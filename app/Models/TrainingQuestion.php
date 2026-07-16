<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingQuestion extends Model
{
    protected $fillable = [
        'test_id',
        'question',
        'question_type',
        'options',
        'correct_answer',
        'marks',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'options' => 'array',
    ];

    public function test()
    {
        return $this->belongsTo(TrainingTest::class, 'test_id');
    }
}
