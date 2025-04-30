<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Redirect to the products page after successful login
            return redirect()->route('products.index');
        }

        return redirect()->back()->with('error', 'Invalid credentials')->withInput();
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login.form');
    }
}
