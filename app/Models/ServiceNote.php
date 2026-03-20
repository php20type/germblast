<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceNote extends Model
{
    protected $table = 'service_notes';
    protected $fillable = [
        'service_order_id',
        'user_id',
        'person_id',
        'notes',
        'image_path',
        'notify_sales_team',
    ];

     public function serviceOrder()
    {
        return $this->belongsTo(ServiceOrder::class, 'service_order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function person()
    {
        return $this->belongsTo(User::class, 'person_id');
    }

}
