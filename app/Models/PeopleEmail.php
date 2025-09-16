<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeopleEmail extends Model
{
    protected $table = 'people_emails';
    protected $fillable=[
        'people_id',
        'email',
        'personal_email',
        'support_email'
    ];

     public function people()
    {
        return $this->belongsTo(People::class, 'people_id');
    }
}
