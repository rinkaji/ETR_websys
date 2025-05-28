<!DOCTYPE html>
<html>
<head>
    <title>Create Supply Request</title>
</head>
<body>
    <h1>Create Supply Request</h1>
    <form method="POST" action="{{ route('request.store') }}">
        @csrf
        <div>
            <label>Office:</label>
            <input type="text" name="office" required>
        </div>
        <div>
            <label>Requested By:</label>
            <input type="text" name="request_by" required>
        </div>
        <div>
            <label>Designation:</label>
            <input type="text" name="request_by_designation" required>
        </div>
        <table border="1">
            <thead>
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
                        <input type="number" name="items[{{ $loop->index }}][quantity]" min="0" max="{{ $supply->quantity }}" value="0">
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <button type="submit">Submit Request</button>
    </form>
    <a href="{{ route('dashboard') }}">Back to Dashboard</a>
</body>
</html>
