@extends('auth.applicant.layouts.index')

@section('title', 'Data Keluarga Pelamar')

@section('content')
    <div class="py-8 md:py-12 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto font-figtree">
        <div class="mb-6 flex items-center justify-end">
            <span class="text-xs font-medium text-gray-400">Langkah 2 dari 4</span>
        </div>

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

                <!-- Step 2: Keluarga (AKTIF) -->
                <li class="flex items-center transition-colors text-[#B11116] font-bold">
                    <span
                        class="flex items-center justify-center w-8 h-8 rounded-full border-2 mr-2 shadow-sm transition-all text-xs font-bold border-[#B11116] bg-[#B11116] text-white">
                        <span>2</span>
                    </span>
                    <span class="hidden sm:inline">Keluarga</span>
                </li>

                <li class="flex-1 border-t-2 mx-2 sm:mx-4 transition-colors duration-300 border-gray-200"></li>

                <!-- Step 3: Pendidikan (Dapat diklik, simpan dulu) -->
                <li>
                    <button type="button" onclick="goToStep('education')" title="Simpan data saat ini & lanjut ke Data Pendidikan"
                        class="flex items-center transition-colors text-gray-500 hover:text-[#B11116] cursor-pointer group focus:outline-none">
                        <span
                            class="flex items-center justify-center w-8 h-8 rounded-full border-2 mr-2 shadow-sm transition-all text-xs font-bold border-gray-300 bg-white text-gray-500 group-hover:border-[#B11116] group-hover:text-[#B11116]">
                            <span>3</span>
                        </span>
                        <span class="hidden sm:inline group-hover:font-bold">Pendidikan</span>
                    </button>
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

        @php
            $father = $families->firstWhere('relationship', 'father');
            $mother = $families->firstWhere('relationship', 'mother');
            $spouse = $families->firstWhere('relationship', 'spouse');
            $fatherInLaw = $families->firstWhere('relationship', 'father_in_law');
            $motherInLaw = $families->firstWhere('relationship', 'mother_in_law');
            $existingSiblings = $families->where('relationship', 'sibling')->values();
            $existingChildren = $families->where('relationship', 'child')->values();

            $oldSiblings = old('families.siblings');
            if ($oldSiblings === null && $existingSiblings->isNotEmpty()) {
                $oldSiblings = [];
                foreach ($existingSiblings as $idx => $sib) {
                    $oldSiblings[$idx + 1] = [
                        'name' => $sib->name,
                        'place_of_birth' => $sib->place_of_birth,
                        'date_of_birth' => $sib->date_of_birth ? \Carbon\Carbon::parse($sib->date_of_birth)->format('Y-m-d') : '',
                        'education' => $sib->education,
                        'work' => $sib->work,
                        'phone_number' => $sib->phone_number,
                    ];
                }
            }

            $oldChildren = old('families.children');
            if ($oldChildren === null && $existingChildren->isNotEmpty()) {
                $oldChildren = [];
                foreach ($existingChildren as $cIdx => $c) {
                    $oldChildren[$cIdx + 1] = [
                        'name' => $c->name,
                        'place_of_birth' => $c->place_of_birth,
                        'date_of_birth' => $c->date_of_birth ? \Carbon\Carbon::parse($c->date_of_birth)->format('Y-m-d') : '',
                        'education' => $c->education,
                        'work' => $c->work,
                        'phone_number' => $c->phone_number,
                    ];
                }
            }
        @endphp

        <form action="{{ route('biodata.family.store') }}" method="POST" id="familyForm" novalidate>
            @csrf
            <input type="hidden" name="redirect_step" id="redirect_step" value="education">

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-6 sm:p-10 space-y-10">

                    <header class="pb-4 border-b border-gray-100">
                        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">
                            Data <span class="text-[#B11116]">Keluarga</span>
                        </h1>
                        <p class="text-gray-500 text-sm mt-1">
                            Lengkapi data keluarga kandung dan keluarga inti Anda secara benar.
                        </p>
                    </header>

                    <section class="space-y-6">
                        <div class="flex items-center gap-3 pb-2 border-b border-gray-100">
                            <div class="p-2 bg-red-50 text-[#B11116] rounded-xl">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-base font-bold text-gray-900">Keluarga Kandung</h2>
                                <p class="text-xs text-gray-500">Data Ayah dan Ibu kandung wajib diisi lengkap.</p>
                            </div>
                        </div>

                        <!-- Data Ayah -->
                        <div class="bg-gray-50/70 rounded-2xl p-5 border border-gray-200 space-y-4">
                            <h3 class="text-xs font-bold text-[#B11116] uppercase tracking-wider flex items-center gap-2">
                                <span>1. Data Ayah Kandung</span>
                                <span class="text-[#B11116]">*</span>
                            </h3>
                            <input type="hidden" name="families[father][family_type]" value="biological">
                            <input type="hidden" name="families[father][relationship]" value="father">

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="space-y-1.5">
                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Nama
                                        Lengkap Ayah <span class="text-[#B11116]">*</span></label>
                                    <input type="text" name="families[father][name]" required
                                        value="{{ old('families.father.name', $father?->name) }}" placeholder="Nama Lengkap Ayah Kandung"
                                        class="uppercase placeholder:normal-case w-full px-4 py-2.5 bg-white rounded-xl border @error('families.father.name') border-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                    @error('families.father.name')
                                        <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="space-y-1.5">
                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Kondisi / Status <span class="text-[#B11116]">*</span></label>
                                    @php
                                        $fatherStatus = old('families.father.status', $father?->status ?? 'alive');
                                    @endphp
                                    <select name="families[father][status]" required
                                        class="w-full px-4 py-2.5 bg-white rounded-xl border @error('families.father.status') border-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                        <option value="alive" {{ $fatherStatus === 'alive' ? 'selected' : '' }}>Masih Hidup</option>
                                        <option value="deceased" {{ $fatherStatus === 'deceased' ? 'selected' : '' }}>Sudah Meninggal (+)</option>
                                        <option value="divorced" {{ $fatherStatus === 'divorced' ? 'selected' : '' }}>Bercerai</option>
                                    </select>
                                    @error('families.father.status')
                                        <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="space-y-1.5">
                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Tempat
                                        Lahir <span class="text-[#B11116]">*</span></label>
                                    <input type="text" name="families[father][place_of_birth]" required
                                        value="{{ old('families.father.place_of_birth', $father?->place_of_birth) }}" placeholder="Kota Lahir Ayah"
                                        class="uppercase placeholder:normal-case w-full px-4 py-2.5 bg-white rounded-xl border @error('families.father.place_of_birth') border-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                    @error('families.father.place_of_birth')
                                        <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="space-y-1.5">
                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Tanggal
                                        Lahir <span class="text-[#B11116]">*</span></label>
                                    <input type="date" name="families[father][date_of_birth]" required
                                        value="{{ old('families.father.date_of_birth', $father?->date_of_birth ? \Carbon\Carbon::parse($father->date_of_birth)->format('Y-m-d') : '') }}"
                                        class="w-full px-4 py-2.5 bg-white rounded-xl border @error('families.father.date_of_birth') border-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                    @error('families.father.date_of_birth')
                                        <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="space-y-1.5">
                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Pendidikan
                                        Terakhir <span class="text-[#B11116]">*</span></label>
                                    @php
                                        $fatherEdu = old('families.father.education', $father?->education);
                                    @endphp
                                    <select name="families[father][education]" required
                                        class="w-full px-4 py-2.5 bg-white rounded-xl border @error('families.father.education') border-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                        <option value="" disabled {{ $fatherEdu ? '' : 'selected' }}>Pilih Pendidikan Terakhir</option>
                                        @foreach (['SD' => 'SD / Sederajat', 'SMP' => 'SMP / Sederajat', 'SMA/SMK' => 'SMA / SMK / Sederajat', 'D1/D2/D3' => 'D1 / D2 / D3', 'S1/D4' => 'S1 / D4', 'S2' => 'S2', 'S3' => 'S3', 'Tidak Sekolah' => 'Tidak Sekolah'] as $val => $lbl)
                                            <option value="{{ $val }}" {{ $fatherEdu == $val ? 'selected' : '' }}>{{ $lbl }}</option>
                                        @endforeach
                                    </select>
                                    @error('families.father.education')
                                        <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="space-y-1.5">
                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Pekerjaan
                                        <span class="text-[#B11116]">*</span></label>
                                    <input type="text" name="families[father][work]" required
                                        value="{{ old('families.father.work', $father?->work) }}"
                                        placeholder="Contoh: PNS / Wirausaha / Pensiunan"
                                        class="uppercase placeholder:normal-case w-full px-4 py-2.5 bg-white rounded-xl border @error('families.father.work') border-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                    @error('families.father.work')
                                        <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="space-y-1.5 md:col-span-2">
                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">No.
                                        Telepon / WA <span class="text-[#B11116]">*</span></label>
                                    <input type="tel" name="families[father][phone_number]" required
                                        inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                        value="{{ old('families.father.phone_number', $father?->phone_number) }}"
                                        placeholder="Contoh: 081234567890"
                                        class="w-full px-4 py-2.5 bg-white rounded-xl border @error('families.father.phone_number') border-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                    @error('families.father.phone_number')
                                        <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Data Ibu -->
                        <div class="bg-gray-50/70 rounded-2xl p-5 border border-gray-200 space-y-4">
                            <h3 class="text-xs font-bold text-[#B11116] uppercase tracking-wider flex items-center gap-2">
                                <span>2. Data Ibu Kandung</span>
                                <span class="text-[#B11116]">*</span>
                            </h3>
                            <input type="hidden" name="families[mother][family_type]" value="biological">
                            <input type="hidden" name="families[mother][relationship]" value="mother">

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="space-y-1.5">
                                     <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Nama
                                         Lengkap Ibu <span class="text-[#B11116]">*</span></label>
                                     <input type="text" name="families[mother][name]" required
                                         value="{{ old('families.mother.name', $mother?->name) }}" placeholder="Nama Lengkap Ibu Kandung"
                                         class="uppercase placeholder:normal-case w-full px-4 py-2.5 bg-white rounded-xl border @error('families.mother.name') border-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                     @error('families.mother.name')
                                         <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                     @enderror
                                 </div>
                                 <div class="space-y-1.5">
                                     <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Kondisi / Status <span class="text-[#B11116]">*</span></label>
                                     @php
                                         $motherStatus = old('families.mother.status', $mother?->status ?? 'alive');
                                     @endphp
                                     <select name="families[mother][status]" required
                                         class="w-full px-4 py-2.5 bg-white rounded-xl border @error('families.mother.status') border-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                        <option value="alive" {{ $motherStatus === 'alive' ? 'selected' : '' }}>Masih Hidup</option>
                                        <option value="deceased" {{ $motherStatus === 'deceased' ? 'selected' : '' }}>Sudah Meninggal (+)</option>
                                        <option value="divorced" {{ $motherStatus === 'divorced' ? 'selected' : '' }}>Bercerai</option>
                                    </select>
                                    @error('families.mother.status')
                                        <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="space-y-1.5">
                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Tempat
                                        Lahir <span class="text-[#B11116]">*</span></label>
                                    <input type="text" name="families[mother][place_of_birth]" required
                                        value="{{ old('families.mother.place_of_birth', $mother?->place_of_birth) }}" placeholder="Kota Lahir Ibu"
                                        class="uppercase placeholder:normal-case w-full px-4 py-2.5 bg-white rounded-xl border @error('families.mother.place_of_birth') border-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                    @error('families.mother.place_of_birth')
                                        <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="space-y-1.5">
                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Tanggal
                                        Lahir <span class="text-[#B11116]">*</span></label>
                                    <input type="date" name="families[mother][date_of_birth]" required
                                        value="{{ old('families.mother.date_of_birth', $mother?->date_of_birth ? \Carbon\Carbon::parse($mother->date_of_birth)->format('Y-m-d') : '') }}"
                                        class="w-full px-4 py-2.5 bg-white rounded-xl border @error('families.mother.date_of_birth') border-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                    @error('families.mother.date_of_birth')
                                        <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="space-y-1.5">
                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Pendidikan
                                        Terakhir <span class="text-[#B11116]">*</span></label>
                                    @php
                                        $motherEdu = old('families.mother.education', $mother?->education);
                                    @endphp
                                    <select name="families[mother][education]" required
                                        class="w-full px-4 py-2.5 bg-white rounded-xl border @error('families.mother.education') border-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                        <option value="" disabled {{ $motherEdu ? '' : 'selected' }}>Pilih Pendidikan Terakhir</option>
                                        @foreach (['SD' => 'SD / Sederajat', 'SMP' => 'SMP / Sederajat', 'SMA/SMK' => 'SMA / SMK / Sederajat', 'D1/D2/D3' => 'D1 / D2 / D3', 'S1/D4' => 'S1 / D4', 'S2' => 'S2', 'S3' => 'S3', 'Tidak Sekolah' => 'Tidak Sekolah'] as $val => $lbl)
                                            <option value="{{ $val }}" {{ $motherEdu == $val ? 'selected' : '' }}>{{ $lbl }}</option>
                                        @endforeach
                                    </select>
                                    @error('families.mother.education')
                                        <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="space-y-1.5">
                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Pekerjaan
                                        <span class="text-[#B11116]">*</span></label>
                                    <input type="text" name="families[mother][work]" required
                                        value="{{ old('families.mother.work', $mother?->work) }}"
                                        placeholder="Contoh: Ibu Rumah Tangga / Wirausaha"
                                        class="uppercase placeholder:normal-case w-full px-4 py-2.5 bg-white rounded-xl border @error('families.mother.work') border-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                    @error('families.mother.work')
                                        <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="space-y-1.5 md:col-span-2">
                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">No.
                                        Telepon / WA <span class="text-[#B11116]">*</span></label>
                                    <input type="tel" name="families[mother][phone_number]" required
                                        inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                        value="{{ old('families.mother.phone_number', $mother?->phone_number) }}"
                                        placeholder="Contoh: 081234567890"
                                        class="w-full px-4 py-2.5 bg-white rounded-xl border @error('families.mother.phone_number') border-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                    @error('families.mother.phone_number')
                                        <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Data Saudara -->
                        <div class="space-y-4 pt-2">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-xs font-bold text-gray-800 uppercase tracking-wider">3. Data Saudara
                                        Kandung (Opsional)</h3>
                                    <p class="text-xs text-gray-500">Tambahkan informasi kakak/adik kandung Anda jika ada.
                                    </p>
                                </div>
                                <button type="button" onclick="addSiblingRow()"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-50 hover:bg-red-100 text-[#B11116] rounded-xl text-xs font-bold transition-all active:scale-95 cursor-pointer">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                    Tambah Saudara
                                </button>
                            </div>

                            <div id="siblingContainer" class="space-y-4">
                                @if (!empty($oldSiblings))
                                    @foreach ($oldSiblings as $sIndex => $sibling)
                                        <div class="bg-gray-50 rounded-2xl p-5 border border-gray-200 space-y-4 relative group" id="sibling_row_{{ $sIndex }}">
                                            <div class="flex items-center justify-between pb-2 border-b border-gray-200">
                                                <span class="text-xs font-bold text-gray-700 uppercase tracking-wider">Saudara Kandung {{ $loop->iteration }}</span>
                                                <button type="button" onclick="removeRow('sibling_row_{{ $sIndex }}')" class="text-red-500 hover:text-red-700 text-xs font-bold flex items-center gap-1 cursor-pointer">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                    Hapus
                                                </button>
                                            </div>
                                            <input type="hidden" name="families[siblings][{{ $sIndex }}][family_type]" value="biological">
                                            <input type="hidden" name="families[siblings][{{ $sIndex }}][relationship]" value="sibling">

                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div class="space-y-1.5">
                                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Nama Lengkap</label>
                                                    <input type="text" name="families[siblings][{{ $sIndex }}][name]" required value="{{ $sibling['name'] ?? '' }}" placeholder="Nama Lengkap Saudara Kandung" class="uppercase placeholder:normal-case w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                                    @error('families.siblings.'.$sIndex.'.name')
                                                        <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="space-y-1.5">
                                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Jenis Kelamin <span class="text-[#B11116]">*</span></label>
                                                    <select name="families[siblings][{{ $sIndex }}][gender]" required class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                                        <option value="" disabled {{ empty($sibling['gender']) ? 'selected' : '' }}>Pilih Jenis Kelamin</option>
                                                        <option value="l" {{ ($sibling['gender'] ?? '') === 'l' ? 'selected' : '' }}>Laki-Laki (L)</option>
                                                        <option value="p" {{ ($sibling['gender'] ?? '') === 'p' ? 'selected' : '' }}>Perempuan (P)</option>
                                                    </select>
                                                    @error('families.siblings.'.$sIndex.'.gender')
                                                        <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="space-y-1.5">
                                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Tempat Lahir</label>
                                                    <input type="text" name="families[siblings][{{ $sIndex }}][place_of_birth]" required value="{{ $sibling['place_of_birth'] ?? '' }}" placeholder="Kota Lahir" class="uppercase placeholder:normal-case w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                                    @error('families.siblings.'.$sIndex.'.place_of_birth')
                                                        <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="space-y-1.5">
                                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Tanggal Lahir</label>
                                                    <input type="date" name="families[siblings][{{ $sIndex }}][date_of_birth]" required value="{{ $sibling['date_of_birth'] ?? '' }}" class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                                    @error('families.siblings.'.$sIndex.'.date_of_birth')
                                                        <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="space-y-1.5">
                                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Pendidikan Terakhir</label>
                                                    <select name="families[siblings][{{ $sIndex }}][education]" required class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                                        <option value="" disabled {{ empty($sibling['education']) ? 'selected' : '' }}>Pilih Pendidikan Terakhir</option>
                                                        @foreach (['SD' => 'SD / Sederajat', 'SMP' => 'SMP / Sederajat', 'SMA/SMK' => 'SMA / SMK / Sederajat', 'D1/D2/D3' => 'D1 / D2 / D3', 'S1/D4' => 'S1 / D4', 'S2' => 'S2', 'S3' => 'S3', 'Belum Sekolah' => 'Belum Sekolah', 'Tidak Sekolah' => 'Tidak Sekolah'] as $val => $lbl)
                                                            <option value="{{ $val }}" {{ ($sibling['education'] ?? '') == $val ? 'selected' : '' }}>{{ $lbl }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('families.siblings.'.$sIndex.'.education')
                                                        <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="space-y-1.5">
                                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Pekerjaan</label>
                                                    <input type="text" name="families[siblings][{{ $sIndex }}][work]" required value="{{ $sibling['work'] ?? '' }}" placeholder="Pekerjaan / Pelajar" class="uppercase placeholder:normal-case w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                                    @error('families.siblings.'.$sIndex.'.work')
                                                        <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="space-y-1.5 md:col-span-2">
                                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">No. Telepon / WA</label>
                                                    <input type="tel" name="families[siblings][{{ $sIndex }}][phone_number]" required inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '');" value="{{ $sibling['phone_number'] ?? '' }}" placeholder="Contoh: 081234567890" class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                                    @error('families.siblings.'.$sIndex.'.phone_number')
                                                        <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </section>

                    @php
                        $isMarriedOrHasNuclear = in_array(auth()->user()->applicant->marital_status ?? 'single', [
                            'married',
                            'divorced',
                            'widowed',
                        ]);
                    @endphp

                    @if ($isMarriedOrHasNuclear)
                        <section class="space-y-6 pt-6 border-t border-gray-200">
                            <div class="flex items-center gap-3 pb-2 border-b border-gray-100">
                                <div class="p-2 bg-red-50 text-[#B11116] rounded-xl">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-base font-bold text-gray-900">Keluarga Inti (Pasangan & Anak)</h2>
                                    <p class="text-xs text-gray-500">Terdeteksi status pernikahan Anda. Harap lengkapi data
                                        pasangan dan anak (jika ada).</p>
                                </div>
                            </div>

                            <!-- Data Pasangan -->
                            <div class="bg-gray-50/70 rounded-2xl p-5 border border-gray-200 space-y-4">
                                <h3
                                    class="text-xs font-bold text-[#B11116] uppercase tracking-wider flex items-center gap-2">
                                    <span>Data Suami / Istri</span>
                                    <span class="text-[#B11116]">*</span>
                                </h3>
                                <input type="hidden" name="families[spouse][family_type]" value="nuclear">
                                <input type="hidden" name="families[spouse][relationship]" value="spouse">

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="space-y-1.5 md:col-span-2">
                                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Nama
                                            Lengkap Pasangan <span class="text-[#B11116]">*</span></label>
                                        <input type="text" name="families[spouse][name]" required
                                            value="{{ old('families.spouse.name', $spouse?->name) }}"
                                            placeholder="Nama Lengkap Suami / Istri"
                                            class="uppercase placeholder:normal-case w-full px-4 py-2.5 bg-white rounded-xl border @error('families.spouse.name') border-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                        @error('families.spouse.name')
                                            <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="space-y-1.5">
                                        <label
                                            class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Tempat
                                            Lahir <span class="text-[#B11116]">*</span></label>
                                        <input type="text" name="families[spouse][place_of_birth]" required
                                            value="{{ old('families.spouse.place_of_birth', $spouse?->place_of_birth) }}"
                                            placeholder="Kota Lahir Pasangan"
                                            class="uppercase placeholder:normal-case w-full px-4 py-2.5 bg-white rounded-xl border @error('families.spouse.place_of_birth') border-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                        @error('families.spouse.place_of_birth')
                                            <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="space-y-1.5">
                                        <label
                                            class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Tanggal
                                            Lahir <span class="text-[#B11116]">*</span></label>
                                        <input type="date" name="families[spouse][date_of_birth]" required
                                            value="{{ old('families.spouse.date_of_birth', $spouse?->date_of_birth ? \Carbon\Carbon::parse($spouse->date_of_birth)->format('Y-m-d') : '') }}"
                                            class="w-full px-4 py-2.5 bg-white rounded-xl border @error('families.spouse.date_of_birth') border-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                        @error('families.spouse.date_of_birth')
                                            <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="space-y-1.5">
                                        <label
                                            class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Pendidikan
                                            Terakhir <span class="text-[#B11116]">*</span></label>
                                        @php
                                            $spouseEdu = old('families.spouse.education', $spouse?->education);
                                        @endphp
                                        <select name="families[spouse][education]" required
                                            class="w-full px-4 py-2.5 bg-white rounded-xl border @error('families.spouse.education') border-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                            <option value="" disabled {{ $spouseEdu ? '' : 'selected' }}>Pilih Pendidikan Terakhir</option>
                                            @foreach (['SD' => 'SD / Sederajat', 'SMP' => 'SMP / Sederajat', 'SMA/SMK' => 'SMA / SMK / Sederajat', 'D1/D2/D3' => 'D1 / D2 / D3', 'S1/D4' => 'S1 / D4', 'S2' => 'S2', 'S3' => 'S3', 'Tidak Sekolah' => 'Tidak Sekolah'] as $val => $lbl)
                                                <option value="{{ $val }}" {{ $spouseEdu == $val ? 'selected' : '' }}>{{ $lbl }}</option>
                                            @endforeach
                                        </select>
                                        @error('families.spouse.education')
                                            <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="space-y-1.5">
                                        <label
                                            class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Pekerjaan
                                            <span class="text-[#B11116]">*</span></label>
                                        <input type="text" name="families[spouse][work]" required
                                            value="{{ old('families.spouse.work', $spouse?->work) }}" placeholder="Pekerjaan Pasangan"
                                            class="uppercase placeholder:normal-case w-full px-4 py-2.5 bg-white rounded-xl border @error('families.spouse.work') border-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                        @error('families.spouse.work')
                                            <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="space-y-1.5 md:col-span-2">
                                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">No.
                                            Telepon / WA <span class="text-[#B11116]">*</span></label>
                                        <input type="tel" name="families[spouse][phone_number]" required
                                            inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                            value="{{ old('families.spouse.phone_number', $spouse?->phone_number) }}"
                                            placeholder="Contoh: 081234567890"
                                            class="w-full px-4 py-2.5 bg-white rounded-xl border @error('families.spouse.phone_number') border-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                        @error('families.spouse.phone_number')
                                            <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Data Orang Tua Mertua (Opsional) -->
                            <div class="bg-gray-50/70 rounded-2xl p-5 border border-gray-200 space-y-6">
                                <div class="border-b border-gray-200/80 pb-3">
                                    <h3 class="text-xs font-bold text-gray-800 uppercase tracking-wider flex items-center gap-2">
                                        <span>Data Orang Tua Mertua</span>
                                        <span class="text-[11px] font-normal text-gray-400 capitalize">(Opsional)</span>
                                    </h3>
                                    <p class="text-xs text-gray-500 mt-0.5">Isi data ayah mertua dan ibu mertua jika berkenan.</p>
                                </div>

                                <!-- Ayah Mertua -->
                                <div class="space-y-4">
                                    <h4 class="text-xs font-bold text-gray-700 uppercase tracking-wider flex items-center gap-2">
                                        <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                        Ayah Mertua
                                    </h4>
                                    <input type="hidden" name="families[father_in_law][family_type]" value="nuclear">
                                    <input type="hidden" name="families[father_in_law][relationship]" value="father_in_law">
                                    <input type="hidden" name="families[father_in_law][gender]" value="l">

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="space-y-1.5 md:col-span-2">
                                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Nama Lengkap Ayah Mertua</label>
                                            <input type="text" name="families[father_in_law][name]"
                                                value="{{ old('families.father_in_law.name', $fatherInLaw?->name) }}"
                                                placeholder="Nama Lengkap Ayah Mertua"
                                                class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                        </div>
                                        <div class="space-y-1.5">
                                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Tempat Lahir</label>
                                            <input type="text" name="families[father_in_law][place_of_birth]"
                                                value="{{ old('families.father_in_law.place_of_birth', $fatherInLaw?->place_of_birth) }}"
                                                placeholder="Kota Lahir"
                                                class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                        </div>
                                        <div class="space-y-1.5">
                                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Tanggal Lahir</label>
                                            <input type="date" name="families[father_in_law][date_of_birth]"
                                                value="{{ old('families.father_in_law.date_of_birth', $fatherInLaw?->date_of_birth ? \Carbon\Carbon::parse($fatherInLaw->date_of_birth)->format('Y-m-d') : '') }}"
                                                class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                        </div>
                                        <div class="space-y-1.5">
                                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Pendidikan Terakhir</label>
                                            @php
                                                $filEdu = old('families.father_in_law.education', $fatherInLaw?->education);
                                            @endphp
                                            <select name="families[father_in_law][education]"
                                                class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                                <option value="" {{ $filEdu ? '' : 'selected' }}>Pilih Pendidikan (Opsional)</option>
                                                @foreach (['SD' => 'SD / Sederajat', 'SMP' => 'SMP / Sederajat', 'SMA/SMK' => 'SMA / SMK / Sederajat', 'D1/D2/D3' => 'D1 / D2 / D3', 'S1/D4' => 'S1 / D4', 'S2' => 'S2', 'S3' => 'S3', 'Tidak Sekolah' => 'Tidak Sekolah'] as $val => $lbl)
                                                    <option value="{{ $val }}" {{ $filEdu == $val ? 'selected' : '' }}>{{ $lbl }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="space-y-1.5">
                                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Pekerjaan</label>
                                            <input type="text" name="families[father_in_law][work]"
                                                value="{{ old('families.father_in_law.work', $fatherInLaw?->work) }}"
                                                placeholder="Pekerjaan Ayah Mertua"
                                                class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                        </div>
                                        <div class="space-y-1.5 md:col-span-2">
                                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">No. Telepon / WA</label>
                                            <input type="tel" name="families[father_in_law][phone_number]"
                                                inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                                value="{{ old('families.father_in_law.phone_number', $fatherInLaw?->phone_number) }}"
                                                placeholder="Contoh: 081234567890 (atau isi 0 jika tidak ada)"
                                                class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                        </div>
                                    </div>
                                </div>

                                <div class="border-t border-gray-200/70 pt-4 space-y-4">
                                    <h4 class="text-xs font-bold text-gray-700 uppercase tracking-wider flex items-center gap-2">
                                        <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                        Ibu Mertua
                                    </h4>
                                    <input type="hidden" name="families[mother_in_law][family_type]" value="nuclear">
                                    <input type="hidden" name="families[mother_in_law][relationship]" value="mother_in_law">
                                    <input type="hidden" name="families[mother_in_law][gender]" value="p">

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="space-y-1.5 md:col-span-2">
                                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Nama Lengkap Ibu Mertua</label>
                                            <input type="text" name="families[mother_in_law][name]"
                                                value="{{ old('families.mother_in_law.name', $motherInLaw?->name) }}"
                                                placeholder="Nama Lengkap Ibu Mertua"
                                                class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                        </div>
                                        <div class="space-y-1.5">
                                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Tempat Lahir</label>
                                            <input type="text" name="families[mother_in_law][place_of_birth]"
                                                value="{{ old('families.mother_in_law.place_of_birth', $motherInLaw?->place_of_birth) }}"
                                                placeholder="Kota Lahir"
                                                class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                        </div>
                                        <div class="space-y-1.5">
                                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Tanggal Lahir</label>
                                            <input type="date" name="families[mother_in_law][date_of_birth]"
                                                value="{{ old('families.mother_in_law.date_of_birth', $motherInLaw?->date_of_birth ? \Carbon\Carbon::parse($motherInLaw->date_of_birth)->format('Y-m-d') : '') }}"
                                                class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                        </div>
                                        <div class="space-y-1.5">
                                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Pendidikan Terakhir</label>
                                            @php
                                                $milEdu = old('families.mother_in_law.education', $motherInLaw?->education);
                                            @endphp
                                            <select name="families[mother_in_law][education]"
                                                class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                                <option value="" {{ $milEdu ? '' : 'selected' }}>Pilih Pendidikan (Opsional)</option>
                                                @foreach (['SD' => 'SD / Sederajat', 'SMP' => 'SMP / Sederajat', 'SMA/SMK' => 'SMA / SMK / Sederajat', 'D1/D2/D3' => 'D1 / D2 / D3', 'S1/D4' => 'S1 / D4', 'S2' => 'S2', 'S3' => 'S3', 'Tidak Sekolah' => 'Tidak Sekolah'] as $val => $lbl)
                                                    <option value="{{ $val }}" {{ $milEdu == $val ? 'selected' : '' }}>{{ $lbl }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="space-y-1.5">
                                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Pekerjaan</label>
                                            <input type="text" name="families[mother_in_law][work]"
                                                value="{{ old('families.mother_in_law.work', $motherInLaw?->work) }}"
                                                placeholder="Pekerjaan Ibu Mertua"
                                                class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                        </div>
                                        <div class="space-y-1.5 md:col-span-2">
                                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">No. Telepon / WA</label>
                                            <input type="tel" name="families[mother_in_law][phone_number]"
                                                inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                                value="{{ old('families.mother_in_law.phone_number', $motherInLaw?->phone_number) }}"
                                                placeholder="Contoh: 081234567890 (atau isi 0 jika tidak ada)"
                                                class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Data Anak -->
                            <div class="space-y-4 pt-2">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-xs font-bold text-gray-800 uppercase tracking-wider">Data Anak
                                            (Maksimal 3)</h3>
                                        <p class="text-xs text-gray-500">Tambahkan informasi anak kandung Anda jika ada.
                                        </p>
                                    </div>
                                    <button type="button" id="btnAddChild" onclick="addChildRow()"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-50 hover:bg-red-100 text-[#B11116] rounded-xl text-xs font-bold transition-all active:scale-95 cursor-pointer">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M12 4v16m8-8H4" />
                                        </svg>
                                        Tambah Anak
                                    </button>
                                </div>

                                <div id="childrenContainer" class="space-y-4">
                                    @if (!empty($oldChildren))
                                        @foreach ($oldChildren as $cIndex => $child)
                                            <div class="bg-gray-50 rounded-2xl p-5 border border-gray-200 space-y-4 relative group" id="child_row_{{ $cIndex }}">
                                                <div class="flex items-center justify-between pb-2 border-b border-gray-200">
                                                    <span class="text-xs font-bold text-gray-700 uppercase tracking-wider">Anak Ke-{{ $loop->iteration }}</span>
                                                    <button type="button" onclick="removeRow('child_row_{{ $cIndex }}', true)" class="text-red-500 hover:text-red-700 text-xs font-bold flex items-center gap-1 cursor-pointer">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                        Hapus
                                                    </button>
                                                </div>
                                                <input type="hidden" name="families[children][{{ $cIndex }}][family_type]" value="nuclear">
                                                <input type="hidden" name="families[children][{{ $cIndex }}][relationship]" value="child">

                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                    <div class="space-y-1.5">
                                                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Nama Lengkap Anak</label>
                                                        <input type="text" name="families[children][{{ $cIndex }}][name]" required value="{{ $child['name'] ?? '' }}" placeholder="Nama Lengkap Anak" class="uppercase placeholder:normal-case w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                                        @error('families.children.'.$cIndex.'.name')
                                                            <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                    <div class="space-y-1.5">
                                                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Jenis Kelamin <span class="text-[#B11116]">*</span></label>
                                                        <select name="families[children][{{ $cIndex }}][gender]" required class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                                            <option value="" disabled {{ empty($child['gender']) ? 'selected' : '' }}>Pilih Jenis Kelamin</option>
                                                            <option value="l" {{ ($child['gender'] ?? '') === 'l' ? 'selected' : '' }}>Laki-Laki (L)</option>
                                                            <option value="p" {{ ($child['gender'] ?? '') === 'p' ? 'selected' : '' }}>Perempuan (P)</option>
                                                        </select>
                                                        @error('families.children.'.$cIndex.'.gender')
                                                            <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                    <div class="space-y-1.5">
                                                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Tempat Lahir</label>
                                                        <input type="text" name="families[children][{{ $cIndex }}][place_of_birth]" required value="{{ $child['place_of_birth'] ?? '' }}" placeholder="Kota Lahir" class="uppercase placeholder:normal-case w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                                        @error('families.children.'.$cIndex.'.place_of_birth')
                                                            <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                    <div class="space-y-1.5">
                                                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Tanggal Lahir</label>
                                                        <input type="date" name="families[children][{{ $cIndex }}][date_of_birth]" required value="{{ $child['date_of_birth'] ?? '' }}" class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                                        @error('families.children.'.$cIndex.'.date_of_birth')
                                                            <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                    <div class="space-y-1.5">
                                                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Pendidikan / Sekolah</label>
                                                        <select name="families[children][{{ $cIndex }}][education]" required class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                                            <option value="" disabled {{ empty($child['education']) ? 'selected' : '' }}>Pilih Jenjang Pendidikan</option>
                                                            @foreach (['Belum Sekolah' => 'Belum Sekolah', 'PAUD/TK' => 'PAUD / TK', 'SD' => 'SD / Sederajat', 'SMP' => 'SMP / Sederajat', 'SMA/SMK' => 'SMA / SMK / Sederajat', 'D1/D2/D3' => 'D1 / D2 / D3', 'S1/D4' => 'S1 / D4', 'S2' => 'S2'] as $val => $lbl)
                                                                <option value="{{ $val }}" {{ ($child['education'] ?? '') == $val ? 'selected' : '' }}>{{ $lbl }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('families.children.'.$cIndex.'.education')
                                                            <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                    <div class="space-y-1.5">
                                                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Pekerjaan</label>
                                                        <input type="text" name="families[children][{{ $cIndex }}][work]" required value="{{ $child['work'] ?? '' }}" placeholder="Contoh: Pelajar / Belum Bekerja" class="uppercase placeholder:normal-case w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                                        @error('families.children.'.$cIndex.'.work')
                                                            <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                    <div class="space-y-1.5 md:col-span-2">
                                                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">No. Telepon / WA (Jika ada)</label>
                                                        <input type="tel" name="families[children][{{ $cIndex }}][phone_number]" required inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '');" value="{{ $child['phone_number'] ?? '' }}" placeholder="Contoh: 081234567890 / 0 jika belum punya" class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                                        @error('families.children.'.$cIndex.'.phone_number')
                                                            <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </section>
                    @endif

                    <div class="pt-8 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4 mt-8">
                        <div class="flex items-center gap-3 w-full sm:w-auto">
                            <a href="{{ route('biodata.edit', auth()->user()->applicant->id) }}"
                                class="w-full sm:w-auto px-6 py-3 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 font-bold text-sm rounded-xl transition-all inline-flex items-center justify-center gap-2 cursor-pointer">
                                Kembali ke Langkah 1
                            </a>
                        </div>

                        <button type="submit" id="btnSubmit"
                            class="w-full sm:w-auto px-8 py-3 bg-[#B11116] hover:bg-red-800 text-white font-bold text-sm rounded-xl shadow-md transition-all flex items-center justify-center gap-2 cursor-pointer focus:ring-4 focus:ring-red-200 disabled:opacity-50 disabled:cursor-not-allowed active:scale-95">
                            <span id="btnText">Simpan & Lanjut ke Langkah 3</span>
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

    <script>
        let siblingIndex = {{ !empty($oldSiblings) ? max(array_keys($oldSiblings)) : 0 }};
        let childIndex = {{ !empty($oldChildren) ? max(array_keys($oldChildren)) : 0 }};
        const maxChildren = 3;

        function goToStep(step) {
            const redirectInput = document.getElementById('redirect_step');
            if (redirectInput) {
                redirectInput.value = step;
            }

            const familyForm = document.getElementById('familyForm');
            if (familyForm) {
                if (familyForm.reportValidity && !familyForm.reportValidity()) {
                    return;
                }
                familyForm.submit();
            }
        }

        function addSiblingRow() {
            siblingIndex++;
            const container = document.getElementById('siblingContainer');
            const currentSiblingsCount = document.querySelectorAll('[id^="sibling_row_"]').length + 1;
            const html = `
                <div class="bg-gray-50 rounded-2xl p-5 border border-gray-200 space-y-4 relative group" id="sibling_row_${siblingIndex}">
                    <div class="flex items-center justify-between pb-2 border-b border-gray-200">
                        <span class="text-xs font-bold text-gray-700 uppercase tracking-wider">Saudara Kandung ${currentSiblingsCount}</span>
                        <button type="button" onclick="removeRow('sibling_row_${siblingIndex}')" class="text-red-500 hover:text-red-700 text-xs font-bold flex items-center gap-1 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            Hapus
                        </button>
                    </div>
                    <input type="hidden" name="families[siblings][${siblingIndex}][family_type]" value="biological">
                    <input type="hidden" name="families[siblings][${siblingIndex}][relationship]" value="sibling">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Nama Lengkap</label>
                            <input type="text" name="families[siblings][${siblingIndex}][name]" required placeholder="Nama Lengkap Saudara Kandung" class="uppercase placeholder:normal-case w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Jenis Kelamin <span class="text-[#B11116]">*</span></label>
                            <select name="families[siblings][${siblingIndex}][gender]" required class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                <option value="l">Laki-Laki (L)</option>
                                <option value="p">Perempuan (P)</option>
                            </select>
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Tempat Lahir</label>
                            <input type="text" name="families[siblings][${siblingIndex}][place_of_birth]" required placeholder="Kota Lahir" class="uppercase placeholder:normal-case w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Tanggal Lahir</label>
                            <input type="date" name="families[siblings][${siblingIndex}][date_of_birth]" required class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Pendidikan Terakhir</label>
                            <select name="families[siblings][${siblingIndex}][education]" required class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                <option value="" disabled selected>Pilih Pendidikan Terakhir</option>
                                <option value="SD">SD / Sederajat</option>
                                <option value="SMP">SMP / Sederajat</option>
                                <option value="SMA/SMK">SMA / SMK / Sederajat</option>
                                <option value="D1/D2/D3">D1 / D2 / D3</option>
                                <option value="S1/D4">S1 / D4</option>
                                <option value="S2">S2</option>
                                <option value="S3">S3</option>
                                <option value="Belum Sekolah">Belum Sekolah</option>
                                <option value="Tidak Sekolah">Tidak Sekolah</option>
                            </select>
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Pekerjaan</label>
                            <input type="text" name="families[siblings][${siblingIndex}][work]" required placeholder="Pekerjaan / Pelajar" class="uppercase placeholder:normal-case w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                        </div>
                        <div class="space-y-1.5 md:col-span-2">
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">No. Telepon / WA</label>
                            <input type="tel" name="families[siblings][${siblingIndex}][phone_number]" required inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '');" placeholder="Contoh: 081234567890" class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                        </div>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
        }

        function addChildRow() {
            const currentChildrenCount = document.querySelectorAll('[id^="child_row_"]').length;
            if (currentChildrenCount >= maxChildren) {
                if (typeof showToast === 'function') {
                    showToast('warning', 'Batas Maksimum Tercapai', 'Maksimal data anak yang dapat ditambahkan adalah ' + maxChildren);
                }
                return;
            }

            childIndex++;
            const container = document.getElementById('childrenContainer');
            const html = `
                <div class="bg-gray-50 rounded-2xl p-5 border border-gray-200 space-y-4 relative group" id="child_row_${childIndex}">
                    <div class="flex items-center justify-between pb-2 border-b border-gray-200">
                        <span class="text-xs font-bold text-gray-700 uppercase tracking-wider">Anak Ke-${currentChildrenCount + 1}</span>
                        <button type="button" onclick="removeRow('child_row_${childIndex}', true)" class="text-red-500 hover:text-red-700 text-xs font-bold flex items-center gap-1 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            Hapus
                        </button>
                    </div>
                    <input type="hidden" name="families[children][${childIndex}][family_type]" value="nuclear">
                    <input type="hidden" name="families[children][${childIndex}][relationship]" value="child">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Nama Lengkap Anak</label>
                            <input type="text" name="families[children][${childIndex}][name]" required placeholder="Nama Lengkap Anak" class="uppercase placeholder:normal-case w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Jenis Kelamin <span class="text-[#B11116]">*</span></label>
                            <select name="families[children][${childIndex}][gender]" required class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                <option value="l">Laki-Laki (L)</option>
                                <option value="p">Perempuan (P)</option>
                            </select>
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Tempat Lahir</label>
                            <input type="text" name="families[children][${childIndex}][place_of_birth]" required placeholder="Kota Lahir" class="uppercase placeholder:normal-case w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Tanggal Lahir</label>
                            <input type="date" name="families[children][${childIndex}][date_of_birth]" required class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Pendidikan / Sekolah</label>
                            <select name="families[children][${childIndex}][education]" required class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                <option value="" disabled selected>Pilih Jenjang Pendidikan</option>
                                <option value="Belum Sekolah">Belum Sekolah</option>
                                <option value="PAUD/TK">PAUD / TK</option>
                                <option value="SD">SD / Sederajat</option>
                                <option value="SMP">SMP / Sederajat</option>
                                <option value="SMA/SMK">SMA / SMK / Sederajat</option>
                                <option value="D1/D2/D3">D1 / D2 / D3</option>
                                <option value="S1/D4">S1 / D4</option>
                                <option value="S2">S2</option>
                            </select>
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Pekerjaan</label>
                            <input type="text" name="families[children][${childIndex}][work]" required placeholder="Contoh: Pelajar / Belum Bekerja" class="uppercase placeholder:normal-case w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                        </div>
                        <div class="space-y-1.5 md:col-span-2">
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">No. Telepon / WA (Jika ada)</label>
                            <input type="tel" name="families[children][${childIndex}][phone_number]" required inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '');" placeholder="Contoh: 081234567890 / 0 jika belum punya" class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                        </div>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
            updateAddChildButtonState();
        }

        function removeRow(rowId, isChild = false) {
            const row = document.getElementById(rowId);
            if (row) {
                row.remove();
            }
            if (isChild) {
                updateAddChildButtonState();
            }
        }

        function updateAddChildButtonState() {
            const btnAddChild = document.getElementById('btnAddChild');
            if (btnAddChild) {
                const currentChildrenCount = document.querySelectorAll('[id^="child_row_"]').length;
                if (currentChildrenCount >= maxChildren) {
                    btnAddChild.classList.add('opacity-50', 'cursor-not-allowed');
                } else {
                    btnAddChild.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const familyForm = document.getElementById('familyForm');
            const btnSubmit = document.getElementById('btnSubmit');
            const btnText = document.getElementById('btnText');
            const btnLoadingText = document.getElementById('btnLoadingText');
            const btnArrow = document.getElementById('btnArrow');

            if (familyForm && btnSubmit) {
                familyForm.addEventListener('submit', function() {
                    btnSubmit.disabled = true;
                    if (btnText) btnText.classList.add('hidden');
                    if (btnArrow) btnArrow.classList.add('hidden');
                    if (btnLoadingText) btnLoadingText.classList.remove('hidden');
                });
            }

            updateAddChildButtonState();
        });
    </script>
@endsection
