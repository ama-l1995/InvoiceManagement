@extends('layouts.app')

@section('title', 'Create Invoice')

@section('content')
<div class="container mt-4" style="width: 75%; margin: 0 auto;">
    <h1>Create Invoice</h1>
    @can('create invoices')
        <a href="{{ route('invoices.create') }}">Create Invoice</a>
        <form id="invoiceForm" action="{{ route('invoices.store') }}" method="POST" onsubmit="prepareItems()">
            @csrf

            <div class="mb-3">
                <label for="client_id" class="form-label">Client</label>
                <select name="client_id" id="client_id" class="form-select" required>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                    @endforeach
                </select>
                @error('client_id')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3">
                <label for="invoice_date" class="form-label">Invoice Date</label>
                <input type="date" name="invoice_date" id="invoice_date" class="form-control" required>
                @error('invoice_date')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3">
                <label for="due_date" class="form-label">Due Date</label>
                <input type="date" name="due_date" id="due_date" class="form-control" required>
                @error('due_date')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div id="items">
                <h4>Items</h4>
                <div class="item">
                    <div class="mb-3">
                        <label for="items[0][description]" class="form-label">Description</label>
                        <input type="text" name="items[0][description]" class="form-control" required>
                        @error('items.0.description')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="items[0][quantity]" class="form-label">Quantity</label>
                        <input type="number" name="items[0][quantity]" class="form-control" min="1" required>
                        @error('items.0.quantity')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="items[0][price]" class="form-label">Price</label>
                        <input type="number" name="items[0][price]" class="form-control" step="0.01" min="0.01" required>
                        @error('items.0.price')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <button type="button" class="btn btn-secondary" onclick="addItem()">Add Another Item</button>



            <button type="submit" class="btn btn-primary">Save Invoice</button>
        </form>
    @else
        <p>You do not have permission to create invoices.</p>
    @endcan
    
</div>

<script>
    let itemIndex = 1;

    function addItem() {
        const itemsDiv = document.getElementById('items');
        const newItemDiv = document.createElement('div');
        newItemDiv.classList.add('item');
        newItemDiv.innerHTML = `
            <h4>Item ${itemIndex + 1}</h4>
            <div class="mb-3">
                <label for="items[${itemIndex}][description]" class="form-label">Description</label>
                <input type="text" name="items[${itemIndex}][description]" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="items[${itemIndex}][quantity]" class="form-label">Quantity</label>
                <input type="number" name="items[${itemIndex}][quantity]" class="form-control" min="1" required>
            </div>
            <div class="mb-3">
                <label for="items[${itemIndex}][price]" class="form-label">Price</label>
                <input type="number" name="items[${itemIndex}][price]" class="form-control" step="0.01" min="0.01" required>
            </div>
        `;
        itemsDiv.appendChild(newItemDiv);
        itemIndex++;
    }

    function prepareItems() {
    const form = document.getElementById('invoiceForm');
    const items = document.querySelectorAll('#items .item');
    const itemsArray = [];

    items.forEach((item, index) => {
        const description = item.querySelector(`[name="items[${index}][description]"]`).value;
        const quantity = item.querySelector(`[name="items[${index}][quantity]"]`).value;
        const price = item.querySelector(`[name="items[${index}][price]"]`).value;

        itemsArray.push({ description, quantity, price });
    });

    const itemsJsonInput = document.createElement('input');
    itemsJsonInput.type = 'hidden';
    itemsJsonInput.name = 'items';
    itemsJsonInput.value = JSON.stringify(itemsArray); // Ensure it's a JSON string
    form.appendChild(itemsJsonInput);
}

</script>
@endsection
