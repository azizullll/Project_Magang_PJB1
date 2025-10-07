<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Division;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $divisions = [
            [
                'name' => 'SDM',
                'code' => 'SDM',
                'description' => 'Divisi Sumber Daya Manusia',
            ],
            [
                'name' => 'Engineering',
                'code' => 'ENG',
                'description' => 'Divisi Engineering',
            ],
            [
                'name' => 'HSE',
                'code' => 'HSE',
                'description' => 'Divisi Health, Safety & Environment',
            ],
            [
                'name' => 'Finance',
                'code' => 'FIN',
                'description' => 'Divisi Finance',
            ],
            [
                'name' => 'Marketing',
                'code' => 'MKT',
                'description' => 'Divisi Marketing',
            ],
            [
                'name' => 'Production',
                'code' => 'PROD',
                'description' => 'Divisi Production',
            ],
            [
                'name' => 'Quality Control',
                'code' => 'QC',
                'description' => 'Divisi Quality Control',
            ],
        ];

        foreach ($divisions as $division) {
            Division::create($division);
        }
    }
}
