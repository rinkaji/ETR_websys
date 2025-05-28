<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Supply</title>
</head>
<body>
    <div>
        <h1>Add Supplies</h1>
        @if ($errors->any())
            <div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li style="color: red">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.store') }}">
            @csrf
            <div>
                <label for="item">Item</label>
                <input type="text" name="item" required>
            </div>
            <div>
                <label for="unit">Unit</label>
                <select name="unit" required>
                    <option value="" disabled selected>Select Unit</option>
                    <option value="reams">reams</option>
                    <option value="piece">piece</option>
                    <option value="bottle">bottle</option>
                    <option value="box">box</option>
                    <option value="set">set</option>
                </select>
            </div>
            <div>
                <label for="quantity">Quantity</label>
                <input type="number" name="quantity" required>
            </div>
            <div>
                <label for="unit_cost">Unit Cost</label>
                <input type="number" step="0.01" name="unit_cost" required>
            </div>
            <button type="submit">Create</button>
        </form>
        <a href="{{ route('dashboard') }}">Back to Dashboard</a>
    </div>
</body>
</html>