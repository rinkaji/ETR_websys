<?php

namespace App\Http\Controllers;

use App\Models\Supply;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        // Quick stats
        $totalSupplies = \App\Models\Supply::count();
        $pendingRequests = \App\Models\request::where('status', 'pending')->count();
        $lowStockCount = \App\Models\Supply::whereColumn('quantity', '<=', 'reorder_threshold')->count();

        // Search & filter
        $query = \App\Models\Supply::query();
        if ($request->filled('search')) {
            $query->where('item', 'like', '%'.$request->search.'%');
        }
        $supplies = $query->get();

        // For filter dropdowns
        $categories = collect(); // empty collection or remove from view

        return view('admin.dashboard', compact(
            'supplies', 'totalSupplies', 'pendingRequests', 'categories', 'lowStockCount'
        ));
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'item' => 'required',
            'unit' => 'required',
            'quantity' => 'required|numeric',
            'unit_cost' => 'required|numeric',
            'supply_from' => 'required|in:purchased,received',
            'reorder_threshold' => 'required|integer|min:0',
        ]);

        $validated['supply_from_quantity'] = $validated['quantity'];

        Supply::create($validated);
        return redirect()->route('admin.index')->with('success', 'Supply created successfully');
    }

    public function dashboard(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            return view('dashboard');
        }

        // Quick stats
        $totalSupplies = \App\Models\Supply::count();
        $pendingRequests = \App\Models\request::where('status', 'pending')->count();
        $lowStockCount = \App\Models\Supply::whereColumn('quantity', '<=', 'reorder_threshold')->count();

        // Search & filter
        $query = \App\Models\Supply::query();
        if ($request->filled('search')) {
            $query->where('item', 'like', '%'.$request->search.'%');
        }
        $supplies = $query->get();

        // For filter dropdowns
        $categories = collect();

        return view('admin.dashboard', compact(
            'supplies', 'totalSupplies', 'pendingRequests', 'categories', 'lowStockCount'
        ));
    }

    // Add/edit/delete supply items
    public function edit($id)
    {
        $supply = \App\Models\Supply::findOrFail($id);
        return view('admin.edit', compact('supply'));
    }

    public function update(Request $request, $id)
    {
        $supply = \App\Models\Supply::findOrFail($id);
        $validated = $request->validate([
            'item' => 'required',
            'unit' => 'required',
            'quantity' => 'required|numeric',
            'unit_cost' => 'required|numeric',
            'supply_from' => 'required|in:purchased,received',
            'reorder_threshold' => 'required|integer|min:0',
        ]);
        // Do not update supply_from_quantity on update
        $supply->update($validated);

        AuditLog::create([
            'admin_id' => auth()->id(),
            'action' => 'update_supply',
            'details' => json_encode($validated),
        ]);

        return redirect()->route('dashboard')->with('success', 'Supply updated!');
    }

    public function destroy($id)
    {
        $supply = \App\Models\Supply::findOrFail($id);
        $supply->delete();

        AuditLog::create([
            'admin_id' => auth()->id(),
            'action' => 'delete_supply',
            'details' => json_encode(['supply_id' => $id]),
        ]);

        return redirect()->route('dashboard')->with('success', 'Supply deleted!');
    }

    public function history(Request $request)
    {
        $month = $request->query('month', date('m'));
        $requests = \App\Models\request::with(['items.supply', 'user'])
            ->whereMonth('created_at', $month)
            ->orderBy('created_at', 'desc')
            ->get();

        // Ensure 'office' is always a string for grouping
        $requests->each(function($req) {
            if (empty($req->office)) {
                $req->office = 'Unknown';
            }
        });

        $departments = $requests->groupBy('office');

        return view('admin.history', compact('requests', 'departments', 'month'));
    }
}
