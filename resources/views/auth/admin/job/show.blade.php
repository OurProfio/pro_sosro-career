@extends('auth.admin.layouts.index')

@section('title', 'Detail Lowongan - ' . ($job->title ?? 'Sinar Sosro'))

@section('content')
    @php
        $totalApplicants = $job->applications->count();
        $acceptedApplicants = $job->applications->where('status', 'accepted')->count();
        $rejectedApplicants = $job->applications->where('status', 'rejected')->count();
        $inProgressApplicants = $job->applications->whereIn('status', ['pending', 'progress'])->count();
        $recent24hCount = $job->applications->filter(fn ($app) => $app->created_at && $app->created_at->greaterThanOrEqualTo(now()->subDay()))->count();

        $closingDate = $job->closing_date ? \Carbon\Carbon::parse($job->closing_date)->startOfDay() : null;
        $daysRemaining = $closingDate ? (int) today()->diffInDays($closingDate, false) : null;
    @endphp

    <div class="flex flex-col w-full space-y-6 pb-8 font-sans"
        x-data="{
            openEditModal: {{ $errors->any() ? 'true' : 'false' }},
            closeModalOpen: false,
            searchQuery: '',
            stageFilter: '',
            eduFilter: '',
            visibleApplicantsCount: {{ $job->applications->count() }},
            filterApplicants() {
                this.$nextTick(() => {
                    const rows = document.querySelectorAll('.applicant-row');
                    let count = 0;
                    const q = (this.searchQuery || '').trim().toLowerCase();
                    const stage = (this.stageFilter || '').trim().toLowerCase();
                    const edu = (this.eduFilter || '').trim().toLowerCase();

                    rows.forEach(r => {
                        const search = (r.dataset.search || '').toLowerCase();
                        const rStage = (r.dataset.stage || '').toLowerCase();
                        const rEdu = (r.dataset.edu || '').toLowerCase();

                        const matchSearch = !q || search.includes(q);
                        const matchStage = !stage || rStage.includes(stage);
                        const matchEdu = !edu || rEdu.includes(edu);

                        if (matchSearch && matchStage && matchEdu) {
                            r.style.display = '';
                            count++;
                        } else {
                            r.style.display = 'none';
                        }
                    });

                    this.visibleApplicantsCount = count;
                });
            }
        }"
        x-init="
            $watch('searchQuery', () => filterApplicants());
            $watch('stageFilter', () => filterApplicants());
            $watch('eduFilter', () => filterApplicants());
        ">

        <!-- Top Bar / Action Controls (UNIFIED HCI PATTERN) -->
        <section class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-3.5 border-b border-slate-200">
            <div class="flex items-center gap-3.5">
                <a class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-white border border-slate-200 shadow-2xs text-slate-600 hover:text-[#9b1b1f] hover:bg-slate-100 transition shrink-0"
                    href="{{ route('job.index') }}" title="Kembali ke Manajemen Lowongan">
                    <span class="material-symbols-outlined text-[20px]">arrow_back</span>
                </a>
                <div class="space-y-0.5">
                    <nav class="flex items-center gap-1.5 text-xs text-slate-400 font-medium">
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-[#9b1b1f] transition">Portal Karir</a>
                        <span class="material-symbols-outlined text-xs">chevron_right</span>
                        <a href="{{ route('job.index') }}" class="hover:text-[#9b1b1f] transition">Manajemen Lowongan</a>
                        <span class="material-symbols-outlined text-xs">chevron_right</span>
                        <span class="text-[#9b1b1f] font-bold">{{ $job->title }}</span>
                    </nav>
                    <h1 class="text-xl font-bold text-slate-900 tracking-tight">Detail Lowongan Pekerjaan</h1>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-wrap items-center gap-2.5">
                @if ($job->status === 'aktif')
                    <button type="button" @click="closeModalOpen = true"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-red-50 text-[#A6192E] border border-red-200 font-semibold text-xs shadow-2xs hover:bg-red-100 transition cursor-pointer">
                        <span class="material-symbols-outlined text-[16px]">lock</span>
                        Tutup Lowongan
                    </button>

                    <button type="button" @click="openEditModal = true"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-white border border-slate-200 text-slate-700 font-semibold text-xs shadow-2xs hover:bg-slate-100 transition cursor-pointer">
                        <span class="material-symbols-outlined text-[16px] text-slate-500">edit_square</span>
                        Edit Lowongan
                    </button>
                @else
                    <span class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-slate-100 border border-slate-200 text-slate-500 font-semibold text-xs cursor-not-allowed">
                        <span class="material-symbols-outlined text-[16px] text-slate-400">lock</span>
                        Lowongan Telah Ditutup
                    </span>
                @endif
            </div>
        </section>

        <!-- Header Banner & Position Summary -->
        <section class="bg-white rounded-2xl p-6 sm:p-8 border border-slate-200/80 shadow-2xs relative overflow-hidden">
            <!-- Decorative background glow -->
            <div class="absolute -right-16 -top-16 w-64 h-64 bg-red-100 rounded-full blur-3xl opacity-60 pointer-events-none"></div>

            <div class="relative z-10 flex flex-col lg:flex-row lg:items-start justify-between gap-6">
                <div class="space-y-3 max-w-3xl">
                    <div class="flex flex-wrap items-center gap-2.5">
                        @if ($job->status === 'aktif')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                Lowongan Aktif
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200">
                                <span class="w-2 h-2 rounded-full bg-slate-400"></span>
                                Lowongan Ditutup
                            </span>
                        @endif

                        @if ($job->category)
                            <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-700 uppercase tracking-wider">
                                {{ ucwords(str_replace('_', ' ', $job->category)) }}
                            </span>
                        @endif
                    </div>

                    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight leading-snug">
                        {{ $job->title }}
                    </h1>

                    <div class="flex flex-wrap items-center gap-y-2 gap-x-4 text-xs text-slate-500">
                        <span class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-base text-slate-400">person_pin</span>
                            Diposting oleh <strong class="text-slate-700 font-semibold">{{ $job->admin?->name ?? $job->admin?->user?->name ?? 'Admin HR' }}</strong>
                        </span>
                        <span class="inline-block w-1 h-1 rounded-full bg-slate-300"></span>
                        <span class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-base text-slate-400">calendar_today</span>
                            Dibuat {{ $job->opening_date ? \Carbon\Carbon::parse($job->opening_date)->translatedFormat('d M Y') : ($job->created_at ? $job->created_at->translatedFormat('d M Y') : '-') }}
                        </span>
                    </div>
                </div>

                <div class="flex items-center lg:flex-col lg:items-end justify-between border-t lg:border-t-0 pt-4 lg:pt-0 border-slate-100 gap-2 shrink-0">
                    <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">Masa Pendaftaran</span>
                    @if ($job->status !== 'aktif' || ($daysRemaining !== null && $daysRemaining < 0))
                        <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-slate-100 rounded-lg text-slate-600 text-xs font-bold">
                            <span class="material-symbols-outlined text-slate-500 text-sm">lock_clock</span>
                            Sudah Ditutup ({{ $closingDate ? $closingDate->translatedFormat('d M Y') : '-' }})
                        </div>
                    @elseif ($daysRemaining === 0)
                        <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-red-50 rounded-lg text-[#991b1b] text-xs font-bold border border-red-100">
                            <span class="material-symbols-outlined text-[#991b1b] text-sm">hourglass_bottom</span>
                            Hari Terakhir ({{ $closingDate->translatedFormat('d M Y') }})
                        </div>
                    @elseif ($daysRemaining !== null)
                        <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-amber-50 rounded-lg text-amber-800 text-xs font-bold border border-amber-100">
                            <span class="material-symbols-outlined text-amber-600 text-sm">hourglass_top</span>
                            Sisa {{ $daysRemaining }} Hari Lagi ({{ $closingDate->translatedFormat('d M Y') }})
                        </div>
                    @endif
                </div>
            </div>

            <!-- 6 Position Info Key Attributes -->
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 mt-6 pt-6 border-t border-slate-100">
                <div class="p-3 rounded-xl bg-slate-50/80 border border-slate-100">
                    <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Divisi / Bidang</p>
                    <p class="text-xs font-bold text-slate-800 mt-1 truncate" title="{{ $job->occupation }}">{{ $job->occupation ?? '-' }}</p>
                </div>
                <div class="p-3 rounded-xl bg-slate-50/80 border border-slate-100">
                    <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Tipe Kontrak</p>
                    <p class="text-xs font-bold text-slate-800 mt-1 truncate" title="{{ $job->type }}">{{ $job->type ?? '-' }}</p>
                </div>
                <div class="p-3 rounded-xl bg-slate-50/80 border border-slate-100">
                    <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Unit Kerja</p>
                    <p class="text-xs font-bold text-slate-800 mt-1 truncate" title="{{ $job->office->name ?? '-' }}">{{ $job->office->name ?? '-' }}</p>
                </div>
                <div class="p-3 rounded-xl bg-slate-50/80 border border-slate-100">
                    <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Penempatan</p>
                    <p class="text-xs font-bold text-slate-800 mt-1 truncate" title="{{ $job->location }}">{{ $job->location ?? '-' }}</p>
                </div>
                <div class="p-3 rounded-xl bg-slate-50/80 border border-slate-100">
                    <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Tanggal Buka</p>
                    <p class="text-xs font-bold text-slate-800 mt-1 truncate">
                        {{ $job->opening_date ? \Carbon\Carbon::parse($job->opening_date)->translatedFormat('d M Y') : '-' }}
                    </p>
                </div>
                <div class="p-3 rounded-xl bg-slate-50/80 border border-slate-100">
                    <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Batas Lamaran</p>
                    <p class="text-xs font-bold text-slate-800 mt-1 truncate">
                        {{ $job->closing_date ? \Carbon\Carbon::parse($job->closing_date)->translatedFormat('d M Y') : '-' }}
                    </p>
                </div>
            </div>
        </section>

        <!-- Applicant Metrics Bar -->
        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Total Pelamar -->
            <div class="bg-white rounded-xl p-5 border border-slate-200/80 shadow-2xs flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Pelamar</p>
                    <h3 class="text-2xl font-bold text-slate-900 mt-1">
                        {{ number_format($totalApplicants, 0, ',', '.') }} <span class="text-xs font-normal text-slate-400">Kandidat</span>
                    </h3>
                    <p class="text-[11px] text-emerald-600 font-semibold mt-1 flex items-center gap-0.5">
                        <span class="material-symbols-outlined text-xs">trending_up</span>
                        +{{ $recent24hCount }} dalam 24 jam terakhir
                    </p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-red-50 text-[#991b1b] flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-2xl">groups</span>
                </div>
            </div>

            <!-- Dalam Proses -->
            <div class="bg-white rounded-xl p-5 border border-slate-200/80 shadow-2xs flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Dalam Proses</p>
                    <h3 class="text-2xl font-bold text-blue-900 mt-1">
                        {{ number_format($inProgressApplicants, 0, ',', '.') }} <span class="text-xs font-normal text-slate-400">Kandidat</span>
                    </h3>
                    <p class="text-[11px] text-slate-500 font-medium mt-1">Screening, Tes, Interview</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-2xl">sync</span>
                </div>
            </div>

            <!-- Diterima -->
            <div class="bg-white rounded-xl p-5 border border-slate-200/80 shadow-2xs flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Diterima (Accepted)</p>
                    <h3 class="text-2xl font-bold text-emerald-800 mt-1">
                        {{ number_format($acceptedApplicants, 0, ',', '.') }} <span class="text-xs font-normal text-slate-400">Kandidat</span>
                    </h3>
                    <p class="text-[11px] text-emerald-700 font-medium mt-1">Lolos seleksi akhir</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-2xl">verified</span>
                </div>
            </div>

            <!-- Ditolak / Gugur -->
            <div class="bg-white rounded-xl p-5 border border-slate-200/80 shadow-2xs flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Tidak Memenuhi</p>
                    <h3 class="text-2xl font-bold text-slate-600 mt-1">
                        {{ number_format($rejectedApplicants, 0, ',', '.') }} <span class="text-xs font-normal text-slate-400">Kandidat</span>
                    </h3>
                    <p class="text-[11px] text-slate-400 font-medium mt-1">Tidak lolos kualifikasi</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-500 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-2xl">person_cancel</span>
                </div>
            </div>
        </section>

        <!-- Job Details: Responsibilities & Qualifications (Split Bento Cards) -->
        <section class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Kolom Kiri: Deskripsi & Tanggung Jawab -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-2xs space-y-4">
                <div class="flex items-center gap-3 pb-3 border-b border-slate-100">
                    <div class="w-8 h-8 rounded-lg bg-red-50 text-[#991b1b] flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-lg">engineering</span>
                    </div>
                    <div>
                        <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wide">Deskripsi &amp; Tanggung Jawab</h2>
                        <p class="text-xs text-slate-400">Rincian tugas dan tanggung jawab posisi pekerjaan</p>
                    </div>
                </div>

                @if (trim($job->description ?? ''))
                    <div class="text-xs leading-relaxed text-slate-600 whitespace-pre-line">
                        {!! preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', e($job->description)) !!}
                    </div>
                @else
                    <p class="text-xs text-slate-400">Belum ada deskripsi pekerjaan.</p>
                @endif
            </div>

            <!-- Kolom Kanan: Kualifikasi & Kriteria Pelamar -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-2xs space-y-4">
                <div class="flex items-center gap-3 pb-3 border-b border-slate-100">
                    <div class="w-8 h-8 rounded-lg bg-red-50 text-[#991b1b] flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-lg">assignment_ind</span>
                    </div>
                    <div>
                        <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wide">Kualifikasi &amp; Kriteria Pelamar</h2>
                        <p class="text-xs text-slate-400">Standar kualifikasi teknis &amp; persyaratan kandidat</p>
                    </div>
                </div>

                @if (trim($job->qualification ?? ''))
                    <div class="text-xs leading-relaxed text-slate-600 whitespace-pre-line">
                        {!! preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', e($job->qualification)) !!}
                    </div>
                @else
                    <p class="text-xs text-slate-400">Belum ada kualifikasi pelamar.</p>
                @endif
            </div>
        </section>

        <!-- Main Section: Applicants Pipeline & Management Table -->
        <section class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs overflow-hidden space-y-6 p-6">
            <!-- Header of Applicants Section -->
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2">
                        <h2 class="text-lg font-bold text-slate-900">Kandidat Pelamar Lowongan Ini</h2>
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-50 text-[#991b1b]">
                            {{ $totalApplicants }} Orang
                        </span>
                    </div>
                    <p class="text-xs text-slate-500 mt-1">
                        Kelola dan tinjau seluruh berkas pelamar yang mendaftar pada posisi {{ $job->title }}.
                    </p>
                </div>
            </div>

            <!-- Filter Bar (Search & Dropdowns) -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 bg-slate-50 p-3.5 rounded-xl border border-slate-100">
                <!-- Search Input -->
                <div class="relative">
                    <span class="material-symbols-outlined text-slate-400 text-lg absolute left-3 top-2 pointer-events-none">search</span>
                    <input x-model="searchQuery"
                        @input="filterApplicants()"
                        class="w-full pl-9 pr-3 py-2 text-xs rounded-lg border border-slate-200 bg-white shadow-2xs placeholder:text-slate-400 focus:ring-2 focus:ring-[#991b1b]/20 focus:border-[#991b1b] text-slate-800"
                        placeholder="Cari Nama, NIK, atau Email..." type="text">
                </div>

                <!-- Stage Filter -->
                <div class="relative">
                    <select x-model="stageFilter"
                        @change="filterApplicants()"
                        class="w-full appearance-none py-2 pl-3 pr-9 text-xs rounded-lg border border-slate-200 bg-white shadow-2xs text-slate-700 focus:ring-2 focus:ring-[#991b1b]/20 focus:border-[#991b1b]">
                        <option value="">Semua Tahapan Seleksi</option>
                        @foreach ($stages as $stageOption)
                            <option value="{{ strtolower($stageOption->name) }}">{{ ucwords($stageOption->name) }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Education Filter -->
                <div class="relative">
                    <select x-model="eduFilter"
                        @change="filterApplicants()"
                        class="w-full appearance-none py-2 pl-3 pr-9 text-xs rounded-lg border border-slate-200 bg-white shadow-2xs text-slate-700 focus:ring-2 focus:ring-[#991b1b]/20 focus:border-[#991b1b]">
                        <option value="">Semua Tingkat Pendidikan</option>
                        <option value="s2">S2 / Magister</option>
                        <option value="s1">S1 / D4 Sarjana</option>
                        <option value="d3">D3 / Vokasi</option>
                        <option value="sma">SMA / SMK</option>
                    </select>
                </div>
            </div>

            <!-- Applicants Table -->
            @if ($job->applications->isEmpty())
                <div class="px-6 py-12 text-center bg-slate-50/50 rounded-xl border border-dashed border-slate-200">
                    <span class="material-symbols-outlined text-3xl text-slate-300">group_off</span>
                    <p class="text-sm font-semibold text-slate-600 mt-2">
                        Belum Ada Kandidat yang Melamar
                    </p>
                    <p class="text-xs text-slate-400 mt-0.5">
                        Pelamar yang mendaftar pada lowongan ini akan otomatis muncul di tabel ini.
                    </p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse min-w-[900px]">
                        <thead>
                            <tr class="bg-red-50/60 text-[11px] font-bold text-[#7f1d1d] uppercase tracking-wider rounded-lg">
                                <th class="py-3 px-3 rounded-l-lg w-12 text-center">NO</th>
                                <th class="py-3 px-4 text-center">KANDIDAT / PELAMAR</th>
                                <th class="py-3 px-4 text-center">PENDIDIKAN TERAKHIR</th>
                                <th class="py-3 px-4 text-center">PENGALAMAN KERJA</th>
                                <th class="py-3 px-3 text-center">TANGGAL LAMAR</th>
                                <th class="py-3 px-3 text-center">TAHAPAN SELEKSI</th>
                                <th class="py-3 px-3 text-center">STATUS</th>
                                <th class="py-3 px-4 text-center rounded-r-lg">AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-xs">
                            @foreach ($job->applications as $application)
                                @php
                                    $applicant = $application->applicant;
                                    $latestEdu = $applicant?->educations?->sortByDesc('graduation_year')->first();
                                    $latestExp = $applicant?->workExperiences?->sortByDesc(fn ($exp) => [$exp->end_date ?? '9999-12-31', $exp->start_date])->first();

                                    $appAge = $applicant?->date_of_birth ? \Carbon\Carbon::parse($applicant->date_of_birth)->age : null;
                                    $appGender = match (strtolower((string) $applicant?->gender)) {
                                        'l' => 'Laki-laki',
                                        'p' => 'Perempuan',
                                        default => '-',
                                    };

                                    $currentStage = $stages->firstWhere('id', $application->stages_id);
                                    $currentStep = $currentStage?->step ?? 0;

                                    $searchText = strtolower(trim(($applicant->name ?? '') . ' ' . ($applicant->nik ?? '') . ' ' . ($applicant->email ?? '')));
                                    $stageText = strtolower((string) ($currentStage->name ?? ''));
                                    $eduText = strtolower((string) ($latestEdu->degree_level ?? ''));
                                @endphp

                                <tr class="applicant-row hover:bg-slate-50/80 transition-colors group {{ $application->status === 'accepted' ? 'bg-emerald-50/20' : ($application->status === 'rejected' ? 'opacity-75' : '') }}"
                                    data-search="{{ $searchText }}"
                                    data-stage="{{ $stageText }}"
                                    data-edu="{{ $eduText }}"
                                    x-show="
                                        (!searchQuery || @js($searchText).includes(searchQuery.toLowerCase().trim())) &&
                                        (!stageFilter || @js($stageText).includes(stageFilter.toLowerCase().trim())) &&
                                        (!eduFilter || @js($eduText).includes(eduFilter.toLowerCase().trim()))
                                    ">
                                    <td class="py-3.5 px-3 text-center font-bold text-slate-400">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="py-3.5 px-4">
                                        <div class="flex items-center gap-3">
                                            @if ($applicant?->photo_url)
                                                <img class="w-10 h-10 rounded-full object-cover shrink-0 shadow-2xs border border-slate-200"
                                                    src="{{ asset('storage/' . $applicant->photo_url) }}"
                                                    alt="{{ $applicant->name }}">
                                            @else
                                                <div class="w-10 h-10 rounded-full bg-red-50 text-[#991b1b] border border-red-100 flex items-center justify-center font-bold text-xs shrink-0 shadow-2xs">
                                                    {{ strtoupper(substr($applicant->name ?? 'A', 0, 2)) }}
                                                </div>
                                            @endif
                                            <div class="min-w-0">
                                                <p class="font-bold text-slate-900 group-hover:text-[#991b1b] transition truncate">
                                                    {{ $applicant->name ?? '-' }}
                                                </p>
                                                <p class="text-[11px] text-slate-500 truncate">
                                                    {{ $applicant->email ?? '-' }} • {{ $appAge ? $appAge . ' Th' : '-' }} • <span class="text-slate-400">{{ $appGender }}</span>
                                                </p>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="py-3.5 px-4">
                                        @if ($latestEdu)
                                            <p class="font-semibold text-slate-800">
                                                {{ $latestEdu->degree_level }} {{ $latestEdu->major }}
                                            </p>
                                            <p class="text-[11px] text-slate-500">
                                                {{ $latestEdu->institution_name }}
                                                @if ($latestEdu->gpa !== null)
                                                    • IPK <span class="font-bold text-slate-700">{{ $latestEdu->gpa }}</span>
                                                @endif
                                            </p>
                                        @else
                                            <span class="text-slate-400">-</span>
                                        @endif
                                    </td>

                                    <td class="py-3.5 px-4">
                                        @if ($latestExp)
                                            <p class="font-semibold text-slate-800">{{ $latestExp->position ?? '-' }}</p>
                                            <p class="text-[11px] text-slate-500">{{ $latestExp->company_name ?? '-' }}</p>
                                        @else
                                            <span class="inline-flex px-2 py-0.5 rounded bg-slate-100 text-slate-600 text-[11px] font-medium">
                                                Fresh Graduate
                                            </span>
                                        @endif
                                    </td>

                                    <td class="py-3.5 px-3 text-center text-slate-600 font-mono text-[11px]">
                                        {{ $application->created_at?->translatedFormat('d M Y') ?? '-' }}<br>
                                        <span class="text-[10px] text-slate-400">{{ $application->created_at ? $application->created_at->format('H:i') . ' WIB' : '' }}</span>
                                    </td>

                                    <td class="py-3.5 px-3 text-center">
                                        <div class="relative inline-block">
                                            <select
                                                class="stage-select appearance-none py-1.5 pl-2.5 pr-8 text-xs rounded-lg border border-slate-200 bg-white text-slate-700 font-medium shadow-2xs focus:ring-2 focus:ring-[#991b1b]/20 focus:border-[#991b1b] focus:outline-none disabled:bg-slate-100 disabled:cursor-not-allowed"
                                                data-stage-url="{{ route('application.updateStage', $application) }}"
                                                data-status-url="{{ route('application.updateStatus', $application) }}"
                                                data-current="{{ $application->status === 'accepted' ? 'status:accepted' : ($application->status === 'rejected' ? 'status:rejected' : ($application->stages_id ? 'stage:' . $application->stages_id : '')) }}"
                                                data-applicant-name="{{ $applicant->name ?? '-' }}"
                                                data-applicant-email="{{ $applicant->email ?? '-' }}"
                                                data-office-type="{{ $job->office->type ?? '-' }}"
                                                @disabled(in_array($application->status, ['accepted', 'rejected', 'cancelled']))>
                                                <option value="">Pilih Stage</option>

                                                @foreach ($stages as $stage)
                                                    @if ($stage->step >= $currentStep)
                                                        <option value="stage:{{ $stage->id }}" data-stage-name="{{ $stage->name }}"
                                                            {{ !in_array($application->status, ['accepted', 'rejected', 'cancelled']) && $application->stages_id == $stage->id ? 'selected' : '' }}>
                                                            {{ $stage->step }}. {{ ucwords($stage->name) }}
                                                        </option>
                                                    @endif
                                                @endforeach

                                                <optgroup label="Keputusan Akhir">
                                                    <option value="status:accepted" {{ $application->status === 'accepted' ? 'selected' : '' }}>
                                                        Accepted (Diterima)
                                                    </option>
                                                    <option value="status:rejected" {{ $application->status === 'rejected' ? 'selected' : '' }}>
                                                        Rejected (Ditolak)
                                                    </option>
                                                </optgroup>
                                            </select>
                                            <svg class="w-3.5 h-3.5 text-slate-400 absolute right-2.5 top-2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M19 9l-7 7-7-7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                            </svg>
                                        </div>
                                    </td>

                                    <td class="py-3.5 px-3 text-center whitespace-nowrap">
                                        @if ($application->status === 'pending')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-bold bg-amber-50 text-amber-700 border border-amber-200/80 whitespace-nowrap shrink-0 min-w-max">
                                                Dalam Review
                                            </span>
                                        @elseif ($application->status === 'progress')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-bold bg-blue-50 text-blue-700 border border-blue-200/80 whitespace-nowrap shrink-0 min-w-max">
                                                Sedang Diproses
                                            </span>
                                        @elseif ($application->status === 'accepted')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200/80 whitespace-nowrap shrink-0 min-w-max">
                                                Diterima
                                            </span>
                                        @elseif ($application->status === 'rejected')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-bold bg-rose-50 text-rose-700 border border-rose-200/80 whitespace-nowrap shrink-0 min-w-max">
                                                Tidak Lolos
                                            </span>
                                        @elseif ($application->status === 'cancelled')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-semibold bg-slate-100 text-slate-600 border border-slate-200 whitespace-nowrap shrink-0 min-w-max">
                                                Dibatalkan
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-semibold bg-slate-100 text-slate-700 border border-slate-200 capitalize whitespace-nowrap shrink-0 min-w-max">
                                                {{ $application->status }}
                                            </span>
                                        @endif
                                    </td>

                                    <td class="py-3.5 px-4 text-center">
                                        @if ($applicant)
                                            <a href="{{ route('applicant.show', $applicant) }}"
                                                class="inline-flex items-center px-3 py-1.5 rounded-lg bg-white border border-slate-200 text-slate-700 hover:text-[#991b1b] hover:border-[#991b1b] font-semibold text-xs shadow-2xs transition">
                                                Lihat Profil
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach

                            <!-- Empty state when search or filter returns 0 results -->
                            <tr id="applicants-empty-row" x-show="visibleApplicantsCount === 0 && {{ $job->applications->count() }} > 0" style="display: none;">
                                <td colspan="8" class="py-12 px-6 text-center text-slate-400">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"></path>
                                        </svg>
                                        <p class="text-xs font-semibold text-slate-700">Tidak ada pelamar yang sesuai</p>
                                        <p class="text-[11px] text-slate-400">Tidak ditemukan kandidat dengan kata kunci atau filter tahapan/pendidikan tersebut.</p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination / Counter Controls -->
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-4 border-t border-slate-100 text-xs">
                    <p class="text-slate-500">
                        Menampilkan <strong class="text-slate-800" x-text="visibleApplicantsCount">{{ $totalApplicants }}</strong> dari <strong class="text-slate-800">{{ $totalApplicants }}</strong> pelamar terdaftar
                    </p>
                </div>
            @endif
        </section>

        <!-- BEGIN: Modal Edit Lowongan (Alpine.js) -->
        <template x-teleport="body">
            <div x-show="openEditModal"
                x-cloak
                style="display: none;"
                class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
                role="dialog"
                aria-modal="true"
                aria-labelledby="modal-edit-title"
                @keydown.escape.window="openEditModal = false">

                <div x-show="openEditModal"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    @click.outside="openEditModal = false"
                    class="bg-white w-full max-w-3xl rounded-2xl shadow-2xl border border-slate-200 flex flex-col max-h-[92vh] overflow-hidden">

                <!-- Modal Header -->
                <div class="px-8 py-5 border-b border-slate-100 flex items-center justify-between bg-white shrink-0">
                    <div class="flex items-center gap-3.5">
                        <div class="w-10 h-10 rounded-xl bg-red-50 border border-red-100/70 flex items-center justify-center text-[#A6192E] shadow-2xs">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 15.07a4.5 4.5 0 0 1-1.897 1.13l-2.685.805.805-2.685a4.5 4.5 0 0 1 1.13-1.897L16.862 4.487Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 7.125 16.875 4.5" />
                            </svg>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="text-lg font-bold text-slate-900 leading-tight" id="modal-edit-title">Edit Data Lowongan</h3>
                            </div>
                            <p class="text-xs text-slate-500 mt-0.5">Perbarui informasi dan rincian lowongan kerja ini.</p>
                        </div>
                    </div>
                    <button type="button" @click="openEditModal = false" aria-label="Tutup Modal" class="p-1.5 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-lg transition cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </button>
                </div>

                <!-- Form Container -->
                <form action="{{ route('job.update', $job->id) }}" method="POST" class="flex flex-col flex-1 min-h-0 overflow-hidden">
                    @csrf
                    @method('PUT')
                    <div class="flex-1 overflow-y-auto px-8 py-6 space-y-6">
                        <!-- Group 1: Informasi Dasar -->
                        <div class="space-y-4">
                            <div class="flex items-center gap-2 pb-1 border-b border-slate-100">
                                <span class="w-2 h-2 rounded-full bg-[#A6192E]"></span>
                                <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider">Informasi Dasar</h4>
                            </div>

                            <div class="space-y-1.5">
                                <label for="modal_edit_title" class="block text-[11px] font-semibold text-slate-700 uppercase tracking-wider">
                                    Judul Lowongan <span class="text-[#A6192E] font-bold">*</span>
                                </label>
                                <input type="text" name="title" id="modal_edit_title" value="{{ old('title', $job->title) }}"
                                    class="w-full px-4 py-2.5 text-xs rounded-xl border {{ $errors->has('title') ? 'border-red-500 ring-1 ring-red-500' : 'border-slate-200' }} bg-slate-50/50 hover:border-slate-300 focus:bg-white focus:border-[#A6192E] focus:ring-2 focus:ring-[#A6192E]/20 text-slate-800 placeholder-slate-400 transition"
                                    placeholder="Contoh: Senior Backend Developer" required>
                                @error('title')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="space-y-1.5">
                                    <label for="modal_edit_office_id" class="block text-[11px] font-semibold text-slate-700 uppercase tracking-wider">
                                        Kantor / Cabang <span class="text-[#A6192E] font-bold">*</span>
                                    </label>
                                    <div class="relative">
                                        <select name="office_id" id="modal_edit_office_id"
                                            class="w-full appearance-none px-4 pr-10 py-2.5 text-xs rounded-xl border {{ $errors->has('office_id') ? 'border-red-500 ring-1 ring-red-500' : 'border-slate-200' }} bg-slate-50/50 hover:border-slate-300 focus:bg-white focus:border-[#A6192E] focus:ring-2 focus:ring-[#A6192E]/20 text-slate-700 cursor-pointer transition"
                                            required>
                                            <option value="" disabled>-- Pilih Kantor / Cabang --</option>
                                            @if (isset($offices))
                                                @foreach ($offices as $office)
                                                    <option value="{{ $office->id }}" {{ old('office_id', $job->office_id) == $office->id ? 'selected' : '' }}>
                                                        {{ $office->name ?? $office->title }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    @error('office_id')
                                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="space-y-1.5">
                                    <label for="modal_edit_category" class="block text-[11px] font-semibold text-slate-700 uppercase tracking-wider">
                                        Kategori Lowongan <span class="text-[#A6192E] font-bold">*</span>
                                    </label>
                                    <div class="relative">
                                        <select name="category" id="modal_edit_category"
                                            class="w-full appearance-none px-4 pr-10 py-2.5 text-xs rounded-xl border {{ $errors->has('category') ? 'border-red-500 ring-1 ring-red-500' : 'border-slate-200' }} bg-slate-50/50 hover:border-slate-300 focus:bg-white focus:border-[#A6192E] focus:ring-2 focus:ring-[#A6192E]/20 text-slate-700 cursor-pointer transition"
                                            required>
                                            <option value="" disabled>-- Pilih Kategori --</option>
                                            <option value="profesional" {{ old('category', $job->category) == 'profesional' ? 'selected' : '' }}>Profesional</option>
                                            <option value="management_trainee" {{ old('category', $job->category) == 'management_trainee' ? 'selected' : '' }}>Management Trainee</option>
                                            <option value="internship" {{ old('category', $job->category) == 'internship' ? 'selected' : '' }}>Internship / PKL</option>
                                            <option value="magang" {{ old('category', $job->category) == 'magang' ? 'selected' : '' }}>Magang</option>
                                        </select>
                                    </div>
                                    @error('category')
                                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="space-y-1.5">
                                    <label for="modal_edit_occupation" class="block text-[11px] font-semibold text-slate-700 uppercase tracking-wider">
                                        Bidang Pekerjaan <span class="text-[#A6192E] font-bold">*</span>
                                    </label>
                                    <div class="relative">
                                        <select name="occupation" id="modal_edit_occupation"
                                            class="w-full appearance-none px-4 pr-10 py-2.5 text-xs rounded-xl border {{ $errors->has('occupation') ? 'border-red-500 ring-1 ring-red-500' : 'border-slate-200' }} bg-slate-50/50 hover:border-slate-300 focus:bg-white focus:border-[#A6192E] focus:ring-2 focus:ring-[#A6192E]/20 text-slate-700 cursor-pointer transition"
                                            required>
                                            <option value="" disabled>-- Pilih Bidang Pekerjaan --</option>
                                            @if (isset($divisions))
                                                @foreach ($divisions as $division)
                                                    <option value="{{ $division->name }}" {{ old('occupation', $job->occupation) == $division->name ? 'selected' : '' }}>
                                                        {{ $division->name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    @error('occupation')
                                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="space-y-1.5">
                                    <label for="modal_edit_type" class="block text-[11px] font-semibold text-slate-700 uppercase tracking-wider">
                                        Tipe Pekerjaan <span class="text-[#A6192E] font-bold">*</span>
                                    </label>
                                    <div class="relative">
                                        <select name="type" id="modal_edit_type"
                                            class="w-full appearance-none px-4 pr-10 py-2.5 text-xs rounded-xl border {{ $errors->has('type') ? 'border-red-500 ring-1 ring-red-500' : 'border-slate-200' }} bg-slate-50/50 hover:border-slate-300 focus:bg-white focus:border-[#A6192E] focus:ring-2 focus:ring-[#A6192E]/20 text-slate-700 cursor-pointer transition"
                                            required>
                                            <option value="" disabled>-- Pilih Tipe Pekerjaan --</option>
                                            <option value="Full-Time" {{ old('type', $job->type) == 'Full-Time' ? 'selected' : '' }}>Full-Time (Tetap)</option>
                                            <option value="Kontrak" {{ old('type', $job->type) == 'Kontrak' ? 'selected' : '' }}>Kontrak (PKWT)</option>
                                            <option value="Part-Time" {{ old('type', $job->type) == 'Part-Time' ? 'selected' : '' }}>Part Time</option>
                                            <option value="Freelance" {{ old('type', $job->type) == 'Freelance' ? 'selected' : '' }}>Freelance</option>
                                        </select>
                                    </div>
                                    @error('type')
                                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="space-y-1.5">
                                <label for="modal_edit_location" class="block text-[11px] font-semibold text-slate-700 uppercase tracking-wider">
                                    Lokasi Kerja <span class="text-[#A6192E] font-bold">*</span>
                                </label>
                                <input type="text" name="location" id="modal_edit_location" value="{{ old('location', $job->location) }}"
                                    class="w-full px-4 py-2.5 text-xs rounded-xl border {{ $errors->has('location') ? 'border-red-500 ring-1 ring-red-500' : 'border-slate-200' }} bg-slate-50/50 hover:border-slate-300 focus:bg-white focus:border-[#A6192E] focus:ring-2 focus:ring-[#A6192E]/20 text-slate-800 placeholder-slate-400 transition"
                                    placeholder="Contoh: Jakarta Selatan" required>
                                @error('location')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Group 2: Rincian Lowongan -->
                        <div class="space-y-4">
                            <div class="flex items-center gap-2 pb-1 border-b border-slate-100">
                                <span class="w-2 h-2 rounded-full bg-[#A6192E]"></span>
                                <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider">Rincian Posisi</h4>
                            </div>

                            <div class="space-y-1.5">
                                <label for="modal_edit_description" class="block text-[11px] font-semibold text-slate-700 uppercase tracking-wider">
                                    Deskripsi Pekerjaan <span class="text-[#A6192E] font-bold">*</span>
                                </label>
                                <x-forms.rich-textarea
                                    name="description"
                                    id="modal_edit_description"
                                    :value="old('description', $job->description)"
                                    placeholder="Tuliskan tanggung jawab dan rincian pekerjaan..."
                                    :hasError="$errors->has('description')"
                                    :required="true"
                                    :rows="4"
                                />
                                @error('description')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-1.5">
                                <label for="modal_edit_qualification" class="block text-[11px] font-semibold text-slate-700 uppercase tracking-wider">
                                    Kualifikasi Pelamar <span class="text-[#A6192E] font-bold">*</span>
                                </label>
                                <x-forms.rich-textarea
                                    name="qualification"
                                    id="modal_edit_qualification"
                                    :value="old('qualification', $job->qualification)"
                                    placeholder="Tuliskan pendidikan, pengalaman, keahlian, dan persyaratan lainnya..."
                                    :hasError="$errors->has('qualification')"
                                    :required="true"
                                    :rows="4"
                                />
                                @error('qualification')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Group 3: Periode Waktu -->
                        <div class="space-y-4">
                            <div class="flex items-center gap-2 pb-1 border-b border-slate-100">
                                <span class="w-2 h-2 rounded-full bg-[#A6192E]"></span>
                                <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider">Periode Waktu Publikasi</h4>
                            </div>

                            <div class="space-y-1.5">
                                <label for="modal_edit_closing_date" class="block text-[11px] font-semibold text-slate-700 uppercase tracking-wider">
                                    Tanggal Tutup <span class="text-[#A6192E] font-bold">*</span>
                                </label>
                                <input type="date" name="closing_date" id="modal_edit_closing_date" value="{{ old('closing_date', $job->closing_date ? \Carbon\Carbon::parse($job->closing_date)->format('Y-m-d') : '') }}"
                                    class="w-full px-4 py-2.5 text-xs rounded-xl border {{ $errors->has('closing_date') ? 'border-red-500 ring-1 ring-red-500' : 'border-slate-200' }} bg-slate-50/50 hover:border-slate-300 focus:bg-white focus:border-[#A6192E] focus:ring-2 focus:ring-[#A6192E]/20 text-slate-700 transition"
                                    required>
                                @error('closing_date')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="px-8 py-4 bg-slate-50/70 border-t border-slate-100 flex items-center justify-end gap-3 shrink-0">
                        <button type="button" @click="openEditModal = false" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-100 hover:text-slate-800 font-semibold text-xs transition duration-150 cursor-pointer">
                            Batal
                        </button>
                        <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-[#A6192E] hover:bg-[#7f1d1d] text-white font-bold text-xs shadow-sm shadow-red-950/20 hover:shadow-md transition duration-150 ease-in-out cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
        </template>
        <!-- END: Modal Edit Lowongan -->

        <!-- BEGIN: Modal Konfirmasi Tutup Lowongan (Alpine.js) -->
        <template x-teleport="body">
            <div x-show="closeModalOpen"
                x-cloak
                style="display: none;"
                class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
                role="dialog"
                aria-modal="true"
                aria-labelledby="close-job-modal-title"
                @keydown.escape.window="closeModalOpen = false">

                <div x-show="closeModalOpen"
                    x-transition:enter="ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="ease-in duration-150"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    @click.outside="closeModalOpen = false"
                    class="bg-white w-full max-w-md rounded-2xl shadow-2xl border border-slate-200 overflow-hidden">

                    <div class="p-6 text-center">
                        <div class="w-12 h-12 rounded-2xl bg-red-50 border border-red-100 flex items-center justify-center text-[#A6192E] mx-auto mb-4 shadow-2xs">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"></path>
                            </svg>
                        </div>

                        <h3 class="text-base font-bold text-slate-900" id="close-job-modal-title">
                            Tutup Lowongan Pekerjaan?
                        </h3>

                        <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                            Apakah Anda yakin ingin menutup lowongan <span class="font-bold text-slate-800">{{ $job->title }}</span>?
                            Lowongan yang sudah ditutup <span class="font-bold text-[#A6192E]">tidak dapat dibuka kembali</span> secara permanen.
                        </p>
                    </div>

                    <form action="{{ route('job.destroy', $job) }}" method="POST" class="px-6 py-4 bg-slate-50/70 border-t border-slate-100 flex items-center justify-end gap-2.5">
                        @csrf
                        @method('DELETE')
                        <button type="button" @click="closeModalOpen = false"
                            class="px-4 py-2 rounded-xl border border-slate-200 bg-white text-slate-600 hover:bg-slate-100 hover:text-slate-800 font-semibold text-xs transition cursor-pointer">
                            Batal
                        </button>
                        <button type="submit"
                            class="inline-flex items-center gap-1.5 px-5 py-2 rounded-xl bg-[#A6192E] hover:bg-[#7f1d1d] text-white font-bold text-xs shadow-sm transition cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"></path>
                            </svg>
                            Ya, Tutup Lowongan
                        </button>
                    </form>
                </div>
            </div>
        </template>
        <!-- END: Modal Konfirmasi Tutup Lowongan -->
    </div>

    <x-application.modal-email />

    <script>
        const stageModal = document.getElementById('stage-email-modal');
        const stageForm = document.getElementById('stage-email-form');
        const stageIdInput = document.getElementById('modal-stage-id');
        const statusInput = document.getElementById('modal-status');
        let activeStageSelect = null;

        const submitBtn = document.getElementById('modal-submit-btn');

        function resetSubmitButton() {
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<span>Lanjutkan</span>';
            }
        }

        function showFields(fieldId) {
            document.querySelectorAll('.stage-fields').forEach(field => {
                field.classList.add('hidden');
            });

            document.getElementById(fieldId).classList.remove('hidden');
        }

        function openStageModal(trigger, title) {
            stageForm.reset();
            resetSubmitButton();
            stageForm.action = trigger.dataset.updateUrl;

            document.getElementById('modal-title').textContent = title;
            document.getElementById('modal-applicant-name').textContent = trigger.dataset.applicantName;
            document.getElementById('modal-applicant-email').textContent = trigger.dataset.applicantEmail;

            stageModal.classList.remove('hidden');
            stageModal.classList.add('flex');
        }

        function closeStageModal() {
            if (activeStageSelect) {
                activeStageSelect.value = activeStageSelect.dataset.current;
                activeStageSelect = null;
            }

            resetSubmitButton();
            stageModal.classList.add('hidden');
            stageModal.classList.remove('flex');
        }

        stageForm?.addEventListener('submit', function(e) {
            if (submitBtn) {
                if (submitBtn.disabled) {
                    e.preventDefault();
                    return;
                }
                submitBtn.disabled = true;
                submitBtn.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                    </svg>
                    <span>Memproses...</span>
                `;
            }
        });

        document.querySelectorAll('.stage-select').forEach(select => {
            select.addEventListener('change', function() {
                if (!this.value) {
                    this.value = this.dataset.current;
                    return;
                }

                activeStageSelect = this;

                if (this.value === 'status:accepted') {
                    openStageModal(this, 'Terima Applicant');
                    stageForm.action = this.dataset.statusUrl;

                    stageIdInput.disabled = true;
                    statusInput.disabled = false;
                    statusInput.value = 'accepted';
                    document.getElementById('modal-stage-wrapper').classList.add('hidden');
                    document.getElementById('modal-office-type').textContent = this.dataset.officeType;

                    showFields('fields-accept');
                    return;
                }

                if (this.value === 'status:rejected') {
                    openStageModal(this, 'Tolak Applicant');
                    stageForm.action = this.dataset.statusUrl;

                    stageIdInput.disabled = true;
                    statusInput.disabled = false;
                    statusInput.value = 'rejected';
                    document.getElementById('modal-stage-wrapper').classList.add('hidden');

                    showFields('fields-reject');
                    return;
                }

                // Pilihan stage (format value: stage:123)
                const rawStageId = this.value.replace('stage:', '');
                const stageName = this.options[this.selectedIndex].dataset.stageName;

                openStageModal(this, 'Data Tahapan Applicant');
                stageForm.action = this.dataset.stageUrl;

                stageIdInput.disabled = false;
                stageIdInput.value = rawStageId;
                statusInput.disabled = true;
                document.getElementById('modal-stage-wrapper').classList.remove('hidden');
                document.getElementById('modal-stage-name').value = stageName;

                switch (stageName.startsWith('interview') ? 'interview' : stageName) {
                    case 'psikotes':
                        showFields('fields-psikotes');
                        break;

                    case 'interview':
                        showFields('fields-interview');
                        break;

                    case 'mcu':
                        showFields('fields-mcu');
                        break;

                    case 'study case':
                        showFields('fields-study-case');
                        break;

                    case 'panel bod':
                        showFields('fields-panel-bod');
                        break;

                    case 'offering':
                        showFields('fields-offering');
                        break;

                    default:
                        showFields('fields-none');
                        break;
                }

                toggleMethodFields('interview_type', 'interview-virtual-field', 'interview-offline-field');
                toggleMethodFields('panel_bod_type', 'panel-bod-virtual-field', 'panel-bod-offline-field');
            });
        });

        stageModal.querySelectorAll('[data-modal-hide]').forEach(button => {
            button.addEventListener('click', closeStageModal);
        });

        function toggleMethodFields(selectId, virtualFieldId, offlineFieldId) {
            const isVirtual = document.getElementById(selectId).value === 'virtual';

            document.getElementById(virtualFieldId).classList.toggle('hidden', !isVirtual);
            document.getElementById(offlineFieldId).classList.toggle('hidden', isVirtual);
        }

        document.getElementById('interview_type').addEventListener('change', () => {
            toggleMethodFields('interview_type', 'interview-virtual-field', 'interview-offline-field');
        });

        document.getElementById('panel_bod_type').addEventListener('change', () => {
            toggleMethodFields('panel_bod_type', 'panel-bod-virtual-field', 'panel-bod-offline-field');
        });
    </script>
@endsection
