<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnonymousFeedback extends Model
{
    protected $table = 'anonymous_feedbacks';

    protected $fillable = [
        'description',
    ];
}
