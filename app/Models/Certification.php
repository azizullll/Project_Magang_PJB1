<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Certification extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'bidang',
        'judul',
        'kompetensi_inti',
        'kompetensi_pilihan',
        'level',
    ];

    /**
     * Relasi many-to-many ke Employee.
     */
    public function employees(): BelongsToMany
    {
        return $this->belongsToMany(Employee::class, 'certification_employee')
            ->withPivot(['certificate_image', 'expiration_date', 'issued_date'])
            ->withTimestamps();
    }
}


