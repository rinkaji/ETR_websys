<?php

namespace App\Http\Controllers;

use App\Models\request;
use App\Models\Request_Item;
use App\Models\Supply;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\DB;

class RequestController extends Controller
{
    // Office: Show create request form
    public function create()
    {
        $supplies = Supply::all();
        return view('office.request_create', compact('supplies'));
    }

    // Office: Store new request
    public function store(HttpRequest $request)
    {
        // Filter out items with quantity <= 0
        $filteredItems = collect($request->input('items', []))
            ->filter(function ($item) {
                return isset($item['quantity']) && $item['quantity'] > 0;
            })->values()->all();

        if (empty($filteredItems)) {
            return back()->withInput()->withErrors(['items' => 'Please request at least one item.']);
        }

        $validated = $request->validate([
            'office' => 'required|string|max:255',
            'request_by' => 'required|string|max:255',
            'request_by_designation' => 'required|string|max:255',
        ]);
        // Validate filtered items
        foreach ($filteredItems as $item) {
            if (
                !isset($item['supply_id']) ||
                !\App\Models\Supply::where('id', $item['supply_id'])->exists() ||
                !isset($item['quantity']) ||
                !is_numeric($item['quantity']) ||
                $item['quantity'] < 1
            ) {
                return back()->withInput()->withErrors(['items' => 'Invalid item or quantity.']);
            }
        }

        try {
            \DB::transaction(function () use ($request, $filteredItems) {
                $req = \App\Models\request::create([
                    'request_id' => uniqid('REQ-'),
                    'status' => 'pending',
                    'office' => $request->office,
                    'request_by' => $request->request_by,
                    'request_by_designation' => $request->request_by_designation,
                    'user_id' => auth()->id(),
                ]);
                foreach ($filteredItems as $item) {
                    \App\Models\Request_Item::create([
                        'request_id' => $req->id,
                        'supply_id' => $item['supply_id'],
                        'quantity' => $item['quantity'],
                    ]);
                }
            });
        } catch (\Throwable $e) {
            \Log::error('Request creation failed: '.$e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return back()->withInput()->withErrors(['error' => 'Failed to create request. Please contact admin.']);
        }

        return redirect()->route('dashboard')->with('success', 'Request submitted!');
    }

    // Admin: List all requests
    public function index()
    {
        $requests = request::with(['items.supply', 'user'])->orderBy('created_at', 'desc')->get();
        return view('admin.requests', compact('requests'));
    }

    // Admin: Accept request
    public function accept(request $request)
    {
        if ($request->status !== 'pending') {
            return back()->with('error', 'Request already processed.');
        }

        DB::transaction(function () use ($request) {
            foreach ($request->items as $item) {
                $supply = $item->supply;
                if ($supply->quantity < $item->quantity) {
                    throw new \Exception("Not enough stock for {$supply->item}");
                }
                $supply->quantity -= $item->quantity;
                $supply->save();
            }
            $request->status = 'accepted';
            $request->save();
        });

        return back()->with('success', 'Request accepted and supplies deducted.');
    }

    // Admin: Reject request
    public function reject(request $request)
    {
        if ($request->status !== 'pending') {
            return back()->with('error', 'Request already processed.');
        }
        $request->status = 'rejected';
        $request->save();
        return back()->with('success', 'Request rejected.');
    }
}
