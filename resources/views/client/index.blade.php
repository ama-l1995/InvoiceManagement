@extends('layouts.app')

@section('title', 'Invoices')

@section('content')
    <h1>Invoices</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Invoice Number</th>
                <th>Client</th>
                <th>Date</th>
                <th>Total</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoices as $invoice)
                <tr>
                    <td>{{ $invoice->invoice_number }}</td>
                    <td>{{ $invoice->user->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('Y-m-d') }}</td>
                    <td>${{ number_format($invoice->items->sum(function($item) {
                        return $item->quantity * $item->price;
                    }), 2) }}</td>
                    <td>
                        <a href="{{ route('invoices.show', $invoice->id) }}" class="btn btn-info btn-sm">View</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection
