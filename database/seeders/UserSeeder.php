<?php

namespace Database\Seeders;

use App\Enums\Course;
use App\Enums\Role;
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
                'course' => Course::ComputerScience,
                'enrollment_number' => 215115522,
                'role' => Role::Requester,
                'type' => 'STUDENT',
                'remember_token' => Str::random(10),
                'created_at' => now(),
            ],
        ]);
    }
}
