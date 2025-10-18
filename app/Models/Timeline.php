<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Timeline extends Model
{
     use HasFactory;

    protected $fillable = [
        'user_id',
        'owner_type',
        'owner_id',
        'action_type',
        'description',
    ];

     public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function owner()
    {
        return $this->morphTo(null, 'owner_type', 'owner_id');
    }

}
