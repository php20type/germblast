<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PricingService extends Model
{
    protected $table = 'pricing_services';

    protected $fillable = [
        'pricing_id',
        'service_name',
    ];

    public function pricingProposal()
    {
        return $this->belongsTo(PricingProposal::class, 'pricing_id');
    }
}
