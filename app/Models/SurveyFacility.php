<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyFacility extends Model
{
    protected $fillable = [
        'user_id',
        'survey_proposal_id',

        'facility_name',
        'address',
        'city',
        'state',
        'zip',
        'facility_type',

        // Additional facility details
        'square_footage',
        'offices',
        'standard_bathrooms',
        'single_bathrooms',
        'football_lockerroom',
        'regular_lockerrooms',
        'weight_room',
        'training_room',
        'equipment_room',
        'coachs_office',
        'shoulder_pads',
        'helmets',
        'wrestling_mats',

        // Man hours + cost
        'man_hours',
        'man_hours_cost',
    ];

    public function surveyProposal()
    {
        return $this->belongsTo(SurveyProposal::class, 'survey_proposal_id');
    }

      public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function maps()
    {
        return $this->hasMany(SurveyFacilityMap::class, 'survey_facility_id');
    }

    public function atp()
    {
        return $this->hasMany(SurveyFacilityAtp::class, 'survey_facility_id');
    }


}
