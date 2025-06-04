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

        h2 {
            font-weight: 600 !important;
            margin-bottom: 15px !important;
            color: #1D70B8 !important;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="bg-light">


    @extends('office-layouts.app')

    @section('content')
    <h1 class="mb-4 d-flex align-items-center justify-content-between">
        Office Dashboard
        <!-- Notification Bell Button -->
        <button type="button" class="btn btn-outline-warning position-relative" data-bs-toggle="modal" data-bs-target="#notificationsModal">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-bell" viewBox="0 0 16 16">
                <path d="M8 16a2 2 0 0 0 1.985-1.75H6.015A2 2 0 0 0 8 16zm.104-14.804A1.5 1.5 0 0 0 5.5 2c0 .628-.134 1.197-.356 1.684C4.042 4.68 3 6.07 3 8v3.086l-.707.707A1 1 0 0 0 3 13h10a1 1 0 0 0 .707-1.707L13 11.086V8c0-1.93-1.042-3.32-2.144-4.316A3.007 3.007 0 0 0 10.5 2a1.5 1.5 0 0 0-2.396-1.804zM8 1a1 1 0 0 1 1 1c0 .628.134 1.197.356 1.684C9.958 4.68 11 6.07 11 8v3.586l1 1V13H4v-1.414l1-1V8c0-1.93 1.042-3.32 2.144-4.316A3.007 3.007 0 0 1 7.5 2a1 1 0 0 1 .604-.804z"/>
            </svg>
            @php
                $declinedCount = \App\Models\request::where('user_id', auth()->id())->where('status', 'rejected')->count();
            @endphp
            @if($declinedCount > 0)
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                {{ $declinedCount }}
            </span>
            @endif
        </button>
    </h1>
    <p>Welcome. This is the dedicated portal for your department/office to create a request from the Supply Office.</strong></p>
    <div class="container py-4">
        <!-- <a href="{{ route('request.create') }}" class="btn btn-primary mb-3">Create Supply Request</a> -->

        <h2 class="h5 mt-4">My Requests</h2>
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
                </tr>
            </thead>
            <tbody>
                @foreach(\App\Models\request::where('user_id',
                auth()->id())->with('items.supply')->orderBy('created_at', 'desc')->get() as $req)
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

        <h2 class="h5 mt-4">Real-Time Supply Availability</h2>
        <div class="table-responsive bg-white rounded shadow-sm">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
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

        <!-- Notification Modal (make sure it's outside any table or container that could hide it) -->
        <div class="modal fade" id="notificationsModal" tabindex="-1" aria-labelledby="notificationsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="notificationsModalLabel">Declined Requests</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @php
                            $declinedRequests = \App\Models\request::where('user_id', auth()->id())
                                ->where('status', 'rejected')
                                ->orderBy('updated_at', 'desc')
                                ->get();
                        @endphp
                        @if($declinedRequests->isEmpty())
                            <div class="alert alert-info mb-0">No declined requests.</div>
                        @else
                            <div class="list-group">
                                @foreach($declinedRequests as $req)
                                    <div class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>Request #{{ $req->request_id }}</strong>
                                                <span class="badge bg-danger ms-2">Declined</span>
                                                <div class="small text-muted">Date: {{ $req->updated_at->format('Y-m-d H:i') }}</div>
                                            </div>
                                            
                                        </div>
                                        <div class="mt-2">
                                            <strong>Reason:</strong>
                                            <span>{{ $req->decline_reason ?? 'No reason provided.' }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection

</html>