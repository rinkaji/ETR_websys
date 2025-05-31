<?php

namespace App\Http\Controllers;

use App\Models\Request_Item;
use Illuminate\Http\Request;

class AdminOrderItemController extends Controller
{
    public function showOrderedItems($office = null)
    {
        if ($office != null) {
            $requestItems = Request_Item::with(['request', 'supply'])
                ->whereHas('request', function ($query) use ($office) {
                    $query->where('office', 'LIKE', '%' . $office . '%')->where('status', 'accepted');
                })
                ->get();

            $grandTotal = $requestItems->sum(function ($item) {
                return $item->supply->unit_cost * $item->quantity;
            });

            return view('admin/orderedItems', compact('requestItems', 'grandTotal'));
        }

        $requestItems = Request_Item::with(['request', 'supply'])->whereHas('request', function ($query) {
            $query->where('status', 'accepted');
        })->get();

        $grandTotal = $requestItems->sum(function ($item) {
            return $item->supply->unit_cost * $item->quantity;
        });

        return view('admin/orderedItems', compact('requestItems', 'grandTotal'));
    }
}
