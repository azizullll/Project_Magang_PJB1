<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Certification;
use App\Models\Pelatihan;

class UpdateCertificationsWithPelatihanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua data pelatihan
        $pelatihanData = Pelatihan::all();
        
        foreach ($pelatihanData as $pelatihan) {
            // Update atau create certification berdasarkan kode pelatihan
            Certification::updateOrCreate(
                ['code' => $pelatihan->kode],
                [
                    'name' => $pelatihan->judul,
                    'bidang' => $pelatihan->bidang,
                    'judul' => $pelatihan->judul,
                    'kompetensi_inti' => $pelatihan->kompetensi_inti,
                    'kompetensi_pilihan' => $pelatihan->kompetensi_pilihan,
                    'level' => $pelatihan->level,
                ]
            );
        }
    }
}
