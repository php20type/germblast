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

class EmployeeController extends Controller
{
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

        return view('admin.employee.edit', compact('employee', 'roles', 'territories','maskTypes','maskFitTestRecords','driverLogItems','driverLogs','driverSuspensions'));
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

            'training_level' => $validated['training_level'],

            'biological_response_team' => $validated['biological_response_team'],
            'healthcare_team' => $validated['healthcare_team'],
            'driver_trained' => $validated['driver_trained'],
            'floor_certified' => $validated['floor_certified'],
        ];

        if ($request->hasFile('profile_image')) {
            if ($employee->profile_image) {
                Storage::disk('public')->delete($employee->profile_image);
            }
            $updateData['profile_image'] = $request->file('profile_image')->store('profiles', 'public');
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
}
