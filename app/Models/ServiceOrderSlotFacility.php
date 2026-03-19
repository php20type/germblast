<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceOrderSlotFacility extends Model
{
     protected $table = 'service_order_slot_facilities';

    protected $fillable = [
        'service_order_slot_id',
        'company_location_id',
    ];

    public function slot()
    {
        return $this->belongsTo(ServiceOrderSlot::class, 'service_order_slot_id');
    }

    public function companyLocation()
    {
        return $this->belongsTo(CompanyLocation::class, 'company_location_id');
    }
}
