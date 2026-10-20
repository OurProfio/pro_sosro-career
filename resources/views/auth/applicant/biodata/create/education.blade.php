@extends('auth.applicant.layouts.index')

@section('title', 'Data Pendidikan & Pelatihan Pelamar')

@section('content')
    <div class="py-8 md:py-12 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto font-figtree">
        <div class="mb-6 flex items-center justify-between">
            <a href="{{ route('biodata.index') }}"
                class="inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-2 text-xs font-semibold text-gray-700 shadow-sm transition hover:border-gray-300 hover:bg-gray-50 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Pratinjau Biodata
            </a>
            <span class="text-xs font-medium text-gray-400">Langkah 3 dari 4</span>
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

                <!-- Step 3: Pendidikan & Pelatihan (AKTIF) -->
                <li class="flex items-center transition-colors text-[#B11116] font-bold">
                    <span
                        class="flex items-center justify-center w-8 h-8 rounded-full border-2 mr-2 shadow-sm transition-all text-xs font-bold border-[#B11116] bg-[#B11116] text-white">
                        <span>3</span>
                    </span>
                    <span class="hidden sm:inline">Pendidikan</span>
                </li>

                <li class="flex-1 border-t-2 mx-2 sm:mx-4 transition-colors duration-300 border-gray-200"></li>

                <!-- Step 4: Pengalaman (Dapat diklik, simpan dulu) -->
                <li>
                    <button type="button" onclick="goToStep('workExperience')" title="Simpan data saat ini & lanjut ke Data Pengalaman"
                        class="flex items-center transition-colors text-gray-500 hover:text-[#B11116] cursor-pointer group focus:outline-none">
                        <span
                            class="flex items-center justify-center w-8 h-8 rounded-full border-2 mr-2 shadow-sm transition-all text-xs font-bold border-gray-300 bg-white text-gray-500 group-hover:border-[#B11116] group-hover:text-[#B11116]">
                            <span>4</span>
                        </span>
                        <span class="hidden sm:inline group-hover:font-bold">Pengalaman</span>
                    </button>
                </li>
            </ol>
        </div>

        <form action="{{ route('biodata.education.store') }}" method="POST" id="educationForm" novalidate>
            @csrf
            <input type="hidden" name="redirect_step" id="redirect_step" value="workExperience">

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-6 sm:p-10 space-y-10">

                    <header class="pb-4 border-b border-gray-100">
                        <h1 class="text-2xl font-black text-gray-900 tracking-tight">
                            Riwayat <span class="text-[#B11116]">Pendidikan & Pelatihan</span>
                        </h1>
                        <p class="text-gray-500 text-sm mt-1">
                            Isi riwayat pendidikan formal dan sertifikasi/pelatihan non-formal yang pernah Anda ikuti.
                        </p>
                    </header>

                    <!-- SECTION 1: PENDIDIKAN FORMAL -->
                    <section class="space-y-6">
                        <div class="flex items-center gap-2 pb-2 border-b border-gray-100">
                            <h2 class="text-base font-black text-gray-800 tracking-tight uppercase">Pendidikan Formal</h2>
                        </div>

                        <div id="educationContainer" class="space-y-6">
                            @php
                                $oldEducations = old('educations');
                                if (empty($oldEducations)) {
                                    if (isset($educations) && $educations->isNotEmpty()) {
                                        $oldEducations = $educations->map(function ($edu) {
                                            return [
                                                'degree_level' => $edu->degree_level,
                                                'institution_name' => $edu->institution_name,
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
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 14l9-5-9-5-9 5 9 5z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                                </svg>
                                            </div>
                                            <h3
                                                class="text-xs font-black uppercase tracking-wider text-gray-800 card-title-label">
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
                                                <option value="" disabled
                                                    {{ empty($edu['degree_level']) ? 'selected' : '' }}>Pilih Jenjang
                                                </option>
                                                <option value="SMA/SMK"
                                                    {{ ($edu['degree_level'] ?? '') == 'SMA/SMK' ? 'selected' : '' }}>SMA /
                                                    SMK / MA</option>
                                                <option value="D3"
                                                    {{ ($edu['degree_level'] ?? '') == 'D3' ? 'selected' : '' }}>D3 (Diploma
                                                    III)</option>
                                                <option value="D4/S1"
                                                    {{ ($edu['degree_level'] ?? '') == 'D4/S1' ? 'selected' : '' }}>D4 / S1
                                                    (Sarjana)
                                                </option>
                                                <option value="S2"
                                                    {{ ($edu['degree_level'] ?? '') == 'S2' ? 'selected' : '' }}>S2
                                                    (Magister)</option>
                                                <option value="S3"
                                                    {{ ($edu['degree_level'] ?? '') == 'S3' ? 'selected' : '' }}>S3
                                                    (Doktor)</option>
                                            </select>
                                            @error("educations.{$index}.degree_level")
                                                <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Nama Sekolah / Universitas -->
                                        <div class="space-y-1.5">
                                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                                Nama Sekolah / Universitas <span class="text-[#B11116]">*</span>
                                            </label>
                                            <input type="text" name="educations[{{ $index }}][institution_name]"
                                                required value="{{ $edu['institution_name'] ?? '' }}"
                                                placeholder="Contoh: Universitas Indonesia / SMAN 1 Jakarta"
                                                class="uppercase placeholder:normal-case w-full px-4 py-2.5 bg-white rounded-xl border @error("educations.{$index}.institution_name") border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                            @error("educations.{$index}.institution_name")
                                                <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Jurusan -->
                                        <div class="space-y-1.5">
                                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                                Jurusan / Program Studi <span class="text-[#B11116]">*</span>
                                            </label>
                                            <input type="text" name="educations[{{ $index }}][major]" required
                                                value="{{ $edu['major'] ?? '' }}"
                                                placeholder="Contoh: Teknik Informatika / IPA / Rekayasa Perangkat Lunak"
                                                class="uppercase placeholder:normal-case w-full px-4 py-2.5 bg-white rounded-xl border @error("educations.{$index}.major") border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
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
                                                <label
                                                    class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                                    Tahun Lulus <span class="text-[#B11116]">*</span>
                                                </label>
                                                <label class="inline-flex items-center cursor-pointer select-none">
                                                    <input type="checkbox" onchange="toggleCurrentStudy(this)"
                                                        class="is-current-checkbox rounded border-gray-300 text-[#B11116] focus:ring-[#B11116] w-3.5 h-3.5 cursor-pointer disabled:opacity-40 disabled:cursor-not-allowed">
                                                    <span
                                                        class="ml-1.5 text-xs text-gray-600 font-semibold label-current-study">Masih
                                                        Studi Saat Ini</span>
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

                        <div class="flex justify-start">
                            <button type="button" id="btnAddEducation" onclick="addEducationCard()"
                                class="inline-flex items-center gap-2 px-4 py-2.5 bg-red-50 hover:bg-red-100 text-[#B11116] rounded-xl text-xs font-bold transition-all active:scale-95 cursor-pointer shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                Tambah Pendidikan Lainnya
                            </button>
                        </div>
                    </section>

                    <!-- SECTION 2: PELATIHAN / SERTIFIKASI (OPSIONAL) -->
                    <section class="space-y-6 pt-6 border-t border-gray-100">
                        <div class="flex items-center justify-between pb-2 border-b border-gray-100">
                            <div>
                                <h2 class="text-base font-black text-gray-800 tracking-tight uppercase">Pelatihan &
                                    Sertifikasi</h2>
                                <p class="text-xs text-gray-500 mt-0.5">Isi jika Anda pernah mengikuti pelatihan, seminar,
                                    atau memiliki sertifikasi profesional (Opsional).</p>
                            </div>
                        </div>

                        <div id="trainingContainer" class="space-y-6">
                            @php
                                $oldTrainings = old('trainings');
                                if ($oldTrainings === null) {
                                    $oldTrainings = isset($trainings) && $trainings->isNotEmpty()
                                        ? $trainings->map(function ($t) {
                                            return [
                                                'training_name' => $t->training_name,
                                                'organizer' => $t->organizer,
                                                'finished' => $t->finished ? \Carbon\Carbon::parse($t->finished)->format('Y-m-d') : '',
                                            ];
                                        })->toArray()
                                        : [];
                                }
                            @endphp

                            @foreach ($oldTrainings as $tIndex => $train)
                                <div class="training-card bg-gray-50/70 rounded-2xl p-5 md:p-6 border border-gray-200 space-y-4 relative transition-all"
                                    data-index="{{ $tIndex }}">
                                    <div class="flex items-center justify-between pb-3 border-b border-gray-200/80">
                                        <div class="flex items-center gap-2">
                                            <div class="p-1.5 bg-red-100 text-[#B11116] rounded-lg">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                                </svg>
                                            </div>
                                            <h3
                                                class="text-xs font-black uppercase tracking-wider text-gray-800 training-title-label">
                                                Pelatihan Ke-{{ $tIndex + 1 }}
                                            </h3>
                                        </div>

                                        <button type="button" onclick="removeTrainingCard(this)"
                                            class="text-red-500 hover:text-red-700 hover:bg-red-50 p-1.5 rounded-lg transition-all"
                                            title="Hapus Pelatihan Ini">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <!-- Nama Pelatihan -->
                                        <div class="space-y-1.5">
                                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                                Nama Pelatihan / Sertifikasi <span class="text-[#B11116]">*</span>
                                            </label>
                                            <input type="text" name="trainings[{{ $tIndex }}][training_name]"
                                                required value="{{ $train['training_name'] ?? '' }}"
                                                placeholder="Contoh: Fullstack Web Development"
                                                class="uppercase placeholder:normal-case w-full px-4 py-2.5 bg-white rounded-xl border @error("trainings.{$tIndex}.training_name") border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                            @error("trainings.{$tIndex}.training_name")
                                                <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Penyelenggara -->
                                        <div class="space-y-1.5">
                                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                                Penyelenggara <span class="text-[#B11116]">*</span>
                                            </label>
                                            <input type="text" name="trainings[{{ $tIndex }}][organizer]"
                                                required value="{{ $train['organizer'] ?? '' }}"
                                                placeholder="Contoh: Dicoding Indonesia / BNSP"
                                                class="uppercase placeholder:normal-case w-full px-4 py-2.5 bg-white rounded-xl border @error("trainings.{$tIndex}.organizer") border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                            @error("trainings.{$tIndex}.organizer")
                                                <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Tanggal Selesai -->
                                        <div class="space-y-1.5">
                                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                                Tanggal Selesai <span class="text-[#B11116]">*</span>
                                            </label>
                                            <input type="date" name="trainings[{{ $tIndex }}][finished]"
                                                required value="{{ $train['finished'] ?? '' }}"
                                                class="w-full px-4 py-2.5 bg-white rounded-xl border @error("trainings.{$tIndex}.finished") border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                            @error("trainings.{$tIndex}.finished")
                                                <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="flex justify-start">
                            <button type="button" id="btnAddTraining" onclick="addTrainingCard()"
                                class="inline-flex items-center gap-2 px-4 py-2.5 bg-red-50 hover:bg-red-100 text-[#B11116] rounded-xl text-xs font-bold transition-all active:scale-95 cursor-pointer shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                Tambah Pelatihan / Sertifikasi
                            </button>
                        </div>
                    </section>

                    <!-- Actions Bottom -->
                    <div class="pt-8 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4 mt-8">
                        <div class="flex items-center gap-3 w-full sm:w-auto">
                            <a href="{{ route('biodata.index') }}"
                                class="w-full sm:w-auto px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-sm rounded-xl transition-all inline-flex items-center justify-center gap-2 cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Kembali ke Pratinjau
                            </a>
                            <a href="{{ route('biodata.family.create') }}"
                                class="w-full sm:w-auto px-6 py-3 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 font-bold text-sm rounded-xl transition-all inline-flex items-center justify-center gap-2 cursor-pointer">
                                Kembali ke Langkah 2
                            </a>
                        </div>

                        <button type="submit" id="btnSubmit"
                            class="w-full sm:w-auto px-8 py-3 bg-[#B11116] hover:bg-red-800 text-white font-bold text-sm rounded-xl shadow-md transition-all flex items-center justify-center gap-2 cursor-pointer focus:ring-4 focus:ring-red-200 disabled:opacity-50 disabled:cursor-not-allowed active:scale-95">
                            <span id="btnText">Simpan & Lanjut ke Langkah 4</span>
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
                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </div>

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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 14l9-5-9-5-9 5 9 5z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                        </svg>
                    </div>
                    <h3 class="text-xs font-black uppercase tracking-wider text-gray-800 card-title-label">Pendidikan
                        Ke-{NUMBER}</h3>
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
                        <option value="SMA/SMK">SMA / SMK / MA</option>
                        <option value="D3">D3 (Diploma III)</option>
                        <option value="D4/S1">D4 / S1 (Sarjana)</option>
                        <option value="S2">S2 (Magister)</option>
                        <option value="S3">S3 (Doktor)</option>
                    </select>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                        Nama Sekolah / Universitas <span class="text-[#B11116]">*</span>
                    </label>
                    <input type="text" name="educations[{INDEX}][institution_name]" required
                        placeholder="Contoh: Universitas Indonesia / SMAN 1 Jakarta"
                        class="uppercase placeholder:normal-case w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                        Jurusan / Program Studi <span class="text-[#B11116]">*</span>
                    </label>
                    <input type="text" name="educations[{INDEX}][major]" required
                        placeholder="Contoh: Teknik Informatika / IPA / Rekayasa Perangkat Lunak"
                        class="uppercase placeholder:normal-case w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
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
                            <span class="ml-1.5 text-xs text-gray-600 font-semibold label-current-study">Masih Studi Saat
                                Ini</span>
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
                    <h3 class="text-xs font-black uppercase tracking-wider text-gray-800 training-title-label">
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
                        class="uppercase placeholder:normal-case w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                        Penyelenggara <span class="text-[#B11116]">*</span>
                    </label>
                    <input type="text" name="trainings[{INDEX}][organizer]" required
                        placeholder="Contoh: Dicoding Indonesia / BNSP"
                        class="uppercase placeholder:normal-case w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
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
        });
    </script>
@endsection
