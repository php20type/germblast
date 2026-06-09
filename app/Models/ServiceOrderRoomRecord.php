<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceOrderRoomRecord extends Model
{
    protected $table = 'service_order_room_records';

    protected $fillable = [
        'service_order_id',
        'barcode',
        'created_by',
    ];

    public function serviceOrder()
    {
        return $this->belongsTo(ServiceOrder::class, 'service_order_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
