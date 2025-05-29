<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <h1>This is oredered Items page</h1>
    <table>
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">Back to Dashboard</a><br>
        <a href="{{route('admin.orderedItems')}}">reset</a>
        <thead>
            <tr>
                <th>R.I.S No</th>
                <th>Department Office visited</th>
                <th>Item</th>
                <th>Unit</th>
                <th>Qty. Issued</th>
                <th>Unit Cost</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($requestItems as $item)
            <tr>
                <td>{{$item->request->request_id}}</td>
                <td><a href="{{route('admin.orderedItems', ['office' => $item->request->office])}}">{{$item->request->office}}
                    </a></td>
                <td>{{$item->Supply->item}}</td>
                <td>{{$item->Supply->unit}}</td>
                <td>{{$item->quantity}}</td>
                <td>{{$item->Supply->unit_cost}}</td>
                <td>{{($item->Supply->unit_cost * $item->quantity)}}</td>
            </tr>
            @endforeach
        </tbody>

        <tfoot>
            <tr>
                <td colspan="6" style="text-align: right;"><strong>Total:</strong></td>
                <td><strong>{{ $grandTotal }}</strong></td>
            </tr>
        </tfoot>
    </table>
</body>

</html>