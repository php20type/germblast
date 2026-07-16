<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingTest extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'description',
        'video_url',
        'passing_percentage',

        'status',
    ];

    public function category()
    {
        return $this->belongsTo(TrainingCategory::class, 'category_id');
    }

    public function questions()
    {
        return $this->hasMany(TrainingQuestion::class, 'test_id');
    }
}
