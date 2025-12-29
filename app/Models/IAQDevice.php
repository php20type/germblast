<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IAQDevice extends Model
{
          protected $table = 'iaq_devices';

    protected $fillable = [
        'iaq_zone_id',
        'name',
        'node_id'
    ];

      public function iaqZone()
    {
        return $this->belongsTo(IAQZone::class, 'iaq_zone_id');
    }

 
}
