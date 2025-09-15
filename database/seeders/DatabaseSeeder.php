<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Employee;
use App\Models\Certification;
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

        // Seed certifications master (beberapa kode umum)
        $codes = ['K3U', 'CM001', 'CA100', 'ISO9001', 'ITILF', 'PMIACP'];
        foreach ($codes as $code) {
            Certification::query()->updateOrCreate(
                ['code' => $code],
                ['name' => $code]
            );
        }

        // Generate employees
        Employee::factory()->count(30)->create();
        
        // Seed certification-employee relationships with sample data
        $this->call(CertificationEmployeeSeeder::class);
        
        // Seed pelatihan data
        $this->call(PelatihanSeeder::class);
    }
}
