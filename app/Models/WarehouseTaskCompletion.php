<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarehouseTaskCompletion extends Model
{
    protected $table = 'warehouse_task_completions';

    protected $fillable = [
        'warehouse_task_id',
        'user_id',
        'notes',
        'completed_at'
    ];

    protected $casts = [
        'completed_at' => 'datetime'
    ];

    /**
     * Get the task that was completed.
     */
    public function task()
    {
        return $this->belongsTo(WarehouseTask::class, 'warehouse_task_id');
    }

    /**
     * Get the user who completed the task.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
