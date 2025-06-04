<?php

namespace App\Http\Controllers;

use App\Models\Supply;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $totalSupplies = \App\Models\Supply::count();
        $pendingRequests = \App\Models\request::where('status', 'pending')->count();

        // Filter logic
        $query = \App\Models\Supply::query();
        if ($request->filled('search')) {
            $query->where('item', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('low_stock')) {
            $query->whereColumn('quantity', '<=', 'reorder_threshold');
        }
        $supplies = $query->get();

        $lowStockCount = \App\Models\Supply::whereColumn('quantity', '<=', 'reorder_threshold')->count();
        $lowStockActive = $lowStockCount > 0; // Always true if any item is low

        $categories = collect();

        return view('admin.dashboard', compact(
            'supplies',
            'totalSupplies',
            'pendingRequests',
            'categories',
            'lowStockCount',
            'lowStockActive'
        ));
    }

    public function create()
    {
        $units = \App\Models\Unit::all();
        return view('admin.create', compact('units'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'item' => 'required',
            'description' => 'required',
            'unit' => 'required',
            'type' => 'required',
            'quantity' => 'required|numeric',
            'unit_cost' => 'required|numeric',
            'supply_from' => 'required|in:164,161,184,101',
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

        $totalSupplies = \App\Models\Supply::count();
        $pendingRequests = \App\Models\request::where('status', 'pending')->count();

        // Filter logic
        $query = \App\Models\Supply::query();
        if ($request->filled('search')) {
            $query->where('item', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('low_stock')) {
            $query->whereColumn('quantity', '<=', 'reorder_threshold');
        }
        $supplies = $query->get();

        $lowStockCount = \App\Models\Supply::whereColumn('quantity', '<=', 'reorder_threshold')->count();
        $lowStockActive = $lowStockCount > 0; // Always true if any item is low

        $categories = collect();

        return view('admin.dashboard', compact(
            'supplies',
            'totalSupplies',
            'pendingRequests',
            'categories',
            'lowStockCount',
            'lowStockActive'
        ));
    }

    // Add/edit/delete supply items
    public function edit($id)
    {
        $supply = \App\Models\Supply::findOrFail($id);
        $units = \App\Models\Unit::all();
        return view('admin.edit', compact('supply', 'units'));
    }

    public function update(Request $request, $id)
    {
        $supply = \App\Models\Supply::findOrFail($id);
        $validated = $request->validate([
            'item' => 'required',
            'description' => 'required',
            'unit' => 'required',
            'quantity' => 'required|numeric',
            'unit_cost' => 'required|numeric',
            'supply_from' => 'required|in:164,161,184,101',
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
        // Delete related request_items first to avoid foreign key constraint error
        \App\Models\Request_Item::where('supply_id', $id)->delete();
        $supply->delete();

        \App\Models\AuditLog::create([
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
        $requests->each(function ($req) {
            if (empty($req->office)) {
                $req->office = 'Unknown';
            }
        });

        $departments = $requests->groupBy('office');

        return view('admin.history', compact('requests', 'departments', 'month'));
    }

    public function storeUnit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:units,name',
        ]);
        \App\Models\Unit::create($validated);
        return back()->with('success', 'Unit added!');
    }
}
