<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
            color: #333;
        }
        h1 {
            color: #007bff;
            font-size: 24px;
        }
        .invoice-header, .invoice-footer {
            margin-bottom: 20px;
        }
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
        }
        .invoice-table th, .invoice-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .invoice-table th {
            background-color: #f4f4f4;
        }
        .total {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="invoice-header">
        <h1>Invoice #{{ $invoice->invoice_number }}</h1>
        <p><strong>Client:</strong> {{ $invoice->client_name }}</p>
        <p><strong>Invoice Date:</strong> {{ $invoice->invoice_date->format('Y-m-d') }}</p>
    </div>

    <table class="invoice-table">
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
                    <td>{{ $item['description'] }}</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>${{ number_format($item['price'], 2) }}</td>
                    <td>${{ number_format($item['quantity'] * $item['price'], 2) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="total">Grand Total</td>
                <td class="total">${{ number_format(collect($invoice->items)->sum(function($item) {
                    return $item['quantity'] * $item['price'];
                }), 2) }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="invoice-footer">
        <p>Thank you for your business!</p>
    </div>
</body>
</html>
