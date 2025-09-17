<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadProduct extends Model
{
    protected $table = 'lead_products';

    protected $fillable = [
        'lead_id',
        'product_id',
        'qty',
        'price',
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class,'lead_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
}
