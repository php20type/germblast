<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Country extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'name', 'iso2', 'dialing_code'];

    public $timestamps = false;

    // Relationships
    public function states()
    {
        return $this->hasMany(State::class,'country_id');
    }

    public function company()
    {
        return $this->hasMany(Company::class, 'country_id');
    }

    public function people()
    {
        return $this->hasMany(People::class, 'country_id');
    }
}
