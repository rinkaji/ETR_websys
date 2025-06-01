<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>


<body class="bg-light">


    @extends('layouts.app')

    @section('title', 'Admin Dashboard')

    @section('content')
    <h1 class="mb-4">Inventory</h1>

    <!-- <div class="mb-3">
        <a href="{{ route('admin.requests') }}" class="btn btn-success me-2">View Office Requests</a>
        <a href="{{ route('admin.create') }}" class="btn btn-primary me-2">Create Supply</a>
        <a href="{{ route('register') }}" class="btn btn-secondary me-2">Register Users</a>
        <a href="{{ route('admin.history') }}" class="btn btn-warning">View History</a>
    </div> -->

    <div class="row mb-4">
        <div class="col">
            <div class="card text-dark" style="background-color: #f1f1f1; border: none;">
                <div class="card-body">
                    <h5 class="card-title">Total Items</h5>
                    <p class="card-text fs-3">{{ $totalSupplies }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-dark" style="background-color: #f1f1f1; border: none;">
                <div class="card-body">
                    <h5 class="card-title">Low Stock</h5>
                    <p class="card-text fs-3">{{ $lowStockCount }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-dark" style="background-color: #f1f1f1; border: none;">
                <div class="card-body">
                    <h5 class="card-title">Pending Requests</h5>
                    <p class="card-text fs-3">{{ $pendingRequests }}</p>
                </div>
            </div>
        </div>
    </div>



    <form method="GET" action="{{ route('dashboard') }}" class="row g-3 mb-3">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Search by name, code, category"
                value="{{ request('search') }}">
        </div>

        <div class="col-md-2">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="low_stock" value="1" @if(request('low_stock'))
                    checked @endif>
                <label class="form-check-label">Low Stock Only</label>
            </div>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-outline-primary">Filter</button>
        </div>
    </form>

    @if($lowStockActive && $supplies->count() > 0)
    <div class="alert alert-danger">
        <strong>Low Stock Alert:</strong> There are items below their reorder threshold!
    </div>
    @endif

    <h2 class="h4 mt-4 mb-3">Supplies Inventory</h2>
    <div class="table-responsive bg-white rounded shadow-sm">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Item</th>
                    <th>Description</th> <!-- reminder -->
                    <th>Unit</th>
                    <th>Quantity</th>
                    <th>Total Quantity</th>
                    <th>Fund Cluster</th>
                    <th>Unit Cost</th>

                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($supplies as $supply)
                <tr>
                    <td>{{ $supply->item }}</td>
                    <td>{{ $supply->description }}</td>
                    <td>{{ $supply->unit }}</td>
                    <td>{{ $supply->quantity }}</td>
                    <td>{{ $supply->supply_from_quantity }}</td>
                    <td>{{ ucfirst($supply->supply_from) }}</td>
                    <td>{{ number_format($supply->unit_cost, 2) }}</td>
                    <td>
                        <a href="{{ route('admin.edit', $supply->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.destroy', $supply->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Delete this item?')">Delete</button>
                        </form>
                        <a href="{{ route('admin.stockCard', [ 'item' => urlencode($supply->item),
    'description' => urlencode($supply->description), 'unit' => urlencode($supply->unit)]) }}"
                            class="btn btn-sm btn-info">View</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @endsection


</html>