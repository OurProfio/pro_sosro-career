@extends('auth.applicant.layouts.index')

@section('title', 'Pratinjau Biodata Pelamar')

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
        {{-- Control Bar --}}
        <div
            class="mb-6 flex flex-wrap justify-between items-center gap-4 no-print bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
            <div class="flex items-center gap-3">
                <a href="{{ route('biodata.workExperience.create') }}"
                    class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-lg transition" title="Kembali">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <h2 class="text-base font-bold text-slate-800">Pratinjau Biodata</h2>
                    <p class="text-xs text-slate-500">Periksa kembali kelengkapan data sebelum mengunduh atau mencetak</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('biodata.edit', auth()->user()->applicant->id) }}"
                    class="px-4 py-2 bg-slate-100 text-slate-700 hover:bg-slate-200 rounded-lg text-xs font-semibold transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit Data
                </a>
                <button onclick="window.print()"
                    class="px-5 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-xs font-bold transition flex items-center gap-2 shadow-md shadow-red-200 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Cetak / Simpan PDF
                </button>
            </div>
        </div>

        {{-- Main Layout --}}
        <div
            class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden print-grid grid grid-cols-1 lg:grid-cols-12">

            {{-- COLUMN 1: Sidebar Informasi Pribadi & Kontak --}}
            <aside
                class="lg:col-span-4 bg-slate-50 border-b lg:border-b-0 lg:border-r border-slate-200 p-6 sm:p-8 flex flex-col justify-between">
                <div class="space-y-6">
                    {{-- Avatar Section --}}
                    <div class="text-center lg:text-left">
                        <div
                            class="w-32 h-40 mx-auto lg:mx-0 bg-slate-200 rounded-xl overflow-hidden border-2 border-white shadow-md relative flex items-center justify-center">
                            @if ($applicant->photo_url)
                                <img src="{{ asset('storage/' . $applicant->photo_url) }}" alt="Foto {{ $applicant->name }}"
                                    class="w-full h-full object-cover">
                            @else
                                <svg class="w-16 h-16 text-slate-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            @endif
                        </div>
                        <h1 class="mt-4 text-xl font-extrabold text-slate-900 tracking-tight leading-snug">
                            {{ $applicant->name }}
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
                            <span class="font-semibold">{{ $applicant->phone_number }}</span>
                        </div>

                        <div class="flex items-center gap-3 text-slate-700">
                            <div
                                class="w-8 h-8 rounded-lg bg-white border border-slate-200 flex items-center justify-center flex-shrink-0 text-slate-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <span class="font-medium truncate">{{ $applicant->email }}</span>
                        </div>

                        @if ($applicant->linkedin)
                            <div class="flex items-center gap-3 text-slate-700">
                                <div
                                    class="w-8 h-8 rounded-lg bg-white border border-slate-200 flex items-center justify-center flex-shrink-0 text-slate-500">
                                    <span class="text-[10px] font-black">IN</span>
                                </div>
                                <span class="font-medium truncate">{{ $applicant->linkedin }}</span>
                            </div>
                        @endif

                        @if ($applicant->instagram)
                            <div class="flex items-center gap-3 text-slate-700">
                                <div
                                    class="w-8 h-8 rounded-lg bg-white border border-slate-200 flex items-center justify-center flex-shrink-0 text-slate-500">
                                    <span class="text-[10px] font-black">IG</span>
                                </div>
                                <span class="font-medium">{{ $applicant->instagram }}</span>
                            </div>
                        @endif
                    </div>

                    {{-- Detail Personal --}}
                    <div class="space-y-3 pt-4 border-t border-slate-200 text-xs">
                        <h3 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Detail Personal</h3>

                        <div class="grid grid-cols-2 gap-2 bg-white p-3 rounded-xl border border-slate-200">
                            <div>
                                <p class="text-[9px] text-slate-400 font-semibold uppercase">NIK</p>
                                <p class="font-bold text-slate-800 tracking-tight text-[11px]">{{ $applicant->nik }}</p>
                            </div>
                            <div>
                                <p class="text-[9px] text-slate-400 font-semibold uppercase">Agama</p>
                                <p class="font-semibold text-slate-700">{{ ucfirst($applicant->religion) }}</p>
                            </div>
                            <div class="mt-2">
                                <p class="text-[9px] text-slate-400 font-semibold uppercase">Jenis Kelamin</p>
                                <p class="font-semibold text-slate-700">
                                    {{ $applicant->gender == 'l' ? 'Laki-laki' : 'Perempuan' }}</p>
                            </div>
                            <div class="mt-2">
                                <p class="text-[9px] text-slate-400 font-semibold uppercase">Status</p>
                                <p class="font-semibold text-slate-700">
                                    @switch($applicant->marital_status)
                                        @case('single')
                                            Lajang
                                        @break

                                        @case('married')
                                            Menikah
                                        @break

                                        @case('divorced')
                                            Cerai
                                        @break

                                        @case('widowed')
                                            Duda/Janda
                                        @break

                                        @default
                                            {{ ucfirst($applicant->marital_status) }}
                                    @endswitch
                                </p>
                            </div>
                        </div>

                        <div class="space-y-1.5 pt-1">
                            <div class="flex justify-between py-1 border-b border-slate-200/60">
                                <span class="text-slate-500">TTL</span>
                                <span class="font-medium text-slate-800">
                                    {{ $applicant->place_of_birth }},
                                    {{ \Carbon\Carbon::parse($applicant->date_of_birth)->locale('id')->translatedFormat('d M Y') }}
                                </span>
                            </div>
                            <div class="flex justify-between py-1 border-b border-slate-200/60">
                                <span class="text-slate-500">Tinggi / Berat</span>
                                <span class="font-medium text-slate-800">{{ $applicant->height }} cm /
                                    {{ $applicant->weight }} kg</span>
                            </div>
                            <div class="flex justify-between py-1 border-b border-slate-200/60">
                                <span class="text-slate-500">SIM</span>
                                <span class="font-medium text-slate-800">
                                    @php
                                        $licenses = is_array($applicant->driver_licenses)
                                            ? $applicant->driver_licenses
                                            : json_decode($applicant->driver_licenses ?? '[]', true);
                                    @endphp
                                    {{ !empty($licenses) ? implode(', ', array_map('strtoupper', $licenses)) : '-' }}
                                </span>
                            </div>
                            <div class="flex justify-between py-1 border-b border-slate-200/60">
                                <span class="text-slate-500">Rokok / Tato</span>
                                <span class="font-medium text-slate-800">
                                    {{ $applicant->is_smoker == 'y' ? 'Ya' : 'Tidak' }} /
                                    {{ $applicant->has_tattoo == 'y' ? 'Ya' : 'Tidak' }}
                                </span>
                            </div>
                            @if ($applicant->medical_history)
                                <div class="py-1 border-b border-slate-200/60">
                                    <span class="text-slate-500 block">Riwayat Medis:</span>
                                    <span class="font-medium text-slate-800">{{ $applicant->medical_history }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Alamat --}}
                    <div class="space-y-3 pt-4 border-t border-slate-200 text-xs">
                        <h3 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Alamat</h3>

                        <div class="space-y-2">
                            <div>
                                <p class="text-[9px] font-bold text-slate-400 uppercase">KTP</p>
                                <p class="text-slate-700 leading-relaxed font-medium mt-0.5">
                                    {{ $applicant->address_ktp }}
                                </p>
                            </div>
                            <div class="pt-1">
                                <p class="text-[9px] font-bold text-slate-400 uppercase">Domisili Saat Ini</p>
                                <p class="text-slate-700 leading-relaxed font-medium mt-0.5">
                                    {{ $applicant->address_domisili }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>

            {{-- COLUMN 2: Main Content Area --}}
            <main class="lg:col-span-8 p-6 sm:p-8 space-y-8">

                {{-- 1. PENGALAMAN KERJA --}}
                <section class="break-inside-avoid">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-1.5 h-4 bg-red-600 rounded-full"></div>
                        <h2 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Pengalaman Kerja</h2>
                    </div>

                    @if ($applicant->workExperiences && $applicant->workExperiences->count() > 0)
                        <div class="space-y-4">
                            @foreach ($applicant->workExperiences->sortByDesc(fn($exp) => [$exp->end_date ?? '9999-12-31', $exp->start_date]) as $exp)
                                <div class="relative pl-6 border-l-2 border-slate-200 space-y-2">
                                    <div
                                        class="absolute -left-[7px] top-0 w-3 h-3 rounded-full bg-red-600 border-2 border-white">
                                    </div>

                                    <div class="flex flex-wrap justify-between items-start gap-1">
                                        <div>
                                            <h3 class="text-sm font-bold text-slate-900">{{ $exp->position ?? '-' }}</h3>
                                            <p class="text-xs font-semibold text-red-600">{{ $exp->company_name ?? '-' }}
                                                {{ $exp->division ? "({$exp->division})" : '' }}</p>
                                        </div>
                                        <span
                                            class="px-2.5 py-0.5 bg-slate-100 text-slate-600 rounded-md text-[10px] font-bold">
                                            {{ $exp->start_date ? \Carbon\Carbon::parse($exp->start_date)->locale('id')->translatedFormat('M Y') : '-' }}
                                            -
                                            {{ $exp->end_date ? \Carbon\Carbon::parse($exp->end_date)->locale('id')->translatedFormat('M Y') : 'Saat Ini' }}
                                        </span>
                                    </div>

                                    <div
                                        class="grid grid-cols-2 sm:grid-cols-3 gap-2 bg-slate-50 p-3 rounded-lg border border-slate-100 text-[11px] mt-2">
                                        <div>
                                            <span class="text-slate-400 text-[9px] block uppercase font-semibold">Gaji
                                                Terakhir</span>
                                            <span class="font-medium text-slate-700">
                                                {{ $exp->salary ? 'Rp ' . number_format($exp->salary, 0, ',', '.') : '-' }}
                                            </span>
                                        </div>
                                        <div>
                                            <span
                                                class="text-slate-400 text-[9px] block uppercase font-semibold">Referensi</span>
                                            <span
                                                class="font-medium text-slate-700">{{ $exp->reference_name ?? '-' }}</span>
                                        </div>
                                        <div class="col-span-2 sm:col-span-1">
                                            <span class="text-slate-400 text-[9px] block uppercase font-semibold">Alasan
                                                Berhenti</span>
                                            <span
                                                class="font-medium text-slate-700">{{ $exp->reason_for_leaving ?? '-' }}</span>
                                        </div>
                                        @if ($exp->facility)
                                            <div class="col-span-2 sm:col-span-3 pt-1 border-t border-slate-200/60">
                                                <span
                                                    class="text-slate-400 text-[9px] block uppercase font-semibold">Fasilitas</span>
                                                <span class="font-medium text-slate-700">{{ $exp->facility }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-xs text-slate-400 italic bg-slate-50 p-3 rounded-lg border border-slate-100">
                            Belum memiliki pengalaman kerja (Fresh Graduate).
                        </p>
                    @endif
                </section>

                {{-- 2. PENDIDIKAN FORMAL --}}
                <section class="break-inside-avoid">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-1.5 h-4 bg-red-600 rounded-full"></div>
                        <h2 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Pendidikan Formal</h2>
                    </div>

                    @if ($applicant->educations && $applicant->educations->count() > 0)
                        <div class="space-y-3 text-xs">
                            @foreach ($applicant->educations as $edu)
                                <div
                                    class="p-4 bg-slate-50 border border-slate-200 rounded-xl flex flex-wrap justify-between items-center gap-2">
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <span
                                                class="px-2 py-0.5 bg-slate-900 text-white font-bold text-[9px] rounded uppercase">
                                                {{ $edu->degree_level }}
                                            </span>
                                            <h3 class="font-bold text-slate-900">{{ $edu->institution_name }}</h3>
                                        </div>
                                        <p class="text-slate-600 mt-1">{{ $edu->major }}</p>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-slate-600 font-medium text-[11px]">
                                            {{ $edu->entry_year }} - {{ $edu->graduation_year }}
                                        </span>
                                        <p class="text-slate-500 text-[11px] mt-0.5 font-semibold">IPK / Nilai:
                                            {{ $edu->gpa }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-xs text-slate-400 italic bg-slate-50 p-3 rounded-lg border border-slate-100">
                            Data pendidikan formal belum diisi.
                        </p>
                    @endif
                </section>

                {{-- 3. KELUARGA --}}
                <section class="break-inside-avoid">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-1.5 h-4 bg-red-600 rounded-full"></div>
                        <h2 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Data Keluarga Kandung</h2>
                    </div>

                    @if ($applicant->families && $applicant->families->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                            @foreach ($applicant->families as $fam)
                                <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl space-y-1">
                                    <div class="flex justify-between items-center">
                                        <span class="font-bold text-slate-900">{{ $fam->name }}</span>
                                        <span
                                            class="px-2 py-0.5 bg-red-100 text-red-700 font-bold text-[9px] rounded uppercase">
                                            @switch($fam->relationship)
                                                @case('father')
                                                    Ayah
                                                @break

                                                @case('mother')
                                                    Ibu
                                                @break

                                                @case('sibling')
                                                    Saudara
                                                @break

                                                @case('spouse')
                                                    Pasangan
                                                @break

                                                @case('child')
                                                    Anak
                                                @break

                                                @default
                                                    {{ ucfirst($fam->relationship) }}
                                            @endswitch
                                        </span>
                                    </div>
                                    <p class="text-slate-500 text-[11px]">
                                        {{ \Carbon\Carbon::parse($fam->date_of_birth)->age }} Th • {{ $fam->education }} •
                                        {{ $fam->work }}
                                    </p>
                                    <p class="text-slate-600 font-medium text-[11px] pt-1">Kontak:
                                        {{ $fam->phone_number }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-xs text-slate-400 italic bg-slate-50 p-3 rounded-lg border border-slate-100">
                            Data keluarga belum diisi.
                        </p>
                    @endif
                </section>

                {{-- 4. PELATIHAN & DOKUMEN LAMPIRAN --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 break-inside-avoid">
                    {{-- Pelatihan --}}
                    <div>
                        <div class="flex items-center gap-2 mb-3">
                            <div class="w-1.5 h-3 bg-red-600 rounded-full"></div>
                            <h2 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Pelatihan / Sertifikasi
                            </h2>
                        </div>
                        @if ($applicant->trainings && $applicant->trainings->count() > 0)
                            <div class="space-y-2 text-xs">
                                @foreach ($applicant->trainings as $train)
                                    <div class="p-2.5 bg-white border border-slate-200 rounded-lg">
                                        <p class="font-bold text-slate-800">{{ $train->training_name }}</p>
                                        <p class="text-[10px] text-slate-500">
                                            {{ $train->organizer }} •
                                            {{ \Carbon\Carbon::parse($train->finished)->locale('id')->translatedFormat('Y') }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-xs text-slate-400 italic bg-slate-50 p-2.5 rounded-lg border border-slate-100">
                                Belum ada riwayat pelatihan.
                            </p>
                        @endif
                    </div>

                    {{-- Lampiran Berkas (STATIS) --}}
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
