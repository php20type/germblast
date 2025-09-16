<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable=[
        'activity_type_id',
        'title',
        'date',
        'start_time',
        'end_time',
        'all_day',
        'location',
        'participant_id',
        'agenda',
    ];

    public function activity_type()
    {
        return $this->belongsTo(ActivityType::class, 'activity_type_id');
    }
    public function people()
    {
        return $this->belongsToMany(People::class,'participant_id');
    }
}
