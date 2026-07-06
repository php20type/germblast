<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobClockAuditLog extends Model
{
    protected $fillable = [
        'slot_clock_id',
        'action',
        'old_type',
        'new_type',
        'old_clocked_in_at',
        'new_clocked_in_at',
        'old_clocked_out_at',
        'new_clocked_out_at',
        'user_id'
    ];

    public function clock()
    {
        return $this->belongsTo(ServiceOrderSlotClock::class, 'slot_clock_id')->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
