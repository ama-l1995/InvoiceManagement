@extends('layouts.app')

@section('title', 'Create User')

@section('content')
    <div class="container mt-4">
        <h1>Create User</h1>

        <form action="{{ route('users.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">User Name</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" >
                @error('name')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" >
                @error('email')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" >
                @error('password')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" >
                @error('password_confirmation')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="tel" id="phone" name="phone" class="form-control" value="{{ old('phone') }}">
                @error('phone')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <textarea id="address" name="address" class="form-control" rows="4" >{{ old('address') }}</textarea>
                @error('address')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3 ">
                <label class="form-label">Permissions</label>
                <div class="form-control">
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <div class="form-check ">
                                <input class="form-check-input" type="checkbox" id="select_all" />
                                <label class="form-check-label" for="select_all">Select All</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        @foreach($permissions as $index => $permission)
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->name }}" id="permission_{{ $permission->id }}" {{ in_array($permission->name, old('permissions', [])) ? 'checked' : '' }}>
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
                <button type="submit" class="btn btn-primary">Create User</button>
            </div>
        </form>
    </div>
@endsection


