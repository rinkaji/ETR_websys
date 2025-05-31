<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">


    @extends('office-layouts.app')

    @section('content')
    <div class="container py-4">
        <h1 class="mb-4">Office Dashboard</h1>
        <p>Welcome. This is your dedicated portal to create a request from the Supply Office.</strong></p>

        <!-- <a href="{{ route('request.create') }}" class="btn btn-primary mb-3">Create Supply Request</a> -->

        <h2 class="h5 mt-4">My Requests</h2>
        <table class="table table-bordered table-hover bg-white">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Request No.</th>
                    <th>Status</th>
                    <th>Office</th>
                    <th>Requested By</th>
                    <th>Designation</th>
                    <th>Items</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach(\App\Models\request::where('user_id', auth()->id())->with('items.supply')->orderBy('created_at', 'desc')->get() as $req)
                <tr>
                    <td>{{ $req->id }}</td>
                    <td>{{ $req->request_id }}</td>
                    <td>{{ ucfirst($req->status) }}</td>
                    <td>{{ $req->office }}</td>
                    <td>{{ $req->request_by }}</td>
                    <td>{{ $req->request_by_designation }}</td>
                    <td>
                        <ul>
                            @foreach($req->items as $item)
                            <li>{{ $item->supply->item }} ({{ $item->quantity }})</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>{{ $req->created_at->format('Y-m-d H:i') }}</td>

                </tr>
                @endforeach
            </tbody>
        </table>
        <h2 class="h5 mt-4">Supplies Inventory</h2>
        <div class="table-responsive bg-white rounded shadow-sm">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Item</th>
                        <th>Unit</th>
                        <th>Quantity</th>
                        <th>Unit Cost</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(\App\Models\Supply::all() as $supply)
                    <tr>
                        <td>{{ $supply->item }}</td>
                        <td>{{ $supply->unit }}</td>
                        <td>{{ $supply->quantity }}</td>
                        <td>{{ number_format($supply->unit_cost, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endsection
</html>