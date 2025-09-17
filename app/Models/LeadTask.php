<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadTask extends Model
{
     protected $table = 'lead_tasks';
    protected $fillable=[
        'lead_id',
        'title',
        'description',
        'created_time',
        'due_time',
        'completed_time',
        'subject_type',
        'subject_legacy_id',
        'assignee_id',
        'assignee_name',
        'completed_user_id',
        'completed_user_name'
    ];

     public function lead()
    {
        return $this->belongsTo(Lead::class, 'lead_id');
    }

     public function assigneeUser()
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    public function completedUser()
    {
        return $this->belongsTo(User::class, 'completed_user_id');
    }
}
