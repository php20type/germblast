<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TimeOffRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TimeOffRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        // 1. Current user's requests
        $myRequests = TimeOffRequest::where('user_id', $user->id)
            ->latest()
            ->get();

        // Calculate current user's approved days (e.g. for the current year)
        $currentYear = Carbon::now()->year;
        $myApprovedRequestsThisYear = TimeOffRequest::where('user_id', $user->id)
            ->where('status', 'approved')
            ->whereYear('start_date', $currentYear)
            ->get();

        $myApprovedDays = $myApprovedRequestsThisYear->sum(function ($req) {
            return $req->duration_days;
        });

        // 2. Company-wide requests (for admins, managers, supervisors)
        $isAdminOrManager = $user->isSuperAdmin() || 
                            $user->isSupervisor() || 
                            $user->isOperationsManager() || 
                            $user->isAssistantOperationsManager() || 
                            $user->isRegionalOperationsManager();

        $companyRequests = collect();
        $submittedCount = 0;
        $approvedCount = 0;
        $totalApprovedDaysCompany = 0;

        if ($isAdminOrManager) {
            $companyRequests = TimeOffRequest::with(['user', 'manager'])
                ->latest()
                ->get();

            $submittedCount = TimeOffRequest::where('status', 'submitted')->count();
            $approvedCount = TimeOffRequest::where('status', 'approved')->count();
            
            $approvedRequestsThisYear = TimeOffRequest::where('status', 'approved')
                ->whereYear('start_date', $currentYear)
                ->get();
            $totalApprovedDaysCompany = $approvedRequestsThisYear->sum(function ($req) {
                return $req->duration_days;
            });
        }

        return view('admin.hr.time-off.index', compact(
            'myRequests',
            'myApprovedDays',
            'isAdminOrManager',
            'companyRequests',
            'submittedCount',
            'approvedCount',
            'totalApprovedDaysCompany'
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
            TimeOffRequest::create([
                'user_id'    => auth()->id(),
                'start_date' => $request->start_date,
                'end_date'   => $request->end_date,
                'reason'     => $request->reason,
                'status'     => 'submitted',
            ]);

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
        $isAdminOrManager = $user->isSuperAdmin() || 
                            $user->isSupervisor() || 
                            $user->isOperationsManager() || 
                            $user->isAssistantOperationsManager() || 
                            $user->isRegionalOperationsManager();

        if (!$isAdminOrManager) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Unauthorized action.'], 403);
            }
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        try {
            $timeOffRequest = TimeOffRequest::findOrFail($id);
            $timeOffRequest->update([
                'status'      => 'approved',
                'actioned_by' => $user->id,
                'actioned_at' => now(),
                'admin_notes' => $request->admin_notes,
            ]);

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
     * Deny a time off request.
     */
    public function deny(Request $request, $id)
    {
        $user = auth()->user();
        $isAdminOrManager = $user->isSuperAdmin() || 
                            $user->isSupervisor() || 
                            $user->isOperationsManager() || 
                            $user->isAssistantOperationsManager() || 
                            $user->isRegionalOperationsManager();

        if (!$isAdminOrManager) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Unauthorized action.'], 403);
            }
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        try {
            $timeOffRequest = TimeOffRequest::findOrFail($id);
            $timeOffRequest->update([
                'status'      => 'denied',
                'actioned_by' => $user->id,
                'actioned_at' => now(),
                'admin_notes' => $request->admin_notes,
            ]);

            if ($request->ajax()) {
                return response()->json(['message' => 'Request denied successfully.']);
            }
            return redirect()->back()->with('success', 'Request denied successfully.');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Something went wrong: ' . $e->getMessage()], 500);
            }
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

}
