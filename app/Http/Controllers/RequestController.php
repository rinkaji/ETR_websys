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
        $validated = $request->validate([
            'office' => 'required|string|max:255',
            'request_by' => 'required|string|max:255',
            'request_by_designation' => 'required|string|max:255',
            'items' => 'required|array',
            'items.*.supply_id' => 'required|exists:supplies,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request) {
            $req = request::create([
                'request_id' => uniqid('REQ-'),
                'status' => 'pending',
                'office' => $request->office,
                'request_by' => $request->request_by,
                'request_by_designation' => $request->request_by_designation,
                'user_id' => auth()->id(),
            ]);
            foreach ($request->items as $item) {
                if ($item['quantity'] > 0) {
                    Request_Item::create([
                        'request_id' => $req->id,
                        'supply_id' => $item['supply_id'],
                        'quantity' => $item['quantity'],
                    ]);
                }
            }
        });

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
