@extends('auth.applicant.layouts.index')

@section('title', 'Data Pendidikan & Pelatihan Pelamar')

@section('content')
    <div class="py-8 md:py-12 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto font-figtree">
        <div class="mb-6 flex items-center justify-end">
            <span class="text-xs font-medium text-gray-400">Langkah 3 dari 4</span>
        </div>

        <!-- Wizard Progress Bar -->
        <div class="mb-10">
            <ol class="flex items-center w-full text-xs font-semibold">
                <!-- Step 1: Data Personal -->
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

                <!-- Step 2: Keluarga -->
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

                <!-- Step 3: Pendidikan (Aktif) -->
                <li class="flex items-center text-[#B11116]">
                    <span
                        class="flex items-center justify-center w-8 h-8 rounded-full border-2 border-[#B11116] bg-red-50 text-[#B11116] font-bold mr-2 shadow-sm text-xs ring-4 ring-red-100">
                        3
                    </span>
                    <span class="font-bold">Pendidikan</span>
                </li>

                <li class="flex-1 border-t-2 border-gray-200 mx-2 sm:mx-4"></li>

                <!-- Step 4: Pengalaman Kerja -->
                <li>
                    <button type="button" onclick="goToStep('workExperience')"
                        title="Simpan data saat ini & lanjut ke Pengalaman Kerja"
                        class="flex items-center text-gray-400 hover:text-gray-600 transition-colors cursor-pointer group focus:outline-none">
                        <span
                            class="flex items-center justify-center w-8 h-8 rounded-full border-2 border-gray-200 bg-white font-bold mr-2 text-xs group-hover:border-gray-400">
                            4
                        </span>
                        <span class="hidden sm:inline font-semibold">Pengalaman</span>
                    </button>
                </li>
            </ol>
        </div>

        <form id="educationForm" action="{{ route('biodata.education.store') }}" method="POST" class="space-y-8">
            @csrf
            <input type="hidden" name="redirect_step" id="redirect_step" value="workExperience">

            <!-- BAGIAN 1: RIWAYAT PENDIDIKAN FORMAL -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 md:p-8">
                <div class="space-y-6">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-gray-100 gap-4">
                        <div>
                            <h2 class="text-lg font-bold text-gray-900 tracking-tight flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-[#B11116]"></span>
                                Riwayat Pendidikan Formal
                            </h2>
                            <p class="text-xs text-gray-500 mt-1">
                                Cantumkan riwayat pendidikan formal Anda, dimulai dari pendidikan terakhir.
                            </p>
                        </div>
                        <button type="button" onclick="addEducationCard()"
                            class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-red-50 text-[#B11116] hover:bg-red-100 font-bold rounded-xl text-xs transition-colors cursor-pointer border border-red-200/60 shadow-xs self-start sm:self-auto">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Tambah Pendidikan
                        </button>
                    </div>

                    @error('educations')
                        <div class="p-3 bg-red-50 border border-red-200 rounded-xl text-red-600 text-xs font-semibold">
                            {{ $message }}
                        </div>
                    @enderror

                    <!-- Container Card Pendidikan -->
                    <div id="educationContainer" class="space-y-6">
                        @php
                            $oldEducations = old('educations');
                            if (empty($oldEducations)) {
                                if (isset($educations) && $educations->isNotEmpty()) {
                                    $oldEducations = $educations->map(function ($edu) {
                                        return [
                                            'degree_level' => $edu->degree_level,
                                            'institution_name' => $edu->institution_name,
                                            'city' => $edu->city ?? '',
                                            'major' => $edu->major,
                                            'gpa' => $edu->gpa,
                                            'entry_year' => $edu->entry_year,
                                            'graduation_year' => $edu->graduation_year,
                                        ];
                                    })->toArray();
                                } else {
                                    $oldEducations = [
                                        [
                                            'degree_level' => '',
                                            'institution_name' => '',
                                            'city' => '',
                                            'major' => '',
                                            'gpa' => '',
                                            'entry_year' => '',
                                            'graduation_year' => '',
                                        ],
                                    ];
                                }
                            }
                        @endphp

                        @foreach ($oldEducations as $index => $edu)
                            <div class="education-card bg-gray-50/70 rounded-2xl p-5 md:p-6 border border-gray-200 space-y-4 relative transition-all"
                                data-index="{{ $index }}">
                                <div class="flex items-center justify-between pb-3 border-b border-gray-200/80">
                                    <div class="flex items-center gap-2">
                                        <div class="p-1.5 bg-red-100 text-[#B11116] rounded-lg">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 14l9-5-9-5-9 5 9 5z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                            </svg>
                                        </div>
                                        <h3 class="text-xs font-bold uppercase tracking-wider text-gray-800 card-title-label">
                                            {{ $index === 0 ? 'Pendidikan Terakhir' : 'Pendidikan Ke-' . ($index + 1) }}
                                        </h3>
                                        @if ($index === 0)
                                            <span class="text-[#B11116] font-bold text-xs">*</span>
                                        @endif
                                    </div>

                                    <button type="button" onclick="removeEducationCard(this)"
                                        class="btn-delete-card text-red-500 hover:text-red-700 hover:bg-red-50 p-1.5 rounded-lg transition-all {{ $index === 0 ? 'hidden' : '' }}"
                                        title="Hapus Pendidikan Ini">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Jenjang Pendidikan -->
                                    <div class="space-y-1.5">
                                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                            Jenjang Pendidikan <span class="text-[#B11116]">*</span>
                                        </label>
                                        <select name="educations[{{ $index }}][degree_level]" required
                                            class="w-full px-4 py-2.5 bg-white rounded-xl border @error("educations.{$index}.degree_level") border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                            <option value="" disabled {{ empty($edu['degree_level']) ? 'selected' : '' }}>
                                                Pilih Jenjang
                                            </option>
                                            @if (isset($educationTypes) && $educationTypes->isNotEmpty())
                                                @foreach ($educationTypes as $etype)
                                                    @php
                                                        $val = $etype->EDUTYPE_NAME_ID ?? $etype->EDUTYPE_NAME_EN;
                                                    @endphp
                                                    <option value="{{ $val }}"
                                                        {{ ($edu['degree_level'] ?? '') == $val ? 'selected' : '' }}>
                                                        {{ $val }} ({{ $etype->EDUTYPE_NAME_EN }})
                                                    </option>
                                                @endforeach
                                            @else
                                                <option value="SMA" {{ ($edu['degree_level'] ?? '') == 'SMA' ? 'selected' : '' }}>SMA</option>
                                                <option value="STM" {{ ($edu['degree_level'] ?? '') == 'STM' ? 'selected' : '' }}>STM</option>
                                                <option value="Diploma" {{ ($edu['degree_level'] ?? '') == 'Diploma' ? 'selected' : '' }}>Diploma</option>
                                                <option value="Sarjana" {{ ($edu['degree_level'] ?? '') == 'Sarjana' ? 'selected' : '' }}>Sarjana</option>
                                                <option value="Master/S2" {{ ($edu['degree_level'] ?? '') == 'Master/S2' ? 'selected' : '' }}>Master/S2</option>
                                                <option value="Doctor" {{ ($edu['degree_level'] ?? '') == 'Doctor' ? 'selected' : '' }}>Doctor</option>
                                                <option value="Lain-lain" {{ ($edu['degree_level'] ?? '') == 'Lain-lain' ? 'selected' : '' }}>Lain-lain</option>
                                            @endif
                                        </select>
                                        @error("educations.{$index}.degree_level")
                                            <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Nama Sekolah / Universitas (Combobox with Other) -->
                                    <div class="space-y-1.5 school-combobox-wrapper" data-field="school">
                                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                            Nama Sekolah / Universitas <span class="text-[#B11116]">*</span>
                                        </label>
                                        <div class="relative">
                                            <input type="text"
                                                class="combobox-search-input w-full px-4 py-2.5 bg-white rounded-xl border @error("educations.{$index}.institution_name") border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm"
                                                placeholder="Ketik untuk mencari sekolah / universitas..."
                                                autocomplete="off"
                                                value="{{ $edu['institution_name'] ?? '' }}"
                                                onfocus="openCombobox(this)"
                                                oninput="filterCombobox(this, 'school')">

                                            <!-- Hidden Actual Input -->
                                            <input type="hidden"
                                                name="educations[{{ $index }}][institution_name]"
                                                class="combobox-value-input"
                                                value="{{ $edu['institution_name'] ?? '' }}"
                                                required>

                                            <!-- Dropdown Menu -->
                                            <div class="combobox-dropdown absolute left-0 right-0 top-full mt-1.5 bg-white border border-gray-200 rounded-xl shadow-xl z-50 max-h-60 overflow-y-auto hidden">
                                                <div class="combobox-other-option p-3 bg-red-50/70 hover:bg-red-100/80 cursor-pointer border-b border-red-100 text-[#B11116] font-bold text-xs flex items-center gap-2"
                                                    onclick="selectOtherCombobox(this, 'school')">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                    </svg>
                                                    <span>Lainnya / Tidak Terdaftar di List (Input Manual)</span>
                                                </div>
                                                <ul class="combobox-list divide-y divide-gray-50 text-sm text-gray-800">
                                                    <!-- Dynamic options -->
                                                </ul>
                                            </div>
                                        </div>

                                        <!-- Container Input Manual Sekolah jika Other -->
                                        <div class="manual-school-input-wrapper space-y-1.5 pt-1 hidden">
                                            <span class="text-[11px] text-amber-700 bg-amber-50 px-2 py-0.5 rounded font-medium inline-block">Mode Input Manual Sekolah</span>
                                            <input type="text"
                                                class="manual-school-input w-full px-4 py-2 bg-amber-50/30 rounded-xl border border-amber-300 text-gray-900 text-sm focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none"
                                                placeholder="Ketik nama lengkap sekolah / universitas..."
                                                value="{{ $edu['institution_name'] ?? '' }}"
                                                oninput="syncManualValue(this, 'school')">
                                        </div>

                                        @error("educations.{$index}.institution_name")
                                            <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Kota / Kabupaten Sekolah (Wajib diisi) -->
                                    <div class="space-y-1.5">
                                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                            Kota / Kabupaten Sekolah <span class="text-[#B11116]">*</span>
                                        </label>
                                        <input type="text" name="educations[{{ $index }}][city]" required
                                            value="{{ $edu['city'] ?? '' }}"
                                            placeholder="Contoh: Jakarta Selatan, Surabaya, Kab. Slawi"
                                            class="w-full px-4 py-2.5 bg-white rounded-xl border @error("educations.{$index}.city") border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                        @error("educations.{$index}.city")
                                            <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Jurusan (Combobox with Other) -->
                                    <div class="space-y-1.5 major-combobox-wrapper" data-field="major">
                                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                            Jurusan / Program Studi <span class="text-[#B11116]">*</span>
                                        </label>
                                        <div class="relative">
                                            <input type="text"
                                                class="combobox-search-input w-full px-4 py-2.5 bg-white rounded-xl border @error("educations.{$index}.major") border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm"
                                                placeholder="Ketik untuk mencari jurusan..."
                                                autocomplete="off"
                                                value="{{ $edu['major'] ?? '' }}"
                                                onfocus="openCombobox(this)"
                                                oninput="filterCombobox(this, 'major')">

                                            <!-- Hidden Actual Input -->
                                            <input type="hidden"
                                                name="educations[{{ $index }}][major]"
                                                class="combobox-value-input"
                                                value="{{ $edu['major'] ?? '' }}"
                                                required>

                                            <!-- Dropdown Menu -->
                                            <div class="combobox-dropdown absolute left-0 right-0 top-full mt-1.5 bg-white border border-gray-200 rounded-xl shadow-xl z-50 max-h-60 overflow-y-auto hidden">
                                                <div class="combobox-other-option p-3 bg-red-50/70 hover:bg-red-100/80 cursor-pointer border-b border-red-100 text-[#B11116] font-bold text-xs flex items-center gap-2"
                                                    onclick="selectOtherCombobox(this, 'major')">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                    </svg>
                                                    <span>Lainnya / Tidak Terdaftar di List (Input Manual)</span>
                                                </div>
                                                <ul class="combobox-list divide-y divide-gray-50 text-sm text-gray-800">
                                                    <!-- Dynamic options -->
                                                </ul>
                                            </div>
                                        </div>

                                        <!-- Container Input Manual Jurusan jika Other -->
                                        <div class="manual-major-input-wrapper space-y-1.5 pt-1 hidden">
                                            <span class="text-[11px] text-amber-700 bg-amber-50 px-2 py-0.5 rounded font-medium inline-block">Mode Input Manual Jurusan</span>
                                            <input type="text"
                                                class="manual-major-input w-full px-4 py-2 bg-amber-50/30 rounded-xl border border-amber-300 text-gray-900 text-sm focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none"
                                                placeholder="Ketik nama lengkap jurusan / program studi..."
                                                value="{{ $edu['major'] ?? '' }}"
                                                oninput="syncManualValue(this, 'major')">
                                        </div>

                                        @error("educations.{$index}.major")
                                            <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- IPK / Nilai Rata-rata -->
                                    <div class="space-y-1.5">
                                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                            IPK / Nilai Rata-rata <span class="text-[#B11116]">*</span>
                                        </label>
                                        <input type="number" step="0.01" min="0" max="100"
                                            name="educations[{{ $index }}][gpa]" required
                                            value="{{ $edu['gpa'] ?? '' }}" placeholder="Contoh: 3.75 atau 85.50"
                                            class="w-full px-4 py-2.5 bg-white rounded-xl border @error("educations.{$index}.gpa") border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                        <span class="text-[11px] text-gray-400 block">Gunakan skala 4.00 untuk PT atau
                                            100.00 untuk SMA.</span>
                                        @error("educations.{$index}.gpa")
                                            <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Tahun Masuk -->
                                    <div class="space-y-1.5">
                                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                            Tahun Masuk <span class="text-[#B11116]">*</span>
                                        </label>
                                        <input type="number" min="1970" max="{{ date('Y') }}"
                                            name="educations[{{ $index }}][entry_year]" required
                                            value="{{ $edu['entry_year'] ?? '' }}" placeholder="Contoh: 2020"
                                            class="w-full px-4 py-2.5 bg-white rounded-xl border @error("educations.{$index}.entry_year") border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                        @error("educations.{$index}.entry_year")
                                            <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Tahun Lulus -->
                                    <div class="space-y-1.5">
                                        <div class="flex items-center justify-between">
                                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                                Tahun Lulus <span class="text-[#B11116]">*</span>
                                            </label>
                                            <label class="inline-flex items-center cursor-pointer select-none">
                                                <input type="checkbox" onchange="toggleCurrentStudy(this)"
                                                    class="is-current-checkbox rounded border-gray-300 text-[#B11116] focus:ring-[#B11116] w-3.5 h-3.5 cursor-pointer disabled:opacity-40 disabled:cursor-not-allowed">
                                                <span class="ml-1.5 text-xs text-gray-600 font-semibold label-current-study">Masih Studi Saat Ini</span>
                                            </label>
                                        </div>
                                        <input type="number" min="1970" max="{{ date('Y') + 10 }}"
                                            name="educations[{{ $index }}][graduation_year]" required
                                            value="{{ $edu['graduation_year'] ?? '' }}" placeholder="Contoh: 2024"
                                            class="graduation-year-input w-full px-4 py-2.5 bg-white rounded-xl border @error("educations.{$index}.graduation_year") border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                        @error("educations.{$index}.graduation_year")
                                            <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- BAGIAN 2: PELATIHAN & KURSUS -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 md:p-8">
                <div class="space-y-6">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-gray-100 gap-4">
                        <div>
                            <h2 class="text-lg font-bold text-gray-900 tracking-tight flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-[#B11116]"></span>
                                Pelatihan / Kursus / Sertifikasi
                            </h2>
                            <p class="text-xs text-gray-500 mt-1">
                                Bagian ini bersifat opsional. Kosongkan jika Anda belum pernah mengikuti pelatihan atau kursus.
                            </p>
                        </div>
                        <button type="button" onclick="addTrainingCard()"
                            class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-red-50 text-[#B11116] hover:bg-red-100 font-bold rounded-xl text-xs transition-colors cursor-pointer border border-red-200/60 shadow-xs self-start sm:self-auto">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Tambah Pelatihan
                        </button>
                    </div>

                    <!-- Container Card Pelatihan -->
                    <div id="trainingContainer" class="space-y-6">
                        @php
                            $oldTrainings = old('trainings');
                            if ($oldTrainings === null) {
                                if (isset($trainings) && $trainings->isNotEmpty()) {
                                    $oldTrainings = $trainings->map(function ($tr) {
                                        return [
                                            'training_name' => $tr->training_name,
                                            'organizer' => $tr->organizer,
                                            'finished' => $tr->finished ? \Carbon\Carbon::parse($tr->finished)->format('Y-m-d') : '',
                                        ];
                                    })->toArray();
                                } else {
                                    $oldTrainings = [];
                                }
                            }
                        @endphp

                        @if (empty($oldTrainings))
                            <div id="emptyTrainingNotice" class="text-center py-6 px-4 bg-gray-50/50 rounded-2xl border border-dashed border-gray-200">
                                <p class="text-xs text-gray-400">Belum ada pelatihan yang ditambahkan. Klik tombol <span class="font-bold text-gray-600">"Tambah Pelatihan"</span> di atas jika memiliki riwayat sertifikasi/kursus.</p>
                            </div>
                        @else
                            @foreach ($oldTrainings as $tIndex => $tr)
                                <div class="training-card bg-gray-50/70 rounded-2xl p-5 md:p-6 border border-gray-200 space-y-4 relative transition-all"
                                    data-index="{{ $tIndex }}">
                                    <div class="flex items-center justify-between pb-3 border-b border-gray-200/80">
                                        <div class="flex items-center gap-2">
                                            <div class="p-1.5 bg-red-100 text-[#B11116] rounded-lg">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                                </svg>
                                            </div>
                                            <h3 class="text-xs font-bold uppercase tracking-wider text-gray-800 training-title-label">
                                                Pelatihan Ke-{{ $tIndex + 1 }}
                                            </h3>
                                        </div>

                                        <button type="button" onclick="removeTrainingCard(this)"
                                            class="text-red-500 hover:text-red-700 hover:bg-red-50 p-1.5 rounded-lg transition-all"
                                            title="Hapus Pelatihan Ini">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div class="space-y-1.5">
                                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                                Nama Pelatihan / Sertifikasi <span class="text-[#B11116]">*</span>
                                            </label>
                                            <input type="text" name="trainings[{{ $tIndex }}][training_name]" required
                                                value="{{ $tr['training_name'] ?? '' }}"
                                                placeholder="Contoh: Fullstack Web Development"
                                                class="w-full px-4 py-2.5 bg-white rounded-xl border @error("trainings.{$tIndex}.training_name") border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                            @error("trainings.{$tIndex}.training_name")
                                                <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="space-y-1.5">
                                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                                Penyelenggara <span class="text-[#B11116]">*</span>
                                            </label>
                                            <input type="text" name="trainings[{{ $tIndex }}][organizer]" required
                                                value="{{ $tr['organizer'] ?? '' }}" placeholder="Contoh: Dicoding Indonesia / BNSP"
                                                class="w-full px-4 py-2.5 bg-white rounded-xl border @error("trainings.{$tIndex}.organizer") border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                            @error("trainings.{$tIndex}.organizer")
                                                <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="space-y-1.5">
                                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                                Tanggal Selesai <span class="text-[#B11116]">*</span>
                                            </label>
                                            <input type="date" name="trainings[{{ $tIndex }}][finished]" required
                                                value="{{ $tr['finished'] ?? '' }}"
                                                class="w-full px-4 py-2.5 bg-white rounded-xl border @error("trainings.{$tIndex}.finished") border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                            @error("trainings.{$tIndex}.finished")
                                                <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            <!-- Navigasi Bawah Form -->
            <div class="flex items-center justify-between pt-4">
                <a href="{{ route('biodata.family.create') }}"
                    class="px-6 py-3 border border-gray-300 hover:bg-gray-50 text-gray-700 font-bold rounded-xl text-xs transition-colors cursor-pointer shadow-xs">
                    &larr; Kembali (Data Keluarga)
                </a>

                <div class="flex items-center gap-3">
                    <button type="submit" id="btnSubmit"
                        class="px-8 py-3 bg-[#B11116] hover:bg-red-800 text-white font-bold rounded-xl text-xs transition-all shadow-md hover:shadow-lg flex items-center gap-2 cursor-pointer">
                        <span id="btnText">Simpan & Lanjut ke Pengalaman</span>
                        <span id="btnLoadingText" class="hidden flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Menyimpan Data...
                        </span>
                        <svg id="btnArrow" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Template JS untuk Tambah Card Pendidikan -->
    <template id="educationCardTemplate">
        <div class="education-card bg-gray-50/70 rounded-2xl p-5 md:p-6 border border-gray-200 space-y-4 relative transition-all"
            data-index="{INDEX}">
            <div class="flex items-center justify-between pb-3 border-b border-gray-200/80">
                <div class="flex items-center gap-2">
                    <div class="p-1.5 bg-red-100 text-[#B11116] rounded-lg">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                        </svg>
                    </div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-gray-800 card-title-label">
                        Pendidikan Ke-{NUMBER}
                    </h3>
                </div>

                <button type="button" onclick="removeEducationCard(this)"
                    class="btn-delete-card text-red-500 hover:text-red-700 hover:bg-red-50 p-1.5 rounded-lg transition-all"
                    title="Hapus Pendidikan Ini">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                        Jenjang Pendidikan <span class="text-[#B11116]">*</span>
                    </label>
                    <select name="educations[{INDEX}][degree_level]" required
                        class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                        <option value="" disabled selected>Pilih Jenjang</option>
                        @if (isset($educationTypes) && $educationTypes->isNotEmpty())
                            @foreach ($educationTypes as $etype)
                                @php
                                    $val = $etype->EDUTYPE_NAME_ID ?? $etype->EDUTYPE_NAME_EN;
                                @endphp
                                <option value="{{ $val }}">{{ $val }} ({{ $etype->EDUTYPE_NAME_EN }})</option>
                            @endforeach
                        @else
                            <option value="SMA">SMA</option>
                            <option value="STM">STM</option>
                            <option value="Diploma">Diploma</option>
                            <option value="Sarjana">Sarjana</option>
                            <option value="Master/S2">Master/S2</option>
                            <option value="Doctor">Doctor</option>
                            <option value="Lain-lain">Lain-lain</option>
                        @endif
                    </select>
                </div>

                <!-- Sekolah Combobox -->
                <div class="space-y-1.5 school-combobox-wrapper" data-field="school">
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                        Nama Sekolah / Universitas <span class="text-[#B11116]">*</span>
                    </label>
                    <div class="relative">
                        <input type="text"
                            class="combobox-search-input w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm"
                            placeholder="Ketik untuk mencari sekolah / universitas..."
                            autocomplete="off"
                            onfocus="openCombobox(this)"
                            oninput="filterCombobox(this, 'school')">

                        <input type="hidden"
                            name="educations[{INDEX}][institution_name]"
                            class="combobox-value-input"
                            required>

                        <div class="combobox-dropdown absolute left-0 right-0 top-full mt-1.5 bg-white border border-gray-200 rounded-xl shadow-xl z-50 max-h-60 overflow-y-auto hidden">
                            <div class="combobox-other-option p-3 bg-red-50/70 hover:bg-red-100/80 cursor-pointer border-b border-red-100 text-[#B11116] font-bold text-xs flex items-center gap-2"
                                onclick="selectOtherCombobox(this, 'school')">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                <span>Lainnya / Tidak Terdaftar di List (Input Manual)</span>
                            </div>
                            <ul class="combobox-list divide-y divide-gray-50 text-sm text-gray-800"></ul>
                        </div>
                    </div>

                    <div class="manual-school-input-wrapper space-y-1.5 pt-1 hidden">
                        <span class="text-[11px] text-amber-700 bg-amber-50 px-2 py-0.5 rounded font-medium inline-block">Mode Input Manual Sekolah</span>
                        <input type="text"
                            class="manual-school-input w-full px-4 py-2 bg-amber-50/30 rounded-xl border border-amber-300 text-gray-900 text-sm focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none"
                            placeholder="Ketik nama lengkap sekolah / universitas..."
                            oninput="syncManualValue(this, 'school')">
                    </div>
                </div>

                <!-- Kota / Kabupaten Sekolah -->
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                        Kota / Kabupaten Sekolah <span class="text-[#B11116]">*</span>
                    </label>
                    <input type="text" name="educations[{INDEX}][city]" required
                        placeholder="Contoh: Jakarta Selatan, Surabaya, Kab. Slawi"
                        class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                </div>

                <!-- Jurusan Combobox -->
                <div class="space-y-1.5 major-combobox-wrapper" data-field="major">
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                        Jurusan / Program Studi <span class="text-[#B11116]">*</span>
                    </label>
                    <div class="relative">
                        <input type="text"
                            class="combobox-search-input w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm"
                            placeholder="Ketik untuk mencari jurusan..."
                            autocomplete="off"
                            onfocus="openCombobox(this)"
                            oninput="filterCombobox(this, 'major')">

                        <input type="hidden"
                            name="educations[{INDEX}][major]"
                            class="combobox-value-input"
                            required>

                        <div class="combobox-dropdown absolute left-0 right-0 top-full mt-1.5 bg-white border border-gray-200 rounded-xl shadow-xl z-50 max-h-60 overflow-y-auto hidden">
                            <div class="combobox-other-option p-3 bg-red-50/70 hover:bg-red-100/80 cursor-pointer border-b border-red-100 text-[#B11116] font-bold text-xs flex items-center gap-2"
                                onclick="selectOtherCombobox(this, 'major')">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                <span>Lainnya / Tidak Terdaftar di List (Input Manual)</span>
                            </div>
                            <ul class="combobox-list divide-y divide-gray-50 text-sm text-gray-800"></ul>
                        </div>
                    </div>

                    <div class="manual-major-input-wrapper space-y-1.5 pt-1 hidden">
                        <span class="text-[11px] text-amber-700 bg-amber-50 px-2 py-0.5 rounded font-medium inline-block">Mode Input Manual Jurusan</span>
                        <input type="text"
                            class="manual-major-input w-full px-4 py-2 bg-amber-50/30 rounded-xl border border-amber-300 text-gray-900 text-sm focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none"
                            placeholder="Ketik nama lengkap jurusan / program studi..."
                            oninput="syncManualValue(this, 'major')">
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                        IPK / Nilai Rata-rata <span class="text-[#B11116]">*</span>
                    </label>
                    <input type="number" step="0.01" min="0" max="100" name="educations[{INDEX}][gpa]"
                        required placeholder="Contoh: 3.75 atau 85.50"
                        class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                    <span class="text-[11px] text-gray-400 block">Gunakan skala 4.00 untuk PT atau 100.00 untuk SMA.</span>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                        Tahun Masuk <span class="text-[#B11116]">*</span>
                    </label>
                    <input type="number" min="1970" max="{{ date('Y') }}"
                        name="educations[{INDEX}][entry_year]" required placeholder="Contoh: 2020"
                        class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                </div>

                <div class="space-y-1.5">
                    <div class="flex items-center justify-between">
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                            Tahun Lulus <span class="text-[#B11116]">*</span>
                        </label>
                        <label class="inline-flex items-center cursor-pointer select-none">
                            <input type="checkbox" onchange="toggleCurrentStudy(this)"
                                class="is-current-checkbox rounded border-gray-300 text-[#B11116] focus:ring-[#B11116] w-3.5 h-3.5 cursor-pointer disabled:opacity-40 disabled:cursor-not-allowed">
                            <span class="ml-1.5 text-xs text-gray-600 font-semibold label-current-study">Masih Studi Saat Ini</span>
                        </label>
                    </div>
                    <input type="number" min="1970" max="{{ date('Y') + 10 }}"
                        name="educations[{INDEX}][graduation_year]" required placeholder="Contoh: 2024"
                        class="graduation-year-input w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                </div>
            </div>
        </div>
    </template>

    <!-- Template JS untuk Tambah Card Pelatihan -->
    <template id="trainingCardTemplate">
        <div class="training-card bg-gray-50/70 rounded-2xl p-5 md:p-6 border border-gray-200 space-y-4 relative transition-all"
            data-index="{INDEX}">
            <div class="flex items-center justify-between pb-3 border-b border-gray-200/80">
                <div class="flex items-center gap-2">
                    <div class="p-1.5 bg-red-100 text-[#B11116] rounded-lg">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                        </svg>
                    </div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-gray-800 training-title-label">
                        Pelatihan Ke-{NUMBER}
                    </h3>
                </div>

                <button type="button" onclick="removeTrainingCard(this)"
                    class="text-red-500 hover:text-red-700 hover:bg-red-50 p-1.5 rounded-lg transition-all"
                    title="Hapus Pelatihan Ini">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                        Nama Pelatihan / Sertifikasi <span class="text-[#B11116]">*</span>
                    </label>
                    <input type="text" name="trainings[{INDEX}][training_name]" required
                        placeholder="Contoh: Fullstack Web Development"
                        class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                        Penyelenggara <span class="text-[#B11116]">*</span>
                    </label>
                    <input type="text" name="trainings[{INDEX}][organizer]" required
                        placeholder="Contoh: Dicoding Indonesia / BNSP"
                        class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                        Tanggal Selesai <span class="text-[#B11116]">*</span>
                    </label>
                    <input type="date" name="trainings[{INDEX}][finished]" required
                        class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                </div>
            </div>
        </div>
    </template>

    <script>
        const masterSchools = @json($schools ?? []);
        const masterMajors = @json($majors ?? []);

        function goToStep(step) {
            const redirectInput = document.getElementById('redirect_step');
            if (redirectInput) {
                redirectInput.value = step;
            }

            const educationForm = document.getElementById('educationForm');
            if (educationForm) {
                if (educationForm.reportValidity && !educationForm.reportValidity()) {
                    return;
                }
                educationForm.submit();
            }
        }

        const currentYear = new Date().getFullYear();

        /* --- LOGIK UTAMA PENDIDIKAN --- */
        function toggleCurrentStudy(checkbox) {
            const card = checkbox.closest('.education-card');
            const inputField = card.querySelector('.graduation-year-input');
            if (!inputField) return;

            if (checkbox.checked) {
                inputField.dataset.previousValue = inputField.value;
                inputField.value = currentYear;
                inputField.readOnly = true;
                inputField.classList.add('bg-gray-100', 'text-gray-500', 'cursor-not-allowed');
            } else {
                inputField.value = inputField.dataset.previousValue || '';
                inputField.readOnly = false;
                inputField.classList.remove('bg-gray-100', 'text-gray-500', 'cursor-not-allowed');
            }

            syncCurrentStudyCheckboxes();
        }

        function syncCurrentStudyCheckboxes() {
            const checkboxes = document.querySelectorAll('#educationContainer .is-current-checkbox');
            const activeCheckbox = Array.from(checkboxes).find(cb => cb.checked);

            checkboxes.forEach(cb => {
                const label = cb.closest('label').querySelector('.label-current-study');
                if (activeCheckbox) {
                    if (cb !== activeCheckbox) {
                        cb.disabled = true;
                        if (label) label.classList.add('text-gray-400');
                    } else {
                        cb.disabled = false;
                        if (label) label.classList.remove('text-gray-400');
                    }
                } else {
                    cb.disabled = false;
                    if (label) label.classList.remove('text-gray-400');
                }
            });
        }

        function addEducationCard() {
            const container = document.getElementById('educationContainer');
            const template = document.getElementById('educationCardTemplate').innerHTML;
            const currentCards = container.querySelectorAll('.education-card').length;

            const newCardHtml = template
                .replace(/{INDEX}/g, currentCards)
                .replace(/{NUMBER}/g, currentCards + 1);

            container.insertAdjacentHTML('beforeend', newCardHtml);
            reindexEducationCards();
        }

        function removeEducationCard(button) {
            const card = button.closest('.education-card');
            if (card) {
                card.remove();
                reindexEducationCards();
            }
        }

        function reindexEducationCards() {
            const cards = document.querySelectorAll('#educationContainer .education-card');
            cards.forEach((card, idx) => {
                card.setAttribute('data-index', idx);

                const titleLabel = card.querySelector('.card-title-label');
                if (titleLabel) {
                    titleLabel.textContent = idx === 0 ? 'Pendidikan Terakhir' : `Pendidikan Ke-${idx + 1}`;
                }

                const deleteBtn = card.querySelector('.btn-delete-card');
                if (deleteBtn) {
                    if (idx === 0) {
                        deleteBtn.classList.add('hidden');
                    } else {
                        deleteBtn.classList.remove('hidden');
                    }
                }

                const inputs = card.querySelectorAll('input, select');
                inputs.forEach(input => {
                    if (input.name) {
                        input.name = input.name.replace(/educations\[\d+\]/, `educations[${idx}]`);
                    }
                });
            });

            syncCurrentStudyCheckboxes();
        }

        function addTrainingCard() {
            const container = document.getElementById('trainingContainer');
            const template = document.getElementById('trainingCardTemplate').innerHTML;
            const emptyNotice = document.getElementById('emptyTrainingNotice');
            if (emptyNotice) emptyNotice.remove();

            const currentCards = container.querySelectorAll('.training-card').length;

            const newCardHtml = template
                .replace(/{INDEX}/g, currentCards)
                .replace(/{NUMBER}/g, currentCards + 1);

            container.insertAdjacentHTML('beforeend', newCardHtml);
            reindexTrainingCards();
        }

        function removeTrainingCard(button) {
            const card = button.closest('.training-card');
            if (card) {
                card.remove();
                reindexTrainingCards();
            }
        }

        function reindexTrainingCards() {
            const cards = document.querySelectorAll('#trainingContainer .training-card');
            cards.forEach((card, idx) => {
                card.setAttribute('data-index', idx);

                const titleLabel = card.querySelector('.training-title-label');
                if (titleLabel) {
                    titleLabel.textContent = `Pelatihan Ke-${idx + 1}`;
                }

                const inputs = card.querySelectorAll('input, select');
                inputs.forEach(input => {
                    if (input.name) {
                        input.name = input.name.replace(/trainings\[\d+\]/, `trainings[${idx}]`);
                    }
                });
            });
        }

        /* --- COMBOBOX AUTOCOMPLETE & OTHER LOGIC --- */
        function openCombobox(input) {
            closeAllComboboxes();
            const wrapper = input.closest('[data-field]');
            const dropdown = wrapper.querySelector('.combobox-dropdown');
            const fieldType = wrapper.dataset.field;
            filterCombobox(input, fieldType);
            dropdown.classList.remove('hidden');
        }

        function closeAllComboboxes() {
            document.querySelectorAll('.combobox-dropdown').forEach(dd => dd.classList.add('hidden'));
        }

        document.addEventListener('click', function(e) {
            if (!e.target.closest('[data-field]')) {
                closeAllComboboxes();
            }
        });

        function filterCombobox(input, type) {
            const wrapper = input.closest('[data-field]');
            const listEl = wrapper.querySelector('.combobox-list');
            const valInput = wrapper.querySelector('.combobox-value-input');
            const query = input.value.trim().toLowerCase();
            const items = type === 'school' ? masterSchools : masterMajors;
            const nameProp = type === 'school' ? 'EDU_NAME' : 'MAJOR_NAME';

            // By default sync search input with value input
            valInput.value = input.value;

            const filtered = items.filter(item => {
                const name = item[nameProp] || '';
                return name.toLowerCase().includes(query);
            }).slice(0, 40);

            if (filtered.length === 0) {
                listEl.innerHTML = `<li class="p-3 text-xs text-gray-400 text-center italic">Tidak ditemukan "${input.value}". Silakan klik pilihan Lainnya di atas untuk mengisi manual.</li>`;
            } else {
                listEl.innerHTML = filtered.map(item => {
                    const name = item[nameProp];
                    const safeName = name.replace(/'/g, "\\'");
                    return `<li class="p-2.5 px-3 hover:bg-red-50 hover:text-[#B11116] cursor-pointer transition-colors text-xs font-medium"
                                onclick="selectItemCombobox(this, '${safeName}', '${type}')">
                                ${name}
                            </li>`;
                }).join('');
            }
        }

        function selectItemCombobox(el, name, type) {
            const wrapper = el.closest('[data-field]');
            const searchInput = wrapper.querySelector('.combobox-search-input');
            const valInput = wrapper.querySelector('.combobox-value-input');
            const dropdown = wrapper.querySelector('.combobox-dropdown');
            const manualWrapper = wrapper.querySelector(`.manual-${type}-input-wrapper`);

            searchInput.value = name;
            valInput.value = name;
            dropdown.classList.add('hidden');

            if (manualWrapper) {
                manualWrapper.classList.add('hidden');
                const manualInput = manualWrapper.querySelector('input');
                if (manualInput) manualInput.value = '';
            }
        }

        function selectOtherCombobox(el, type) {
            const wrapper = el.closest('[data-field]');
            const searchInput = wrapper.querySelector('.combobox-search-input');
            const valInput = wrapper.querySelector('.combobox-value-input');
            const dropdown = wrapper.querySelector('.combobox-dropdown');
            const manualWrapper = wrapper.querySelector(`.manual-${type}-input-wrapper`);
            const manualInput = manualWrapper.querySelector('input');

            searchInput.value = 'Lainnya / Input Manual';
            searchInput.classList.add('bg-gray-100', 'text-gray-500');
            valInput.value = '';
            dropdown.classList.add('hidden');

            if (manualWrapper) {
                manualWrapper.classList.remove('hidden');
                manualInput.focus();
            }
        }

        function syncManualValue(input, type) {
            const wrapper = input.closest('[data-field]');
            const valInput = wrapper.querySelector('.combobox-value-input');
            valInput.value = input.value.trim();
        }

        document.addEventListener('DOMContentLoaded', function() {
            const educationForm = document.getElementById('educationForm');
            const btnSubmit = document.getElementById('btnSubmit');
            const btnText = document.getElementById('btnText');
            const btnLoadingText = document.getElementById('btnLoadingText');
            const btnArrow = document.getElementById('btnArrow');

            if (educationForm && btnSubmit) {
                educationForm.addEventListener('submit', function() {
                    btnSubmit.disabled = true;
                    if (btnText) btnText.classList.add('hidden');
                    if (btnArrow) btnArrow.classList.add('hidden');
                    if (btnLoadingText) btnLoadingText.classList.remove('hidden');
                });
            }

            syncCurrentStudyCheckboxes();

            // Cek kondisi awal pada tiap combobox (apakah nilai awal ada di list atau custom manual)
            document.querySelectorAll('.education-card').forEach(card => {
                ['school', 'major'].forEach(type => {
                    const wrapper = card.querySelector(`[data-field="${type}"]`);
                    if (!wrapper) return;
                    const valInput = wrapper.querySelector('.combobox-value-input');
                    const searchInput = wrapper.querySelector('.combobox-search-input');
                    const manualWrapper = wrapper.querySelector(`.manual-${type}-input-wrapper`);
                    const manualInput = manualWrapper ? manualWrapper.querySelector('input') : null;
                    const val = (valInput.value || '').trim();

                    if (val) {
                        const items = type === 'school' ? masterSchools : masterMajors;
                        const nameProp = type === 'school' ? 'EDU_NAME' : 'MAJOR_NAME';
                        const found = items.some(i => (i[nameProp] || '').trim().toLowerCase() === val.toLowerCase());
                        if (!found) {
                            // Berarti data manual / previously other
                            searchInput.value = 'Lainnya / Input Manual';
                            searchInput.classList.add('bg-gray-100', 'text-gray-500');
                            if (manualWrapper) {
                                manualWrapper.classList.remove('hidden');
                                if (manualInput) manualInput.value = val;
                            }
                        }
                    }
                });
            });
        });
    </script>
@endsection
