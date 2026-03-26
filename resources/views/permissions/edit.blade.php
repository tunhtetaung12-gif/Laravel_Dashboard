@extends('layouts.dashboard')

@section('content')
@section('page-title', 'Edit Role')

<div class="container">
    <h3>Edit Role</h3>

    <form action="{{ route('roles.update', $role->id) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Role Name</label>
            <input type="text" name="name" value="{{ old('name', $role->name) }}" class="form-control">
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <!-- Permissions Checkboxes -->
        <div class="mb-3">
            <label class="form-label">Assign Permissions</label>
            @foreach($permissions as $permission)
                <div class="form-check">
                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                        class="form-check-input" id="perm_{{ $permission->id }}"
                        {{ $role->permissions->contains('id', $permission->id) ? 'checked' : '' }}>
                    <label class="form-check-label" for="perm_{{ $permission->id }}">
                        {{ $permission->name }}
                    </label>
                </div>
            @endforeach
        </div>

        <button class="btn btn-success">Update</button>
        <a href="{{ route('roles.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
