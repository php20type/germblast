<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeAvailability extends Model
{
    protected $fillable = [
        'user_id',
        'start_date',
        'end_date',
        'avg_hours',
        'max_hours',
        'mon_start', 'mon_end',
        'tue_start', 'tue_end',
        'wed_start', 'wed_end',
        'thu_start', 'thu_end',
        'fri_start', 'fri_end',
        'sat_start', 'sat_end',
        'sun_start', 'sun_end',
    ];

    protected $casts = [
        'start_date' => 'date:Y-m-d',
        'end_date' => 'date:Y-m-d',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
