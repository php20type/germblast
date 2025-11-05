<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_type',
        'owner_id',
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
        'completed_user_name',
    ];

    /**
     * Get the parent model (Company, People, or Lead) that owns this task.
     */
     public function owner()
    {
        return $this->morphTo(null, 'owner_type', 'owner_id');
    }

    /**
     * The user assigned to this task.
     */
    public function assignee()
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    /**
     * The user who completed this task.
     */
    public function completedBy()
    {
        return $this->belongsTo(User::class, 'completed_user_id');
    }
}
