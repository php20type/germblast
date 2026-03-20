<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceOutline extends Model
{
    protected $table = 'service_outlines';
    protected $fillable = [
        'service_id',
        'outline_name',
        'description',
        'range',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class,'service_id');
    }
}
