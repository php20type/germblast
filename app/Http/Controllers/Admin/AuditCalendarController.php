<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ServiceOrderSlot;

class AuditCalendarController extends Controller
{
    public function index()
    {
        return view('admin.operations.audit-calendar');
    }

    public function auditCalendarOrders()
    {
        $slots = ServiceOrderSlot::with([
                'serviceOrder.service.lead.company',
                'serviceOrder'
            ])
            ->where('is_audit', true)
            ->get();

        $events = $slots->map(function ($slot) {
            $order = $slot->serviceOrder;
            if (!$order) return null;

            return [
                'id'    => $slot->id,
                'title' => $order->service->lead->company->name ?? $order->service->service_name ?? 'Audit',
                'start' => $slot->scheduled_start_time,
                'end'   => $slot->scheduled_end_time,
                'color' => $slot->is_audit_finalized ? '#e63946' : '#069697',
                'extendedProps' => [
                    'order_id'     => $order->id,
                    'order_no'     => $order->order_no,
                    'status'       => $slot->status ?? 'pending',
                    'scheduled_start_time' => $slot->scheduled_start_time,
                    'is_audit_finalized' => $slot->is_audit_finalized,
                ],
            ];
        })->filter()->values();

        return response()->json($events);
    }
}
