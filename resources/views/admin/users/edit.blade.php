@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
    <div class="container mt-4">
        <h1>Edit User</h1>

        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">User Name</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                @error('name')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                @error('email')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="tel" id="phone" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                @error('phone')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <textarea id="address" name="address" class="form-control" rows="4" required>{{ old('address', $user->address) }}</textarea>
                @error('address')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Permissions</label>
                <div class="form-control">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="select_all" />
                        <label class="form-check-label" for="select_all">Select All</label>
                    </div>
                    <div class="row mt-3">
                        @foreach($permissions as $permission)
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->name }}" id="permission_{{ $permission->id }}" {{ in_array($permission->name, old('permissions', $user->permissions->pluck('name')->toArray())) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="permission_{{ $permission->id }}">
                                        {{ $permission->name }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @error('permissions')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Update User</button>
            </div>
        </form>
    </div>
@endsection
