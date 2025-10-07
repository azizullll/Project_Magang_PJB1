<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JobPosition;
use App\Models\Division;

class JobPositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positions = [
            // SDM Division
            [
                'name' => 'Staf HRD',
                'code' => 'SDM-001',
                'division_name' => 'SDM',
                'competency_level' => 2,
                'description' => 'Staf Human Resources Development',
            ],
            [
                'name' => 'Manager HRD',
                'code' => 'SDM-002',
                'division_name' => 'SDM',
                'competency_level' => 7,
                'description' => 'Manager Human Resources Development',
            ],
            
            // Engineering Division
            [
                'name' => 'Teknisi',
                'code' => 'ENG-001',
                'division_name' => 'Engineering',
                'competency_level' => 2,
                'description' => 'Teknisi Engineering',
            ],
            [
                'name' => 'Project Manager',
                'code' => 'ENG-002',
                'division_name' => 'Engineering',
                'competency_level' => 7,
                'description' => 'Project Manager Engineering',
            ],
            [
                'name' => 'Safety Engineer',
                'code' => 'ENG-003',
                'division_name' => 'Engineering',
                'competency_level' => 4,
                'description' => 'Safety Engineer',
            ],
            [
                'name' => 'Manager Engineer',
                'code' => 'ENG-004',
                'division_name' => 'Engineering',
                'competency_level' => 7,
                'description' => 'Manager Engineering',
            ],
            
            // HSE Division
            [
                'name' => 'HSE Officer',
                'code' => 'HSE-001',
                'division_name' => 'HSE',
                'competency_level' => 4,
                'description' => 'Health Safety Environment Officer',
            ],
            [
                'name' => 'Manajer K3',
                'code' => 'HSE-002',
                'division_name' => 'HSE',
                'competency_level' => 7,
                'description' => 'Manajer Kesehatan dan Keselamatan Kerja',
            ],
            
            // Finance Division
            [
                'name' => 'Staf Finance',
                'code' => 'FIN-001',
                'division_name' => 'Finance',
                'competency_level' => 2,
                'description' => 'Staf Finance',
            ],
            [
                'name' => 'Manager Finance',
                'code' => 'FIN-002',
                'division_name' => 'Finance',
                'competency_level' => 7,
                'description' => 'Manager Finance',
            ],
            
            // Marketing Division
            [
                'name' => 'Staf Marketing',
                'code' => 'MKT-001',
                'division_name' => 'Marketing',
                'competency_level' => 2,
                'description' => 'Staf Marketing',
            ],
            [
                'name' => 'Manager Marketing',
                'code' => 'MKT-002',
                'division_name' => 'Marketing',
                'competency_level' => 7,
                'description' => 'Manager Marketing',
            ],
            
            // Production Division
            [
                'name' => 'Operator',
                'code' => 'PROD-001',
                'division_name' => 'Production',
                'competency_level' => 2,
                'description' => 'Operator Produksi',
            ],
            [
                'name' => 'Supervisor Produksi',
                'code' => 'PROD-002',
                'division_name' => 'Production',
                'competency_level' => 5,
                'description' => 'Supervisor Produksi',
            ],
            [
                'name' => 'Manager Produksi',
                'code' => 'PROD-003',
                'division_name' => 'Production',
                'competency_level' => 7,
                'description' => 'Manager Produksi',
            ],
            
            // Quality Control Division
            [
                'name' => 'QC Inspector',
                'code' => 'QC-001',
                'division_name' => 'Quality Control',
                'competency_level' => 2,
                'description' => 'Quality Control Inspector',
            ],
            [
                'name' => 'Manager QC',
                'code' => 'QC-002',
                'division_name' => 'Quality Control',
                'competency_level' => 7,
                'description' => 'Manager Quality Control',
            ],
        ];

        foreach ($positions as $position) {
            $division = Division::where('name', $position['division_name'])->first();
            if ($division) {
                JobPosition::create([
                    'name' => $position['name'],
                    'code' => $position['code'],
                    'division_id' => $division->id,
                    'competency_level' => $position['competency_level'],
                    'description' => $position['description'],
                ]);
            }
        }
    }
}
