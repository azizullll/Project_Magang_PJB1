<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Training;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'nip',
        'nama',
        'email',
        'alamat',
        'no_telp',
        'jabatan',
        'divisi',
        'masa_kerja_tahun',
        'level_kompetensi',
        'foto_path',
    ];

    /**
     * Relasi many-to-many ke Certification (legacy).
     */
    public function certifications(): BelongsToMany
    {
        return $this->belongsToMany(Certification::class, 'certification_employee')
            ->withPivot(['certificate_image', 'expiration_date', 'issued_date'])
            ->withTimestamps();
    }

    /**
     * Relasi many-to-many ke Training untuk sertifikasi.
     */
    public function trainings(): BelongsToMany
    {
        return $this->belongsToMany(Training::class, 'employee_training')
            ->withPivot(['issued_date', 'expiration_date', 'certificate_image'])
            ->withTimestamps();
    }
}


