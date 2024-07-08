<?php

namespace App\Http\Controllers\Institutional;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class RoleController extends Controller
{

    public function index()
    {
        $roles = Role::where('parent_id', auth()->user()->parent_id ?? auth()->user()->id)->get();
        return view('client.panel.roles.index', compact('roles'));
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
            "GetReceivedOffers"
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
            "UpdateOffer",
            "GetOffers"
        ];

        $filteredPermissions  = $permissions;

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



        $specialPermissionKeys = [
            'ChangePassword',
            'EditProfile',
            'ViewDashboard',
            'ShowCartOrders',
            'GetMyCollection',
            'GetMyEarnings',
            'neighborView',
            'GetOrders',
            'GetReceivedOffers',
            'GetGivenOffers',
            'GetSwapApplications',
            'MyReservations',
            'Reservations',
            'Orders'
        ];

        // Veritabanından bu özel izinlerin ID'lerini alın
        $specialPermissionIDs = Permission::whereIn('key', $specialPermissionKeys)
            ->pluck('id') // Sadece ID'leri alın
            ->toArray();

        // Görünümü gruplanmış izinlerle döndürün
        return view('client.panel.roles.create', compact('groupedPermissions', 'specialPermissionIDs'));
    }


    public function edit($hashedId)
    {
        $roleId = decode_id($hashedId);

        $user = User::where('id', auth()->user()->parent_id ?? auth()->user()->id)->first();
        $role = Role::where('id', $roleId)->with('rolePermissions.permissions')->first();
        $mainRole = Role::where('id', '2')->with('rolePermissions.permissions')->first();
        $permissions = $mainRole->rolePermissions->pluck('permissions')->flatten();

        $specialPermissions = [
            'Projects',
            'CreateProject',
            'GetProjects',
            'DeleteProject',
            'UpdateProject',
            "GetReceivedOffers",
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
            "UpdateOffer",
            "GetOffers"
        ];

        $filteredPermissions  = $permissions;


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



        $specialPermissionKeys = [
            'ChangePassword',
            'EditProfile',
            'ViewDashboard',
            'ShowCartOrders',
            'GetMyCollection',
            'GetMyEarnings',
            'neighborView',
            'GetOrders',
            'GetReceivedOffers',
            'GetGivenOffers',
            'GetSwapApplications',
            'MyReservations',
            'Reservations',
            'Orders'
        ];

        // Veritabanından bu özel izinlerin ID'lerini alın
        $specialPermissionIDs = Permission::whereIn('key', $specialPermissionKeys)
            ->pluck('id') // Sadece ID'leri alın
            ->toArray();



        return view('client.panel.roles.edit', compact('role', 'groupedPermissions', 'specialPermissionIDs'));
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

    public function update(UpdateRoleRequest $request, $hashedId)
    {
        $roleId = decode_id($hashedId);

        $permissions = $request->input('permissions');
        $role = Role::where("id", $roleId)->first();

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

    public function destroy( $hashedId)
    {
        $roleId = decode_id($hashedId);
        $role = Role::where("id", $roleId)->first();

        $role->delete();
        return redirect()->route('institutional.roles.index')->with('success', 'Role deleted successfully');
    }
}
