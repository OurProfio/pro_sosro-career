@extends('guest.layouts.index')

@section('title', 'Masuk')

@section('content')
    <div class="flex flex-col items-center justify-center px-4 py-8 min-h-full">

        <div
            class="w-full sm:max-w-md bg-white shadow-[0_20px_50px_rgba(0,0,0,0.05)] rounded-2xl p-8 md:p-10 border border-gray-100">

            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800 tracking-tight">
                    Masuk ke <span class="text-red-600">Akun Anda</span>
                </h2>
                <p class="text-gray-500 mt-2 font-medium">Selamat datang kembali! Silakan masuk untuk melanjutkan.</p>
            </div>

            @if (session('error'))
                <div
                    class="mb-4 p-3 rounded-lg bg-red-50 border border-red-200 font-medium text-sm text-red-700 text-center">
                    {{ session('error') }}
                </div>
            @endif

            @if (session('warning') || request('required'))
                <div class="mb-4 p-3.5 rounded-xl bg-amber-50 border border-amber-200 font-medium text-xs text-amber-800 text-center flex items-center justify-center gap-2">
                    <svg class="w-4 h-4 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <span>{{ session('warning') ?? 'Silakan masuk (login) terlebih dahulu untuk dapat melamar lowongan pekerjaan.' }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('guest.login.post') }}" onsubmit="return disableButton(this)" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block font-semibold text-gray-700 text-sm mb-1">Email</label>
                    <input id="email" type="email" name="email"
                        class="block w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 text-sm focus:ring-4 focus:ring-red-50 focus:border-red-500 focus:bg-white transition-all outline-none"
                        value="{{ old('email') }}" required autofocus placeholder="Masukkan email Anda" />

                    @error('email')
                        <p class="text-sm text-red-600 mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="password" class="block font-semibold text-gray-700 text-sm mb-1">Password</label>
                    <input id="password" type="password" name="password"
                        class="block w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 text-sm focus:ring-4 focus:ring-red-50 focus:border-red-500 focus:bg-white transition-all outline-none pr-12"
                        required placeholder="••••••••" />
                    @error('password')
                        <p class="text-sm text-red-600 mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-2">
                    <button type="submit"
                        class="w-full bg-red-600 hover:bg-red-700 text-white py-3.5 rounded-lg font-bold transition-all shadow-md hover:shadow-lg active:scale-[0.98] disabled:opacity-70 disabled:cursor-not-allowed disabled:active:scale-100 cursor-pointer">
                        <span id="btn-text">Masuk</span>
                    </button>
                </div>
            </form>

            <div class="flex flex-col items-center space-y-3 pt-3 border-t border-gray-100">
                <p class="text-sm text-gray-500">
                    Belum punya akun?
                    <a href="{{ route('guest.register') }}"
                        class="text-red-600 hover:text-red-700 hover:underline font-bold ml-1 cursor-pointer">
                        Daftar di sini
                    </a>
                </p>
            </div>
        </div>
    </div>
@endsection
