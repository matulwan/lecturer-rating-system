<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function __construct()
    {
        // 
    }

    public function showLoginForm(Request $request)
    {
        if (Auth::check()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'user_code' => ['required', 'string'],  // Changed from 'id'
            'password' => ['required', 'string'],
        ]);

        // Use the validated credentials directly
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            return match ($user->role) {
                'student' => redirect()->route('student.page'),
                'lecturer' => redirect()->route('lecturer.page'),
                'super_admin' => redirect()->route('admin.page'),
                default => redirect()->route('login')
            };
        }

        throw ValidationException::withMessages([
            'user_code' => ['The provided credentials do not match our records.'],
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login');
    }
}