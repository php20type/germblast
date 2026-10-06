<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SitProgramModule extends Model
{
    protected $fillable = [
        'sit_program_id',
        'sit_module_id',
        'status',
        'completed_by',
        'completed_at',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
    ];

    public function sitProgram()
    {
        return $this->belongsTo(SitProgram::class);
    }

    public function module()
    {
        return $this->belongsTo(SitModule::class, 'sit_module_id');
    }

    public function completedBy()
    {
        return $this->belongsTo(User::class, 'completed_by');
    }
}
