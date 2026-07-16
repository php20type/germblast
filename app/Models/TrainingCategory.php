<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingCategory extends Model
{
    protected $fillable = [
        'name',
        'description',
        'sort_order',
        'status',
    ];

    public function tests()
    {
        return $this->hasMany(TrainingTest::class, 'category_id');
    }
}
