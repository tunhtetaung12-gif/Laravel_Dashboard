@extends('layouts.dashboard')

@section('content')
@section('page-title', 'Roles Management')
<div class="container">
    <h3>Create Role</h3>

    <form action="{{ route('roles.store') }}" method="POST">
        @csrf

        <input type="hidden" name="guard_name" value="web">

        <div class="mb-3">
            <label class="form-label">Role Name</label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-control">
            @error('name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <!-- Permissions Checkboxes -->
        <div class="mb-3">
            <label class="form-label">Assign Permissions</label>
            <div class="form-check">
                @foreach ($permissions as $permission)
                    <div>
                        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                            class="form-check-input" id="perm_{{ $permission->id }}"
                            {{ collect(old('permissions'))->contains($permission->id) ? 'checked' : '' }}>
                        <label class="form-check-label" for="perm_{{ $permission->id }}">
                            {{ $permission->name }}
                        </label>
                    </div>
                @endforeach
            </div>
            @error('permissions')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <button class="btn btn-success">Save</button>
        <a href="{{ route('roles.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
