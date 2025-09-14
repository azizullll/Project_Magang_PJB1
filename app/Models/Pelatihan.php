<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelatihan extends Model
{
    use HasFactory;

    protected $table = 'pelatihan';

    protected $fillable = [
        'kode',
        'nama_pelatihan',
        'kategori',
        'divisi',
        'jabatan',
        'level',
        'biaya',
        'durasi',
        'sertifikat'
    ];

    protected $casts = [
        'level' => 'integer',
    ];
}
