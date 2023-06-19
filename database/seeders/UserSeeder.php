<?php

namespace Database\Seeders;

use App\Enums\UserCourse;
use App\Enums\UserRole;
use App\Enums\UserType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Mateus Machado',
                'email' => 'mateus.machado@ufba.br',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'course' => UserCourse::ComputerScience,
                'enrollment_number' => 215115522,
                'role' => UserRole::Requester->value,
                'type' => UserType::Student->value,
                'remember_token' => Str::random(10),
                'created_at' => now(),
            ],
            [
                'name' => 'Mateus Machado',
                'email' => 'mbmachado@outlook.com',
                'email_verified_at' => now(),
                'password' => Hash::make('flK088#2!@#12k*&'),
                'course' => UserCourse::ComputerScience,
                'enrollment_number' => 215115522,
                'role' => UserRole::Admin->value,
                'type' => UserType::Committee->value,
                'remember_token' => Str::random(10),
                'created_at' => now(),
            ],
        ]);
    }
}
