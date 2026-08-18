<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SitEvaluationAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'technician_id',
        'evaluator_id',
        'attempt_number',
        'score',
        'passed',
        'completed_at',
        'remarks',
        'development_plan',
        'other_comments',
    ];

    protected $casts = [
        'passed' => 'boolean',
        'completed_at' => 'datetime',
    ];

    public function technician()
    {
        return $this->belongsTo(User::class, 'technician_id');
    }

    public function evaluator()
    {
        return $this->belongsTo(User::class, 'evaluator_id');
    }

    public function scores()
    {
        return $this->hasMany(EvaluationScore::class, 'sit_evaluation_attempt_id');
    }
}
