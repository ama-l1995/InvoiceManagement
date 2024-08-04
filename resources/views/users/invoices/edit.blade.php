@extends('layouts.app')

@section('title', 'Edit Invoice')

@section('content')
<div class="container">

    <h1>Edit Invoice</h1>
    @can('edit invoices')
        <form action="{{ route('invoices.update', $invoice->id) }}" method="POST" id="invoiceForm">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="client_id" class="form-label">Client</label>
                <select name="client_id" id="client_id" class="form-select" required>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}" {{ $invoice->client_id == $client->id ? 'selected' : '' }}>{{ $client->name }}</option>
                    @endforeach
                </select>
                @error('client_id')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3">
                <label for="invoice_date" class="form-label">Invoice Date</label>
                <input type="date" name="invoice_date" id="invoice_date" class="form-control" value="{{ $invoice->invoice_date->format('Y-m-d') }}" required>
                @error('invoice_date')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3">
                <label for="due_date" class="form-label">Due Date</label>
                <input type="date" name="due_date" id="due_date" class="form-control" value="{{ $invoice->due_date->format('Y-m-d') }}" required>
                @error('due_date')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div id="items">
                <h4>Items</h4>
                @foreach($invoice->items as $index => $item)
                    <div class="item">
                        <h4>Item {{ $index + 1 }}</h4>
                        <div class="mb-3">
                            <label for="items[{{ $index }}][description]" class="form-label">Description</label>
                            <input type="text" name="items[{{ $index }}][description]" class="form-control" value="{{ $item['description'] }}" required>
                            @error("items[{{ $index }}][description]")
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="items[{{ $index }}][quantity]" class="form-label">Quantity</label>
                            <input type="number" name="items[{{ $index }}][quantity]" class="form-control" value="{{ $item['quantity'] }}" min="1" required>
                            @error("items[{{ $index }}][quantity]")
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="items[{{ $index }}][price]" class="form-label">Price</label>
                            <input type="number" name="items[{{ $index }}][price]" class="form-control" value="{{ $item['price'] }}" step="0.01" min="0.01" required>
                            @error("items[{{ $index }}][price]")
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                @endforeach
            </div>

            <button type="button" class="btn btn-secondary" onclick="addItem()">Add Another Item</button>

            <button type="submit" class="btn btn-primary" onclick="prepareItems()">Update Invoice</button>
        </form>
        
    @else
        <p>You do not have permission to edit invoices.</p>
    @endcan
</div>

    <script>
        let itemIndex = {{ count($invoice->items) }};

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

            const itemsInput = document.createElement('input');
            itemsInput.type = 'hidden';
            itemsInput.name = 'items';
            itemsInput.value = JSON.stringify(itemsArray);
            form.appendChild(itemsInput);
        }
    </script>
@endsection
