<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::where("parent_id", "4")->get();
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

        return redirect()->route('admin.roles.index')->with('success', 'Rol Başarıyla Oluşturuldu');
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

        return redirect()->route('admin.roles.index')->with('success', 'Rol Başarıyla Güncellendi');
    }
    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('admin.roles.index')->with('success', 'Rol Başarıyla Silindi');
    }

}
