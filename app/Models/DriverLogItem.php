<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DriverLogItem extends Model
{
    protected $table = 'driver_log_items';
    protected $fillable = [
        'name',
        'points',
    ];

    public function driverLogs()
    {
        return $this->hasMany(DriverLog::class, 'driver_log_item_id');
    }

}
