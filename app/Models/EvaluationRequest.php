<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'target_user_id',
        'evaluator_user_id',
        'status',
        'sent_at',
        'completed_at',
        'remarks',
        'development_plan',
        'other_comments',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function targetUser()
    {
        return $this->belongsTo(User::class, 'target_user_id');
    }

    public function evaluatorUser()
    {
        return $this->belongsTo(User::class, 'evaluator_user_id');
    }

    public function scores()
    {
        return $this->hasMany(EvaluationScore::class, 'evaluation_request_id');
    }
}
