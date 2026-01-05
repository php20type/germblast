<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WaterManagementPhase extends Model
{
    protected $table = 'water_management_phase';

    /**
     * Mass assignable fields
     */
    protected $fillable = [

        /* COMPANY */
        'company_id',

        /* BASIC DETAILS */
        'survey_name',
        'municipal_water_supplier',

        /* FACILITY RISK FACTORS */
        'is_healthcare_facility',
        'houses_elderly_patients',
        'has_multiple_housing_units',
        'has_more_than_two_floors',
        'has_cooling_tower',
        'has_hot_tub_or_spa',
        'has_indoor_fountain',
        'has_central_mister_or_humidifier',
        'conducts_organ_transplant',
        'history_of_legionella',

        /* MONITORING DETAILS */
        'current_monitoring_activities',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function waterManagementTeams()
    {
        return $this->hasMany(WaterManagementTeam::class);
    }
}
