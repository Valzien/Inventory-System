<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginPage()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (auth()->user()->role === 'direktur') {
                return redirect('/direktur/dashboard');
            }

            return redirect('/');
        }

        return back()->with('error', 'Email atau password salah');
    }

    public function loginDirekturPage()
    {
        return view('auth.login-direktur');
    }

    public function loginDirektur(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = auth()->user();

            if ($user->role !== 'direktur') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return back()->with('error', 'Akun ini bukan akun Direktur');
            }

            $request->session()->regenerate();
            return redirect('/direktur/dashboard');
        }

        return back()->with('error', 'Email atau password salah');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
