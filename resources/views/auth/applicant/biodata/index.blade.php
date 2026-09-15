@extends('auth.applicant.layouts.index')

@section('title', 'Biodata Pelamar (Preview)')

@section('content')
    <style>
        @media print {

            nav,
            .nav-buttons,
            .sidebar,
            .no-print,
            button,
            footer {
                display: none !important;
            }

            body {
                background: white !important;
                padding: 0 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .max-w-6xl {
                max-width: 100% !important;
                width: 100% !important;
                margin: 0 !important;
            }

            .print-grid {
                display: grid !important;
                grid-template-columns: 280px 1fr !important;
                gap: 1.5rem !important;
            }

            .shadow-sm,
            .shadow-md,
            .shadow-lg,
            .rounded-2xl,
            .rounded-xl {
                box-shadow: none !important;
                border-radius: 0 !important;
            }

            section,
            .break-inside-avoid {
                page-break-inside: avoid;
            }

            @page {
                size: A4;
                margin: 1.2cm;
            }
        }
    </style>

    {{-- Header Khusus Cetak --}}
    <div class="hidden print:block mb-6 border-b-2 border-slate-900 pb-4">
        <div class="flex justify-between items-end">
            <div>
                <h1 class="text-2xl font-black uppercase tracking-wider text-slate-900">Biodata Calon Karyawan</h1>
                <p class="text-xs text-slate-500 font-medium">Dokumen Resmi Sistem Rekrutmen Perusahaan</p>
            </div>
            <p class="text-[10px] text-slate-400 font-mono">Dicetak pada: {{ date('d/m/Y H:i') }}</p>
        </div>
    </div>

    <div class="max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        {{-- Control Bar (Actionable & Clear Affordance) --}}
        <div
            class="mb-6 flex flex-wrap justify-between items-center gap-4 no-print bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
            <div class="flex items-center gap-3">
                <a href="#" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-lg transition"
                    title="Kembali">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <h2 class="text-base font-bold text-slate-800">Preview Biodata</h2>
                    <p class="text-xs text-slate-500">Periksa kembali kelengkapan data sebelum mengunduh</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('biodata.edit', auth()->user()->applicant->applicantProfile->id) }}"
                    class="px-4 py-2 bg-slate-100 text-slate-700 hover:bg-slate-200 rounded-lg text-xs font-semibold transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit Data
                </a>
                <button onclick="window.print()"
                    class="px-5 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-xs font-bold transition flex items-center gap-2 shadow-md shadow-red-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Cetak / Simpan PDF
                </button>
            </div>
        </div>

        {{-- Main Resume Layout (Asymmetric 2-Column Grid) --}}
        <div
            class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden print-grid grid grid-cols-1 lg:grid-cols-12">

            {{-- COLUMN 1: Sidebar Informasi Pribadi & Kontak (4 Cols) --}}
            <aside
                class="lg:col-span-4 bg-slate-50 border-b lg:border-b-0 lg:border-r border-slate-200 p-6 sm:p-8 flex flex-col justify-between">
                <div class="space-y-6">
                    {{-- Avatar Section --}}
                    <div class="text-center lg:text-left">
                        <div
                            class="w-32 h-40 mx-auto lg:mx-0 bg-slate-200 rounded-xl overflow-hidden border-2 border-white shadow-md relative flex items-center justify-center">
                            <svg class="w-16 h-16 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <h1 class="mt-4 text-xl font-extrabold text-slate-900 tracking-tight leading-snug">
                            Alandrian Surya Tantra
                        </h1>
                        <p class="text-xs font-medium text-slate-500 mt-0.5">Pelamar Kerja</p>
                    </div>

                    {{-- Primary Contact Info --}}
                    <div class="space-y-3 pt-4 border-t border-slate-200 text-xs">
                        <div class="flex items-center gap-3 text-slate-700">
                            <div
                                class="w-8 h-8 rounded-lg bg-white border border-slate-200 flex items-center justify-center flex-shrink-0 text-red-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <span class="font-semibold">0812-3456-7890</span>
                        </div>

                        <div class="flex items-center gap-3 text-slate-700">
                            <div
                                class="w-8 h-8 rounded-lg bg-white border border-slate-200 flex items-center justify-center flex-shrink-0 text-slate-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <span class="font-medium truncate">alandrian@example.com</span>
                        </div>

                        <div class="flex items-center gap-3 text-slate-700">
                            <div
                                class="w-8 h-8 rounded-lg bg-white border border-slate-200 flex items-center justify-center flex-shrink-0 text-slate-500">
                                <span class="text-[10px] font-black">IN</span>
                            </div>
                            <span class="font-medium truncate">linkedin.com/in/alandrian</span>
                        </div>

                        <div class="flex items-center gap-3 text-slate-700">
                            <div
                                class="w-8 h-8 rounded-lg bg-white border border-slate-200 flex items-center justify-center flex-shrink-0 text-slate-500">
                                <span class="text-[10px] font-black">IG</span>
                            </div>
                            <span class="font-medium">@alandrian_st</span>
                        </div>
                    </div>

                    {{-- Fisik & Identitas --}}
                    <div class="space-y-3 pt-4 border-t border-slate-200 text-xs">
                        <h3 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Detail Personal</h3>

                        <div class="grid grid-cols-2 gap-2 bg-white p-3 rounded-xl border border-slate-200">
                            <div>
                                <p class="text-[9px] text-slate-400 font-semibold uppercase">NIK</p>
                                <p class="font-bold text-slate-800 tracking-tight text-[11px]">3175091411050001</p>
                            </div>
                            <div>
                                <p class="text-[9px] text-slate-400 font-semibold uppercase">Agama</p>
                                <p class="font-semibold text-slate-700">Islam</p>
                            </div>
                            <div class="mt-2">
                                <p class="text-[9px] text-slate-400 font-semibold uppercase">Gender</p>
                                <p class="font-semibold text-slate-700">Laki-laki</p>
                            </div>
                            <div class="mt-2">
                                <p class="text-[9px] text-slate-400 font-semibold uppercase">Status</p>
                                <p class="font-semibold text-slate-700">Lajang</p>
                            </div>
                        </div>

                        <div class="space-y-1.5 pt-1">
                            <div class="flex justify-between py-1 border-b border-slate-200/60">
                                <span class="text-slate-500">TTL</span>
                                <span class="font-medium text-slate-800">Jakarta, 14 Nov 2005</span>
                            </div>
                            <div class="flex justify-between py-1 border-b border-slate-200/60">
                                <span class="text-slate-500">Tinggi / Berat</span>
                                <span class="font-medium text-slate-800">173 cm / 65 kg</span>
                            </div>
                            <div class="flex justify-between py-1 border-b border-slate-200/60">
                                <span class="text-slate-500">SIM</span>
                                <span class="font-medium text-slate-800">SIM A, SIM C</span>
                            </div>
                            <div class="flex justify-between py-1 border-b border-slate-200/60">
                                <span class="text-slate-500">Rokok / Tato</span>
                                <span class="font-medium text-slate-800">Tidak / Tidak</span>
                            </div>
                        </div>
                    </div>

                    {{-- Alamat --}}
                    <div class="space-y-3 pt-4 border-t border-slate-200 text-xs">
                        <h3 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Alamat</h3>

                        <div class="space-y-2">
                            <div>
                                <p class="text-[9px] font-bold text-slate-400 uppercase">KTP</p>
                                <p class="text-slate-700 leading-relaxed font-medium mt-0.5">
                                    Jl. Raya Harapan Indah No. 12, Medan Satria, Bekasi, Jawa Barat
                                </p>
                            </div>
                            <div class="pt-1">
                                <p class="text-[9px] font-bold text-slate-400 uppercase">Domisili Saat Ini</p>
                                <p class="text-slate-700 leading-relaxed font-medium mt-0.5">
                                    Perum. Kebon Jeruk Indah Blok B3 No. 5, Jakarta Barat
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-6 mt-6 border-t border-slate-200 text-[10px] text-slate-400 text-center lg:text-left">
                    Ref-ID: APP-2026-0912
                </div>
            </aside>

            {{-- COLUMN 2: Main Content Area (8 Cols) --}}
            <main class="lg:col-span-8 p-6 sm:p-8 space-y-8">

                {{-- 1. PREFERENSI KERJA & MINAT --}}
                <section class="break-inside-avoid">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-1.5 h-4 bg-red-600 rounded-full"></div>
                        <h2 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Preferensi & Minat Karir</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                        {{-- Gaji & Ekspektasi --}}
                        <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 flex flex-col justify-between">
                            <div class="space-y-3">
                                <div>
                                    <span class="text-[10px] text-slate-400 font-bold uppercase block">Ekspektasi
                                        Gaji</span>
                                    <span class="text-base font-extrabold text-red-600">Rp 7.500.000</span>
                                </div>
                                <div>
                                    <span class="text-[10px] text-slate-400 font-bold uppercase block">Fasilitas
                                        Diharapkan</span>
                                    <span class="font-medium text-slate-700">BPJS Kesehatan, BPJS Ketenagakerjaan,
                                        Tunjangan Transport</span>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-2 pt-4 mt-2 border-t border-slate-200">
                                <div class="flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                    <span class="text-[11px] font-semibold text-slate-700">Dinas Luar Kota</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                    <span class="text-[11px] font-semibold text-slate-700">Relokasi Kerja</span>
                                </div>
                            </div>
                        </div>

                        {{-- Prioritas Minat --}}
                        <div class="bg-slate-50 p-4 rounded-xl border border-slate-200">
                            <span class="text-[10px] text-slate-400 font-bold uppercase block mb-3">Prioritas Bidang
                                Pekerjaan</span>
                            <div class="space-y-1.5">
                                <div
                                    class="flex items-center gap-2 bg-white px-2.5 py-1.5 rounded-lg border border-slate-200 shadow-2xs">
                                    <span
                                        class="w-4 h-4 rounded-md bg-slate-900 text-white font-mono text-[9px] font-bold flex items-center justify-center">1</span>
                                    <span class="font-bold text-slate-800 text-[11px]">Software Engineering</span>
                                </div>
                                <div
                                    class="flex items-center gap-2 bg-white px-2.5 py-1.5 rounded-lg border border-slate-200 shadow-2xs">
                                    <span
                                        class="w-4 h-4 rounded-md bg-slate-700 text-white font-mono text-[9px] font-bold flex items-center justify-center">2</span>
                                    <span class="font-bold text-slate-800 text-[11px]">Research & Development</span>
                                </div>
                                <div
                                    class="flex items-center gap-2 bg-white px-2.5 py-1.5 rounded-lg border border-slate-200 shadow-2xs">
                                    <span
                                        class="w-4 h-4 rounded-md bg-slate-400 text-white font-mono text-[9px] font-bold flex items-center justify-center">3</span>
                                    <span class="font-semibold text-slate-700 text-[11px]">IT Infrastructure</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- 2. PENGALAMAN KERJA (Timeline UI) --}}
                <section class="break-inside-avoid">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-1.5 h-4 bg-red-600 rounded-full"></div>
                        <h2 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Pengalaman Kerja</h2>
                    </div>

                    <div class="space-y-4">
                        <div class="relative pl-6 border-l-2 border-slate-200 space-y-2">
                            <div class="absolute -left-[7px] top-0 w-3 h-3 rounded-full bg-red-600 border-2 border-white">
                            </div>

                            <div class="flex flex-wrap justify-between items-start gap-1">
                                <div>
                                    <h3 class="text-sm font-bold text-slate-900">Backend Developer Intern</h3>
                                    <p class="text-xs font-semibold text-red-600">PT Teknologi Nusantara</p>
                                </div>
                                <span class="px-2.5 py-0.5 bg-slate-100 text-slate-600 rounded-md text-[10px] font-bold">
                                    Jan 2026 - Jun 2026
                                </span>
                            </div>

                            <div
                                class="grid grid-cols-2 sm:grid-cols-3 gap-2 bg-slate-50 p-3 rounded-lg border border-slate-100 text-[11px] mt-2">
                                <div>
                                    <span class="text-slate-400 text-[9px] block uppercase font-semibold">Gaji
                                        Terakhir</span>
                                    <span class="font-medium text-slate-700">Rp 4.500.000</span>
                                </div>
                                <div>
                                    <span class="text-slate-400 text-[9px] block uppercase font-semibold">Referensi</span>
                                    <span class="font-medium text-slate-700">Budi Santoso (Supervisor)</span>
                                </div>
                                <div class="col-span-2 sm:col-span-1">
                                    <span class="text-slate-400 text-[9px] block uppercase font-semibold">Alasan
                                        Berhenti</span>
                                    <span class="font-medium text-slate-700">Kontrak Selesai</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- 3. PENDIDIKAN FORMAL --}}
                <section class="break-inside-avoid">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-1.5 h-4 bg-red-600 rounded-full"></div>
                        <h2 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Pendidikan Formal</h2>
                    </div>

                    <div class="space-y-3 text-xs">
                        {{-- Perguruan Tinggi --}}
                        <div
                            class="p-4 bg-slate-50 border border-slate-200 rounded-xl flex flex-wrap justify-between items-center gap-2">
                            <div>
                                <div class="flex items-center gap-2">
                                    <span
                                        class="px-2 py-0.5 bg-slate-900 text-white font-bold text-[9px] rounded">S1</span>
                                    <h3 class="font-bold text-slate-900">Universitas Esa Unggul</h3>
                                </div>
                                <p class="text-slate-600 mt-1">Teknik Informatika</p>
                            </div>
                            <div class="text-right">
                                <span class="px-2 py-0.5 bg-blue-100 text-blue-700 rounded-full text-[10px] font-bold">
                                    Sedang Memtempuh
                                </span>
                                <p class="text-slate-500 text-[11px] mt-1 font-semibold">IPK: 3.85 (Angkatan 2024)</p>
                            </div>
                        </div>

                        {{-- Sekolah Menengah --}}
                        <div
                            class="p-3 bg-white border border-slate-200 rounded-xl flex flex-wrap justify-between items-center gap-2">
                            <div>
                                <div class="flex items-center gap-2">
                                    <span
                                        class="px-2 py-0.5 bg-slate-200 text-slate-700 font-bold text-[9px] rounded">SMA</span>
                                    <h3 class="font-bold text-slate-800">SMA Negeri 1 Jakarta</h3>
                                </div>
                                <p class="text-slate-500 mt-0.5 text-[11px]">MIPA</p>
                            </div>
                            <div class="text-right">
                                <span class="text-slate-600 font-medium text-[11px]">Lulus 2024</span>
                                <p class="text-slate-500 text-[11px] font-medium">Nilai Akhir: 88.50</p>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- 4. KELUARGA --}}
                <section class="break-inside-avoid">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-1.5 h-4 bg-red-600 rounded-full"></div>
                        <h2 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Data Keluarga Kandung</h2>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                        <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl space-y-1">
                            <div class="flex justify-between items-center">
                                <span class="font-bold text-slate-900">Suryadi Tantra</span>
                                <span
                                    class="px-2 py-0.5 bg-red-100 text-red-700 font-bold text-[9px] rounded uppercase">Ayah</span>
                            </div>
                            <p class="text-slate-500 text-[11px]">51 Th • S1 Wiraswasta</p>
                            <p class="text-slate-600 font-medium text-[11px] pt-1">Kontak: 0813-9988-7766</p>
                        </div>

                        <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl space-y-1">
                            <div class="flex justify-between items-center">
                                <span class="font-bold text-slate-900">Ratna Dewi</span>
                                <span
                                    class="px-2 py-0.5 bg-red-100 text-red-700 font-bold text-[9px] rounded uppercase">Ibu</span>
                            </div>
                            <p class="text-slate-500 text-[11px]">48 Th • SMA (Ibu Rumah Tangga)</p>
                            <p class="text-slate-600 font-medium text-[11px] pt-1">Kontak: 0813-8877-6655</p>
                        </div>
                    </div>
                </section>

                {{-- 5. PELATIHAN & DOKUMEN LAMPIRAN --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 break-inside-avoid">
                    {{-- Pelatihan --}}
                    <div>
                        <div class="flex items-center gap-2 mb-3">
                            <div class="w-1.5 h-3 bg-red-600 rounded-full"></div>
                            <h2 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Pelatihan / Kursus</h2>
                        </div>
                        <div class="space-y-2 text-xs">
                            <div class="p-2.5 bg-white border border-slate-200 rounded-lg">
                                <p class="font-bold text-slate-800">RESTful API Development</p>
                                <p class="text-[10px] text-slate-500">Dicoding Academy • 2026</p>
                            </div>
                            <div class="p-2.5 bg-white border border-slate-200 rounded-lg">
                                <p class="font-bold text-slate-800">Machine Learning Specialization</p>
                                <p class="text-[10px] text-slate-500">Coursera / Stanford • 2025</p>
                            </div>
                        </div>
                    </div>

                    {{-- Lampiran Berkas --}}
                    <div>
                        <div class="flex items-center gap-2 mb-3">
                            <div class="w-1.5 h-3 bg-red-600 rounded-full"></div>
                            <h2 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Lampiran Berkas</h2>
                        </div>
                        <div class="grid grid-cols-2 gap-2 text-[10px]">
                            <div
                                class="p-2 bg-slate-50 border border-slate-200 rounded-lg flex items-center justify-between font-semibold text-slate-700">
                                <span>KTP</span>
                                <span class="text-emerald-600 font-bold">✓ Uploaded</span>
                            </div>
                            <div
                                class="p-2 bg-slate-50 border border-slate-200 rounded-lg flex items-center justify-between font-semibold text-slate-700">
                                <span>Ijazah</span>
                                <span class="text-emerald-600 font-bold">✓ Uploaded</span>
                            </div>
                            <div
                                class="p-2 bg-slate-50 border border-slate-200 rounded-lg flex items-center justify-between font-semibold text-slate-700">
                                <span>Transkrip</span>
                                <span class="text-emerald-600 font-bold">✓ Uploaded</span>
                            </div>
                            <div
                                class="p-2 bg-slate-50 border border-slate-200 rounded-lg flex items-center justify-between font-semibold text-slate-700">
                                <span>SKCK</span>
                                <span class="text-emerald-600 font-bold">✓ Uploaded</span>
                            </div>
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>
@endsection
