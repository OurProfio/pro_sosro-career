<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (auth()->user()->role === 'admin') {
                return redirect()->intended(route('admin.dashboard'));
            } elseif (auth()->user()->role === 'user') {
                return redirect()->intended(route('applicant.dashboard'));
            }
        }

        return back()->with('error', 'Email atau password yang Anda masukkan salah.')->withInput();
    }

    public function register(RegisterRequest $request)
    {
        User::create([
            'email' => $request->email,
            'password' => $request->password,
        ]);

        return redirect()->route('guest.login')->with('success', 'Pendaftaran berhasil. Silakan masuk dengan akun Anda.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('guest.login');
    }
}
