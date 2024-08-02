@extends('layouts.app')

@section('title', 'Invoices')

@section('content')
    <h1>Invoices</h1>
    <a href="{{ route('invoices.create') }}" class="btn btn-primary mb-3">Create Invoice</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Invoice Number</th>
                <th>Client</th>
                <th>Date</th>
                <th>Total </th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoices as $invoice)
                <tr>
                    <td>{{ $invoice->invoice_number }}</td>
                    <td>{{ $invoice->user->name }}</td>
                    <td>{{ $invoice->invoice_date->format('Y-m-d') }}</td>
                    <td>${{ number_format($invoice->items->sum(function($item) {
                        return $item->quantity * $item->price;
                    }), 2) }}</td>
                    <td>
                        <a href="{{ route('invoices.show', $invoice->id) }}" class="btn btn-info btn-sm">Download PDF</a>
                        <a href="{{ route('invoices.edit', $invoice->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination Links -->
    {{ $invoices->links() }}
@endsection
