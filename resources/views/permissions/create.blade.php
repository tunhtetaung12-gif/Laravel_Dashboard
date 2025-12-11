@extends('layouts.dashboard')

@section('title', 'Add Permission')
@section('page-title', 'Permissions Management')

@section('content')
    <div class="container">
        <h3>Create Permission</h3>
        <form action="{{ route('permissions.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Permission Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <button class="btn btn-success">Save</button>
            <a href="{{ route('permissions.index') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
@endsection
