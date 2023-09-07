<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RolePermission;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    public function store(Request $request)
    {
        RolePermission::create($request->all());
        return response()->json([
            'message' => 'Role Permission created successfully',
            'status' => 201,
            'success' => true,
        ], 201);
    }

    public function destroy(Request $request)
    {
        $rolePermission = RolePermission::where("role_id", $request->role_id)->where("permission_id", $request->permission_id)->first();
        $rolePermission->delete();
        return response()->json([
            'message' => 'Role Permission group deleted successfully',
            'status' => 204,
            'success' => true,
        ], 200);
    }
}
