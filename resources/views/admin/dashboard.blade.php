<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-size: 0.9rem !important;
        }

        h1 {
            font-weight: 900 !important;
        }

        .action-btn {
            font-size: 0.85rem !important;
            padding: 0.25rem 0.6rem !important;
            border: none !important;
            border-radius: 4px;
            text-decoration: none !important;
        }

        .edit-btn,
        .delete-btn {
            background-color: #f1f1f1 !important;
            color: black !important;
        }

        .edit-btn:hover {
            background-color: #1D70B8 !important;
        }

        .delete-btn:hover {
            background-color: red !important;
            color: #f1f1f1 !important;
        }

        h2 {
            font-weight: 600 !important;
            color: #1D70B8 !important;
        }

        .icon-crud {
            height: 12px !important;
            margin-right: 8px;
        }

        .card a {
            text-decoration: none !important;
            color: black;
        }
    </style>

</head>


<body class="bg-light">


    @extends('layouts.app')

    @section('title', 'Admin Dashboard')

    @section('content')



    <!--Update UI-->
    @if (session('success'))
    <span>{{session('success')}}</span>
    @endif


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
                    <p class="card-text fs-3"><b>{{ $totalSupplies }}</b></p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-dark" style="background-color: #f1f1f1; border: none;">
                <div class="card-body">
                    <h5 class="card-title">Low Stock</h5>
                    <p class="card-text fs-3"><b>{{ $lowStockCount }}</b></p>
                </div>
            </div>
        </div>
        <div class="col">
            <a href="{{ route('admin.requests') }}">
                <div class="card text-dark" style="background-color: #f1f1f1; border: none;">
                    <a href="{{ route('admin.requests') }}">
                        <div class="card-body">
                            <h5 class="card-title">Pending Requests</h5>
                            <p class="card-text fs-3"><b>{{ $pendingRequests }}</b></p>
                        </div>
                    </a>
                </div>
            </a>
        </div>
    </div>

    <form method="GET" action="{{ route('dashboard') }}" class="row g-3 mb-3">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Search by name, code, category"
                value="{{ request('search') }}">
        </div>

        <div class="col-md-2 d-flex justify-content-center align-items-center">
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

    @if($lowStockCount > 0)
    <div class="alert alert-danger d-flex align-items-center">
        <img src="{{ asset('images/alert-02.svg') }}" alt="Alert Icon" class="me-2" style="height: 24px; width: 24px;">
        <div>
            <strong>Low Stock Alert:</strong> Some items are about to run out!
        </div>
    </div>
    @endif
    <h2 class="h4 mt-5 mb-3">Supplies Inventory</h2>
    <div class="table-responsive bg-white rounded shadow-sm">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Item</th>
                    <th>Description</th> <!-- reminder -->
                    <th>Unit</th>
                    <th>Quantity</th>
                    <th>Total Quantity</th>
                    <th>Fund Cluster</th>
                    <th>Unit Cost</th>
                    <th>Amount</th>

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
                    <td>{{ number_format($supply->supply_from_quantity * $supply->unit_cost, 2) }}</td>
                    <td>
                        <a href="{{ route('admin.edit', $supply->id) }}" class="btn btn-sm btn-warning action-btn edit-btn"><img class="icon-crud" src="{{ asset('images/edit-icon.svg') }}">Edit</a>
                        <form action="{{ route('admin.destroy', $supply->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger action-btn delete-btn"
                                onclick="return confirm('Delete this item?')"><img class="icon-crud" src="{{ asset('images/delete-icon.svg') }}">Delete</button>
                        </form>
                        <a href="{{ route('admin.stockCard', [ 'item' => urlencode($supply->item), 'description' => urlencode($supply->description), 'unit' => urlencode($supply->unit)]) }}"
                            class="action-btn view-btn"><img class="icon-crud" src="{{ asset('images/print-icon.svg') }}">View</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @endsection


</html>