<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Repositories\User\UserRepositoryInterface;
use Spatie\Permission\Models\Role;


class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function index()
    {
        // $users = User::get();
        $users = $this->userRepository->index();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    // public function store(UserRequest $request)
    // {
    //     $validatedData = $request->validated();

    //     if ($request->hasFile('image')) {
    //         $imageName = time() . '.' . $request->image->extension();

    //         $request->image->move(public_path('productImages'), $imageName);

    //         $validatedData = array_merge($validatedData, ['image' => $imageName]);
    //     }

    //     $validatedData['status'] = $request->has('status') ? true : false;

    //     // Hash password if it exists
    //     if (isset($validatedData['password'])) {
    //         $validatedData['password'] = bcrypt($validatedData['password']);
    //     }

    //     // User::create($validatedData);
    //     $this->userRepository->create($validatedData);
    //     return redirect()->route('users.index');
    // }

    public function store(UserRequest $request)
    {
        $validatedData = $request->validated();

        // Handle image upload
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('productImages'), $imageName);
            $validatedData['image'] = $imageName;
        }

        // Status
        $validatedData['status'] = $request->has('status') ? true : false;

        // Hash password
        if (isset($validatedData['password'])) {
            $validatedData['password'] = bcrypt($validatedData['password']);
        }

        // Create user
        $user = $this->userRepository->create($validatedData);

        // Sync roles if any
        // if ($request->has('roles')) {
        //     $user->syncRoles($request->roles);
        // }

        // Assign single role
        if ($request->role) {
            $user->syncRoles([$request->role]);
        }

        return redirect()->route('users.index');
    }


    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    // public function update(Request $request, User $user)
    // {
    //     $data = $request->validate([
    //         'name'  => 'required|string|max:255',
    //         'email' => 'required|email|max:255|unique:users,email,' . $user->id,
    //         'phone' => 'nullable|string|max:20',
    //         'address' => 'nullable|string|max:255',
    //         'gender' => 'nullable|string|max:10',
    //         'status' => 'nullable|boolean',
    //     ]);

    //     $data['status'] = $request->has('status') ? 1 : 0;

    //     $user->update($data);

    //     return redirect()->route('users.index')->with('success', 'User updated successfully.');
    // }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'gender' => 'nullable|string|max:10',
            'status' => 'nullable|boolean',
        ]);

        $data['status'] = $request->has('status') ? 1 : 0;

        // Update user
        $user->update($data);

        // Sync roles
        // if ($request->has('roles')) {
        //     $user->syncRoles($request->roles);
        // } else {
        //     $user->syncRoles([]);
        // }

        // Sync single role
        if ($request->role) {
            $user->syncRoles([$request->role]);
        } else {
            $user->syncRoles([]); 
        }

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }



    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function delete($id)
    {
        // $user = User::find($id);
        // $user->delete();
        $this->userRepository->delete($id);
        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully.');
    }
}
