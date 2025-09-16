<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeopleUrl extends Model
{
    protected $table = 'people_urls';
     protected $fillable=[
        'people_id',
        'url',
        'blog_url',
        'twitter_url'
    ];

     public function people()
    {
        return $this->belongsTo(People::class, 'people_id');
    }
}
