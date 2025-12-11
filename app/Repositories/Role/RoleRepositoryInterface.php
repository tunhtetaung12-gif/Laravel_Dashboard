<?php

namespace App\Repositories\Role;

use Illuminate\Http\Request;

interface RoleRepositoryInterface
{
    public function all();
    public function find($id);
    public function create($data);
    public function update($validatedData, $id);
    public function store($data);
    public function delete($id);
}
