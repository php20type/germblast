<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DriverSuspensionRecord extends Model
{
    protected $table = 'driver_suspension_records';

    protected $fillable = [
        'user_id',
        'suspended_until',
        'notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
