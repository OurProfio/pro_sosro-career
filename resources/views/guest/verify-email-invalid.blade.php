@extends('guest.layouts.index')

@section('title', ($isExpired ?? false) ? 'Link Verifikasi Kedaluwarsa' : 'Link Verifikasi Tidak Valid')

@section('content')
    <div class="flex flex-col items-center justify-center px-4 py-8 min-h-full">
        <div
            class="w-full sm:max-w-md bg-white shadow-[0_20px_50px_rgba(0,0,0,0.05)] rounded-2xl p-8 md:p-10 border border-gray-100">

            <div class="flex justify-center mb-5">
                @if ($isExpired ?? false)
                    <div
                        class="w-14 h-14 rounded-2xl bg-amber-50 border border-amber-100 text-amber-600 flex items-center justify-center shadow-xs">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                @else
                    <div
                        class="w-14 h-14 rounded-2xl bg-red-50 border border-red-100 text-red-600 flex items-center justify-center shadow-xs">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                        </svg>
                    </div>
                @endif
            </div>

            <div class="text-center mb-8">
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 tracking-tight">
                    @if ($isExpired ?? false)
                        Link Verifikasi <span class="text-red-600">Kedaluwarsa</span>
                    @else
                        Link Verifikasi <span class="text-red-600">Tidak Valid</span>
                    @endif
                </h2>
                <p class="text-gray-500 mt-3 text-sm leading-relaxed font-medium">
                    @if ($isExpired ?? false)
                        Link verifikasi email ini sudah melewati batas waktu {{ config('auth.verification.expire') }}
                        menit sehingga tidak dapat digunakan lagi.
                    @else
                        Link verifikasi email ini tidak valid atau sudah rusak. Silakan minta link verifikasi baru untuk
                        mengaktifkan akun Anda.
                    @endif
                </p>
            </div>

            @if (auth()->check() && auth()->user()->hasVerifiedEmail())
                <div
                    class="mb-5 p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-sm text-emerald-700 font-medium text-center">
                    Email Anda (<strong>{{ auth()->user()->email }}</strong>) sudah terverifikasi sebelumnya.
                </div>

                <a href="{{ route('applicant.dashboard') }}"
                    class="block w-full text-center bg-red-600 hover:bg-red-700 text-white py-3.5 rounded-lg font-bold transition-all shadow-md hover:shadow-lg active:scale-[0.98] cursor-pointer">
                    Masuk ke Dashboard
                </a>
            @elseif (auth()->check())
                <p class="text-xs text-gray-500 text-center mb-4">
                    Kirim ulang link verifikasi baru ke <strong class="text-gray-700">{{ auth()->user()->email }}</strong>.
                </p>

                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit"
                        class="w-full bg-red-600 hover:bg-red-700 text-white py-3.5 rounded-lg font-bold transition-all shadow-md hover:shadow-lg active:scale-[0.98] cursor-pointer">
                        Kirim Ulang Link Verifikasi
                    </button>
                </form>

                <div class="flex items-center justify-center gap-4 pt-4 mt-6 border-t border-gray-100">
                    <a href="{{ route('guest.index') }}"
                        class="text-sm text-gray-500 hover:text-red-600 hover:underline font-medium">
                        Kembali ke Beranda
                    </a>
                    <span class="text-gray-300">|</span>
                    <form method="POST" action="{{ route('auth.logout') }}">
                        @csrf
                        <button type="submit"
                            class="text-sm text-gray-500 hover:text-red-600 hover:underline font-medium cursor-pointer">
                            Keluar
                        </button>
                    </form>
                </div>
            @else
                <a href="{{ route('guest.login') }}"
                    class="block w-full text-center bg-red-600 hover:bg-red-700 text-white py-3.5 rounded-lg font-bold transition-all shadow-md hover:shadow-lg active:scale-[0.98] cursor-pointer">
                    Masuk untuk Kirim Ulang Link
                </a>

                <div class="flex items-center justify-center pt-4 mt-6 border-t border-gray-100">
                    <a href="{{ route('guest.index') }}"
                        class="text-sm text-gray-500 hover:text-red-600 hover:underline font-medium">
                        Kembali ke Beranda
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
