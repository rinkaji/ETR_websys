<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Supply</title>
</head>
<body>
    <h1>Edit Supply</h1>
    <form method="POST" action="{{ route('admin.update', $supply->id) }}">
        @csrf
        @method('PUT')
        <div>
            <label>Item</label>
            <input type="text" name="item" value="{{ $supply->item }}" required>
        </div>
        <div>
            <label>Unit</label>
            <input type="text" name="unit" value="{{ $supply->unit }}" required>
        </div>
        <div>
            <label>Quantity</label>
            <input type="number" name="quantity" value="{{ $supply->quantity }}" required>
        </div>
        <div>
            <label>Unit Cost</label>
            <input type="number" step="0.01" name="unit_cost" value="{{ $supply->unit_cost }}" required>
        </div>
        <div>
            <label>Supply Source</label><br>
            <input type="radio" name="supply_from" value="purchased" {{ $supply->supply_from == 'purchased' ? 'checked' : '' }} required> Purchased
            <input type="radio" name="supply_from" value="received" {{ $supply->supply_from == 'received' ? 'checked' : '' }} required> Received
        </div>
        <div>
            <label>Supply From Quantity</label>
            <input type="number" value="{{ $supply->supply_from_quantity }}" readonly>
        </div>
        <button type="submit">Update</button>
    </form>
    <a href="{{ route('dashboard') }}">Back to Dashboard</a>
</body>
</html>
