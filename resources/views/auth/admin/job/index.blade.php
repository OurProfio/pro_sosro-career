@extends('auth.admin.layouts.index')

@section('title', 'Manajemen Lowongan - Sinar Sosro Gunung Slamat (Rekso)')

@section('content')
    <div class="space-y-6 font-sans" x-data="{ openCreateModal: {{ $errors->any() ? 'true' : 'false' }} }">
        <!-- Header Section: Title, Location Filter, & Action Button -->
        <section class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 pb-2" data-purpose="page-title-and-actions">
            <div>
                <h2 class="text-2xl font-bold tracking-tight text-[#7f1d1d]">Manajemen Lowongan</h2>
                <p class="text-sm text-slate-500 mt-1">Kelola permohonan, pantau jadwal posting, dan verifikasi kebutuhan posisi kerja.</p>
            </div>
            <div class="flex items-center gap-3">
                <!-- Region Filter Dropdown -->
                <div class="relative">
                    <select aria-label="Filter Wilayah" class="appearance-none bg-white border border-slate-300 text-slate-700 text-xs font-semibold rounded-full pl-4 pr-9 py-2.5 shadow-sm hover:border-slate-400 focus:outline-none focus:ring-2 focus:ring-[#b91c1c]/20 focus:border-[#b91c1c] transition cursor-pointer">
                        <option value="all">Semua Wilayah</option>
                        <option value="cibitung">Pabrik Cibitung</option>
                        <option value="cakung">Pabrik Cakung</option>
                        <option value="kpb">KPB (Pusat)</option>
                        <option value="semarang">Cabang Semarang</option>
                        <option value="bali">Distribusi Bali</option>
                    </select>
                    <svg class="w-4 h-4 text-slate-400 absolute right-3 top-3 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M19 9l-7 7-7-7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                    </svg>
                </div>
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
            <!-- Status Filter Tabs with Approval Tab -->
            <div class="px-6 pt-5 pb-3 border-b border-slate-100 flex flex-wrap items-center gap-2" data-purpose="status-tab-group">
                <!-- Tab 1: Semua Lowongan -->
                <button class="px-4 py-2 text-xs font-medium rounded-full text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition" type="button">
                    Semua Lowongan
                </button>
                <!-- Tab 2: Persetujuan Upload Lowongan -->
                <button class="relative inline-flex items-center gap-2 px-4 py-2 text-xs font-bold rounded-full bg-red-50 text-[#A6192E] border border-red-200/70 shadow-sm transition" type="button">
                    <span>Persetujuan Upload Lowongan</span>
                    <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-[10px] font-extrabold bg-[#A6192E] text-white">
                        5
                    </span>
                </button>
                <!-- Tab 3: Lowongan Dibuka -->
                <button class="px-4 py-2 text-xs font-medium rounded-full text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition" type="button">
                    Lowongan Dibuka
                </button>
                <!-- Tab 4: Lowongan Ditunda -->
                <button class="px-4 py-2 text-xs font-medium rounded-full text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition" type="button">
                    Lowongan Ditunda
                </button>
                <!-- Tab 5: Lowongan Ditutup -->
                <button class="px-4 py-2 text-xs font-medium rounded-full text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition" type="button">
                    Lowongan Ditutup
                </button>
            </div>

            <!-- Search Bar and Sorting Toolbar -->
            <div class="p-6 pb-4 flex flex-col sm:flex-row items-center justify-between gap-4" data-purpose="table-controls">
                <div class="relative w-full sm:max-w-md">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </span>
                    <input class="w-full pl-10 pr-4 py-2 text-xs rounded-full border border-slate-300 focus:border-[#b91c1c] focus:ring-2 focus:ring-[#b91c1c]/20 text-slate-800 placeholder-slate-400 transition" placeholder="Cari Lowongan berdasarkan posisi, divisi..." type="text" />
                </div>
                <div class="flex items-center gap-2 self-end sm:self-auto text-xs text-slate-500">
                    <span>Urutkan:</span>
                    <select aria-label="Urutan Tampilan" class="border border-slate-200 rounded-lg px-2.5 py-1.5 text-xs text-slate-700 font-medium focus:ring-1 focus:ring-[#b91c1c]">
                        <option>Paling Baru</option>
                        <option>Batas Waktu Terdekat</option>
                        <option>Kandidat Terbanyak</option>
                    </select>
                </div>
            </div>

            <!-- BEGIN: RecruitmentDataTable (Static Stitch Data) -->
            <div class="overflow-x-auto" data-purpose="data-table-container">
                <table class="w-full text-left border-collapse" id="job-vacancies-table">
                    <thead>
                        <tr class="bg-rose-50/40 border-y border-rose-100/60 text-[11px] font-bold uppercase tracking-wider text-[#7f1d1d]">
                            <th class="py-3 px-5 text-center w-12" scope="col">No.</th>
                            <th class="py-3 px-6" scope="col">Informasi Lowongan</th>
                            <th class="py-3 px-4 text-center" scope="col">Kandidat</th>
                            <th class="py-3 px-5" scope="col">Terbuat</th>
                            <th class="py-3 px-5" scope="col">
                                <div class="flex items-center gap-1 cursor-pointer group">
                                    <span>Batas Waktu</span>
                                    <svg class="w-3.5 h-3.5 text-[#b91c1c]" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path d="M19 9l-7 7-7-7" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </div>
                            </th>
                            <th class="py-3 px-5 text-center" scope="col">
                                <div class="inline-flex items-center gap-1 cursor-pointer">
                                    <span>Status</span>
                                    <svg class="w-3.5 h-3.5 text-[#b91c1c]" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path d="M19 9l-7 7-7-7" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </div>
                            </th>
                            <th class="py-3 px-6 text-right" scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs">
                        <!-- Row 1: Production Operator -->
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="py-4 px-5 text-center text-slate-400 font-semibold">1</td>
                            <td class="py-4 px-6">
                                <div class="font-bold text-slate-800 text-[13px]">Production Operator</div>
                                <div class="text-[11px] text-slate-400 mt-0.5">Departemen Produksi • Plant Cibitung (Full Time)</div>
                            </td>
                            <td class="py-4 px-4 text-center">
                                <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-slate-100 text-slate-700 font-bold text-xs">
                                    1
                                </span>
                            </td>
                            <td class="py-4 px-5 text-slate-600 font-medium">14 Sept 2026</td>
                            <td class="py-4 px-5 text-slate-600 font-medium">28 Sept 2026</td>
                            <td class="py-4 px-5 text-center">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                    Pending Review
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="inline-flex items-center justify-end gap-1.5">
                                    <button class="p-1.5 text-emerald-600 hover:bg-emerald-50 rounded-md transition" title="Setujui Lowongan" type="button">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </button>
                                    <button class="p-1.5 text-slate-500 hover:text-red-800 hover:bg-rose-50 rounded-md transition" title="Lihat Detail" type="button">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </button>
                                    <button class="p-1.5 text-slate-400 hover:text-slate-600 rounded-md transition" title="Pilihan Lain" type="button">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Row 2: PRODUCTION OPERATOR KPB -->
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="py-4 px-5 text-center text-slate-400 font-semibold">2</td>
                            <td class="py-4 px-6">
                                <div class="font-bold text-slate-800 text-[13px]">PRODUCTION OPERATOR KPB</div>
                                <div class="text-[11px] text-slate-400 mt-0.5">Departemen Produksi • Unit KPB (Kontrak)</div>
                            </td>
                            <td class="py-4 px-4 text-center">
                                <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-slate-100 text-slate-700 font-bold text-xs">
                                    1
                                </span>
                            </td>
                            <td class="py-4 px-5 text-slate-600 font-medium">14 Sept 2026</td>
                            <td class="py-4 px-5 text-slate-600 font-medium">28 Sept 2026</td>
                            <td class="py-4 px-5 text-center">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                    Pending Review
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="inline-flex items-center justify-end gap-1.5">
                                    <button class="p-1.5 text-emerald-600 hover:bg-emerald-50 rounded-md transition" title="Setujui Lowongan" type="button">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </button>
                                    <button class="p-1.5 text-slate-500 hover:text-red-800 hover:bg-rose-50 rounded-md transition" title="Lihat Detail" type="button">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </button>
                                    <button class="p-1.5 text-slate-400 hover:text-slate-600 rounded-md transition" title="Pilihan Lain" type="button">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Row 3: Mechanic Operator -->
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="py-4 px-5 text-center text-slate-400 font-semibold">3</td>
                            <td class="py-4 px-6">
                                <div class="font-bold text-slate-800 text-[13px]">Mechanic Operator</div>
                                <div class="text-[11px] text-slate-400 mt-0.5">Departemen Maintenance &amp; Mesin • Cakung</div>
                            </td>
                            <td class="py-4 px-4 text-center">
                                <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-slate-100 text-slate-700 font-bold text-xs">
                                    1
                                </span>
                            </td>
                            <td class="py-4 px-5 text-slate-600 font-medium">14 Sept 2026</td>
                            <td class="py-4 px-5 text-slate-600 font-medium">28 Sept 2026</td>
                            <td class="py-4 px-5 text-center">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                    Pending Review
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="inline-flex items-center justify-end gap-1.5">
                                    <button class="p-1.5 text-emerald-600 hover:bg-emerald-50 rounded-md transition" title="Setujui Lowongan" type="button">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </button>
                                    <button class="p-1.5 text-slate-500 hover:text-red-800 hover:bg-rose-50 rounded-md transition" title="Lihat Detail" type="button">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </button>
                                    <button class="p-1.5 text-slate-400 hover:text-slate-600 rounded-md transition" title="Pilihan Lain" type="button">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Row 4: Sales TO Area -->
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="py-4 px-5 text-center text-slate-400 font-semibold">4</td>
                            <td class="py-4 px-6">
                                <div class="font-bold text-slate-800 text-[13px]">Sales TO Area</div>
                                <div class="text-[11px] text-slate-400 mt-0.5">Departemen Sales &amp; Distribusi • Bali &amp; Lombok</div>
                            </td>
                            <td class="py-4 px-4 text-center">
                                <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-slate-100 text-slate-700 font-bold text-xs">
                                    1
                                </span>
                            </td>
                            <td class="py-4 px-5 text-slate-600 font-medium">14 Sept 2026</td>
                            <td class="py-4 px-5 text-slate-600 font-medium">28 Sept 2026</td>
                            <td class="py-4 px-5 text-center">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                    Pending Review
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="inline-flex items-center justify-end gap-1.5">
                                    <button class="p-1.5 text-emerald-600 hover:bg-emerald-50 rounded-md transition" title="Setujui Lowongan" type="button">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </button>
                                    <button class="p-1.5 text-slate-500 hover:text-red-800 hover:bg-rose-50 rounded-md transition" title="Lihat Detail" type="button">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </button>
                                    <button class="p-1.5 text-slate-400 hover:text-slate-600 rounded-md transition" title="Pilihan Lain" type="button">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Row 5: Administration Supervisor -->
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="py-4 px-5 text-center text-slate-400 font-semibold">5</td>
                            <td class="py-4 px-6">
                                <div class="font-bold text-slate-800 text-[13px]">Administration Supervisor</div>
                                <div class="text-[11px] text-slate-400 mt-0.5">Departemen HR &amp; GA • Kantor Pusat</div>
                            </td>
                            <td class="py-4 px-4 text-center">
                                <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-slate-100 text-slate-700 font-bold text-xs">
                                    1
                                </span>
                            </td>
                            <td class="py-4 px-5 text-slate-600 font-medium">14 Sept 2026</td>
                            <td class="py-4 px-5 text-slate-600 font-medium">28 Sept 2026</td>
                            <td class="py-4 px-5 text-center">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                    Pending Review
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="inline-flex items-center justify-end gap-1.5">
                                    <button class="p-1.5 text-emerald-600 hover:bg-emerald-50 rounded-md transition" title="Setujui Lowongan" type="button">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </button>
                                    <button class="p-1.5 text-slate-500 hover:text-red-800 hover:bg-rose-50 rounded-md transition" title="Lihat Detail" type="button">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </button>
                                    <button class="p-1.5 text-slate-400 hover:text-slate-600 rounded-md transition" title="Pilihan Lain" type="button">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- END: RecruitmentDataTable -->

            <!-- BEGIN: TablePaginationFooter -->
            <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-200/80 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500" data-purpose="table-pagination">
                <p>Menampilkan <span class="font-semibold text-slate-700">1-5</span> dari <span class="font-semibold text-slate-700">28</span> total lowongan</p>
                <nav aria-label="Pagination Navigation" class="inline-flex items-center gap-1">
                    <button class="px-2.5 py-1.5 rounded border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 disabled:opacity-50" disabled="" type="button">
                        Sebelumnya
                    </button>
                    <button class="w-7 h-7 flex items-center justify-center rounded font-semibold bg-[#A6192E] text-white" type="button">
                        1
                    </button>
                    <button class="w-7 h-7 flex items-center justify-center rounded text-slate-600 hover:bg-slate-100" type="button">
                        2
                    </button>
                    <button class="w-7 h-7 flex items-center justify-center rounded text-slate-600 hover:bg-slate-100" type="button">
                        3
                    </button>
                    <button class="px-2.5 py-1.5 rounded border border-slate-200 bg-white text-slate-600 hover:bg-slate-50" type="button">
                        Selanjutnya
                    </button>
                </nav>
            </div>
            <!-- END: TablePaginationFooter -->
        </div>
        <!-- END: Main Card Container -->

        <!-- BEGIN: Modal Tambah Lowongan (Alpine.js) -->
        <div x-show="openCreateModal"
            x-cloak
            style="display: none;"
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
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
                                        <svg class="w-4 h-4 text-slate-400 absolute right-3.5 top-3 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M19 9l-7 7-7-7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                        </svg>
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
                                        <svg class="w-4 h-4 text-slate-400 absolute right-3.5 top-3 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M19 9l-7 7-7-7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                        </svg>
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
                                        <svg class="w-4 h-4 text-slate-400 absolute right-3.5 top-3 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M19 9l-7 7-7-7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                        </svg>
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
                                        <svg class="w-4 h-4 text-slate-400 absolute right-3.5 top-3 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M19 9l-7 7-7-7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                        </svg>
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
                                <textarea name="description" id="modal_description" rows="4"
                                    class="w-full px-4 py-2.5 text-xs rounded-xl border {{ $errors->has('description') ? 'border-red-500 ring-1 ring-red-500' : 'border-slate-200' }} bg-slate-50/50 hover:border-slate-300 focus:bg-white focus:border-[#A6192E] focus:ring-2 focus:ring-[#A6192E]/20 text-slate-800 placeholder-slate-400 transition leading-relaxed resize-y"
                                    placeholder="Tuliskan tanggung jawab dan rincian pekerjaan..." required>{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-1.5">
                                <label for="modal_qualification" class="block text-[11px] font-semibold text-slate-700 uppercase tracking-wider">
                                    Kualifikasi Pelamar <span class="text-[#A6192E] font-bold">*</span>
                                </label>
                                <textarea name="qualification" id="modal_qualification" rows="4"
                                    class="w-full px-4 py-2.5 text-xs rounded-xl border {{ $errors->has('qualification') ? 'border-red-500 ring-1 ring-red-500' : 'border-slate-200' }} bg-slate-50/50 hover:border-slate-300 focus:bg-white focus:border-[#A6192E] focus:ring-2 focus:ring-[#A6192E]/20 text-slate-800 placeholder-slate-400 transition leading-relaxed resize-y"
                                    placeholder="Tuliskan pendidikan, pengalaman, keahlian, dan persyaratan lainnya..." required>{{ old('qualification') }}</textarea>
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

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="space-y-1.5">
                                    <label for="modal_opening_date" class="block text-[11px] font-semibold text-slate-700 uppercase tracking-wider">
                                        Tanggal Buka <span class="text-[#A6192E] font-bold">*</span>
                                    </label>
                                    <input type="date" name="opening_date" id="modal_opening_date" value="{{ old('opening_date') }}"
                                        class="w-full px-4 py-2.5 text-xs rounded-xl border {{ $errors->has('opening_date') ? 'border-red-500 ring-1 ring-red-500' : 'border-slate-200' }} bg-slate-50/50 hover:border-slate-300 focus:bg-white focus:border-[#A6192E] focus:ring-2 focus:ring-[#A6192E]/20 text-slate-700 transition"
                                        required>
                                    @error('opening_date')
                                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
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
        <!-- END: Modal Tambah Lowongan -->
    </div>
@endsection
