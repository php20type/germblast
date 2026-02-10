<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyProposal extends Model
{
    protected $table = 'survey_proposals';

    protected $fillable = [
        'user_id',
        'lead_id',
        'company_id',
        'date',
        'description',
        'enrollment',
        'wada',
        'aba',
        'service_technicians',
        'distance',
        'man_hours',
        'estimate',
        'specialist_narrative',
        'supplemental_title',
        'supplemental_body',
        'status'
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class, 'lead_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function facilities()
    {
        return $this->hasMany(SurveyFacility::class, 'survey_proposal_id');
    }

    public function equipmentEvaluations()
    {
        return $this->hasMany(EquipmentEvaluation::class, 'survey_proposal_id');
    }

    public function pricingProposal()
    {
        return $this->hasMany(PricingProposal::class, 'survey_proposal_id');
    }

    public function proposalComments()
    {
        return $this->hasMany(ProposalComment::class,'survey_proposal_id');
    }

}
