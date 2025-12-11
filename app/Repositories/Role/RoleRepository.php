<?php

namespace App\Repositories\Role;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;



class RoleRepository implements RoleRepositoryInterface
{
    public function all()
    {
        return Role::with('permissions')->orderBy('id')->get();
    }

    public function find($id)
    {
        return Role::find($id);
    }

    public function create($data)
    {
        return Role::create($data);
    }

    public function update($validatedData, $id)
    {
        // dd($id);
        $role = Role::find($id);
        // dd($role);
        $role->update(['name' => $validatedData['name']]);

        if (isset($validatedData['permissions'])) {
            $permissions = Permission::whereIn('id', $validatedData['permissions'])->get();
            $role->syncPermissions($permissions);
        }else{
            $role->syncPermissions([]);
        }
    }

    public function store( $data)
    {
        $role = Role::create(['name' => $data['name']]);
        if (isset($data['permissions'])) {
            $permissions = Permission::whereIn('id', $data['permissions'])->get();
            $role->syncPermissions($permissions);
        }

        return $role;
    }

    public function delete($id)
    {
        return Role::destroy($id);
    }
}
