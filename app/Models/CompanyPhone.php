<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyPhone extends Model
{
    protected $fillable=[
        'company_id',
        'phone',
        'home_phones',
        'mobile_phones',
        'work_phones',
        'fax_phones'
    ];

     public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
