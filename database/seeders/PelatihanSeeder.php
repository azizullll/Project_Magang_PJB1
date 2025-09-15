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
                'bidang' => 'Proyek',
                'kode' => 'CM001',
                'judul' => 'Membantu pelaksanaan perencanaan pembangkit tenaga listrik-',
                'kompetensi_inti' => 'Membantu pelaksanaan perencanaan pembangkit tenaga listrik',
                'kompetensi_pilihan' => '',
                'level' => 1,
            ],
            [
                'bidang' => 'Proyek',
                'kode' => 'CM006',
                'judul' => 'Menetapkan Perencanaan Pembangkit Tenaga Listrik-',
                'kompetensi_inti' => 'Menetapkan Perencanaan Pembangkit Tenaga Listrik',
                'kompetensi_pilihan' => '',
                'level' => 5,
            ],
            [
                'bidang' => 'Proyek',
                'kode' => 'CMH02',
                'judul' => 'TAP RNC PTL-RNC DSG INST SI mekanik PLTS & alat bantunya',
                'kompetensi_inti' => 'Menetapkan Perencanaan Pembangkit Tenaga Listrik',
                'kompetensi_pilihan' => 'Merencanakan desain instalasi sistem mekanik PLTS dan alat bantunya',
                'level' => 5,
            ],
            [
                'bidang' => 'Proyek',
                'kode' => 'CMH01',
                'judul' => 'TAP RNC PTL-RNC DSG INST SI turbin bayu & alat bantunya',
                'kompetensi_inti' => 'Menetapkan Perencanaan Pembangkit Tenaga Listrik',
                'kompetensi_pilihan' => 'Merencanakan desain instalasi sistem turbin bayu dan alat bantunya',
                'level' => 5,
            ],
            [
                'bidang' => 'Proyek',
                'kode' => 'CMH03',
                'judul' => 'TAP RNC PTL-RNC DSG SI kelistrikan PLTS & alat bantunya',
                'kompetensi_inti' => 'Menetapkan Perencanaan Pembangkit Tenaga Listrik',
                'kompetensi_pilihan' => 'Merencanakan desain sistem kelistrikan PLTS dan alat bantunya',
                'level' => 5,
            ],
            [
                'bidang' => 'Proyek',
                'kode' => 'CM007',
                'judul' => 'Mengelola Pelaksanaan Perencanaan Pembangkit Tenaga Listrik-',
                'kompetensi_inti' => 'Mengelola Pelaksanaan Perencanaan Pembangkit Tenaga Listrik',
                'kompetensi_pilihan' => '',
                'level' => 6,
            ],
        ];

        foreach ($pelatihanData as $data) {
            // Idempotent seeding based on unique 'kode'
            Pelatihan::updateOrCreate(
                ['kode' => $data['kode']],
                $data
            );
        }
    }
}
