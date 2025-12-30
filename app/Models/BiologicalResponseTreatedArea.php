<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BiologicalResponseTreatedArea extends Model
{
     protected $table = 'biological_response_treated_areas';

    protected $fillable = [
        'biological_response_intake_id',
        'area_name',
    ];

    public function biologicalResponseIntake()
    {
        return $this->belongsTo(BiologicalResponseIntake::class,'biological_response_intake_id');
    }
}
