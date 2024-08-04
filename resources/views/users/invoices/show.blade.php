<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Invoice Details</h2>
        <div class="mb-3">
            <strong>Invoice Number:</strong> {{ $invoice->invoice_number }}
        </div>
        <div class="mb-3">
            <strong>Client:</strong> {{ $invoice->client_name }}
        </div>
        <div class="mb-3">
            <strong>Client Address:</strong> {{ $invoice->client_address }}
        </div>
        <div class="mb-3">
            <strong>Invoice Date:</strong> {{ $invoice->invoice_date->format('Y-m-d') }}
        </div>
        <div class="mb-3">
            <strong>Due Date:</strong> {{ $invoice->due_date->format('Y-m-d') }}
        </div>
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
        <div class="mb-3">
            <strong>Total Amount:</strong> ${{ number_format($invoice->total_amount, 2) }}
        </div>
        <a href="{{ route('invoices.download', $invoice->id) }}" class="btn btn-info btn-sm">Download PDF</a>

        <a href="{{ route('invoices.all') }}" class="btn btn-secondary">Back to List</a>
    </div>
</body>
</html>
