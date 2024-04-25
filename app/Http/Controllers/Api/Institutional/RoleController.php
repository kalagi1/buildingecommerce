<?php

namespace App\Http\Controllers\Api\Institutional;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Role;
use App\Models\RolePermission;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{

    public function index()
    {
        $user = auth()->user();
        $userId = $user ? ($user->parent_id ?? $user->id) : null;
        $roles = Role::where("parent_id", $userId)->get();
        return response()->json(['roles' => $roles]);
    }

    public function create()
    {

        $role = Role::where("id", "2")->with("rolePermissions.permissions")->first();
        $permissions = $role->rolePermissions->pluck('permissions')->flatten();
        
        // İzinleri 'permission_group_id' değerine göre gruplayın
        $groupedPermissions = $permissions->groupBy('permission_group_id');
    
        return response()->json(['groupedPermissions' => $groupedPermissions]);
    }
    
    

    public function edit(Role $role)
    {
       
        $role = Role::where("id", $role->id)->with("rolePermissions.permissions")->first();
        $mainRole = Role::where("id", "2")->with("rolePermissions.permissions")->first();
        $permissions = $mainRole->rolePermissions->pluck('permissions')->flatten();
         $groupedPermissions = $permissions->groupBy('permission_group_id');
         return response()->json(['role' => $role, 'groupedPermissions' => $groupedPermissions]);
    }

    public function store(CreateRoleRequest $request)
    {
       
        $permissions = $request->input('permissions');

        $role = Role::create([
            'name' => $request->input('name'),
            "parent_id" => auth()->user()->parent_id ?? auth()->user()->id,
        ]);

        if (!empty($permissions)) {
            foreach ($permissions as $permissionId) {
                RolePermission::create([
                    "role_id" => $role->id,
                    "permission_id" => $permissionId]);
            }
        }

        return response()->json(['success' => true, 'message' => 'Role created successfully']);
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
        return response()->json(['success' => true, 'message' => 'Role updated successfully']);
        
    }
    public function destroy(Role $role)
    {   
        $role->delete();
        return response()->json(['success' => true, 'message' => 'Role deleted successfully']);
       
    }
}
