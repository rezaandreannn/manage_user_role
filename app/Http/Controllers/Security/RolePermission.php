<?php

namespace App\Http\Controllers\Security;

use App\Models\User;
use App\Helpers\AuthHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class RolePermission extends Controller
{
    public function index(Request $request)
    {
        $excludedRoles = ['super admin'];
        $roles = Role::whereNotIn('name', $excludedRoles)->get();

        $modulePermissions = Permission::where('type', 'module')->get();
        $locationPermissions = Permission::where('type', 'location')->get();
        $menuPermissions = Permission::where('type', 'menu')->get();
        $otherPermissions = Permission::where('type', 'other')->get();

        return view('role-permission.permissions', compact('roles', 'modulePermissions', 'locationPermissions', 'menuPermissions', 'otherPermissions'));
    }

    public function store(Request $request)
    {
        $roleId = $request->input('role_id');
        $permissionName = $request->input('permission_name');
        $checked = $request->input('action');

        $role = Role::where('name', $roleId)->first();

        $permission = Permission::where('name', $permissionName)->first();

        if ($role && $permission) {
            if ($checked == 'insert') {
                $role->givePermissionTo($permission);
            } else {
                $role->revokePermissionTo($permission);
            }

            $message = 'Permissions updated successfully';

            return response()->json(['message' => $message]);
        }

        return response()->json(['error' => 'Role or permission not found'], 404);
    }
}
