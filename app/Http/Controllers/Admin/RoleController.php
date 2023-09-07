<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use Dotenv\Validator;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::where("is_active", "1")->get(); // İzinleri veritabanından alın

        return view('admin.roles.create', compact('permissions'));
    }

    public function edit(Role $role)
    {
        $role = Role::where("id", $role->id)->with("rolePermissions.permissions")->first();
        $permissions = Permission::where("is_active", "1")->get(); // İzinleri veritabanından alın
        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    public function store(CreateRoleRequest $request)
    {
        $permissions = $request->input('permissions');

        $role = Role::create([
            'name' => $request->input('name'),
        ]);

        if (!empty($permissions)) {
            foreach ($permissions as $permissionId) {
                RolePermission::create([
                    "role_id" => $role->id,
                    "permission_id" => $permissionId,
                ]);
            }
        }

        return redirect()->route('admin.roles.index')->with('success', 'Role created successfully');
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        $permissions = $request->input('permissions');

        $role->update([
            'name' => $request->input('name'),
        ]);

        RolePermission::where('role_id', $role->id)->delete();

        if (!empty($permissions)) {
            foreach ($permissions as $permissionId) {
                RolePermission::create([
                    "role_id" => $role->id,
                    "permission_id" => $permissionId,
                ]);
            }
        }

        return redirect()->route('admin.roles.index')->with('success', 'Role updated successfully');
    }
    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('admin.roles.index')->with('success', 'Role deleted successfully');
    }

    public function bulkDelete(FacadesRequest $request)
    {
        $roleIds = $request->input('role_ids');

        // Seçilen rolleri silme işlemi
        Role::whereIn('id', $roleIds)->delete();

        return response()->json(['message' => 'Roles deleted successfully']);
    }

}
