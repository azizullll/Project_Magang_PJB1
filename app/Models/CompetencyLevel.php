<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CompetencyLevel extends Model
{
    protected $fillable = [
        'level',
        'name',
        'description',
        'min_experience_years',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function jobPositions(): HasMany
    {
        return $this->hasMany(JobPosition::class, 'competency_level', 'level');
    }

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class, 'level_kompetensi', 'name');
    }
}
