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

        // Render ulang halaman login dengan error langsung via Inertia props
        // Ini tidak bergantung pada session flash yang rentan di Vercel serverless
        return Inertia::render('admin/login', [
            'errors' => ['email' => 'Email atau password salah.'],
        ])->toResponse($request)->setStatusCode(422);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin/login');
    }
}
