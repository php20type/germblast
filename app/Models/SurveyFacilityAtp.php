<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyFacilityAtp extends Model
{
    protected $table = 'survey_facility_atp';

    protected $fillable = [
        'user_id',
        'lead_id',
        'survey_facility_id',
        'location',
        'atp_value',
        'file_name',
        'file_path',
        'file_type',
    ];

      public function facility()
    {
        return $this->belongsTo(SurveyFacility::class, 'survey_facility_id');
    }

      public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

     public function lead()
    {
        return $this->belongsTo(Lead::class, 'lead_id');
    }

}
