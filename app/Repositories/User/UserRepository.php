<?php

namespace App\Repositories\User;

use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public function index()
    {
        return User::get();
    }

    public function find($id)
    {
        return User::find($id);
    }

    public function create($data)
    {
        return User::create($data);
    }

    public function update($user,$data)
    {
        return $user->update($data);
    }

    public function delete($id)
    {
        $user = User::find($id);
        return $user->delete();
    }
}
