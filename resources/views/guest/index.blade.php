@extends('guest.layouts.index')

@section('title', 'Selamat Datang')

@section('content')
    <section id="beranda"
        class="relative w-full min-h-[540px] md:min-h-[580px] lg:min-h-[620px] bg-slate-900 overflow-hidden flex flex-col justify-between pt-24 pb-8 md:pt-28 md:pb-10">
        <!-- Background Team Dummy Image -->
        <img src="{{ asset('assets/images/hero-dummy-team.jpg') }}" alt="Sosro Team Dummy"
            class="absolute inset-0 w-full h-full object-cover object-right md:object-[center_right] pointer-events-none select-none">

        <!-- Red Brand Arc / Curved Gradient Overlay (Sesuai Mockup Sosro) -->
        <div
            class="absolute -left-36 md:-left-20 -top-24 md:-top-32 w-[550px] sm:w-[650px] md:w-[750px] lg:w-[860px] h-[550px] sm:h-[650px] md:h-[750px] lg:h-[860px] rounded-full bg-gradient-to-br from-[#c8102e] via-[#B11116] to-[#8b0a0e] shadow-2xl z-10 pointer-events-none opacity-95">
        </div>

        <!-- Wave Overlay along Bottom (Merah Melengkung di Bagian Bawah) -->
        <div
            class="absolute inset-x-0 bottom-0 h-32 md:h-40 bg-gradient-to-t from-[#B11116] via-[#B11116]/85 to-transparent z-10 pointer-events-none">
        </div>

        <!-- Watermark Daun Teh & Botol Sosro di Area Kurva Merah -->
        <div
            class="absolute left-6 top-24 md:left-12 md:top-28 z-15 pointer-events-none opacity-20 text-white hidden sm:block">
            <svg class="w-28 h-28" viewBox="0 0 100 100" fill="currentColor">
                <!-- Daun 1 -->
                <path d="M20,60 C20,30 50,20 60,20 C60,50 40,65 20,60 Z" />
                <!-- Siluet Botol -->
                <path
                    d="M72,40 C72,35 75,32 75,25 L79,25 C79,32 82,35 82,40 L84,55 C84,65 80,75 77,75 C74,75 70,65 70,55 Z" />
                <!-- Daun 2 -->
                <path d="M35,80 C35,65 55,55 65,55 C65,70 50,85 35,80 Z" />
            </svg>
        </div>

        <!-- Watermark Daun di Kanan Bawah Wave -->
        <div
            class="absolute right-6 bottom-4 md:right-16 md:bottom-6 z-15 pointer-events-none opacity-20 text-white hidden sm:block">
            <svg class="w-24 h-24" viewBox="0 0 100 100" fill="currentColor">
                <path d="M30,70 C30,45 60,35 70,35 C70,60 50,75 30,70 Z" />
                <path d="M55,85 C55,70 75,60 85,60 C85,75 70,90 55,85 Z" />
            </svg>
        </div>

        <!-- Center / Headline Text "Work Together As A Team" -->
        <div class="relative z-20 max-w-7xl mx-auto px-6 md:px-12 w-full my-auto py-8 md:py-12">
            <div class="max-w-md lg:max-w-lg text-left">
                <h1 data-i18n-key="hero_title"
                    class="text-4xl sm:text-5xl lg:text-6xl text-white font-semibold leading-[1.12] tracking-tight drop-shadow-md">
                    Work Together<br>As A Team
                </h1>
            </div>
        </div>

        <!-- Floating Search & Filter Bar (Pills Shape Sesuai Mockup) -->
        <div class="relative z-20 max-w-6xl mx-auto px-4 sm:px-6 w-full mt-auto">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3 items-center">
                <!-- Search Input Pill -->
                <div
                    class="lg:col-span-5 relative flex items-center bg-white rounded-full shadow-lg border border-slate-100 px-2 py-1 transition focus-within:ring-2 focus-within:ring-[#B11116]/30">
                    <label for="jobSearch" class="sr-only">Cari lowongan</label>
                    <input id="jobSearch" type="search" placeholder="Cari lowongan..." data-i18n-key="search_placeholder"
                        class="w-full bg-transparent px-4 py-2 text-sm text-slate-800 placeholder:text-slate-400 focus:outline-none font-semibold" />
                    <button type="button" id="btnSearch" data-i18n-key="search_btn" aria-label="Cari"
                        class="cursor-pointer hover:cursor-pointer flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[#B11116] text-white transition hover:bg-[#940e13]">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="m21 21-4.35-4.35m1.35-5.4a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0Z" />
                        </svg>
                    </button>
                </div>

                <!-- Location Filter Pill -->
                <div class="lg:col-span-2 relative">
                    <label for="filterLocation" class="sr-only">Filter lokasi</label>
                    <select id="filterLocation"
                        class="w-full cursor-pointer hover:cursor-pointer appearance-none rounded-full bg-white px-5 pr-10 py-3 text-sm font-semibold text-slate-700 shadow-lg border border-slate-100 transition hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-[#B11116]/30">
                        <option value="" data-i18n-key="opt_all_locations">Semua Lokasi</option>
                        @foreach ($jobs->pluck('location')->unique()->filter()->values() as $loc)
                            <option value="{{ $loc }}">{{ $loc }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-[#B11116]">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m6 9 6 6 6-6" />
                        </svg>
                    </div>
                </div>

                <!-- Category Filter Pill -->
                <div class="lg:col-span-3 relative">
                    <label for="filterCategory" class="sr-only">Filter kategori</label>
                    <select id="filterCategory"
                        class="w-full cursor-pointer hover:cursor-pointer appearance-none rounded-full bg-white px-5 pr-10 py-3 text-sm font-semibold text-slate-700 shadow-lg border border-slate-100 transition hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-[#B11116]/30">
                        <option value="" data-i18n-key="opt_all_categories">Semua Kategori</option>
                        @foreach ($jobs->pluck('category')->unique()->filter()->values() as $cat)
                            <option value="{{ $cat }}">{{ ucwords(str_replace('_', ' ', $cat)) }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-[#B11116]">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m6 9 6 6 6-6" />
                        </svg>
                    </div>
                </div>

                <!-- Bidang Filter Pill -->
                <div class="lg:col-span-2 relative">
                    <label for="filterBidang" class="sr-only">Filter bidang pekerjaan</label>
                    <select id="filterBidang"
                        class="w-full cursor-pointer hover:cursor-pointer appearance-none rounded-full bg-white px-5 pr-10 py-3 text-sm font-semibold text-slate-700 shadow-lg border border-slate-100 transition hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-[#B11116]/30">
                        <option value="" data-i18n-key="opt_all_fields">Semua Bidang</option>
                        @foreach ($jobs->pluck('occupation')->unique()->filter()->values() as $occ)
                            <option value="{{ $occ }}">{{ $occ }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-[#B11116]">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m6 9 6 6 6-6" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-14 bg-white" id="lowongan">
        <div class="max-w-6xl mx-auto px-6">
            <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p data-i18n-key="section_career_label"
                        class="text-sm font-semibold uppercase tracking-wider text-[#B11116]">Karier bersama kami</p>
                    <h2 data-i18n-key="section_career_title"
                        class="mt-1 text-2xl font-semibold tracking-tight text-slate-900 sm:text-3xl">Temukan lowongan yang
                        sesuai</h2>
                    <p data-i18n-key="section_career_desc"
                        class="mt-2 max-w-2xl text-sm leading-6 text-slate-600 font-normal">Gunakan pencarian dan filter
                        untuk menemukan posisi berdasarkan lokasi, kategori, atau bidang pekerjaan.</p>
                </div>

                <div
                    class="inline-flex w-fit items-center gap-3 rounded-xl border border-slate-200 bg-white px-4 py-3 shadow-sm">
                    <span id="jobCount" aria-live="polite"
                        class="inline-flex h-9 min-w-9 items-center justify-center rounded-lg bg-red-50 px-2 text-sm font-semibold text-[#B11116]">
                        {{ $jobs->count() }}
                    </span>
                    <span data-i18n-key="vacancies_available" class="text-sm font-medium text-slate-600">lowongan
                        tersedia</span>
                </div>
            </div>
            </select>
            <div
                class="pointer-events-none absolute right-2.5 top-1/2 flex h-8 w-8 -translate-y-1/2 items-center justify-center rounded-lg bg-slate-100 text-slate-600">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9 6 6 6-6" />
                </svg>
            </div>
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
                                @elseif (!$applicant)
                                    {{-- KONDISI 2: Sudah login, tapi belum isi biodata --}}
                                    <button type="button" onclick="handleBelumBiodata(this)"
                                        data-title="{{ $job->title }}"
                                        class="cursor-pointer hover:cursor-pointer inline-flex min-h-11 items-center justify-center rounded-xl bg-[#B11116] px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#940e13] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#B11116] focus-visible:ring-offset-2 active:scale-[0.98]">
                                        Lamar posisi ini
                                    </button>
                                @else
                                    {{-- KONDISI 3: Sudah login dan sudah isi biodata --}}
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
                            {{-- KONDISI 1: Belum login --}}
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
                    <p class="text-slate-500 font-semibold text-base">Saat ini belum ada lowongan pekerjaan yang dibuka.
                    </p>
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
                <p class="mt-1 text-sm text-slate-500">Tidak ada posisi yang cocok dengan kata kunci atau filter yang Anda
                    pilih.</p>
                <button type="button" id="btnResetFilter"
                    class="mt-4 cursor-pointer hover:cursor-pointer inline-flex items-center gap-2 rounded-xl bg-slate-200 px-4 py-2 text-xs font-semibold text-slate-700 transition hover:bg-slate-300">
                    Reset Filter
                </button>
            </div>
        </div>
        </div>
    </section>

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

            if (jobSearch) {
                jobSearch.addEventListener('input', function() {
                    updateBidangOptions();
                    filterJobs();
                });
                jobSearch.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        updateBidangOptions();
                        filterJobs();
                    }
                });
            }

            if (btnSearch) {
                btnSearch.addEventListener('click', function() {
                    updateBidangOptions();
                    filterJobs();
                });
            }

            if (filterLocation) {
                filterLocation.addEventListener('change', function() {
                    updateBidangOptions();
                    filterJobs();
                });
            }

            if (filterCategory) {
                filterCategory.addEventListener('change', function() {
                    updateBidangOptions();
                    filterJobs();
                });
            }

            if (filterBidang) {
                filterBidang.addEventListener('change', filterJobs);
            }

            if (btnResetFilter) {
                btnResetFilter.addEventListener('click', function() {
                    if (jobSearch) jobSearch.value = '';
                    if (filterLocation) filterLocation.value = '';
                    if (filterCategory) filterCategory.value = '';
                    if (filterBidang) filterBidang.value = '';
                    updateBidangOptions();
                    filterJobs();
                });
            }

            // Sync with URL params if any
            const urlParams = new URLSearchParams(window.location.search);
            let hasParams = false;
            if (urlParams.get('search') && jobSearch) {
                jobSearch.value = urlParams.get('search');
                hasParams = true;
            }
            if (urlParams.get('location') && filterLocation) {
                filterLocation.value = urlParams.get('location');
                hasParams = true;
            }
            if (urlParams.get('category') && filterCategory) {
                filterCategory.value = urlParams.get('category');
                hasParams = true;
            }
            updateBidangOptions();
            if (urlParams.get('bidang') && filterBidang) {
                filterBidang.value = urlParams.get('bidang');
                hasParams = true;
            }
            filterJobs();
        });
    </script>

    <!-- MODAL 1: Notifikasi Belum Login -->
    <div id="modalBelumLogin"
        class="fixed inset-0 z-[100] hidden items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm transition-all"
        role="dialog" aria-modal="true">
        <div
            class="bg-white w-full max-w-md rounded-2xl shadow-2xl border border-slate-200 overflow-hidden transform transition-all">
            <div class="p-6 text-center">
                <div
                    class="w-12 h-12 rounded-2xl bg-amber-50 border border-amber-100 flex items-center justify-center text-amber-600 mx-auto mb-4 shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                    </svg>
                </div>
                <h3 class="text-base font-semibold text-slate-900">
                    Masuk ke Akun Diperlukan
                </h3>
                <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                    Anda harus masuk (login) ke akun Anda terlebih dahulu untuk dapat melamar posisi <span
                        id="modalLoginJobTitle" class="font-semibold text-slate-800"></span>.
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
        <div
            class="bg-white w-full max-w-md rounded-2xl shadow-2xl border border-slate-200 overflow-hidden transform transition-all">
            <div class="p-6 text-center">
                <div
                    class="w-12 h-12 rounded-2xl bg-amber-50 border border-amber-100 flex items-center justify-center text-amber-600 mx-auto mb-4 shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                </div>
                <h3 class="text-base font-semibold text-slate-900">
                    Lengkapi Biodata Anda
                </h3>
                <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                    Anda harus melengkapi data biodata pelamar terlebih dahulu sebelum dapat melamar posisi <span
                        id="modalBiodataJobTitle" class="font-semibold text-slate-800"></span>.
                </p>
            </div>
            <div class="px-6 py-4 bg-slate-50/70 border-t border-slate-100 flex items-center justify-end gap-2.5">
                <button type="button" onclick="tutupModalBelumBiodata()"
                    class="px-4 py-2 rounded-xl border border-slate-200 bg-white text-slate-600 hover:bg-slate-100 hover:text-slate-800 font-semibold text-xs transition cursor-pointer">
                    Batal
                </button>
                <a href="{{ route('biodata.create') }}?required=1"
                    class="inline-flex items-center gap-1.5 px-5 py-2 rounded-xl bg-[#B11116] hover:bg-[#940e13] text-white font-semibold text-xs shadow-sm transition cursor-pointer">
                    Isi Biodata Sekarang
                </a>
            </div>
        </div>
    </div>

    <!-- MODAL 3: Konfirmasi Lamar (Sudah Login & Biodata Terisi) -->
    <div id="modalKonfirmasiLamar"
        class="fixed inset-0 z-[100] hidden items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm transition-all"
        role="dialog" aria-modal="true">
        <div
            class="bg-white w-full max-w-md rounded-2xl shadow-2xl border border-slate-200 overflow-hidden transform transition-all">
            <div class="p-6 text-center">
                <div
                    class="w-12 h-12 rounded-2xl bg-red-50 border border-red-100 flex items-center justify-center text-[#B11116] mx-auto mb-4 shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0zm-9 3.75h.008v.008H12v-.008z" />
                    </svg>
                </div>
                <h3 class="text-base font-semibold text-slate-900">
                    Kirim Lamaran Pekerjaan?
                </h3>
                <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                    Apakah Anda yakin ingin mengirimkan lamaran untuk posisi <span id="modalLamarJobTitle"
                        class="font-semibold text-slate-800"></span>?
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
        <div
            class="bg-white w-full max-w-md rounded-2xl shadow-2xl border border-slate-200 overflow-hidden transform transition-all">
            <div class="p-6 text-center">
                <div
                    class="w-12 h-12 rounded-2xl bg-amber-50 border border-amber-100 flex items-center justify-center text-amber-600 mx-auto mb-4 shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                </div>
                <h3 class="text-base font-semibold text-slate-900">
                    Akses Dibatasi
                </h3>
                <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                    Anda sedang masuk sebagai <span class="font-semibold text-slate-800">Administrator</span>. Akun
                    Administrator tidak dapat melamar lowongan pekerjaan. Silakan gunakan akun Pelamar untuk melamar
                    lowongan.
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

    <script>
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

        // Tutup modal ketika klik area background (backdrop)
        ['modalBelumLogin', 'modalBelumBiodata', 'modalKonfirmasiLamar', 'modalAkunAdmin'].forEach(function(id) {
            const modalEl = document.getElementById(id);
            if (modalEl) {
                modalEl.addEventListener('click', function(e) {
                    if (e.target === modalEl) {
                        modalEl.classList.add('hidden');
                        modalEl.classList.remove('flex');
                    }
                });
            }
        });

        // Tutup modal ketika tombol Escape ditekan
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                tutupModalBelumLogin();
                tutupModalBelumBiodata();
                tutupModalLamar();
                tutupModalAkunAdmin();
            }
        });
    </script>
@endsection
