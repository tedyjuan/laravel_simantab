<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {

            $request->session()->regenerate();

            return response()->json([
                'success' => true,
                'message' => 'Login berhasil.',
                'redirect' => route('dashboard'),
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Username atau password salah.',
            'errors' => [
                'username' => [
                    'Username atau password salah.'
                ]
            ]
        ], 422);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route('login'));
    }
}
