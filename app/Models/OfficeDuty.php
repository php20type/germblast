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

    /**
     * Dynamically determine if the task is completed for the current period based on frequency.
     */
    public function getIsCompletedAttribute()
    {
        $now = now();
        $completions = $this->completions();

        switch (strtolower($this->frequency)) {
            case 'daily':
                return $completions->where('completed_at', '>=', $now->copy()->startOfDay())->exists();
            case 'weekly':
                return $completions->where('completed_at', '>=', $now->copy()->startOfWeek())->exists();
            case 'monthly':
                return $completions->where('completed_at', '>=', $now->copy()->startOfMonth())->exists();
            case 'as needed':
            case 'one-off':
            default:
                // For a one-off task, if it has any completion record, it's complete.
                return $completions->exists();
        }
    }
}
