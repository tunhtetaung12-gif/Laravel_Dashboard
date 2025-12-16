@extends('layouts.dashboard')

@section('title', 'User Details')
@section('page-title', 'User Details')

@section('content')
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1>User Information</h1>
                <p>Detailed profile of the selected user</p>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            {{-- User Information --}}
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th style="width: 25%">ID</th>
                        <td>{{ $user->id }}</td>
                    </tr>

                    <tr>
                        <th>Name</th>
                        <td class="fw-bold">{{ $user->name }}</td>
                    </tr>

                    <tr>
                        <th>Email</th>
                        <td>{{ $user->email }}</td>
                    </tr>

                    <tr>
                        <th>Phone</th>
                        <td>{{ $user->phone ?? '-' }}</td>
                    </tr>

                    <tr>
                        <th>Address</th>
                        <td>{{ $user->address ?? '-' }}</td>
                    </tr>

                    <tr>
                        <th>Gender</th>
                        <td>{{ $user->gender ?? '-' }}</td>
                    </tr>

                    <tr>
                        <th>Roles</th>
                        <td>
                            @if ($user->roles->count() > 0)
                                @foreach ($user->roles as $role)
                                    <span class="badge bg-info text-dark">{{ $role->name }}</span>
                                @endforeach
                            @else
                                <span class="badge bg-secondary">No Role</span>
                            @endif
                        </td>
                    </tr>


                    <tr>
                        <th>Status</th>
                        <td>
                            @if ($user->status === 1)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="mt-3">
                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">
                    Edit User
                </a>

                <a href="{{ route('users.index') }}" class="btn btn-secondary">
                    Back
                </a>
            </div>

        </div>
    </div>
@endsection
