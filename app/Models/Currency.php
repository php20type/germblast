<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Market;

class Currency extends Model
{
    protected $fillable = [
        'code',
        'name',
        'USDexchangerate',
    ];

    /**
     * Get all markets using this currency.
     */
    public function market()
    {
        return $this->hasMany(Market::class,'currency_id');
    }
}
