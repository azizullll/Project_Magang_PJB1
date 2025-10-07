<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CompetencyLevel;

class CompetencyLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $levels = [
            [
                'level' => 1,
                'name' => 'Pemula',
                'description' => 'Level dasar untuk karyawan baru',
                'min_experience_years' => 0,
            ],
            [
                'level' => 2,
                'name' => 'Operator',
                'description' => 'Level operator dengan kemampuan dasar',
                'min_experience_years' => 1,
            ],
            [
                'level' => 3,
                'name' => 'Terampil',
                'description' => 'Level terampil dengan pengalaman 3+ tahun',
                'min_experience_years' => 3,
            ],
            [
                'level' => 4,
                'name' => 'Ahli Muda',
                'description' => 'Level ahli muda dengan pengalaman 6+ tahun',
                'min_experience_years' => 6,
            ],
            [
                'level' => 5,
                'name' => 'Supervisor',
                'description' => 'Level supervisor dengan kemampuan kepemimpinan',
                'min_experience_years' => 8,
            ],
            [
                'level' => 6,
                'name' => 'Ahli Madya',
                'description' => 'Level ahli madya dengan pengalaman 10+ tahun',
                'min_experience_years' => 10,
            ],
            [
                'level' => 7,
                'name' => 'Manager',
                'description' => 'Level manager dengan kemampuan manajerial',
                'min_experience_years' => 12,
            ],
        ];

        foreach ($levels as $level) {
            CompetencyLevel::create($level);
        }
    }
}
