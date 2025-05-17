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