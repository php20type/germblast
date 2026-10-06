<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SitModule extends Model
{
    protected $fillable = [
        'name',
        'description',
        'order_index',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function programModules()
    {
        return $this->hasMany(SitProgramModule::class, 'sit_module_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
