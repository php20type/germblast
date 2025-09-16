<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TerritoryLocation extends Model
{
     protected $fillable = [
        'territory_id',
        'type',
        'country',
        'state',
        'city',
        'postal_code',
        'area_code',
        'range',
    ];

    // A location belongs to one territory
    public function territory()
    {
        return $this->belongsTo(Territory::class, 'territory_id');
    }
}
