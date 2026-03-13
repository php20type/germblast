<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceOrder extends Model
{
    protected $table = 'service_orders';
    protected $fillable = [
        'user_id',
        'service_id',

        'order_no',

        // Intended
        'intended_date',

        // Scheduled
        'scheduled_date',
        'scheduled_start_time',
        'scheduled_end_time',
        'scheduled_arrival_time',
        'scheduled_office',
        'scheduled_recurrence_count',
        'scheduled_recurrence_rule',
        'meet',
        'overnight',

        // Clock in/out
        'clocked_by',
        'clocked_in_at',
        'clocked_out_at',
        'job_notes',

        'status',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class,'service_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function clockedBy()
    {
        return $this->belongsTo(User::class,'clocked_by');
    }

}
