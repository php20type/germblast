<?php

namespace App\Http\Controllers;

use App\Models\Territory;
use Illuminate\Http\Request;
use App\Models\Equipment;
use App\Models\EquipmentManagementType;
use App\Models\EquipmentStatusLog;


use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class EquipmentManagementController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:equipment_manager.view', only: ['index', 'history']),
            new Middleware('permission:equipment_manager.add', only: ['store', 'updateStatus']),
        ];
    }
    public function index(Request $request)
    {
        $baseQuery = Equipment::with('type');

        // Status-wise data
        $dirtyTypes = (clone $baseQuery)->where('status', Equipment::STATUS_DIRTY)->get();
        $readyTypes = (clone $baseQuery)->where('status', Equipment::STATUS_READY)->get();
        $brokenTypes = (clone $baseQuery)->where('status', Equipment::STATUS_BROKEN)->get();
        $lostTypes = (clone $baseQuery)->where('status', Equipment::STATUS_LOST)->get();
        $decommissionedTypes = (clone $baseQuery)->where('status', Equipment::STATUS_DECOMMISSIONED)->get();
        $inUseTypes = (clone $baseQuery)->where(function ($q) {
            $q->where('status', Equipment::STATUS_ASSIGNED)
              ->orWhereHas('slots');
        })->get();
        $allTypes = (clone $baseQuery)->get();

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
        ]);

        if ($request->ajax()) {
            return response()->json(['message' => 'Equipment created successfully']);
        }

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
        // HANDLE UNASSIGN  (In Use tab modal)
        // ------------------------------------------------------------------
        if ($newStatus === 'unassign') {

            if (!$equipment->isAssigned()) {
                if ($request->ajax()) {
                    return response()->json(['message' => 'This equipment is not currently assigned.'], 400);
                }
                return back()->with('error', 'This equipment is not currently assigned.');
            }

            EquipmentStatusLog::create([
                'equipment_id' => $equipment->id,
                'from_status'  => config("mapping.equipment_status.{$equipment->status}", $equipment->status),
                'to_status'    => 'dirty',
                'note'         => $request->note ?? 'Unassigned',
                'territory_id' => $request->office ?: null,
                'changed_by'   => auth()->id(),
            ]);

            // Ensure we detach the equipment from all active slots to prevent "ghost" assignments
            $equipment->slots()->detach();

            $equipment->update(['status' => Equipment::STATUS_DIRTY]);

            if ($request->ajax()) {
                return response()->json(['message' => 'Equipment has been unassigned successfully.']);
            }
            return back()->with('success', 'Equipment has been unassigned successfully.');
        }

        // ------------------------------------------------------------------
        // VALIDATE STATUS IS A KNOWN VALUE
        // ------------------------------------------------------------------
        $integerStatus = $newStatus;
        if (is_string($newStatus) && !is_numeric($newStatus)) {
            $mapped = array_search($newStatus, config('mapping.equipment_status', []));
            if ($mapped !== false) {
                $integerStatus = $mapped;
            }
        }

        if (!in_array((int)$integerStatus, Equipment::statuses(), true)) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Unknown status value provided.'], 400);
            }
            return back()->with('error', 'Unknown status value provided.');
        }

        // ------------------------------------------------------------------
        // VALIDATE TRANSITION IS ALLOWED
        // ------------------------------------------------------------------
        if (!$equipment->canTransitionTo($integerStatus)) {
            $currentStatusText = config("mapping.equipment_status.{$equipment->status}", $equipment->status);
            $newStatusText = config("mapping.equipment_status.{$integerStatus}", $newStatus);
            $errorMsg = 'Cannot transition from "' . ucfirst($currentStatusText) . '" to "' . ucfirst($newStatusText) . '".';
            
            if ($request->ajax()) {
                return response()->json(['message' => $errorMsg], 400);
            }
            return back()->with('error', $errorMsg);
        }

        // ------------------------------------------------------------------
        // LOG THE STATUS CHANGE
        // ------------------------------------------------------------------
        EquipmentStatusLog::create([
            'equipment_id' => $equipment->id,
            'from_status'  => config("mapping.equipment_status.{$equipment->status}", $equipment->status),
            'to_status'    => config("mapping.equipment_status.{$integerStatus}", $integerStatus),
            'note'         => $request->note,
            'territory_id' => $request->office ?: null,
            'changed_by'   => auth()->id(),
        ]);

        // ------------------------------------------------------------------
        // APPLY STATUS CHANGE
        // ------------------------------------------------------------------
        $equipment->status      = $integerStatus;
        $equipment->save();

        // If the equipment is transitioning to anything other than ASSIGNED,
        // it must be detached from any active slots to prevent inconsistencies.
        if ($integerStatus !== Equipment::STATUS_ASSIGNED) {
            $equipment->slots()->detach();
        }

        $newStatusText = config("mapping.equipment_status.{$integerStatus}", $newStatus);
        $successMsg = 'Equipment status updated to "' . ucfirst($newStatusText) . '" successfully.';
        
        if ($request->ajax()) {
            return response()->json(['message' => $successMsg]);
        }
        return back()->with('success', $successMsg);
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
                $fromText = is_numeric($log->from_status) 
                    ? config("mapping.equipment_status.{$log->from_status}", $log->from_status) 
                    : $log->from_status;
                
                $toText = is_numeric($log->to_status) 
                    ? config("mapping.equipment_status.{$log->to_status}", $log->to_status) 
                    : $log->to_status;

                return [
                    'date'        => $log->created_at->format('m/d/y g:i a'),
                    'from_status' => ucfirst($fromText),
                    'to_status'   => ucfirst($toText),
                    'note'        => $log->note,
                    'territory'   => $log->territory ? $log->territory->name : null,
                    'changed_by'  => $log->changedBy ? $log->changedBy->name : 'System',
                ];
            });

        $equipmentStatusText = config("mapping.equipment_status.{$equipment->status}", $equipment->status);

        return response()->json([
            'equipment' => [
                'id'            => $equipment->id,
                'barcode'       => $equipment->barcode,
                'serial_number' => $equipment->serial_number,
                'type'          => $equipment->type ? $equipment->type->name : '-',
                'status'        => ucfirst($equipmentStatusText),
            ],
            'logs' => $logs,
        ]);
    }
}
