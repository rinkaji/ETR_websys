<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Models\AuthModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    protected $authModel;

    public function __construct()
    {
        $this->authModel = new AuthModel();
    }

    public function showLoginForm()
    {
        return view('Auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            // 'role' => 'required|in:admin,office'
        ]);

        if ($this->authModel->loginUser($credentials)) {
            // $user = Auth::user();
            // if ($user->role !== $request->role) {
            //     $this->authModel->logoutUser();
            //     return back()->withErrors([
            //         'role' => 'Invalid role selected for this account'
            //     ]);
            // }
            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials'
        ]);
    }

    public function logout(Request $request)
    {
        $this->authModel->logoutUser();
        return redirect()->route('login');
    }
}
