<?php

namespace App\Http\Controllers\Admin\HR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NominationCycle;
use App\Models\Nomination;
use Carbon\Carbon;

class NominationController extends Controller
{
    public function index()
    {
        $categories = [
            'technician' => 'Outstanding Technician of the Quarter Management',
            'warehouse' => 'Outstanding Warehouse Team Member of the Quarter Management',
            'supervisor' => 'Outstanding Supervisor Nomination System Management',
            'om' => 'Outstanding Operations Manager Nomination System Management',
        ];

        // Get active cycles
        $activeCycles = NominationCycle::active()->get()->keyBy('category');

        // Get past cycles with nominations
        $pastCycles = NominationCycle::where('is_active', false)
            ->with(['nominations.nominee', 'nominations.office'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('category');

        // Limit to last 3 for each category and group nominations
        $formattedPastCycles = [];
        foreach ($pastCycles as $category => $cycles) {
            $formattedPastCycles[$category] = $cycles->take(3)->map(function($cycle) {
                // Group nominations by office name
                $groupedNominations = $cycle->nominations->groupBy(function($nom) {
                    return $nom->office ? $nom->office->name : 'Unknown Office';
                })->map(function($officeNoms) {
                    // Group by nominee
                    return $officeNoms->groupBy('nominee_id')->map(function($nomineeNoms) {
                        return [
                            'nominee' => $nomineeNoms->first()->nominee,
                            'count' => $nomineeNoms->count(),
                            'comments' => $nomineeNoms->pluck('comments')->filter()->values()
                        ];
                    })->sortByDesc('count');
                });
                $cycle->grouped_nominations = $groupedNominations;
                return $cycle;
            });
        }

        $user = auth()->user();
        $votedCycleIds = Nomination::where('voter_id', $user->id)->pluck('nomination_cycle_id')->toArray();

        $groupedUsers = \App\Models\User::with('territory')
            ->where('active', 1)
            ->orderBy('name')
            ->get()
            ->groupBy(function($u) {
                return $u->territory ? $u->territory->name : 'Unassigned Office';
            });
        
        $offices = \App\Models\OfficeLocation::all();

        return view('admin.hr.nominations.index', compact('categories', 'activeCycles', 'formattedPastCycles', 'groupedUsers', 'offices', 'votedCycleIds'));
    }

    public function storeCycle(Request $request)
    {
        $request->validate([
            'category' => 'required|in:technician,warehouse,supervisor,om',
            'title' => 'required|string|max:255',
            'start_date' => 'required|date',
        ]);

        // Check if there is already an active cycle for this category
        $activeCycle = NominationCycle::where('category', $request->category)->active()->first();
        if ($activeCycle) {
            return response()->json(['message' => 'An active voting cycle already exists for this category.'], 422);
        }

        NominationCycle::create([
            'category' => $request->category,
            'title' => $request->title,
            'start_date' => $request->start_date,
            'is_active' => true,
            'created_by' => auth()->id(),
        ]);

        // Add to timeline/activity log if you have an ActivityLogger service.
        
        return response()->json(['message' => 'Voting cycle initiated successfully.']);
    }

    public function closeCycle($id)
    {
        $cycle = NominationCycle::findOrFail($id);
        $cycle->update([
            'is_active' => false,
            'end_date' => Carbon::now(),
        ]);

        return response()->json(['message' => 'Voting cycle closed successfully.']);
    }
}
