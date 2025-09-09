<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $credentials['email'])->first();
        if (!$user || $user->status !== 'active') {
            return back()->withInput($request->only('email'))
                ->withErrors(['email' => 'Akun tidak aktif atau tidak ditemukan.']);
        }

        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withInput($request->only('email'))
            ->withErrors(['password' => 'Password salah']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}


