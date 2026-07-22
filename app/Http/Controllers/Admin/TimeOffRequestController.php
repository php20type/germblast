<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TimeOffRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Carbon\Carbon;


class TimeOffRequestController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:time_off_request.view', only: ['index', 'store']),
            new Middleware('permission:time_off_request.edit', only: ['approve', 'reject']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        
        $currentYear = Carbon::now()->year;
        $selectedYear = $request->input('year', $currentYear); // default to current year

        // 1. Current user's requests
        $myRequests = TimeOffRequest::where('user_id', $user->id)
            ->whereYear('start_date', $selectedYear)
            ->latest()
            ->get();

        // 2. Company-wide requests (for users with edit permission or super admin)
        $companyRequests = collect();

        // Stats queries base
        $adminQuery = TimeOffRequest::query();
        $employeeQuery = TimeOffRequest::where('user_id', $user->id);

        // Apply year filter
        $adminQuery->whereYear('start_date', $selectedYear);
        $employeeQuery->whereYear('start_date', $selectedYear);

        if ($user->can('time_off_request.edit')) {
            $companyRequests = TimeOffRequest::with(['user', 'manager'])
                ->whereYear('start_date', $selectedYear)
                ->latest()
                ->get();

            // Stats for Manager/Admin (Company-wide)
            $approvedCount = $adminQuery->clone()->where('status', 'approved')->count();
            $pendingCount = $adminQuery->clone()->where('status', 'submitted')->count();
            $rejectedCount = $adminQuery->clone()->where('status', 'rejected')->count();
        } else {
            // Stats for regular employee (personal requests)
            $approvedCount = $employeeQuery->clone()->where('status', 'approved')->count();
            $pendingCount = $employeeQuery->clone()->where('status', 'submitted')->count();
            $rejectedCount = $employeeQuery->clone()->where('status', 'rejected')->count();
        }

        // Generate dynamic years for the toggle starting from 2026 up to the current year
        $years = range($currentYear, 2026);

        return view('admin.hr.time-off.index', compact(
            'myRequests',
            'companyRequests',
            'approvedCount',
            'pendingCount',
            'rejectedCount',
            'selectedYear',
            'currentYear',
            'years'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'reason'     => 'nullable|string|max:1000',
        ]);

        try {
            $timeOffRequest = TimeOffRequest::create([
                'user_id'    => auth()->id(),
                'start_date' => $request->start_date,
                'end_date'   => $request->end_date,
                'reason'     => $request->reason,
                'status'     => 'submitted',
            ]);

            $timeOffRequest->load('user');
            (new \App\Services\NotificationService())->timeOffSubmitted($timeOffRequest);

            if ($request->ajax()) {
                return response()->json(['message' => 'Time off request submitted successfully.']);
            }
            return redirect()->back()->with('success', 'Time off request submitted successfully.');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Failed to submit request: ' . $e->getMessage()], 500);
            }
            return redirect()->back()->with('error', 'Failed to submit request: ' . $e->getMessage());
        }
    }

    /**
     * Approve a time off request.
     */
    public function approve(Request $request, $id)
    {
        $user = auth()->user();

        try {
            $timeOffRequest = TimeOffRequest::findOrFail($id);
            $timeOffRequest->update([
                'status'      => 'approved',
                'actioned_by' => $user->id,
                'actioned_at' => now(),
                'admin_notes' => $request->admin_notes,
            ]);

            $timeOffRequest->load('user');
            (new \App\Services\NotificationService())->timeOffActioned($timeOffRequest);

            if ($request->ajax()) {
                return response()->json(['message' => 'Request approved successfully.']);
            }
            return redirect()->back()->with('success', 'Request approved successfully.');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Something went wrong: ' . $e->getMessage()], 500);
            }
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    /**
     * Reject a time off request.
     */
    public function reject(Request $request, $id)
    {
        $user = auth()->user();

        try {
            $timeOffRequest = TimeOffRequest::findOrFail($id);
            $timeOffRequest->update([
                'status'      => 'rejected',
                'actioned_by' => $user->id,
                'actioned_at' => now(),
                'admin_notes' => $request->admin_notes,
            ]);

            $timeOffRequest->load('user');
            (new \App\Services\NotificationService())->timeOffActioned($timeOffRequest);

            if ($request->ajax()) {
                return response()->json(['message' => 'Request rejected successfully.']);
            }
            return redirect()->back()->with('success', 'Request rejected successfully.');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Something went wrong: ' . $e->getMessage()], 500);
            }
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

}
