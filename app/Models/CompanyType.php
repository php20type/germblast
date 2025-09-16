<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyType extends Model
{
    protected $fillable = [
        'type',
    ];

    public function company()
    {
        return $this->hasMany(Company::class,'company_type_id');
    }

}
