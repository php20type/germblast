<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompanyFile extends Model
{
     use HasFactory;

    protected $fillable = [
        'user_id',
        'company_id',
        'file_name',
        'file_path',
        'file_type',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class,'company_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
