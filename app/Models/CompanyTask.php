<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyTask extends Model
{
    protected $fillable=[
        'company_id',
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

     public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
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
