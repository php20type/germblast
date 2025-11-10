<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Approval extends Model
{
    use HasFactory;

    protected $fillable = [
        'action',
        'data',
        'email',
        'redirect_url',
        'approval_token',
        'is_approved',
    ];

    protected $casts = [
        'data' => 'array',
    ];
}
