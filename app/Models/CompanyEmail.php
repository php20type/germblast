<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyEmail extends Model
{
    protected $fillable=[
        'company_id',
        'email',
        'personal_email',
        'support_email',
        'work_email',
    ];

     public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
