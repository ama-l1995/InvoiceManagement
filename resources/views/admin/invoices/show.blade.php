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
        <strong>Client:</strong> {{ $invoice->client->name }}
    </div>
    <div class="mb-3">
        <strong>Invoice Date:</strong> {{ $invoice->invoice_date }}
    </div>
    <div class="mb-3">
        <strong>Notes:</strong> {{ $invoice->notes }}
    </div>
    <h4>Items</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Description</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoice->items as $item)
                <tr>
                    <td>{{ $item->description }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->price }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('invoices.index') }}" class="btn btn-secondary">Back to List</a>
</div>
</body>
</html>
