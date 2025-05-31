<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Supply</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
    <h1 class="mb-4">Add Supplies</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.store') }}" class="bg-white p-4 rounded shadow-sm">
        @csrf
        <div class="mb-3">
            <label for="item" class="form-label">Item</label>
            <input type="text" name="item" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="unit" class="form-label">Unit</label>
            <select name="unit" class="form-select" required>
                <option value="" disabled selected>Select Unit</option>
                <option value="reams">reams</option>
                <option value="piece">piece</option>
                <option value="bottle">bottle</option>
                <option value="box">box</option>
                <option value="set">set</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="quantity" class="form-label">Quantity</label>
            <input type="number" name="quantity" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="unit_cost" class="form-label">Unit Cost</label>
            <input type="number" step="0.01" name="unit_cost" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="reorder_threshold" class="form-label">Reorder Threshold</label>
            <input type="number" name="reorder_threshold" class="form-control" value="0" min="0" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Supply source</label><br>
            <div class="form-check form-check-inline">
                <input type="radio" name="supply_from" value="purchased" class="form-check-input" required>
                <label class="form-check-label" for="supply_from">Purchased Supply</label>
            </div>
            <div class="form-check form-check-inline">
                <input type="radio" name="supply_from" value="received" class="form-check-input" required>
                <label class="form-check-label" for="supply_from">Received Supply</label>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
    </form>
</div>
</body>
</html>