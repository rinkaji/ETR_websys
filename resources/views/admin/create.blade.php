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
            background-color: #1D70B8;
            font-family: 'Inter', sans-serif;
            font-size: 0.9rem !important;
        }

        .card-custom {
            background-color: white;
            border-radius: 13px;
            padding: 2rem;
            /* box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1); */
            max-width: 600px;
            margin: 0.3rem auto;
        }

        h1 {
            text-align: center;
            color: #1D70B8;
            margin-bottom: 2rem;
            font-weight: 900 !important;
        }

        .form-label {
            font-weight: bold;
        }

        submit-btn {
            color: #1D70B8;
        }

        .icon-register {
            height: 50px !important;
            width: 50px !important;
            display: block;
            margin: 1rem auto;
        }

        .card-custom p {
            margin-bottom: 4rem;
        }

        .card-custom h1 {
            margin-bottom: 1rem !important;
        }
    </style>
</head>

<body>

    @extends('layouts.app')

    @section('title', 'Admin Dashboard')

    @section('content')
    <div class="card-custom">
        <img class="icon-register" src="{{ asset('images/add-icon-black.svg') }}">
        <h1>Add Supplies</h1>
        <p>Enter the supply details below. Requesting accounts will be able to view its current stock level.</p>

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
                <label for="unit" class="form-label">Supply Source</label>
                <select name="supply_from" class="form-select" required>
                    <option value="" disabled selected>Select Unit</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
            {{-- <div class="mb-3">
                    <label class="form-label">Supply Source</label><br>
                    <div class="form-check form-check-inline">
                        <input type="radio" name="supply_from" value="purchased" class="form-check-input" required>
                        <label class="form-check-label">Purchased Supply</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" name="supply_from" value="received" class="form-check-input" required>
                        <label class="form-check-label">Received Supply</label>
                    </div>
                </div> --}}
            <button type="submit" class="btn btn-primary w-100 mt-3 submit-btn">Create supply</button>
            <!-- <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Create</button>
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
                </div> -->
        </form>
    </div>

    @endsection
</body>

</html>