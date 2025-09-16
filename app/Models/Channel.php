<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    protected $fillable=[
        'name',
    ];

    public function source(){
        return $this->hasMany(Source::class, 'channel_id');
    }
}
