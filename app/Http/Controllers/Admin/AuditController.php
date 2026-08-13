<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ServiceOrderSlot;

use App\Models\AuditSection;

class AuditController extends Controller
{
    public function index()
    {
        $audits = ServiceOrderSlot::with('serviceOrder.service.lead.company', 'office', 'staff.user')
                    ->where('is_audit_finalized', true)
                    ->get();

        return view('admin.operations.audits', compact('audits'));
    }

    public function show($id)
    {
        $slot = ServiceOrderSlot::with('serviceOrder.service.lead.company', 'office', 'staff.user', 'vehicles', 'facilities.companyLocation.city', 'facilities.companyLocation.state')
                    ->findOrFail($id);

        $sections = AuditSection::with(['questions.submissions' => function($query) use ($id) {
            $query->where('service_order_slot_id', $id)->with('employee', 'creator');
        }])->orderBy('sort_order')->get();

        return view('admin.operations.audit-detail', compact('slot', 'sections'));
    }

    public function auditThis(Request $request, $slot_id)
    {
        $slot = ServiceOrderSlot::findOrFail($slot_id);
        $slot->update(['is_audit' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Slot marked for audit successfully.'
        ]);
    }

    public function finalize(Request $request, $id)
    {
        $slot = ServiceOrderSlot::findOrFail($id);
        $slot->update(['is_audit_finalized' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Audit finalized successfully.'
        ]);
    }

    public function reopen(Request $request, $id)
    {
        $slot = ServiceOrderSlot::findOrFail($id);
        $slot->update(['is_audit_finalized' => false]);

        return response()->json([
            'success' => true,
            'message' => 'Audit re-opened successfully.'
        ]);
    }

    public function cancelAudit(Request $request, $slot_id)
    {
        $slot = ServiceOrderSlot::findOrFail($slot_id);
        $slot->update([
            'is_audit' => false,
            'is_audit_finalized' => false
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Audit cancelled successfully.'
        ]);
    }
}
