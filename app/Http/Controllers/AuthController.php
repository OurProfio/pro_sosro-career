<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\Applicant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

            if(auth()->user()->role === 'admin') {
                return redirect()->intended(route('admin.dashboard'));
            } else if(auth()->user()->role === 'user') {
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
