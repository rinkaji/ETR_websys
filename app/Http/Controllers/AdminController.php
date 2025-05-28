<?php

namespace App\Http\Controllers;

use App\Models\Supply;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $supplies = Supply::all();
        return view('admin.dashboard', compact('supplies'));
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
        ]);

        Supply::create($validated);
        return redirect()->route('admin.index')->with('success', 'Supply created successfully');
    }

    public function dashboard()
    {
        if (auth()->user()->role === 'admin') {
            $supplies = Supply::all();
            return view('admin.dashboard', compact('supplies'));
        }
        return view('dashboard');
    }
}
