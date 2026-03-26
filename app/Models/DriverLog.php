<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DriverLog extends Model
{
    protected $table = 'driver_logs';
    protected $fillable = [
        'user_id',
        'driver_log_item_id',
        'points',
        'log_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function item()
    {
        return $this->belongsTo(DriverLogItem::class, 'driver_log_item_id');
    }

}
