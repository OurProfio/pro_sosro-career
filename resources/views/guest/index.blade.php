@extends('guest.layouts.index')

@section('title', 'Selamat Datang')

@section('content')
    <section class="relative w-full overflow-hidden bg-black">
        <img src="{{ asset('assets/images/lowongan-hero.webp') }}" alt="Intip Keseruan Insan Sinar Sosro Gunung Slamat"
            class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-x-0 bottom-0 h-1/2 bg-gradient-to-t from-red-900 via-red/80 to-transparent"></div>
        <div class="flex items-center justify-center px-6 py-40 md:px-20 max-w-7xl mx-auto">
            <div class="w-full text-center md:text-left z-10">
                <h1
                    class="text-4xl md:text-5xl lg:text-[2.7rem] text-white font-bold uppercase leading-[1.1] md:max-w-[700px] drop-shadow-lg">
                    Bersama Kami, Menjadi Bagian Sinar Sosro Gunung Slamat
                </h1>
                <p class="text-lg md:text-xl text-white mt-6 md:mt-8 max-w-2xl">
                    Bergabunglah dengan tim kami, baik sebagai talenta muda maupun profesional berpengalaman. Pilih kategori
                    yang sesuai untuk mengembangkan potensi karirmu.
                </p>
                <a href="#lowongan"
                    class="max-md:mx-auto cursor-pointer hover:cursor-pointer px-6 py-2 rounded-full bg-white text-red-700 font-bold block mt-5 w-max hover:bg-red-700 hover:text-white transition shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                    Lihat Lowongan
                </a>
            </div>
        </div>
    </section>

    <section class="py-20 bg-white" id="lowongan">
        <div class="max-w-6xl mx-auto px-6">
            <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-sm font-bold uppercase tracking-wider text-[#B11116]">Karier bersama kami</p>
                    <h2 class="mt-1 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">Temukan lowongan yang sesuai</h2>
                    <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-600">Gunakan pencarian dan filter untuk menemukan posisi berdasarkan lokasi, kategori, atau bidang pekerjaan.</p>
                </div>

                <div class="inline-flex w-fit items-center gap-3 rounded-xl border border-slate-200 bg-white px-4 py-3 shadow-sm">
                    <span id="jobCount" aria-live="polite" class="inline-flex h-9 min-w-9 items-center justify-center rounded-lg bg-red-50 px-2 text-sm font-bold text-[#B11116]">
                        {{ $jobs->count() }}
                    </span>
                    <span class="text-sm font-medium text-slate-600">lowongan tersedia</span>
                </div>
            </div>

            <div class="mb-10 grid grid-cols-1 gap-3 lg:grid-cols-5">
                <div class="flex min-h-13 w-full items-center gap-3 rounded-xl border border-slate-200 bg-white px-3 shadow-sm transition focus-within:border-[#B11116] focus-within:ring-2 focus-within:ring-[#B11116]/20 lg:col-span-2">
                    <label for="jobSearch" class="sr-only">Cari lowongan berdasarkan kata kunci</label>
                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-slate-100 text-slate-500" aria-hidden="true">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.35-4.35m1.35-5.4a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0Z" />
                        </svg>
                    </div>
                    <input id="jobSearch" type="search" placeholder="Cari posisi, lokasi, atau kata kunci..."
                        class="min-w-0 flex-1 border-0 bg-transparent px-1 py-3 text-sm text-slate-800 placeholder:text-slate-400 focus:outline-none focus:ring-0" />
                    <button type="button" id="btnSearch"
                        class="cursor-pointer hover:cursor-pointer inline-flex min-h-11 shrink-0 items-center justify-center rounded-lg bg-[#B11116] px-5 text-sm font-bold text-white transition hover:bg-[#940e13] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#B11116] focus-visible:ring-offset-2">
                        Cari
                    </button>
                </div>

                <div class="relative w-full font-semibold lg:col-span-1">
                    <label for="filterLocation" class="sr-only">Filter berdasarkan lokasi</label>
                    <select id="filterLocation"
                        class="min-h-13 w-full cursor-pointer hover:cursor-pointer appearance-none rounded-xl border border-slate-200 bg-white px-4 pr-14 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50 focus:border-[#B11116] focus:outline-none focus:ring-2 focus:ring-[#B11116]/20">
                        <option value="">Semua Lokasi</option>
                        @foreach ($jobs->pluck('location')->unique()->filter()->values() as $loc)
                            <option value="{{ $loc }}">{{ $loc }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute right-2.5 top-1/2 flex h-8 w-8 -translate-y-1/2 items-center justify-center rounded-lg bg-slate-100 text-slate-600">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9 6 6 6-6" />
                        </svg>
                    </div>
                </div>

                <div class="relative w-full font-semibold lg:col-span-1">
                    <label for="filterCategory" class="sr-only">Filter berdasarkan kategori</label>
                    <select id="filterCategory"
                        class="min-h-13 w-full cursor-pointer hover:cursor-pointer appearance-none rounded-xl border border-slate-200 bg-white px-4 pr-14 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50 focus:border-[#B11116] focus:outline-none focus:ring-2 focus:ring-[#B11116]/20">
                        <option value="">Semua Kategori</option>
                        @foreach ($jobs->pluck('category')->unique()->filter()->values() as $cat)
                            <option value="{{ $cat }}">{{ ucwords(str_replace('_', ' ', $cat)) }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute right-2.5 top-1/2 flex h-8 w-8 -translate-y-1/2 items-center justify-center rounded-lg bg-slate-100 text-slate-600">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9 6 6 6-6" />
                        </svg>
                    </div>
                </div>

                <div class="relative w-full font-semibold lg:col-span-1">
                    <label for="filterBidang" class="sr-only">Filter berdasarkan bidang pekerjaan</label>
                    <select id="filterBidang"
                        class="min-h-13 w-full cursor-pointer hover:cursor-pointer appearance-none rounded-xl border border-slate-200 bg-white px-4 pr-14 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50 focus:border-[#B11116] focus:outline-none focus:ring-2 focus:ring-[#B11116]/20">
                        <option value="">Semua Bidang</option>
                        @foreach ($jobs->pluck('occupation')->unique()->filter()->values() as $occ)
                            <option value="{{ $occ }}">{{ $occ }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute right-2.5 top-1/2 flex h-8 w-8 -translate-y-1/2 items-center justify-center rounded-lg bg-slate-100 text-slate-600">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9 6 6 6-6" />
                        </svg>
                    </div>
                </div>
            </div>

            <div id="jobList" class="grid md:grid-cols-2 gap-6">
                @forelse ($jobs as $job)
                    <article class="job-card flex h-full flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-red-200 hover:shadow-lg focus-within:ring-2 focus-within:ring-[#B11116]/30"
                        data-title="{{ strtolower($job->title) }}"
                        data-location="{{ strtolower($job->location) }}"
                        data-category="{{ strtolower($job->category) }}"
                        data-bidang="{{ strtolower($job->occupation) }}"
                        data-search="{{ strtolower($job->title . ' ' . $job->location . ' ' . ($job->office->name ?? '') . ' ' . str_replace('_', ' ', $job->category) . ' ' . $job->occupation . ' ' . $job->type . ' ' . strip_tags($job->qualification) . ' ' . strip_tags($job->description)) }}">
                        <div class="flex-1 p-5 sm:p-6">
                            <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                                <div class="min-w-0">
                                    <span class="inline-flex items-center rounded-full bg-red-50 px-3 py-1 text-xs font-semibold text-[#B11116]">
                                        {{ ucwords(str_replace('_', ' ', $job->category)) }}
                                    </span>
                                    <h3 class="mt-3 text-xl font-bold leading-7 text-slate-900 sm:text-2xl">{{ $job->title }}</h3>
                                </div>
                                <div class="shrink-0 rounded-xl border border-amber-200 bg-amber-50 text-amber-800 px-3.5 py-2.5 sm:text-right">
                                    <p class="text-[11px] font-semibold uppercase tracking-wide text-amber-800">
                                        Batas lamaran
                                    </p>
                                    <p class="mt-0.5 text-sm font-bold text-amber-950">
                                        {{ \Carbon\Carbon::parse($job->closing_date)->translatedFormat('d F Y') }}
                                    </p>
                                </div>
                            </div>

                            <dl class="mt-5 grid grid-cols-1 gap-3 sm:grid-cols-3">
                                <div class="rounded-xl bg-slate-50 p-3.5">
                                    <dt class="text-[11px] font-semibold uppercase tracking-wide text-slate-500">Lokasi</dt>
                                    <dd class="mt-1 text-sm font-medium leading-5 text-slate-800">{{ $job->location }} <span class="font-normal text-slate-500">({{ $job->office->name ?? 'Cabang' }})</span></dd>
                                </div>
                                <div class="rounded-xl bg-slate-50 p-3.5">
                                    <dt class="text-[11px] font-semibold uppercase tracking-wide text-slate-500">Bidang</dt>
                                    <dd class="mt-1 text-sm font-medium leading-5 text-slate-800">{{ $job->occupation }}</dd>
                                </div>
                                <div class="rounded-xl bg-slate-50 p-3.5">
                                    <dt class="text-[11px] font-semibold uppercase tracking-wide text-slate-500">Tipe pekerjaan</dt>
                                    <dd class="mt-1 text-sm font-medium leading-5 text-slate-800">{{ $job->type }}</dd>
                                </div>
                            </dl>

                            <div class="mt-5 space-y-2">
                                <details class="group rounded-xl border border-slate-200">
                                    <summary class="flex min-h-11 cursor-pointer hover:cursor-pointer list-none items-center justify-between gap-3 rounded-xl px-4 py-3 text-sm font-semibold text-slate-800 transition hover:bg-slate-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-[#B11116] [&::-webkit-details-marker]:hidden">
                                        <span>Kualifikasi</span>
                                        <svg class="h-4 w-4 shrink-0 text-slate-500 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9 6 6 6-6" /></svg>
                                    </summary>
                                    <div class="border-t border-slate-100 px-4 py-3 text-sm leading-6 text-slate-600 whitespace-pre-line">{{ $job->qualification }}</div>
                                </details>
                                <details class="group rounded-xl border border-slate-200">
                                    <summary class="flex min-h-11 cursor-pointer hover:cursor-pointer list-none items-center justify-between gap-3 rounded-xl px-4 py-3 text-sm font-semibold text-slate-800 transition hover:bg-slate-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-[#B11116] [&::-webkit-details-marker]:hidden">
                                        <span>Deskripsi pekerjaan</span>
                                        <svg class="h-4 w-4 shrink-0 text-slate-500 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9 6 6 6-6" /></svg>
                                    </summary>
                                    <div class="border-t border-slate-100 px-4 py-3 text-sm leading-6 text-slate-600 whitespace-pre-line">{{ $job->description }}</div>
                                </details>
                            </div>
                        </div>

                        <div class="flex flex-col gap-3 border-t border-slate-100 bg-slate-50/70 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                            <p class="text-xs leading-5 text-slate-500">Periksa kualifikasi sebelum mengirim lamaran.</p>
                            @auth
                                @php
                                    $applicant = auth()->user()->applicant;
                                    $sudahMelamar = $applicant
                                        ? \App\Models\Application::where('applicant_id', $applicant->id)
                                            ->where('job_id', $job->id)
                                            ->exists()
                                        : false;
                                @endphp

                                @if ($sudahMelamar)
                                    <button disabled aria-disabled="true"
                                        class="inline-flex min-h-11 cursor-not-allowed items-center justify-center gap-2 rounded-xl bg-emerald-50 px-5 py-2.5 text-sm font-semibold text-emerald-800 ring-1 ring-inset ring-emerald-200">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m5 13 4 4L19 7" /></svg>
                                        Sudah dilamar
                                    </button>
                                @else
                                    <form action="{{ route('applications.store') }}" method="POST" class="form-apply">
                                        @csrf
                                        <input type="hidden" name="job_id" value="{{ $job->id }}">
                                        <button type="button" onclick="konfirmasiLamar(this)" data-title="{{ $job->title }}"
                                            class="cursor-pointer hover:cursor-pointer inline-flex min-h-11 items-center justify-center rounded-xl bg-[#B11116] px-6 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-[#940e13] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#B11116] focus-visible:ring-offset-2 active:scale-[0.98]">
                                            Lamar posisi ini
                                        </button>
                                    </form>
                                @endif
                            @else
                                <a href="{{ route('guest.login') }}"
                                    class="cursor-pointer hover:cursor-pointer inline-flex min-h-11 items-center justify-center rounded-xl bg-[#B11116] px-6 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-[#940e13] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#B11116] focus-visible:ring-offset-2">
                                    Masuk untuk melamar
                                </a>
                            @endauth
                        </div>
                    </article>
                @empty
                    <div
                        class="col-span-1 md:col-span-2 text-center py-12 bg-slate-50 rounded-2xl border border-dashed border-slate-300">
                        <p class="text-slate-500 font-semibold text-base">Saat ini belum ada lowongan pekerjaan yang dibuka.</p>
                    </div>
                @endforelse

                <div id="noJobFound" class="col-span-1 md:col-span-2 hidden text-center py-12 px-4 bg-slate-50 rounded-2xl border border-dashed border-slate-300">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-red-50 text-[#B11116] mb-3">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.35-4.35m1.35-5.4a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0Z" />
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-slate-800">Tidak ada lowongan ditemukan</h3>
                    <p class="mt-1 text-sm text-slate-500">Tidak ada posisi yang cocok dengan kata kunci atau filter yang Anda pilih.</p>
                    <button type="button" id="btnResetFilter"
                        class="mt-4 cursor-pointer hover:cursor-pointer inline-flex items-center gap-2 rounded-xl bg-slate-200 px-4 py-2 text-xs font-bold text-slate-700 transition hover:bg-slate-300">
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
                jobSearch.addEventListener('input', filterJobs);
                jobSearch.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        filterJobs();
                    }
                });
            }

            if (btnSearch) {
                btnSearch.addEventListener('click', filterJobs);
            }

            if (filterLocation) {
                filterLocation.addEventListener('change', filterJobs);
            }

            if (filterCategory) {
                filterCategory.addEventListener('change', filterJobs);
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
            if (urlParams.get('bidang') && filterBidang) {
                filterBidang.value = urlParams.get('bidang');
                hasParams = true;
            }
            if (hasParams) {
                filterJobs();
            }
        });

        function konfirmasiLamar(button) {
            const title = button.dataset.title;
            const form = button.closest('form');

            if (!window.confirm(`Kirim lamaran untuk posisi "${title}"?`)) {
                return;
            }

            button.disabled = true;
            button.textContent = 'Mengirim...';
            form.submit();
        }
    </script>

    <script>
        @if (session('success'))
            window.alert(@json(session('success')));
        @endif

        @if (session('error'))
            window.alert(@json(session('error')));
        @endif
    </script>
@endsection
