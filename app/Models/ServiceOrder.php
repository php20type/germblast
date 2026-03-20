<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceOrder extends Model
{
    protected $table = 'service_orders';
    protected $fillable = [
        'user_id',
        'service_id',
        'order_no',
        'intended_date',
        'status',

        // Inventory consumptions
        'microfiber',
        'swabs',
        'oxivir_jars',
        'opticide_gallons',
        'halomist',
        'water',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class,'service_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

     public function orderSlots()
    {
        return $this->hasMany(ServiceOrderSlot::class, 'service_order_id');
    }

    public function notes()
    {
        return $this->hasMany(ServiceNote::class, 'service_order_id');
    }
}
