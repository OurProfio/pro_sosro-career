@extends('auth.admin.layouts.index')

@section('title', 'Manajemen Lowongan - Sinar Sosro Gunung Slamat (Rekso)')

@section('content')
    <div class="space-y-6 font-sans">
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
                <a href="{{ route('job.create') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-full bg-[#A6192E] hover:bg-[#7f1d1d] text-white text-xs font-bold shadow-sm shadow-red-950/20 hover:shadow-md transition duration-150 ease-in-out">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                    <span>Tambah Lowongan</span>
                </a>
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
    </div>
@endsection
