@extends('auth.applicant.layouts.index')

@section('title', 'Dashboard Pelamar')

@section('content')
    <div class="py-8 md:py-12 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-2xl md:text-3xl font-black text-gray-800 tracking-tight">
                    Halo, <span class="text-red-600">{{ auth()->user()->nama }}</span>
                </h2>

                <p class="text-gray-500 mt-1 font-medium">
                    Selamat datang di <b>Dashboard Pelamar</b>, Pantau progres lamaran Anda di sini.
                </p>
            </div>

            <div class="inline-flex items-center px-5 py-2.5 bg-white border border-gray-100 rounded-2xl shadow-sm">
                <div class="relative flex h-3 w-3 mr-4">
                    <span
                        class="animate-ping absolute inline-flex h-full w-full bg-amber-400 opacity-75 rounded-full"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-amber-500"></span>
                </div>

                <div class="flex flex-col">
                    <span class="text-[10px] uppercase tracking-widest font-black text-gray-400 leading-none mb-1">
                        Status Profil
                    </span>

                    <span class="text-sm font-bold text-gray-700 leading-none">
                        Perlu Dilengkapi
                    </span>
                </div>
            </div>
        </div>


        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-50 overflow-hidden relative group">
                    <div
                        class="absolute -right-20 -top-20 w-60 h-60 bg-red-50 rounded-full opacity-50 group-hover:scale-110 transition-transform duration-500">
                    </div>

                    <div class="relative">

                        <h3 class="text-xl font-bold text-gray-800 mb-4">
                            Langkah Persiapan
                        </h3>

                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div
                                    class="flex-shrink-0 w-8 h-8 bg-red-600 text-white rounded-lg flex items-center justify-center font-bold text-sm">
                                    1
                                </div>

                                <div class="ml-4">
                                    <p class="text-gray-800 font-bold">
                                        Lengkapi Profil Biodata
                                    </p>

                                    <p class="text-gray-500 text-sm">
                                        Pastikan data pribadi dan riwayat pendidikan sudah benar.
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div
                                    class="flex-shrink-0 w-8 h-8 bg-gray-200 text-gray-400 rounded-lg flex items-center justify-center font-bold text-sm">
                                    2
                                </div>

                                <div class="ml-4">
                                    <p class="text-gray-400 font-bold">
                                        Unggah Dokumen Pendukung
                                    </p>

                                    <p class="text-gray-400 text-sm">
                                        Siapkan CV, Ijazah, dan berkas lainnya dalam format PDF.
                                    </p>
                                </div>
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


                    <a href="{{ route('guest.index') }}/#lowongan"
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