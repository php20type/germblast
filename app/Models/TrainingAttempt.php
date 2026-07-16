<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingAttempt extends Model
{
    protected $fillable = [
        'employee_id',
        'training_test_id',
        'attempt_number',
        'score',
        'status',

        'submitted_at',
    ];

    protected $casts = [

        'submitted_at' => 'datetime',
    ];

    public function test()
    {
        return $this->belongsTo(TrainingTest::class, 'training_test_id');
    }

    public function employee()
    {
        return $this->belongsTo(\App\Models\User::class, 'employee_id');
    }
}
