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
            'status' => Equipment::STATUS_DIRTY,
            'is_assigned' => false,
        ]);

        return redirect()->back()->with('success', 'Equipment created successfully');
    }

    public function updateStatus(Request $request, $id)
    {
        $equipment = Equipment::findOrFail($id);

        $newStatus = $request->status;

        // ------------------------------------------------------------------
        // VALIDATE COMMON FIELDS
        // ------------------------------------------------------------------
        $request->validate([
            'status'       => 'required|string',
            'note'         => 'nullable|string|max:1000',
            'office'       => 'nullable|exists:territories,id',
        ]);

        // ------------------------------------------------------------------
        // HANDLE IN USE  (assign)
        // ------------------------------------------------------------------
        if ($newStatus === 'in_use') {

            if ($equipment->status !== Equipment::STATUS_READY) {
                return back()->with('error', 'Only equipment with status "Ready" can be assigned.');
            }

            EquipmentStatusLog::create([
                'equipment_id' => $equipment->id,
                'from_status'  => $equipment->status,
                'to_status'    => 'in_use',
                'note'         => $request->note,
                'territory_id' => $request->office ?: null,
                'changed_by'   => auth()->id(),
            ]);

            $equipment->is_assigned = true;
            $equipment->save();

            return back()->with('success', 'Equipment marked as In Use.');
        }

        // ------------------------------------------------------------------
        // HANDLE UNASSIGN  (In Use tab modal)
        // ------------------------------------------------------------------
        if ($newStatus === 'unassign') {

            if (!$equipment->is_assigned) {
                return back()->with('error', 'This equipment is not currently assigned.');
            }

            EquipmentStatusLog::create([
                'equipment_id' => $equipment->id,
                'from_status'  => 'in_use',
                'to_status'    => $equipment->status,
                'note'         => $request->note ?? 'Unassigned',
                'territory_id' => $request->office ?: null,
                'changed_by'   => auth()->id(),
            ]);

            $equipment->is_assigned = false;
            $equipment->save();

            return back()->with('success', 'Equipment has been unassigned successfully.');
        }

        // ------------------------------------------------------------------
        // VALIDATE STATUS IS A KNOWN VALUE
        // ------------------------------------------------------------------
        if (!in_array($newStatus, Equipment::statuses(), true)) {
            return back()->with('error', 'Unknown status value provided.');
        }

        // ------------------------------------------------------------------
        // VALIDATE TRANSITION IS ALLOWED
        // ------------------------------------------------------------------
        if (!$equipment->canTransitionTo($newStatus)) {
            return back()->with('error',
                'Cannot transition from "' . ucfirst($equipment->status) . '" to "' . ucfirst($newStatus) . '".'
            );
        }

        // ------------------------------------------------------------------
        // LOG THE STATUS CHANGE
        // ------------------------------------------------------------------
        EquipmentStatusLog::create([
            'equipment_id' => $equipment->id,
            'from_status'  => $equipment->status,
            'to_status'    => $newStatus,
            'note'         => $request->note,
            'territory_id' => $request->office ?: null,
            'changed_by'   => auth()->id(),
        ]);

        // ------------------------------------------------------------------
        // APPLY STATUS CHANGE
        // ------------------------------------------------------------------
        $equipment->status      = $newStatus;
        $equipment->is_assigned = false;   // any manual status change clears assignment
        $equipment->save();

        return back()->with('success', 'Equipment status updated to "' . ucfirst($newStatus) . '" successfully.');
    }

    // ------------------------------------------------------------------
    // HISTORY  — returns JSON status logs for a given equipment
    // ------------------------------------------------------------------
    public function history($id)
    {
        $equipment = Equipment::with(['type'])->findOrFail($id);

        $logs = EquipmentStatusLog::with(['changedBy', 'territory'])
            ->where('equipment_id', $id)
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($log) {
                return [
                    'date'        => $log->created_at->format('m/d/y g:i a'),
                    'from_status' => ucfirst($log->from_status),
                    'to_status'   => ucfirst($log->to_status),
                    'note'        => $log->note,
                    'territory'   => $log->territory ? $log->territory->name : null,
                    'changed_by'  => $log->changedBy ? $log->changedBy->name : 'System',
                ];
            });

        return response()->json([
            'equipment' => [
                'id'            => $equipment->id,
                'barcode'       => $equipment->barcode,
                'serial_number' => $equipment->serial_number,
                'type'          => $equipment->type ? $equipment->type->name : '-',
                'status'        => ucfirst($equipment->status),
            ],
            'logs' => $logs,
        ]);
    }
}
