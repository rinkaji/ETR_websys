<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }

    th,
    td {
        border: 1px solid black;
    }

    /* Padding for item/description row */
    tr:nth-child(2) td,
    tr:nth-child(2) th {
        padding: 10px;
        vertical-align: bottom;
    }

    /* Text alignment per cell as requested */
    .bottom-left {
        vertical-align: bottom;
        text-align: left;
    }

    .bottom-middle {
        vertical-align: bottom;
        text-align: center;
    }

    .bottom-right {
        vertical-align: bottom;
        text-align: right;
    }

    .middle {
        vertical-align: middle;
        text-align: center;
    }
</style>

<table border="1">
    <thead>
        <tr>
            <th colspan="7">Stock Card <br> PSU-Urdaneta Campus <br> Agency</th>
        </tr>
        <tr>
            <td class="bottom-left">Item:</td>
            <th colspan="2" class="bottom-left">{{$itemName}}</th>
            <td class="bottom-middle">Description:</td>
            <th class="bottom-left">{{$description}}</th>
            <td class="bottom-right">Stock #:</td>
            <th></th>
        </tr>
        <tr>
            <th rowspan="2" class="bottom-left">Date</th>
            <th rowspan="2" class="bottom-middle">Reference</th>
            <th rowspan="2" class="middle">Receipt Qty</th>
            <th colspan="2">Issurance</th>
            <th rowspan="2" class="middle">Balance Qty</th>
            <th rowspan="2" class="middle">No. of Days Consume</th>
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
            <td colspan="2" class="bottom-left">
                Beginning Balance as of {{ $data['month'] }}: {{ $data['beginning_balance'] }}
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        @foreach($merged_groups as $items)
        @if((\Carbon\Carbon::parse($items['date'])->format('F Y') === $data['month']))
        <tr>
            <td class="bottom-left">{{\Carbon\Carbon::parse($items['date'])->format('m/d/Y')}}</td>
            <td class="bottom-middle"></td>
            @php
            $balance += (int)$items['receipt_qty'] ?? 0;
            $balance -= (int)$items['qty'] ?? 0;
            @endphp
            <td class="bottom-middle">{{$items['receipt_qty']}}</td>
            <td class="bottom-middle">{{$items['qty']}}</td>
            <td class="bottom-middle">{{$items['office']}}</td>
            <td class="bottom-middle">{{$balance}}</td>
            <td></td>
        </tr>
        @endif
        @endforeach
        @endforeach
    </tbody>
</table>