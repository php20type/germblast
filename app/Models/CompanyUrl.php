<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyUrl extends Model
{
    protected $fillable=[
        'company_id',
        'url',
        'blog_url',
        'twitter_url'
    ];

     public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
