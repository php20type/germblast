<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionController extends Controller
{
   public function index()
    {
        $roles = Role::with('permissions')->orderBy('name')->get();

        // Load grouped permissions from config
        $permissionGroups = collect(config('permission-groups'))
            ->map(function ($permissions) {
                return Permission::whereIn('name', $permissions)
                    ->orderBy('name')
                    ->get();
            });

        $rolePermissionMap   = config('role-permission-map');

        return view('admin.roles.permissions', compact(
            'roles',
            'permissionGroups',
            'rolePermissionMap'
        ));
    }

    public function update(Request $request)
    {
        $request->validate([
            'role_id'     => 'required|exists:roles,id',
            'permissions' => 'nullable|array',
        ]);

        $role = Role::findOrFail($request->role_id);

        // Sync permissions
        $role->syncPermissions($request->permissions ?? []);

        return redirect()
            ->back()
            ->with('success', 'Permissions updated successfully.');
    }
}
