@extends('auth.admin.layouts.index')

@section('title', 'Manajemen Lowongan - Sinar Sosro Gunung Slamat (Rekso)')

@section('content')
    <div class="space-y-6 font-sans" x-data="{
        openCreateModal: {{ $errors->any() ? 'true' : 'false' }},
        search: '',
        selectedOffice: '',
        sortBy: 'latest',
        visibleJobsCount: {{ $jobs->count() }},
        applyFilters() {
            this.$nextTick(() => {
                const rows = document.querySelectorAll('#job-vacancies-table tbody tr.job-row');
                let count = 0;
                const q = (this.search || '').trim().toLowerCase();
                const office = this.selectedOffice;

                rows.forEach(r => {
                    const haystack = (r.dataset.haystack || '').toLowerCase();
                    const rOffice = r.dataset.office || '';

                    const matchSearch = !q || haystack.includes(q);
                    const matchOffice = !office || rOffice === office;

                    if (matchSearch && matchOffice) {
                        r.style.display = '';
                        count++;
                    } else {
                        r.style.display = 'none';
                    }
                });

                this.visibleJobsCount = count;
                this.reNumberVisibleRows();
            });
        },
        applySort() {
            let tbody = document.querySelector('#job-vacancies-table tbody');
            if (!tbody) return;
            let rows = Array.from(tbody.querySelectorAll('tr.job-row'));
            rows.sort((a, b) => {
                if (this.sortBy === 'latest') return Number(b.dataset.created || 0) - Number(a.dataset.created || 0);
                if (this.sortBy === 'closing_soon') return Number(a.dataset.closing || 0) - Number(b.dataset.closing || 0);
                if (this.sortBy === 'most_applicants') return Number(b.dataset.applicants || 0) - Number(a.dataset.applicants || 0);
                return 0;
            });
            const emptyRow = document.querySelector('#job-vacancies-empty-row');
            rows.forEach(r => tbody.appendChild(r));
            if (emptyRow) tbody.appendChild(emptyRow);
            this.reNumberVisibleRows();
        },
        reNumberVisibleRows() {
            let visibleIdx = 1;
            document.querySelectorAll('#job-vacancies-table tbody tr.job-row').forEach(r => {
                if (r.style.display !== 'none') {
                    const cell = r.querySelector('.row-number');
                    if (cell) cell.textContent = visibleIdx++;
                }
            });
        }
    }"
    x-init="
        $watch('search', () => applyFilters());
        $watch('selectedOffice', () => applyFilters());
        $watch('sortBy', () => applySort());
    ">
        <!-- Header Section: Title & Action Button -->
        <section class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 pb-3.5 border-b border-slate-200" data-purpose="page-title-and-actions">
            <div class="space-y-0.5">
                <nav class="flex items-center gap-1.5 text-xs text-slate-400 font-medium">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-[#9b1b1f] transition">Portal Karir</a>
                    <span class="material-symbols-outlined text-xs">chevron_right</span>
                    <span class="text-[#9b1b1f] font-bold">Manajemen Lowongan</span>
                </nav>
                <h1 class="text-xl font-bold tracking-tight text-slate-900">Manajemen Lowongan</h1>
                <p class="text-xs text-slate-500">Kelola permohonan, pantau jadwal posting, dan verifikasi kebutuhan posisi kerja.</p>
            </div>
            <div class="flex items-center gap-3">
                <!-- Tambah Lowongan Primary CTA -->
                <button type="button" @click="openCreateModal = true" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-full bg-[#A6192E] hover:bg-[#7f1d1d] text-white text-xs font-bold shadow-sm shadow-red-950/20 hover:shadow-md transition duration-150 ease-in-out cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                    <span>Tambah Lowongan</span>
                </button>
            </div>
        </section>

        <!-- Main Card Container -->
        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm overflow-hidden" data-purpose="content-card">
            <!-- Status Filter Tabs -->
            <div class="px-6 pt-5 pb-3 border-b border-slate-100 flex flex-wrap items-center gap-2" data-purpose="status-tab-group">
                <!-- Tab 1: Semua Lowongan (Default Active) -->
                <a href="{{ route('job.index') }}"
                    class="px-4 py-2 text-xs font-bold rounded-full bg-red-50 text-[#A6192E] border border-red-200/70 shadow-sm transition cursor-pointer">
                    Semua Lowongan
                </a>
                <!-- Tab 2: Lowongan Dibuka -->
                <button class="px-4 py-2 text-xs font-medium rounded-full text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition cursor-default" type="button">
                    Lowongan Dibuka
                </button>
                <!-- Tab 3: Lowongan Ditunda -->
                <button class="px-4 py-2 text-xs font-medium rounded-full text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition cursor-default" type="button">
                    Lowongan Ditunda
                </button>
                <!-- Tab 4: Lowongan Ditutup -->
                <button class="px-4 py-2 text-xs font-medium rounded-full text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition cursor-default" type="button">
                    Lowongan Ditutup
                </button>
            </div>

            <!-- Search Bar and Sorting Toolbar -->
            <div class="p-6 pb-4 flex flex-col md:flex-row md:items-center justify-between gap-4" data-purpose="table-controls">
                <div class="relative w-full md:max-w-md">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </span>
                    <input
                        x-model="search"
                        @input="applyFilters()"
                        class="w-full pl-10 pr-9 py-2 text-xs rounded-full border border-slate-300 focus:border-[#b91c1c] focus:ring-2 focus:ring-[#b91c1c]/20 text-slate-800 placeholder-slate-400 transition"
                        placeholder="Cari Lowongan berdasarkan posisi, divisi, lokasi..."
                        type="text"
                    />
                    <button
                        x-show="search"
                        @click="search = ''; applyFilters()"
                        type="button"
                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-600 cursor-pointer"
                        title="Hapus pencarian"
                    >
                        <span class="material-symbols-outlined text-[16px]">close</span>
                    </button>
                </div>
                <div class="flex flex-wrap items-center gap-3 self-end md:self-auto text-xs text-slate-500">
                    <!-- Dropdown Semua Wilayah dari Database (Office) -->
                    <div class="relative">
                        <select
                            x-model="selectedOffice"
                            @change="applyFilters()"
                            aria-label="Filter Wilayah"
                            class="bg-white border border-slate-300 text-slate-700 text-xs font-semibold rounded-full px-3.5 py-2 shadow-2xs hover:border-slate-400 focus:outline-none focus:ring-2 focus:ring-[#b91c1c]/20 focus:border-[#b91c1c] transition cursor-pointer">
                            <option value="">Semua Wilayah</option>
                            @foreach ($offices as $office)
                                <option value="{{ $office->id }}">{{ $office->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Dropdown Urutkan -->
                    <div class="flex items-center gap-1.5">
                        <span class="font-medium">Urutkan:</span>
                        <select
                            x-model="sortBy"
                            @change="applySort()"
                            aria-label="Urutan Tampilan"
                            class="border border-slate-200 rounded-lg px-2.5 py-1.5 text-xs text-slate-700 font-medium focus:ring-1 focus:ring-[#b91c1c] cursor-pointer">
                            <option value="latest">Paling Baru</option>
                            <option value="closing_soon">Batas Waktu Terdekat</option>
                            <option value="most_applicants">Kandidat Terbanyak</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- BEGIN: RecruitmentDataTable (Static Stitch Data) -->
            <div class="overflow-x-auto" data-purpose="data-table-container">
                <table class="w-full text-left border-collapse" id="job-vacancies-table">
                    <thead>
                        <tr class="bg-rose-50/40 border-y border-rose-100/60 text-[11px] font-bold uppercase tracking-wider text-[#7f1d1d]">
                            <th class="py-3 px-5 text-center w-12" scope="col">No.</th>
                            <th class="py-3 px-6 text-center" scope="col">Informasi Lowongan</th>
                            <th class="py-3 px-4 text-center" scope="col">Kandidat</th>
                            <th class="py-3 px-5 text-center" scope="col">Terbuat</th>
                            <th class="py-3 px-5 text-center" scope="col">
                                <div class="inline-flex items-center justify-center gap-1 cursor-pointer group">
                                    <span>Batas Waktu</span>
                                </div>
                            </th>
                            <th class="py-3 px-5 text-center" scope="col">
                                <div class="inline-flex items-center justify-center gap-1 cursor-pointer">
                                    <span>Status</span>
                                </div>
                            </th>
                            <th class="py-3 px-6 text-center" scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs">
                        @forelse ($jobs as $index => $job)
                            @php
                                $jobOfficeId = (string) ($job->office_id ?? '');
                                $searchHaystack = strtolower(
                                    $job->title . ' ' .
                                    ($job->occupation ?? '') . ' ' .
                                    ($job->category ?? '') . ' ' .
                                    ($job->office?->name ?? '') . ' ' .
                                    ($job->location ?? '')
                                );
                                $closingTimestamp = $job->closing_date ? \Carbon\Carbon::parse($job->closing_date)->timestamp : 9999999999;
                                $createdTimestamp = $job->created_at ? $job->created_at->timestamp : 0;
                                $applicantsTotal = (int) ($job->applications_count ?? $job->applications->count());
                            @endphp
                            <tr
                                data-haystack="{{ $searchHaystack }}"
                                data-office="{{ $jobOfficeId }}"
                                data-created="{{ $createdTimestamp }}"
                                data-closing="{{ $closingTimestamp }}"
                                data-applicants="{{ $applicantsTotal }}"
                                class="job-row hover:bg-slate-50/70 transition-colors"
                            >
                                <td class="py-4 px-5 text-center text-slate-400 font-semibold row-number">{{ $index + 1 }}</td>
                                <td class="py-4 px-6">
                                    <a href="{{ route('job.show', $job) }}" class="font-bold text-slate-800 hover:text-[#A6192E] transition-colors text-[13px] block">
                                        {{ $job->title }}
                                    </a>
                                    <div class="text-[11px] text-slate-400 mt-0.5">
                                        {{ $job->occupation ?? ucwords(str_replace('_', ' ', $job->category ?? '-')) }} • {{ $job->office->name ?? $job->location ?? '-' }} ({{ $job->type ?? '-' }})
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-slate-100 text-slate-700 font-bold text-xs">
                                        {{ $job->applications_count ?? $job->applications->count() }}
                                    </span>
                                </td>
                                <td class="py-4 px-5 text-center text-slate-600 font-medium">
                                    {{ $job->opening_date ? \Carbon\Carbon::parse($job->opening_date)->translatedFormat('d M Y') : ($job->created_at ? $job->created_at->translatedFormat('d M Y') : '-') }}
                                </td>
                                <td class="py-4 px-5 text-center text-slate-600 font-medium">
                                    {{ $job->closing_date ? \Carbon\Carbon::parse($job->closing_date)->translatedFormat('d M Y') : '-' }}
                                </td>
                                <td class="py-4 px-5 text-center">
                                    @if ($job->status === 'aktif')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-600 border border-slate-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                            Ditutup
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <div class="inline-flex items-center justify-center">
                                        <a href="{{ route('job.show', $job) }}" class="p-1.5 text-slate-500 hover:text-[#A6192E] hover:bg-rose-50 rounded-md transition" title="Lihat Detail">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round"></path>
                                                <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-linecap="round" stroke-linejoin="round"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 px-6 text-center text-slate-400">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0"></path>
                                        </svg>
                                        <p class="text-xs font-medium">Belum ada data lowongan yang terdaftar.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse

                        <!-- Empty state when search or filter returns 0 results -->
                        <tr id="job-vacancies-empty-row" x-show="visibleJobsCount === 0 && {{ $jobs->count() }} > 0" style="display: none;">
                            <td colspan="7" class="py-12 px-6 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"></path>
                                    </svg>
                                    <p class="text-xs font-semibold text-slate-700">Tidak ada lowongan yang sesuai</p>
                                    <p class="text-[11px] text-slate-400">Tidak ditemukan lowongan dengan kata kunci atau filter wilayah tersebut.</p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- END: RecruitmentDataTable -->

            <!-- BEGIN: TableFooter (Tanpa Tombol Pagination) -->
            <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-200/80 flex items-center justify-between text-xs text-slate-500" data-purpose="table-footer">
                <p>Menampilkan <span class="font-semibold text-slate-700" x-text="visibleJobsCount">{{ $jobs->count() }}</span> dari <span class="font-semibold text-slate-700">{{ $jobs->count() }}</span> total lowongan</p>
            </div>
            <!-- END: TableFooter -->
        </div>
        <!-- END: Main Card Container -->

        <!-- BEGIN: Modal Tambah Lowongan (Alpine.js) -->
        <template x-teleport="body">
            <div x-show="openCreateModal"
                x-cloak
                style="display: none;"
                class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
                role="dialog"
                aria-modal="true"
                aria-labelledby="modal-title"
                @keydown.escape.window="openCreateModal = false">
                
                <div x-show="openCreateModal"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    @click.outside="openCreateModal = false"
                    class="bg-white w-full max-w-3xl rounded-2xl shadow-2xl border border-slate-200 flex flex-col max-h-[92vh] overflow-hidden">
                
                <!-- Modal Header -->
                <div class="px-8 py-5 border-b border-slate-100 flex items-center justify-between bg-white shrink-0">
                    <div class="flex items-center gap-3.5">
                        <div class="w-10 h-10 rounded-xl bg-red-50 border border-red-100/70 flex items-center justify-center text-[#A6192E] shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="text-lg font-bold text-slate-900 leading-tight" id="modal-title">Tambah Lowongan Baru</h3>
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-red-50 text-[#A6192E] border border-red-100/70">HR Portal</span>
                            </div>
                            <p class="text-xs text-slate-500 mt-0.5">Isi formulir berikut untuk mempublikasikan lowongan kerja baru.</p>
                        </div>
                    </div>
                    <button type="button" @click="openCreateModal = false" aria-label="Tutup Modal" class="p-1.5 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-lg transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </button>
                </div>

                <!-- Form Container -->
                <form action="{{ route('job.store') }}" method="POST" class="flex flex-col flex-1 min-h-0 overflow-hidden">
                    @csrf
                    <div class="flex-1 overflow-y-auto px-8 py-6 space-y-6">
                        <!-- Group 1: Informasi Dasar -->
                        <div class="space-y-4">
                            <div class="flex items-center gap-2 pb-1 border-b border-slate-100">
                                <span class="w-2 h-2 rounded-full bg-[#A6192E]"></span>
                                <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider">Informasi Dasar</h4>
                            </div>

                            <div class="space-y-1.5">
                                <label for="modal_title" class="block text-[11px] font-semibold text-slate-700 uppercase tracking-wider">
                                    Judul Lowongan <span class="text-[#A6192E] font-bold">*</span>
                                </label>
                                <input type="text" name="title" id="modal_title" value="{{ old('title') }}"
                                    class="w-full px-4 py-2.5 text-xs rounded-xl border {{ $errors->has('title') ? 'border-red-500 ring-1 ring-red-500' : 'border-slate-200' }} bg-slate-50/50 hover:border-slate-300 focus:bg-white focus:border-[#A6192E] focus:ring-2 focus:ring-[#A6192E]/20 text-slate-800 placeholder-slate-400 transition"
                                    placeholder="Contoh: Senior Backend Developer" required>
                                @error('title')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="space-y-1.5">
                                    <label for="modal_office_id" class="block text-[11px] font-semibold text-slate-700 uppercase tracking-wider">
                                        Kantor / Cabang <span class="text-[#A6192E] font-bold">*</span>
                                    </label>
                                    <div class="relative">
                                        <select name="office_id" id="modal_office_id"
                                            class="w-full appearance-none px-4 pr-10 py-2.5 text-xs rounded-xl border {{ $errors->has('office_id') ? 'border-red-500 ring-1 ring-red-500' : 'border-slate-200' }} bg-slate-50/50 hover:border-slate-300 focus:bg-white focus:border-[#A6192E] focus:ring-2 focus:ring-[#A6192E]/20 text-slate-700 cursor-pointer transition"
                                            required>
                                            <option value="" disabled {{ old('office_id') ? '' : 'selected' }}>-- Pilih Kantor / Cabang --</option>
                                            @if (isset($offices))
                                                @foreach ($offices as $office)
                                                    <option value="{{ $office->id }}" {{ old('office_id') == $office->id ? 'selected' : '' }}>
                                                        {{ $office->name }}
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
                                    <label for="modal_category" class="block text-[11px] font-semibold text-slate-700 uppercase tracking-wider">
                                        Kategori Lowongan <span class="text-[#A6192E] font-bold">*</span>
                                    </label>
                                    <div class="relative">
                                        <select name="category" id="modal_category"
                                            class="w-full appearance-none px-4 pr-10 py-2.5 text-xs rounded-xl border {{ $errors->has('category') ? 'border-red-500 ring-1 ring-red-500' : 'border-slate-200' }} bg-slate-50/50 hover:border-slate-300 focus:bg-white focus:border-[#A6192E] focus:ring-2 focus:ring-[#A6192E]/20 text-slate-700 cursor-pointer transition"
                                            required>
                                            <option value="" disabled {{ old('category') ? '' : 'selected' }}>-- Pilih Kategori --</option>
                                            <option value="profesional" {{ old('category') == 'profesional' ? 'selected' : '' }}>Profesional</option>
                                            <option value="management_trainee" {{ old('category') == 'management_trainee' ? 'selected' : '' }}>Management Trainee</option>
                                            <option value="internship" {{ old('category') == 'internship' ? 'selected' : '' }}>Internship / PKL</option>
                                            <option value="magang" {{ old('category') == 'magang' ? 'selected' : '' }}>Magang</option>
                                        </select>
                                    </div>
                                    @error('category')
                                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="space-y-1.5">
                                    <label for="modal_occupation" class="block text-[11px] font-semibold text-slate-700 uppercase tracking-wider">
                                        Bidang Pekerjaan <span class="text-[#A6192E] font-bold">*</span>
                                    </label>
                                    <div class="relative">
                                        <select name="occupation" id="modal_occupation"
                                            class="w-full appearance-none px-4 pr-10 py-2.5 text-xs rounded-xl border {{ $errors->has('occupation') ? 'border-red-500 ring-1 ring-red-500' : 'border-slate-200' }} bg-slate-50/50 hover:border-slate-300 focus:bg-white focus:border-[#A6192E] focus:ring-2 focus:ring-[#A6192E]/20 text-slate-700 cursor-pointer transition"
                                            required>
                                            <option value="" disabled {{ old('occupation') ? '' : 'selected' }}>-- Pilih Bidang Pekerjaan --</option>
                                            @if (isset($divisions))
                                                @foreach ($divisions as $division)
                                                    <option value="{{ $division->name }}" {{ old('occupation') == $division->name ? 'selected' : '' }}>
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
                                    <label for="modal_type" class="block text-[11px] font-semibold text-slate-700 uppercase tracking-wider">
                                        Tipe Pekerjaan <span class="text-[#A6192E] font-bold">*</span>
                                    </label>
                                    <div class="relative">
                                        <select name="type" id="modal_type"
                                            class="w-full appearance-none px-4 pr-10 py-2.5 text-xs rounded-xl border {{ $errors->has('type') ? 'border-red-500 ring-1 ring-red-500' : 'border-slate-200' }} bg-slate-50/50 hover:border-slate-300 focus:bg-white focus:border-[#A6192E] focus:ring-2 focus:ring-[#A6192E]/20 text-slate-700 cursor-pointer transition"
                                            required>
                                            <option value="" disabled {{ old('type') ? '' : 'selected' }}>-- Pilih Tipe Pekerjaan --</option>
                                            <option value="Full-Time" {{ old('type') == 'Full-Time' ? 'selected' : '' }}>Full-Time (Tetap)</option>
                                            <option value="Kontrak" {{ old('type') == 'Kontrak' ? 'selected' : '' }}>Kontrak (PKWT)</option>
                                            <option value="Part-Time" {{ old('type') == 'Part-Time' ? 'selected' : '' }}>Part Time</option>
                                            <option value="Freelance" {{ old('type') == 'Freelance' ? 'selected' : '' }}>Freelance</option>
                                        </select>
                                    </div>
                                    @error('type')
                                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="space-y-1.5">
                                <label for="modal_location" class="block text-[11px] font-semibold text-slate-700 uppercase tracking-wider">
                                    Lokasi Kerja <span class="text-[#A6192E] font-bold">*</span>
                                </label>
                                <input type="text" name="location" id="modal_location" value="{{ old('location') }}"
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
                                <label for="modal_description" class="block text-[11px] font-semibold text-slate-700 uppercase tracking-wider">
                                    Deskripsi Pekerjaan <span class="text-[#A6192E] font-bold">*</span>
                                </label>
                                <x-forms.rich-textarea
                                    name="description"
                                    id="modal_description"
                                    :value="old('description')"
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
                                <label for="modal_qualification" class="block text-[11px] font-semibold text-slate-700 uppercase tracking-wider">
                                    Kualifikasi Pelamar <span class="text-[#A6192E] font-bold">*</span>
                                </label>
                                <x-forms.rich-textarea
                                    name="qualification"
                                    id="modal_qualification"
                                    :value="old('qualification')"
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
                                <label for="modal_closing_date" class="block text-[11px] font-semibold text-slate-700 uppercase tracking-wider">
                                    Tanggal Tutup <span class="text-[#A6192E] font-bold">*</span>
                                </label>
                                <input type="date" name="closing_date" id="modal_closing_date" value="{{ old('closing_date') }}"
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
                        <button type="button" @click="openCreateModal = false" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-100 hover:text-slate-800 font-semibold text-xs transition duration-150 cursor-pointer">
                            Batal
                        </button>
                        <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-[#A6192E] hover:bg-[#7f1d1d] text-white font-bold text-xs shadow-sm shadow-red-950/20 hover:shadow-md transition duration-150 ease-in-out cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                            Simpan Lowongan
                        </button>
                    </div>
                </form>
            </div>
        </div>
        </template>
        <!-- END: Modal Tambah Lowongan -->
    </div>
@endsection
