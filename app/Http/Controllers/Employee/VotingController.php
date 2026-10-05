<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NominationCycle;
use App\Models\Nomination;
use App\Models\User;
use App\Models\OfficeLocation;

class VotingController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Get active cycles
        $activeCycles = NominationCycle::active()->get();

        // Get IDs of cycles the user has already voted in
        $votedCycleIds = Nomination::where('voter_id', $user->id)
            ->pluck('nomination_cycle_id')
            ->toArray();

        // Filter active cycles to only those the user hasn't voted in
        $availableCycles = $activeCycles->filter(function($cycle) use ($votedCycleIds) {
            return !in_array($cycle->id, $votedCycleIds);
        });

        // Get eligible nominees (e.g., all active users) grouped by territory (office)
        $groupedUsers = User::with('territory')
            ->where('active', 1)
            ->orderBy('name')
            ->get()
            ->groupBy(function($u) {
                return $u->territory ? $u->territory->name : 'Unassigned Office';
            });
        
        // Get offices
        $offices = OfficeLocation::all();

        return view('employee.voting.index', compact('availableCycles', 'groupedUsers', 'offices'));
    }

    public function submitVote(Request $request)
    {
        $request->validate([
            'nomination_cycle_id' => 'required|exists:nomination_cycles,id',
            'nominee_id' => 'required|exists:users,id',
            'comments' => 'nullable|string|max:1000',
        ]);

        $user = auth()->user();

        // Verify the cycle is still active
        $cycle = NominationCycle::find($request->nomination_cycle_id);
        if (!$cycle || !$cycle->is_active) {
            return response()->json(['message' => 'This voting cycle is no longer active.'], 422);
        }

        // Verify the user hasn't already voted in this cycle
        $existingVote = Nomination::where('nomination_cycle_id', $cycle->id)
            ->where('voter_id', $user->id)
            ->first();

        if ($existingVote) {
            return response()->json(['message' => 'You have already voted in this category for the current cycle.'], 422);
        }

        $nominee = User::with('territory')->find($request->nominee_id);
        $officeId = null;
        if ($nominee && $nominee->territory) {
            $office = OfficeLocation::where('name', $nominee->territory->name)->first();
            if ($office) {
                $officeId = $office->id;
            }
        }

        Nomination::create([
            'nomination_cycle_id' => $cycle->id,
            'voter_id' => $user->id,
            'nominee_id' => $request->nominee_id,
            'office_id' => $officeId,
            'comments' => $request->comments,
        ]);

        return response()->json(['message' => 'Your vote has been successfully submitted!']);
    }
}
