@extends('auth.applicant.layouts.index')

@section('title', 'Data Pengalaman Kerja Pelamar')

@section('content')
    <div class="py-8 md:py-12 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto font-figtree">
        <div class="mb-6 flex items-center justify-end">
            <span class="text-xs font-medium text-gray-400">Langkah 4 dari 4</span>
        </div>

        <!-- Wizard Progress Bar -->
        <div class="mb-10">
            <ol class="flex items-center w-full text-xs font-semibold">
                <!-- Step 1: Data Personal (Dapat diklik, simpan dulu) -->
                <li>
                    <button type="button" onclick="goToStep('personal')" title="Simpan data saat ini & kembali ke Data Personal"
                        class="flex items-center transition-colors text-[#B11116] cursor-pointer group focus:outline-none">
                        <span
                            class="flex items-center justify-center w-8 h-8 rounded-full border-2 mr-2 shadow-sm transition-all text-xs font-bold border-[#B11116] bg-[#B11116] text-white group-hover:opacity-90">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                            </svg>
                        </span>
                        <span class="hidden sm:inline font-bold">Data Personal</span>
                    </button>
                </li>

                <li class="flex-1 border-t-2 mx-2 sm:mx-4 transition-colors duration-300 border-[#B11116]"></li>

                <!-- Step 2: Keluarga (Dapat diklik, simpan dulu) -->
                <li>
                    <button type="button" onclick="goToStep('family')" title="Simpan data saat ini & kembali ke Data Keluarga"
                        class="flex items-center transition-colors text-[#B11116] cursor-pointer group focus:outline-none">
                        <span
                            class="flex items-center justify-center w-8 h-8 rounded-full border-2 mr-2 shadow-sm transition-all text-xs font-bold border-[#B11116] bg-[#B11116] text-white group-hover:opacity-90">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                            </svg>
                        </span>
                        <span class="hidden sm:inline font-bold">Keluarga</span>
                    </button>
                </li>

                <li class="flex-1 border-t-2 mx-2 sm:mx-4 transition-colors duration-300 border-[#B11116]"></li>

                <!-- Step 3: Pendidikan (Dapat diklik, simpan dulu) -->
                <li>
                    <button type="button" onclick="goToStep('education')" title="Simpan data saat ini & kembali ke Data Pendidikan"
                        class="flex items-center transition-colors text-[#B11116] cursor-pointer group focus:outline-none">
                        <span
                            class="flex items-center justify-center w-8 h-8 rounded-full border-2 mr-2 shadow-sm transition-all text-xs font-bold border-[#B11116] bg-[#B11116] text-white group-hover:opacity-90">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                            </svg>
                        </span>
                        <span class="hidden sm:inline font-bold">Pendidikan</span>
                    </button>
                </li>

                <li class="flex-1 border-t-2 mx-2 sm:mx-4 transition-colors duration-300 border-[#B11116]"></li>

                <!-- Step 4: Pengalaman (AKTIF) -->
                <li class="flex items-center transition-colors text-[#B11116] font-bold">
                    <span
                        class="flex items-center justify-center w-8 h-8 rounded-full border-2 mr-2 shadow-sm transition-all text-xs font-bold border-[#B11116] bg-[#B11116] text-white">
                        <span>4</span>
                    </span>
                    <span class="hidden sm:inline">Pengalaman</span>
                </li>
            </ol>
        </div>

        <form action="{{ route('biodata.workExperience.store') }}" method="POST" id="experienceForm" novalidate>
            @csrf
            <input type="hidden" name="redirect_step" id="redirect_step" value="index">

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-6 sm:p-10 space-y-8">

                    <header class="border-b border-gray-100 pb-4">
                        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">
                            Riwayat <span class="text-[#B11116]">Pengalaman Kerja</span>
                        </h1>
                        <p class="text-gray-500 text-sm mt-1">
                            Isi riwayat pengalaman kerja Anda secara rinci. Jika Anda belum pernah bekerja atau fresh
                            graduate, bagian ini bersifat opsional (dapat dikosongkan).
                        </p>
                    </header>

                    @php
                        $sosroExp = $workExperiences->first(function ($exp) {
                            $cn = strtolower((string) ($exp->company_name ?? ''));
                            return str_contains($cn, 'sosro') || str_contains($cn, 'gunung slamat') || str_contains($cn, 'rekso');
                        });
                        $hasWorkedSosroDb = $sosroExp ? '1' : ($workExperiences->isNotEmpty() ? '0' : '');
                        $selectedWorkedSosro = old('has_worked_in_sosro', $hasWorkedSosroDb);
                        $hasAppliedSosro = old('has_applied_sosro', $applicant?->has_applied_sosro ?? 'n');
                    @endphp

                    <!-- PERTANYAAN PERNAH MELAMAR DI SOSRO -->
                    <div class="space-y-3 border-b border-gray-100 pb-4">
                        <div class="space-y-1">
                            <span class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Pernahkah Anda Melamar di PT SINAR SOSRO / Group ini sebelumnya? <span class="text-[#B11116]">*</span>
                            </span>
                            <div class="flex items-center gap-6 py-1">
                                <label for="applied_sosro_yes" class="inline-flex items-center cursor-pointer group py-1">
                                    <input id="applied_sosro_yes" type="radio" name="has_applied_sosro" value="y"
                                        required
                                        {{ $hasAppliedSosro === 'y' ? 'checked' : '' }}
                                        class="w-4 h-4 text-[#B11116] border-gray-300 focus:ring-[#B11116]">
                                    <span class="ml-2 text-sm font-medium text-gray-700 group-hover:text-gray-900">Pernah</span>
                                </label>
                                <label for="applied_sosro_no" class="inline-flex items-center cursor-pointer group py-1">
                                    <input id="applied_sosro_no" type="radio" name="has_applied_sosro" value="n"
                                        required
                                        {{ $hasAppliedSosro === 'n' ? 'checked' : '' }}
                                        class="w-4 h-4 text-[#B11116] border-gray-300 focus:ring-[#B11116]">
                                    <span class="ml-2 text-sm font-medium text-gray-700 group-hover:text-gray-900">Belum Pernah</span>
                                </label>
                            </div>
                            @error('has_applied_sosro')
                                <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- DETAIL MELAMAR DI SOSRO -->
                        <div id="appliedSosroDetailCard" class="{{ $hasAppliedSosro === 'y' ? '' : 'hidden' }} p-5 bg-gray-50 border border-gray-200 rounded-xl space-y-4 transition-all">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="space-y-1.5">
                                    <label for="previous_applied_position" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Untuk Posisi Jabatan Apa? <span class="text-[#B11116]">*</span>
                                    </label>
                                    <input id="previous_applied_position" name="previous_applied_position" type="text"
                                        value="{{ old('previous_applied_position', $applicant?->previous_applied_position ?? '') }}"
                                        placeholder="Contoh: Staff HRD / Sales Officer"
                                        class="w-full px-4 py-2.5 bg-white rounded-xl border @error('previous_applied_position') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                    @error('previous_applied_position')
                                        <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="space-y-1.5">
                                    <label for="previous_applied_year" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Kapan (Tahun)? <span class="text-[#B11116]">*</span>
                                    </label>
                                    <input id="previous_applied_year" name="previous_applied_year" type="number" inputmode="numeric"
                                        min="1970" max="{{ date('Y') }}"
                                        value="{{ old('previous_applied_year', $applicant?->previous_applied_year ?? '') }}"
                                        placeholder="Contoh: {{ date('Y') - 1 }}"
                                        class="w-full px-4 py-2.5 bg-white rounded-xl border @error('previous_applied_year') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                    @error('previous_applied_year')
                                        <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-3 border-b border-gray-100 pb-4">
                        <div class="space-y-1">
                            <span class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Pernah Bekerja di PT SINAR SOSRO GUNUNG SLAMAT? <span class="text-[#B11116]">*</span>
                            </span>
                            <div class="flex items-center gap-6 py-1">
                                <label for="worked_sosro_yes" class="inline-flex items-center cursor-pointer group py-1">
                                    <input id="worked_sosro_yes" type="radio" name="has_worked_in_sosro" value="1"
                                        required
                                        {{ $selectedWorkedSosro == '1' ? 'checked' : '' }}
                                        class="w-4 h-4 text-[#B11116] border-gray-300 focus:ring-[#B11116]">
                                    <span
                                        class="ml-2 text-sm font-medium text-gray-700 group-hover:text-gray-900">Pernah</span>
                                </label>
                                <label for="worked_sosro_no" class="inline-flex items-center cursor-pointer group py-1">
                                    <input id="worked_sosro_no" type="radio" name="has_worked_in_sosro" value="0"
                                        required
                                        {{ $selectedWorkedSosro == '0' ? 'checked' : '' }}
                                        class="w-4 h-4 text-[#B11116] border-gray-300 focus:ring-[#B11116]">
                                    <span class="ml-2 text-sm font-medium text-gray-700 group-hover:text-gray-900">Belum
                                        Pernah</span>
                                </label>
                            </div>
                            @error('has_worked_in_sosro')
                                <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- CARD KONDISIONAL DETAIL SOSRO (Pengalaman ke-0 jika diisi) -->
                        <div id="sosroWorkDetailCard"
                            class="hidden p-5 bg-red-50/50 border border-red-100 rounded-xl space-y-4 transition-all">
                            <div class="flex items-center gap-2 text-[#B11116]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <h4 class="text-xs font-bold uppercase tracking-wide">Detail Pengalaman di PT SINAR SOSRO GUNUNG SLAMAT</h4>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="space-y-1.5">
                                    <label for="previous_sosro_company"
                                        class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Nama Perusahaan / Unit Kerja <span class="text-[#B11116]">*</span>
                                    </label>
                                    <input id="previous_sosro_company" name="experiences[0][company_name]" type="text"
                                        value="{{ old('experiences.0.company_name', $sosroExp?->company_name ?? 'PT SINAR SOSRO GUNUNG SLAMAT') }}"
                                        placeholder="Contoh: PT SINAR SOSRO GUNUNG SLAMAT - KBT Jakarta"
                                        class="uppercase placeholder:normal-case w-full px-4 py-2.5 bg-white rounded-xl border @error('experiences.0.company_name') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                    @error('experiences.0.company_name')
                                        <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="space-y-1.5 md:col-span-2">
                                    <label for="previous_sosro_company_address"
                                        class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Alamat Perusahaan / Unit Kerja
                                    </label>
                                    <input id="previous_sosro_company_address" name="experiences[0][company_address]" type="text"
                                        value="{{ old('experiences.0.company_address', '') }}"
                                        placeholder="Contoh: Jl. Raya Bogor KM 28, Jakarta Timur"
                                        class="uppercase placeholder:normal-case w-full px-4 py-2.5 bg-white rounded-xl border @error('experiences.0.company_address') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                    @error('experiences.0.company_address')
                                        <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="space-y-1.5">
                                    <label for="previous_sosro_company_phone"
                                        class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        No. Telepon Perusahaan / Kantor
                                    </label>
                                    <input id="previous_sosro_company_phone" name="experiences[0][company_phone]" type="tel"
                                        value="{{ old('experiences.0.company_phone', $sosroExp?->company_phone ?? '') }}"
                                        placeholder="Contoh: (021) 1234567 atau 0812345678"
                                        class="w-full px-4 py-2.5 bg-white rounded-xl border @error('experiences.0.company_phone') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                    @error('experiences.0.company_phone')
                                        <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="space-y-1.5 md:col-span-2">
                                    <label for="previous_sosro_company_address"
                                        class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Alamat Perusahaan / Kantor
                                    </label>
                                    <input id="previous_sosro_company_address" name="experiences[0][company_address]" type="text"
                                        value="{{ old('experiences.0.company_address', $sosroExp?->company_address ?? '') }}"
                                        placeholder="Contoh: Jl. Raya Sultan Agung KM 28, Bekasi"
                                        class="w-full px-4 py-2.5 bg-white rounded-xl border @error('experiences.0.company_address') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                    @error('experiences.0.company_address')
                                        <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="space-y-1.5">
                                    <label for="previous_sosro_position"
                                        class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Jabatan Terakhir <span class="text-[#B11116]">*</span>
                                    </label>
                                    <input id="previous_sosro_position" name="experiences[0][position]" type="text"
                                        value="{{ old('experiences.0.position', $sosroExp?->position ?? '') }}"
                                        placeholder="Contoh: Sales Officer"
                                        class="uppercase placeholder:normal-case w-full px-4 py-2.5 bg-white rounded-xl border @error('experiences.0.position') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                    @error('experiences.0.position')
                                        <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Tanggal Mulai Bekerja Sosro -->
                                <div class="space-y-1.5">
                                    <label for="previous_sosro_start_date"
                                        class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Tanggal Mulai Bekerja <span class="text-[#B11116]">*</span>
                                    </label>
                                    <input id="previous_sosro_start_date" name="experiences[0][start_date]"
                                        type="date"
                                        value="{{ old('experiences.0.start_date', $sosroExp?->start_date ? \Carbon\Carbon::parse($sosroExp->start_date)->format('Y-m-d') : '') }}"
                                        class="w-full px-4 py-2.5 bg-white rounded-xl border @error('experiences.0.start_date') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                    @error('experiences.0.start_date')
                                        <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Tanggal Selesai Bekerja Sosro -->
                                <div class="space-y-1.5 md:col-span-2">
                                    <div class="flex items-center justify-between">
                                        <label for="previous_sosro_end_date"
                                            class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                            Tanggal Selesai Bekerja <span class="text-[#B11116]">*</span>
                                        </label>
                                        <label class="inline-flex items-center cursor-pointer select-none">
                                            <input type="checkbox" id="sosro_is_current_job"
                                                name="experiences[0][is_current]" value="1"
                                                onchange="toggleCurrentJob(this)"
                                                {{ old('experiences.0.is_current', $sosroExp && empty($sosroExp->end_date) && !empty($sosroExp->start_date) ? '1' : '') == '1' ? 'checked' : '' }}
                                                class="is-current-job-checkbox rounded border-gray-300 text-[#B11116] focus:ring-[#B11116] w-3.5 h-3.5 cursor-pointer">
                                            <span class="ml-1.5 text-xs text-gray-600 font-semibold">Masih Bekerja Saat
                                                Ini</span>
                                        </label>
                                    </div>
                                    <input id="previous_sosro_end_date" name="experiences[0][end_date]" type="date"
                                        value="{{ old('experiences.0.end_date', $sosroExp?->end_date ? \Carbon\Carbon::parse($sosroExp->end_date)->format('Y-m-d') : '') }}"
                                        class="end-date-input w-full px-4 py-2.5 bg-white rounded-xl border @error('experiences.0.end_date') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                    @error('experiences.0.end_date')
                                        <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Bagian Referensi Sosro Terpisah -->
                                <div class="md:col-span-2 pt-2 border-t border-red-200/60">
                                    <span class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                                        Kontak Referensi (Atasan / HRD Sosro)
                                    </span>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                        <div class="space-y-1">
                                            <label for="previous_sosro_reference_name" class="block text-[11px] font-semibold text-gray-600">
                                                Nama Lengkap Referensi
                                            </label>
                                            <input id="previous_sosro_reference_name" name="experiences[0][reference_name]"
                                                type="text"
                                                value="{{ old('experiences.0.reference_name', $sosroExp?->reference_name ?? '') }}"
                                                placeholder="Contoh: Bpk. Budi Santoso"
                                                class="uppercase placeholder:normal-case w-full px-3 py-2 bg-white rounded-xl border @error('experiences.0.reference_name') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-xs transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                            @error('experiences.0.reference_name')
                                                <p class="text-[10px] text-red-600 font-medium">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="space-y-1">
                                            <label for="previous_sosro_reference_position" class="block text-[11px] font-semibold text-gray-600">
                                                Jabatan Referensi
                                            </label>
                                            <input id="previous_sosro_reference_position" name="experiences[0][reference_position]"
                                                type="text"
                                                value="{{ old('experiences.0.reference_position', $sosroExp?->reference_position ?? '') }}"
                                                placeholder="Contoh: Manager Area Sales"
                                                class="uppercase placeholder:normal-case w-full px-3 py-2 bg-white rounded-xl border @error('experiences.0.reference_position') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-xs transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                            @error('experiences.0.reference_position')
                                                <p class="text-[10px] text-red-600 font-medium">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="space-y-1">
                                            <label for="previous_sosro_reference_phone" class="block text-[11px] font-semibold text-gray-600">
                                                No. Telepon / WA Referensi
                                            </label>
                                            <input id="previous_sosro_reference_phone" name="experiences[0][reference_phone]"
                                                type="tel" inputmode="numeric"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                                value="{{ old('experiences.0.reference_phone', $sosroExp?->reference_phone ?? '') }}"
                                                placeholder="Contoh: 081234567890"
                                                class="w-full px-3 py-2 bg-white rounded-xl border @error('experiences.0.reference_phone') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-xs transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                            @error('experiences.0.reference_phone')
                                                <p class="text-[10px] text-red-600 font-medium">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Container Card Pengalaman Kerja General -->
                    <div id="experienceContainer" class="space-y-4 pt-0">
                        @php
                            $oldExperiences = old('experiences', []);
                            // Abaikan indeks 0 jika itu berasal dari form Sosro
                            if (old('has_worked_in_sosro') == '1' && isset($oldExperiences[0])) {
                                unset($oldExperiences[0]);
                            }
                            if (empty($oldExperiences)) {
                                if (isset($workExperiences) && $workExperiences->isNotEmpty()) {
                                    $oldExperiences = [];
                                    $generalExperiences = $sosroExp
                                        ? $workExperiences->filter(fn ($we) => $we->id !== $sosroExp->id)->values()
                                        : $workExperiences->values();

                                    foreach ($generalExperiences as $idx => $we) {
                                        $oldExperiences[$idx + 1] = [
                                            'company_name' => $we->company_name,
                                            'company_address' => $we->company_address,
                                            'company_phone' => $we->company_phone,
                                            'position' => $we->position,
                                            'division' => $we->division,
                                            'salary' => $we->salary ? number_format($we->salary, 0, ',', '.') : '',
                                            'start_date' => $we->start_date ? \Carbon\Carbon::parse($we->start_date)->format('Y-m-d') : '',
                                            'end_date' => $we->end_date ? \Carbon\Carbon::parse($we->end_date)->format('Y-m-d') : '',
                                            'facility' => $we->facility,
                                            'reference_name' => $we->reference_name,
                                            'reference_position' => $we->reference_position,
                                            'reference_phone' => $we->reference_phone,
                                            'reason_for_leaving' => $we->reason_for_leaving,
                                            'is_current' => empty($we->end_date) && !empty($we->start_date) ? '1' : '',
                                        ];
                                    }
                                } else {
                                    $oldExperiences = [
                                        1 => [
                                            'company_name' => '',
                                            'company_address' => '',
                                            'company_phone' => '',
                                            'position' => '',
                                            'division' => '',
                                            'salary' => '',
                                            'start_date' => '',
                                            'end_date' => '',
                                            'facility' => '',
                                            'reference_name' => '',
                                            'reference_position' => '',
                                            'reference_phone' => '',
                                            'reason_for_leaving' => '',
                                            'is_current' => '',
                                        ],
                                    ];
                                }
                            }
                        @endphp

                        @foreach ($oldExperiences as $index => $exp)
                            <div class="experience-card bg-gray-50/70 rounded-2xl p-5 md:p-6 border border-gray-200 space-y-4 relative transition-all"
                                data-index="{{ $index }}">
                                <div class="flex items-center justify-between pb-3 border-b border-gray-200/80">
                                    <div class="flex items-center gap-2">
                                        <div class="p-1.5 bg-red-100 text-[#B11116] rounded-lg">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <h3
                                            class="text-xs font-bold uppercase tracking-wider text-gray-800 card-title-label">
                                            Pengalaman Kerja Ke-{{ $loop->iteration }}
                                        </h3>
                                    </div>

                                    <button type="button" onclick="removeExperienceCard(this)"
                                        class="btn-delete-card text-red-500 hover:text-red-700 hover:bg-red-50 p-1.5 rounded-lg transition-all {{ $loop->first ? 'hidden' : '' }}"
                                        title="Hapus Pengalaman Ini">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Nama Perusahaan -->
                                    <div class="space-y-1.5">
                                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                            Nama Perusahaan
                                        </label>
                                        <input type="text" name="experiences[{{ $index }}][company_name]"
                                            value="{{ $exp['company_name'] ?? '' }}"
                                            placeholder="Contoh: PT. Maju Bersama"
                                            class="uppercase placeholder:normal-case w-full px-4 py-2.5 bg-white rounded-xl border @error("experiences.{$index}.company_name") border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                        @error("experiences.{$index}.company_name")
                                            <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Alamat Perusahaan -->
                                    <div class="space-y-1.5 md:col-span-2">
                                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                            Alamat Perusahaan
                                        </label>
                                        <input type="text" name="experiences[{{ $index }}][company_address]"
                                            value="{{ $exp['company_address'] ?? '' }}"
                                            placeholder="Contoh: Jl. Merdeka No. 1, Jakarta"
                                            class="uppercase placeholder:normal-case w-full px-4 py-2.5 bg-white rounded-xl border @error("experiences.{$index}.company_address") border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                        @error("experiences.{$index}.company_address")
                                            <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- No. Telepon Perusahaan -->
                                    <div class="space-y-1.5">
                                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                            No. Telepon Perusahaan
                                        </label>
                                        <input type="tel" name="experiences[{{ $index }}][company_phone]"
                                            value="{{ $exp['company_phone'] ?? '' }}"
                                            placeholder="Contoh: (021) 1234567 atau 0812345678"
                                            class="w-full px-4 py-2.5 bg-white rounded-xl border @error("experiences.{$index}.company_phone") border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                        @error("experiences.{$index}.company_phone")
                                            <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Alamat Perusahaan -->
                                    <div class="space-y-1.5 md:col-span-2">
                                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                            Alamat Perusahaan
                                        </label>
                                        <input type="text" name="experiences[{{ $index }}][company_address]"
                                            value="{{ $exp['company_address'] ?? '' }}"
                                            placeholder="Contoh: Jl. Jend. Sudirman No. 10, Jakarta Selatan"
                                            class="w-full px-4 py-2.5 bg-white rounded-xl border @error("experiences.{$index}.company_address") border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                        @error("experiences.{$index}.company_address")
                                            <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Jabatan / Posisi -->
                                    <div class="space-y-1.5">
                                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                            Jabatan / Posisi
                                        </label>
                                        <input type="text" name="experiences[{{ $index }}][position]"
                                            value="{{ $exp['position'] ?? '' }}" placeholder="Contoh: Staff IT Support"
                                            class="uppercase placeholder:normal-case w-full px-4 py-2.5 bg-white rounded-xl border @error("experiences.{$index}.position") border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                        @error("experiences.{$index}.position")
                                            <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Divisi -->
                                    <div class="space-y-1.5">
                                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                            Divisi / Departemen
                                        </label>
                                        <input type="text" name="experiences[{{ $index }}][division]"
                                            value="{{ $exp['division'] ?? '' }}"
                                            placeholder="Contoh: Information Technology"
                                            class="uppercase placeholder:normal-case w-full px-4 py-2.5 bg-white rounded-xl border @error("experiences.{$index}.division") border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                        @error("experiences.{$index}.division")
                                            <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Gaji Terakhir -->
                                    <div class="space-y-1.5">
                                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                            Gaji Terakhir (Rp)
                                        </label>
                                        <div class="relative">
                                            <span
                                                class="absolute inset-y-0 left-0 flex items-center pl-4 text-xs font-bold text-gray-400">Rp</span>
                                            <input type="text" inputmode="numeric"
                                                name="experiences[{{ $index }}][salary]"
                                                value="{{ $exp['salary'] ?? '' }}" placeholder="0"
                                                oninput="formatRupiahInput(this)"
                                                class="salary-input w-full pl-10 pr-4 py-2.5 bg-white rounded-xl border @error("experiences.{$index}.salary") border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                        </div>
                                        @error("experiences.{$index}.salary")
                                            <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Tanggal Mulai -->
                                    <div class="space-y-1.5">
                                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                            Tanggal Mulai Bekerja
                                        </label>
                                        <input type="date" name="experiences[{{ $index }}][start_date]"
                                            value="{{ $exp['start_date'] ?? '' }}"
                                            class="w-full px-4 py-2.5 bg-white rounded-xl border @error("experiences.{$index}.start_date") border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                        @error("experiences.{$index}.start_date")
                                            <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Tanggal Selesai -->
                                    <div class="space-y-1.5 md:col-span-2">
                                        <div class="flex items-center justify-between">
                                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                                Tanggal Selesai Bekerja
                                            </label>
                                            <label class="inline-flex items-center cursor-pointer select-none">
                                                <input type="checkbox"
                                                    name="experiences[{{ $index }}][is_current]" value="1"
                                                    onchange="toggleCurrentJob(this)"
                                                    {{ ($exp['is_current'] ?? '') == '1' ? 'checked' : '' }}
                                                    class="is-current-job-checkbox rounded border-gray-300 text-[#B11116] focus:ring-[#B11116] w-3.5 h-3.5 cursor-pointer">
                                                <span class="ml-1.5 text-xs text-gray-600 font-semibold">Masih Bekerja Saat
                                                    Ini</span>
                                            </label>
                                        </div>
                                        <input type="date" name="experiences[{{ $index }}][end_date]"
                                            value="{{ $exp['end_date'] ?? '' }}"
                                            class="end-date-input w-full px-4 py-2.5 bg-white rounded-xl border @error("experiences.{$index}.end_date") border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                        @error("experiences.{$index}.end_date")
                                            <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Fasilitas -->
                                    <div class="space-y-1.5 md:col-span-2">
                                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                            Fasilitas yang Diterima
                                        </label>
                                        <input type="text" name="experiences[{{ $index }}][facility]"
                                            value="{{ $exp['facility'] ?? '' }}"
                                            placeholder="Contoh: BPJS Kesehatan, Tunjangan Makan"
                                            class="uppercase placeholder:normal-case w-full px-4 py-2.5 bg-white rounded-xl border @error("experiences.{$index}.facility") border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                        @error("experiences.{$index}.facility")
                                            <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Kontak Referensi Terpisah -->
                                    <div class="md:col-span-2 pt-2 border-t border-gray-200/80">
                                        <span class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                                            Kontak Referensi (Atasan / HRD Perusahaan Ini)
                                        </span>
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                            <div class="space-y-1">
                                                <label class="block text-[11px] font-semibold text-gray-600">
                                                    Nama Lengkap Referensi
                                                </label>
                                                <input type="text" name="experiences[{{ $index }}][reference_name]"
                                                    value="{{ $exp['reference_name'] ?? '' }}"
                                                    placeholder="Contoh: Bpk. Hendra Gunawan"
                                                    class="uppercase placeholder:normal-case w-full px-3 py-2 bg-white rounded-xl border @error("experiences.{$index}.reference_name") border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-xs transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                                @error("experiences.{$index}.reference_name")
                                                    <p class="text-[10px] text-red-600 font-medium">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div class="space-y-1">
                                                <label class="block text-[11px] font-semibold text-gray-600">
                                                    Jabatan Referensi
                                                </label>
                                                <input type="text" name="experiences[{{ $index }}][reference_position]"
                                                    value="{{ $exp['reference_position'] ?? '' }}"
                                                    placeholder="Contoh: Manager Operasional"
                                                    class="uppercase placeholder:normal-case w-full px-3 py-2 bg-white rounded-xl border @error("experiences.{$index}.reference_position") border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-xs transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                                @error("experiences.{$index}.reference_position")
                                                    <p class="text-[10px] text-red-600 font-medium">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div class="space-y-1">
                                                <label class="block text-[11px] font-semibold text-gray-600">
                                                    No. Telepon / WA Referensi
                                                </label>
                                                <input type="tel" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '');" name="experiences[{{ $index }}][reference_phone]"
                                                    value="{{ $exp['reference_phone'] ?? '' }}"
                                                    placeholder="Contoh: 081234567890"
                                                    class="w-full px-3 py-2 bg-white rounded-xl border @error("experiences.{$index}.reference_phone") border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-xs transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                                @error("experiences.{$index}.reference_phone")
                                                    <p class="text-[10px] text-red-600 font-medium">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Alasan Berhenti -->
                                    <div class="space-y-1.5 md:col-span-2">
                                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                            Alasan Berhenti
                                        </label>
                                        <input type="text" name="experiences[{{ $index }}][reason_for_leaving]"
                                            value="{{ $exp['reason_for_leaving'] ?? '' }}"
                                            placeholder="Contoh: Kontrak kerja berakhir / Ingin mengembangkan karir"
                                            class="uppercase placeholder:normal-case reason-leaving-input w-full px-4 py-2.5 bg-white rounded-xl border @error("experiences.{$index}.reason_for_leaving") border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                        @error("experiences.{$index}.reason_for_leaving")
                                            <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Tombol Tambah Card Pengalaman -->
                    <div class="flex justify-start">
                        <button type="button" id="btnAddExperience" onclick="addExperienceCard()"
                            class="inline-flex items-center gap-2 px-4 py-2.5 bg-red-50 hover:bg-red-100 text-[#B11116] rounded-xl text-xs font-bold transition-all active:scale-95 cursor-pointer shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            Tambah Pengalaman Kerja
                        </button>
                    </div>

                    <!-- Actions Bottom -->
                    <div class="pt-8 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4 mt-8">
                        <div class="flex items-center gap-3 w-full sm:w-auto">
                            <a href="{{ route('biodata.education.create') }}"
                                class="w-full sm:w-auto px-6 py-3 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 font-bold text-sm rounded-xl transition-all inline-flex items-center justify-center gap-2 cursor-pointer">
                                Kembali ke Langkah 3
                            </a>
                        </div>

                        <button type="submit" id="btnSubmit"
                            class="w-full sm:w-auto px-8 py-3 bg-[#B11116] hover:bg-red-800 text-white font-bold text-sm rounded-xl shadow-md transition-all flex items-center justify-center gap-2 cursor-pointer focus:ring-4 focus:ring-red-200 disabled:opacity-50 disabled:cursor-not-allowed active:scale-95">
                            <span id="btnText">Selesai & Simpan Biodata</span>
                            <span id="btnLoadingText" class="hidden flex items-center gap-2">
                                <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                Menyimpan...
                            </span>
                            <svg id="btnArrow" class="w-4 h-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </button>
                    </div>

                </div>
            </div>
        </form>
    </div>

    <!-- Template JS untuk Tambah Card Pengalaman -->
    <template id="experienceCardTemplate">
        <div class="experience-card bg-gray-50/70 rounded-2xl p-5 md:p-6 border border-gray-200 space-y-4 relative transition-all"
            data-index="{INDEX}">
            <div class="flex items-center justify-between pb-3 border-b border-gray-200/80">
                <div class="flex items-center gap-2">
                    <div class="p-1.5 bg-red-100 text-[#B11116] rounded-lg">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-gray-800 card-title-label">
                        Pengalaman Kerja Ke-{NUMBER}
                    </h3>
                </div>

                <button type="button" onclick="removeExperienceCard(this)"
                    class="btn-delete-card text-red-500 hover:text-red-700 hover:bg-red-50 p-1.5 rounded-lg transition-all"
                    title="Hapus Pengalaman Ini">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Nama Perusahaan</label>
                    <input type="text" name="experiences[{INDEX}][company_name]" placeholder="Contoh: PT. Sinar Sosro"
                        class="uppercase placeholder:normal-case w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">No. Telepon Perusahaan</label>
                    <input type="tel" name="experiences[{INDEX}][company_phone]" placeholder="Contoh: (021) 1234567 atau 0812345678"
                        class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                </div>

                <div class="space-y-1.5 md:col-span-2">
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Alamat Perusahaan</label>
                    <input type="text" name="experiences[{INDEX}][company_address]" placeholder="Contoh: Jl. Jend. Sudirman No. 10, Jakarta Selatan"
                        class="uppercase placeholder:normal-case w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Jabatan / Posisi</label>
                    <input type="text" name="experiences[{INDEX}][position]" placeholder="Contoh: Staff IT Support"
                        class="uppercase placeholder:normal-case w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Divisi /
                        Departemen</label>
                    <input type="text" name="experiences[{INDEX}][division]"
                        placeholder="Contoh: Information Technology"
                        class="uppercase placeholder:normal-case w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                </div>

                <div class="space-y-1.5 md:col-span-2">
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Gaji Terakhir
                        (Rp)</label>
                    <div class="relative">
                        <span
                            class="absolute inset-y-0 left-0 flex items-center pl-4 text-xs font-bold text-gray-400">Rp</span>
                        <input type="text" inputmode="numeric" name="experiences[{INDEX}][salary]" placeholder="0"
                            oninput="formatRupiahInput(this)"
                            class="salary-input w-full pl-10 pr-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Tanggal Mulai
                        Bekerja</label>
                    <input type="date" name="experiences[{INDEX}][start_date]"
                        class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                </div>

                <div class="space-y-1.5 md:col-span-2">
                    <div class="flex items-center justify-between">
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Tanggal Selesai
                            Bekerja</label>
                        <label class="inline-flex items-center cursor-pointer select-none">
                            <input type="checkbox" name="experiences[{INDEX}][is_current]" value="1"
                                onchange="toggleCurrentJob(this)"
                                class="is-current-job-checkbox rounded border-gray-300 text-[#B11116] focus:ring-[#B11116] w-3.5 h-3.5 cursor-pointer">
                            <span class="ml-1.5 text-xs text-gray-600 font-semibold">Masih Bekerja Saat Ini</span>
                        </label>
                    </div>
                    <input type="date" name="experiences[{INDEX}][end_date]"
                        class="end-date-input w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                </div>

                <div class="space-y-1.5 md:col-span-2">
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Fasilitas yang
                        Diterima</label>
                    <input type="text" name="experiences[{INDEX}][facility]"
                        placeholder="Contoh: BPJS Kesehatan, Tunjangan Makan"
                        class="uppercase placeholder:normal-case w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                </div>

                <!-- Kontak Referensi Terpisah -->
                <div class="md:col-span-2 pt-2 border-t border-gray-200/80">
                    <span class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                        Kontak Referensi (Atasan / HRD Perusahaan Ini)
                    </span>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        <div class="space-y-1">
                            <label class="block text-[11px] font-semibold text-gray-600">
                                Nama Lengkap Referensi
                            </label>
                            <input type="text" name="experiences[{INDEX}][reference_name]"
                                placeholder="Contoh: Bpk. Hendra Gunawan"
                                class="uppercase placeholder:normal-case w-full px-3 py-2 bg-white rounded-xl border border-gray-300 text-gray-900 text-xs transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-[11px] font-semibold text-gray-600">
                                Jabatan Referensi
                            </label>
                            <input type="text" name="experiences[{INDEX}][reference_position]"
                                placeholder="Contoh: Manager Operasional"
                                class="uppercase placeholder:normal-case w-full px-3 py-2 bg-white rounded-xl border border-gray-300 text-gray-900 text-xs transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-[11px] font-semibold text-gray-600">
                                No. Telepon / WA Referensi
                            </label>
                            <input type="tel" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '');" name="experiences[{INDEX}][reference_phone]"
                                placeholder="Contoh: 081234567890"
                                class="w-full px-3 py-2 bg-white rounded-xl border border-gray-300 text-gray-900 text-xs transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                        </div>
                    </div>
                </div>

                <div class="space-y-1.5 md:col-span-2">
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Alasan Berhenti</label>
                    <input type="text" name="experiences[{INDEX}][reason_for_leaving]"
                        placeholder="Contoh: Kontrak kerja berakhir / Ingin mengembangkan karir"
                        class="uppercase placeholder:normal-case reason-leaving-input w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                </div>
            </div>
        </div>
    </template>

    <script>
        function goToStep(step) {
            const redirectInput = document.getElementById('redirect_step');
            if (redirectInput) {
                redirectInput.value = step;
            }

            const experienceForm = document.getElementById('experienceForm');
            if (experienceForm) {
                if (experienceForm.reportValidity && !experienceForm.reportValidity()) {
                    return;
                }
                document.querySelectorAll('.salary-input').forEach(input => {
                    input.value = input.value.replace(/[^0-9]/g, '');
                });
                experienceForm.submit();
            }
        }

        /* Format Rupiah Input */
        function formatRupiahInput(input) {
            let value = input.value.replace(/[^0-9]/g, '');
            if (value) {
                input.value = new Intl.NumberFormat('id-ID').format(value);
            } else {
                input.value = '';
            }
        }

        /* Sync State Kunci Checkbox 'Masih Bekerja Saat Ini' secara global */
        function updateGlobalCurrentJobCheckboxes() {
            const allCheckboxes = document.querySelectorAll('.is-current-job-checkbox');
            const activeChecked = Array.from(allCheckboxes).find(cb => cb.checked);

            allCheckboxes.forEach(cb => {
                if (activeChecked) {
                    if (!cb.checked) {
                        cb.disabled = true;
                        cb.closest('label').classList.add('opacity-50', 'cursor-not-allowed');
                    }
                } else {
                    cb.disabled = false;
                    cb.closest('label').classList.remove('opacity-50', 'cursor-not-allowed');
                }
            });
        }

        /* Toggle Kunci Tanggal Selesai & Alasan Berhenti */
        function toggleCurrentJob(checkbox) {
            let endDateInput = null;
            let reasonInput = null;

            // Jika checkbox berada di form Rekso/Sosro
            if (checkbox.id === 'sosro_is_current_job') {
                endDateInput = document.getElementById('previous_sosro_end_date');
            } else { // Jika checkbox berada di kartu Pengalaman Kerja
                const card = checkbox.closest('.experience-card');
                if (card) {
                    endDateInput = card.querySelector('.end-date-input');
                    reasonInput = card.querySelector('.reason-leaving-input');
                }
            }

            if (checkbox.checked) {
                if (endDateInput) {
                    endDateInput.dataset.previousValue = endDateInput.value;
                    endDateInput.value = '';
                    endDateInput.disabled = true;
                    endDateInput.classList.add('bg-gray-100', 'text-gray-400', 'cursor-not-allowed');
                }
            } else {
                if (endDateInput) {
                    endDateInput.value = endDateInput.dataset.previousValue || '';
                    endDateInput.disabled = false;
                    endDateInput.classList.remove('bg-gray-100', 'text-gray-400', 'cursor-not-allowed');
                }
            }

            updateGlobalCurrentJobCheckboxes();
        }

        /* Cek dan update visibilitas tombol Tambah Pengalaman (Maksimal total 3) */
        function updateAddButtonVisibility() {
            const workedSosroYes = document.getElementById('worked_sosro_yes');
            const isSosroActive = workedSosroYes && workedSosroYes.checked;
            // Jika pernah kerja di Sosro (1 slot terpakai), sisa kuota pengalaman luar adalah 2.
            // Jika belum pernah kerja di Sosro, kuota pengalaman luar adalah 3.
            const maxDynamic = isSosroActive ? 2 : 3;
            const currentDynamicCount = document.querySelectorAll('#experienceContainer .experience-card').length;
            const btnAdd = document.getElementById('btnAddExperience');

            if (btnAdd) {
                if (currentDynamicCount >= maxDynamic) {
                    btnAdd.style.display = 'none';
                } else {
                    btnAdd.style.display = 'inline-flex';
                }
            }
        }

        /* Hitung total card aktif dan tentukan index awal baru */
        function getNextExperienceIndex() {
            const workedSosroYes = document.getElementById('worked_sosro_yes');
            const isSosroActive = workedSosroYes && workedSosroYes.checked;
            const dynamicCardsCount = document.querySelectorAll('#experienceContainer .experience-card').length;

            return isSosroActive ? dynamicCardsCount + 1 : dynamicCardsCount;
        }

        /* Tambah Card Pengalaman */
        function addExperienceCard() {
            const workedSosroYes = document.getElementById('worked_sosro_yes');
            const isSosroActive = workedSosroYes && workedSosroYes.checked;
            const maxDynamic = isSosroActive ? 2 : 3;
            const currentDynamicCount = document.querySelectorAll('#experienceContainer .experience-card').length;

            if (currentDynamicCount >= maxDynamic) {
                return;
            }

            const container = document.getElementById('experienceContainer');
            const template = document.getElementById('experienceCardTemplate').innerHTML;
            const nextIndex = getNextExperienceIndex();
            const totalDisplayNumber = document.querySelectorAll('.experience-card').length + 1;

            const newCardHtml = template
                .replace(/{INDEX}/g, nextIndex)
                .replace(/{NUMBER}/g, totalDisplayNumber);

            container.insertAdjacentHTML('beforeend', newCardHtml);
            reindexExperienceCards();
            updateGlobalCurrentJobCheckboxes();
            updateAddButtonVisibility();
        }

        /* Hapus Card Pengalaman */
        function removeExperienceCard(button) {
            const card = button.closest('.experience-card');
            if (card) {
                card.remove();
                reindexExperienceCards();
                updateGlobalCurrentJobCheckboxes();
                updateAddButtonVisibility();
            }
        }

        /* Sinkronisasi Index Array setelah Tambah/Hapus */
        function reindexExperienceCards() {
            const workedSosroYes = document.getElementById('worked_sosro_yes');
            const isSosroActive = workedSosroYes && workedSosroYes.checked;
            let startIndex = isSosroActive ? 1 : 0;

            const cards = document.querySelectorAll('#experienceContainer .experience-card');
            cards.forEach((card, idx) => {
                const currentIndex = startIndex + idx;
                card.setAttribute('data-index', currentIndex);

                const titleLabel = card.querySelector('.card-title-label');
                if (titleLabel) {
                    const displayNum = isSosroActive ? idx + 2 : idx + 1;
                    titleLabel.textContent = `Pengalaman Kerja Ke-${displayNum}`;
                }

                const deleteBtn = card.querySelector('.btn-delete-card');
                if (deleteBtn) {
                    if (idx === 0 && !isSosroActive) {
                        deleteBtn.classList.add('hidden');
                    } else {
                        deleteBtn.classList.remove('hidden');
                    }
                }

                const inputs = card.querySelectorAll('input, select');
                inputs.forEach(input => {
                    if (input.name) {
                        input.name = input.name.replace(/experiences\[\d+\]/,
                            `experiences[${currentIndex}]`);
                    }
                });
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            // TOGGLE PENGALAMAN KERJA DI SOSRO
            const workedSosroYes = document.getElementById('worked_sosro_yes');
            const workedSosroNo = document.getElementById('worked_sosro_no');
            const sosroCard = document.getElementById('sosroWorkDetailCard');
            const previousSosroCompany = document.getElementById('previous_sosro_company');
            const previousSosroPosition = document.getElementById('previous_sosro_position');
            const previousSosroStartDate = document.getElementById('previous_sosro_start_date');
            const previousSosroEndDate = document.getElementById('previous_sosro_end_date');

            function toggleSosroDetails() {
                if (workedSosroYes && workedSosroYes.checked) {
                    sosroCard.classList.remove('hidden');
                    previousSosroCompany.setAttribute('required', 'required');
                    previousSosroPosition.setAttribute('required', 'required');
                    previousSosroStartDate.setAttribute('required', 'required');
                    previousSosroEndDate.setAttribute('required', 'required');
                } else {
                    sosroCard.classList.add('hidden');
                    previousSosroCompany.removeAttribute('required');
                    previousSosroPosition.removeAttribute('required');
                    previousSosroStartDate.removeAttribute('required');
                    previousSosroEndDate.removeAttribute('required');
                    previousSosroCompany.value = '';
                    previousSosroPosition.value = '';
                    previousSosroStartDate.value = '';
                    previousSosroEndDate.value = '';

                    const sosroCurrentCb = document.getElementById('sosro_is_current_job');
                    if (sosroCurrentCb && sosroCurrentCb.checked) {
                        sosroCurrentCb.checked = false;
                        toggleCurrentJob(sosroCurrentCb);
                    }
                }
                // Jika user memilih Sosro dan kartu dinamis melebihi kuota (maks 2), hapus kartu berlebih dari belakang
                if (workedSosroYes && workedSosroYes.checked) {
                    let dynamicCards = document.querySelectorAll('#experienceContainer .experience-card');
                    while (dynamicCards.length > 2) {
                        dynamicCards[dynamicCards.length - 1].remove();
                        dynamicCards = document.querySelectorAll('#experienceContainer .experience-card');
                    }
                }
                reindexExperienceCards();
                updateAddButtonVisibility();
            }

            if (workedSosroYes && workedSosroNo) {
                workedSosroYes.addEventListener('change', toggleSosroDetails);
                workedSosroNo.addEventListener('change', toggleSosroDetails);
                toggleSosroDetails();
            }

            // TOGGLE PERNAH MELAMAR DI SOSRO
            const appliedSosroYes = document.getElementById('applied_sosro_yes');
            const appliedSosroNo = document.getElementById('applied_sosro_no');
            const appliedDetailCard = document.getElementById('appliedSosroDetailCard');
            const prevAppliedPosition = document.getElementById('previous_applied_position');
            const prevAppliedYear = document.getElementById('previous_applied_year');

            function toggleAppliedSosro() {
                if (appliedSosroYes && appliedSosroYes.checked) {
                    if (appliedDetailCard) appliedDetailCard.classList.remove('hidden');
                    if (prevAppliedPosition) prevAppliedPosition.setAttribute('required', 'required');
                    if (prevAppliedYear) prevAppliedYear.setAttribute('required', 'required');
                } else {
                    if (appliedDetailCard) appliedDetailCard.classList.add('hidden');
                    if (prevAppliedPosition) {
                        prevAppliedPosition.removeAttribute('required');
                        prevAppliedPosition.value = '';
                    }
                    if (prevAppliedYear) {
                        prevAppliedYear.removeAttribute('required');
                        prevAppliedYear.value = '';
                    }
                }
            }

            if (appliedSosroYes && appliedSosroNo) {
                appliedSosroYes.addEventListener('change', toggleAppliedSosro);
                appliedSosroNo.addEventListener('change', toggleAppliedSosro);
                toggleAppliedSosro();
            }

            updateAddButtonVisibility();

            // Inisialisasi Format Rupiah untuk input Gaji yang sudah terisi
            document.querySelectorAll('.salary-input').forEach(input => {
                if (input.value) {
                    formatRupiahInput(input);
                }
            });

            // Inisialisasi awal centang & kunci status pekerjaan
            document.querySelectorAll('.is-current-job-checkbox').forEach(cb => {
                if (cb.checked) {
                    toggleCurrentJob(cb);
                }
            });
            updateGlobalCurrentJobCheckboxes();

            // SUBMIT FORM HANDLING
            const experienceForm = document.getElementById('experienceForm');
            const btnSubmit = document.getElementById('btnSubmit');
            const btnText = document.getElementById('btnText');
            const btnLoadingText = document.getElementById('btnLoadingText');
            const btnArrow = document.getElementById('btnArrow');

            if (experienceForm && btnSubmit) {
                experienceForm.addEventListener('submit', function() {
                    // Clean format Rupiah menjadi integer murni sebelum disubmit ke backend
                    document.querySelectorAll('.salary-input').forEach(input => {
                        input.value = input.value.replace(/[^0-9]/g, '');
                    });

                    btnSubmit.disabled = true;
                    if (btnText) btnText.classList.add('hidden');
                    if (btnArrow) btnArrow.classList.add('hidden');
                    if (btnLoadingText) btnLoadingText.classList.remove('hidden');
                });
            }
        });
    </script>
@endsection
