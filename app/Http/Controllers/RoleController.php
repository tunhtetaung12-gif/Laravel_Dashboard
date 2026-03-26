<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Requests\RoleUpdateRequest;
use Spatie\Permission\Models\Permission;


use App\Repositories\Role\RoleRepositoryInterface;
use App\Repositories\Permission\PermissionRepositoryInterface;

class RoleController extends Controller
{
    protected $roleRepository;
    protected $permissionRepository;

    public function __construct(RoleRepositoryInterface $roleRepository, PermissionRepositoryInterface $permissionRepository)
    {
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
    }

    public function index()
    {
        $roles = $this->roleRepository->all();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $data = $request->validate([
            'name' => 'required|string|unique:roles,name',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $this->roleRepository->store($data);

        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }


    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();

        return view('roles.edit', compact('role', 'permissions'));
    }


    // public function updatePermissions(Request $request, Role $role)
    // {
    //     $request->validate([
    //         'permissions' => 'array',
    //         'permissions.*' => 'exists:permissions,id',
    //     ]);

    //     $permissions = Permission::whereIn('id', $request->permissions ?? [])->get();
    //     $role->syncPermissions($permissions);

    //     return redirect()->back()->with('success', 'Permissions updated successfully.');
    // }

    public function update(RoleUpdateRequest $request, $id)
    {
        $validatedData = $request->validated();

        $this->roleRepository->update($validatedData, $id);

        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }


    public function destroy($id)
    {
        $this->roleRepository->delete($id);

        return redirect()->route('roles.index')->with('success', 'Role deleted successfully');
    }
}
