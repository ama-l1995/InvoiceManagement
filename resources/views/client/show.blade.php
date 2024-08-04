@extends('layouts.app')

@section('title', 'Invoice Details')

@section('content')
<div class="container w-75 mx-auto mt-4">

    <h1>Invoice Details</h1>
    <a href="{{ route('client.invoices.index') }}" class="btn btn-primary mb-3">Back to Invoices</a>

    <div class="card">
        <div class="card-header">
            Invoice #{{ $invoice->invoice_number }}
        </div>
        <div class="card-body">
            <h5 class="card-title">Client: {{ $invoice->client->name }}</h5>
            <p class="card-text">Date: {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('Y-m-d') }}</p>
            <h4>Items</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoice->items as $item)
                    <tr>
                        <td>{{ $item['description'] }}</td>
                        <td>{{ $item['quantity'] }}</td>
                        <td>${{ number_format($item['price'], 2) }}</td>
                        <td>${{ number_format($item['quantity'] * $item['price'], 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
            <h5 class="card-title mt-3">Total: ${{ number_format(collect($invoice->items)->sum(function($item) {
                return $item['quantity'] * $item['price'];
            }), 2) }}</h5>
        </div>
    </div>
</div>
@endsection
