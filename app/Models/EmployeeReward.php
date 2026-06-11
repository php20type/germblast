<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeReward extends Model
{
    protected $table = 'employee_rewards';

    protected $fillable = [
        'user_id',
        'name',
        'description',
    ];

    /**
     * Get the employee associated with the reward.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
