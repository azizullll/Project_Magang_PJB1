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
                'tenggat_sertifikat' => 3,
                'kompetensi_inti' => '• Memahami dasar-dasar keselamatan dan kesehatan kerja
• Mengidentifikasi potensi bahaya di tempat kerja
• Menerapkan prosedur keselamatan standar
• Menggunakan alat pelindung diri (APD) dengan benar
• Melakukan evakuasi darurat',
                'kompetensi_pilihan' => '• Analisis risiko keselamatan
• Investigasi kecelakaan kerja
• Pengembangan program K3
• Audit keselamatan internal
• Pelatihan K3 untuk tim'
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
                'tenggat_sertifikat' => 2,
                'kompetensi_inti' => '• Memahami prinsip dasar operasi PLTU
• Mengoperasikan sistem boiler dan turbin
• Monitoring parameter operasi
• Melakukan prosedur start-up dan shut-down
• Mengidentifikasi abnormalitas operasi',
                'kompetensi_pilihan' => '• Optimasi efisiensi PLTU
• Troubleshooting sistem
• Perawatan rutin peralatan
• Analisis performa unit
• Koordinasi dengan tim maintenance'
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
                'tenggat_sertifikat' => 2,
                'kompetensi_inti' => '• Analisis sistem kontrol PLTU
• Optimasi parameter operasi
• Troubleshooting lanjutan
• Koordinasi operasi multi-unit
• Manajemen bahan bakar dan air',
                'kompetensi_pilihan' => '• Pengembangan prosedur operasi
• Training operator junior
• Analisis data historis
• Implementasi sistem monitoring
• Evaluasi performa jangka panjang'
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
                'tenggat_sertifikat' => 1,
                'kompetensi_inti' => '• Merencanakan jadwal pemeliharaan
• Melakukan inspeksi visual dan fungsional
• Mengganti komponen yang aus
• Dokumentasi hasil pemeliharaan
• Koordinasi dengan operasi',
                'kompetensi_pilihan' => '• Analisis kegagalan komponen
• Optimasi interval pemeliharaan
• Pengembangan checklist inspeksi
• Manajemen spare parts
• Pelatihan teknik pemeliharaan'
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
                'tenggat_sertifikat' => 5,
                'kompetensi_inti' => '• Analisis sistem tenaga listrik
• Perhitungan arus hubung singkat
• Desain proteksi sistem
• Evaluasi stabilitas sistem
• Koordinasi proteksi',
                'kompetensi_pilihan' => '• Simulasi sistem kelistrikan
• Pengembangan model sistem
• Analisis harmonisa
• Optimasi konfigurasi sistem
• Riset dan pengembangan teknologi'
            ]
        ];

        foreach ($pelatihanData as $data) {
            Pelatihan::create($data);
        }
    }
}
