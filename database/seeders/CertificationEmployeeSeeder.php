<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\Certification;

class CertificationEmployeeSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Create sample certifications if they don't exist
        $certifications = [
            [
                'code' => 'K3-001',
                'name' => 'K3 Umum'
            ],
            [
                'code' => 'CM-001',
                'name' => 'Certificate of Management'
            ],
            [
                'code' => 'CA-100',
                'name' => 'Certificate of Achievement'
            ],
            [
                'code' => 'ISO-9001',
                'name' => 'ISO 9001 Quality Management'
            ]
        ];

        foreach ($certifications as $certData) {
            Certification::firstOrCreate(
                ['code' => $certData['code']],
                $certData
            );
        }

        // Get all employees and certifications
        $employees = Employee::all();
        $certs = Certification::all();

        // Assign random certifications to employees with sample data
        foreach ($employees as $employee) {
            // Randomly assign 1-3 certifications to each employee
            $randomCerts = $certs->random(rand(1, 3));
            
            foreach ($randomCerts as $cert) {
                // Sample dates for testing different statuses
                $issuedDate = now()->subMonths(rand(6, 24));
                $expirationDate = $issuedDate->copy()->addYears(rand(1, 3));
                
                // Create some expired certificates for testing
                if (rand(1, 3) === 1) {
                    $expirationDate = now()->subDays(rand(1, 90));
                }
                
                // Create some certificates expiring within a month
                if (rand(1, 4) === 1) {
                    $expirationDate = now()->addDays(rand(1, 30));
                }

                $employee->certifications()->attach($cert->id, [
                    'issued_date' => $issuedDate->format('Y-m-d'),
                    'expiration_date' => $expirationDate->format('Y-m-d'),
                    'certificate_image' => null, // You can add sample images later
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
    }
}