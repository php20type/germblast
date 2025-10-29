<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LeadFile extends Model
{
      use HasFactory;

    protected $fillable = [
        'user_id',
        'lead_id',
        'file_name',
        'file_path',
        'file_type',
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class,'lead_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
