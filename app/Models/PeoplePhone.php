<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeoplePhone extends Model
{
    protected $table = 'people_phones';
    protected $fillable=[
        'people_id',
        'phone',
        'home_phones',
        'mobile_phones',
        'work_phones',
        'fax_phones'
    ];

     public function people()
    {
        return $this->belongsTo(People::class, 'people_id');
    }
}
