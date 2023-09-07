<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Role;
use Illuminate\Support\Facades\Request as FacadesRequest;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        return view('admin.roles.create');
    }

    public function store(CreateRoleRequest $request)
    {
        Role::create([
            'name' => $request->input('name'),
        ]);

        return redirect()->route('admin.roles.index')->with('success', 'Role created successfully');
    }

    public function edit(Role $role)
    {
        return view('admin.roles.edit', compact('role'));
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {

        $role->update([
            'name' => $request->input('name'),
        ]);

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
