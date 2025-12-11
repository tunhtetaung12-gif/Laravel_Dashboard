@extends('layouts.dashboard')

@section('title', 'Roles')
@section('page-title', 'Roles Management')

@section('content')
    <div class="container">
        <!-- Add Role Button -->
        <a href="{{ route('roles.create') }}" class="btn btn-primary mb-3">
            <i class="bi bi-plus-circle"></i> Add Role
        </a>

        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Roles Table -->
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Role Name</th>
                    <th>Permissions</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $role)
                    <tr>
                        <td>{{ $role->id }}</td>
                        <td>{{ $role->name }}</td>
                        <td>
                            @if ($role->permissions->count() > 0)
                                @foreach ($role->permissions as $permission)
                                    <span class="badge bg-info text-dark">{{ $permission->name }}</span>
                                @endforeach
                            @else
                                <span class="text-muted">No Permissions</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-sm btn-outline-warning">Edit</a>
                            <form action="{{ route('roles.destroy', $role->id) }}" method="POST"
                                style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"
                                    onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>


    </div>
@endsection
