@extends('auth.applicant.layouts.index')

@section('title', 'Dashboard Pelamar')

@section('content')
    <div class="py-8 md:py-12 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800 tracking-tight">
                    Selamat datang, <span class="text-red-600">{{ auth()->user()->applicant?->name ?: 'Pelamar' }}</span>
                </h2>

                <p class="text-gray-500 mt-1 font-medium">
                    Kelola profil dan pantau perkembangan lamaran Anda dari sini.
                </p>
            </div>

            @php
                $applicant = auth()->user()->applicant;
                $isBiodataComplete = $applicant && $applicant->isProfileComplete();
                $inProgressApp = $applicant ? $applicant->applications()->where('status', 'progress')->with(['job', 'stage'])->latest()->first() : null;
                $hasApplications = $applicant && $applicant->applications()->exists();
            @endphp

            <div class="inline-flex items-center px-5 py-2.5 bg-white border border-gray-100 rounded-2xl shadow-sm">
                @if ($isBiodataComplete)
                    <div class="relative flex h-3 w-3 mr-4">
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                    </div>

                    <div class="flex flex-col">
                        <span class="text-[10px] uppercase tracking-widest font-bold text-gray-400 leading-none mb-1">
                            Status Profil
                        </span>

                        <span class="text-sm font-bold text-emerald-600 leading-none">
                            Lengkap & Siap Melamar
                        </span>
                    </div>
                @else
                    <div class="relative flex h-3 w-3 mr-4">
                        <span
                            class="animate-ping absolute inline-flex h-full w-full bg-amber-400 opacity-75 rounded-full"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-amber-500"></span>
                    </div>

                    <div class="flex flex-col">
                        <span class="text-[10px] uppercase tracking-widest font-bold text-gray-400 leading-none mb-1">
                            Status Profil
                        </span>

                        <span class="text-sm font-bold text-gray-700 leading-none">
                            Perlu Dilengkapi
                        </span>
                    </div>
                @endif
            </div>
        </div>


        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-50 overflow-hidden relative group">
                    <div
                        class="absolute -right-20 -top-20 w-60 h-60 bg-red-50 rounded-full opacity-50 group-hover:scale-110 transition-transform duration-500">
                    </div>

                    <div class="relative">

                        <h3 class="text-xl font-bold text-gray-800 mb-5 flex items-center justify-between">
                            <span>Langkah Persiapan</span>
                            <span class="text-xs font-semibold text-gray-400">
                                {{ $isBiodataComplete ? '1 dari 2 Langkah Selesai' : '0 dari 2 Langkah Selesai' }}
                            </span>
                        </h3>

                        <div class="space-y-5">
                            {{-- LANGKAH 1: LENGKAPI BIODATA --}}
                            <div class="flex items-start">
                                @if ($isBiodataComplete)
                                    <div
                                        class="flex-shrink-0 w-8 h-8 bg-emerald-600 text-white rounded-lg flex items-center justify-center font-bold text-sm shadow-xs">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>

                                    <div class="ml-4 flex-1">
                                        <div class="flex items-center gap-2">
                                            <p class="text-gray-900 font-bold">
                                                Lengkapi Profil Biodata
                                            </p>
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                                </svg>
                                                Selesai
                                            </span>
                                        </div>

                                        <p class="text-gray-500 text-sm mt-0.5">
                                            Data pribadi, keluarga, pendidikan, dan pengalaman kerja Anda sudah lengkap.
                                        </p>

                                        <a href="{{ route('biodata.index') }}"
                                            class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-700 hover:text-emerald-800 mt-1 hover:underline">
                                            <span>Lihat / perbarui profil biodata</span>
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </a>
                                    </div>
                                @else
                                    <div
                                        class="flex-shrink-0 w-8 h-8 bg-[#B11116] text-white rounded-lg flex items-center justify-center font-bold text-sm shadow-xs">
                                        1
                                    </div>

                                    <div class="ml-4 flex-1">
                                        <div class="flex items-center gap-2">
                                            <p class="text-gray-800 font-bold">
                                                Lengkapi Profil Biodata
                                            </p>
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                                Wajib Diisi
                                            </span>
                                        </div>

                                        <p class="text-gray-500 text-sm mt-0.5">
                                            Pastikan data identitas pribadi, susunan keluarga, riwayat pendidikan, dan pengalaman kerja terisi dengan benar.
                                        </p>

                                        <a href="{{ route('biodata.index') }}"
                                            class="inline-flex items-center gap-1 text-xs font-bold text-[#B11116] hover:text-red-800 mt-1 hover:underline">
                                            <span>Mulai lengkapi biodata sekarang</span>
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </a>
                                    </div>
                                @endif
                            </div>

                            {{-- LANGKAH 2: UNGGAH DOKUMEN (DINAMIS SESUAI TAHAP ACC / PROSES HRD) --}}
                            <div class="flex items-start pt-3 border-t border-gray-100">
                                @if ($inProgressApp)
                                    <div
                                        class="flex-shrink-0 w-8 h-8 bg-[#B11116] text-white rounded-lg flex items-center justify-center font-bold text-sm shadow-xs animate-pulse">
                                        2
                                    </div>

                                    <div class="ml-4 flex-1">
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <p class="text-gray-900 font-bold">
                                                Unggah Dokumen Pendukung
                                            </p>
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-red-50 text-[#B11116] border border-red-200">
                                                Tahap Seleksi Berkas
                                            </span>
                                        </div>

                                        <p class="text-gray-600 text-sm mt-0.5">
                                            Lamaran Anda untuk posisi <strong class="text-gray-900">{{ $inProgressApp->job?->title }}</strong> sedang diproses
                                            @if ($inProgressApp->stage)
                                                (Tahap: <span class="text-[#B11116] font-semibold">{{ ucwords($inProgressApp->stage->name) }}</span>)
                                            @endif.
                                            Siapkan berkas scan (KTP, Ijazah, Transkrip, SKCK) dalam format PDF/JPG.
                                        </p>

                                        <div class="mt-2">
                                            <a href="{{ route('applications.index') }}"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#B11116] hover:bg-red-800 text-white font-bold text-xs rounded-xl shadow-xs transition-all active:scale-95">
                                                <span>Lihat Status &amp; Unggah Berkas</span>
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                @else
                                    <div
                                        class="flex-shrink-0 w-8 h-8 bg-gray-100 text-gray-400 border border-gray-200 rounded-lg flex items-center justify-center font-bold text-sm">
                                        2
                                    </div>

                                    <div class="ml-4 flex-1">
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <p class="text-gray-700 font-bold">
                                                Unggah Dokumen Pendukung
                                            </p>
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-gray-100 text-gray-500 border border-gray-200">
                                                Tahap Seleksi
                                            </span>
                                        </div>

                                        <p class="text-gray-500 text-sm mt-0.5 leading-relaxed">
                                            Unggah berkas (KTP, Ijazah, Transkrip, SKCK) akan dibuka secara otomatis jika lamaran pekerjaan Anda telah lolos seleksi awal dan disetujui (ACC) oleh tim HRD.
                                        </p>

                                        @if ($hasApplications)
                                            <div class="mt-2 inline-flex items-center gap-1.5 text-[11px] font-medium text-amber-700 bg-amber-50 px-2.5 py-1 rounded-lg border border-amber-200">
                                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <span>Lamaran Anda sedang dalam tahap peninjauan awal. Anda akan dihubungi jika berkas fisik/digital diperlukan.</span>
                                            </div>
                                        @else
                                            <div class="mt-2">
                                                <a href="{{ route('guest.lowongan') }}"
                                                    class="inline-flex items-center gap-1 text-xs font-semibold text-[#B11116] hover:underline">
                                                    <span>Lamar posisi pekerjaan untuk memulai &rarr;</span>
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>


                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    <a href="{{ route('biodata.index') }}"
                        class="group flex items-center p-5 bg-white border border-gray-200 rounded-full shadow-lg hover:shadow-md hover:border-blue-400 transition-all duration-200 active:scale-95">

                        <div
                            class="w-12 h-12 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-colors">

                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>

                        </div>

                        <div class="ml-4">
                            <span class="block font-bold text-gray-800">
                                Profil Saya
                            </span>

                            <span class="block text-xs text-gray-400">
                                Lengkapi biodata
                            </span>
                        </div>

                    </a>


                    <a href="{{ route('guest.lowongan') }}"
                        class="group flex items-center p-5 bg-white border border-gray-200 rounded-full shadow-lg hover:shadow-md hover:border-red-500 transition-all duration-200 active:scale-95">

                        <div
                            class="w-12 h-12 bg-red-50 text-red-600 rounded-full flex items-center justify-center group-hover:bg-red-600 group-hover:text-white transition-colors">

                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>

                        </div>

                        <div class="ml-4">
                            <span class="block font-bold text-gray-800">
                                Cari Lowongan
                            </span>

                            <span class="block text-xs text-gray-400">
                                Lihat posisi aktif
                            </span>
                        </div>

                    </a>

                    <a href="{{ route('applications.index') }}"
                        class="group flex items-center p-5 bg-white border border-gray-200 rounded-full shadow-lg hover:shadow-md hover:border-emerald-500 transition-all duration-200 active:scale-95">

                        <div
                            class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-full flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition-colors">

                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>

                        </div>

                        <div class="ml-4">
                            <span class="block font-bold text-gray-800">
                                Riwayat Lamaran
                            </span>

                            <span class="block text-xs text-gray-400">
                                Pantau status lamaran
                            </span>
                        </div>

                    </a>
                </div>
            </div>


            <div class="space-y-6">
                <div class="bg-gray-900 p-6 rounded-[2rem] text-white overflow-hidden relative shadow-2xl shadow-gray-200">
                    <div
                        class="absolute top-0 right-0 -mr-16 -mt-16 w-32 h-32 bg-red-600 rounded-full blur-[60px] opacity-50">
                    </div>

                    <h4 class="text-lg font-bold mb-2 relative">
                        Butuh Bantuan?
                    </h4>

                    <p class="text-gray-400 text-sm mb-4 relative">
                        Jika mengalami kendala teknis saat pendaftaran, hubungi kami.
                    </p>


                    <a href=""
                        class="inline-flex items-center text-red-400 font-bold text-sm hover:text-red-300 transition-colors">Hubungi Kontak Kami
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
