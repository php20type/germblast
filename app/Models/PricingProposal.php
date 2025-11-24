<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PricingProposal extends Model
{
    use HasFactory;

    protected $table = 'pricing_proposals';

    /**
     * Mass Assignable Fields
     */
    protected $fillable = [
        'survey_proposal_id',
        'pricing_total',
        'partial_cost_service',
        'awareness',
        'education',
        'technology',
        'response',
        'logistics_expense',
        'proposal_name',
        'proposal_order',
        'override_pricing',
        'discounts',
        'descriptions',
        'services_per_year',
        'contract_terms',
        'prepayment_discount',
    ];

     public function surveyProposal()
    {
        return $this->belongsTo(SurveyProposal::class, 'survey_proposal_id');
    }

    /**
     * PricingProposal has many Facilities (Many-to-Many)
     * Pivot table: pricing_proposal_facility
     */
    public function facilities()
    {
        return $this->belongsToMany(SurveyFacility::class, 'pricing_proposal_facility', 'pricing_proposal_id', 'facility_id')
                    ->withTimestamps();
    }

    /**
     * PricingProposal has many Equipment (Many-to-Many)
     * Pivot table (if created): pricing_proposal_equipment
     */
    public function equipment()
    {
        return $this->belongsToMany(EquipmentEvaluation::class, 'pricing_proposal_equipment', 'pricing_proposal_id', 'equipment_id')
                    ->withTimestamps();
    }
}
