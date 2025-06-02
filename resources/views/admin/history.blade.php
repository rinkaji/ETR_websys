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

        .card-header {
            background-color: black !important;
        }
    </style>

</head>

<body class="bg-light">


    @extends('layouts.app')

    @section('title', 'Admin Dashboard')

    @section('content')
    <h1 class="mb-4">Request History</h1>
    <div class="container py-4">
        <div class="mb-3">
            @foreach(range(1,12) as $m)
            <a href="{{ route('admin.history', ['month' => str_pad($m, 2, '0', STR_PAD_LEFT)]) }}"
                class="btn btn-sm {{ $month == str_pad($m, 2, '0', STR_PAD_LEFT) ? 'btn-primary' : 'btn-outline-primary' }} me-1 mb-1">
                {{ DateTime::createFromFormat('!m', $m)->format('F') }}
            </a>
            @endforeach
        </div>
        @foreach($departments as $office => $reqs)
        <div class="card mb-4">
            <div class="card-header text-white">
                <strong>Department/Office:</strong> {{ $office }}
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Request No.</th>
                            <th>Requested By</th>
                            <th>Designation</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Items</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reqs as $req)
                        <tr>
                            <td>{{ $req->request_id }}</td>
                            <td>{{ $req->request_by }}</td>
                            <td>{{ $req->request_by_designation }}</td>
                            <td>{{ ucfirst($req->status) }}</td>
                            <td>{{ $req->created_at->format('Y-m-d') }}</td>
                            <td>
                                <ul>
                                    @foreach($req->items as $item)
                                    <li>{{ $item->supply->item }} ({{ $item->quantity }})</li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endforeach
        <!-- <a href="{{ route('dashboard') }}" class="btn btn-secondary">Back to Dashboard</a> -->
    </div>
    @endsection

</html>