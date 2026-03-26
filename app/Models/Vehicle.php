<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $table = 'vehicles';

    protected $fillable = [
        'name',
        'number_available',
        'is_retired',
    ];
}
