@extends('layouts.app')

@section('title', 'Users')

@section('content')
<div class="container-fluid mt-4">

    <h1 class="mb-4">Users</h1>

    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('users.create') }}" class="btn btn-primary">Create User</a>

    </div>
    <div class="container- mt-4">
        <div class="table-responsive">
            <table class="table table-striped text-center table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Permissions</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>{{ $user->address }}</td>
                            <td>
                                @forelse($user->permissions as $permission)
                                    <p class=" ">{{ $permission->name }}</p>
                                @empty
                                    <p >No Permissions</p>
                                @endforelse
                            </td>
                            <td>
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No users found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>


    {{ $users->links() }} <!-- Pagination links -->
</div>
@endsection
