<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ZoomMeeting extends Model
{
     protected $fillable = [
        'meeting_id',
        'zoom_meeting_id',
        'uuid',
        'host_id',
        'host_email',
        'topic',
        'status',
        'start_time',
        'end_time',
        'duration',
        'date',
        'timezone',
        'agenda',
        'start_url',
        'join_url',
        'password',
        'encrypted_password',
        'response',
    ];

    public function meeting()
    {
        return $this->belongsTo(Meeting::class,'meeting_id');
    }

}
