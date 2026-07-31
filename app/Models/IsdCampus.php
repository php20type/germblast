<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class IsdCampus extends Model
{
    use HasFactory;

    protected $table = 'isd_campuses';

    protected $fillable = [
        'id',
        'isd_school_id',
        'name',
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(IsdSchool::class, 'isd_school_id');
    }

    public function attendanceRecords(): HasMany
    {
        return $this->hasMany(IsdAttendanceRecord::class, 'isd_campus_id');
    }
}
