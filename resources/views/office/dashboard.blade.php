<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h1>Office Dashboard</h1>
<p>Welcome, {{ auth()->user()->name }}</p>
<p>Email: {{ auth()->user()->email }}</p>

<a href="{{ route('request.create') }}">Create Supply Request</a>

<h2>My Requests</h2>
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

<!-- <h2>Office Controls</h2>
<ul>
    <li>My Documents</li>
    <li>Submit Reports</li>
    <li>View Schedule</li>
</ul> -->

<div>
    <table border="1">
        <thead>
            <tr>
                <th>Unit</th>
                <th>Description</th>
                <th>Quantity</th>
                <th>Stock Availability</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    
                </td>
            </tr>
        </tbody>
    </table>
</div>

<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit">Logout</button>
</form>

</body>
</html>