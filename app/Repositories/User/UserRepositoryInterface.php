<?php

namespace App\Repositories\User;

use App\Models\User;

interface UserRepositoryInterface
{
    public function index();

    public function find($id);

    public function create($data);

    public function update($user,$data);

    public function delete($id);
}
