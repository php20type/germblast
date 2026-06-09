<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceOrderCleanPatch extends Model
{
    protected $table = 'service_order_clean_patches';

    protected $fillable = [
        'service_order_id',
        'barcode',
        'patch_size',
        'created_by',
    ];

    public function serviceOrder()
    {
        return $this->belongsTo(ServiceOrder::class, 'service_order_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
