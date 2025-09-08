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
        // Seed dummy admin users
        User::query()->updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'username' => 'admin',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'status' => 'active',
            ]
        );

        User::query()->updateOrCreate(
            ['email' => 'azizul@gmail.com'],
            [
                'username' => 'azizul',
                'password' => Hash::make('azizul123'),
                'role' => 'admin',
                'status' => 'active',
            ]
        );
    }
}
