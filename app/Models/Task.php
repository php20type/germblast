<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'company_id',
        'user_id',
        'title',
        'description',
        'due_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class,'company_id');
    }
}
