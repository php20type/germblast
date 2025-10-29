<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PeopleFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'people_id',
        'file_name',
        'file_path',
        'file_type',
    ];

    public function people()
    {
        return $this->belongsTo(People::class,'people_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
