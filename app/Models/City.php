<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class City extends Model
{
     use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'state_id',
        'state_code',
        'state_name',
        'country_id',
        'country_code',
        'country_name',
        'latitude',
        'longitude',
        'wikiDataId'
    ];

    public $timestamps = false;

    // Relationships
    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function company()
    {
        return $this->hasMany(Company::class,'city_id');
    }

    public function people()
    {
        return $this->hasMany(People::class, 'city_id');
    }

}
