<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelatihan extends Model
{
    use HasFactory;

    protected $table = 'pelatihan';

    // Fields aligned with database/migrations/2025_09_15_030855_create_pelatihan_table.php
    protected $fillable = [
        'bidang',
        'kode',
        'judul',
        'kompetensi_inti',
        'kompetensi_pilihan',
        'level',
        'tenggat_sertifikat',
    ];
}
