<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Currency;

class Market extends Model
{
    protected $fillable=[
        'name',
        'currency_id',
    ];

     public function currency()
    {
        return $this->belongsTo(Currency::class,'currency_id');
    }

    public function lead()
    {
        return $this->hasMany(Lead::class, 'market_id');
    }
}
