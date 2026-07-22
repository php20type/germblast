<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmployeeReward;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class EmployeeRewardController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:gb_reward.view', only: ['index']),
            new Middleware('permission:gb_reward.add', only: ['store', 'destroy']),
        ];
    }

    /**
     * Display a listing of the rewards.
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->can('gb_reward.add') || $user->isSuperAdmin()) {
            // Users with add permission or Super Admin can view all rewards in the system
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
        EmployeeReward::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Reward deleted successfully.');
    }
}
