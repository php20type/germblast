<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class State extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'country_id',
        'country_code',
        'country_name',
        'state_code',
        'type',
        'latitude',
        'longitude',
    ];

    public $timestamps = false;

    // Relationships
    public function country()
    {
        return $this->belongsTo(Country::class,'country_id');
    }

    public function cities()
    {
        return $this->hasMany(City::class);
    }

    public function company()
    {
        return $this->hasMany(Company::class,'state_id');
    }

    public function people()
    {
        return $this->hasMany(People::class, 'state_id');
    }
}
