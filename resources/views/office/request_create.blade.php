<!DOCTYPE html>
<html>
<head>
    <title>Create Supply Request</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
    <h1 class="mb-4">Create Supply Request</h1>
    <form method="POST" action="{{ route('request.store') }}" class="bg-white p-4 rounded shadow-sm">
        @csrf
        <div class="mb-3">
            <label class="form-label">Office:</label>
            <input type="text" name="office" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Requested By:</label>
            <input type="text" name="request_by" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Designation:</label>
            <input type="text" name="request_by_designation" class="form-control" required>
        </div>
        <div class="table-responsive mb-3">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Supply</th>
                        <th>Available</th>
                        <th>Request Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($supplies as $supply)
                    <tr>
                        <td>
                            <input type="hidden" name="items[{{ $loop->index }}][supply_id]" value="{{ $supply->id }}">
                            {{ $supply->item }}
                        </td>
                        <td>{{ $supply->quantity }}</td>
                        <td>
                            <input type="number" name="items[{{ $loop->index }}][quantity]" min="0" max="{{ $supply->quantity }}" value="0" class="form-control">
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <button type="submit" class="btn btn-primary">Submit Request</button>
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
    </form>
</div>
</body>
</html>
