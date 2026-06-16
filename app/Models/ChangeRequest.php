<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChangeRequest extends Model
{
    protected $table = 'change_requests';

    protected $fillable = [
        'title',
        'description',
        'requester_id',
        'status',
    ];

    /**
     * Get the user who requested the change.
     */
    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    /**
     * Get the tasks associated with this change request.
     */
    public function tasks()
    {
        return $this->hasMany(ChangeRequestTask::class, 'change_request_id');
    }

    /**
     * Get the documentation/history entries for this change request.
     */
    public function documentations()
    {
        return $this->hasMany(ChangeRequestDocumentation::class, 'change_request_id');
    }
}
