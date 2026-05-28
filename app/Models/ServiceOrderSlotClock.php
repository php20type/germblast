<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceOrderSlotClock extends Model
{
    protected $table = 'service_order_slot_clocks';

    protected $fillable = [
        'service_order_slot_id',
        'type',
        'clocked_by',
        'vehicle_id',
        'driver_user_id',
        'clocked_in_at',
        'clocked_out_at',
        'clocked_hours',
        'notes',
    ];

    public function serviceOrderSlot()
    {
        return $this->belongsTo(ServiceOrderSlot::class, 'service_order_slot_id');
    }

    public function clockedBy()
    {
        return $this->belongsTo(User::class, 'clocked_by');
    }

    public function calculateHours(): float
    {
        if ($this->clocked_in_at && $this->clocked_out_at) {
            return round(
                $this->clocked_in_at->diffInMinutes($this->clocked_out_at) / 60,
                2
            );
        }
        return 0;
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_user_id');
    }

}
