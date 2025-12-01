<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadStageProcess extends Model
{
    protected $fillable = [
        'lead_id',
        'initial_meeting_scheduled_at',
        'initial_meeting_completed_at',
        'initial_meeting_completed_by',
        'site_survey_scheduled_at',
        'site_survey_completed_at',
        'site_survey_completed_by',
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class,'lead_id');
    }

    public function initialMeetingCompletedBy()
    {
        return $this->belongsTo(User::class, 'initial_meeting_completed_by');
    }

    public function siteSurveyCompletedBy()
    {
        return $this->belongsTo(User::class, 'site_survey_completed_by');
    }
}
