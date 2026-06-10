<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeOffRequest extends Model
{
    protected $table = 'time_off_requests';

    protected $fillable = [
        'user_id',
        'start_date',
        'end_date',
        'reason',
        'status',
        'actioned_by',
        'actioned_at',
        'admin_notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'actioned_at' => 'datetime',
    ];

    /**
     * Relationship: The employee requesting time off.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relationship: The manager/admin who approved or denied the request.
     */
    public function manager()
    {
        return $this->belongsTo(User::class, 'actioned_by');
    }

    /**
     * Accessor: Calculate number of days requested.
     */
    public function getDurationDaysAttribute()
    {
        if ($this->start_date && $this->end_date) {
            return $this->start_date->diffInDays($this->end_date) + 1;
        }
        return 0;
    }
}
