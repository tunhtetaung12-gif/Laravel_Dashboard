<?php

namespace App\Repositories\User;

use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public function index()
    {
        return User::with('roles')->get();
    }

    public function find($id)
    {
        return User::find($id);
    }

    //Multiple role
    // public function create($data)
    // {
    //     $user = User::create($data);

    //     if (isset($data['roles'])) {
    //         $user->syncRoles($data['roles']);
    //     }

    //     return $user;
    // }

    // public function update($user, $data)
    // {
    //     $user->update($data);

    //     if (isset($data['roles'])) {
    //         $user->syncRoles($data['roles']);
    //     } else {
    //         $user->syncRoles([]);
    //     }
    // }

    //Single role
    public function create($data)
    {
        $user = User::create($data);

        if (isset($data['roles'])) {
            $user->syncRoles($data['roles']);
        }

        return $user;
    }

    public function update($user, $data)
    {
        $user->update($data);

        if (isset($data['roles'])) {
            $user->syncRoles($data['roles']);
        } else {
            $user->syncRoles([]);
        }
    }


    public function delete($id)
    {
        $user = User::find($id);
        return $user->delete();
    }
}
