@if (! app('request')->routeIs('stockCardAll.download'))
<a href="{{ route('stockCardAll.download') }}">Download to PDF</a>
@endif
<style>
    th,
    td {
        padding: 6px;
    }

    th {
        text-align: center;
    }

    .bottom-left {
        vertical-align: bottom;
        text-align: left;
    }

    .bottom-center {
        vertical-align: bottom;
        text-align: center;
    }

    .top-center {
        vertical-align: top;
        text-align: center;
    }

    .left {
        text-align: left;
    }

    .center {
        text-align: center;
    }

    .right {
        text-align: right;
    }

    .total {
        color: red;
        font-size: 16px;
        font-weight: bold;
    }

    .grand-total-issued {
        font-size: 20px;
        font-weight: bold;
    }
</style>

@php
$categories = [
'Office Supplies' => $supplies,
'Janitorial Supplies' => $janitorialSupplies,
'Medical Supplies' => $medicalSupplies
];

$grand = ['start' => 0, 'received' => 0, 'issued' => 0, 'end' => 0];

function formatCell($val) {
if (is_numeric($val)) {
return (floor($val) != $val)
? '<td class="right">'.number_format($val, 2).'</td>'
: '<td class="center">'.$val.'</td>';
}
return '<td class="left">'.$val.'</td>';
}
@endphp

<table border="1">
    <thead>
        <tr>
            <th colspan="12">January Inventory 2025<br>Pangasinan State University-Urdaneta Campus<br>Urdaneta City,
                Pangasinan</th>
        </tr>
        <tr>
            <td colspan="3" rowspan="2"></td>
            <td colspan="8" rowspan="2" style="text-align:end">To be filled up by the</td>
            <td></td>
        </tr>
        <tr>
            <td></td>
        </tr>
        <tr>
            <th class="bottom-left">Item</th>
            <th class="bottom-center">Unit</th>
            <th class="bottom-center">Qty</th>
            <th></th>
            <th class="top-center">Purchase Supplies<br>(Fund 05-206441)</th>
            <th class="top-center">Received from Lingayen</th>
            <th></th>
            <th class="bottom-center">Issued</th>
            <th class="bottom-center">Inventory End</th>
            <th class="bottom-center">Unit Cost</th>
            <th class="bottom-center">Amount</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($categories as $category => $items)
        @php
        $totals = ['start' => 0, 'received' => 0, 'issued' => 0, 'end' => 0];
        @endphp

        <tr>
            <td colspan="12" class="left"><b>{{ $category }}</b></td>
        </tr>

        @foreach ($items as $item)
        @php
        $startQty = 0;
        $unitCost = $item->unit_cost;
        $issued = DB::table('request_items')
        ->join('requests', 'request_items.request_id', '=', 'requests.id')
        ->where('request_items.supply_id', $item->id)
        ->where('requests.status', 'accepted')
        ->sum('request_items.quantity');

        $received = $item->supply_from_quantity;
        $receivedAmt = $received * $unitCost;
        $issuedAmt = $issued * $unitCost;
        $endAmt = $item->quantity * $unitCost;

        $totals['start'] += $startQty * $unitCost;
        $totals['received'] += $receivedAmt;
        $totals['issued'] += $issuedAmt;
        $totals['end'] += $endAmt;
        @endphp

        <tr>
            {!! formatCell($item->item) !!}
            {!! formatCell($item->unit) !!}
            {!! formatCell($startQty) !!}
            {!! formatCell($startQty * $unitCost ?: '-') !!}
            {!! formatCell($item->supply_from == 101 ? $received : '') !!}
            {!! formatCell($item->supply_from != 101 ? $received : '') !!}
            {!! formatCell($receivedAmt ?: '-') !!}
            {!! formatCell($issued) !!}
            {!! formatCell($item->quantity) !!}
            {!! formatCell($unitCost) !!}
            {!! formatCell($endAmt) !!}
            {!! formatCell($issuedAmt) !!}
        </tr>
        @endforeach

        <tr>
            <td colspan="3"></td>
            <td class="total">{{ number_format($totals['start'], 2) }}</td>
            <td colspan="2"></td>
            <td class="total">{{ number_format($totals['received'], 2) }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td class="total">{{ number_format($totals['end'], 2) }}</td>
            <td class="total">{{ number_format($totals['issued'], 2) }}</td>
        </tr>

        @php
        $grand['start'] += $totals['start'];
        $grand['received'] += $totals['received'];
        $grand['issued'] += $totals['issued'];
        $grand['end'] += $totals['end'];
        @endphp
        @endforeach

        <tr>
            <td colspan="12" style="height: 40px;"></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="2"><b><i>Grand Total</i></b></td>
            <td class=""><b>{{ number_format($grand['start'], 2) }}</b></td>
            <td></td>
            <td></td>
            <td class=""><b>{{ number_format($grand['received'], 2) }}</b></td>
            <td></td>
            <td></td>
            <td></td>
            <td class=""><b>{{ number_format($grand['end'], 2) }}</b></td>
            <td class="grand-total-issued">{{ number_format($grand['issued'], 2) }}</td>
        </tr>

        <!-- Signatories -->
        <tr>
            <td colspan="12" style="padding-top: 70px;">
                <table width="100%" style="text-align: center;">
                    <tr>
                        <td><b>{{auth()->user()->office}}</b><br><span>Supply Staff</span></td>
                        <td><b>ERNOMOBILLE M. PLACO</b><br><span>Campus Supply Officer</span></td>
                        <td><b>CHENNA ANNE C. LANDINGIN</b><br><span>Campus Accountant</span></td>
                        <td><b>ROY C. FERRER, PhD</b><br><span>Campus Executive Officer</span></td>
                    </tr>
                </table>
            </td>
        </tr>
    </tbody>
</table>