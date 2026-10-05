<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NominationCycle extends Model
{
    protected $fillable = [
        'category',
        'title',
        'start_date',
        'end_date',
        'is_active',
        'created_by',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function nominations()
    {
        return $this->hasMany(Nomination::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
