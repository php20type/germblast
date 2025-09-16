<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyAddress extends Model
{
    // Mass assignable fields
    protected $fillable = [
        'company_id',
        'address',
        'main_address',
        'work_address',
        'home_address',
        'billing_address',
        'mailing_address',
    ];

    /**
     * Define relationship to Company
     */
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
