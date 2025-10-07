<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Training;
use App\Models\Division;
use App\Models\JobPosition;

class TrainingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $trainings = [
            // K3 Trainings
            [
                'code' => 'K3-001',
                'name' => 'K3 Umum',
                'category' => 'K3',
                'relevant_divisions' => [1, 2, 3, 4, 5, 6, 7], // All divisions
                'relevant_job_positions' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18], // All positions
                'level' => 2,
                'cost' => 1500000,
                'duration_days' => 2,
                'duration_hours' => 16,
                'institution' => 'BNSP',
                'certification_code' => 'K3-CERT-001',
                'competencies_gained' => 'Pengetahuan dasar K3, identifikasi bahaya, penggunaan APD',
                'next_competencies' => 'K3 Level 3, Ahli K3 Umum, Manajer K3',
                'description' => 'Pelatihan dasar K3 untuk semua karyawan',
            ],
            [
                'code' => 'K3-002',
                'name' => 'Ahli K3 Umum',
                'category' => 'K3',
                'relevant_divisions' => [1, 2, 3, 4, 5, 6, 7],
                'relevant_job_positions' => [3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18],
                'level' => 4,
                'cost' => 5000000,
                'duration_days' => 5,
                'duration_hours' => 40,
                'institution' => 'Kemenaker RI',
                'certification_code' => 'K3-CERT-002',
                'competencies_gained' => 'Ahli K3, audit K3, investigasi kecelakaan, manajemen risiko',
                'next_competencies' => 'Manajer K3, Auditor K3, Konsultan K3',
                'description' => 'Pelatihan untuk menjadi Ahli K3 Umum',
            ],
            
            // Engineering Trainings
            [
                'code' => 'ENG-001',
                'name' => 'Project Management Professional',
                'category' => 'Teknis',
                'relevant_divisions' => [2, 6], // Engineering, Production
                'relevant_job_positions' => [4, 6, 12, 13, 14, 15, 16, 17, 18],
                'level' => 5,
                'cost' => 8000000,
                'duration_days' => 5,
                'duration_hours' => 40,
                'institution' => 'PMI Indonesia',
                'certification_code' => 'PMP-CERT-001',
                'competencies_gained' => 'Manajemen proyek, perencanaan, monitoring, controlling',
                'next_competencies' => 'Senior Project Manager, Program Manager',
                'description' => 'Sertifikasi Project Management Professional',
            ],
            [
                'code' => 'ENG-002',
                'name' => 'Safety Engineering',
                'category' => 'Teknis',
                'relevant_divisions' => [2, 3, 6, 7],
                'relevant_job_positions' => [5, 7, 8, 12, 13, 14, 15, 16, 17, 18],
                'level' => 4,
                'cost' => 3000000,
                'duration_days' => 3,
                'duration_hours' => 24,
                'institution' => 'IATKI',
                'certification_code' => 'SE-CERT-001',
                'competencies_gained' => 'Safety engineering, risk assessment, safety design',
                'next_competencies' => 'Senior Safety Engineer, Safety Manager',
                'description' => 'Pelatihan Safety Engineering untuk engineer',
            ],
            
            // Management Trainings
            [
                'code' => 'MGT-001',
                'name' => 'Leadership Development',
                'category' => 'Manajerial',
                'relevant_divisions' => [1, 2, 3, 4, 5, 6, 7],
                'relevant_job_positions' => [2, 4, 6, 8, 10, 12, 14, 16, 18],
                'level' => 6,
                'cost' => 4000000,
                'duration_days' => 3,
                'duration_hours' => 24,
                'institution' => 'Internal Training',
                'certification_code' => 'LD-CERT-001',
                'competencies_gained' => 'Kepemimpinan, komunikasi, decision making, team building',
                'next_competencies' => 'Executive Leadership, Strategic Management',
                'description' => 'Pengembangan kepemimpinan untuk manajer',
            ],
            [
                'code' => 'MGT-002',
                'name' => 'Strategic Management',
                'category' => 'Manajerial',
                'relevant_divisions' => [1, 2, 3, 4, 5, 6, 7],
                'relevant_job_positions' => [2, 4, 6, 8, 10, 12, 14, 16, 18],
                'level' => 7,
                'cost' => 6000000,
                'duration_days' => 4,
                'duration_hours' => 32,
                'institution' => 'External Consultant',
                'certification_code' => 'SM-CERT-001',
                'competencies_gained' => 'Strategic planning, business analysis, competitive advantage',
                'next_competencies' => 'Executive MBA, Board Leadership',
                'description' => 'Manajemen strategis untuk senior manager',
            ],
            
            // Softskill Trainings
            [
                'code' => 'SS-001',
                'name' => 'Communication Skills',
                'category' => 'Softskill',
                'relevant_divisions' => [1, 2, 3, 4, 5, 6, 7],
                'relevant_job_positions' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18],
                'level' => 2,
                'cost' => 1000000,
                'duration_days' => 2,
                'duration_hours' => 16,
                'institution' => 'Internal Training',
                'certification_code' => 'CS-CERT-001',
                'competencies_gained' => 'Presentasi, negosiasi, public speaking, interpersonal skills',
                'next_competencies' => 'Advanced Communication, Media Training',
                'description' => 'Pengembangan keterampilan komunikasi',
            ],
            [
                'code' => 'SS-002',
                'name' => 'Time Management',
                'category' => 'Softskill',
                'relevant_divisions' => [1, 2, 3, 4, 5, 6, 7],
                'relevant_job_positions' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18],
                'level' => 1,
                'cost' => 500000,
                'duration_days' => 1,
                'duration_hours' => 8,
                'institution' => 'Internal Training',
                'certification_code' => 'TM-CERT-001',
                'competencies_gained' => 'Prioritization, planning, delegation, productivity',
                'next_competencies' => 'Project Management, Leadership',
                'description' => 'Manajemen waktu dan produktivitas',
            ],
        ];

        foreach ($trainings as $training) {
            Training::create($training);
        }
    }
}
