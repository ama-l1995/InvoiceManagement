<!DOCTYPE html>
<html>
<head>
    <title>Invoice {{ $invoice->invoice_number }}</title>
</head>
<body>
    <h1>Invoice #{{ $invoice->invoice_number }}</h1>
    <p>Client: {{ $invoice->user->name }}</p>
    <p>Invoice Date: {{ $invoice->invoice_date->format('Y-m-d') }}</p>
    <table border="1" cellspacing="0" cellpadding="10">
        <thead>
            <tr>
                <th>Description</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->items as $item)
                <tr>
                    <td>{{ $item->description }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>${{ number_format($item->price, 2) }}</td>
                    <td>${{ number_format($item->quantity * $item->price, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
