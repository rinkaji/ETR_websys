<?php

namespace App\Http\Controllers;

use App\Models\Request_Item;
use App\Models\Supply;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class stockCardDownloadController extends Controller
{


    public function downloadStockCard(Request $request)
    {
        $item = $request->item;
        $description = $request->description;
        $unit = $request->unit;

        // Your logic from showStockCard() — reuse if possible
        $itemName = $item;
        $monthlyData = collect();
        $start = Carbon::createFromDate(now()->year, 1, 1);

        $supply_items = Supply::where([
            'item' => $item,
            'description' => $description,
            'unit' => $unit
        ])->get();

        $grouped_supply = $supply_items->groupBy(function ($item) {
            return Carbon::parse($item->created_at)->format('F Y');
        });

        $formatted_supply = collect();
        foreach ($grouped_supply as $key => $group) {
            foreach ($group as $supply) {
                $formatted_supply->push([
                    'raw_date' => Carbon::parse($supply->created_at)->startOfMonth(),
                    'date' => Carbon::parse($supply->created_at)->format('F Y'),
                    'supplies' => $supply->supply_from == 'received' ? 'from lingayen' : '',
                    'receipt_qty' => $supply->quantity,
                    'qty' => '',
                    'office' => '',
                ]);
            }
        }

        $request_items = Request_Item::with(['supply', 'request'])
            ->whereHas('supply', fn($q) => $q->where('item', $item))
            ->whereHas('request', fn($q) => $q->where('status', 'accepted'))
            ->get();

        $formatted_items = collect();
        foreach ($request_items->groupBy(fn($item) => Carbon::parse($item->request->updated_at)->format('F Y')) as $group) {
            foreach ($group as $item) {
                $formatted_items->push([
                    'raw_date' => Carbon::parse($item->request->updated_at)->startOfMonth(),
                    'date' => Carbon::parse($item->request->updated_at)->format('F Y'),
                    'supplies' => '',
                    'receipt_qty' => '',
                    'qty' => $item->quantity,
                    'office' => $item->request->office,
                ]);
            }
        }

        $merged_groups = $formatted_supply->merge($formatted_items)->sortBy('raw_date')->values();

        for ($i = 0; $i < 12; $i++) {
            $date = $start->copy()->addMonths($i);
            $monthlyData->push([
                'month' => $date->format('F Y'),
                'beginning_balance' => '', // implement getBeginningBalance($date) if needed
                'transactions' => ' ' // implement getTransactionsForMonth($date) if needed
            ]);
        }
        $monthYear = now()->format('F_Y'); // e.g. "June_2025"
        $filename = "{$monthYear}_{$itemName}.pdf";
        return Pdf::loadView('admin.stockCard', [
            'monthlyData' => $monthlyData,
            'merged_groups' => $merged_groups,
            'itemName' => $itemName,
            'description' => $description,
            'isPdf' => true // ← custom flag
        ])->download($filename);
    }
}
