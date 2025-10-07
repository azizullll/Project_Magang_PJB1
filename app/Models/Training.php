<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Training extends Model
{
    protected $fillable = [
        'code',
        'name',
        'category',
        'relevant_divisions',
        'relevant_job_positions',
        'level',
        'cost',
        'duration_days',
        'certificate_active_years',
        'institution',
        'institution_phone',
        'institution_email',
        'institution_address',
        'certification_code',
        'competencies_gained',
        'next_competencies',
        'description',
        'is_active',
    ];

    protected $casts = [
        'relevant_divisions' => 'array',
        'relevant_job_positions' => 'array',
        'cost' => 'decimal:2',
        'certificate_active_years' => 'integer',
        'is_active' => 'boolean',
    ];

    public function divisions()
    {
        return Division::whereIn('id', $this->relevant_divisions ?? []);
    }

    public function jobPositions()
    {
        return JobPosition::whereIn('id', $this->relevant_job_positions ?? []);
    }

    public function certifications(): BelongsToMany
    {
        return $this->belongsToMany(Certification::class, 'training_certifications')
            ->withTimestamps();
    }
}
