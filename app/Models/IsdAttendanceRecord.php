<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IsdAttendanceRecord extends Model
{
    use HasFactory;

    protected $table = 'isd_attendance_records';

    protected $fillable = [
        'isd_campus_id',
        'school_year',
        'week',
        'ada',
        'pia',
    ];

    public function campus(): BelongsTo
    {
        return $this->belongsTo(IsdCampus::class, 'isd_campus_id');
    }
}
