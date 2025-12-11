@extends('layouts.dashboard')

@section('title', 'Edit Role')
@section('page-title', 'Edit Role')

@section('content')
    <div class="container">
        <form action="{{route('roles.update', ['role' => $role->id])}}" method="POST">
            {{-- {{dd($role->id)}} --}}
            @csrf
            @method('PATCH')
            <div class="mb-3">
                <label for="name" class="form-label">Role Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $role->name) }}">
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Assign Permissions</label>
                @foreach ($permissions as $permission)
                    <div class="form-check">
                        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" class="form-check-input"
                            id="perm_{{ $permission->id }}"
                            {{ $role->permissions->contains('id', $permission->id) ? 'checked' : '' }}>
                        <label class="form-check-label" for="perm_{{ $permission->id }}">
                            {{ $permission->name }}
                        </label>
                    </div>
                @endforeach
                @error('permissions')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <button class="btn btn-success" type="submit">Update</button>
            <a href="{{ route('roles.index') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
@endsection
