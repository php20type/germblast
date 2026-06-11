<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmployeeReward;
use App\Models\User;
use Illuminate\Http\Request;

class EmployeeRewardController extends Controller
{
    /**
     * Display a listing of the rewards.
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->isSuperAdmin()) {
            // Super Admin can view all rewards in the system
            $rewards = EmployeeReward::with('user')->latest()->get();
        } else {
            // Regular employees only view their own rewards
            $rewards = $user->rewards()->latest()->get();
        }

        $users = User::orderBy('name')->get();

        return view('admin.hr.rewards.index', compact('rewards', 'users'));
    }

    /**
     * Store a newly created reward.
     */
    public function store(Request $request)
    {
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'user_id'     => 'required|exists:users,id',
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string|max:5000',
        ]);

        EmployeeReward::create([
            'user_id'     => $request->user_id,
            'name'        => $request->name,
            'description' => $request->description,
        ]);

        if ($request->ajax()) {
            return response()->json(['message' => 'Reward assigned successfully.']);
        }

        return redirect()->route('admin.hr.rewards.index')
            ->with('success', 'Reward assigned successfully.');
    }

    /**
     * Remove the specified reward.
     */
    public function destroy($id)
    {
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        EmployeeReward::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Reward deleted successfully.');
    }
}
