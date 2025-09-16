<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Territory extends Model
{

    protected $fillable = [
        'name',
    ];

    // A territory has many locations
    public function locations()
    {
        return $this->hasMany(TerritoryLocation::class, 'territory_id');
    }

    public function company()
    {
        return $this->hasMany(Company::class,'territory_id');
    }

    public function people()
    {
        return $this->hasMany(People::class, 'territory_id');
    }



}
