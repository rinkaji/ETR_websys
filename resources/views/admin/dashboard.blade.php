<h1 class="text-3xl font-bold mb-4">Admin Dashboard</h1>
<p class="text-lg">Welcome, <span class="font-semibold">{{ auth()->user()->name }}</span></p>
<p class="text-sm text-gray-600 mb-6">Email: {{ auth()->user()->email }}</p>

<a href="{{ route('admin.requests') }}" class="inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition mb-6">View Office Requests</a>

<h2 class="text-2xl font-semibold mt-8 mb-4">Admin Controls</h2>

<a href="{{ route('admin.create') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition mb-6">Create Supply</a>
<a href="{{ route('register') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition mb-6">Register Users</a>

<div class="overflow-x-auto bg-white shadow rounded-lg">
   <table border="1" class="min-w-full table-auto border-collapse">
    <thead>
        <tr class="bg-gray-100 text-gray-700 text-left text-sm uppercase tracking-wider">
            <th class="px-6 py-3 border-b">Item</th>
            <th class="px-6 py-3 border-b">Unit</th>
            <th class="px-6 py-3 border-b">Quantity</th>
            <th class="px-6 py-3 border-b">Purchase Supplies</th>
            <th class="px-6 py-3 border-b">Received Supplies</th>
            <th class="px-6 py-3 border-b">Issued Supplies</th>
            <th class="px-6 py-3 border-b">Inventory End</th>
            <th class="px-6 py-3 border-b">Total Cost</th>
            <th class="px-6 py-3 border-b">Unit Cost</th>
            <th class="px-6 py-3 border-b">Amount</th>
        </tr>
    </thead>
    <tbody class="text-sm text-gray-800">
        @foreach($supplies as $supply)
        <tr class="hover:bg-gray-50 transition">
            <td class="px-6 py-4 border-b">{{ $supply->item }}</td>
            <td class="px-6 py-4 border-b">{{ $supply->unit }}</td>
            <td class="px-6 py-4 border-b">{{ $supply->quantity }}</td>
            <td class="px-6 py-4 border-b">{{ $supply->purchase_supplies }}</td>
            <td class="px-6 py-4 border-b">{{ $supply->received_supplies }}</td>
            <td class="px-6 py-4 border-b">{{ $supply->issued }}</td>
            <td class="px-6 py-4 border-b">{{ $supply->inventory_end }}</td>
            <td class="px-6 py-4 border-b">{{  number_format($supply->quantity * $supply->unit_cost, 2) }}</td>
            <td class="px-6 py-4 border-b">{{ number_format($supply->unit_cost, 2) }}</td>
            <td class="px-6 py-4 border-b">
                {{number_format($supply->unit_cost, 2) }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

</div>

<form method="POST" action="{{ route('logout') }}" class="mt-6">
    @csrf
    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">Logout</button>
</form>
