<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - PSU Urdaneta Supply Office</title>
    <style>
        body {
            font-family: sans-serif;
        }

        h1,
        h2 {
            color: #003366;
            margin-bottom: 1rem;
        }

        .button {
            display: inline-block;
            background-color: #003366;
            color: white;
            padding: 0.5rem 1rem;
            text-decoration: none;
            margin-bottom: 1rem;
            transition: background-color 0.2s ease;
            border: none;
        }

        .button:hover {
            background-color: #002244;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 0.75rem;
            text-align: left;
        }

        th {
            background-color: #f3f3f3;
            text-transform: uppercase;
            font-size: 0.85rem;
            color: #333;
        }

        tr:hover {
            background-color: #f9f9f9;
        }

        .logout-btn {
            background-color: #cc0000;
            color: white;
            padding: 0.5rem 1rem;
            border: none;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .logout-btn:hover {
            background-color: #990000;
        }
    </style>
</head>

<body>
    <h1>Admin Dashboard</h1>
    <p>Welcome, <strong style="color: #003366;">{{ auth()->user()->name }}</strong></p>
    <p style="color: #666; font-size: 0.9rem; margin-bottom: 1.5rem;">Email: {{ auth()->user()->email }}</p>

    <h2>Admin Controls</h2>

    <a href="{{ route('admin.create') }}" class="button">Create Supply</a>
    <a href="{{ route('register') }}" class="button">Register Users</a>

    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th>Unit</th>
                <th>Quantity</th>
                <th>Purchase Supplies</th>
                <th>Received Supplies</th>
                <th>Issued Supplies</th>
                <th>Inventory End</th>
                <th>Total Cost</th>
                <th>Unit Cost</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($supplies as $supply)
            <tr>
                <td>{{ $supply->item }}</td>
                <td>{{ $supply->unit }}</td>
                <td>{{ $supply->quantity }}</td>
                <td>{{ $supply->purchase_supplies }}</td>
                <td>{{ $supply->received_supplies }}</td>
                <td>{{ $supply->issued }}</td>
                <td>{{ $supply->inventory_end }}</td>
                <td>{{ number_format($supply->quantity * $supply->unit_cost, 2) }}</td>
                <td>{{ number_format($supply->unit_cost, 2) }}</td>
                <td>{{ number_format($supply->unit_cost, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <form method="POST" action="{{ route('logout') }}" style="margin-top: 1.5rem;">
        @csrf
        <button type="submit" class="logout-btn">Logout</button>
    </form>
</body>

</html>