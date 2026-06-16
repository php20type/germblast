<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfficeDutyCompletion extends Model
{
    protected $table = 'office_duty_completions';

    protected $fillable = [
        'office_duty_id',
        'user_id',
        'notes',
        'completed_at'
    ];

    protected $casts = [
        'completed_at' => 'datetime'
    ];

    /**
     * Get the duty that was completed.
     */
    public function duty()
    {
        return $this->belongsTo(OfficeDuty::class, 'office_duty_id');
    }

    /**
     * Get the user who completed the duty.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
