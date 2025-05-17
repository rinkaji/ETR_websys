<?php

namespace App\Models;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthModel {

    public function registerUser($data) {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'], 
            'password' => Hash::make($data['password']),
            'role' => $data['role']
        ]);
    }

    public function loginUser($credentials) {
        if (Auth::attempt($credentials)) {
            session()->regenerate();
            return true;
        }
        return false;
    }

    public function logoutUser() {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
    }
}
