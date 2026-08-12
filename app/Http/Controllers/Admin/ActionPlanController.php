<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ActionPlan;
use Illuminate\Support\Facades\Auth;

class ActionPlanController extends Controller
{
    public function index()
    {
        $unresolvedActionPlans = ActionPlan::where('is_resolved', false)->get();
        $resolvedActionPlans = ActionPlan::where('is_resolved', true)->orderBy('resolved_at', 'desc')->get();

        return view('admin.operations.action-plan', compact('unresolvedActionPlans', 'resolvedActionPlans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'concern_area' => 'required|string|max:255',
            'section' => 'required|string|max:255',
            'notes' => 'required|string',
        ]);

        ActionPlan::create([
            'concern_area' => $request->concern_area,
            'section' => $request->section,
            'user_id' => Auth::id() ?? 1, // fallback if testing unauthenticated
            'notes' => $request->notes,
            'is_resolved' => false,
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back()->with('success', 'Action Plan added successfully.');
    }

    public function markResolved(Request $request, $id)
    {
        $actionPlan = ActionPlan::findOrFail($id);
        $actionPlan->update([
            'is_resolved' => true,
            'resolved_by' => Auth::id(),
            'resolved_at' => now(),
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back()->with('success', 'Action Plan marked as resolved.');
    }
}
