<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadPeople extends Model
{
    protected $table = 'lead_peoples';

    protected $fillable = [
        'lead_id',
        'people_id',
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class,'lead_id');
    }

    public function people()
    {
        return $this->belongsTo(People::class,'people_id');
    }
}
