<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityType extends Model
{
    protected $fillable=[
        'id',
        'type',
        'icon'
    ];

     public function activities()
    {
        return $this->hasMany(Activity::class,'activity_type_id');
    }
}
