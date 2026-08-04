<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timecard extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_id',
        'work_date',
        'clock_in',
        'clock_out',
        'clock_type',
    ];

    public static function getClockTypes()
    {
        return config('mapping.timecard_clock_types', []);
    }

    public function getClockTypeLabelAttribute()
    {
        $types = self::getClockTypes();
        return $types[$this->clock_type] ?? 'Unknown';
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class,'company_id');
    }
}
