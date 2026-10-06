<?php

namespace App\Http\Controllers\Admin\Operations;

use App\Http\Controllers\Controller;
use App\Models\SitModule;
use Illuminate\Http\Request;

class SitModuleController extends Controller
{
    public function index()
    {
        $modules = SitModule::orderBy('order_index')->orderBy('created_at')->get();
        return view('admin.operations.sit-modules.index', compact('modules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $maxOrder = SitModule::max('order_index') ?? 0;

        $module = SitModule::create([
            'name'        => $request->name,
            'description' => $request->description,
            'order_index' => $maxOrder + 1,
            'is_active'   => true,
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Module created successfully.', 'module' => $module]);
        }

        return redirect()->back()->with('success', 'Module created successfully.');
    }

    public function update(Request $request, SitModule $sitModule)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $sitModule->update([
            'name'        => $request->name,
            'description' => $request->description,
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Module updated successfully.']);
        }

        return redirect()->back()->with('success', 'Module updated successfully.');
    }

    public function toggleActive(Request $request, SitModule $sitModule)
    {
        $sitModule->update(['is_active' => !$sitModule->is_active]);
        $label = $sitModule->is_active ? 'activated' : 'deactivated';
        
        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => "Module {$label} successfully.", 'is_active' => $sitModule->is_active]);
        }

        return redirect()->back()->with('success', "Module {$label} successfully.");
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'integer|exists:sit_modules,id',
        ]);

        foreach ($request->order as $index => $id) {
            SitModule::where('id', $id)->update(['order_index' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }

    public function destroy(Request $request, SitModule $sitModule)
    {
        // Soft-delete by deactivating if it has program history, hard-delete otherwise
        if ($sitModule->programModules()->count() > 0) {
            $sitModule->update(['is_active' => false]);
            
            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Module has program history — it has been deactivated instead of deleted.']);
            }
            return redirect()->back()->with('success', 'Module has program history — it has been deactivated instead of deleted.');
        }

        $sitModule->delete();
        
        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Module deleted successfully.']);
        }
        return redirect()->back()->with('success', 'Module deleted successfully.');
    }
}
