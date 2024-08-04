@extends('layouts.app')

@section('title', 'Invoices')

@section('content')
<div class="container w-75 mx-auto mt-4">
    <h1 class="mb-4">Invoices</h1>
    @can('view invoices')
        <a href="{{ route('invoices.create') }}" class="btn btn-primary mb-3">Create Invoice</a>

        <!-- Search Input -->
        <div class="mb-3 w-50 ">
            <input type="text" id="searchInput" class="form-control" placeholder="Search by Invoice Number, Client, or Date" onkeyup="filterTable()">
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-bordered" id="invoiceTable">
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
                            <td>{{ $invoice->client->name }}</td>
                            <td>{{ $invoice->invoice_date->format('Y-m-d') }}</td>
                            <td>${{ number_format(collect($invoice->items)->sum(function($item) {
                                return $item['quantity'] * $item['price'];
                            }), 2) }}</td>
                            <td>
                                <a href="{{ route('invoices.show', $invoice->id) }}" class="btn btn-info btn-sm">Show</a>
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
        </div>

        <!-- Pagination Links -->
        <div class="d-flex justify-content-center mt-4">
            {{ $invoices->links() }}
        </div>
        
    @else
        <p>You do not have permission to view invoices.</p>
    @endcan
</div>

<script>
function filterTable() {
    // Get the input value and convert it to lowercase
    let input = document.getElementById('searchInput').value.toLowerCase();
    // Get the table and rows
    let table = document.getElementById('invoiceTable');
    let rows = table.getElementsByTagName('tr');

    // Loop through all table rows and hide those that don't match the input
    for (let i = 1; i < rows.length; i++) { // start from 1 to skip header row
        let cells = rows[i].getElementsByTagName('td');
        let found = false;

        // Check if any cell in the row contains the input text
        for (let j = 0; j < cells.length - 1; j++) { // skip last cell (Actions)
            if (cells[j].innerText.toLowerCase().includes(input)) {
                found = true;
                break;
            }
        }

        // Show or hide the row based on whether the input was found
        rows[i].style.display = found ? '' : 'none';
    }
}
</script>
@endsection
