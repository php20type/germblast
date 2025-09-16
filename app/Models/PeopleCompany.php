<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeopleCompany extends Model
{
     protected $table = 'people_companies';

    protected $fillable = [
        'people_id',
        'company_id',
    ];

    public function people()
    {
        return $this->belongsTo(People::class, 'people_id');
    }
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

}
