<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'services';
    protected $fillable = [
        'user_id',
        'lead_id',
        'service_name',
        'price_per_service',
        'number_of_services',
        'po_number',
        'total_price'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function lead()
    {
        return $this->belongsTo(Lead::class,'lead_id');
    }

    public function outlines()
    {
        return $this->hasMany(ServiceOutline::class, 'service_id');
    }

    public function orders()
    {
        return $this->hasMany(ServiceOrder::class, 'service_id');
    }

}
