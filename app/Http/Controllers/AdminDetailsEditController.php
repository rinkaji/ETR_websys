<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminDetailsEditController extends Controller
{
    public function editAdmin()
    {
        $user = Auth()->user();
        return view('admin/editAdminDetails', compact('user'));
    }


    public function updateAdminDetails(Request $request)
    {
        $validated = $request->validate([
            'office' => 'required|string',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'password' => 'required|string|confirmed|min:8',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        auth()->user()->update([
            'office' => $validated['office'],
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);

        return redirect()->route('dashboard')->with('success', 'User Updated');
    }
}
