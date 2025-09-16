<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    protected $fillable = [
        'name',
        'channel_id',
    ];

    // Lead Sources pivot table
    public function leadSources()
    {
        return $this->hasMany(LeadSource::class, 'source_id');
    }
    public function leads()
    {
        return $this->belongsToMany(Lead::class, 'lead_sources')
            ->withTimestamps();
    }


    public function channel()
    {
        return $this->belongsTo(Channel::class, 'channel_id');
    }


}
