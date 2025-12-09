<?php

namespace App\Http\Controllers;

use App\Repositories\Role\RoleRepositoryInterface;

use Illuminate\Http\Request;

class RoleController extends Controller
{
    protected $roleRepository;

    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function index()
    {
        $roles = $this->roleRepository->all();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        return view('roles.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name'
        ]);

        $this->roleRepository->create($data);

        return redirect()->route('roles.index')->with('success', 'Role created successfully');
    }

    public function edit($id)
    {
        $role = $this->roleRepository->find($id);
        return view('roles.edit', compact('role'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $id
        ]);

        $this->roleRepository->update($id, $data);

        return redirect()->route('roles.index')->with('success', 'Role updated successfully');
    }

    public function destroy($id)
    {
        $this->roleRepository->delete($id);

        return redirect()->route('roles.index')->with('success', 'Role deleted successfully');
    }
}
