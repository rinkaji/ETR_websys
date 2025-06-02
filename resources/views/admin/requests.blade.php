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
    </style>
</head>

<body class="bg-light">


    @extends('layouts.app')

    <!-- @section('title', 'Admin Dashboard') -->

    @section('content')
    <h1 class="mb-4">Office Requests</h1>
    <div class="container py-4">
        <table class="table table-bordered table-hover bg-white">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Request No.</th>
                    <th>Status</th>
                    <th>Office</th>
                    <th>Requested By</th>
                    <th>Designation</th>
                    <th>Items</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($requests as $req)
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
                    <td>
                        @if($req->status === 'pending')
                        <form method="POST" action="{{ route('admin.requests.accept', $req) }}" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">Accept</button>
                        </form>
                        <form method="POST" action="{{ route('admin.requests.reject', $req) }}" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                        </form>
                        @else
                        <span class="badge bg-secondary">{{ ucfirst($req->status) }}</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <!-- <a href="{{ route('dashboard') }}" class="btn btn-secondary">Back to Dashboard</a> -->
    </div>
    @endsection

</html>