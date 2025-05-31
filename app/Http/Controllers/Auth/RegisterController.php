<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AuthModel;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    protected $authModel;

    public function __construct() {
        $this->authModel = new AuthModel();
    }

    public function showRegistrationForm()
    {
        return view('Auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'office' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|confirmed|min:8',
            'role' => 'required|in:admin,office'
        ]);

        $this->authModel->registerUser($validated);

        return redirect()->route('login')
            ->with('success', 'Registration successful');
    }
}
