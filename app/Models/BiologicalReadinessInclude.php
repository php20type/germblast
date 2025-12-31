<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BiologicalReadinessInclude extends Model
{
    protected $table = 'biological_readiness_includes';

    protected $fillable = [
        'biological_readiness_id',
        'includes',
    ];

    public function biologicalReadiness()
    {
        return $this->belongsTo(BiologicalReadiness::class,'biological_readiness_id');
    }
}
