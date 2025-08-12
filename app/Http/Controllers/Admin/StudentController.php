<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;

class StudentController extends Controller
{
    /**
     * Display a listing of students
     */
    public function index()
    {
        try {
            $students = Student::with('user')->get()->map(function ($student) {
                return [
                    'id' => $student->id,
                    'name' => $student->user ? $student->user->name : 'N/A',
                    'ic_number' => $student->user ? $student->user->user_code : 'N/A', // Using user_code as IC number
                    'semester' => $student->semester
                ];
            });

            return response()->json($students);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve students',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created student
     */
    public function store(Request $request) 
    { 
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'ic_number' => 'required|string|unique:users,user_code', // Changed from student_id to ic_number
            'semester' => 'required|integer|between:1,8',
        ]);

        // Use database transaction to ensure data consistency
        DB::beginTransaction();
        
        try {
            // Create user account for student first
            $user = User::create([
                'name' => $validated['name'],
                'user_code' => $validated['ic_number'], // Use user_code field for IC number
                'password' => Hash::make($validated['ic_number']), // IC as password
                'role' => 'student'
            ]);

            // Create student record linked to user (no generated student_id)
            $student = Student::create([
                'user_id' => $user->id,
                'semester' => $validated['semester'],
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Student added successfully',
                'data' => [
                    'id' => $student->id,
                    'name' => $user->name,
                    'ic_number' => $user->user_code,
                    'semester' => $student->semester
                ]
            ], 201);

        } catch (Exception $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to create student',
                'error' => $e->getMessage()
            ], 500);
        } 
    }

    /**
     * Display the specified student
     */
    public function show($id)
    {
        try {
            $student = Student::with('user')->findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $student->id,
                    'name' => $student->user->name,
                    'ic_number' => $student->user->user_code,
                    'semester' => $student->semester
                ]
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Student not found'
            ], 404);
        }
    }

    /**
     * Update the specified student
     */
    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'ic_number' => 'required|string|unique:users,user_code,' . $student->user_id,
            'semester' => 'required|integer|between:1,8',
        ]);

        DB::beginTransaction();

        try {
            // Update student record
            $student->update([
                'semester' => $validated['semester']
            ]);

            // Update corresponding user record
            $user = $student->user;
            if ($user) {
                $user->update([
                    'name' => $validated['name'],
                    'user_code' => $validated['ic_number'],
                    'password' => Hash::make($validated['ic_number']) // Update password to new IC
                ]);
            }

            DB::commit();

            return response()->json([
                'message' => 'Student updated successfully',
                'data' => [
                    'id' => $student->id,
                    'name' => $user->name,
                    'ic_number' => $user->user_code,
                    'semester' => $student->semester
                ]
            ]);

        } catch (Exception $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to update student',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified student
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $student = Student::with('user')->findOrFail($id);
            
            // Delete corresponding user record (if exists)
            if ($student->user) {
                $student->user->delete();
            }

            $student->delete();

            DB::commit();

            return response()->json([
                'message' => 'Student deleted successfully'
            ]);

        } catch (Exception $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete student',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Import students via Excel/CSV
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

            // Find header row (first non-empty row)
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

            $required = ['name', 'ic_number', 'semester'];
            foreach ($required as $req) {
                if (!in_array($req, $headers, true)) {
                    return response()->json([
                        'success' => false,
                        'message' => "Missing required column: {$req}. Expected headers: name, ic_number, semester"
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

            // Process each subsequent row
            foreach ($rows as $index => $row) {
                if ($index <= $headerRowIndex) {
                    continue; // skip header and rows before
                }
                $summary['total_rows']++;

                $name = trim((string) ($row[$colByName['name']] ?? ''));
                $ic = trim((string) ($row[$colByName['ic_number']] ?? ''));
                $semesterVal = trim((string) ($row[$colByName['semester']] ?? ''));

                if ($name === '' && $ic === '' && $semesterVal === '') {
                    // blank row -> skip quietly
                    $summary['skipped']++;
                    continue;
                }

                // Basic validation
                if ($name === '' || $ic === '' || $semesterVal === '') {
                    $summary['errors'][] = [
                        'row' => $index,
                        'message' => 'Missing required fields (name, ic_number, semester)'
                    ];
                    continue;
                }

                if (!ctype_digit((string) $semesterVal)) {
                    $summary['errors'][] = [
                        'row' => $index,
                        'message' => 'Semester must be an integer between 1 and 8'
                    ];
                    continue;
                }
                $semester = (int) $semesterVal;
                if ($semester < 1 || $semester > 8) {
                    $summary['errors'][] = [
                        'row' => $index,
                        'message' => 'Semester must be between 1 and 8'
                    ];
                    continue;
                }

                // Duplicate check by user_code
                if (User::where('user_code', $ic)->exists()) {
                    $summary['skipped']++;
                    continue;
                }

                try {
                    DB::transaction(function () use ($name, $ic, $semester, &$summary) {
                        $user = User::create([
                            'name' => $name,
                            'user_code' => $ic,
                            'password' => Hash::make($ic),
                            'role' => 'student'
                        ]);

                        Student::create([
                            'user_id' => $user->id,
                            'semester' => $semester,
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
    // Removed student ID generation; students are identified via linked user and other attributes
}