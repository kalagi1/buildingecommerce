<?php

namespace App\Http\Controllers\Api\Institutional;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Role;
use App\Models\User;
use App\Models\RolePermission;
use Illuminate\Support\Facades\Auth;
use App\Models\Permission;
use App\Models\PermissionGroup;

class RoleController extends Controller
{

    public function index()
    {
        $user = auth()->user();
        $userId = $user ? ($user->parent_id ?? $user->id) : null;
        $roles = Role::where("parent_id", $userId)->get();
        return response()->json(['roles' => $roles]);
    }

    public function create(){

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

        
        // Grup adlarını depolamak için boş bir dizi oluşturun
        $groupNames = [];

        // Her bir grup için grup adını alın
        foreach ($groupedPermissions as $groupId => $permissions) {
            // Grup adını almak için ilgili grup id'sini kullanarak veritabanından sorgulama yapın
            $groupName = PermissionGroup::where('id', $groupId)->value('desc');

            // Eğer grup adı bulunursa, diziye ekleyin
            if ($groupName) {
                $groupNames[] = $groupName;
            }
        }

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
        // $specialPermissionIDs = Permission::whereIn('key', $specialPermissionKeys)
        //     ->pluck('id') // Sadece ID'leri alın
        //     ->toArray();
    
        return response()->json([
            'groupNames' => $groupNames,
            'groupedPermissions' => $groupedPermissions,
            'filteredPermissions'    => $filteredPermissions,
            'specialPermissionKeys' => $specialPermissionKeys
        ]);
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

        $role = Role::create([
            'name' => $request->input('name'),
            "parent_id" => auth()->user()->parent_id ?? auth()->user()->id,
        ]);

        if (!empty($permissions)) {
            $permissions = array_merge($permissions, $specialPermissionIDs);
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
