@extends('guest.layouts.index')

@section('title', 'Verifikasi Email')

@section('content')
    <div class="flex flex-col items-center justify-center px-4 py-8">
        <div
            class="w-full sm:max-w-md bg-white shadow-[0_20px_50px_rgba(0,0,0,0.05)] rounded-2xl p-8 md:p-10 border border-gray-100">

            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800 tracking-tight">
                    Verifikasi <span class="text-red-600">Email Anda</span>
                </h2>
                <p class="text-gray-500 mt-2 font-medium">
                    Kami telah mengirim link verifikasi ke <strong>{{ auth()->user()->email }}</strong>.
                    Link berlaku selama {{ config('auth.verification.expire') }} menit.
                </p>
            </div>

            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit"
                    class="w-full bg-red-600 hover:bg-red-700 text-white py-3.5 rounded-lg font-bold transition-all shadow-md hover:shadow-lg active:scale-[0.98] cursor-pointer">
                    Kirim Ulang Link Verifikasi
                </button>
            </form>

            <form method="POST" action="{{ route('auth.logout') }}" class="text-center pt-4 mt-6 border-t border-gray-100">
                @csrf
                <button type="submit" class="text-sm text-gray-500 hover:text-red-600 hover:underline cursor-pointer">
                    Keluar
                </button>
            </form>
        </div>
    </div>
@endsection
