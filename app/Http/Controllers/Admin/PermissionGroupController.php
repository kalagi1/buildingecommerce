<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePermissionGroupRequest;
use App\Http\Requests\UpdatePermissionGroupRequest;
use App\Models\Permission;
use App\Models\PermissionGroup;
use Illuminate\View\View;

class PermissionGroupController extends Controller
{
    public function index(): View
    {
        $permissionGroups = PermissionGroup::with('permissions')->get();
        return view('admin.permission_groups.index', compact('permissionGroups'));
    }

    public function create(): View
    {
        return view('admin.permission_groups.create');
    }

    public function store(CreatePermissionGroupRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['is_active'] = $request->has('is_active') ? 1 : 0; // Set is_active to 1 if it exists, otherwise set to 0
        $group = PermissionGroup::create($validatedData);
        $permissionKeys = [
            'Get[key]', 'Create[key]', 'Get[key]ById', 'Update[key]', 'Delete[key]', '[key]',
        ];
        foreach ($permissionKeys as $i => $key) {
            $value = str_replace('[key]', $group->name, $key);
            if ($i == 0 || $i == 5) {
                if (substr($group->name, -1) == "s") {
                    $value .= "es";
                } elseif (substr($group->name, -1) == "y") {
                    $value = rtrim($value, "y");
                    $value .= "ies";
                } else {
                    $value .= "s";
                }
            }
            Permission::create([
                'key' => $value,
                'description' => '',
                'permission_group_id' => $group->id,
                'title' => "",
                'is_active' => true,
            ]);
        }
        return redirect()->route('admin.permission_groups.index')->with('success', 'Permission group created successfully.');
    }

    public function edit(PermissionGroup $permissionGroup): View
    {
        return view('admin.permission_groups.edit', compact('permissionGroup'));
    }

    public function update(UpdatePermissionGroupRequest $request, PermissionGroup $permissionGroup)
    {
        $validatedData = $request->validated();
        $validatedData['is_active'] = $request->has('is_active') ? 1 : 0; // Set is_active to 1 if it exists, otherwise set to 0
        $permissionGroup->update($validatedData);
        $permissionKeys = [
            'Get[key]', 'Create[key]', 'Get[key]ById', 'Update[key]', 'Delete[key]', "[key]",
        ];

        $permissions = Permission::where("permission_group_id", $permissionGroup->id)->get();

        foreach ($permissions as $i => $permission) {
            $value = str_replace('[key]', $permissionGroup->name, $permissionKeys[$i]);

            if ($i == 0 || $i == 5) {
                if (substr($permission->name, -1) == "s") {
                    $value .= "es";
                } elseif (substr($permission->name, -1) == "y") {
                    $value = rtrim($value, "y");
                    $value .= "ies";
                } else {
                    $value .= "s";
                }
            }

            $permission->update([
                'key' => $value,
                'description' => '',
                'permission_group_id' => $permissionGroup->id,
                'is_active' => true,
            ]);
        }
        return redirect()->route('admin.permission_groups.index')->with('success', 'Permission group updated successfully.');
    }

    public function destroy(PermissionGroup $permissionGroup)
    {
        $permissionGroup->delete();
        return redirect()->route('admin.permission_groups.index')->with('success', 'Permission group deleted successfully.');
    }
}
