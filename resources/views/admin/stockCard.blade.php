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

    .icon-crud {
        height: 12px !important;
        margin-right: 8px;
    }
</style>

@if (empty($isPdf))
<!-- Back button at the top -->
<a href="{{ route('dashboard') }}" style="
     display: inline-flex;
     align-items: center;
     gap: 6px;
     background-color: white;  /* white background */
     color: black;             /* black text */
     padding: 8px 16px;
     border-radius: 6px;
     font-weight: 600;
     font-size: 14px;
     font-family: Arial, Helvetica, sans-serif;
     text-decoration: none;
     border: none;
     cursor: pointer;
     box-shadow: 0 2px 6px rgba(0,0,0,0.1);
     transition: background-color 0.3s ease;
     margin-bottom: 16px;
     width: fit-content;
     border: 1px solid #ddd;
   " onmouseover="this.style.backgroundColor='#f0f0f0'" onmouseout="this.style.backgroundColor='white'">
    <img src="{{ asset('images/back_icon.png') }}" alt="Back Icon" style="width:16px; height:16px;">
    Back to Dashboard
</a>
@endif



<table border="1">
    <thead>
        <tr>
            <th colspan="7">Stock Card <br> PSU-Urdaneta Campus <br> Agency</th>
        </tr>
        <tr>
            <td class="bottom-left">Item:</td>
            <th colspan="2" class="bottom-left">{{urldecode($itemName)}}</th>
            <td class="bottom-middle">Description:</td>
            <th class="bottom-left">{{urldecode($description)}}</th>
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
@if (empty($isPdf))
<a href="{{ route('stockCard.download', ['item' => request('item'), 'description' => request('description'), 'unit' => request('unit')]) }}"
    target="_blank" style="
     display: inline-flex;
     align-items: center;
     gap: 8px;
     background-color: #0d6efd;
     color: white;
     padding: 12px 20px;
     border-radius: 6px;
     font-weight: 600;
     font-size: 14px;
     font-family: Arial, Helvetica, sans-serif;
     text-decoration: none;
     border: none;
     cursor: pointer;
     box-shadow: 0 2px 6px rgba(13,110,253,0.4);
     transition: background-color 0.3s ease;
     margin-top: 16px;
   " onmouseover="this.style.backgroundColor='#0b5ed7'" onmouseout="this.style.backgroundColor='#0d6efd'">
    <img src="{{ asset('images/printer-stroke-rounded.svg') }}" alt="Print Icon" style="width:20px; height:20px;">
    Download as PDF
</a>




@endif