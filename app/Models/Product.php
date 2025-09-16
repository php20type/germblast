<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'product_type',
        'sku',
        'unit',
        'price',
        'availability',
    ];

    // Lead Products pivot table
    public function leadProducts()
    {
        return $this->hasMany(LeadProduct::class, 'product_id');
    }
    public function leads()
    {
        return $this->belongsToMany(Lead::class, 'lead_products')
            ->withPivot(['qty', 'price']) // extra fields
            ->withTimestamps();
    }

}
