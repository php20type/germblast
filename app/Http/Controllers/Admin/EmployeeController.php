<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Territory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', '!=', 'client');

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

        return view('admin.employee.edit', compact('employee', 'roles', 'territories'));
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
        ]);

        // Update basic fields
        $employee->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'staff_type' => $validated['staff_type'] ?? $employee->staff_type,
            'territory_id' => $validated['territory_id'] ?? $employee->territory_id,
        ]);

        if (!empty($validated['password'])) {
            $employee->update(['password' => Hash::make($validated['password'])]);
        }

        $employee->syncRoles([$validated['role']]);

        return response()->json([
            'status' => true,
            'message' => 'Employee updated successfully.',
        ]);
    }
}
