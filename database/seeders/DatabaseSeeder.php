<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Super Admin
        User::create([
            'name' => 'Super Admin',
            'user_code' => '2302132',
            'password' => Hash::make('2302132'),
            'role' => 'super_admin',
        ]);

        // Create Lecturer
        User::create([
            'name' => 'Dr. John Doe',
            'user_code' => '0122650043',
            'password' => Hash::make('0122650043'),
            'role' => 'lecturer',
        ]);

        // Create Student
        User::create([
            'name' => 'Student One',
            'user_code' => '050221030621',
            'password' => Hash::make('050221030621'),
            'role' => 'student',
        ]);
    }
    public function username()
    {
        return 'user_code';
    }
}
