<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController; 
use App\Http\Controllers\StudentController;

// Main page
Route::get('/', function () {
    return view('welcome');
});

// Routes
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);

// Protected routes
Route::middleware(['auth'])->group(function () {
    // Logout route
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth');

    // Student routes
    Route::get('/student/page', function () {
        return view('student.page');
    })->name('student.page')->middleware('role:student');

    // Lecturer routes
    Route::get('/lecturer/page', function () {
        return view('lecturer.page');
    })->name('lecturer.page')->middleware('role:lecturer');

    // Super Admin routes
    Route::get('/admin/page', function () {
        return view('admin.page');
    })->name('admin.page')->middleware('role:super_admin');

    // Admin API routes
    Route::middleware(['auth', 'role:super_admin'])->prefix('admin')->group(function () {
        // Student management routes
        Route::get('/students', [App\Http\Controllers\Admin\StudentController::class, 'index']);
        Route::post('/students', [App\Http\Controllers\Admin\StudentController::class, 'store']);
        Route::get('/students/{id}', [App\Http\Controllers\Admin\StudentController::class, 'show']);
        Route::put('/students/{id}', [App\Http\Controllers\Admin\StudentController::class, 'update']);
        Route::delete('/students/{id}', [App\Http\Controllers\Admin\StudentController::class, 'destroy']);
        Route::post('/students/import', [App\Http\Controllers\Admin\StudentController::class, 'import']);
        
        // Lecturer management routes
        Route::get('/lecturers', [App\Http\Controllers\Admin\LecturerController::class, 'index']);
        Route::post('/lecturers', [App\Http\Controllers\Admin\LecturerController::class, 'store']);
        Route::get('/lecturers/{id}', [App\Http\Controllers\Admin\LecturerController::class, 'show']);
        Route::put('/lecturers/{id}', [App\Http\Controllers\Admin\LecturerController::class, 'update']);
        Route::delete('/lecturers/{id}', [App\Http\Controllers\Admin\LecturerController::class, 'destroy']);
        Route::post('/lecturers/import', [App\Http\Controllers\Admin\LecturerController::class, 'import']);
    });
});