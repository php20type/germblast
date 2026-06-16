<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChangeRequestDocumentation extends Model
{
    protected $table = 'change_request_documentations';

    protected $fillable = [
        'change_request_id',
        'user_id',
        'notes',
    ];

    /**
     * Get the change request associated with this documentation.
     */
    public function changeRequest()
    {
        return $this->belongsTo(ChangeRequest::class, 'change_request_id');
    }

    /**
     * Get the user who added this documentation.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
