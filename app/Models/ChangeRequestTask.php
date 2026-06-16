<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChangeRequestTask extends Model
{
    protected $table = 'change_request_tasks';

    protected $fillable = [
        'change_request_id',
        'title',
        'assigned_to',
        'due_date',
        'status',
    ];

    /**
     * Get the change request that owns the task.
     */
    public function changeRequest()
    {
        return $this->belongsTo(ChangeRequest::class, 'change_request_id');
    }

    /**
     * Get the user assigned to this task.
     */
    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
