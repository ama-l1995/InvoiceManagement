@extends('layouts.app')

@section('title', 'Edit Invoice')

@section('content')
    <h1>Edit Invoice</h1>

    <form action="{{ route('invoices.update', $invoice->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="user_id" class="form-label">Client</label>
            <select name="user_id" id="user_id" class="form-select" required>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}" {{ $invoice->user_id == $client->id ? 'selected' : '' }}>{{ $client->name }}</option>
                @endforeach
            </select>
            @error('user_id')
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

        <div id="items">
            <h4>Items</h4>
            @foreach($invoice->items as $index => $item)
                <div class="item">
                    <h4>Item {{ $index + 1 }}</h4>
                    <div class="mb-3">
                        <label for="items[{{ $index }}][description]" class="form-label">Description</label>
                        <input type="text" name="items[{{ $index }}][description]" class="form-control" value="{{ $item->description }}" required>
                        @error('items[{{ $index }}][description]')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="items[{{ $index }}][quantity]" class="form-label">Quantity</label>
                        <input type="number" name="items[{{ $index }}][quantity]" class="form-control" value="{{ $item->quantity }}" min="1" required>
                        @error('items[{{ $index }}][quantity]')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="items[{{ $index }}][price]" class="form-label">Price</label>
                        <input type="number" name="items[{{ $index }}][price]" class="form-control" value="{{ $item->price }}" step="0.01" min="0.01" required>
                        @error('items[{{ $index }}][price]')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            @endforeach
        </div>

        <button type="button" class="btn btn-secondary" onclick="addItem()">Add Another Item</button>

        <div class="mb-3">
            <label for="notes" class="form-label">Notes</label>
            <textarea name="notes" id="notes" class="form-control">{{ $invoice->notes }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update Invoice</button>
    </form>

    <script>
        let itemIndex = {{ $invoice->items->count() }};

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
