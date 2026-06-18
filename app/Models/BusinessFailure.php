<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessFailure extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'record_opened_date',
        'description',
        'created_by',
    ];

    protected $casts = [
        'record_opened_date' => 'date',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function documentations()
    {
        return $this->hasMany(BusinessFailureDocumentation::class, 'business_failure_id');
    }
}
