@extends('auth.applicant.layouts.index')

@section('title', 'Biodata Pelamar')

@section('content')
    <div class="py-8 md:py-12 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto font-figtree">
        <div class="mb-10">
            <ol class="flex items-center w-full text-xs font-semibold">
                <li class="flex items-center transition-colors text-[#B11116] font-bold">
                    <span
                        class="flex items-center justify-center w-8 h-8 rounded-full border-2 mr-2 shadow-sm transition-all text-xs font-bold border-[#B11116] bg-[#B11116] text-white">
                        <span>1</span>
                    </span>
                    <span class="hidden sm:inline">Data Personal</span>
                </li>

                <li class="flex-1 border-t-2 mx-2 sm:mx-4 transition-colors duration-300 border-gray-200"></li>

                <li class="flex items-center transition-colors text-gray-400">
                    <span
                        class="flex items-center justify-center w-8 h-8 rounded-full border-2 mr-2 shadow-sm transition-all text-xs font-bold border-gray-300 bg-white text-gray-400">
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

        @if (session('warning') || request('required'))
            <div class="mb-6 p-4 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-xs font-medium flex items-center gap-2.5 shadow-sm">
                <svg class="w-5 h-5 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span>{{ session('warning') ?? 'Silakan lengkapi formulir biodata Anda terlebih dahulu sebelum dapat melamar lowongan pekerjaan.' }}</span>
            </div>
        @endif

        <form action="{{ route('biodata.store') }}" method="POST" id="biodataForm" enctype="multipart/form-data"
            novalidate>
            @csrf
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-6 sm:p-10">
                    <header class="mb-8 pb-4 border-b border-gray-100">
                        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">
                            Data <span class="text-[#B11116]">Personal</span>
                        </h1>
                        <p class="text-gray-500 text-sm mt-1">
                            Isi informasi identitas diri Anda secara akurat sesuai dengan dokumen resmi (KTP).
                        </p>
                    </header>

                    <!-- SEKSI UPLOAD FOTO PROFIL -->
                    <div class="mb-8 p-6 bg-gray-50/80 rounded-2xl border border-gray-200/80">
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-3">
                            Pas Foto Terbaru <span class="text-[#B11116]">*</span>
                        </label>
                        <div class="flex flex-col sm:flex-row items-center gap-6">
                            <!-- Preview Image Container -->
                            <div class="relative group shrink-0">
                                @php
                                    $savedPhoto = auth()->user()->applicant->photo_url ?? null;
                                @endphp
                                <div class="w-32 h-40 rounded-xl overflow-hidden border-2 border-dashed border-gray-300 bg-white flex items-center justify-center shadow-inner relative"
                                    id="photoPreviewContainer">
                                    <img id="photoPreview" src="{{ $savedPhoto ? asset('storage/' . $savedPhoto) : '' }}"
                                        alt="Pratinjau Foto"
                                        class="w-full h-full object-cover {{ $savedPhoto ? '' : 'hidden' }}">

                                    <div id="photoPlaceholder"
                                        class="flex flex-col items-center justify-center p-3 text-center text-gray-400 {{ $savedPhoto ? 'hidden' : '' }}">
                                        <svg class="w-10 h-10 mb-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        <span class="text-[10px] font-semibold uppercase tracking-wider">Foto Pelamar</span>
                                    </div>
                                </div>
                                <button type="button" id="btnRemovePhoto" title="Hapus foto"
                                    class="hidden absolute -top-2 -right-2 bg-red-600 hover:bg-red-700 text-white p-1.5 rounded-full shadow-md transition-all cursor-pointer">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <!-- File Upload Inputs & Requirements -->
                            <div class="flex-1 space-y-3 text-center sm:text-left">
                                <div class="flex flex-wrap items-center justify-center sm:justify-start gap-3">
                                    <label for="photo"
                                        class="px-4 py-2.5 bg-white hover:bg-gray-100 text-gray-700 font-bold text-xs rounded-xl border border-gray-300 transition-all cursor-pointer inline-flex items-center gap-2 shadow-sm active:scale-95">
                                        <svg class="w-4 h-4 text-[#B11116]" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        Pilih Berkas Foto
                                    </label>
                                    <input id="photo" name="photo" type="file" required
                                        accept="image/png, image/jpeg, image/jpg" class="hidden">
                                </div>
                                <p class="text-xs text-gray-500 leading-relaxed">
                                    Unggah pas foto formal berpakaian rapi dengan latar belakang polos. <br>
                                    Format: <strong class="text-gray-700">JPG, JPEG, PNG</strong> (Maksimal: <strong
                                        class="text-gray-700">2MB</strong>).
                                </p>
                                @error('photo')
                                    <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1.5">
                            <label for="nik" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                NIK (Sesuai KTP) <span class="text-[#B11116]">*</span>
                            </label>
                            <input id="nik" name="nik" type="text" inputmode="numeric" required
                                pattern="[0-9]{16}" maxlength="16"
                                value="{{ old('nik', auth()->user()->applicant->nik ?? '') }}"
                                placeholder="16 digit angka KTP"
                                class="w-full px-4 py-2.5 bg-white rounded-xl border @error('nik') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                            <span id="msg_nik" class="text-[11px] text-gray-400 block transition-colors">Harus berisi 16 digit angka.</span>
                            @error('nik')
                                <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1.5">
                            <label for="name" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Nama Lengkap <span class="text-[#B11116]">*</span>
                            </label>
                            <input id="name" name="name" type="text" required
                                value="{{ old('name', auth()->user()->applicant->name ?? '') }}"
                                placeholder="Nama Lengkap Sesuai KTP"
                                class="uppercase placeholder:normal-case w-full px-4 py-2.5 bg-white rounded-xl border @error('name') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                            @error('name')
                                <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1.5">
                            <label for="email" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Alamat Email Resmi <span class="text-[#B11116]">*</span>
                            </label>
                            <input id="email" name="email" type="email" required readonly
                                value="{{ old('email', auth()->user()->applicant->email ?? (auth()->user()->email ?? '')) }}"
                                placeholder="nama@email.com"
                                class="w-full px-4 py-2.5 bg-gray-100 rounded-xl border @error('email') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-600 text-sm transition-all outline-none shadow-sm cursor-not-allowed">
                            <span id="msg_email" class="text-[11px] text-gray-400 block transition-colors">Alamat email terdaftar akun Anda (tidak dapat diubah).</span>
                            @error('email')
                                <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1.5">
                            <label for="phone_number"
                                class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                No. Telepon / WA <span class="text-[#B11116]">*</span>
                            </label>
                            <input id="phone_number" name="phone_number" type="tel" inputmode="numeric" required
                                maxlength="15"
                                value="{{ old('phone_number', auth()->user()->applicant->phone_number ?? '') }}"
                                placeholder="Contoh: 081234567890"
                                class="w-full px-4 py-2.5 bg-white rounded-xl border @error('phone_number') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                            <span id="msg_phone_number" class="text-[11px] text-gray-400 block transition-colors">Nomor aktif WhatsApp (10-15 digit).</span>
                            @error('phone_number')
                                <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-4 md:col-span-2 pt-2 border-t border-gray-100">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="space-y-1.5 md:col-span-2">
                                    <label for="address_ktp"
                                        class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Alamat Lengkap (Sesuai KTP) <span class="text-[#B11116]">*</span>
                                    </label>
                                    <textarea id="address_ktp" name="address_ktp" rows="3" required
                                        placeholder="Jl. Nama Jalan, RT/RW, Kelurahan, Kecamatan, Kota/Kabupaten"
                                        class="uppercase placeholder:normal-case w-full px-4 py-2.5 bg-white rounded-xl border @error('address_ktp') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">{{ old('address_ktp', auth()->user()->applicant->address_ktp ?? '') }}</textarea>
                                    @error('address_ktp')
                                        <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="space-y-1.5">
                                    <label for="postal_code_ktp"
                                        class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Kode Pos KTP
                                    </label>
                                    <input id="postal_code_ktp" name="postal_code_ktp" type="text" inputmode="numeric" maxlength="5"
                                        value="{{ old('postal_code_ktp', auth()->user()->applicant->postal_code_ktp ?? '') }}"
                                        placeholder="Contoh: 12345"
                                        class="w-full px-4 py-2.5 bg-white rounded-xl border @error('postal_code_ktp') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                    <span id="msg_postal_code_ktp" class="text-[11px] text-gray-400 block transition-colors">5 digit kode pos.</span>
                                    @error('postal_code_ktp')
                                        <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="space-y-2 pt-2 border-t border-gray-100/60">
                                <div class="flex items-center justify-between">
                                    <label for="address_domisili"
                                        class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Alamat Domisili saat ini <span class="text-[#B11116]">*</span>
                                    </label>
                                    <label
                                        class="inline-flex items-center cursor-pointer select-none py-1 px-2 rounded-lg hover:bg-gray-50 transition-colors">
                                        <input type="checkbox" id="sameAddressCheckbox"
                                            class="rounded border-gray-300 text-[#B11116] focus:ring-[#B11116] w-4 h-4 cursor-pointer">
                                        <span class="ml-2 text-xs font-semibold text-gray-600">Sama dengan KTP</span>
                                    </label>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="space-y-1.5 md:col-span-2">
                                        <textarea id="address_domisili" name="address_domisili" rows="2" required
                                            placeholder="Alamat Domisili Tempat Tinggal Saat Ini"
                                            class="uppercase placeholder:normal-case w-full px-4 py-2.5 bg-white rounded-xl border @error('address_domisili') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">{{ old('address_domisili', auth()->user()->applicant->address_domisili ?? '') }}</textarea>
                                        @error('address_domisili')
                                            <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="space-y-1.5">
                                        <label for="postal_code_domisili"
                                            class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                            Kode Pos Domisili
                                        </label>
                                        <input id="postal_code_domisili" name="postal_code_domisili" type="text" inputmode="numeric" maxlength="5"
                                            value="{{ old('postal_code_domisili', auth()->user()->applicant->postal_code_domisili ?? '') }}"
                                            placeholder="Contoh: 12345"
                                            class="w-full px-4 py-2.5 bg-white rounded-xl border @error('postal_code_domisili') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                        <span id="msg_postal_code_domisili" class="text-[11px] text-gray-400 block transition-colors">5 digit kode pos.</span>
                                        @error('postal_code_domisili')
                                            <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-1.5 pt-2 border-t border-gray-100 md:border-t-0">
                            <span class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Jenis Kelamin <span class="text-[#B11116]">*</span>
                            </span>
                            <div class="flex items-center gap-6 py-2">
                                <label for="gender_l" class="inline-flex items-center cursor-pointer group py-1">
                                    <input id="gender_l" type="radio" name="gender" value="l" required
                                        {{ old('gender', auth()->user()->applicant->gender ?? '') == 'l' ? 'checked' : '' }}
                                        class="w-4 h-4 text-[#B11116] border-gray-300 focus:ring-[#B11116]">
                                    <span
                                        class="ml-2 text-sm font-medium text-gray-700 group-hover:text-gray-900">Laki-laki</span>
                                </label>
                                <label for="gender_p" class="inline-flex items-center cursor-pointer group py-1">
                                    <input id="gender_p" type="radio" name="gender" value="p" required
                                        {{ old('gender', auth()->user()->applicant->gender ?? '') == 'p' ? 'checked' : '' }}
                                        class="w-4 h-4 text-[#B11116] border-gray-300 focus:ring-[#B11116]">
                                    <span
                                        class="ml-2 text-sm font-medium text-gray-700 group-hover:text-gray-900">Perempuan</span>
                                </label>
                            </div>
                            @error('gender')
                                <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1.5 pt-2 border-t border-gray-100 md:border-t-0">
                            <label for="religion" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Agama <span class="text-[#B11116]">*</span>
                            </label>
                            <select id="religion" name="religion" required
                                class="w-full px-4 py-2.5 bg-white rounded-xl border @error('religion') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                <option value="" disabled
                                    {{ old('religion', auth()->user()->applicant->religion ?? '') ? '' : 'selected' }}>
                                    Pilih Agama</option>
                                @foreach ($religions as $rel)
                                    <option value="{{ $rel->RELIGION_ID }}"
                                        {{ old('religion', auth()->user()->applicant->religion ?? '') == $rel->RELIGION_ID ? 'selected' : '' }}>
                                        {{ $rel->RELIGION_NAME_ID ?? $rel->RELIGION_NAME_EN }}
                                    </option>
                                @endforeach
                            </select>
                            @error('religion')
                                <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1.5">
                            <label for="place_of_birth"
                                class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Tempat Lahir <span class="text-[#B11116]">*</span>
                            </label>
                            <input id="place_of_birth" name="place_of_birth" type="text" required
                                value="{{ old('place_of_birth', auth()->user()->applicant->place_of_birth ?? '') }}"
                                placeholder="Kota Lahir"
                                class="uppercase placeholder:normal-case w-full px-4 py-2.5 bg-white rounded-xl border @error('place_of_birth') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                            @error('place_of_birth')
                                <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1.5">
                            <label for="date_of_birth"
                                class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Tanggal Lahir <span class="text-[#B11116]">*</span>
                            </label>
                            <input id="date_of_birth" name="date_of_birth" type="date" required
                                max="{{ now()->subYears(15)->format('Y-m-d') }}"
                                value="{{ old('date_of_birth', auth()->user()->applicant->date_of_birth ?? '') }}"
                                class="w-full px-4 py-2.5 bg-white rounded-xl border @error('date_of_birth') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                            @error('date_of_birth')
                                <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1.5">
                            <label for="height" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Tinggi Badan (cm) <span class="text-[#B11116]">*</span>
                            </label>
                            <input id="height" name="height" type="number" min="100" max="250" required
                                value="{{ old('height', auth()->user()->applicant->height ?? '') }}"
                                placeholder="Contoh: 170"
                                class="w-full px-4 py-2.5 bg-white rounded-xl border @error('height') border-red-[#B11116] ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                            @error('height')
                                <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1.5">
                            <label for="weight" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Berat Badan (kg) <span class="text-[#B11116]">*</span>
                            </label>
                            <input id="weight" name="weight" type="number" min="30" max="200" required
                                value="{{ old('weight', auth()->user()->applicant->weight ?? '') }}"
                                placeholder="Contoh: 65"
                                class="w-full px-4 py-2.5 bg-white rounded-xl border @error('weight') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                            @error('weight')
                                <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1.5">
                            <label for="blood_type" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Golongan Darah <span class="text-[#B11116]">*</span>
                            </label>
                            <select id="blood_type" name="blood_type" required
                                class="w-full px-4 py-2.5 bg-white rounded-xl border @error('blood_type') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                <option value="" disabled {{ old('blood_type', auth()->user()->applicant->blood_type ?? '') ? '' : 'selected' }}>Pilih Golongan Darah</option>
                                @foreach (['A', 'B', 'AB', 'O'] as $blood)
                                    <option value="{{ $blood }}" {{ old('blood_type', auth()->user()->applicant->blood_type ?? '') == $blood ? 'selected' : '' }}>
                                        Golongan {{ $blood }}
                                    </option>
                                @endforeach
                            </select>
                            @error('blood_type')
                                <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1.5">
                            <label for="is_smoker" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Perokok? <span class="text-[#B11116]">*</span>
                            </label>
                            <select id="is_smoker" name="is_smoker" required
                                class="w-full px-4 py-2.5 bg-white rounded-xl border @error('is_smoker') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                <option value="" disabled
                                    {{ old('is_smoker', auth()->user()->applicant->is_smoker ?? '') == null ? 'selected' : '' }}>
                                    Pilih Jawaban</option>
                                <option value="n"
                                    {{ old('is_smoker', auth()->user()->applicant->is_smoker ?? '') === 'n' ? 'selected' : '' }}>
                                    Tidak</option>
                                <option value="y"
                                    {{ old('is_smoker', auth()->user()->applicant->is_smoker ?? '') === 'y' ? 'selected' : '' }}>
                                    Ya</option>
                            </select>
                            @error('is_smoker')
                                <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1.5">
                            <label for="has_tattoo"
                                class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Bertato? <span class="text-[#B11116]">*</span>
                            </label>
                            <select id="has_tattoo" name="has_tattoo" required
                                class="w-full px-4 py-2.5 bg-white rounded-xl border @error('has_tattoo') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                <option value="" disabled
                                    {{ old('has_tattoo', auth()->user()->applicant->has_tattoo ?? '') == null ? 'selected' : '' }}>
                                    Pilih Jawaban</option>
                                <option value="n"
                                    {{ old('has_tattoo', auth()->user()->applicant->has_tattoo ?? '') === 'n' ? 'selected' : '' }}>
                                    Tidak</option>
                                <option value="y"
                                    {{ old('has_tattoo', auth()->user()->applicant->has_tattoo ?? '') === 'y' ? 'selected' : '' }}>
                                    Ya</option>
                            </select>
                            @error('has_tattoo')
                                <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1.5">
                            <label for="marital_status"
                                class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Status Pernikahan <span class="text-[#B11116]">*</span>
                            </label>
                            <select id="marital_status" name="marital_status" required onchange="toggleMaritalDate(this.value)"
                                class="w-full px-4 py-2.5 bg-white rounded-xl border @error('marital_status') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                <option value="" disabled
                                    {{ old('marital_status', auth()->user()->applicant->marital_status ?? '') ? '' : 'selected' }}>
                                    Pilih Status</option>
                                <option value="single"
                                    {{ old('marital_status', auth()->user()->applicant->marital_status ?? '') == 'single' ? 'selected' : '' }}>
                                    Belum Menikah</option>
                                <option value="married"
                                    {{ old('marital_status', auth()->user()->applicant->marital_status ?? '') == 'married' ? 'selected' : '' }}>
                                    Sudah Menikah</option>
                                <option value="divorced"
                                    {{ old('marital_status', auth()->user()->applicant->marital_status ?? '') == 'divorced' ? 'selected' : '' }}>
                                    Cerai Hidup</option>
                                <option value="widowed"
                                    {{ old('marital_status', auth()->user()->applicant->marital_status ?? '') == 'widowed' ? 'selected' : '' }}>
                                    Cerai Mati</option>
                            </select>
                            @error('marital_status')
                                <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div id="maritalDateWrapper" class="space-y-1.5 md:col-span-2 {{ in_array(old('marital_status', auth()->user()->applicant->marital_status ?? ''), ['married', 'divorced', 'widowed']) ? '' : 'hidden' }}">
                            <label for="marital_date" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Tahun Menikah / Bercerai (Sejak Tahun)
                            </label>
                            <input id="marital_date" name="marital_date" type="number" min="1950" max="{{ date('Y') }}"
                                placeholder="Contoh: 2020"
                                value="{{ old('marital_date', auth()->user()->applicant->marital_date ?? '') }}"
                                class="w-full px-4 py-2.5 bg-white rounded-xl border @error('marital_date') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                            <span class="text-[11px] text-gray-400 block">Masukkan tahun (4 digit, contoh: 2020).</span>
                            @error('marital_date')
                                <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1.5">
                            <label for="instagram" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Akun Instagram
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-xs font-bold text-gray-400">@</span>
                                <input id="instagram" name="instagram" type="text"
                                    value="{{ old('instagram', auth()->user()->applicant->instagram ?? '') }}"
                                    placeholder="username_anda"
                                    class="w-full pl-9 pr-4 py-2.5 bg-white rounded-xl border @error('instagram') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                            </div>
                            <span class="text-[11px] text-gray-400 block">Cukup tulis username saja (tanpa link / URL).</span>
                            @error('instagram')
                                <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1.5">
                            <label for="linkedin" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Nama di LinkedIn
                            </label>
                            <input id="linkedin" name="linkedin" type="text"
                                value="{{ old('linkedin', auth()->user()->applicant->linkedin ?? '') }}"
                                placeholder="Contoh: Budi Santoso"
                                class="w-full px-4 py-2.5 bg-white rounded-xl border @error('linkedin') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                            <span class="text-[11px] text-gray-400 block">Tulis nama akun Anda di LinkedIn (jangan gunakan link/URL).</span>
                            @error('linkedin')
                                <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- SEKSI KONTAK DARURAT (EMERGENCY CONTACT) -->
                        <div class="md:col-span-2 p-5 bg-gray-50/90 rounded-2xl border border-gray-200/80 space-y-4">
                            <div class="flex items-center gap-2">
                                <div class="p-1.5 bg-red-100 text-[#B11116] rounded-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xs font-bold uppercase tracking-wider text-gray-800">
                                        Kontak Darurat (Emergency Contact) <span class="text-[#B11116]">*</span>
                                    </h3>
                                    <p class="text-[11px] text-gray-500">Wajib diisi: Keluarga atau kerabat terdekat yang dapat dihubungi saat situasi darurat.</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="space-y-1.5">
                                    <label for="emergency_contact_name" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Nama Kontak Darurat <span class="text-[#B11116]">*</span>
                                    </label>
                                    <input id="emergency_contact_name" name="emergency_contact_name" type="text" required
                                        value="{{ old('emergency_contact_name', auth()->user()->applicant->emergency_contact_name ?? '') }}"
                                        placeholder="Nama Lengkap Kerabat"
                                        class="uppercase placeholder:normal-case w-full px-4 py-2.5 bg-white rounded-xl border @error('emergency_contact_name') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                    @error('emergency_contact_name')
                                        <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="space-y-1.5">
                                    <label for="emergency_contact_relationship" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Hubungan <span class="text-[#B11116]">*</span>
                                    </label>
                                    <select id="emergency_contact_relationship" name="emergency_contact_relationship" required
                                        class="w-full px-4 py-2.5 bg-white rounded-xl border @error('emergency_contact_relationship') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                        <option value="" {{ old('emergency_contact_relationship', auth()->user()->applicant->emergency_contact_relationship ?? '') ? '' : 'selected' }}>Pilih Hubungan</option>
                                        @foreach (['Orang Tua', 'Pasangan (Suami/Istri)', 'Saudara Kandung', 'Kerabat/Keluarga Besar'] as $rel)
                                            <option value="{{ $rel }}" {{ old('emergency_contact_relationship', auth()->user()->applicant->emergency_contact_relationship ?? '') == $rel ? 'selected' : '' }}>{{ $rel }}</option>
                                        @endforeach
                                    </select>
                                    @error('emergency_contact_relationship')
                                        <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="space-y-1.5">
                                    <label for="emergency_contact_phone" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        No. Telepon / WA <span class="text-[#B11116]">*</span>
                                    </label>
                                    <input id="emergency_contact_phone" name="emergency_contact_phone" type="tel" inputmode="numeric" required
                                        maxlength="15"
                                        value="{{ old('emergency_contact_phone', auth()->user()->applicant->emergency_contact_phone ?? '') }}"
                                        placeholder="Contoh: 081234567890"
                                        class="w-full px-4 py-2.5 bg-white rounded-xl border @error('emergency_contact_phone') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                    <span id="msg_emergency_contact_phone" class="text-[11px] text-gray-400 block transition-colors">Nomor aktif kerabat (10-15 digit).</span>
                                    @error('emergency_contact_phone')
                                        <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        @php
                            $savedLicenses = old('driver_licenses', auth()->user()->applicant->driver_licenses ?? []);
                            if (!is_array($savedLicenses)) {
                                $savedLicenses = json_decode($savedLicenses, true) ?? [];
                            }
                        @endphp
                        <div class="space-y-2 md:col-span-2 pt-2">
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Kepemilikan SIM (Pilih semua yang dimiliki)
                            </label>
                            <div class="grid grid-cols-2 sm:grid-cols-5 gap-3">
                                @foreach (['A', 'B1', 'B2', 'C', 'D'] as $sim)
                                    <label
                                        class="flex items-center p-3 bg-gray-50 rounded-xl border border-gray-200 hover:border-red-300 cursor-pointer transition-all group active:scale-95">
                                        <input type="checkbox" name="driver_licenses[]" value="{{ $sim }}"
                                            {{ in_array($sim, $savedLicenses) ? 'checked' : '' }}
                                            class="w-4 h-4 rounded border-gray-300 text-[#B11116] focus:ring-[#B11116]">
                                        <span class="ml-2.5 text-xs font-bold text-gray-700 group-hover:text-[#B11116]">
                                            SIM {{ $sim }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                            @error('driver_licenses')
                                <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1.5 md:col-span-2">
                            <label for="medical_history"
                                class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Riwayat Penyakit (Jika Ada)
                            </label>
                            <textarea id="medical_history" name="medical_history" rows="2"
                                placeholder="Tuliskan riwayat penyakit kronis/serius yang pernah atau sedang diderita, atau kosongkan jika tidak ada"
                                class="uppercase placeholder:normal-case w-full px-4 py-2.5 bg-white rounded-xl border @error('medical_history') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">{{ old('medical_history', auth()->user()->applicant->medical_history ?? '') }}</textarea>
                            @error('medical_history')
                                <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="pt-7 border-t border-gray-100">
                        <div class="mb-6">
                            <h2 class="text-base font-bold text-gray-900">Ekspektasi & Informasi Tambahan</h2>
                            <p class="text-xs text-gray-500 mt-0.5">Berikan gambaran mengenai ekspektasi kerja dan
                                referensi Anda.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Salary Expectation -->
                            <div class="space-y-1.5">
                                <label for="salary_expectation"
                                    class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    Ekspektasi Gaji (Rp/Bulan) <span class="text-[#B11116]">*</span>
                                </label>
                                <div class="relative">
                                    <span
                                        class="absolute inset-y-0 left-0 flex items-center pl-4 text-xs font-bold text-gray-400">Rp</span>
                                    <input id="salary_expectation" name="salary_expectation" type="text"
                                        inputmode="numeric" required
                                        value="{{ old('salary_expectation', auth()->user()->applicant->expectation->salary_expectation ?? '') }}"
                                        oninput="formatRupiahInput(this)" placeholder="0"
                                        class="w-full pl-10 pr-4 py-2.5 bg-white rounded-xl border @error('salary_expectation') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                </div>
                                @error('salary_expectation')
                                    <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Job Source (Sumber Informasi Lowongan) -->
                            <div class="space-y-1.5">
                                <label for="job_source"
                                    class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    Sumber Informasi Lowongan <span class="text-[#B11116]">*</span>
                                </label>
                                @php
                                    $jobSources = [
                                        'Career Page',
                                        'Jobfair',
                                        'Jobstreet',
                                        'KitaLulus',
                                        'LinkedIn',
                                        'Approach by HR',
                                        'Social Media',
                                        'Instagram Career',
                                        'University Job Portal',
                                        'Referral',
                                    ];
                                    $selectedJobSource = old('job_source', auth()->user()->applicant->expectation->job_source ?? '');
                                @endphp
                                <select id="job_source" name="job_source" required onchange="toggleReferralInput(this.value)"
                                    class="w-full px-4 py-2.5 bg-white rounded-xl border @error('job_source') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                    <option value="" disabled {{ $selectedJobSource ? '' : 'selected' }}>Pilih Sumber Informasi</option>
                                    @foreach ($jobSources as $source)
                                        <option value="{{ $source }}" {{ $selectedJobSource == $source ? 'selected' : '' }}>
                                            {{ $source }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('job_source')
                                    <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Reference By (Tampil Jika Memilih Referral) -->
                            <div id="referralWrapper" class="space-y-1.5 {{ $selectedJobSource === 'Referral' ? '' : 'hidden' }}">
                                <label for="reference_by"
                                    class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    Nama Lengkap Karyawan (Pemberi Referensi) <span class="text-[#B11116]">*</span>
                                </label>
                                <input id="reference_by" name="reference_by" type="text"
                                    value="{{ old('reference_by', auth()->user()->applicant->expectation->reference_by ?? '') }}"
                                    placeholder="Masukkan Nama Lengkap Karyawan"
                                    class="uppercase placeholder:normal-case w-full px-4 py-2.5 bg-white rounded-xl border @error('reference_by') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                @error('reference_by')
                                    <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Facility Expectation -->
                            <div class="space-y-1.5 md:col-span-2">
                                <label for="facility_expectation"
                                    class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    Ekspektasi Fasilitas (Opsional)
                                </label>
                                <textarea id="facility_expectation" name="facility_expectation" rows="2"
                                    placeholder="Tuliskan ekspektasi fasilitas seperti tunjangan kesehatan, mess, laptop kantor, dll."
                                    class="uppercase placeholder:normal-case w-full px-4 py-2.5 bg-white rounded-xl border @error('facility_expectation') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">{{ old('facility_expectation', auth()->user()->applicant->expectation->facility_expectation ?? '') }}</textarea>
                                @error('facility_expectation')
                                    <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Ready to Relocate -->
                            <div class="space-y-1.5">
                                <span class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    Bersedia Ditempatkan Dimana Saja <span class="text-[#B11116]">*</span>
                                </span>
                                <div class="flex items-center gap-6 py-2">
                                    <label for="relocate_yes" class="inline-flex items-center cursor-pointer group py-1">
                                        <input id="relocate_yes" type="radio" name="ready_to_relocate" value="1"
                                            required
                                            {{ old('ready_to_relocate', auth()->user()->applicant->expectation->ready_to_relocate ?? '') == '1' ? 'checked' : '' }}
                                            class="w-4 h-4 text-[#B11116] border-gray-300 focus:ring-[#B11116]">
                                        <span
                                            class="ml-2 text-sm font-medium text-gray-700 group-hover:text-gray-900">Ya</span>
                                    </label>
                                    <label for="relocate_no" class="inline-flex items-center cursor-pointer group py-1">
                                        <input id="relocate_no" type="radio" name="ready_to_relocate" value="0"
                                            required
                                            {{ old('ready_to_relocate', auth()->user()->applicant->expectation->ready_to_relocate ?? '') == '0' ? 'checked' : '' }}
                                            class="w-4 h-4 text-[#B11116] border-gray-300 focus:ring-[#B11116]">
                                        <span
                                            class="ml-2 text-sm font-medium text-gray-700 group-hover:text-gray-900">Tidak</span>
                                    </label>
                                </div>
                                @error('ready_to_relocate')
                                    <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Ready to Travel -->
                            <div class="space-y-1.5">
                                <span class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    Bersedia Perjalanan Dinas? <span class="text-[#B11116]">*</span>
                                </span>
                                <div class="flex items-center gap-6 py-2">
                                    <label for="travel_yes" class="inline-flex items-center cursor-pointer group py-1">
                                        <input id="travel_yes" type="radio" name="ready_to_travel" value="1"
                                            required
                                            {{ old('ready_to_travel', auth()->user()->applicant->expectation->ready_to_travel ?? '') == '1' ? 'checked' : '' }}
                                            class="w-4 h-4 text-[#B11116] border-gray-300 focus:ring-[#B11116]">
                                        <span
                                            class="ml-2 text-sm font-medium text-gray-700 group-hover:text-gray-900">Ya</span>
                                    </label>
                                    <label for="travel_no" class="inline-flex items-center cursor-pointer group py-1">
                                        <input id="travel_no" type="radio" name="ready_to_travel" value="0"
                                            required
                                            {{ old('ready_to_travel', auth()->user()->applicant->expectation->ready_to_travel ?? '') == '0' ? 'checked' : '' }}
                                            class="w-4 h-4 text-[#B11116] border-gray-300 focus:ring-[#B11116]">
                                        <span
                                            class="ml-2 text-sm font-medium text-gray-700 group-hover:text-gray-900">Tidak</span>
                                    </label>
                                </div>
                                @error('ready_to_travel')
                                    <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="space-y-3 md:col-span-2 pt-6 border-t border-gray-100 mt-6">
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Urutan Prioritas Divisi <span class="text-[#B11116]">*</span>
                            </label>
                            <p class="text-xs text-gray-500">
                                Geser (drag & drop) atau gunakan tombol panah untuk menentukan urutan minat Anda. Divisi
                                paling atas merupakan pilihan utama.
                            </p>
                        </div>

                        @if ($divisions->isNotEmpty())
                            @php
                                $oldPreferences = old('division_preferences');

                                if (
                                    is_null($oldPreferences) &&
                                    isset(auth()->user()->applicant) &&
                                    auth()->user()->applicant->divisionPreferences
                                ) {
                                    $oldPreferences = auth()
                                        ->user()
                                        ->applicant->divisionPreferences->pluck('division_id')
                                        ->toArray();
                                }

                                if (!empty($oldPreferences) && is_array($oldPreferences)) {
                                    $sortedDivisions = collect();

                                    foreach ($oldPreferences as $id) {
                                        $found = $divisions->firstWhere('id', (int) $id);
                                        if ($found) {
                                            $sortedDivisions->push($found);
                                        }
                                    }

                                    $remainingDivisions = $divisions->reject(function ($div) use ($oldPreferences) {
                                        return in_array($div->id, array_map('intval', $oldPreferences));
                                    });

                                    $sortedDivisions = $sortedDivisions->merge($remainingDivisions);
                                } else {
                                    $sortedDivisions = $divisions->shuffle();
                                }
                            @endphp

                            <div id="divisionSortableList" class="space-y-2.5">
                                @foreach ($sortedDivisions as $index => $division)
                                    <div data-id="{{ $division->id }}"
                                        class="division-item flex items-center justify-between p-3.5 bg-white rounded-xl border border-gray-200 shadow-sm transition-all hover:border-red-300 hover:shadow-md cursor-grab active:cursor-grabbing select-none group">
                                        <input type="hidden" name="division_preferences[]" value="{{ $division->id }}">
                                        <div class="flex items-center gap-3.5">
                                            <div class="text-gray-400 group-hover:text-gray-600 transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 8h16M4 16h16" />
                                                </svg>
                                            </div>
                                            <span
                                                class="division-rank flex items-center justify-center w-6 h-6 rounded-full bg-red-50 text-[#B11116] text-xs font-extrabold transition-all group-hover:bg-[#B11116] group-hover:text-white">
                                                {{ $loop->iteration }}
                                            </span>
                                            <span class="text-sm font-bold text-gray-800">
                                                {{ $division->name }}
                                            </span>
                                        </div>
                                        <div class="flex items-center gap-1">
                                            <button type="button" onclick="moveDivisionUp(this)"
                                                title="Pindahkan Ke Atas"
                                                class="p-1.5 text-gray-400 hover:text-[#B11116] hover:bg-red-50 rounded-lg transition-colors cursor-pointer focus:outline-none focus:ring-2 focus:ring-red-200">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2.5" d="M5 15l7-7 7 7" />
                                                </svg>
                                            </button>
                                            <button type="button" onclick="moveDivisionDown(this)"
                                                title="Pindahkan Ke Bawah"
                                                class="p-1.5 text-gray-400 hover:text-[#B11116] hover:bg-red-50 rounded-lg transition-colors cursor-pointer focus:outline-none focus:ring-2 focus:ring-red-200">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2.5" d="M19 9l-7 7-7-7" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="p-4 bg-amber-50 border border-amber-200 rounded-xl flex items-start gap-3">
                                <div class="p-1 bg-amber-100 rounded-lg text-amber-600 shrink-0 mt-0.5">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-amber-900 uppercase tracking-wide">Pengisian Minat
                                        Divisi Belum Tersedia</h4>
                                    <p class="text-xs text-amber-700 mt-0.5 leading-relaxed">
                                        Data divisi untuk pendaftaran belum lengkap. Silakan bersabar dan cek kembali secara
                                        berkala.
                                    </p>
                                </div>
                            </div>
                        @endif

                        @error('division_preferences')
                            <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const container = document.getElementById('divisionSortableList');
                            if (container) {
                                new Sortable(container, {
                                    animation: 200,
                                    ghostClass: 'opacity-40',
                                    chosenClass: 'border-[#B11116]',
                                    dragClass: 'shadow-lg',
                                    onEnd: function() {
                                        updateDivisionRanks();
                                    }
                                });
                            }
                        });

                        function updateDivisionRanks() {
                            const items = document.querySelectorAll('#divisionSortableList .division-item');
                            items.forEach((item, index) => {
                                const rankBadge = item.querySelector('.division-rank');
                                if (rankBadge) {
                                    rankBadge.textContent = index + 1;
                                }
                            });
                        }

                        function moveDivisionUp(button) {
                            const item = button.closest('.division-item');
                            const previousItem = item.previousElementSibling;
                            if (previousItem) {
                                item.parentNode.insertBefore(item, previousItem);
                                updateDivisionRanks();
                            }
                        }

                        function moveDivisionDown(button) {
                            const item = button.closest('.division-item');
                            const nextItem = item.nextElementSibling;
                            if (nextItem) {
                                item.parentNode.insertBefore(nextItem, item);
                                updateDivisionRanks();
                            }
                        }
                    </script>

                    <div class="pt-8 border-t border-gray-100 flex justify-end mt-8">
                        <button type="submit" id="btnSubmit"
                            class="w-full sm:w-auto px-8 py-3 bg-[#B11116] hover:bg-red-800 text-white font-bold text-sm rounded-xl shadow-md transition-all flex items-center justify-center gap-2 cursor-pointer focus:ring-4 focus:ring-red-200 disabled:opacity-50 disabled:cursor-not-allowed active:scale-95">
                            <span id="btnText">Simpan & Lanjut ke Langkah 2</span>
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
        function formatRupiahInput(input) {
            let value = input.value.replace(/[^0-9]/g, '');
            if (value) {
                input.value = new Intl.NumberFormat('id-ID').format(value);
            } else {
                input.value = '';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // PHOTO PREVIEW LOGIC
            const photoInput = document.getElementById('photo');
            const photoPreview = document.getElementById('photoPreview');
            const photoPlaceholder = document.getElementById('photoPlaceholder');
            const btnRemovePhoto = document.getElementById('btnRemovePhoto');

            if (photoPreview && photoPreview.getAttribute('src') !== '') {
                if (btnRemovePhoto) btnRemovePhoto.classList.remove('hidden');
            }

            if (photoInput) {
                photoInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            photoPreview.src = e.target.result;
                            photoPreview.classList.remove('hidden');
                            if (photoPlaceholder) photoPlaceholder.classList.add('hidden');
                            if (btnRemovePhoto) btnRemovePhoto.classList.remove('hidden');
                        }
                        reader.readAsDataURL(file);
                    }
                });
            }

            if (btnRemovePhoto) {
                btnRemovePhoto.addEventListener('click', function() {
                    if (photoInput) photoInput.value = '';
                    photoPreview.src = '';
                    photoPreview.classList.add('hidden');
                    if (photoPlaceholder) photoPlaceholder.classList.remove('hidden');
                    btnRemovePhoto.classList.add('hidden');
                });
            }

            // SAME ADDRESS CHECKBOX
            const sameAddressCheckbox = document.getElementById('sameAddressCheckbox');
            const addressKtp = document.getElementById('address_ktp');
            const addressDomisili = document.getElementById('address_domisili');
            const postalKtp = document.getElementById('postal_code_ktp');
            const postalDomisili = document.getElementById('postal_code_domisili');

            function syncSameAddress() {
                if (!sameAddressCheckbox || !addressKtp || !addressDomisili) return;

                if (sameAddressCheckbox.checked) {
                    addressDomisili.value = addressKtp.value;
                    addressDomisili.readOnly = true;
                    addressDomisili.setAttribute('readonly', 'readonly');
                    addressDomisili.classList.add('bg-gray-100', 'text-gray-500', 'cursor-not-allowed');

                    if (postalKtp && postalDomisili) {
                        postalDomisili.value = postalKtp.value;
                        postalDomisili.readOnly = true;
                        postalDomisili.setAttribute('readonly', 'readonly');
                        postalDomisili.classList.add('bg-gray-100', 'text-gray-500', 'cursor-not-allowed');
                        validatePostal(postalDomisili, 'msg_postal_code_domisili');
                    }
                } else {
                    addressDomisili.readOnly = false;
                    addressDomisili.removeAttribute('readonly');
                    addressDomisili.classList.remove('bg-gray-100', 'text-gray-500', 'cursor-not-allowed');

                    if (postalDomisili) {
                        postalDomisili.readOnly = false;
                        postalDomisili.removeAttribute('readonly');
                        postalDomisili.classList.remove('bg-gray-100', 'text-gray-500', 'cursor-not-allowed');
                    }
                }
            }

            if (sameAddressCheckbox && addressKtp && addressDomisili) {
                sameAddressCheckbox.addEventListener('change', syncSameAddress);

                addressKtp.addEventListener('input', function() {
                    if (sameAddressCheckbox.checked) {
                        addressDomisili.value = this.value;
                    }
                });

                if (postalKtp && postalDomisili) {
                    postalKtp.addEventListener('input', function() {
                        if (sameAddressCheckbox.checked) {
                            postalDomisili.value = this.value;
                            validatePostal(postalDomisili, 'msg_postal_code_domisili');
                        }
                    });
                }

                syncSameAddress();
            }

            // ================= REAL-TIME VALIDATION =================
            function setFieldStatus(input, msgEl, isValid, message, isNeutral = false) {
                if (!input || !msgEl) return;
                msgEl.textContent = message;

                input.classList.remove('border-red-500', 'ring-red-500', 'border-emerald-500', 'ring-emerald-500', 'border-amber-500', 'ring-amber-500');
                msgEl.classList.remove('text-red-600', 'text-emerald-600', 'text-amber-600', 'text-gray-400');

                if (isNeutral) {
                    msgEl.classList.add('text-gray-400');
                } else if (isValid) {
                    input.classList.add('border-emerald-500');
                    msgEl.classList.add('text-emerald-600');
                } else {
                    input.classList.add('border-red-500');
                    msgEl.classList.add('text-red-600');
                }
            }

            // 1. NIK Real-time (16 digits)
            const nikInput = document.getElementById('nik');
            const msgNik = document.getElementById('msg_nik');
            function validateNik() {
                if (!nikInput || !msgNik) return;
                nikInput.value = nikInput.value.replace(/[^0-9]/g, '');
                const len = nikInput.value.length;
                if (len === 0) {
                    setFieldStatus(nikInput, msgNik, false, 'Wajib diisi (tepat 16 digit angka KTP).', true);
                } else if (len < 16) {
                    setFieldStatus(nikInput, msgNik, false, `Masih kurang ${16 - len} digit lagi (${len}/16 digit).`);
                } else if (len === 16) {
                    setFieldStatus(nikInput, msgNik, true, '✓ NIK lengkap dan valid (16 digit).');
                }
            }
            if (nikInput) {
                nikInput.addEventListener('input', validateNik);
                if (nikInput.value) validateNik();
            }

            // Email Real-time
            const emailInput = document.getElementById('email');
            const msgEmail = document.getElementById('msg_email');
            const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            function validateEmail() {
                if (!emailInput || !msgEmail) return;
                const val = emailInput.value.trim();
                if (val.length === 0) {
                    setFieldStatus(emailInput, msgEmail, false, 'Alamat email wajib diisi.', true);
                } else if (!emailRegex.test(val)) {
                    setFieldStatus(emailInput, msgEmail, false, 'Format email harus resmi & valid (contoh: nama@domain.com).');
                } else {
                    setFieldStatus(emailInput, msgEmail, true, '✓ Format email resmi valid.');
                }
            }
            if (emailInput) {
                emailInput.addEventListener('input', validateEmail);
                if (emailInput.value) validateEmail();
            }

            // 2. Phone Number Real-time (10-15 digits)
            const phoneInput = document.getElementById('phone_number');
            const msgPhone = document.getElementById('msg_phone_number');
            function validatePhone(input, msgEl, required = true) {
                if (!input || !msgEl) return;
                input.value = input.value.replace(/[^0-9]/g, '');
                const len = input.value.length;
                if (len === 0) {
                    if (required) {
                        setFieldStatus(input, msgEl, false, 'Wajib diisi (10 - 15 digit angka).', true);
                    } else {
                        setFieldStatus(input, msgEl, true, 'Nomor aktif WhatsApp (10-15 digit).', true);
                    }
                } else if (len < 10) {
                    setFieldStatus(input, msgEl, false, `Masih kurang ${10 - len} digit lagi (minimal 10 digit, saat ini ${len}).`);
                } else if (len <= 15) {
                    setFieldStatus(input, msgEl, true, `✓ Nomor telepon valid (${len} digit).`);
                } else {
                    setFieldStatus(input, msgEl, false, `Nomor terlalu panjang (maksimal 15 digit, saat ini ${len}).`);
                }
            }
            if (phoneInput) {
                phoneInput.addEventListener('input', () => validatePhone(phoneInput, msgPhone, true));
                if (phoneInput.value) validatePhone(phoneInput, msgPhone, true);
            }

            // 3. Emergency Contact Phone Real-time
            const emgPhoneInput = document.getElementById('emergency_contact_phone');
            const msgEmgPhone = document.getElementById('msg_emergency_contact_phone');
            if (emgPhoneInput) {
                emgPhoneInput.addEventListener('input', () => validatePhone(emgPhoneInput, msgEmgPhone, true));
                if (emgPhoneInput.value) validatePhone(emgPhoneInput, msgEmgPhone, true);
            }

            // 4. Postal Code Real-time (5 digits)
            function validatePostal(input, msgId) {
                const msgEl = document.getElementById(msgId);
                if (!input || !msgEl) return;
                input.value = input.value.replace(/[^0-9]/g, '');
                const len = input.value.length;
                if (len === 0) {
                    setFieldStatus(input, msgEl, true, '5 digit kode pos.', true);
                } else if (len < 5) {
                    setFieldStatus(input, msgEl, false, `Masih kurang ${5 - len} digit lagi (${len}/5 digit).`);
                } else if (len === 5) {
                    setFieldStatus(input, msgEl, true, '✓ Kode pos valid (5 digit).');
                }
            }
            if (postalKtp) {
                postalKtp.addEventListener('input', () => validatePostal(postalKtp, 'msg_postal_code_ktp'));
                if (postalKtp.value) validatePostal(postalKtp, 'msg_postal_code_ktp');
            }
            if (postalDomisili) {
                postalDomisili.addEventListener('input', () => validatePostal(postalDomisili, 'msg_postal_code_domisili'));
                if (postalDomisili.value) validatePostal(postalDomisili, 'msg_postal_code_domisili');
            }

            // 5. Height & Weight Real-time
            const heightInput = document.getElementById('height');
            const weightInput = document.getElementById('weight');
            if (heightInput) {
                heightInput.addEventListener('input', function() {
                    const val = parseInt(this.value, 10);
                    if (this.value && (val < 100 || val > 250)) {
                        this.classList.add('border-red-500');
                    } else {
                        this.classList.remove('border-red-500');
                    }
                });
            }
            if (weightInput) {
                weightInput.addEventListener('input', function() {
                    const val = parseInt(this.value, 10);
                    if (this.value && (val < 30 || val > 250)) {
                        this.classList.add('border-red-500');
                    } else {
                        this.classList.remove('border-red-500');
                    }
                });
            }

            // 6. Social Media Username Real-time sanitize
            const igInput = document.getElementById('instagram');
            const liInput = document.getElementById('linkedin');
            if (igInput) {
                igInput.addEventListener('input', function() {
                    let v = this.value.trim();
                    v = v.replace(/^https?:\/\/(www\.)?instagram\.com\//i, '').replace(/^@+/, '').replace(/\/$/, '');
                    if (v !== this.value) this.value = v;
                });
            }
            if (liInput) {
                liInput.addEventListener('input', function() {
                    let v = this.value;
                    if (/^https?:\/\//i.test(v)) {
                        v = v.replace(/^https?:\/\/(www\.)?linkedin\.com\/in\//i, '').replace(/^https?:\/\/(www\.)?linkedin\.com\//i, '').replace(/^@+/, '').replace(/\/$/, '');
                    }
                    if (v !== this.value) this.value = v;
                });
            }

            const salaryInput = document.getElementById('salary_expectation');
            if (salaryInput && salaryInput.value) {
                formatRupiahInput(salaryInput);
            }

            const biodataForm = document.getElementById('biodataForm');
            const btnSubmit = document.getElementById('btnSubmit');
            const btnText = document.getElementById('btnText');
            const btnLoadingText = document.getElementById('btnLoadingText');
            const btnArrow = document.getElementById('btnArrow');

            if (biodataForm && btnSubmit) {
                biodataForm.addEventListener('submit', function(e) {
                    // Check if NIK is not 16 digits
                    if (nikInput && nikInput.value.length !== 16) {
                        e.preventDefault();
                        nikInput.focus();
                        validateNik();
                        if (typeof showToast === 'function') {
                            showToast('warning', 'Validasi Gagal', 'NIK harus terdiri dari tepat 16 digit angka.');
                        }
                        return false;
                    }
                    if (phoneInput && (phoneInput.value.length < 10 || phoneInput.value.length > 15)) {
                        e.preventDefault();
                        phoneInput.focus();
                        validatePhone(phoneInput, msgPhone, true);
                        if (typeof showToast === 'function') {
                            showToast('warning', 'Validasi Gagal', 'Nomor telepon harus antara 10 sampai 15 digit angka.');
                        }
                        return false;
                    }
                    if (salaryInput) {
                        salaryInput.value = salaryInput.value.replace(/[^0-9]/g, '');
                    }
                    btnSubmit.disabled = true;
                    if (btnText) btnText.classList.add('hidden');
                    if (btnArrow) btnArrow.classList.add('hidden');
                    if (btnLoadingText) btnLoadingText.classList.remove('hidden');
                });
            }
        });

        function toggleMaritalDate(status) {
            const wrapper = document.getElementById('maritalDateWrapper');
            const input = document.getElementById('marital_date');
            if (!wrapper) return;
            if (['married', 'divorced', 'widowed'].includes(status)) {
                wrapper.classList.remove('hidden');
            } else {
                wrapper.classList.add('hidden');
                if (input) input.value = '';
            }
        }

        function toggleReferralInput(value) {
            const referralWrapper = document.getElementById('referralWrapper');
            const referenceInput = document.getElementById('reference_by');
            if (!referralWrapper) return;
            if (value === 'Referral') {
                referralWrapper.classList.remove('hidden');
                if (referenceInput) {
                    referenceInput.setAttribute('required', 'required');
                    referenceInput.focus();
                }
            } else {
                referralWrapper.classList.add('hidden');
                if (referenceInput) {
                    referenceInput.removeAttribute('required');
                }
            }
        }
    </script>
@endsection
