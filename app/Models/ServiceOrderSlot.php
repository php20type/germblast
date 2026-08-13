<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceOrderSlot extends Model
{
     protected $table = 'service_order_slots';

    protected $fillable = [
        'service_order_id',
        'scheduled_start_time',
        'scheduled_end_time',
        'scheduled_arrival_time',
        'scheduled_office',
        'scheduled_recurrence_count',
        'scheduled_recurrence_rule',
        'scheduled_hours',
        'meet',
        'overnight',

        'confirmed_by',
        'is_confirmed',
        'confirmed_at',
        'confirmation_notes',
        'status',
        'is_audit',
        'is_audit_finalized',
    ];

    protected $casts = [
        'scheduled_start_time' => 'datetime',
        'scheduled_end_time'   => 'datetime',
    ];

    public function getClockedInAtAttribute()
    {
        $firstClock = $this->clocks()->orderBy('clocked_in_at', 'asc')->first();
        return $firstClock ? $firstClock->clocked_in_at : null;
    }

    public function getClockedOutAtAttribute()
    {
        $hasActive = $this->clocks()->whereNull('clocked_out_at')->exists();
        if ($hasActive) {
            return null;
        }
        $latestClock = $this->clocks()->whereNotNull('clocked_out_at')->orderBy('clocked_out_at', 'desc')->first();
        return $latestClock ? $latestClock->clocked_out_at : null;
    }

    public function serviceOrder()
    {
        return $this->belongsTo(ServiceOrder::class, 'service_order_id');
    }

    public function confirmedBy()
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }

    public function facilities()
    {
        return $this->hasMany(ServiceOrderSlotFacility::class, 'service_order_slot_id');
    }

    public function clocks()
    {
        return $this->hasMany(ServiceOrderSlotClock::class, 'service_order_slot_id');
    }

    public function office()
    {
        return $this->belongsTo(Territory::class, 'scheduled_office');
    }

    public function staff()
    {
        return $this->hasMany(ServiceOrderSlotStaff::class, 'service_order_slot_id');
    }

    public function vehicles()
    {
        return $this->belongsToMany(Vehicle::class, 'service_order_slot_vehicles')
                    ->withTimestamps();
    }

    public function equipments()
    {
        return $this->belongsToMany(Equipment::class, 'service_order_slot_equipments', 'service_order_slot_id', 'equipment_id')
                    ->withTimestamps();
    }

}
