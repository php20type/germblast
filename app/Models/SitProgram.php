<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SitProgram extends Model
{
    protected $fillable = [
        'user_id',
        'status',
        'started_at',
        'completed_at',
        'notes',
        'initiated_by'
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function initiatedBy()
    {
        return $this->belongsTo(User::class, 'initiated_by');
    }

    public function programModules()
    {
        return $this->hasMany(SitProgramModule::class);
    }
}
