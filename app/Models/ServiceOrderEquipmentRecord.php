<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceOrderEquipmentRecord extends Model
{
    protected $table = 'service_order_equipment_records';

    protected $fillable = [
        'service_order_id',
        'barcode',
        'status',
        'created_by',
    ];

    public function serviceOrder()
    {
        return $this->belongsTo(ServiceOrder::class, 'service_order_id');
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class, 'barcode', 'barcode');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
