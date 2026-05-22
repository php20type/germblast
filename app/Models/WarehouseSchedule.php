<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarehouseSchedule extends Model
{
    protected $table = 'warehouse_schedules';

    protected $fillable = [
        'employee',
        'start_time',
        'end_time',
        'type',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];
}
