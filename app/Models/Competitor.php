<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Competitor extends Model
{
    protected $fillable = [
        'name',
    ];

    // Lead Competitor pivot table
    public function leadCompetitors()
    {
        return $this->hasMany(LeadCompetitor::class, 'competitor_id');
    }
    public function leads()
    {
        return $this->belongsToMany(Lead::class, 'lead_competitors')
            ->withTimestamps();
    }


}
