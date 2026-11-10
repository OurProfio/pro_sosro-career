@extends('guest.layouts.index')

@section('title', 'Lowongan Pekerjaan')

@section('content')
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        .font-brand-scope,
        #beranda-lowongan,
        #beranda-lowongan input,
        #beranda-lowongan button,
        #beranda-lowongan select,
        .custom-dropdown,
        #lowongan {
            font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .font-display-title,
        #beranda-lowongan h1,
        #lowongan h2 {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif !important;
            letter-spacing: -0.025em;
        }
    </style>

    <!-- JUMBOTRON SECTION (Single Slide / Non-Slider Sesuai Desain Jumbotron Beranda) -->
    <section id="beranda-lowongan"
        class="relative w-full min-h-[560px] sm:min-h-[600px] md:min-h-[640px] lg:min-h-[680px] bg-[#B11116] overflow-hidden flex flex-col justify-between pt-24 pb-8 md:pt-28 md:pb-10">

        <!-- Background Native Red SVG Curves & Ambient Glow -->
        <div class="absolute inset-0 w-full h-full pointer-events-none select-none overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-[#c8102e] via-[#B11116] to-[#7f0b0f]"></div>
            <div class="absolute -top-32 -left-32 w-[600px] md:w-[800px] h-[600px] md:h-[800px] rounded-full bg-radial from-[#e81928]/40 via-[#c8102e]/20 to-transparent blur-2xl"></div>
            <div class="absolute -bottom-20 -right-20 w-[500px] md:w-[700px] h-[500px] md:h-[700px] rounded-full bg-radial from-[#660508]/60 to-transparent blur-3xl"></div>

            <!-- SVG Kurva Merah Sesuai Jumbotron Beranda -->
            <svg class="absolute inset-0 w-full h-full" viewBox="0 0 1440 600" preserveAspectRatio="none" fill="none" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <linearGradient id="curveMainLowongan" x1="0%" y1="0%" x2="100%" y2="80%">
                        <stop offset="0%" stop-color="#df1a26" stop-opacity="0.9" />
                        <stop offset="40%" stop-color="#B11116" stop-opacity="0.95" />
                        <stop offset="100%" stop-color="#73080c" stop-opacity="0.85" />
                    </linearGradient>
                    <linearGradient id="curveLayerLowongan" x1="20%" y1="0%" x2="80%" y2="100%">
                        <stop offset="0%" stop-color="#e8202d" stop-opacity="0.6" />
                        <stop offset="60%" stop-color="#B11116" stop-opacity="0.75" />
                        <stop offset="100%" stop-color="#8a0c10" stop-opacity="0.9" />
                    </linearGradient>
                    <linearGradient id="waveBottomLowongan" x1="0%" y1="0%" x2="100%" y2="0%">
                        <stop offset="0%" stop-color="#B11116" />
                        <stop offset="45%" stop-color="#c8102e" />
                        <stop offset="100%" stop-color="#8b0a0e" />
                    </linearGradient>
                </defs>
                <path d="M0,0 L620,0 C460,140 390,260 450,380 C510,500 680,520 920,540 C1140,558 1320,530 1440,545 L1440,600 L0,600 Z" fill="url(#curveLayerLowongan)" />
                <path d="M0,0 L490,0 C350,130 300,250 360,370 C420,490 580,515 820,532 C1060,548 1280,522 1440,535 L1440,600 L0,600 Z" fill="url(#curveMainLowongan)" />
                <path d="M0,480 C260,450 500,515 800,488 C1100,460 1300,505 1440,495 L1440,600 L0,600 Z" fill="url(#waveBottomLowongan)" opacity="0.92" />
            </svg>

            <!-- Ornamen Daun & Botol Sosro -->
            <img src="{{ asset('assets/images/sosro-ornament.png') }}" alt=""
                class="absolute -left-6 top-14 md:left-4 md:top-18 w-44 sm:w-56 md:w-68 lg:w-76 object-contain pointer-events-none select-none opacity-20 transform -rotate-12">
            <img src="{{ asset('assets/images/sosro-ornament.png') }}" alt=""
                class="absolute right-4 bottom-2 md:right-16 md:bottom-4 w-32 sm:w-40 md:w-48 object-contain pointer-events-none select-none opacity-20 transform rotate-45">
        </div>

        <!-- Konten Jumbotron Teks -->
        <div class="relative z-20 max-w-7xl mx-auto px-6 md:px-12 w-full h-full flex items-center my-auto pt-8">
            <div class="max-w-xl lg:max-w-3xl text-left py-8 md:py-12">
                <!-- Main Title -->
                <h1 style="font-weight: 800;"
                    class="font-display-title text-2xl sm:text-3xl md:text-4xl lg:text-[3.25rem] text-white font-extrabold uppercase leading-[1.14] tracking-tight drop-shadow-md">
                    BERSAMA KAMI, MENJADI BAGIAN SINAR SOSRO GUNUNG SLAMAT
                </h1>

                <!-- Description -->
                <p class="text-white/95 text-sm sm:text-base md:text-lg mt-4 md:mt-5 max-w-2xl font-normal leading-relaxed drop-shadow-sm">
                    Bergabunglah dengan kami, baik sebagai talenta muda maupun profesional berpengalaman. Pilih kategori yang sesuai untuk mengembangkan potensi karirmu.
                </p>
            </div>
        </div>

        <!-- Floating Search & Filter Bar (Themed Dropdowns + Real-Time Search) -->
        <div class="relative z-30 max-w-6xl mx-auto px-4 sm:px-6 w-full mt-3">
            <div class="flex flex-col md:flex-row items-stretch md:items-center gap-2.5 sm:gap-3">
                <!-- Search Input Pill -->
                <div class="h-11 sm:h-12 flex-1 relative flex items-center bg-white rounded-full shadow-lg shadow-black/10 pl-5 pr-3 transition-all duration-200 hover:shadow-xl focus-within:ring-2 focus-within:ring-[#B11116]/30">
                    <label for="jobSearch" class="sr-only">Cari lowongan</label>
                    <input id="jobSearch" type="search" placeholder="Cari lowongan berdasarkan posisi, lokasi, divisi..."
                        class="w-full bg-transparent pr-2 text-xs sm:text-sm text-slate-800 placeholder:text-[#c77a87] focus:outline-none font-semibold border-0 focus:ring-0 [&::-webkit-search-cancel-button]:hidden" />

                    <!-- Clear Button -->
                    <button type="button" id="btnClearSearch" aria-label="Hapus kata kunci pencarian" title="Hapus teks pencarian"
                        class="hidden cursor-pointer p-1 rounded-full text-slate-400 hover:text-red-700 hover:bg-red-50 transition active:scale-90">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Hidden native selects to retain full JS compatibility -->
                <select id="filterLocation" class="hidden">
                    <option value="">Semua Lokasi</option>
                    @foreach ($jobs->pluck('location')->unique()->filter()->values() as $loc)
                        <option value="{{ $loc }}">{{ $loc }}</option>
                    @endforeach
                </select>

                <select id="filterCategory" class="hidden">
                    <option value="">Semua Kategori</option>
                    @foreach ($jobs->pluck('category')->unique()->filter()->values() as $cat)
                        <option value="{{ $cat }}">{{ ucwords(str_replace('_', ' ', $cat)) }}</option>
                    @endforeach
                </select>

                <select id="filterBidang" class="hidden">
                    <option value="">Semua Bidang</option>
                    @foreach ($jobs->pluck('occupation')->unique()->filter()->values() as $occ)
                        <option value="{{ $occ }}">{{ $occ }}</option>
                    @endforeach
                </select>

                <!-- Location Custom Themed Dropdown -->
                <div class="custom-dropdown relative w-full md:w-auto" data-target="filterLocation">
                    <button type="button" class="dropdown-trigger h-11 sm:h-12 w-full md:w-auto cursor-pointer rounded-full bg-white pl-5 pr-4 text-xs sm:text-sm font-semibold text-[#c77a87] shadow-lg shadow-black/10 hover:shadow-xl transition-all duration-200 flex items-center justify-between gap-3 border border-transparent hover:border-red-100 focus:outline-none focus:ring-2 focus:ring-[#B11116]/30">
                        <span class="dropdown-label truncate" data-default="Semua Lokasi">Semua Lokasi</span>
                        <svg class="dropdown-chevron w-4 h-4 shrink-0 text-[#a30f28] transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="m6 9 6 6 6-6" />
                        </svg>
                    </button>
                    <div class="dropdown-menu hidden absolute left-0 top-full mt-2 w-full md:w-56 bg-white/95 backdrop-blur-md rounded-2xl shadow-2xl border border-red-100/90 py-1.5 z-50 transform origin-top transition-all duration-200">
                        <div class="dropdown-options max-h-56 overflow-y-auto px-1.5 space-y-0.5">
                            <button type="button" data-value="" class="dropdown-option w-full text-left px-3.5 py-2.5 rounded-xl text-xs sm:text-sm font-medium text-[#B11116] bg-red-50/70 hover:bg-red-50 flex items-center justify-between transition cursor-pointer">
                                <span>Semua Lokasi</span>
                                <svg class="option-check w-4 h-4 text-[#B11116]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            </button>
                            @foreach ($jobs->pluck('location')->unique()->filter()->values() as $loc)
                                <button type="button" data-value="{{ $loc }}" class="dropdown-option w-full text-left px-3.5 py-2.5 rounded-xl text-xs sm:text-sm font-medium text-slate-700 hover:text-[#B11116] hover:bg-red-50/80 flex items-center justify-between transition cursor-pointer">
                                    <span>{{ $loc }}</span>
                                    <svg class="option-check hidden w-4 h-4 text-[#B11116]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Category Custom Themed Dropdown -->
                <div class="custom-dropdown relative w-full md:w-auto" data-target="filterCategory">
                    <button type="button" class="dropdown-trigger h-11 sm:h-12 w-full md:w-auto cursor-pointer rounded-full bg-white pl-5 pr-4 text-xs sm:text-sm font-semibold text-[#c77a87] shadow-lg shadow-black/10 hover:shadow-xl transition-all duration-200 flex items-center justify-between gap-3 border border-transparent hover:border-red-100 focus:outline-none focus:ring-2 focus:ring-[#B11116]/30">
                        <span class="dropdown-label truncate" data-default="Semua Kategori">Semua Kategori</span>
                        <svg class="dropdown-chevron w-4 h-4 shrink-0 text-[#a30f28] transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="m6 9 6 6 6-6" />
                        </svg>
                    </button>
                    <div class="dropdown-menu hidden absolute left-0 top-full mt-2 w-full md:w-60 bg-white/95 backdrop-blur-md rounded-2xl shadow-2xl border border-red-100/90 py-1.5 z-50 transform origin-top transition-all duration-200">
                        <div class="dropdown-options max-h-56 overflow-y-auto px-1.5 space-y-0.5">
                            <button type="button" data-value="" class="dropdown-option w-full text-left px-3.5 py-2.5 rounded-xl text-xs sm:text-sm font-medium text-[#B11116] bg-red-50/70 hover:bg-red-50 flex items-center justify-between transition cursor-pointer">
                                <span>Semua Kategori</span>
                                <svg class="option-check w-4 h-4 text-[#B11116]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            </button>
                            @foreach ($jobs->pluck('category')->unique()->filter()->values() as $cat)
                                <button type="button" data-value="{{ $cat }}" class="dropdown-option w-full text-left px-3.5 py-2.5 rounded-xl text-xs sm:text-sm font-medium text-slate-700 hover:text-[#B11116] hover:bg-red-50/80 flex items-center justify-between transition cursor-pointer">
                                    <span>{{ ucwords(str_replace('_', ' ', $cat)) }}</span>
                                    <svg class="option-check hidden w-4 h-4 text-[#B11116]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Occupation / Bidang Custom Themed Dropdown -->
                <div class="custom-dropdown relative w-full md:w-auto" data-target="filterBidang">
                    <button type="button" class="dropdown-trigger h-11 sm:h-12 w-full md:w-auto cursor-pointer rounded-full bg-white pl-5 pr-4 text-xs sm:text-sm font-semibold text-[#c77a87] shadow-lg shadow-black/10 hover:shadow-xl transition-all duration-200 flex items-center justify-between gap-3 border border-transparent hover:border-red-100 focus:outline-none focus:ring-2 focus:ring-[#B11116]/30">
                        <span class="dropdown-label truncate" data-default="Semua Bidang">Semua Bidang</span>
                        <svg class="dropdown-chevron w-4 h-4 shrink-0 text-[#a30f28] transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="m6 9 6 6 6-6" />
                        </svg>
                    </button>
                    <div class="dropdown-menu hidden absolute left-0 top-full mt-2 w-full md:w-64 bg-white/95 backdrop-blur-md rounded-2xl shadow-2xl border border-red-100/90 py-1.5 z-50 transform origin-top transition-all duration-200">
                        <div class="dropdown-options max-h-56 overflow-y-auto px-1.5 space-y-0.5">
                            <button type="button" data-value="" class="dropdown-option w-full text-left px-3.5 py-2.5 rounded-xl text-xs sm:text-sm font-medium text-[#B11116] bg-red-50/70 hover:bg-red-50 flex items-center justify-between transition cursor-pointer">
                                <span>Semua Bidang</span>
                                <svg class="option-check w-4 h-4 text-[#B11116]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            </button>
                            @foreach ($jobs->pluck('occupation')->unique()->filter()->values() as $occ)
                                <button type="button" data-value="{{ $occ }}" class="dropdown-option w-full text-left px-3.5 py-2.5 rounded-xl text-xs sm:text-sm font-medium text-slate-700 hover:text-[#B11116] hover:bg-red-50/80 flex items-center justify-between transition cursor-pointer">
                                    <span>{{ $occ }}</span>
                                    <svg class="option-check hidden w-4 h-4 text-[#B11116]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- HCI Search Action Button -->
                <button type="button" id="btnSearch"
                    class="h-11 sm:h-12 px-6 rounded-full bg-slate-900 hover:bg-black text-white text-xs sm:text-sm font-bold shadow-lg shadow-black/15 transition-all duration-200 flex items-center justify-center gap-2 cursor-pointer hover:shadow-xl active:scale-95">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m21 21-4.35-4.35m1.35-5.4a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0Z" />
                    </svg>
                    <span>Cari</span>
                </button>
            </div>
        </div>
    </section>

    <!-- SECTION DAFTAR LOWONGAN -->
    <section class="py-14 sm:py-16 bg-white" id="lowongan">
        <div class="max-w-6xl mx-auto px-6">
            <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-wider text-[#B11116]">Karier bersama kami</p>
                    <h2 class="font-display-title mt-1 text-2xl font-semibold tracking-tight text-slate-900 sm:text-3xl">
                        Temukan lowongan yang sesuai
                    </h2>
                    <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-600 font-normal">
                        Gunakan pencarian dan filter untuk menemukan posisi berdasarkan lokasi, kategori, atau bidang pekerjaan.
                    </p>
                </div>

                <div class="inline-flex w-fit items-center gap-3 rounded-xl border border-slate-200 bg-white px-4 py-3 shadow-sm">
                    <span id="jobCount" aria-live="polite"
                        class="inline-flex h-9 min-w-9 items-center justify-center rounded-lg bg-red-50 px-2 text-sm font-semibold text-[#B11116]">
                        {{ $jobs->count() }}
                    </span>
                    <span class="text-sm font-medium text-slate-600">lowongan tersedia</span>
                </div>
            </div>

            <div id="jobList" class="grid md:grid-cols-2 gap-6">
                @forelse ($jobs as $job)
                    <article
                        class="job-card flex h-full flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-red-200 hover:shadow-lg focus-within:ring-2 focus-within:ring-[#B11116]/30"
                        data-title="{{ strtolower($job->title) }}" data-location="{{ strtolower($job->location) }}"
                        data-category="{{ strtolower($job->category) }}" data-bidang="{{ strtolower($job->occupation) }}"
                        data-bidang-name="{{ $job->occupation }}"
                        data-search="{{ strtolower($job->title . ' ' . $job->location . ' ' . ($job->office->name ?? '') . ' ' . str_replace('_', ' ', $job->category) . ' ' . $job->occupation . ' ' . $job->type . ' ' . strip_tags($job->qualification) . ' ' . strip_tags($job->description)) }}">
                        <div class="flex-1 p-5 sm:p-6">
                            <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                                <div class="min-w-0">
                                    <span
                                        class="inline-flex items-center rounded-full bg-red-50 px-3 py-1 text-xs font-semibold text-[#B11116]">
                                        {{ ucwords(str_replace('_', ' ', $job->category)) }}
                                    </span>
                                    <h3 class="mt-3 text-xl font-semibold leading-7 text-slate-900 sm:text-2xl">
                                        {{ $job->title }}</h3>
                                </div>
                                <div
                                    class="shrink-0 rounded-xl border border-amber-200 bg-amber-50 text-amber-800 px-3.5 py-2.5 sm:text-right">
                                    <p class="text-[11px] font-semibold uppercase tracking-wide text-amber-800">
                                        Batas lamaran
                                    </p>
                                    <p class="mt-0.5 text-sm font-semibold text-amber-950">
                                        {{ \Carbon\Carbon::parse($job->closing_date)->translatedFormat('d F Y') }}
                                    </p>
                                </div>
                            </div>

                            <dl class="mt-5 grid grid-cols-1 gap-3 sm:grid-cols-3">
                                <div class="rounded-xl bg-slate-50 p-3.5">
                                    <dt class="text-[11px] font-semibold uppercase tracking-wide text-slate-500">Lokasi</dt>
                                    <dd class="mt-1 text-sm font-medium leading-5 text-slate-800">{{ $job->location }} <span
                                            class="font-normal text-slate-500">({{ $job->office->name ?? 'Cabang' }})</span>
                                    </dd>
                                </div>
                                <div class="rounded-xl bg-slate-50 p-3.5">
                                    <dt class="text-[11px] font-semibold uppercase tracking-wide text-slate-500">Bidang</dt>
                                    <dd class="mt-1 text-sm font-medium leading-5 text-slate-800">{{ $job->occupation }}</dd>
                                </div>
                                <div class="rounded-xl bg-slate-50 p-3.5">
                                    <dt class="text-[11px] font-semibold uppercase tracking-wide text-slate-500">Tipe pekerjaan
                                    </dt>
                                    <dd class="mt-1 text-sm font-medium leading-5 text-slate-800">{{ $job->type }}</dd>
                                </div>
                            </dl>

                            <div class="mt-5 space-y-2">
                                <details class="group rounded-xl border border-slate-200">
                                    <summary
                                        class="flex min-h-11 cursor-pointer hover:cursor-pointer list-none items-center justify-between gap-3 rounded-xl px-4 py-3 text-sm font-semibold text-slate-800 transition hover:bg-slate-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-[#B11116] [&::-webkit-details-marker]:hidden">
                                        <span>Kualifikasi</span>
                                        <svg class="h-4 w-4 shrink-0 text-slate-500 transition-transform group-open:rotate-180"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="m6 9 6 6 6-6" />
                                        </svg>
                                    </summary>
                                    <div
                                        class="border-t border-slate-100 px-4 py-3 text-sm leading-6 text-slate-600 whitespace-pre-line">
                                        {{ $job->qualification }}</div>
                                </details>
                                <details class="group rounded-xl border border-slate-200">
                                    <summary
                                        class="flex min-h-11 cursor-pointer hover:cursor-pointer list-none items-center justify-between gap-3 rounded-xl px-4 py-3 text-sm font-semibold text-slate-800 transition hover:bg-slate-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-[#B11116] [&::-webkit-details-marker]:hidden">
                                        <span>Deskripsi pekerjaan</span>
                                        <svg class="h-4 w-4 shrink-0 text-slate-500 transition-transform group-open:rotate-180"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="m6 9 6 6 6-6" />
                                        </svg>
                                    </summary>
                                    <div
                                        class="border-t border-slate-100 px-4 py-3 text-sm leading-6 text-slate-600 whitespace-pre-line">
                                        {{ $job->description }}</div>
                                </details>
                            </div>
                        </div>

                        <div
                            class="flex flex-col gap-3 border-t border-slate-100 bg-slate-50/70 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                            <p class="text-xs leading-5 text-slate-500">Periksa kualifikasi sebelum mengirim lamaran.</p>
                            @auth
                                @if (auth()->user()->role === 'user')
                                    @php
                                        $applicant = auth()->user()->applicant;
                                        $applicationExisting = $applicant
                                            ? \App\Models\Application::where('applicant_id', $applicant->id)
                                                ->where('job_id', $job->id)
                                                ->first()
                                            : null;
                                    @endphp

                                    @if ($applicationExisting)
                                        @if ($applicationExisting->status === 'rejected')
                                            <button disabled aria-disabled="true"
                                                class="inline-flex min-h-11 cursor-not-allowed items-center justify-center gap-2 rounded-xl bg-rose-50 px-5 py-2.5 text-sm font-semibold text-rose-800 ring-1 ring-inset ring-rose-200">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                    aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                        d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                                Lamaran Tidak Terpilih
                                            </button>
                                        @else
                                            <button disabled aria-disabled="true"
                                                class="inline-flex min-h-11 cursor-not-allowed items-center justify-center gap-2 rounded-xl bg-emerald-50 px-5 py-2.5 text-sm font-semibold text-emerald-800 ring-1 ring-inset ring-emerald-200">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                    aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                        d="m5 13 4 4L19 7" />
                                                </svg>
                                                Sudah dilamar
                                            </button>
                                        @endif
                                    @elseif (!$applicant || !$applicant->isProfileComplete())
                                        {{-- Belum isi atau belum lengkap biodata --}}
                                        <button type="button" onclick="handleBelumBiodata(this)"
                                            data-title="{{ $job->title }}"
                                            class="cursor-pointer hover:cursor-pointer inline-flex min-h-11 items-center justify-center rounded-xl bg-[#B11116] px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#940e13] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#B11116] focus-visible:ring-offset-2 active:scale-[0.98]">
                                            Lamar posisi ini
                                        </button>
                                    @else
                                        {{-- Sudah login dan sudah isi biodata --}}
                                        <form action="{{ route('applications.store') }}" method="POST" class="form-apply">
                                            @csrf
                                            <input type="hidden" name="job_id" value="{{ $job->id }}">
                                            <button type="button" onclick="konfirmasiLamar(this)"
                                                data-title="{{ $job->title }}"
                                                class="cursor-pointer hover:cursor-pointer inline-flex min-h-11 items-center justify-center rounded-xl bg-[#B11116] px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#940e13] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#B11116] focus-visible:ring-offset-2 active:scale-[0.98]">
                                                Lamar posisi ini
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    {{-- Akun Administrator / Super Admin --}}
                                    <button type="button" onclick="handleAkunAdmin()"
                                        class="cursor-pointer hover:cursor-pointer inline-flex min-h-11 items-center justify-center rounded-xl bg-[#B11116] px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#940e13] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#B11116] focus-visible:ring-offset-2 active:scale-[0.98]">
                                        Lamar posisi ini
                                    </button>
                                @endif
                            @else
                                {{-- Belum login --}}
                                <button type="button" onclick="handleBelumLogin(this)" data-title="{{ $job->title }}"
                                    class="cursor-pointer hover:cursor-pointer inline-flex min-h-11 items-center justify-center rounded-xl bg-[#B11116] px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#940e13] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#B11116] focus-visible:ring-offset-2 active:scale-[0.98]">
                                    Lamar posisi ini
                                </button>
                            @endauth
                        </div>
                    </article>
                @empty
                    <div
                        class="col-span-1 md:col-span-2 text-center py-12 bg-slate-50 rounded-2xl border border-dashed border-slate-300">
                        <p class="text-slate-500 font-semibold text-base">Saat ini belum ada lowongan pekerjaan yang dibuka.</p>
                    </div>
                @endforelse

                <div id="noJobFound"
                    class="col-span-1 md:col-span-2 hidden text-center py-12 px-4 bg-slate-50 rounded-2xl border border-dashed border-slate-300">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-red-50 text-[#B11116] mb-3">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m21 21-4.35-4.35m1.35-5.4a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0Z" />
                        </svg>
                    </div>
                    <h3 class="text-base font-semibold text-slate-800">Tidak ada lowongan ditemukan</h3>
                    <p class="mt-1 text-sm text-slate-500">Tidak ada posisi yang cocok dengan kata kunci atau filter yang Anda pilih.</p>
                    <button type="button" id="btnResetFilter"
                        class="mt-4 cursor-pointer hover:cursor-pointer inline-flex items-center gap-2 rounded-xl bg-slate-200 px-4 py-2 text-xs font-semibold text-slate-700 transition hover:bg-slate-300">
                        Reset Filter
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- MODAL 1: Notifikasi Belum Login -->
    <div id="modalBelumLogin"
        class="fixed inset-0 z-[100] hidden items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm transition-all"
        role="dialog" aria-modal="true">
        <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl border border-slate-200 overflow-hidden transform transition-all">
            <div class="p-6 text-center">
                <div class="w-12 h-12 rounded-2xl bg-amber-50 border border-amber-100 flex items-center justify-center text-amber-600 mx-auto mb-4 shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                    </svg>
                </div>
                <h3 class="text-base font-semibold text-slate-900">Masuk ke Akun Diperlukan</h3>
                <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                    Anda harus masuk (login) ke akun Anda terlebih dahulu untuk dapat melamar posisi <span id="modalLoginJobTitle" class="font-semibold text-slate-800"></span>.
                </p>
            </div>
            <div class="px-6 py-4 bg-slate-50/70 border-t border-slate-100 flex items-center justify-end gap-2.5">
                <button type="button" onclick="tutupModalBelumLogin()"
                    class="px-4 py-2 rounded-xl border border-slate-200 bg-white text-slate-600 hover:bg-slate-100 hover:text-slate-800 font-semibold text-xs transition cursor-pointer">
                    Batal
                </button>
                <a href="{{ route('guest.login') }}?required=1"
                    class="inline-flex items-center gap-1.5 px-5 py-2 rounded-xl bg-[#B11116] hover:bg-[#940e13] text-white font-semibold text-xs shadow-sm transition cursor-pointer">
                    Masuk Sekarang
                </a>
            </div>
        </div>
    </div>

    <!-- MODAL 2: Notifikasi Belum Isi Biodata -->
    <div id="modalBelumBiodata"
        class="fixed inset-0 z-[100] hidden items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm transition-all"
        role="dialog" aria-modal="true">
        <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl border border-slate-200 overflow-hidden transform transition-all">
            <div class="p-6 text-center">
                <div class="w-12 h-12 rounded-2xl bg-amber-50 border border-amber-100 flex items-center justify-center text-amber-600 mx-auto mb-4 shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                </div>
                <h3 class="text-base font-semibold text-slate-900">Lengkapi Biodata Anda</h3>
                <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                    Anda harus melengkapi data biodata pelamar terlebih dahulu sebelum dapat melamar posisi <span id="modalBiodataJobTitle" class="font-semibold text-slate-800"></span>.
                </p>
            </div>
            <div class="px-6 py-4 bg-slate-50/70 border-t border-slate-100 flex items-center justify-end gap-2.5">
                <button type="button" onclick="tutupModalBelumBiodata()"
                    class="px-4 py-2 rounded-xl border border-slate-200 bg-white text-slate-600 hover:bg-slate-100 hover:text-slate-800 font-semibold text-xs transition cursor-pointer">
                    Batal
                </button>
                <a href="{{ route('biodata.index') }}?required=1"
                    class="inline-flex items-center gap-1.5 px-5 py-2 rounded-xl bg-[#B11116] hover:bg-[#940e13] text-white font-semibold text-xs shadow-sm transition cursor-pointer">
                    Lengkapi Biodata Sekarang
                </a>
            </div>
        </div>
    </div>

    <!-- MODAL 3: Konfirmasi Lamar -->
    <div id="modalKonfirmasiLamar"
        class="fixed inset-0 z-[100] hidden items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm transition-all"
        role="dialog" aria-modal="true">
        <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl border border-slate-200 overflow-hidden transform transition-all">
            <div class="p-6 text-center">
                <div class="w-12 h-12 rounded-2xl bg-red-50 border border-red-100 flex items-center justify-center text-[#B11116] mx-auto mb-4 shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0zm-9 3.75h.008v.008H12v-.008z" />
                    </svg>
                </div>
                <h3 class="text-base font-semibold text-slate-900">Kirim Lamaran Pekerjaan?</h3>
                <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                    Apakah Anda yakin ingin mengirimkan lamaran untuk posisi <span id="modalLamarJobTitle" class="font-semibold text-slate-800"></span>?
                </p>
            </div>
            <div class="px-6 py-4 bg-slate-50/70 border-t border-slate-100 flex items-center justify-end gap-2.5">
                <button type="button" onclick="tutupModalLamar()"
                    class="px-4 py-2 rounded-xl border border-slate-200 bg-white text-slate-600 hover:bg-slate-100 hover:text-slate-800 font-semibold text-xs transition cursor-pointer">
                    Batal
                </button>
                <button type="button" id="btnSubmitLamar"
                    class="inline-flex items-center gap-1.5 px-5 py-2 rounded-xl bg-[#B11116] hover:bg-[#940e13] text-white font-semibold text-xs shadow-sm transition cursor-pointer">
                    Ya, Kirim Lamaran
                </button>
            </div>
        </div>
    </div>

    <!-- MODAL 4: Akun Administrator Tidak Dapat Melamar -->
    <div id="modalAkunAdmin"
        class="fixed inset-0 z-[100] hidden items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm transition-all"
        role="dialog" aria-modal="true">
        <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl border border-slate-200 overflow-hidden transform transition-all">
            <div class="p-6 text-center">
                <div class="w-12 h-12 rounded-2xl bg-amber-50 border border-amber-100 flex items-center justify-center text-amber-600 mx-auto mb-4 shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                </div>
                <h3 class="text-base font-semibold text-slate-900">Akses Dibatasi</h3>
                <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                    Anda sedang masuk sebagai <span class="font-semibold text-slate-800">Administrator</span>. Akun
                    Administrator tidak dapat melamar lowongan pekerjaan. Silakan gunakan akun Pelamar untuk melamar lowongan.
                </p>
            </div>
            <div class="px-6 py-4 bg-slate-50/70 border-t border-slate-100 flex items-center justify-end">
                <button type="button" onclick="tutupModalAkunAdmin()"
                    class="px-5 py-2 rounded-xl bg-slate-800 hover:bg-slate-900 text-white font-semibold text-xs transition cursor-pointer">
                    Mengerti
                </button>
            </div>
        </div>
    </div>

    <!-- SCRIPT FILTER, DROPDOWNS & MODAL LAMAR -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const jobSearch = document.getElementById('jobSearch');
            const btnSearch = document.getElementById('btnSearch');
            const filterLocation = document.getElementById('filterLocation');
            const filterCategory = document.getElementById('filterCategory');
            const filterBidang = document.getElementById('filterBidang');
            const jobCount = document.getElementById('jobCount');
            const noJobFound = document.getElementById('noJobFound');
            const btnResetFilter = document.getElementById('btnResetFilter');
            const jobCards = document.querySelectorAll('.job-card');

            function updateBidangOptions() {
                if (!filterBidang) return;

                const searchVal = (jobSearch ? jobSearch.value : '').trim().toLowerCase();
                const locVal = (filterLocation ? filterLocation.value : '').trim().toLowerCase();
                const catVal = (filterCategory ? filterCategory.value : '').trim().toLowerCase();

                const prevSelectedVal = filterBidang.value;
                const availableBidangs = new Map();

                jobCards.forEach(card => {
                    const cardLoc = (card.dataset.location || '').toLowerCase();
                    const cardCat = (card.dataset.category || '').toLowerCase();
                    const cardSearch = (card.dataset.search || '').toLowerCase();
                    const cardBidName = card.dataset.bidangName || '';

                    const matchesLoc = !locVal || cardLoc === locVal;
                    const matchesCat = !catVal || cardCat === catVal;
                    const matchesSearch = !searchVal || cardSearch.includes(searchVal);

                    if (matchesLoc && matchesCat && matchesSearch && cardBidName.trim() !== '') {
                        availableBidangs.set(cardBidName.toLowerCase(), cardBidName);
                    }
                });

                filterBidang.innerHTML = '<option value="">Semua Bidang</option>';
                let stillHasSelected = false;

                availableBidangs.forEach((origName, lowerVal) => {
                    const opt = document.createElement('option');
                    opt.value = origName;
                    opt.textContent = origName;
                    if (prevSelectedVal && prevSelectedVal.toLowerCase() === lowerVal) {
                        opt.selected = true;
                        stillHasSelected = true;
                    }
                    filterBidang.appendChild(opt);
                });

                if (!stillHasSelected && prevSelectedVal !== '') {
                    filterBidang.value = '';
                }
                syncBidangCustomDropdown();
            }

            function syncBidangCustomDropdown() {
                const bidangDropdown = document.querySelector('.custom-dropdown[data-target="filterBidang"]');
                if (!bidangDropdown || !filterBidang) return;

                const optionsContainer = bidangDropdown.querySelector('.dropdown-options');
                const triggerLabel = bidangDropdown.querySelector('.dropdown-label');
                const trigger = bidangDropdown.querySelector('.dropdown-trigger');
                if (!optionsContainer) return;

                let html = `
                    <button type="button" data-value="" class="dropdown-option w-full text-left px-3.5 py-2.5 rounded-xl text-xs sm:text-sm font-medium ${!filterBidang.value ? 'text-[#B11116] bg-red-50/70 font-semibold' : 'text-slate-700 hover:text-[#B11116] hover:bg-red-50/80'} flex items-center justify-between transition cursor-pointer">
                        <span>Semua Bidang</span>
                        <svg class="option-check ${!filterBidang.value ? '' : 'hidden'} w-4 h-4 text-[#B11116]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                    </button>
                `;

                Array.from(filterBidang.options).forEach(opt => {
                    if (!opt.value) return;
                    const isSelected = filterBidang.value === opt.value;
                    html += `
                        <button type="button" data-value="${opt.value}" class="dropdown-option w-full text-left px-3.5 py-2.5 rounded-xl text-xs sm:text-sm font-medium ${isSelected ? 'text-[#B11116] bg-red-50/70 font-semibold' : 'text-slate-700 hover:text-[#B11116] hover:bg-red-50/80'} flex items-center justify-between transition cursor-pointer">
                            <span>${opt.textContent}</span>
                            <svg class="option-check ${isSelected ? '' : 'hidden'} w-4 h-4 text-[#B11116]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        </button>
                    `;
                });

                optionsContainer.innerHTML = html;

                if (triggerLabel) {
                    triggerLabel.textContent = filterBidang.value || 'Semua Bidang';
                    if (filterBidang.value) {
                        trigger.classList.add('text-slate-800');
                        trigger.classList.remove('text-[#c77a87]');
                    } else {
                        trigger.classList.remove('text-slate-800');
                        trigger.classList.add('text-[#c77a87]');
                    }
                }
            }

            function filterJobs() {
                const searchVal = (jobSearch ? jobSearch.value : '').trim().toLowerCase();
                const locVal = (filterLocation ? filterLocation.value : '').trim().toLowerCase();
                const catVal = (filterCategory ? filterCategory.value : '').trim().toLowerCase();
                const bidVal = (filterBidang ? filterBidang.value : '').trim().toLowerCase();

                let visibleCount = 0;

                jobCards.forEach(card => {
                    const cardLoc = (card.dataset.location || '').toLowerCase();
                    const cardCat = (card.dataset.category || '').toLowerCase();
                    const cardBid = (card.dataset.bidang || '').toLowerCase();
                    const cardSearch = (card.dataset.search || '').toLowerCase();

                    const matchesLoc = !locVal || cardLoc === locVal;
                    const matchesCat = !catVal || cardCat === catVal;
                    const matchesBid = !bidVal || cardBid === bidVal;
                    const matchesSearch = !searchVal || cardSearch.includes(searchVal);

                    if (matchesLoc && matchesCat && matchesBid && matchesSearch) {
                        card.classList.remove('hidden');
                        visibleCount++;
                    } else {
                        card.classList.add('hidden');
                    }
                });

                if (jobCount) {
                    jobCount.textContent = visibleCount;
                }

                if (noJobFound) {
                    if (visibleCount === 0 && jobCards.length > 0) {
                        noJobFound.classList.remove('hidden');
                    } else {
                        noJobFound.classList.add('hidden');
                    }
                }
            }

            const btnClearSearch = document.getElementById('btnClearSearch');
            if (jobSearch) {
                jobSearch.addEventListener('input', function() {
                    if (btnClearSearch) {
                        if (jobSearch.value.trim().length > 0) {
                            btnClearSearch.classList.remove('hidden');
                        } else {
                            btnClearSearch.classList.add('hidden');
                        }
                    }
                });
                jobSearch.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        updateBidangOptions();
                        filterJobs();
                        const lowonganEl = document.getElementById('lowongan');
                        if (lowonganEl) {
                            lowonganEl.scrollIntoView({ behavior: 'smooth' });
                        }
                    }
                });
            }

            if (btnClearSearch && jobSearch) {
                btnClearSearch.addEventListener('click', function() {
                    jobSearch.value = '';
                    btnClearSearch.classList.add('hidden');
                    jobSearch.focus();
                    updateBidangOptions();
                    filterJobs();
                });
            }

            if (btnSearch) {
                btnSearch.addEventListener('click', function() {
                    updateBidangOptions();
                    filterJobs();
                    const lowonganEl = document.getElementById('lowongan');
                    if (lowonganEl) {
                        lowonganEl.scrollIntoView({ behavior: 'smooth' });
                    }
                });
            }

            const customDropdowns = document.querySelectorAll('.custom-dropdown');
            customDropdowns.forEach(dropdown => {
                const targetId = dropdown.dataset.target;
                const hiddenSelect = document.getElementById(targetId);
                const trigger = dropdown.querySelector('.dropdown-trigger');
                const menu = dropdown.querySelector('.dropdown-menu');
                const label = dropdown.querySelector('.dropdown-label');
                const chevron = dropdown.querySelector('.dropdown-chevron');
                const defaultText = label?.dataset.default || 'Pilih';

                if (!trigger || !menu) return;

                function openDropdown() {
                    customDropdowns.forEach(other => {
                        if (other !== dropdown) {
                            other.querySelector('.dropdown-menu')?.classList.add('hidden');
                            other.querySelector('.dropdown-chevron')?.classList.remove('rotate-180');
                        }
                    });
                    menu.classList.remove('hidden');
                    chevron?.classList.add('rotate-180');
                }

                function closeDropdown() {
                    menu.classList.add('hidden');
                    chevron?.classList.remove('rotate-180');
                }

                trigger.addEventListener('click', (e) => {
                    e.stopPropagation();
                    if (menu.classList.contains('hidden')) {
                        openDropdown();
                    } else {
                        closeDropdown();
                    }
                });

                function updateUiSelection(val, text) {
                    if (label) {
                        label.textContent = val ? text : defaultText;
                        if (val) {
                            label.classList.add('text-slate-800');
                            label.classList.remove('text-[#c77a87]');
                        } else {
                            label.classList.remove('text-slate-800');
                            label.classList.add('text-[#c77a87]');
                        }
                    }

                    dropdown.querySelectorAll('.dropdown-option').forEach(opt => {
                        const optVal = opt.dataset.value;
                        const check = opt.querySelector('.option-check');
                        if (optVal === val) {
                            opt.classList.add('text-[#B11116]', 'bg-red-50/70', 'font-semibold');
                            opt.classList.remove('text-slate-700');
                            check?.classList.remove('hidden');
                        } else {
                            opt.classList.remove('text-[#B11116]', 'bg-red-50/70', 'font-semibold');
                            opt.classList.add('text-slate-700');
                            check?.classList.add('hidden');
                        }
                    });
                }

                dropdown.addEventListener('click', (e) => {
                    const optionBtn = e.target.closest('.dropdown-option');
                    if (optionBtn) {
                        const val = optionBtn.dataset.value;
                        const text = optionBtn.querySelector('span')?.textContent || '';
                        if (hiddenSelect) {
                            hiddenSelect.value = val;
                            hiddenSelect.dispatchEvent(new Event('change'));
                        }
                        updateUiSelection(val, text);
                        closeDropdown();
                    }
                });

                if (hiddenSelect && hiddenSelect.value) {
                    const currentOpt = hiddenSelect.options[hiddenSelect.selectedIndex];
                    updateUiSelection(hiddenSelect.value, currentOpt ? currentOpt.textContent : hiddenSelect.value);
                }
            });

            document.addEventListener('click', (e) => {
                if (!e.target.closest('.custom-dropdown')) {
                    customDropdowns.forEach(dropdown => {
                        dropdown.querySelector('.dropdown-menu')?.classList.add('hidden');
                        dropdown.querySelector('.dropdown-chevron')?.classList.remove('rotate-180');
                    });
                }
            });

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    customDropdowns.forEach(dropdown => {
                        dropdown.querySelector('.dropdown-menu')?.classList.add('hidden');
                        dropdown.querySelector('.dropdown-chevron')?.classList.remove('rotate-180');
                    });
                }
            });

            if (filterLocation) filterLocation.addEventListener('change', updateBidangOptions);
            if (filterCategory) filterCategory.addEventListener('change', updateBidangOptions);

            if (btnResetFilter) {
                btnResetFilter.addEventListener('click', function() {
                    if (jobSearch) {
                        jobSearch.value = '';
                        if (btnClearSearch) btnClearSearch.classList.add('hidden');
                    }
                    if (filterLocation) filterLocation.value = '';
                    if (filterCategory) filterCategory.value = '';
                    if (filterBidang) filterBidang.value = '';

                    customDropdowns.forEach(dropdown => {
                        const label = dropdown.querySelector('.dropdown-label');
                        const defaultText = label?.dataset.default || 'Semua';
                        if (label) {
                            label.textContent = defaultText;
                            label.classList.remove('text-slate-800');
                            label.classList.add('text-[#c77a87]');
                        }
                        dropdown.querySelectorAll('.dropdown-option').forEach(opt => {
                            const check = opt.querySelector('.option-check');
                            if (!opt.dataset.value) {
                                opt.classList.add('text-[#B11116]', 'bg-red-50/70', 'font-semibold');
                                opt.classList.remove('text-slate-700');
                                check?.classList.remove('hidden');
                            } else {
                                opt.classList.remove('text-[#B11116]', 'bg-red-50/70', 'font-semibold');
                                opt.classList.add('text-slate-700');
                                check?.classList.add('hidden');
                            }
                        });
                    });

                    updateBidangOptions();
                    filterJobs();
                });
            }

            // Sync with URL params
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('search') && jobSearch) jobSearch.value = urlParams.get('search');
            if (urlParams.get('location') && filterLocation) filterLocation.value = urlParams.get('location');
            if (urlParams.get('category') && filterCategory) filterCategory.value = urlParams.get('category');
            updateBidangOptions();
            if (urlParams.get('bidang') && filterBidang) filterBidang.value = urlParams.get('bidang');
            filterJobs();
        });

        // Modal Action Handlers
        function getJobTitle(trigger) {
            if (typeof trigger === 'string') return trigger;
            return (trigger && trigger.dataset && trigger.dataset.title) ? trigger.dataset.title : '';
        }

        function handleBelumLogin(trigger) {
            const title = getJobTitle(trigger);
            const titleEl = document.getElementById('modalLoginJobTitle');
            if (titleEl) titleEl.textContent = title;
            const modal = document.getElementById('modalBelumLogin');
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        }

        function tutupModalBelumLogin() {
            const modal = document.getElementById('modalBelumLogin');
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        }

        function handleBelumBiodata(trigger) {
            const title = getJobTitle(trigger);
            const titleEl = document.getElementById('modalBiodataJobTitle');
            if (titleEl) titleEl.textContent = title;
            const modal = document.getElementById('modalBelumBiodata');
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        }

        function tutupModalBelumBiodata() {
            const modal = document.getElementById('modalBelumBiodata');
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        }

        function handleAkunAdmin() {
            const modal = document.getElementById('modalAkunAdmin');
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        }

        function tutupModalAkunAdmin() {
            const modal = document.getElementById('modalAkunAdmin');
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        }

        let pendingLamarForm = null;
        let pendingLamarButton = null;

        function konfirmasiLamar(button) {
            const title = getJobTitle(button);
            pendingLamarButton = button;
            pendingLamarForm = button.closest('form');

            const titleEl = document.getElementById('modalLamarJobTitle');
            if (titleEl) {
                titleEl.textContent = title;
            }

            const modal = document.getElementById('modalKonfirmasiLamar');
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        }

        function tutupModalLamar() {
            const modal = document.getElementById('modalKonfirmasiLamar');
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
            pendingLamarForm = null;
            pendingLamarButton = null;
        }

        document.getElementById('btnSubmitLamar')?.addEventListener('click', function() {
            if (pendingLamarForm && pendingLamarButton) {
                this.disabled = true;
                this.textContent = 'Mengirim...';
                pendingLamarButton.disabled = true;
                pendingLamarButton.textContent = 'Mengirim...';
                pendingLamarForm.submit();
            }
        });
    </script>
@endsection

