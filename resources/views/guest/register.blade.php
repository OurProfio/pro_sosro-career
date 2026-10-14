@extends('guest.layouts.index')

@section('title', 'Daftar')

@section('content')
    <div class="flex flex-col items-center justify-center px-4 py-8">
        <div
            class="w-full sm:max-w-lg bg-white shadow-[0_20px_50px_rgba(0,0,0,0.05)] rounded-2xl p-8 md:p-10 border border-gray-100">

            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800 tracking-tight">
                    Buat <span class="text-red-600">Akun Baru</span>
                </h2>
                <p class="text-gray-500 mt-2 font-medium">Mulai langkah karier Anda bersama PT Sinar Sosro Gunung Slamat.</p>
            </div>

            @if (session('status'))
                <div
                    class="mb-4 p-3 rounded-lg bg-green-50 border border-green-200 font-medium text-sm text-green-700 text-center">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('guest.register.post') }}" onsubmit="return disableButton(this)"
                class="space-y-5">
                @csrf
                <div>
                    <label for="email" class="block font-semibold text-gray-700 text-sm mb-1">Alamat Email</label>
                    <div class="relative flex items-center">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                            </svg>
                        </div>
                        <input id="email"
                            class="block w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-4 focus:ring-red-50 focus:border-red-500 focus:bg-white transition-all outline-none"
                            type="email" name="email" value="{{ old('email') }}" required
                            placeholder="nama@email.com" />
                    </div>
                    @error('email')
                        <p class="text-sm text-red-600 mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="password" class="block font-semibold text-gray-700 text-sm mb-1">Password</label>
                        <input id="password" type="password" name="password"
                            class="block w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 text-sm focus:ring-4 focus:ring-red-50 focus:border-red-500 focus:bg-white transition-all outline-none pr-11"
                            required placeholder="••••••••" />

                    </div>

                    <div>
                        <label for="password_confirmation" class="block font-semibold text-gray-700 text-sm mb-1">Konfirmasi
                            Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation"
                            class="block w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 text-sm focus:ring-4 focus:ring-red-50 focus:border-red-500 focus:bg-white transition-all outline-none pr-11"
                            required placeholder="••••••••" />
                    </div>
                </div>

                {{-- ERROR MESSAGES FOR PASSWORD --}}
                @if ($errors->has('password') || $errors->has('password_confirmation'))
                    <div class="space-y-1">
                        @error('password')
                            <p class="text-sm text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                        @error('password_confirmation')
                            <p class="text-sm text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                @endif

                <div class="pt-2">
                    <button type="submit"
                        class="w-full bg-red-600 hover:bg-red-700 text-white py-3.5 rounded-lg font-bold transition-all shadow-md hover:shadow-lg active:scale-[0.98] disabled:opacity-70 disabled:cursor-not-allowed disabled:active:scale-100 cursor-pointer flex justify-center items-center">
                        <span id="btn-text">Daftarkan Akun</span>
                        <svg id="btn-icon" class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </button>
                </div>
            </form>

            <div class="flex flex-col items-center space-y-3 mt-2 border-t border-gray-100">
                <p class="text-sm text-gray-500">
                    Sudah terdaftar?
                    <a href="{{ route('guest.login') }}"
                        class="text-red-600 hover:text-red-700 hover:underline font-bold ml-1 cursor-pointer">
                        Masuk di sini
                    </a>
                </p>
            </div>

            <p class="text-center text-xs text-gray-400 mt-5">
                PT Sinar Sosro Gunung Slamat. Seluruh data Anda terjaga kerahasiaannya.
            </p>
        </div>
    </div>
@endsection
