<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EquipmentEvaluation extends Model
{
      protected $table = 'equipment_evaluations';

    protected $fillable = [
        'user_id',
        'survey_proposal_id',
        'name',

        'wash_counts',
        'cleaning_counts',
        
        'wash_man_hours',
        'wash_man_hours_cost',
        'cleaning_man_hours',
        'cleaning_man_hours_cost',
        'total_cost'
    ];

    protected $casts = [
        'wash_counts' => 'array',
        'cleaning_counts' => 'array',
    ];

     public function surveyProposal()
    {
        return $this->belongsTo(SurveyProposal::class, 'survey_proposal_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function images()
    {
        return $this->hasMany(SurveyEquipmentImage::class, 'survey_equipment_id');
    }

}
