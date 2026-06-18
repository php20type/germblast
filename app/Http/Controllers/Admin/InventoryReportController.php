<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InventoryItem;
use Carbon\Carbon;

class InventoryReportController extends Controller
{
    public function index()
    {
        $items = InventoryItem::orderBy('name', 'asc')->get();
        return view('admin.reports.inventory', compact('items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'office' => 'required|string|max:255',
            'report_date' => 'required|date',
            'inventory_val' => 'nullable|numeric|min:0',
            'reorder_point_val' => 'nullable|numeric|min:0',
            'unit' => 'nullable|string|max:255',
            'supplier' => 'nullable|string|max:255',
            'actions' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $data = $request->all();

        // Auto-determine warning status
        $inv = $request->filled('inventory_val') ? (float)$request->inventory_val : null;
        $reorder = $request->filled('reorder_point_val') ? (float)$request->reorder_point_val : null;
        
        $warning = false;
        if ($inv !== null && $reorder !== null && $inv < $reorder) {
            $warning = true;
        } elseif ($inv === null && $reorder !== null) {
            $warning = true;
        }
        
        $data['warning'] = $warning;

        // Auto-fill action if empty and it is a warning
        if ($warning && empty($data['actions'])) {
            $qty = $reorder !== null ? floatval($reorder) : 0;
            $unitStr = $request->unit ? ' ' . $request->unit : '';
            $data['actions'] = "Please be sure you have an additional {$qty}{$unitStr} on order";
        }

        InventoryItem::create($data);

        return redirect()->route('admin.inventory-report.index')->with('success', 'Inventory item created successfully.');
    }

    public function update(Request $request, $id)
    {
        $item = InventoryItem::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'office' => 'required|string|max:255',
            'report_date' => 'required|date',
            'inventory_val' => 'nullable|numeric|min:0',
            'reorder_point_val' => 'nullable|numeric|min:0',
            'unit' => 'nullable|string|max:255',
            'supplier' => 'nullable|string|max:255',
            'actions' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $data = $request->all();

        // Auto-determine warning status
        $inv = $request->filled('inventory_val') ? (float)$request->inventory_val : null;
        $reorder = $request->filled('reorder_point_val') ? (float)$request->reorder_point_val : null;
        
        $warning = false;
        if ($inv !== null && $reorder !== null && $inv < $reorder) {
            $warning = true;
        } elseif ($inv === null && $reorder !== null) {
            $warning = true;
        }
        
        $data['warning'] = $warning;

        // Auto-fill action if warning and empty
        if ($warning && empty($data['actions'])) {
            $qty = $reorder !== null ? floatval($reorder) : 0;
            $unitStr = $request->unit ? ' ' . $request->unit : '';
            $data['actions'] = "Please be sure you have an additional {$qty}{$unitStr} on order";
        } elseif (!$warning) {
            $data['actions'] = null;
        }

        $item->update($data);

        return redirect()->route('admin.inventory-report.index')->with('success', 'Inventory item updated successfully.');
    }

    public function destroy($id)
    {
        $item = InventoryItem::findOrFail($id);
        $item->delete();

        return redirect()->route('admin.inventory-report.index')->with('success', 'Inventory item deleted successfully.');
    }
}
