<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Outcome extends Model
{
    protected $fillable=[
        'id',
        'name'
    ];

    public function lead()
    {
        return $this->hasMany(Lead::class, 'outcome_id');
    }

}
