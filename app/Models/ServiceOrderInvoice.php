<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceOrderInvoice extends Model
{
    use HasFactory;

    protected $table = 'service_order_invoices';

    protected $fillable = [
        'service_order_id',
        'invoice_no',
        'invoice_date',
        'line_items',   
        'notes',
        'total_amount',
        'created_by',
        'updated_by',
        'sent_by',
        'sent_date'
    ];

    protected $casts = [
        'line_items' => 'array',
        'invoice_date' => 'date:Y-m-d',
        'sent_date' => 'datetime'
    ];

    public function serviceOrder()
    {
        return $this->belongsTo(ServiceOrder::class, 'service_order_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sent_by');
    }
}
