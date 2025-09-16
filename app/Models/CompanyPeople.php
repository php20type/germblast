<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyPeople extends Model
{
     protected $table = 'company_peoples';

    protected $fillable = [
        'company_id',
        'people_id',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function people()
    {
        return $this->belongsTo(People::class, 'people_id');
    }
}
