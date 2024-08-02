@extends('layouts.app')

@section('title', 'Create Invoice')

@section('content')
    <h1>Create Invoice</h1>

    <form action="{{ route('invoices.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="user_id" class="form-label">Client</label>
            <select name="user_id" id="user_id" class="form-select" required>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                @endforeach
            </select>
            @error('user_id')
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

        <div id="items">
            <h4>Items</h4>
            <div class="item">
                <div class="mb-3">
                    <label for="items[0][description]" class="form-label">Description</label>
                    <input type="text" name="items[0][description]" class="form-control" required>
                    @error('items[0][description]')
                            <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="items[0][quantity]" class="form-label">Quantity</label>
                    <input type="number" name="items[0][quantity]" class="form-control" min="1" required>
                    @error('items[0][quantity]')
                            <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="items[0][price]" class="form-label">Price</label>
                    <input type="number" name="items[0][price]" class="form-control" step="0.01" min="0.01" required>
                    @error('items[0][price]')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <button type="button" class="btn btn-secondary" onclick="addItem()">Add Another Item</button>

        <div class="mb-3">
            <label for="notes" class="form-label">Notes</label>
            <textarea name="notes" id="notes" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Save Invoice</button>
    </form>

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
    </script>
@endsection
