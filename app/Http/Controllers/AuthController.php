<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function showLogin()
    {
        return Inertia::render('admin/login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/admin/projects');
        }

        // TEST NUKLIR: Jika ini muncul, berarti server SUDAH tahu login gagal.
        dd([
            'status' => 'LOGIN GAGAL TERDETEKSI DI SERVER',
            'email_input' => $request->email,
            'session_id' => session()->getId(),
            'has_errors' => session()->get('errors') ? 'yes' : 'no'
        ]);

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin/login');
    }
}
