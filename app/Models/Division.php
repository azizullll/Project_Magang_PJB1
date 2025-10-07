<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Division extends Model
{
    protected $fillable = [
        'name',
        'code',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function jobPositions(): HasMany
    {
        return $this->hasMany(JobPosition::class);
    }

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class, 'divisi', 'name');
    }
}
