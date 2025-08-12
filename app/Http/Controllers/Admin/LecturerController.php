<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lecturer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;

class LecturerController extends Controller
{
    /**
     * Display a listing of lecturers
     */
    public function index()
    {
        try {
            $lecturers = Lecturer::with('user')->get()->map(function ($lecturer) {
                return [
                    'id' => $lecturer->id,
                    'name' => $lecturer->user ? $lecturer->user->name : 'N/A',
                    'ic_number' => $lecturer->user ? $lecturer->user->user_code : 'N/A',
                    'salary_number' => $lecturer->salary_number
                ];
            });

            return response()->json($lecturers);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve lecturers',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created lecturer
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'ic_number' => 'required|string|unique:users,user_code',
            'salary_number' => 'required|string|unique:lecturers,salary_number',
        ]);

        DB::beginTransaction();
        
        try {
            // Create user account for lecturer
            $user = User::create([
                'name' => $validated['name'],
                'user_code' => $validated['ic_number'],
                'password' => Hash::make($validated['ic_number']),
                'role' => 'lecturer'
            ]);

            // Create lecturer record
            $lecturer = Lecturer::create([
                'user_id' => $user->id,
                'salary_number' => $validated['salary_number'],
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Lecturer added successfully',
                'data' => [
                    'id' => $lecturer->id,
                    'name' => $user->name,
                    'ic_number' => $user->user_code,
                    'salary_number' => $lecturer->salary_number
                ]
            ], 201);

        } catch (Exception $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to create lecturer',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified lecturer
     */
    public function show($id)
    {
        try {
            $lecturer = Lecturer::with('user')->findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $lecturer->id,
                    'name' => $lecturer->user->name,
                    'ic_number' => $lecturer->user->user_code,
                    'salary_number' => $lecturer->salary_number
                ]
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lecturer not found'
            ], 404);
        }
    }

    /**
     * Update the specified lecturer
     */
    public function update(Request $request, $id)
    {
        $lecturer = Lecturer::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'ic_number' => 'required|string|unique:users,user_code,' . $lecturer->user_id,
            'salary_number' => 'required|string|unique:lecturers,salary_number,' . $id,
        ]);

        DB::beginTransaction();

        try {
            // Update lecturer record
            $lecturer->update([
                'salary_number' => $validated['salary_number']
            ]);

            // Update corresponding user record
            $user = $lecturer->user;
            if ($user) {
                $user->update([
                    'name' => $validated['name'],
                    'user_code' => $validated['ic_number'],
                    'password' => Hash::make($validated['ic_number'])
                ]);
            }

            DB::commit();

            return response()->json([
                'message' => 'Lecturer updated successfully',
                'data' => [
                    'id' => $lecturer->id,
                    'name' => $user->name,
                    'ic_number' => $user->user_code,
                    'salary_number' => $lecturer->salary_number
                ]
            ]);

        } catch (Exception $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to update lecturer',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified lecturer
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $lecturer = Lecturer::with('user')->findOrFail($id);
            
            // Delete corresponding user record
            if ($lecturer->user) {
                $lecturer->user->delete();
            }

            $lecturer->delete();

            DB::commit();

            return response()->json([
                'message' => 'Lecturer deleted successfully'
            ]);

        } catch (Exception $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete lecturer',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Import lecturers via Excel/CSV
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:10240',
        ]);

        $file = $request->file('file');

        try {
            $spreadsheet = IOFactory::load($file->getPathname());
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray(null, true, true, true);

            if (count($rows) === 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'The uploaded file is empty.'
                ], 422);
            }

            // Find header row
            $headerRowIndex = null;
            foreach ($rows as $index => $row) {
                $values = array_filter(array_map('trim', array_values($row)), fn($v) => $v !== null && $v !== '');
                if (!empty($values)) {
                    $headerRowIndex = $index;
                    break;
                }
            }

            if ($headerRowIndex === null) {
                return response()->json(['success' => false, 'message' => 'No header row found in the file.'], 422);
            }

            $rawHeaders = $rows[$headerRowIndex];
            $headers = [];
            foreach ($rawHeaders as $key => $val) {
                $headers[$key] = strtolower(trim((string) $val));
            }

            $required = ['name', 'ic_number', 'salary_number'];
            foreach ($required as $req) {
                if (!in_array($req, $headers, true)) {
                    return response()->json([
                        'success' => false,
                        'message' => "Missing required column: {$req}. Expected headers: name, ic_number, salary_number"
                    ], 422);
                }
            }

            // Map header name -> column key
            $colByName = [];
            foreach ($headers as $colKey => $name) {
                $colByName[$name] = $colKey;
            }

            $summary = [
                'total_rows' => 0,
                'created' => 0,
                'skipped' => 0,
                'errors' => [],
            ];

            foreach ($rows as $index => $row) {
                if ($index <= $headerRowIndex) continue;
                $summary['total_rows']++;

                $name = trim((string) ($row[$colByName['name']] ?? ''));
                $ic = trim((string) ($row[$colByName['ic_number']] ?? ''));
                $salary = trim((string) ($row[$colByName['salary_number']] ?? ''));

                if ($name === '' && $ic === '' && $salary === '') {
                    $summary['skipped']++;
                    continue;
                }

                if ($name === '' || $ic === '' || $salary === '') {
                    $summary['errors'][] = [
                        'row' => $index,
                        'message' => 'Missing required fields (name, ic_number, salary_number)'
                    ];
                    continue;
                }

                // Duplicate by user_code or salary_number
                if (User::where('user_code', $ic)->exists() || \App\Models\Lecturer::where('salary_number', $salary)->exists()) {
                    $summary['skipped']++;
                    continue;
                }

                try {
                    DB::transaction(function () use ($name, $ic, $salary) {
                        $user = User::create([
                            'name' => $name,
                            'user_code' => $ic,
                            'password' => Hash::make($ic),
                            'role' => 'lecturer'
                        ]);

                        Lecturer::create([
                            'user_id' => $user->id,
                            'salary_number' => $salary,
                        ]);
                    });
                    $summary['created']++;
                } catch (Exception $e) {
                    $summary['errors'][] = [
                        'row' => $index,
                        'message' => $e->getMessage()
                    ];
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Import completed',
                'summary' => $summary
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to process file',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Template download removed per request
}