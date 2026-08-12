<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\EmployeePerformanceRecord;

class EmployeePerformanceController extends Controller
{
    public function index(Request $request)
    {
        $currentQuarter = 'Q' . ceil(now()->month / 3) . ' ' . now()->year;
        $quarter = $request->input('quarter', $currentQuarter);

        // Parse current selected quarter to get previous and next
        // Expected format: "Q3 2026"
        preg_match('/Q(\d)\s+(\d{4})/', $quarter, $matches);
        if (count($matches) === 3) {
            $q = (int)$matches[1];
            $y = (int)$matches[2];
        } else {
            $q = (int)ceil(now()->month / 3);
            $y = (int)now()->year;
        }

        $prevQ = $q == 1 ? 4 : $q - 1;
        $prevY = $q == 1 ? $y - 1 : $y;
        $prevQuarter = "Q{$prevQ} {$prevY}";

        $nextQ = $q == 4 ? 1 : $q + 1;
        $nextY = $q == 4 ? $y + 1 : $y;
        $nextQuarter = "Q{$nextQ} {$nextY}";

        $users = User::where('active', 1)
            ->with(['disciplineRecords' => function ($query) use ($quarter) {
                $query->where('quarter', $quarter);
            }])
            ->orderBy('name')
            ->get();

        $technicians = $users->where('staff_type', 'technician');
        $supervisors = $users->where('staff_type', 'leader');
        $warehouse = $users->reject(function ($user) {
            return in_array($user->staff_type, ['technician', 'leader']);
        });

        return view('admin.operations.employee-performance', compact('technicians', 'supervisors', 'warehouse', 'quarter', 'prevQuarter', 'nextQuarter', 'currentQuarter'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'category' => 'required|string',
            'points' => 'required|integer',
            'comments' => 'nullable|string',
            'quarter' => 'required|string',
        ]);

        EmployeePerformanceRecord::create($request->only([
            'user_id', 'category', 'points', 'comments', 'quarter'
        ]));

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Performance record added successfully.'
            ]);
        }

        return back()->with('success', 'Performance record added successfully.');
    }
}
