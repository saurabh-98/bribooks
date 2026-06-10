<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'author@test.com'],
            [
                'name' => 'Author User',
                'password' => bcrypt('password'),
                'role' => 'author',
            ]
        );

        User::updateOrCreate(
            ['email' => 'reviewer@test.com'],
            [
                'name' => 'Reviewer User',
                'password' => bcrypt('password'),
                'role' => 'reviewer',
            ]
        );

        User::updateOrCreate(
            ['email' => 'admin@test.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]
        );
    }
}