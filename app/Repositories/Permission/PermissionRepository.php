<?php

namespace App\Repositories\Permission;

use Spatie\Permission\Models\Permission;

class PermissionRepository implements PermissionRepositoryInterface
{
    public function all()
    {
        return Permission::orderBy('id')->get();
    }

    public function find($id)
    {
        return Permission::find($id);
    }

    public function create($data)
    {
        $data['guard_name'] = 'web';
        return Permission::create($data);
    }

    public function update($id,$data)
    {
        $permission = $this->find($id);
        $permission->update($data);
        return $permission;
    }


    public function delete($id)
    {
        $permission = $this->find($id);
        return $permission->delete();
    }
}
