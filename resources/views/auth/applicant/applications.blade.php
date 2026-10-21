@extends('auth.applicant.layouts.index')

@section('title', 'Riwayat Lamaran Saya')

@section('content')
    <div class="py-8 md:py-12 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto font-figtree">
        {{-- Header Section --}}
        <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-2xl md:text-3xl font-black text-gray-900 tracking-tight">
                    Riwayat <span class="text-[#B11116]">Lamaran Saya</span>
                </h2>
                <p class="text-gray-500 mt-1 font-medium text-sm">
                    Pantau status dan perkembangan lamaran pekerjaan Anda secara langsung.
                </p>
            </div>

            {{-- Counter Badge --}}
            @php
                $activeCount = $applications->whereNotIn('status', ['rejected', 'cancelled'])->count();
            @endphp
            <div
                class="inline-flex items-center px-5 py-2.5 bg-white border border-gray-100 rounded-2xl shadow-sm self-start md:self-auto gap-4">
                <div class="flex items-center">
                    <div
                        class="w-8 h-8 rounded-xl bg-red-50 text-[#B11116] flex items-center justify-center mr-3 shrink-0 font-bold">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-[10px] uppercase tracking-widest font-black text-gray-400 leading-none mb-1">
                            Kuota Aktif
                        </span>
                        <span class="text-sm font-bold {{ $activeCount >= 3 ? 'text-amber-600' : 'text-gray-800' }} leading-none">
                            {{ $activeCount }} / 3 Posisi
                        </span>
                    </div>
                </div>
                <div class="h-8 w-px bg-gray-200"></div>
                <div class="flex flex-col">
                    <span class="text-[10px] uppercase tracking-widest font-black text-gray-400 leading-none mb-1">
                        Total Riwayat
                    </span>
                    <span class="text-sm font-bold text-gray-600 leading-none">
                        {{ $applications->count() }} Lamaran
                    </span>
                </div>
            </div>
        </div>

        {{-- MAIN CONTENT AREA --}}
        @if ($applications->isEmpty())
            {{-- EMPTY STATE: Jika belum ada lamaran --}}
            <div
                class="bg-white rounded-2xl p-8 md:p-12 border border-gray-100 shadow-sm text-center max-w-2xl mx-auto my-6">
                <div
                    class="w-20 h-20 bg-red-50 text-[#B11116] rounded-full flex items-center justify-center mx-auto mb-5 shadow-inner">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                </div>

                <h3 class="text-xl font-bold text-gray-900 mb-2">
                    Belum Ada Lamaran
                </h3>
                <p class="text-gray-500 text-sm leading-relaxed max-w-md mx-auto mb-8">
                    Sepertinya Anda belum melamar pekerjaan apapun saat ini. Jelajahi posisi menarik dan mulai karir Anda
                    bersama kami.
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
                    <a href="{{ route('applicant.dashboard') }}"
                        class="w-full sm:w-auto px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-xs rounded-xl transition-all inline-flex items-center justify-center gap-2 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali ke Dashboard
                    </a>

                    <a href="{{ route('guest.index') }}/#lowongan"
                        class="w-full sm:w-auto px-6 py-2.5 bg-[#B11116] hover:bg-red-800 text-white font-bold text-xs rounded-xl shadow-md transition-all inline-flex items-center justify-center gap-2 cursor-pointer active:scale-95">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Cari Lowongan Sekarang
                    </a>
                </div>
            </div>
        @else
            {{-- LIST STATE: Jika sudah melamar posisi --}}
            <div class="space-y-4">
                @foreach ($applications as $app)
                    <div
                        class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition-all flex flex-col md:flex-row md:items-center justify-between gap-6">
                        <div class="space-y-2">
                            <div class="flex items-center gap-2">
                                <span class="text-xs text-gray-400 font-medium">
                                    Melamar pada
                                    {{ \Carbon\Carbon::parse($app->created_at)->locale('id')->translatedFormat('d M Y') }}
                                </span>
                            </div>

                            <h3 class="text-xl font-bold text-gray-900">
                                {{ $app->job->title }}
                            </h3>

                            <div class="flex items-center gap-4 text-xs text-gray-500 font-medium">
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    {{ $app->job->office?->name ?? '-' }}
                                </span>
                                <span>•</span>
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ $app->job->location }}
                                </span>
                            </div>
                        </div>

                        <div
                            class="flex flex-col sm:flex-row items-start sm:items-center gap-3 pt-4 md:pt-0 border-t md:border-t-0 border-gray-100">
                            @php
                                $statusClasses = match (strtolower($app->status ?? 'pending')) {
                                    'accepted', 'hired' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                    'rejected' => 'bg-rose-50 text-rose-700 border-rose-200',
                                    'cancelled' => 'bg-gray-100 text-gray-600 border-gray-200',
                                    default => 'bg-amber-50 text-amber-700 border-amber-200',
                                };

                                $statusLabels = [
                                    'pending' => 'Dalam Peninjauan',
                                    'progress' => 'Sedang Diproses',
                                    'accepted' => 'Diterima',
                                    'hired' => 'Diterima',
                                    'rejected' => 'Ditolak',
                                    'cancelled' => 'Dibatalkan',
                                ];
                                $status = strtolower($app->status ?? 'pending');
                                $canCancel = ($status === 'pending');
                            @endphp
                            <span class="px-3.5 py-1.5 border rounded-xl text-xs font-bold {{ $statusClasses }}">
                                Status: {{ $statusLabels[$status] ?? 'Dalam Peninjauan' }}
                            </span>

                            @if ($canCancel)
                                <form action="{{ route('applications.cancel', $app->id) }}" method="POST"
                                    onsubmit="return confirm('Apakah Anda yakin ingin membatalkan lamaran pekerjaan ini? Tindakan ini tidak dapat dibatalkan kembali.');">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="px-3.5 py-1.5 bg-white border border-gray-200 hover:border-red-300 hover:bg-red-50 text-gray-500 hover:text-[#B11116] text-xs font-bold rounded-xl transition-all inline-flex items-center gap-1.5 cursor-pointer active:scale-95 shadow-sm"
                                        title="Batalkan Lamaran Ini">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Batalkan Lamaran
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8 flex justify-between items-center border-t border-gray-100 pt-6">
                <a href="{{ route('applicant.dashboard') }}"
                    class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-xs rounded-xl transition-all inline-flex items-center gap-2 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Dashboard
                </a>

                <a href="{{ route('guest.index') }}/#lowongan"
                    class="px-6 py-2.5 bg-[#B11116] hover:bg-red-800 text-white font-bold text-xs rounded-xl shadow-md transition-all inline-flex items-center gap-2 cursor-pointer active:scale-95">
                    Cari Lowongan Lainnya
                </a>
            </div>
        @endif
    </div>
@endsection
