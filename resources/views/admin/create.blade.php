<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Supply</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Inter Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Inter', sans-serif;
        }

        .card-custom {
            background-color: white;
            border-radius: 13px;
            padding: 2rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
            max-width: 700px;
            margin: 3rem auto;
        }

        h1 {
            text-align: center;
            color: #0A28D8;
            margin-bottom: 1.5rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card-custom">
            <h1>Add Supplies</h1>

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('admin.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="item" class="form-label">Item</label>
                    <input type="text" name="item" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="item" class="form-label">Description</label>
                    <input type="text" name="description" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="unit" class="form-label">Unit</label>
                    <div class="input-group">
                        <select name="unit" id="unit" class="form-select" required>
                            <option value="" disabled selected>Select Unit</option>
                            @foreach($units as $unit)
                                <option value="reams">reams</option>
                                <option value="reams">pcs</option>
                                <option value="reams">bottle</option>
                                <option value="reams">box</option>
                                <option value="{{ $unit->name }}">{{ $unit->name }}</option>
                            @endforeach
                        </select>
                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addUnitModal">
                            Add Unit
                        </button>
                    </div>
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
                    <label for="unit" class="form-label">Fund Cluster</label>
                    <select name="supply_from" class="form-select" required>
                        <option value="" disabled selected>Select Fund Cluster</option>
                        <option value="164">164</option>
                        <option value="161">161</option>
                        <option value="184">184</option>
                        <option value="101">101</option>
                    </select>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Create</button>
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Add Unit Modal -->
    <div class="modal fade" id="addUnitModal" tabindex="-1" aria-labelledby="addUnitModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('units.store') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addUnitModalLabel">Add New Unit</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" name="name" class="form-control" placeholder="Unit name" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Add Unit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>