<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = User::where('role', '!=', 'client')
            ->orderBy('name')
            ->get();

        $employeesCount = $employees->count();

        return view('admin.employee.index', compact(
            'employees',
            'employeesCount'
        ));
    }

    public function create()
    {
        $roles = Role::all();

        return view('admin.employee.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => 'required|exists:roles,name',
        ]);

        // Create employee
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),

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
        $roles = Role::all();

        return view('admin.employee.edit', compact('employee', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $employee = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|exists:roles,name',
        ]);

        // Update basic fields
        $employee->update([
            'name' => $validated['name'],
            'role' => $validated['role'],
        ]);

        $employee->syncRoles([$validated['role']]);

        return response()->json([
            'status' => true,
            'message' => 'Employee updated successfully.',
        ]);
    }
}
