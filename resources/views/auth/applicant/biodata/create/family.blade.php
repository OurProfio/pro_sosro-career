@extends('auth.applicant.layouts.index')

@section('title', 'Data Keluarga Pelamar')

@section('content')
    <div class="py-8 md:py-12 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto font-figtree">
        <div class="mb-10">
            <ol class="flex items-center w-full text-xs font-semibold">
                <li class="flex items-center transition-colors text-[#B11116]">
                    <span
                        class="flex items-center justify-center w-8 h-8 rounded-full border-2 mr-2 shadow-sm transition-all text-xs font-bold border-[#B11116] bg-[#B11116] text-white">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                        </svg>
                    </span>
                    <span class="hidden sm:inline">Data Personal</span>
                </li>

                <li class="flex-1 border-t-2 mx-2 sm:mx-4 transition-colors duration-300 border-[#B11116]"></li>

                <li class="flex items-center transition-colors text-[#B11116] font-bold">
                    <span
                        class="flex items-center justify-center w-8 h-8 rounded-full border-2 mr-2 shadow-sm transition-all text-xs font-bold border-[#B11116] bg-[#B11116] text-white">
                        <span>2</span>
                    </span>
                    <span class="hidden sm:inline">Keluarga</span>
                </li>

                <li class="flex-1 border-t-2 mx-2 sm:mx-4 transition-colors duration-300 border-gray-200"></li>

                <li class="flex items-center transition-colors text-gray-400">
                    <span
                        class="flex items-center justify-center w-8 h-8 rounded-full border-2 mr-2 shadow-sm transition-all text-xs font-bold border-gray-300 bg-white text-gray-400">
                        <span>3</span>
                    </span>
                    <span class="hidden sm:inline">Pendidikan</span>
                </li>

                <li class="flex-1 border-t-2 mx-2 sm:mx-4 transition-colors duration-300 border-gray-200"></li>

                <li class="flex items-center transition-colors text-gray-400">
                    <span
                        class="flex items-center justify-center w-8 h-8 rounded-full border-2 mr-2 shadow-sm transition-all text-xs font-bold border-gray-300 bg-white text-gray-400">
                        <span>4</span>
                    </span>
                    <span class="hidden sm:inline">Pengalaman</span>
                </li>
            </ol>
        </div>

        <form action="" method="POST" id="familyForm" novalidate>
            @csrf

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-6 sm:p-10 space-y-10">

                    <header class="pb-4 border-b border-gray-100">
                        <h1 class="text-2xl font-black text-gray-900 tracking-tight">
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
                                <div class="space-y-1.5 md:col-span-2">
                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Nama
                                        Lengkap Ayah <span class="text-[#B11116]">*</span></label>
                                    <input type="text" name="families[father][name]" required
                                        value="{{ old('families.father.name') }}" placeholder="Nama Lengkap Ayah Kandung"
                                        class="w-full px-4 py-2.5 bg-white rounded-xl border @error('families.father.name') border-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                    @error('families.father.name')
                                        <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="space-y-1.5">
                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Tempat
                                        Lahir <span class="text-[#B11116]">*</span></label>
                                    <input type="text" name="families[father][place_of_birth]" required
                                        value="{{ old('families.father.place_of_birth') }}" placeholder="Kota Lahir Ayah"
                                        class="w-full px-4 py-2.5 bg-white rounded-xl border @error('families.father.place_of_birth') border-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                    @error('families.father.place_of_birth')
                                        <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="space-y-1.5">
                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Tanggal
                                        Lahir <span class="text-[#B11116]">*</span></label>
                                    <input type="date" name="families[father][date_of_birth]" required
                                        value="{{ old('families.father.date_of_birth') }}"
                                        class="w-full px-4 py-2.5 bg-white rounded-xl border @error('families.father.date_of_birth') border-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                    @error('families.father.date_of_birth')
                                        <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="space-y-1.5">
                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Pendidikan
                                        Terakhir <span class="text-[#B11116]">*</span></label>
                                    <select name="families[father][education]" required
                                        class="w-full px-4 py-2.5 bg-white rounded-xl border @error('families.father.education') border-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                        <option value="" disabled
                                            {{ old('families.father.education') ? '' : 'selected' }}>Pilih Pendidikan
                                            Terakhir</option>
                                        <option value="SD"
                                            {{ old('families.father.education') == 'SD' ? 'selected' : '' }}>SD / Sederajat
                                        </option>
                                        <option value="SMP"
                                            {{ old('families.father.education') == 'SMP' ? 'selected' : '' }}>SMP /
                                            Sederajat</option>
                                        <option value="SMA/SMK"
                                            {{ old('families.father.education') == 'SMA/SMK' ? 'selected' : '' }}>SMA / SMK
                                            / Sederajat</option>
                                        <option value="D1/D2/D3"
                                            {{ old('families.father.education') == 'D1/D2/D3' ? 'selected' : '' }}>D1 / D2
                                            / D3</option>
                                        <option value="S1/D4"
                                            {{ old('families.father.education') == 'S1/D4' ? 'selected' : '' }}>S1 / D4
                                        </option>
                                        <option value="S2"
                                            {{ old('families.father.education') == 'S2' ? 'selected' : '' }}>S2</option>
                                        <option value="S3"
                                            {{ old('families.father.education') == 'S3' ? 'selected' : '' }}>S3</option>
                                        <option value="Tidak Sekolah"
                                            {{ old('families.father.education') == 'Tidak Sekolah' ? 'selected' : '' }}>
                                            Tidak Sekolah</option>
                                    </select>
                                    @error('families.father.education')
                                        <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="space-y-1.5">
                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Pekerjaan
                                        <span class="text-[#B11116]">*</span></label>
                                    <input type="text" name="families[father][work]" required
                                        value="{{ old('families.father.work') }}"
                                        placeholder="Contoh: PNS / Wirausaha / Pensiunan"
                                        class="w-full px-4 py-2.5 bg-white rounded-xl border @error('families.father.work') border-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                    @error('families.father.work')
                                        <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="space-y-1.5 md:col-span-2">
                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">No.
                                        Telepon / WA <span class="text-[#B11116]">*</span></label>
                                    <input type="tel" name="families[father][phone_number]" required
                                        inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                        value="{{ old('families.father.phone_number') }}"
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
                                <div class="space-y-1.5 md:col-span-2">
                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Nama
                                        Lengkap Ibu <span class="text-[#B11116]">*</span></label>
                                    <input type="text" name="families[mother][name]" required
                                        value="{{ old('families.mother.name') }}" placeholder="Nama Lengkap Ibu Kandung"
                                        class="w-full px-4 py-2.5 bg-white rounded-xl border @error('families.mother.name') border-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                    @error('families.mother.name')
                                        <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="space-y-1.5">
                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Tempat
                                        Lahir <span class="text-[#B11116]">*</span></label>
                                    <input type="text" name="families[mother][place_of_birth]" required
                                        value="{{ old('families.mother.place_of_birth') }}" placeholder="Kota Lahir Ibu"
                                        class="w-full px-4 py-2.5 bg-white rounded-xl border @error('families.mother.place_of_birth') border-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                    @error('families.mother.place_of_birth')
                                        <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="space-y-1.5">
                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Tanggal
                                        Lahir <span class="text-[#B11116]">*</span></label>
                                    <input type="date" name="families[mother][date_of_birth]" required
                                        value="{{ old('families.mother.date_of_birth') }}"
                                        class="w-full px-4 py-2.5 bg-white rounded-xl border @error('families.mother.date_of_birth') border-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                    @error('families.mother.date_of_birth')
                                        <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="space-y-1.5">
                                    <label
                                        class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Pendidikan
                                        Terakhir <span class="text-[#B11116]">*</span></label>
                                    <select name="families[mother][education]" required
                                        class="w-full px-4 py-2.5 bg-white rounded-xl border @error('families.mother.education') border-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                        <option value="" disabled
                                            {{ old('families.mother.education') ? '' : 'selected' }}>Pilih Pendidikan
                                            Terakhir</option>
                                        <option value="SD"
                                            {{ old('families.mother.education') == 'SD' ? 'selected' : '' }}>SD / Sederajat
                                        </option>
                                        <option value="SMP"
                                            {{ old('families.mother.education') == 'SMP' ? 'selected' : '' }}>SMP /
                                            Sederajat</option>
                                        <option value="SMA/SMK"
                                            {{ old('families.mother.education') == 'SMA/SMK' ? 'selected' : '' }}>SMA / SMK
                                            / Sederajat</option>
                                        <option value="D1/D2/D3"
                                            {{ old('families.mother.education') == 'D1/D2/D3' ? 'selected' : '' }}>D1 / D2
                                            / D3</option>
                                        <option value="S1/D4"
                                            {{ old('families.mother.education') == 'S1/D4' ? 'selected' : '' }}>S1 / D4
                                        </option>
                                        <option value="S2"
                                            {{ old('families.mother.education') == 'S2' ? 'selected' : '' }}>S2</option>
                                        <option value="S3"
                                            {{ old('families.mother.education') == 'S3' ? 'selected' : '' }}>S3</option>
                                        <option value="Tidak Sekolah"
                                            {{ old('families.mother.education') == 'Tidak Sekolah' ? 'selected' : '' }}>
                                            Tidak Sekolah</option>
                                    </select>
                                    @error('families.mother.education')
                                        <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="space-y-1.5">
                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Pekerjaan
                                        <span class="text-[#B11116]">*</span></label>
                                    <input type="text" name="families[mother][work]" required
                                        value="{{ old('families.mother.work') }}"
                                        placeholder="Contoh: Ibu Rumah Tangga / Wirausaha"
                                        class="w-full px-4 py-2.5 bg-white rounded-xl border @error('families.mother.work') border-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                    @error('families.mother.work')
                                        <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="space-y-1.5 md:col-span-2">
                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">No.
                                        Telepon / WA <span class="text-[#B11116]">*</span></label>
                                    <input type="tel" name="families[mother][phone_number]" required
                                        inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                        value="{{ old('families.mother.phone_number') }}"
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

                            <div id="siblingContainer" class="space-y-4"></div>
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
                                            value="{{ old('families.spouse.name') }}"
                                            placeholder="Nama Lengkap Suami / Istri"
                                            class="w-full px-4 py-2.5 bg-white rounded-xl border @error('families.spouse.name') border-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                        @error('families.spouse.name')
                                            <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="space-y-1.5">
                                        <label
                                            class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Tempat
                                            Lahir <span class="text-[#B11116]">*</span></label>
                                        <input type="text" name="families[spouse][place_of_birth]" required
                                            value="{{ old('families.spouse.place_of_birth') }}"
                                            placeholder="Kota Lahir Pasangan"
                                            class="w-full px-4 py-2.5 bg-white rounded-xl border @error('families.spouse.place_of_birth') border-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                        @error('families.spouse.place_of_birth')
                                            <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="space-y-1.5">
                                        <label
                                            class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Tanggal
                                            Lahir <span class="text-[#B11116]">*</span></label>
                                        <input type="date" name="families[spouse][date_of_birth]" required
                                            value="{{ old('families.spouse.date_of_birth') }}"
                                            class="w-full px-4 py-2.5 bg-white rounded-xl border @error('families.spouse.date_of_birth') border-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                        @error('families.spouse.date_of_birth')
                                            <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="space-y-1.5">
                                        <label
                                            class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Pendidikan
                                            Terakhir <span class="text-[#B11116]">*</span></label>
                                        <select name="families[spouse][education]" required
                                            class="w-full px-4 py-2.5 bg-white rounded-xl border @error('families.spouse.education') border-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                            <option value="" disabled
                                                {{ old('families.spouse.education') ? '' : 'selected' }}>Pilih Pendidikan
                                                Terakhir</option>
                                            <option value="SD"
                                                {{ old('families.spouse.education') == 'SD' ? 'selected' : '' }}>SD /
                                                Sederajat</option>
                                            <option value="SMP"
                                                {{ old('families.spouse.education') == 'SMP' ? 'selected' : '' }}>SMP /
                                                Sederajat</option>
                                            <option value="SMA/SMK"
                                                {{ old('families.spouse.education') == 'SMA/SMK' ? 'selected' : '' }}>SMA /
                                                SMK / Sederajat</option>
                                            <option value="D1/D2/D3"
                                                {{ old('families.spouse.education') == 'D1/D2/D3' ? 'selected' : '' }}>D1 /
                                                D2 / D3</option>
                                            <option value="S1/D4"
                                                {{ old('families.spouse.education') == 'S1/D4' ? 'selected' : '' }}>S1 / D4
                                            </option>
                                            <option value="S2"
                                                {{ old('families.spouse.education') == 'S2' ? 'selected' : '' }}>S2
                                            </option>
                                            <option value="S3"
                                                {{ old('families.spouse.education') == 'S3' ? 'selected' : '' }}>S3
                                            </option>
                                            <option value="Tidak Sekolah"
                                                {{ old('families.spouse.education') == 'Tidak Sekolah' ? 'selected' : '' }}>
                                                Tidak Sekolah</option>
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
                                            value="{{ old('families.spouse.work') }}" placeholder="Pekerjaan Pasangan"
                                            class="w-full px-4 py-2.5 bg-white rounded-xl border @error('families.spouse.work') border-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                        @error('families.spouse.work')
                                            <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="space-y-1.5 md:col-span-2">
                                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">No.
                                            Telepon / WA <span class="text-[#B11116]">*</span></label>
                                        <input type="tel" name="families[spouse][phone_number]" required
                                            inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                            value="{{ old('families.spouse.phone_number') }}"
                                            placeholder="Contoh: 081234567890"
                                            class="w-full px-4 py-2.5 bg-white rounded-xl border @error('families.spouse.phone_number') border-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                        @error('families.spouse.phone_number')
                                            <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                                        @enderror
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

                                <div id="childrenContainer" class="space-y-4"></div>
                            </div>
                        </section>
                    @endif

                    <div class="pt-8 border-t border-gray-100 flex items-center justify-between mt-8">
                        <a href="{{ route('biodata.edit', auth()->user()->applicant->id) }}"
                            class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-sm rounded-xl transition-all inline-flex items-center gap-2 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Kembali ke Step 1
                        </a>

                        <button type="submit" id="btnSubmit"
                            class="w-full sm:w-auto px-8 py-3 bg-[#B11116] hover:bg-red-800 text-white font-bold text-sm rounded-xl shadow-md transition-all flex items-center justify-center gap-2 cursor-pointer focus:ring-4 focus:ring-red-200 disabled:opacity-50 disabled:cursor-not-allowed active:scale-95">
                            <span id="btnText">Simpan & Lanjut ke Step 3</span>
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
        let siblingIndex = 0;
        let childIndex = 0;
        const maxChildren = 3;

        function addSiblingRow() {
            siblingIndex++;
            const container = document.getElementById('siblingContainer');
            const html = `
                <div class="bg-gray-50 rounded-2xl p-5 border border-gray-200 space-y-4 relative group" id="sibling_row_${siblingIndex}">
                    <div class="flex items-center justify-between pb-2 border-b border-gray-200">
                        <span class="text-xs font-bold text-gray-700 uppercase tracking-wider">Saudara Kandung ${siblingIndex}</span>
                        <button type="button" onclick="removeRow('sibling_row_${siblingIndex}')" class="text-red-500 hover:text-red-700 text-xs font-bold flex items-center gap-1 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            Hapus
                        </button>
                    </div>
                    <input type="hidden" name="families[siblings][${siblingIndex}][family_type]" value="biological">
                    <input type="hidden" name="families[siblings][${siblingIndex}][relationship]" value="sibling">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-1.5 md:col-span-2">
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Nama Lengkap</label>
                            <input type="text" name="families[siblings][${siblingIndex}][name]" required placeholder="Nama Lengkap Saudara Kandung" class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Tempat Lahir</label>
                            <input type="text" name="families[siblings][${siblingIndex}][place_of_birth]" required placeholder="Kota Lahir" class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
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
                            <input type="text" name="families[siblings][${siblingIndex}][work]" required placeholder="Pekerjaan / Pelajar" class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
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
                alert('Maksimal data anak yang dapat ditambahkan adalah ' + maxChildren);
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
                        <div class="space-y-1.5 md:col-span-2">
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Nama Lengkap Anak</label>
                            <input type="text" name="families[children][${childIndex}][name]" required placeholder="Nama Lengkap Anak" class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Tempat Lahir</label>
                            <input type="text" name="families[children][${childIndex}][place_of_birth]" required placeholder="Kota Lahir" class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
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
                            <input type="text" name="families[children][${childIndex}][work]" required placeholder="Contoh: Pelajar / Belum Bekerja" class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
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
        });
    </script>
@endsection
