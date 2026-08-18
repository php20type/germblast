<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'target_user_id',
        'evaluator_user_id',
        'evaluation_type',
        'evaluation_request_id',
        'sit_evaluation_attempt_id',
        'evaluation_question_id',
        'score',
        'max_score',
    ];

    public function targetUser()
    {
        return $this->belongsTo(User::class, 'target_user_id');
    }

    public function evaluatorUser()
    {
        return $this->belongsTo(User::class, 'evaluator_user_id');
    }

    public function question()
    {
        return $this->belongsTo(EvaluationQuestion::class, 'evaluation_question_id');
    }

    public function evaluationRequest()
    {
        return $this->belongsTo(EvaluationRequest::class, 'evaluation_request_id');
    }

    public function sitEvaluationAttempt()
    {
        return $this->belongsTo(SitEvaluationAttempt::class, 'sit_evaluation_attempt_id');
    }
}
