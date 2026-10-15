@extends('auth.applicant.layouts.index')

@section('title', 'Edit Biodata Pelamar')

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
            <span class="text-xs font-medium text-gray-400">Langkah 1 dari 4</span>
        </div>

        <div class="mb-10">
            <ol class="flex items-center w-full text-xs font-semibold">
                <!-- Step 1: Data Personal (AKTIF) -->
                <li class="flex items-center transition-colors text-[#B11116] font-bold">
                    <span
                        class="flex items-center justify-center w-8 h-8 rounded-full border-2 mr-2 shadow-sm transition-all text-xs font-bold border-[#B11116] bg-[#B11116] text-white">
                        <span>1</span>
                    </span>
                    <span class="hidden sm:inline">Data Personal</span>
                </li>

                <li class="flex-1 border-t-2 mx-2 sm:mx-4 transition-colors duration-300 border-gray-200"></li>

                <!-- Step 2: Keluarga (Dapat diklik, simpan dulu) -->
                <li>
                    <button type="button" onclick="goToStep('family')" title="Simpan data saat ini & lanjut ke Data Keluarga"
                        class="flex items-center transition-colors text-gray-500 hover:text-[#B11116] cursor-pointer group focus:outline-none">
                        <span
                            class="flex items-center justify-center w-8 h-8 rounded-full border-2 mr-2 shadow-sm transition-all text-xs font-bold border-gray-300 bg-white text-gray-500 group-hover:border-[#B11116] group-hover:text-[#B11116]">
                            <span>2</span>
                        </span>
                        <span class="hidden sm:inline group-hover:font-bold">Keluarga</span>
                    </button>
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

        <form action="{{ route('biodata.update', $applicant->id) }}" method="POST" id="biodataForm" enctype="multipart/form-data" novalidate>
            @csrf
            @method('PUT')
            <input type="hidden" name="redirect_step" id="redirect_step" value="family">

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-6 sm:p-10">
                    <header class="mb-8 pb-4 border-b border-gray-100">
                        <h1 class="text-2xl font-black text-gray-900 tracking-tight">
                            Edit Data <span class="text-[#B11116]">Personal</span>
                        </h1>
                        <p class="text-gray-500 text-sm mt-1">
                            Perbarui informasi identitas diri Anda secara akurat sesuai dengan dokumen resmi (KTP).
                        </p>
                    </header>

                    <!-- SEKSI UPLOAD FOTO PROFIL -->
                    <div class="mb-8 p-6 bg-gray-50/80 rounded-2xl border border-gray-200/80">
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-3">
                            Pas Foto Terbaru
                        </label>
                        <div class="flex flex-col sm:flex-row items-center gap-6">
                            <!-- Preview Image Container -->
                            <div class="relative group shrink-0">
                                @php
                                    $savedPhoto = $applicant->photo_url ?? null;
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
                                    <input id="photo" name="photo" type="file"
                                        accept="image/png, image/jpeg, image/jpg" class="hidden">
                                </div>
                                <p class="text-xs text-gray-500 leading-relaxed">
                                    Unggah pas foto formal berpakaian rapi dengan latar belakang polos. Kosongkan jika tidak ingin mengubah foto.<br>
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
                                pattern="[0-9]{16}" maxlength="16" value="{{ old('nik', $applicant->nik) }}"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '');" placeholder="16 digit angka KTP"
                                class="w-full px-4 py-2.5 bg-white rounded-xl border @error('nik') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                            <span class="text-[11px] text-gray-400 block">Harus berisi 16 digit angka.</span>
                            @error('nik')
                                <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1.5">
                            <label for="name" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Nama Lengkap <span class="text-[#B11116]">*</span>
                            </label>
                            <input id="name" name="name" type="text" required
                                value="{{ old('name', $applicant->name) }}" placeholder="Nama Lengkap Sesuai KTP"
                                class="w-full px-4 py-2.5 bg-white rounded-xl border @error('name') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                            @error('name')
                                <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1.5">
                            <label for="email" class="block text-xs font-bold text-gray-400 uppercase tracking-wider">
                                Alamat Email
                            </label>
                            <input id="email" name="email" type="email"
                                value="{{ old('email', $applicant->email) }}" readonly
                                class="w-full px-4 py-2.5 bg-gray-50 text-gray-500 rounded-xl border border-gray-200 font-semibold text-sm cursor-not-allowed outline-none select-none">
                        </div>

                        <div class="space-y-1.5">
                            <label for="phone_number"
                                class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                No. Telepon / WA <span class="text-[#B11116]">*</span>
                            </label>
                            <input id="phone_number" name="phone_number" type="tel" inputmode="numeric" required
                                pattern="[0-9]{10,15}" value="{{ old('phone_number', $applicant->phone_number) }}"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '');" placeholder="Contoh: 081234567890"
                                class="w-full px-4 py-2.5 bg-white rounded-xl border @error('phone_number') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                            @error('phone_number')
                                <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-4 md:col-span-2 pt-2 border-t border-gray-100">
                            <div class="space-y-1.5">
                                <label for="address_ktp"
                                    class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    Alamat Lengkap (Sesuai KTP) <span class="text-[#B11116]">*</span>
                                </label>
                                <textarea id="address_ktp" name="address_ktp" rows="3" required
                                    placeholder="Jl. Nama Jalan, RT/RW, Kelurahan, Kecamatan, Kota/Kabupaten"
                                    class="w-full px-4 py-2.5 bg-white rounded-xl border @error('address_ktp') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">{{ old('address_ktp', $applicant->address_ktp) }}</textarea>
                                @error('address_ktp')
                                    <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-2 pt-2">
                                <div class="flex items-center justify-between">
                                    <label for="address_domisili"
                                        class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Alamat Domisili saat ini <span class="text-[#B11116]">*</span>
                                    </label>
                                    <label
                                        class="inline-flex items-center cursor-pointer select-none py-1 px-2 rounded-lg hover:bg-gray-50 transition-colors">
                                        <input type="checkbox" id="sameAddressCheckbox"
                                            @if (old('address_domisili', $applicant->address_domisili) === old('address_ktp', $applicant->address_ktp)) checked @endif
                                            class="rounded border-gray-300 text-[#B11116] focus:ring-[#B11116] w-4 h-4 cursor-pointer">
                                        <span class="ml-2 text-xs font-semibold text-gray-600">Sama dengan KTP</span>
                                    </label>
                                </div>
                                <textarea id="address_domisili" name="address_domisili" rows="2" required
                                    placeholder="Alamat Domisili Tempat Tinggal Saat Ini"
                                    class="w-full px-4 py-2.5 bg-white rounded-xl border @error('address_domisili') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">{{ old('address_domisili', $applicant->address_domisili) }}</textarea>
                                @error('address_domisili')
                                    <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="space-y-1.5 pt-2 border-t border-gray-100 md:border-t-0">
                            <span class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Jenis Kelamin <span class="text-[#B11116]">*</span>
                            </span>
                            <div class="flex items-center gap-6 py-2">
                                <label for="gender_l" class="inline-flex items-center cursor-pointer group py-1">
                                    <input id="gender_l" type="radio" name="gender" value="l" required
                                        {{ old('gender', $applicant->gender) == 'l' ? 'checked' : '' }}
                                        class="w-4 h-4 text-[#B11116] border-gray-300 focus:ring-[#B11116]">
                                    <span
                                        class="ml-2 text-sm font-medium text-gray-700 group-hover:text-gray-900">Laki-laki</span>
                                </label>
                                <label for="gender_p" class="inline-flex items-center cursor-pointer group py-1">
                                    <input id="gender_p" type="radio" name="gender" value="p" required
                                        {{ old('gender', $applicant->gender) == 'p' ? 'checked' : '' }}
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
                                    {{ old('religion', $applicant->religion) ? '' : 'selected' }}>Pilih Agama
                                </option>
                                @foreach (['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Khonghucu', 'Lainnya'] as $agamaOption)
                                    <option value="{{ $agamaOption }}"
                                        {{ old('religion', $applicant->religion) == $agamaOption ? 'selected' : '' }}>
                                        {{ $agamaOption }}
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
                                value="{{ old('place_of_birth', $applicant->place_of_birth) }}" placeholder="Kota Lahir"
                                class="w-full px-4 py-2.5 bg-white rounded-xl border @error('place_of_birth') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
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
                                value="{{ old('date_of_birth', \Carbon\Carbon::parse($applicant->date_of_birth)->format('Y-m-d')) }}"
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
                                value="{{ old('height', $applicant->height) }}" placeholder="Contoh: 170"
                                class="w-full px-4 py-2.5 bg-white rounded-xl border @error('height') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                            @error('height')
                                <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1.5">
                            <label for="weight" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Berat Badan (kg) <span class="text-[#B11116]">*</span>
                            </label>
                            <input id="weight" name="weight" type="number" min="30" max="200" required
                                value="{{ old('weight', $applicant->weight) }}" placeholder="Contoh: 65"
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
                                <option value="" disabled {{ old('blood_type', $applicant->blood_type) ? '' : 'selected' }}>Pilih Golongan Darah</option>
                                @foreach (['A', 'B', 'AB', 'O'] as $blood)
                                    <option value="{{ $blood }}" {{ old('blood_type', $applicant->blood_type) == $blood ? 'selected' : '' }}>
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
                                    {{ old('is_smoker', $applicant->is_smoker) === null ? 'selected' : '' }}>Pilih
                                    Jawaban</option>
                                <option value="n"
                                    {{ old('is_smoker', $applicant->is_smoker) === 'n' ? 'selected' : '' }}>Tidak
                                </option>
                                <option value="y"
                                    {{ old('is_smoker', $applicant->is_smoker) === 'y' ? 'selected' : '' }}>Ya
                                </option>
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
                                    {{ old('has_tattoo', $applicant->has_tattoo) === null ? 'selected' : '' }}>Pilih
                                    Jawaban</option>
                                <option value="n"
                                    {{ old('has_tattoo', $applicant->has_tattoo) === 'n' ? 'selected' : '' }}>Tidak
                                </option>
                                <option value="y"
                                    {{ old('has_tattoo', $applicant->has_tattoo) === 'y' ? 'selected' : '' }}>Ya
                                </option>
                            </select>
                            @error('has_tattoo')
                                <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1.5 md:col-span-2 pt-2 border-t border-gray-100">
                            <label for="marital_status"
                                class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Status Pernikahan <span class="text-[#B11116]">*</span>
                            </label>
                            <select id="marital_status" name="marital_status" required
                                class="w-full px-4 py-2.5 bg-white rounded-xl border @error('marital_status') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                <option value="" disabled
                                    {{ old('marital_status', $applicant->marital_status) ? '' : 'selected' }}>Pilih
                                    Status</option>
                                <option value="single"
                                    {{ old('marital_status', $applicant->marital_status) == 'single' ? 'selected' : '' }}>
                                    Belum Menikah</option>
                                <option value="married"
                                    {{ old('marital_status', $applicant->marital_status) == 'married' ? 'selected' : '' }}>
                                    Sudah Menikah</option>
                                <option value="divorced"
                                    {{ old('marital_status', $applicant->marital_status) == 'divorced' ? 'selected' : '' }}>
                                    Cerai Hidup</option>
                                <option value="widowed"
                                    {{ old('marital_status', $applicant->marital_status) == 'widowed' ? 'selected' : '' }}>
                                    Cerai Mati</option>
                            </select>
                            @error('marital_status')
                                <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1.5">
                            <label for="instagram" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                URL Instagram
                            </label>
                            <input id="instagram" name="instagram" type="url"
                                value="{{ old('instagram', $applicant->instagram) }}"
                                placeholder="https://instagram.com/username"
                                class="w-full px-4 py-2.5 bg-white rounded-xl border @error('instagram') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                            @error('instagram')
                                <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1.5">
                            <label for="linkedin" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                URL LinkedIn
                            </label>
                            <input id="linkedin" name="linkedin" type="url"
                                value="{{ old('linkedin', $applicant->linkedin) }}"
                                placeholder="https://linkedin.com/in/username"
                                class="w-full px-4 py-2.5 bg-white rounded-xl border @error('linkedin') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                            @error('linkedin')
                                <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        @php
                            $savedLicenses = old('driver_licenses', $applicant->driver_licenses ?? []);
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
                                class="w-full px-4 py-2.5 bg-white rounded-xl border @error('medical_history') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">{{ old('medical_history', $applicant->medical_history) }}</textarea>
                            @error('medical_history')
                                <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="pt-7 border-t border-gray-100">
                        <div class="mb-6">
                            <h2 class="text-base font-bold text-gray-900">Ekspektasi & Informasi Tambahan</h2>
                            <p class="text-xs text-gray-500 mt-0.5">Berikan gambaran mengenai ekspektasi kerja dan referensi Anda.</p>
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
                                        value="{{ old('salary_expectation', $applicant->expectation->salary_expectation ?? '') }}"
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
                                    $selectedJobSource = old('job_source', $applicant->expectation->job_source ?? '');
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
                                    value="{{ old('reference_by', $applicant->expectation->reference_by ?? '') }}"
                                    placeholder="Masukkan Nama Lengkap Karyawan"
                                    class="w-full px-4 py-2.5 bg-white rounded-xl border @error('reference_by') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
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
                                    class="w-full px-4 py-2.5 bg-white rounded-xl border @error('facility_expectation') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">{{ old('facility_expectation', $applicant->expectation->facility_expectation ?? '') }}</textarea>
                                @error('facility_expectation')
                                    <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Ready to Relocate -->
                            <div class="space-y-1.5">
                                <span class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    Bersedia Tempatkan/Relokasi? <span class="text-[#B11116]">*</span>
                                </span>
                                <div class="flex items-center gap-6 py-2">
                                    <label for="relocate_yes" class="inline-flex items-center cursor-pointer group py-1">
                                        <input id="relocate_yes" type="radio" name="ready_to_relocate" value="1"
                                            required
                                            {{ old('ready_to_relocate', (string) ($applicant->expectation->ready_to_relocate ?? '')) === '1' ? 'checked' : '' }}
                                            class="w-4 h-4 text-[#B11116] border-gray-300 focus:ring-[#B11116]">
                                        <span
                                            class="ml-2 text-sm font-medium text-gray-700 group-hover:text-gray-900">Ya</span>
                                    </label>
                                    <label for="relocate_no" class="inline-flex items-center cursor-pointer group py-1">
                                        <input id="relocate_no" type="radio" name="ready_to_relocate" value="0"
                                            required
                                            {{ old('ready_to_relocate', (string) ($applicant->expectation->ready_to_relocate ?? '')) === '0' ? 'checked' : '' }}
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
                                            {{ old('ready_to_travel', (string) ($applicant->expectation->ready_to_travel ?? '')) === '1' ? 'checked' : '' }}
                                            class="w-4 h-4 text-[#B11116] border-gray-300 focus:ring-[#B11116]">
                                        <span
                                            class="ml-2 text-sm font-medium text-gray-700 group-hover:text-gray-900">Ya</span>
                                    </label>
                                    <label for="travel_no" class="inline-flex items-center cursor-pointer group py-1">
                                        <input id="travel_no" type="radio" name="ready_to_travel" value="0"
                                            required
                                            {{ old('ready_to_travel', (string) ($applicant->expectation->ready_to_travel ?? '')) === '0' ? 'checked' : '' }}
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
                                $userPreferences = old('division_preferences', $applicant->interest->interests ?? []);
                                if (!is_array($userPreferences)) {
                                    $userPreferences = json_decode($userPreferences, true) ?? [];
                                }

                                $sortedDivisions = $divisions->sortBy(function ($division) use ($userPreferences) {
                                    $pos = array_search($division->id, $userPreferences);
                                    return $pos === false ? 999 : $pos;
                                });
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

                    <div class="pt-8 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4 mt-8">
                        <a href="{{ route('biodata.index') }}"
                            class="w-full sm:w-auto px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-sm rounded-xl transition-all inline-flex items-center justify-center gap-2 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Kembali ke Pratinjau Biodata
                        </a>

                        <button type="submit" id="btnSubmit"
                            class="w-full sm:w-auto px-8 py-3 bg-[#B11116] hover:bg-red-800 text-white font-bold text-sm rounded-xl shadow-md transition-all flex items-center justify-center gap-2 cursor-pointer focus:ring-4 focus:ring-red-200 disabled:opacity-50 disabled:cursor-not-allowed active:scale-95">
                            <span id="btnText">Perbarui & Lanjut ke Langkah 2</span>
                            <span id="btnLoadingText" class="hidden flex items-center gap-2">
                                <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                Memperbarui...
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

        function goToStep(step) {
            const redirectInput = document.getElementById('redirect_step');
            if (redirectInput) {
                redirectInput.value = step;
            }

            const biodataForm = document.getElementById('biodataForm');
            if (biodataForm) {
                if (biodataForm.reportValidity && !biodataForm.reportValidity()) {
                    return;
                }
                const salaryInput = document.getElementById('salary_expectation');
                if (salaryInput) {
                    salaryInput.value = salaryInput.value.replace(/[^0-9]/g, '');
                }
                biodataForm.submit();
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

            function syncSameAddress() {
                if (!sameAddressCheckbox || !addressKtp || !addressDomisili) return;

                if (sameAddressCheckbox.checked) {
                    addressDomisili.value = addressKtp.value;
                    addressDomisili.readOnly = true;
                    addressDomisili.setAttribute('readonly', 'readonly');
                    addressDomisili.classList.add('bg-gray-100', 'text-gray-500', 'cursor-not-allowed');
                } else {
                    addressDomisili.readOnly = false;
                    addressDomisili.removeAttribute('readonly');
                    addressDomisili.classList.remove('bg-gray-100', 'text-gray-500', 'cursor-not-allowed');
                }
            }

            if (sameAddressCheckbox && addressKtp && addressDomisili) {
                sameAddressCheckbox.addEventListener('change', syncSameAddress);

                addressKtp.addEventListener('input', function() {
                    if (sameAddressCheckbox.checked) {
                        addressDomisili.value = this.value;
                    }
                });

                addressDomisili.addEventListener('keydown', function(e) {
                    if (sameAddressCheckbox.checked) {
                        e.preventDefault();
                    }
                });

                // Inisialisasi saat halaman pertama kali dimuat
                syncSameAddress();
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
                biodataForm.addEventListener('submit', function() {
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
    </script>
@endsection
