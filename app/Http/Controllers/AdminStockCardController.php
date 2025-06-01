<?php

namespace App\Http\Controllers;

use App\Models\request as ModelsRequest;
use App\Models\Request_Item;
use App\Models\Supply;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AdminStockCardController extends Controller
{
    // public function showSupplies()
    // {
    //     $supplies = Supply::all();
    //     return view('admin/stockCardList', compact('supplies'));
    // }
    protected function getBeginningBalance($date)
    {
        // logic to get balance before this month
    }
    protected function getTransactionsForMonth($date)
    {
        // logic to get receipts/issues for this month
    }

    public function showStockCard($item, $description, $unit)
    {
        $itemName = $item;
        $monthlyData = collect();
        $start = Carbon::createFromDate(now()->year, 1, 1);

        // Get and group request items once

        $supply_items = Supply::where(['item' => $item, 'description' => $description, 'unit' => $unit])->get();

        $grouped_supply = $supply_items->groupBy(function ($item) {
            return Carbon::parse($item->created_at)->format('F Y');
        });

        $formatted_supply = collect();
        foreach ($grouped_supply as $key => $group) {
            foreach ($group as $supply) {
                $formatted_supply->push([
                    'date' => $key,
                    'supplies' => $supply->supply_from == 'received' ? 'from lingayen' : '',
                    'receipt_qty' => $supply->quantity,
                    'qty' => '',
                    'office' => '',
                ]);
            }
        }

        $request_items = Request_Item::with(['supply', 'request'])
            ->whereHas('supply', function ($query) use ($item) {
                $query->where('item', $item);
            })
            ->whereHas('request', function ($query) {
                $query->where('status', 'accepted');
            })
            ->get();
        $grouped_items = $request_items->groupBy(function ($items) {
            return Carbon::parse($items->request->updated_at)->format('F Y');
        });
        $formatted_items = collect();
        foreach ($grouped_items as $items) {
            foreach ($items as $item) {
                $formatted_items->push([
                    'date' => $item->request->updated_at->format('F Y'),
                    'supplies' => '',
                    'receipt_qty' => '',
                    'qty' => $item->quantity,
                    'office' => $item->request->office,
                ]);
            }
        }
        $merged_groups = $formatted_supply->merge($formatted_items);

        // Build monthly data
        for ($i = 0; $i < 12; $i++) {
            $date = $start->copy()->addMonths($i);
            $monthName = $date->format('F Y');

            $beginningBalance = $this->getBeginningBalance($date);
            $transactions = $this->getTransactionsForMonth($date);

            $monthlyData->push([
                'month' => $monthName,
                'beginning_balance' => $beginningBalance,
                'transactions' => $transactions
            ]);
        }

        return view('admin.stockCard', compact('monthlyData', 'merged_groups', 'itemName', 'description'));
    }


    // public function showStockCard($id)
    // {
    //     // $request_item = Request_Item::where('supply_id', $id)->first();
    //     $request_items = Request_Item::with(['supply', 'request'])
    //         ->where('supply_id', $id) // ✅ filter by supply ID
    //         ->whereHas('request', function ($query) {
    //             $query->where('status', 'accepted'); // ✅ filter by request status
    //         })
    //         ->get();
    //     $grouped_items = $request_items->groupBy(function ($item) {
    //         return Carbon::parse($item->request->updated_at)->format('F Y');
    //     });



    //     return view('admin/stockCard', compact('grouped_items', 'request_items'));
    // }

    //     public function showStockCard($id)
    // {
    //     // Fetch supply for the given ID
    //     $supply = Supply::findOrFail($id);

    //     // Prepare "received" entry from Supply model
    //     $received = collect([
    //         (object)[
    //             'type' => 'received',
    //             'date' => Carbon::parse($supply->created_at),
    //             'item' => $supply,
    //         ]
    //     ]);

    //     // Fetch accepted request items linked to this supply
    //     $issued = Request_Item::with('request')
    //         ->where('supply_id', $id)
    //         ->whereHas('request', function ($q) {
    //             $q->where('status', 'accepted');
    //         })
    //         ->get()
    //         ->map(function ($item) {
    //             return (object)[
    //                 'type' => 'issued',
    //                 'date' => Carbon::parse($item->request->updated_at),
    //                 'item' => $item,
    //                 'request' => $item->request,
    //             ];
    //         });

    //     // Combine and group by month-year
    //     $combined = $received->merge($issued);

    //     $grouped_items = $combined->groupBy(function ($entry) {
    //         return $entry->date->format('F Y');
    //     });

    //     return view('admin.stockCard', compact('grouped_items'));
    // }
}
