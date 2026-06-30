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
        'country_id',
        'state_id',
        'city_id',
        'zip',
        'facility_type',

        // Additional facility details
        'room_counts',

        // Man hours + cost
        'man_hours',
        'man_hours_cost',

        // Total cost
        'total_cost',
        'is_added_to_company',
    ];

    protected $casts = [
        'is_added_to_company' => 'boolean',
        'room_counts' => 'array',
    ];

    protected $with = ['country', 'state', 'city'];
    

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

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }


}
