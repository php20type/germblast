<?php

namespace App\Http\Controllers\Admin\Operations;

use App\Http\Controllers\Controller;
use App\Models\SitModule;
use App\Models\SitProgram;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SitProgramController extends Controller
{
    public function index()
    {
        // Fetch active technicians not already enrolled in an active SIT program
        $technicians = User::role('technician')
            ->where('active', 1)
            ->where('created_at', '<=', Carbon::now()->subDays(90))
            ->whereDoesntHave('sitPrograms', fn($q) => $q->where('status', 'in_progress'))
            ->orderBy('name')
            ->get();

        // Active modules (for preview in confirmation modal)
        $modules = SitModule::active()->orderBy('order_index')->get();

        return view('admin.operations.sit-program.index', compact('technicians', 'modules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        // Guard: prevent double-enrollment
        $alreadyEnrolled = SitProgram::where('user_id', $request->user_id)
            ->where('status', 'in_progress')
            ->exists();

        if ($alreadyEnrolled) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'This technician is already enrolled in an active SIT Program.'], 422);
            }
            return redirect()->back()->withErrors(['user_id' => 'This technician is already enrolled in an active SIT Program.']);
        }

        $program = SitProgram::create([
            'user_id'      => $request->user_id,
            'status'       => 'in_progress',
            'started_at'   => Carbon::now(),
            'initiated_by' => auth()->id(),
        ]);

        // Attach all active modules in order_index sequence
        $modules = SitModule::active()->orderBy('order_index')->get();
        foreach ($modules as $module) {
            $program->programModules()->create([
                'sit_module_id' => $module->id,
                'status'        => 'pending',
            ]);
        }

        $enrolledUser = User::find($request->user_id);
        
        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => $enrolledUser->name . ' has been successfully enrolled in the SIT Program.']);
        }

        return redirect()->route('admin.operations.sit-progress.index')
            ->with('success', $enrolledUser->name . ' has been successfully enrolled in the SIT Program.');
    }
}
