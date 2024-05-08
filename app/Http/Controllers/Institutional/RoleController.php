<?php

namespace App\Http\Controllers\Institutional;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{

    public function index()
    {
        $roles = Role::where("parent_id", auth()->user()->parent_id ?? auth()->user()->id)->get();
        return view('institutional.roles.index', compact('roles'));
    }

    public function create()
    {
        // Şu anki kullanıcının verilerini alın
        $user = User::where("id", Auth::user()->id)->first();
        
        // Role ve izinleri çekin
        $role = Role::where("id", "2")->with("rolePermissions.permissions")->first();
        $permissions = $role->rolePermissions->pluck('permissions')->flatten();
    
        // $permissions'u bir diziye dönüştürün
        $permissionsArray = $permissions->toArray();
    
        // Kullanıcının corporate_type'ı 'Emlak Ofisi' ise, belirli izinleri çıkarın
        if ($user->corporate_type == 'Emlak Ofisi') {
            $permissionsArray = array_diff($permissionsArray, ['Projects', "CreateProject", "GetProjects", "DeleteProject", "UpdateProject"]);
        }
    
        // Dizi ile çalıştığımız için bunu tekrar bir Collection'a dönüştürün
        $groupedPermissions = collect($permissionsArray)->groupBy('permission_group_id');
    
        // Görünümde gruplandırılmış izinlerle birlikte dön
        return view('institutional.roles.create', compact('groupedPermissions'));
    }
    

    public function edit(Role $role)
    {
        $role = Role::where("id", $role->id)->with("rolePermissions.permissions")->first();
        $mainRole = Role::where("id", "2")->with("rolePermissions.permissions")->first();
        $permissions = $mainRole->rolePermissions->pluck('permissions')->flatten();
         $groupedPermissions = $permissions->groupBy('permission_group_id');
        return view('institutional.roles.edit', compact('role', 'groupedPermissions'));
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

        return redirect()->route('institutional.roles.index')->with('success', 'Role created successfully');
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

        return redirect()->route('institutional.roles.index')->with('success', 'Role updated successfully');
    }
    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('institutional.roles.index')->with('success', 'Role deleted successfully');
    }
}
