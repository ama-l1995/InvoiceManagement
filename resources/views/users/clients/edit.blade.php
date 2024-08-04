@extends('layouts.app')

@section('title', 'Edit Client')

@section('content')
    <div class="container mt-4">
        <h1>Edit Client</h1>
        @can('edit clients')
            <form action="{{ route('clients.update', $client->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Client Name</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $client->name) }}" required>
                    @error('name')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $client->email) }}" required>
                    @error('email')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="tel" id="phone" name="phone" class="form-control" value="{{ old('phone', $client->phone) }}">
                    @error('phone')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <textarea id="address" name="address" class="form-control" rows="4" required>{{ old('address', $client->address) }}</textarea>
                    @error('address')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Update Client</button>
                </div>
            </form>
        @else
            <p>You do not have permission to edit clients.</p>
        @endcan
        
    </div>
@endsection
