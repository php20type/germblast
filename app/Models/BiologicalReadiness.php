<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BiologicalReadiness extends Model
{
     protected $table = 'biological_readiness';

    protected $fillable = [
        'company_id',
        'status',
        'project_name',
        'per_hour_reduction_amount',
        'length',
        'monthly_rate',
        'default_readiness_includes_1',
        'default_readiness_includes_2',
        'service_description',
        'line_total',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class,'company_id');
    }

    public function includes()
    {
        return $this->hasMany(BiologicalReadinessInclude::class,'biological_readiness_id');
    }
}
