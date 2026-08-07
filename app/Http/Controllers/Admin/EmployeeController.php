<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Territory;
use App\Models\MaskType;
use App\Models\DriverLog;
use App\Models\DriverLogItem;
use App\Models\DriverSuspensionRecord;
use App\Models\MaskFitTestRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class EmployeeController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:employee.view', only: ['index', 'workReport']),
            new Middleware('permission:driver_report.view', only: ['driverReport']),
            new Middleware('permission:driver_report.edit', only: ['updateDriverReport']),
            new Middleware('permission:employee.edit', only: [
                'create',
                'store',
                'edit',
                'update',
            ]),
        ];
    }

    public function index(Request $request)
    {
        $query = User::withoutRole('customer');

        // Apply search filter
        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        $employees = $query->orderBy('name')->get();
        $employeesCount = $employees->count();

        // Handle AJAX requests
        if ($request->ajax()) {
            return response()->json([
                'table' => view('admin.employee.partials.employee-table-rows', compact('employees'))->render(),
                'count' => $employeesCount,
            ]);
        }

        return view('admin.employee.index', compact(
            'employees',
            'employeesCount'
        ));
    }

    public function create()
    {
        // $roles = Role::all();
        $roles = Role::whereNotIn('name', ['customer'])->get();
        $territories = Territory::all();

        return view('admin.employee.create', compact('roles', 'territories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => 'required|exists:roles,name',
            'staff_type' => 'nullable|in:leader,technician,corporate',
            'territory_id' => 'nullable|exists:territories,id',
        ]);

        // Create employee
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'staff_type' => $validated['staff_type'] ?? null,
            'territory_id' => $validated['territory_id'] ?? null,

            // Store role string for UI / legacy usage
            'role' => $validated['role'],
        ]);

        // Assign Spatie role
        $user->assignRole($validated['role']);

        // Dispatch welcome email and in-app notification via NotificationService
        try {
            (new \App\Services\NotificationService())->employeeCreated($user);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to dispatch welcome notification for new employee: ' . $e->getMessage());
        }

        return response()->json([
            'status' => true,
            'message' => 'Employee created successfully.',
            'data' => $user,
        ], 201);
    }

    public function edit($id)
    {
        $employee = User::findOrFail($id);
        // $roles = Role::all();
        $roles = Role::whereNotIn('name', ['customer'])->get();
        $territories = Territory::all();
        $maskTypes = MaskType::all();
        $maskFitTestRecords = MaskFitTestRecord::with('maskType')
            ->where('user_id', $id)
            ->orderBy('fit_test_date', 'desc')
            ->get();
        $driverLogItems = DriverLogItem::all();
        $driverLogs = DriverLog::with('item')->where('user_id', $id)->latest()->get();
        $driverSuspensions = DriverSuspensionRecord::where('user_id', $id)->latest()->get();

        $categories = \App\Models\TrainingCategory::with(['tests' => function($query) {
            $query->where('status', 'Active')->orderBy('name');
        }])->orderBy('name')->get();
        $userAttempts = \App\Models\TrainingAttempt::where('employee_id', $id)->get();

        return view('admin.employee.edit', compact(
            'employee', 'roles', 'territories', 'maskTypes', 'maskFitTestRecords',
            'driverLogItems', 'driverLogs', 'driverSuspensions', 'categories', 'userAttempts'
        ));
    }

    public function update(Request $request, $id)
    {
        $employee = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'role' => 'required|exists:roles,name',
            'staff_type' => 'nullable|in:leader,technician,corporate',
            'territory_id' => 'nullable|exists:territories,id',

            'active' => 'required|boolean',
            'schedulable' => 'required|boolean',
            'employee_type' => 'required|boolean',

            'cell_phone' => 'required|digits:10',
            'hourly_rate' => 'required|numeric|min:0',
            'overtime_rate' => 'required|numeric|min:0',

            'training_level' => 'required|in:Trainee,Level I,Level II,Level III,Level IV',

            'biological_response_team' => 'required|boolean',
            'healthcare_team' => 'required|boolean',
            'driver_trained' => 'required|boolean',
            'floor_certified' => 'required|boolean',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update basic fields
        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'staff_type' => $validated['staff_type'] ?? $employee->staff_type,
            'territory_id' => $validated['territory_id'] ?? $employee->territory_id,

             'active' => $validated['active'],
            'schedulable' => $validated['schedulable'],
            'employee_type' => $validated['employee_type'],

            'cell_phone' => $validated['cell_phone'],
            'hourly_rate' => $validated['hourly_rate'],
            'overtime_rate' => $validated['overtime_rate'],

            'training_level' => $validated['training_level'],

            'biological_response_team' => $validated['biological_response_team'],
            'healthcare_team' => $validated['healthcare_team'],
            'driver_trained' => $validated['driver_trained'],
            'floor_certified' => $validated['floor_certified'],
        ];

        // if ($request->hasFile('profile_image')) {
        //     if ($employee->profile_image) {
        //         Storage::disk('public')->delete($employee->profile_image);
        //     }
        //     $updateData['profile_image'] = $request->file('profile_image')->store('profiles', 'public');
        // }
        if ($request->hasFile('profile_image')) {
            // New photo uploaded — delete old one and store new
            if ($employee->profile_image) {
                Storage::disk('public')->delete($employee->profile_image);
            }
            $updateData['profile_image'] = $request->file('profile_image')->store('profiles', 'public');

        } elseif ($request->input('remove_profile_image') == '1') {
            // User clicked Remove Photo — delete old and set null
            if ($employee->profile_image) {
                Storage::disk('public')->delete($employee->profile_image);
            }
            $updateData['profile_image'] = null;
        }

        $employee->update($updateData);

        if (!empty($validated['password'])) {
            $employee->update(['password' => Hash::make($validated['password'])]);
        }

        $employee->syncRoles([$validated['role']]);

        return response()->json([
            'status' => true,
            'message' => 'Employee updated successfully.',
        ]);
    }

    public function storeMaskFitTest(Request $request, $id)
    {
        $employee = User::findOrFail($id);

        $validated = $request->validate([
            'fit_test_date' => 'required|date',
            'mask_type_id'  => 'required|exists:mask_types,id',
        ]);

        $record = MaskFitTestRecord::create([
            'user_id'       => $employee->id,
            'fit_test_date' => $validated['fit_test_date'],
            'mask_type_id'  => $validated['mask_type_id'],
        ]);

        $record->load('maskType');

        return response()->json([
            'status'  => true,
            'message' => 'Mask fit test record added successfully.',
        ]);
    }

    public function storeDriverLog(Request $request, $id)
    {
        $employee = User::findOrFail($id);

        $validated = $request->validate([
            'driver_log_item_id' => 'required|exists:driver_log_items,id',
            'log_date' => 'required|date',
        ]);

        DriverLog::create([
            'user_id' => $employee->id,
            'driver_log_item_id' => $validated['driver_log_item_id'],
            'log_date' => $validated['log_date'],
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Driver log added successfully.',
        ]);
    }

    public function storeDriverSuspension(Request $request, $id)
    {
        $employee = User::findOrFail($id);

        $validated = $request->validate([
            'suspended_until' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        DriverSuspensionRecord::create([
            'user_id' => $employee->id,
            'suspended_until' => $validated['suspended_until'],
            'notes' => $validated['notes'] ?? null,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Driver suspension record added successfully.',
        ]);
    }

    /**
     * Display a listing of driver reports.
     */
    public function driverReport()
    {
        $users = User::orderBy('name')->get();
        
        $drivers = $users->filter(function ($user) {
            return $user->isDriverTrained();
        });

        return view('admin.hr.driver-report.index', compact('drivers'));
    }

    /**
     * Update the driver report fields for the specified user.
     */
    public function updateDriverReport(Request $request, $userId)
    {
        $request->validate([
            'status' => 'nullable|string|max:255',
            'points' => 'nullable|string|max:255',
        ]);

        $user = User::findOrFail($userId);

        if (!$user->isDriverTrained()) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Selected user is not a driver.'], 422);
            }
            return redirect()->back()->with('error', 'Selected user is not a driver.');
        }

        $user->update([
            'driver_status' => $request->status,
            'driver_points' => $request->points,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'message' => 'Driver report updated successfully!',
                'user' => $user
            ]);
        }

        return redirect()->back()->with('success', 'Driver report updated successfully!');
    }

    /**
     * Display the employee work report page with monthly payroll statistics.
     */
    public function workReport(Request $request)
    {
        $selectedMonth = $request->input('month', now()->format('Y-m'));
        $monthDate = \Carbon\Carbon::parse($selectedMonth . '-01');
        $startOfMonth = $monthDate->copy()->startOfMonth();
        $endOfMonth = $monthDate->copy()->endOfMonth();

        // 4 weekly ranges definition for columns
        $w1Start = $startOfMonth->copy();
        $w1End = $startOfMonth->copy()->addDays(6)->endOfDay();

        $w2Start = $startOfMonth->copy()->addDays(7)->startOfDay();
        $w2End = $startOfMonth->copy()->addDays(13)->endOfDay();

        $w3Start = $startOfMonth->copy()->addDays(14)->startOfDay();
        $w3End = $startOfMonth->copy()->addDays(20)->endOfDay();

        $w4Start = $startOfMonth->copy()->addDays(21)->startOfDay();
        $w4End = $endOfMonth->copy()->endOfDay();

        $employees = User::withoutRole('customer')->orderBy('name')->get();

        $reportData = [];

        foreach ($employees as $employee) {
            $userId = $employee->id;
            $hourlyRate = $employee->hourly_rate ?? 0;
            $overtimeRate = $employee->overtime_rate ?? 0;

            // Fetch all slot assignments for this employee in the weeks spanned by the month
            $extendedStart = $startOfMonth->copy()->startOfWeek();
            $extendedEnd = $endOfMonth->copy()->endOfWeek();

            $allStaffSlots = \App\Models\ServiceOrderSlotStaff::where('user_id', $userId)
                ->whereHas('slot', function ($q) use ($extendedStart, $extendedEnd) {
                    $q->whereBetween('scheduled_start_time', [$extendedStart, $extendedEnd]);
                })
                ->with(['slot.clocks'])
                ->get()
                ->map(fn($s) => $s->slot)
                ->filter()
                ->sortBy('scheduled_start_time')
                ->values();

            // Group slots by ISO week
            $slotsByWeek = [];
            foreach ($allStaffSlots as $s) {
                $weekKey = \Carbon\Carbon::parse($s->scheduled_start_time)->format('o-W');
                $slotsByWeek[$weekKey][] = $s;
            }

            $w1Actual = 0;
            $w2Actual = 0;
            $w3Actual = 0;
            $w4Actual = 0;

            $totalRegular = 0;
            $totalOvertime = 0;

            foreach ($slotsByWeek as $weekKey => $weekSlots) {
                $priorWorkedHours = 0;
                
                $firstSlotOfWeek = reset($weekSlots);
                $firstSlotDate = \Carbon\Carbon::parse($firstSlotOfWeek->scheduled_start_time)->toDateString();
                
                $availability = \App\Models\EmployeeAvailability::where('user_id', $userId)
                    ->where('start_date', '<=', $firstSlotDate)
                    ->where('end_date', '>=', $firstSlotDate)
                    ->first();
                    
                $maxHoursLimit = $availability ? $availability->max_hours : 40;
                if ($maxHoursLimit <= 0) {
                    $maxHoursLimit = 40;
                }

                foreach ($weekSlots as $slot) {
                    $slotTime = \Carbon\Carbon::parse($slot->scheduled_start_time);

                    // Calculate actual worked hours for this slot
                    $slotActualHours = 0;
                    if ($slot->clocks->isNotEmpty()) {
                        foreach ($slot->clocks as $clock) {
                            $slotActualHours += $clock->clocked_hours ?? $clock->calculateHours();
                        }
                    }

                    // Split slot actual hours into regular and overtime
                    $slotRegular = 0;
                    $slotOvertime = 0;

                    if ($priorWorkedHours >= $maxHoursLimit) {
                        $slotRegular = 0;
                        $slotOvertime = $slotActualHours;
                    } else {
                        $remainingRegular = $maxHoursLimit - $priorWorkedHours;
                        if ($slotActualHours <= $remainingRegular) {
                            $slotRegular = $slotActualHours;
                            $slotOvertime = 0;
                        } else {
                            $slotRegular = $remainingRegular;
                            $slotOvertime = $slotActualHours - $remainingRegular;
                        }
                    }

                    // Accumulate weekly hours
                    $priorWorkedHours += $slotActualHours;

                    // Only count totals if the slot is within the selected month
                    if ($slotTime->between($startOfMonth, $endOfMonth)) {
                        $totalRegular += $slotRegular;
                        $totalOvertime += $slotOvertime;

                        if ($slotTime->between($w1Start, $w1End)) {
                            $w1Actual += $slotActualHours;
                        } elseif ($slotTime->between($w2Start, $w2End)) {
                            $w2Actual += $slotActualHours;
                        } elseif ($slotTime->between($w3Start, $w3End)) {
                            $w3Actual += $slotActualHours;
                        } elseif ($slotTime->between($w4Start, $w4End)) {
                            $w4Actual += $slotActualHours;
                        }
                    }
                }
            }

            // Calculations
            $regularPay = $totalRegular * $hourlyRate;
            $overtimePay = $totalOvertime * $overtimeRate;
            $totalMonthlyPay = $regularPay + $overtimePay;

            $monthDateStr = $monthDate->toDateString();
            $monthAvailability = \App\Models\EmployeeAvailability::where('user_id', $employee->id)
                ->where('start_date', '<=', $monthDateStr)
                ->where('end_date', '>=', $monthDateStr)
                ->first();
            $maxHours = $monthAvailability ? $monthAvailability->max_hours : 40;
            if ($maxHours <= 0) {
                $maxHours = 40;
            }

            $reportData[] = [
                'employee' => $employee,
                'name' => $employee->name,
                'w1Actual' => $w1Actual,
                'w2Actual' => $w2Actual,
                'w3Actual' => $w3Actual,
                'w4Actual' => $w4Actual,
                'totalRegular' => $totalRegular,
                'totalOvertime' => $totalOvertime,
                'regularPay' => $regularPay,
                'overtimePay' => $overtimePay,
                'totalMonthlyPay' => $totalMonthlyPay,
                'maxHours' => $maxHours,
            ];
        }

        return view('admin.hr.work-report.index', compact('reportData', 'selectedMonth', 'monthDate'));
    }

    public function storeAvailability(Request $request, $id)
    {
        $employee = User::findOrFail($id);

        $validated = $request->validate([
            'availability_id' => 'nullable|integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'avg_hours' => 'required|integer|min:0',
            'max_hours' => 'required|integer|min:0',
            'mon_start' => 'required|date_format:H:i',
            'mon_end' => 'required|date_format:H:i',
            'tue_start' => 'required|date_format:H:i',
            'tue_end' => 'required|date_format:H:i',
            'wed_start' => 'required|date_format:H:i',
            'wed_end' => 'required|date_format:H:i',
            'thu_start' => 'required|date_format:H:i',
            'thu_end' => 'required|date_format:H:i',
            'fri_start' => 'required|date_format:H:i',
            'fri_end' => 'required|date_format:H:i',
            'sat_start' => 'required|date_format:H:i',
            'sat_end' => 'required|date_format:H:i',
            'sun_start' => 'required|date_format:H:i',
            'sun_end' => 'required|date_format:H:i',
        ]);

        if (!empty($validated['availability_id'])) {
            $availability = \App\Models\EmployeeAvailability::where('user_id', $employee->id)
                ->findOrFail($validated['availability_id']);
            $availability->update($validated);
            $message = 'Availability record updated successfully.';
        } else {
            $availability = $employee->availabilities()->create($validated);
            $message = 'Availability record created successfully.';
        }

        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $availability,
        ]);
    }

    public function workforceCoverage(Request $request)
    {
        // Parse date from request or default to now
        $selectedDate = $request->filled('date') ? \Carbon\Carbon::parse($request->date)->startOfMonth() : now()->startOfMonth();
        $startOfMonth = $selectedDate->copy()->startOfMonth()->toDateString();
        $endOfMonth = $selectedDate->copy()->endOfMonth()->toDateString();

        $employees = User::withoutRole('customer')
            ->with(['availabilities' => function ($query) use ($startOfMonth, $endOfMonth) {
                $query->where('start_date', '<=', $endOfMonth)
                      ->where('end_date', '>=', $startOfMonth)
                      ->orderBy('start_date', 'desc');
            }])->get();

        $coverage = array_fill_keys(
            ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'], 
            array_fill(0, 24, [])
        );

        foreach ($employees as $employee) {
            $availability = $employee->availabilities->first();
            if (!$availability) continue;

            $name = $employee->name;

            foreach ($coverage as $day => &$hoursArray) {
                $startTime = $availability->{$day . '_start'};
                $endTime = $availability->{$day . '_end'};

                if ($startTime && $endTime) {
                    $startHour = (int) substr($startTime, 0, 2);
                    $endHour = (int) substr($endTime, 0, 2);
                    
                    $endHourLimit = $endHour;
                    // Check if it ends exactly on the hour (e.g. 17:00:00)
                    if (substr($endTime, 3, 2) === '00' && substr($endTime, 6, 2) === '00') {
                        $endHourLimit = $endHour - 1;
                    }
                    
                    $timeString = substr($startTime, 0, 5) . ' - ' . substr($endTime, 0, 5);
                    $employeeData = ['name' => $name, 'time' => $timeString];
                    
                    if ($startTime <= $endTime) {
                        for ($h = $startHour; $h <= $endHourLimit; $h++) {
                            $hoursArray[$h][] = $employeeData;
                        }
                    } else {
                        // Overnight shift
                        for ($h = $startHour; $h <= 23; $h++) {
                            $hoursArray[$h][] = $employeeData;
                        }
                        for ($h = 0; $h <= $endHourLimit; $h++) {
                            $hoursArray[$h][] = $employeeData;
                        }
                    }
                }
            }
        }
        unset($hoursArray); // break reference

        return view('admin.operations.workforce-coverage', compact('coverage', 'selectedDate'));
    }
}
