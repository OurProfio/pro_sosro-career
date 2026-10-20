@extends('guest.layouts.index')

@section('title', 'Masuk Admin')

@section('content')
    <div class="flex flex-col items-center justify-center px-4 py-8 min-h-full">

        <div
            class="w-full sm:max-w-md bg-white shadow-[0_20px_50px_rgba(0,0,0,0.05)] rounded-2xl p-8 md:p-10 border border-gray-100">

            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-[#FFC72C]/20 text-[#d97706] mb-3">
                    <i data-lucide="shield-check" class="w-6 h-6 text-gray-900"></i>
                </div>
                <h2 class="text-3xl font-bold text-gray-800 tracking-tight">
                    Masuk sebagai <span class="text-[#d97706]">Admin</span>
                </h2>
                <p class="text-gray-500 mt-2 font-medium text-sm">
                    Silakan masuk menggunakan akun administrator Anda untuk mengelola sistem rekrutmen.
                </p>
            </div>

            @if (session('status'))
                <div
                    class="mb-4 p-3 rounded-lg bg-green-50 border border-green-200 font-medium text-sm text-green-700 text-center">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.post') }}" onsubmit="return disableButton(this)" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block font-semibold text-gray-700 text-sm mb-1">Email Administrator</label>
                    <input id="email" type="email" name="email"
                        class="block w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 text-sm focus:ring-4 focus:ring-[#FFC72C]/30 focus:border-[#FFC72C] focus:bg-white transition-all outline-none"
                        value="{{ old('email') }}" required autofocus placeholder="admin@sosro.com" />

                    @error('email')
                        <p class="text-sm text-red-600 mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="password" class="block font-semibold text-gray-700 text-sm mb-1">Password</label>
                    <input id="password" type="password" name="password"
                        class="block w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 text-sm focus:ring-4 focus:ring-[#FFC72C]/30 focus:border-[#FFC72C] focus:bg-white transition-all outline-none pr-12"
                        required placeholder="••••••••" />
                    @error('password')
                        <p class="text-sm text-red-600 mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-2">
                    <button type="submit"
                        class="w-full bg-[#FFC72C] hover:bg-[#f0b815] text-gray-900 py-3.5 rounded-lg font-bold transition-all shadow-md hover:shadow-lg active:scale-[0.98] disabled:opacity-70 disabled:cursor-not-allowed disabled:active:scale-100 cursor-pointer">
                        <span id="btn-text">Masuk ke Portal Admin</span>
                    </button>
                </div>
            </form>

            <div class="flex flex-col items-center space-y-2 pt-6 mt-6 border-t border-gray-100">
                <a href="{{ route('guest.login') }}"
                    class="text-xs text-gray-500 hover:text-red-700 hover:underline font-semibold flex items-center gap-1.5 transition">
                    <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                    Bukan administrator? Masuk sebagai Pelamar
                </a>
            </div>
        </div>
    </div>
@endsection
