<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pelatihan;

class PelatihanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pelatihanData = [
            [
                'kode' => 'K3-001',
                'nama_pelatihan' => 'Pelatihan K3 Dasar',
                'kategori' => 'Keselamatan',
                'divisi' => 'Umum',
                'jabatan' => 'Umum',
                'level' => 1,
                'biaya' => 'Rp 1.500.000',
                'durasi' => '2 hari',
                'sertifikat' => 'K3-CERT-001',
                'tenggat_sertifikat' => 3
            ],
            [
                'kode' => 'PLTU-001',
                'nama_pelatihan' => 'Operasi PLTU Dasar',
                'kategori' => 'Operasi',
                'divisi' => 'Operasi',
                'jabatan' => 'Operator',
                'level' => 1,
                'biaya' => 'Rp 2.000.000',
                'durasi' => '3 hari',
                'sertifikat' => 'PLTU-CERT-001',
                'tenggat_sertifikat' => 2
            ],
            [
                'kode' => 'PLTU-002',
                'nama_pelatihan' => 'Operasi PLTU Menengah',
                'kategori' => 'Operasi',
                'divisi' => 'Operasi',
                'jabatan' => 'Teknisi',
                'level' => 2,
                'biaya' => 'Rp 2.500.000',
                'durasi' => '4 hari',
                'sertifikat' => 'PLTU-CERT-002',
                'tenggat_sertifikat' => 2
            ],
            [
                'kode' => 'MAINT-001',
                'nama_pelatihan' => 'Pemeliharaan Preventif',
                'kategori' => 'Pemeliharaan',
                'divisi' => 'Pemeliharaan',
                'jabatan' => 'Teknisi',
                'level' => 2,
                'biaya' => 'Rp 1.800.000',
                'durasi' => '2 hari',
                'sertifikat' => 'MAINT-CERT-001',
                'tenggat_sertifikat' => 1
            ],
            [
                'kode' => 'ENG-001',
                'nama_pelatihan' => 'Analisis Sistem Kelistrikan',
                'kategori' => 'Teknik',
                'divisi' => 'Teknik',
                'jabatan' => 'Engineer',
                'level' => 3,
                'biaya' => 'Rp 3.000.000',
                'durasi' => '5 hari',
                'sertifikat' => 'ENG-CERT-001',
                'tenggat_sertifikat' => 5
            ]
        ];

        foreach ($pelatihanData as $data) {
            Pelatihan::create($data);
        }
    }
}
