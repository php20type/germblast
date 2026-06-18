<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessFailureDocumentation extends Model
{
    use HasFactory;

    protected $table = 'business_failure_documentations';

    protected $fillable = [
        'business_failure_id',
        'user_id',
        'notes',
    ];

    public function businessFailure()
    {
        return $this->belongsTo(BusinessFailure::class, 'business_failure_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
