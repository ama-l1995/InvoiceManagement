@extends('layouts.app')

@section('title', 'Clients')

@section('content')
<div class="container mt-4" style="width: 75%; margin: 0 auto;">
    <h1 class="mb-4">Clients</h1>
    @can('view clients')
        <a href="{{ route('clients.create') }}" class="btn btn-primary mb-3">Create Client</a>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clients as $client)
                    <tr>
                        <td>{{ $client->name }}</td>
                        <td>{{ $client->email }}</td>
                        <td>{{ $client->phone }}</td>
                        <td>{{ $client->address }}</td>
                        <td>
                            <a href="{{ route('clients.showInvoices', $client->id) }}" class="btn btn-info btn-sm">View Invoices</a>
                            <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('clients.destroy', $client->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this client?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>You do not have permission to view clients.</p>
    @endcan
    {{ $clients->links() }}
</div>
@endsection
