<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfficeDuty extends Model
{
    protected $table = 'office_duties';

    protected $fillable = [
        'title',
        'description',
        'frequency',
        'last_performed_by',
        'last_performed_on',
        'notes'
    ];

    /**
     * Get the completions for this duty.
     */
    public function completions()
    {
        return $this->hasMany(OfficeDutyCompletion::class, 'office_duty_id');
    }

    /**
     * Get the user who last performed this duty.
     */
    public function lastPerformedBy()
    {
        return $this->belongsTo(User::class, 'last_performed_by');
    }
}
