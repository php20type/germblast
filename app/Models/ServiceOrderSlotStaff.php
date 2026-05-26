<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceOrderSlotStaff extends Model
{
    protected $table = 'service_order_slot_staff';
    protected $fillable = [
        'service_order_slot_id',
        'user_id',
        'slot_hours',
        'is_leader',
    ];
    protected $casts = [
        'is_leader' => 'boolean',
    ];
    public function slot()
    {
        return $this->belongsTo(ServiceOrderSlot::class, 'service_order_slot_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
