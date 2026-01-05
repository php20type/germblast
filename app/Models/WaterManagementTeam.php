<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WaterManagementTeam extends Model
{
    protected $fillable = [
        'water_management_phase_id',
        'name',
        'role',
        'email',
    ];

    public function waterManagementPhase()
    {
        return $this->belongsTo(WaterManagementPhase::class, 'water_management_phase_id');
    }
}
