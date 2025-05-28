<!DOCTYPE html>
<html>
<head>
    <title>Office Requests</title>
</head>
<body>
    <h1>Office Requests</h1>
    <table border="1">
        <thead>
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
                            <button type="submit">Accept</button>
                        </form>
                        <form method="POST" action="{{ route('admin.requests.reject', $req) }}" style="display:inline;">
                            @csrf
                            <button type="submit">Reject</button>
                        </form>
                    @else
                        {{ ucfirst($req->status) }}
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('dashboard') }}">Back to Dashboard</a>
</body>
</html>
