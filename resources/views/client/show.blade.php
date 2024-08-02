@extends('layouts.app')

@section('title', 'Invoice Details')

@section('content')
    <h1>Invoice Details</h1>
    <a href="{{ route('invoices.index') }}" class="btn btn-primary mb-3">Back to Invoices</a>

    <div class="card">
        <div class="card-header">
            Invoice #{{ $invoice->invoice_number }}
        </div>
        <div class="card-body">
            <h5 class="card-title">Client: {{ $invoice->user->name }}</h5>
            <p class="card-text">Date: {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('Y-m-d') }}</p>
            <p class="card-text">Notes: {{ $invoice->notes }}</p>
            <h5 class="card-title">Items:</h5>
            <ul class="list-group list-group-flush">
                @foreach($invoice->items as $item)
                    <li class="list-group-item">
                        {{ $item->description }} - Quantity: {{ $item->quantity }} - Price: ${{ number_format($item->price, 2) }}
                    </li>
                @endforeach
            </ul>
            <h5 class="card-title mt-3">Total: ${{ number_format($invoice->items->sum(function($item) {
                return $item->quantity * $item->price;
            }), 2) }}</h5>
        </div>
    </div>
@endsection
