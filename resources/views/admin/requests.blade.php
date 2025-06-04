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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
                        <!-- Decline button triggers modal -->
                        <button type="button" class="btn btn-danger btn-sm decline-btn" data-bs-toggle="modal" data-bs-target="#declineModal" data-request-id="{{ $req->id }}">Decline</button>
                        @else
                        <span class="badge bg-secondary">{{ ucfirst($req->status) }}</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Decline Reason Modal -->
    <div class="modal fade" id="declineModal" tabindex="-1" aria-labelledby="declineModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form id="declineForm" method="POST">
            @csrf
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="declineModalLabel">Decline Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="mb-3">
                  <label for="declineReason" class="form-label">Reason for Decline</label>
                  <textarea class="form-control" id="declineReason" name="decline_reason" rows="3" required></textarea>
                </div>
                <input type="hidden" id="declineRequestId" name="request_id" value="">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger">Decline</button>
              </div>
            </div>
        </form>
      </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        var declineModal = document.getElementById('declineModal');
        var declineForm = document.getElementById('declineForm');
        var declineReason = document.getElementById('declineReason');
        var declineRequestId = document.getElementById('declineRequestId');

        // When Decline button is clicked, set form action and request id
        document.querySelectorAll('.decline-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var reqId = this.getAttribute('data-request-id');
                declineRequestId.value = reqId;
                declineForm.action = '/admin/requests/' + reqId + '/reject';
                declineReason.value = '';
            });
        });

        // Prevent submitting empty reason
        declineForm.addEventListener('submit', function(e) {
            if (!declineReason.value.trim()) {
                e.preventDefault();
                declineReason.classList.add('is-invalid');
            }
        });
    });
    </script>
    @endsection

</html>