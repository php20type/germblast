<?php

namespace App\Http\Controllers;

use App\Models\Territory;
use Illuminate\Http\Request;
use App\Models\Equipment;
use App\Models\EquipmentManagementType;
use App\Models\EquipmentStatusLog;


class EquipmentManagementController extends Controller
{
  public function index()
    {
        // Status-wise data
        $dirtyTypes = Equipment::with('type')->where('status', Equipment::STATUS_DIRTY)->get();
        $readyTypes = Equipment::with('type')->where('status', Equipment::STATUS_READY)->get();
        $brokenTypes = Equipment::with('type')->where('status', Equipment::STATUS_BROKEN)->get();
        $lostTypes = Equipment::with('type')->where('status', Equipment::STATUS_LOST)->get();
        $decommissionedTypes = Equipment::with('type')->where('status', Equipment::STATUS_DECOMMISSIONED)->get();
        $inUseTypes = Equipment::with('type')->where('is_assigned', true)->get();
        $allTypes = Equipment::with('type')->get();

        // Counts
        $dirtyCount = $dirtyTypes->count();
        $readyCount = $readyTypes->count();
        $brokenCount = $brokenTypes->count();
        $lostCount = $lostTypes->count();
        $decommissionedCount = $decommissionedTypes->count();
        $inUseCount = $inUseTypes->count();
        $allCount = $allTypes->count();

        // Equipment types (dropdown)
        $equipmentTypes = EquipmentManagementType::all();
        $territories = Territory::all();

        return view('admin.equipment-management.index', compact(
            // Status-wise data
            'dirtyTypes',
            'readyTypes',
            'brokenTypes',
            'lostTypes',
            'decommissionedTypes',
            'inUseTypes',
            'allTypes',
            'equipmentTypes',
            'territories',
            // counts
            'dirtyCount',
            'readyCount',
            'brokenCount',
            'lostCount',
            'decommissionedCount',
            'inUseCount',
            'allCount'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barcode' => 'nullable|string',
            'serial_number' => 'nullable|string',
            'type_id' => 'required|exists:equipment_management_types,id',
        ]);

        Equipment::create([
            'barcode' => $request->barcode,
            'serial_number' => $request->serial_number,
            'type_id' => $request->type_id,
            'status' => Equipment::STATUS_NEW,
            'is_assigned' => false,
        ]);

        return redirect()->back()->with('success', 'Equipment created successfully');
    }

    public function updateStatus(Request $request, $id)
    {
        $equipment = Equipment::findOrFail($id);

        $newStatus = $request->status;

        // -----------------------------
        // HANDLE IN USE (SPECIAL CASE)
        // -----------------------------
        if ($newStatus === 'in_use') {

            // Only allow from READY
            if ($equipment->status !== Equipment::STATUS_READY) {
                return back()->with('error', 'Only READY equipment can be assigned');
            }

            $equipment->is_assigned = true;
            $equipment->save();

            return back()->with('success', 'Equipment assigned');
        }

        // -----------------------------
        // UNASSIGN (OPTIONAL)
        // -----------------------------
        if ($newStatus === 'unassign') {
            $equipment->is_assigned = false;
            $equipment->save();

            return back()->with('success', 'Equipment unassigned');
        }

        // -----------------------------
        // VALIDATE TRANSITION
        // -----------------------------
        if (!$equipment->canTransitionTo($newStatus)) {
            return back()->with('error', 'Invalid status transition');
        }

        EquipmentStatusLog::create([
            'equipment_id' => $equipment->id,
            'from_status' => $equipment->status,
            'to_status' => $newStatus,
            'note' => $request->note,
            'office' => $request->office,
            'changed_by' => auth()->id(),
        ]);

        // -----------------------------
        // APPLY STATUS CHANGE
        // -----------------------------
        $equipment->status = $newStatus;

        // Any status change removes assignment
        $equipment->is_assigned = false;

        $equipment->save();

        return back()->with('success', 'Status updated successfully');
    }
}
