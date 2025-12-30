<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BiologicalResponseIntake extends Model
{
     protected $table = 'biological_response_intake';

    protected $fillable = [
        'company_id',

        // Basic Information
        'project_name',
        'project_address',
        'project_city',
        'project_state',
        'project_zip',
        'project_leader',
        'comments',

        // Frontend Management
        'facility_type',
        'casualties_or_illnesses',
        'estimated_man_hours',
        'estimated_people',
        'type_of_loss',

        // Additional Contact
        'contact_name',
        'contact_title',
        'contact_phone',

        // Insurance
        'insurance_notified',
        'insurance_company_name',
        'insurance_phone',
        'coverage_determination',
        'coverage_amount',
        'deductible',
        'claim_number',
        'adjuster_phone',
        'insurance_email',
        'limit_or_cap',

        // Illness & Death Information
        'person_travelled_outside',
        'diagnosis',
        'number_of_diagnosis',
        'cause_of_death',
        'number_of_deaths',
        'body_unattended',
        'unattended_days',
        'more_than_2_rooms',
        'high_consequence_infectious_disease',
        'police_cleanup',
        'police_contact',
        'police_number',
        'overdose',
        'gunshot',

        // Cost Estimate Information
        'environment_hourly_rate',
        'environment_response_total',
        'supplies_hourly_rate',
        'response_supplies_total',
        'sub_total',
        'waste_disposal',
        'total',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class,'company_id');
    }
    public function treatedAreas()
  {
      return $this->hasMany(BiologicalResponseTreatedArea::class,'biological_response_intake_id');
  }

}
