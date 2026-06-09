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
        'intended_date',
        'status',

        // NEW Checklist Fields
        'service_plan_narrative',
        'sales_narrative',
        'plan_review_status',
        'plan_debrief',

        // Checklist consumables
        'pre_checklist_consumables',
        'post_checklist_consumables',
        'hotel_details',
        'atp_details',
    ];

    protected $casts = [
        'pre_checklist_consumables' => 'array',
        'post_checklist_consumables' => 'array',
        'hotel_details' => 'array',
        'atp_details' => 'array',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class,'service_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

     public function orderSlots()
    {
        return $this->hasMany(ServiceOrderSlot::class, 'service_order_id');
    }

    public function notes()
    {
        return $this->hasMany(ServiceNote::class, 'service_order_id');
    }

    public function employeePerformances()
    {
        return $this->hasMany(ServiceOrderEmployeePerformance::class,'service_order_id');
    }

    public function invoice()
    {
        return $this->hasOne(ServiceOrderInvoice::class, 'service_order_id');
    }

    public function invoices()
    {
        return $this->hasMany(ServiceOrderInvoice::class, 'service_order_id');
    }

    public function roomRecords()
    {
        return $this->hasMany(ServiceOrderRoomRecord::class, 'service_order_id');
    }

    public function equipmentRecords()
    {
        return $this->hasMany(ServiceOrderEquipmentRecord::class, 'service_order_id');
    }

    public function cleanPatches()
    {
        return $this->hasMany(ServiceOrderCleanPatch::class, 'service_order_id');
    }
}
