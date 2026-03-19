<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyLocation extends Model
{
    protected $table = 'company_locations';

    protected $fillable = [
        'company_id',
        'location_name',
        'country_id',
        'state_id',
        'city_id',
        'address_1',
        'address_2',
        'zip',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    // Optional (if you already have these models)
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function iaqZones()
    {
        return $this->hasMany(IAQZone::class, 'company_location_id');
    }

      public function iaqDevices()
    {
        return $this->hasManyThrough(
            IAQDevice::class,
            IAQZone::class,
            'company_location_id', // FK on iaq_zones
            'iaq_zone_id',         // FK on iaq_devices
            'id',                  // PK on company_locations
            'id'                   // PK on iaq_zones
        );
    }

    public function slotFacilities()
    {
        return $this->hasMany(ServiceOrderSlotFacility::class, 'company_location_id');
    }
}
