<?php

namespace App\Http\Controllers\Admin\Operations;

use App\Http\Controllers\Controller;
use App\Models\SitProgram;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SitProgressController extends Controller
{
    public function index()
    {
        $activePrograms = SitProgram::with([
                'user',
                'programModules' => fn($q) => $q->with(['module' => fn($q) => $q->orderBy('order_index')]),
                'initiatedBy',
            ])
            ->where('status', 'in_progress')
            ->latest()
            ->get();

        $completedPrograms = SitProgram::with(['user', 'initiatedBy'])
            ->whereIn('status', ['completed', 'dropped'])
            ->latest('completed_at')
            ->get();

        return view('admin.operations.sit-progress.index', compact('activePrograms', 'completedPrograms'));
    }

    public function update(Request $request, $id)
    {
        $program = SitProgram::findOrFail($id);
        $moduleId = $request->input('module_id');
        $module = $program->programModules()->where('id', $moduleId)->firstOrFail();

        $module->update([
            'status'       => 'completed',
            'completed_by' => auth()->id(),
            'completed_at' => Carbon::now(),
        ]);

        // Check if all modules are completed
        $allCompleted = $program->programModules()->where('status', '!=', 'completed')->count() === 0;
        $completedAt = $module->completed_at ? $module->completed_at->format('M d, Y h:i A') : Carbon::now()->format('M d, Y h:i A');
        $completedBy = auth()->user()->name;

        if ($allCompleted) {
            $program->update([
                'status'       => 'completed',
                'completed_at' => Carbon::now(),
            ]);
            if ($request->ajax()) {
                return response()->json([
                    'success' => true, 
                    'message' => 'All modules completed! SIT Program finished successfully.', 
                    'program_completed' => true,
                    'completed_at_formatted' => $completedAt,
                    'completed_by_name' => $completedBy
                ]);
            }
            return redirect()->route('admin.operations.sit-progress.index')
                ->with('success', 'All modules completed! SIT Program finished successfully.');
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true, 
                'message' => 'Module signed off successfully.', 
                'program_completed' => false,
                'completed_at_formatted' => $completedAt,
                'completed_by_name' => $completedBy
            ]);
        }
        return redirect()->back()->with('success', 'Module signed off successfully.');
    }

    public function drop(Request $request, $id)
    {
        $program = SitProgram::findOrFail($id);
        $program->update([
            'status'       => 'dropped',
            'completed_at' => Carbon::now(),
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'SIT Program has been dropped for ' . $program->user->name . '.']);
        }

        return redirect()->route('admin.operations.sit-progress.index')
            ->with('success', 'SIT Program has been dropped for ' . $program->user->name . '.');
    }
}
