<h1>This is Stock Card Individual</h1>

{{-- <h3>{{$request_items->first()->supply->item}}</h3> --}}
<h2>Description</h2>

<table border="1">
    <thead>
        <tr>
            <th rowspan="2">Date</th>
            <th rowspan="2">Reference</th>
            <th rowspan="2">Receipt Qty</th>
            <th colspan="2">Issurance</th>
            <th rowspan="2">Balance Qty</th>
        </tr>
        <tr>
            <th>Qty</th>
            <th>Office</th>
        </tr>
    </thead>

    <tbody>
        @php
        $balance = 0;
        @endphp
        @foreach($monthlyData as $data)
        <tr>
            <td colspan="5">
                <p>Beginning Balance as of {{ $data['month'] }}: {{ $data['beginning_balance'] }}</p>
            </td>
            <td></td>
        </tr>

        {{-- @if($merged_groups->has($data['month']))
        @foreach ($merged_groups[$data['month']] as $item)
        <tr>
            <td>{{ $item['date']->format('m/d/Y') }}</td>
            <td>{{$item['supplies']}}</td>
            <td>{{$item['receipt_qty']}}</td>
            <td>{{$item['qty']}}</td>
            <td>{{$item['office']}}</td>
            <td></td>
        </tr>
        @endforeach
        @endif --}}

        @foreach($merged_groups as $items)
        @if(($items['date'] === $data['month']))
        <tr>
            <td>{{\Carbon\Carbon::parse($items['date'])->format('m/d/Y')}}</td>
            <td>{{$items['supplies']}}</td>
            @php
            $balance += (int)$items['receipt_qty'] ?? 0;
            $balance -= (int)$items['qty'] ?? 0;
            @endphp
            <td>{{$items['receipt_qty']}}</td>
            <td>{{$items['qty']}}</td>
            <td>{{$items['office']}}</td>
            <td>{{$balance}}</td>
        </tr>
        @endif

        @endforeach
        @endforeach
    </tbody>

</table>

{{-- <table border="1">
    <thead>
        <tr>
            <th rowspan="2">Date</th>
            <th rowspan="2">Reference</th>
            <th rowspan="2">Receipt Qty</th>
            <th colspan="2">Issurance</th>
            <th rowspan="2">Balance Qty</th>
        </tr>
        <tr>
            <th>Qty</th>
            <th>Office</th>
        </tr>
    </thead>

    @foreach ($grouped_items as $monthYear=> $items)


    <tbody>
        <tr>
            <td colspan="5">
                The beginning balance of {{ $monthYear }}
            </td>
            <td>24</td>
        </tr>
        @foreach ($items as $item)
        <tr>
            <td>{{ \Carbon\Carbon::parse($item->request->updated_at)->format('m/d/Y') }}</td>
            <td></td>
            <td></td>
            <td>{{ $item->quantity }}</td>
            <td>{{ $item->request->office }}</td>
            <td></td>
        </tr>
        @endforeach
    </tbody>
    @endforeach
</table> --}}

{{-- @foreach ($grouped_items aas $month => $entries)
<h2>{{ $month }}</h2>
<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>Type</th>
            <th>Date</th>
            <th>Details</th>
            <th>Quantity</th>
            <th>Unit</th>
            <th>Additional Info</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($entries as $entry)
        <tr>
            <td>{{ ucfirst($entry->type) }}</td>
            <td>{{ $entry->date->format('Y-m-d') }}</td>
            <td>
                @if ($entry->type === 'received')
                {{ $entry->item->item }}
                @else
                Requested by: {{ $entry->request->request_by ?? 'N/A' }}
                @endif
            </td>
            <td>
                @if ($entry->type === 'received')
                {{ $entry->item->quantity }}
                @else
                {{ $entry->item->quantity }}
                @endif
            </td>
            <td>
                @if ($entry->type === 'received')
                {{ $entry->item->unit }}
                @else
                {{ $entry->item->supply->unit ?? '' }}
                @endif
            </td>
            <td>
                @if ($entry->type === 'issued')
                Status: {{ ucfirst($entry->request->status) }}<br>
                Office: {{ $entry->request->office ?? 'N/A' }}
                @else
                Received from: {{ $entry->item->supply_from ?? 'N/A' }}
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endforeach --}}