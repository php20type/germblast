<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProposalComment extends Model
{
    protected $table = 'proposal_comments';

    protected $fillable = [
        'user_id',
        'survey_proposal_id',
        'comment'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function surveyProposal()
    {
        return $this->belongsTo(SurveyProposal::class, 'survey_proposal_id');
    }

}
