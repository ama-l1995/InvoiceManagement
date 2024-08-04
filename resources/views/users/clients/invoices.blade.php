@extends('layouts.app')

@section('title', 'Client Invoices')

@section('content')
    <div class="container mt-4" style="width: 75%; margin: 0 auto;">
        <h1 class="mb-4">Invoices for {{ $client->name }}</h1>
        <div class="mb-3">
            <a href="{{ route('invoices.create') }}" class="btn btn-primary">Add New Invoice</a>
        </div>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Invoice Number</th>
                    <th>Client Name</th>
                    <th>Client Address</th>
                    <th>Invoice Date</th>
                    <th>Due Date</th>
                    <th>Total Amount</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($invoices as $invoice)
                    <tr>
                        <td>{{ $invoice->invoice_number }}</td>
                        <td>{{ $client->name }}</td>
                        <td>{{ $client->address }}</td>
                        <td>{{ $invoice->invoice_date->format('Y-m-d') }}</td>
                        <td>{{ $invoice->due_date->format('Y-m-d') }}</td>
                        <td>${{ number_format($invoice->total_amount, 2) }}</td>
                        <td>
                            <a href="{{ route('invoices.show', $invoice->id) }}" class="btn btn-info btn-sm">View</a>

                            <a href="{{ route('invoices.edit', $invoice->id) }}" class="btn btn-warning btn-sm">Edit</a>

                            <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this invoice?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No invoices found for this client.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-3">
            <a href="{{ route('clients.all') }}" class="btn btn-secondary">Back to Clients</a>
        </div>
    </div>
@endsection
