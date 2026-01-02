<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IAQSurvey extends Model
{
     protected $table = 'iaq_surveys';

    protected $fillable = [

        // Foreign key
        'company_id',

        // Basic Information
        'survey_name',
        'building_description',
        'reported_issues',

        // General Walkthrough (booleans + descriptions)
        'odor',
        'odor_desc',

        'dirty_unsanitary',
        'dirty_unsanitary_desc',

        'visible_microbial',
        'visible_microbial_desc',

        'material_staining',
        'material_staining_desc',

        'adequate_ventilation',
        'adequate_ventilation_desc',

        'hvac_duct_blocked',
        'hvac_duct_blocked_desc',

        'filter_adequate',
        'filter_adequate_desc',
        'filter_change_freq',

        'chemical_storage',
        'chemical_storage_desc',

        'temp_within_ashre',
        'temp_within_ashre_desc',

        'overcrowding',
        'overcrowding_desc',

        'poor_iaq_activities',
        'poor_iaq_activities_desc',

        'water_intrusion',
        'water_intrusion_desc',

        'carpet_present',
        'carpet_present_desc',
        'carpet_clean_freq',

        'pest_management',
        'pest_management_desc',
        'pest_management_freq',

        'dirty_air_diffusers',
        'dirty_air_diffusers_desc',

        'mhvac_equipment',
        'mhvac_equipment_desc',

        // Sampling Details
        'location',
        'parameter',
        'volume',
        'sampler',
        'result',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
