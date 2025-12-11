@extends('layouts.dashboard')

@section('title', 'Permissions')
@section('page-title', 'Permissions Management')

@section('content')
    <div class="container">
        <a href="{{ route('permissions.create') }}" class="btn btn-primary mb-3">
            <i class="bi bi-plus-circle"></i> Add Permission
        </a>


        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Permission Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($permissions as $key => $permission)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $permission->name }}</td>
                        <td>
                            <a href="{{ route('permissions.edit', $permission->id) }}" class="btn btn-sm btn-outline-warning">Edit</a>
                            <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST"
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
