<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProposalAction extends Model
{
    protected $table = 'proposal_actions';

    protected $fillable = [
        'survey_proposal_id',
        'user_id',
        'status',
        'comment',
        'old_status',
        'new_status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function surveyProposal()
    {
        return $this->belongsTo(SurveyProposal::class, 'survey_proposal_id');
    }

    /**
     * Get action label
     */
    public function getActionLabelAttribute()
    {
        return match($this->status) {
            'approved' => 'Approved',
            'rejected' => 'Rejected',
            default => ucfirst($this->status)
        };
    }

    /**
     * Get badge color for action
     */
    public function getActionColorAttribute()
    {
        return match($this->status) {
            'approved' => 'success',
            'rejected' => 'danger',
            default => 'secondary'
        };
    }
}
