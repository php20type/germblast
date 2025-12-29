<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IAQZone extends Model
{
      protected $table = 'iaq_zones';

    protected $fillable = [
        'company_location_id',
        'name',
    ];

      public function companyLocation()
    {
        return $this->belongsTo(CompanyLocation::class, 'company_location_id');
    }

       public function iaqDevices()
    {
        return $this->hasMany(IAQDevice::class, 'iaq_zone_id');
    }

}
