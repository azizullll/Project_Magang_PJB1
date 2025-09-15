<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelatihan extends Model
{
    protected $table = 'pelatihan';
    
    protected $fillable = [
        'bidang',
        'kode',
        'judul',
        'kompetensi_inti',
        'kompetensi_pilihan',
        'level',
    ];
}
