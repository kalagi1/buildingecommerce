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
        $roles = Role::where('parent_id', auth()->user()->parent_id ?? auth()->user()->id)->get();
        return view('institutional.roles.index', compact('roles'));
    }

    public function create()
    {
        $user = User::where('id', auth()->user()->parent_id ?? auth()->user()->id)->first();
        $role = Role::where('id', '2')->with('rolePermissions.permissions')->first();
        $permissions = $role->rolePermissions->pluck('permissions')->flatten();

        $specialPermissions = [
            'Projects',
            'CreateProject',
            'GetProjects',
            'DeleteProject',
            'UpdateProject',
            'GetProjectById',
        ];

        $reservationPermissions = [
            'Reservations',
            'CreateReservation',
            'GetReservations',
            'DeleteReservation',
            'UpdateReservation',
            'GetReservationById',
        ];

        $offerPermissions = [
            "Offers",
            "CreateOffer",
            "Offers",
            "DeleteOffer",
            "GetOfferById",
            "UpdateOffer"
        ];

        // Başlangıçta orijinal izinleri kullanarak bir kopya oluşturun
        if ($user->corporate_type == 'Emlak Ofisi') {

            $filteredPermissions = $permissions->reject(function ($permission) use ($specialPermissions) {
                return in_array($permission->key, $specialPermissions);
            });
        }

        // Eğer 'Turizm Amaçlı Kiralama' değilse, 'reservationPermissions'ı çıkartın
        if ($user->corporate_type !== 'Turizm Amaçlı Kiralama') {
            $filteredPermissions = $filteredPermissions->reject(function ($permission) use ($reservationPermissions) {
                return in_array($permission->key, $reservationPermissions);
            });
        }


        if ($user->corporate_type !== 'İnşaat Ofisi') {
            $filteredPermissions = $filteredPermissions->reject(function ($permission) use ($offerPermissions) {
                return in_array($permission->key, $offerPermissions);
            });
        }

        // İzinleri 'permission_group_id' ile gruplayın
        $groupedPermissions = $filteredPermissions->groupBy('permission_group_id');

        // Görünümü gruplanmış izinlerle döndürün
        return view('institutional.roles.create', compact('groupedPermissions'));
    }


    public function edit(Role $role)
    {
        $role = Role::where('id', $role->id)->with('rolePermissions.permissions')->first();
        $mainRole = Role::where('id', '2')->with('rolePermissions.permissions')->first();
        $permissions = $mainRole->rolePermissions->pluck('permissions')->flatten();
        $groupedPermissions = $permissions->groupBy('permission_group_id');
        return view('institutional.roles.edit', compact('role', 'groupedPermissions'));
    }

    public function store(CreateRoleRequest $request)
    {
        $permissions = $request->input('permissions');

        $role = Role::create([
            'name' => $request->input('name'),
            'parent_id' => auth()->user()->parent_id ?? auth()->user()->id,
        ]);

        if (!empty($permissions)) {
            foreach ($permissions as $permissionId) {
                RolePermission::create([
                    'role_id' => $role->id,
                    'permission_id' => $permissionId
                ]);
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
                    'role_id' => $role->id,
                    'permission_id' => $permissionId,
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
