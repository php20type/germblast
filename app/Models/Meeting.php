<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
     protected $fillable = [
        'user_id',
        'activity_type_id',
        'name',
        'meeting_type',
        'duration',
        'date',
        'start_time',
        'end_time',
        'location',
        'description',
        'status',
    ];

     public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function activityType()
    {
           return $this->belongsTo(ActivityType::class, 'activity_type_id');
    }

    public function zoom()
    {
        return $this->hasOne(ZoomMeeting::class, 'meeting_id');
    }

     public function mentionedUsers()
    {
        return $this->belongsToMany(User::class,'meeting_users','meeting_id','user_id')->withTimestamps();
    }
}
