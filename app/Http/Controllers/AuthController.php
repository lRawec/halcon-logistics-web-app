<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();
            return redirect()->intended('dashboard')
                ->with('success', "Welcome back, {$user->username}!");
        }

        return back()->withErrors([
            'username' => 'El usuario o la contraseña son incorrectos.',
        ])->withInput($request->only('username'));
    }

    public function logout(Request $request)
    {
        $username = Auth::user()->username;
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')
            ->with('info', "You have logged out successfully, {$username}. See you soon!");
    }
}
