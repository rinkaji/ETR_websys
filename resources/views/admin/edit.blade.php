<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8" />
    <title>Edit Supply</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Inter Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Inter', sans-serif;
        }

        .card-custom {
            max-width: 700px;
            background: white;
            padding: 2rem;
            border-radius: 13px;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
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
            <h1>Edit Supply</h1>

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('admin.update', $supply->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="item" class="form-label">Item</label>
                    <input type="text" name="item" id="item" class="form-control" value="{{ $supply->item }}"
                        required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <input type="text" name="description" id="description" class="form-control"
                        value="{{ $supply->description }}" required>
                </div>

                <div class="mb-3">
                    <label for="unit" class="form-label">Unit</label>
                    <div class="input-group">
                        <select name="unit" id="unit" class="form-select" required>
                            <option value="" disabled>Select Unit</option>
                            @foreach($units as $unit)
                            <option value="reams">reams</option>
                            <option value="reams">pcs</option>
                            <option value="reams">bottle</option>
                            <option value="reams">box</option>
                            <option value="{{ $unit->name }}" {{ $supply->unit == $unit->name ? 'selected' : '' }}>{{ $unit->name }}</option>
                            @endforeach
                        </select>
                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addUnitModal">
                            Add Unit
                        </button>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input type="number" name="quantity" id="quantity" class="form-control"
                        value="{{ $supply->quantity }}" required>
                </div>

                <div class="mb-3">
                    <label for="unit_cost" class="form-label">Unit Cost</label>
                    <input type="number" step="0.01" name="unit_cost" id="unit_cost" class="form-control"
                        value="{{ $supply->unit_cost }}" required>
                </div>

                <div class="mb-3">
                    <label for="reorder_threshold" class="form-label">Reorder Threshold</label>
                    <input type="number" name="reorder_threshold" id="reorder_threshold" class="form-control"
                        value="{{ $supply->reorder_threshold ?? 0 }}" min="0" required>
                </div>

                <div class="mb-3">
                    <label for="supply_from" class="form-label">Fund Cluster</label>
                    <select name="supply_from" id="supply_from" class="form-select" required>
                        <option value="" disabled>Select Fund Cluster</option>
                        <option value="164" {{ $supply->supply_from == '164' ? 'selected' : '' }}>164</option>
                        <option value="161" {{ $supply->supply_from == '161' ? 'selected' : '' }}>161</option>
                        <option value="184" {{ $supply->supply_from == '184' ? 'selected' : '' }}>184</option>
                        <option value="101" {{ $supply->supply_from == '101' ? 'selected' : '' }}>101</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="supply_from_quantity" class="form-label">Supply From Quantity</label>
                    <input type="number" id="supply_from_quantity" class="form-control"
                        value="{{ $supply->supply_from_quantity }}" readonly>
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
                </div>
            </form>

            <!-- Move the modal OUTSIDE the main form -->
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
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>