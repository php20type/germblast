<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceOrderAtpSample extends Model
{
    protected $fillable = [
        'entry_id',
        'service_order_id',
        'atp_type',
        'facility_id',
        'result',
        'description',
    ];

    public function serviceOrder()
    {
        return $this->belongsTo(ServiceOrder::class, 'service_order_id');
    }

    public function facility()
    {
        return $this->belongsTo(CompanyLocation::class, 'facility_id');
    }
}
