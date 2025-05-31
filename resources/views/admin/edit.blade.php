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

            <form method="POST" action="{{ route('admin.update', $supply->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="item" class="form-label">Item</label>
                    <input type="text" name="item" id="item" class="form-control" value="{{ $supply->item }}"
                        required />
                </div>

                <div class="mb-3">
                    <label for="unit" class="form-label">Unit</label>
                    <input type="text" name="unit" id="unit" class="form-control" value="{{ $supply->unit }}"
                        required />
                </div>

                <div class="mb-3">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input type="number" name="quantity" id="quantity" class="form-control"
                        value="{{ $supply->quantity }}" required />
                </div>

                <div class="mb-3">
                    <label for="unit_cost" class="form-label">Unit Cost</label>
                    <input type="number" step="0.01" name="unit_cost" id="unit_cost" class="form-control"
                        value="{{ $supply->unit_cost }}" required />
                </div>

                <fieldset class="mb-3">
                    <legend class="col-form-label pt-0">Supply Source</legend>
                    <div class="form-check form-check-inline">
                        <input type="radio" name="supply_from" id="purchased" value="purchased" class="form-check-input"
                            {{ $supply->supply_from == 'purchased' ? 'checked' : '' }} required />
                        <label class="form-check-label" for="purchased">Purchased</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" name="supply_from" id="received" value="received" class="form-check-input"
                            {{ $supply->supply_from == 'received' ? 'checked' : '' }} required />
                        <label class="form-check-label" for="received">Received</label>
                    </div>
                </fieldset>

                <div class="mb-3">
                    <label for="supply_from_quantity" class="form-label">Supply From Quantity</label>
                    <input type="number" id="supply_from_quantity" class="form-control"
                        value="{{ $supply->supply_from_quantity }}" readonly />
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>