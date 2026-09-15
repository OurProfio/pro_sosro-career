@extends('auth.applicant.layouts.index')

@section('title', 'Biodata Pelamar')

@section('content')
    <div class="py-8 md:py-12 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto font-figtree">

        <div class="mb-10">
            <ol class="flex items-center w-full text-xs font-semibold">
                <li class="flex items-center transition-colors text-[#B11116]">
                    <span
                        class="flex items-center justify-center w-8 h-8 rounded-full border-2 mr-2 shadow-sm transition-all text-xs font-bold border-[#B11116] bg-[#B11116] text-white">
                        <span>1</span>
                    </span>
                    <span class="hidden sm:inline">Data Personal</span>
                </li>

                <li class="flex-1 border-t-2 mx-2 sm:mx-4 transition-colors duration-300 border-[#B11116]"></li>

                <li class="flex items-center transition-colors text-gray-400 font-bold">
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

        <form action="{{ route('biodata.store') }}" method="POST" id="biodataForm" x-data="{ submitting: false }"
            @submit="submitting = true">
            @csrf
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-6 sm:p-10">
                    <div id="step-1-content">
                        <header class="mb-8 pb-4 border-b border-gray-100">
                            <h1 class="text-2xl font-black text-gray-900 tracking-tight">
                                Data <span class="text-[#B11116]">Personal</span>
                            </h1>
                            <p class="text-gray-500 text-sm mt-1">
                                Isi informasi identitas diri Anda secara akurat sesuai dengan dokumen resmi (KTP).
                            </p>
                        </header>

                        <div class="space-y-8">

                            <section class="space-y-5">
                                <h2
                                    class="text-xs font-black uppercase tracking-wider text-gray-400 pb-1 border-b border-gray-100">
                                    1. Identitas Utama
                                </h2>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                                    <div class="space-y-1.5">
                                        <label for="nik"
                                            class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                            NIK (Sesuai KTP) <span class="text-[#B11116]" title="Wajib diisi">*</span>
                                        </label>
                                        <input id="nik" name="nik" type="text" inputmode="numeric" required
                                            pattern="[0-9]{16}" maxlength="16" value="{{ old('nik') }}"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                            placeholder="16 digit angka KTP"
                                            class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none invalid:border-red-300 shadow-sm">
                                        <span class="text-[11px] text-gray-400 block">Harus berisi 16 digit angka.</span>
                                    </div>

                                    <div class="space-y-1.5">
                                        <label for="nama"
                                            class="block text-xs font-bold text-gray-400 uppercase tracking-wider">
                                            Nama Lengkap (Akun)
                                        </label>
                                        <input id="nama" type="text" value="{{ auth()->user()->nama }}" readonly
                                            class="w-full px-4 py-2.5 bg-gray-50 text-gray-500 rounded-xl border border-gray-200 font-semibold text-sm cursor-not-allowed outline-none">
                                    </div>

                                    <div class="space-y-1.5">
                                        <label for="email"
                                            class="block text-xs font-bold text-gray-400 uppercase tracking-wider">
                                            Alamat Email
                                        </label>
                                        <input id="email" type="email" value="{{ auth()->user()->email }}" readonly
                                            class="w-full px-4 py-2.5 bg-gray-50 text-gray-500 rounded-xl border border-gray-200 font-semibold text-sm cursor-not-allowed outline-none">
                                    </div>

                                    <div class="space-y-1.5">
                                        <label for="no_telepon"
                                            class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                            No. Telepon / WA <span class="text-[#B11116]" title="Wajib diisi">*</span>
                                        </label>
                                        <input id="no_telepon" name="no_telepon" type="tel" inputmode="numeric" required
                                            pattern="[0-9]{10,15}" value="{{ old('no_telepon') }}"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                            placeholder="Contoh: 081234567890"
                                            class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none invalid:border-red-300 shadow-sm">
                                    </div>

                                    <div class="space-y-1.5">
                                        <span class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                            Jenis Kelamin <span class="text-[#B11116]" title="Wajib diisi">*</span>
                                        </span>
                                        <div class="flex items-center gap-6 py-2">
                                            <label for="jk_l" class="inline-flex items-center cursor-pointer group">
                                                <input id="jk_l" type="radio" name="jenis_kelamin" value="l"
                                                    required {{ old('jenis_kelamin') == 'l' ? 'checked' : '' }}
                                                    class="w-4 h-4 text-[#B11116] border-gray-300 focus:ring-[#B11116]">
                                                <span
                                                    class="ml-2 text-sm font-medium text-gray-700 group-hover:text-gray-900">Laki-laki</span>
                                            </label>
                                            <label for="jk_p" class="inline-flex items-center cursor-pointer group">
                                                <input id="jk_p" type="radio" name="jenis_kelamin" value="p"
                                                    required {{ old('jenis_kelamin') == 'p' ? 'checked' : '' }}
                                                    class="w-4 h-4 text-[#B11116] border-gray-300 focus:ring-[#B11116]">
                                                <span
                                                    class="ml-2 text-sm font-medium text-gray-700 group-hover:text-gray-900">Perempuan</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="space-y-1.5">
                                        <label for="agama"
                                            class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                            Agama <span class="text-[#B11116]" title="Wajib diisi">*</span>
                                        </label>
                                        <select id="agama" name="agama" required
                                            class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none invalid:border-red-300 shadow-sm">
                                            <option value="" disabled {{ old('agama') ? '' : 'selected' }}>Pilih
                                                Agama</option>
                                            @foreach (['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Khonghucu', 'Lainnya'] as $agamaOption)
                                                <option value="{{ $agamaOption }}"
                                                    {{ old('agama') == $agamaOption ? 'selected' : '' }}>
                                                    {{ $agamaOption }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="space-y-1.5">
                                        <label for="tempat_lahir"
                                            class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                            Tempat Lahir <span class="text-[#B11116]" title="Wajib diisi">*</span>
                                        </label>
                                        <input id="tempat_lahir" name="tempat_lahir" type="text" required
                                            value="{{ old('tempat_lahir') }}" placeholder="Kota Lahir"
                                            class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none invalid:border-red-300 shadow-sm">
                                    </div>

                                    <div class="space-y-1.5">
                                        <label for="tanggal_lahir"
                                            class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                            Tanggal Lahir <span class="text-[#B11116]" title="Wajib diisi">*</span>
                                        </label>
                                        <input id="tanggal_lahir" name="tanggal_lahir" type="date" required
                                            value="{{ old('tanggal_lahir') }}"
                                            class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none invalid:border-red-300 shadow-sm">
                                    </div>

                                    {{-- FIX PROBLEM 1: Domisili State Management --}}
                                    <div class="space-y-4 md:col-span-2" x-data="{
                                        sameAddress: false,
                                        ktpAddress: @js(old('alamat_ktp', '')),
                                        domisiliAddress: @js(old('alamat_domisili', ''))
                                    }">
                                        <div class="space-y-1.5">
                                            <label for="alamat_ktp"
                                                class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                                Alamat Lengkap (Sesuai KTP) <span class="text-[#B11116]"
                                                    title="Wajib diisi">*</span>
                                            </label>
                                            <textarea id="alamat_ktp" name="alamat_ktp" rows="3" required x-model="ktpAddress"
                                                placeholder="Jl. Nama Jalan, RT/RW, Kelurahan, Kecamatan, Kota/Kabupaten"
                                                class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none invalid:border-red-300 shadow-sm"></textarea>
                                        </div>

                                        <div class="space-y-2 pt-2">
                                            <div class="flex items-center justify-between">
                                                <label for="alamat_domisili"
                                                    class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                                    Alamat Domisili saat ini <span class="text-[#B11116]"
                                                        title="Wajib diisi">*</span>
                                                </label>
                                                <label class="inline-flex items-center cursor-pointer select-none">
                                                    <input type="checkbox" x-model="sameAddress"
                                                        @change="if(sameAddress) domisiliAddress = ktpAddress"
                                                        class="rounded border-gray-300 text-[#B11116] focus:ring-[#B11116] w-4 h-4 cursor-pointer">
                                                    <span class="ml-2 text-xs font-semibold text-gray-600">Sama dengan
                                                        KTP</span>
                                                </label>
                                            </div>

                                            {{-- Gunakan readonly alih-alih disabled agar data tetap terkirim saat submit --}}
                                            <textarea id="alamat_domisili" name="alamat_domisili" rows="2" required
                                                x-model="sameAddress ? ktpAddress : domisiliAddress" :readonly="sameAddress"
                                                placeholder="Alamat Domisili Tempat Tinggal Saat Ini"
                                                class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none invalid:border-red-300 shadow-sm"
                                                :class="sameAddress ? 'bg-gray-100 text-gray-500 cursor-not-allowed' :
                                                    'bg-white'"></textarea>
                                        </div>
                                    </div>

                                    <div class="space-y-2 md:col-span-2 pt-2">
                                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                            Kepemilikan SIM (Pilih semua yang dimiliki)
                                        </label>
                                        <div class="grid grid-cols-2 sm:grid-cols-5 gap-3">
                                            @foreach (['A', 'B1', 'B2', 'C', 'D'] as $sim)
                                                <label
                                                    class="flex items-center p-3 bg-gray-50 rounded-xl border border-gray-200 hover:border-red-300 cursor-pointer transition-all group">
                                                    <input type="checkbox" name="jenis_sim[]"
                                                        value="{{ $sim }}"
                                                        {{ is_array(old('jenis_sim')) && in_array($sim, old('jenis_sim')) ? 'checked' : '' }}
                                                        class="w-4 h-4 rounded border-gray-300 text-[#B11116] focus:ring-[#B11116]">
                                                    <span
                                                        class="ml-2.5 text-xs font-bold text-gray-700 group-hover:text-[#B11116]">
                                                        SIM {{ $sim }}
                                                    </span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="space-y-3 md:col-span-2 pt-2" x-data="{ isExEmployee: @js(old('pernah_bekerja_internal', '')) }">
                                        <div class="space-y-1.5">
                                            <span class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                                Pernah Bekerja di Sinar Sosro / Gunung Slamat? <span class="text-[#B11116]"
                                                    title="Wajib diisi">*</span>
                                            </span>
                                            <div class="flex items-center gap-6 py-1">
                                                <label class="inline-flex items-center cursor-pointer group">
                                                    <input type="radio" name="pernah_bekerja_internal" value="1"
                                                        required x-model="isExEmployee"
                                                        class="w-4 h-4 text-[#B11116] border-gray-300 focus:ring-[#B11116]">
                                                    <span
                                                        class="ml-2 text-sm font-medium text-gray-700 group-hover:text-gray-900">Ya</span>
                                                </label>
                                                <label class="inline-flex items-center cursor-pointer group">
                                                    <input type="radio" name="pernah_bekerja_internal" value="0"
                                                        required x-model="isExEmployee"
                                                        class="w-4 h-4 text-[#B11116] border-gray-300 focus:ring-[#B11116]">
                                                    <span
                                                        class="ml-2 text-sm font-medium text-gray-700 group-hover:text-gray-900">Tidak</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div x-show="isExEmployee === '1'" x-cloak
                                            x-transition:enter="transition ease-out duration-200"
                                            x-transition:enter-start="opacity-0 -translate-y-2 scale-95"
                                            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                            x-transition:leave="transition ease-in duration-150"
                                            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                                            x-transition:leave-end="opacity-0 -translate-y-2 scale-95"
                                            class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 bg-red-50/50 rounded-xl border border-red-100">
                                            <div>
                                                <label for="nama_perusahaan_lama"
                                                    class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1">
                                                    Nama Perusahaan / Unit
                                                </label>
                                                <input id="nama_perusahaan_lama" type="text"
                                                    name="nama_perusahaan_lama" value="{{ old('nama_perusahaan_lama') }}"
                                                    placeholder="Pabrik / Cabang X"
                                                    :required="isExEmployee === '1'"
                                                    class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm text-gray-900 focus:ring-[#B11116] focus:border-[#B11116] outline-none shadow-sm">
                                            </div>
                                            <div>
                                                <label for="jabatan_terakhir"
                                                    class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1">
                                                    Jabatan Terakhir
                                                </label>
                                                <input id="jabatan_terakhir" type="text" name="jabatan_terakhir"
                                                    value="{{ old('jabatan_terakhir') }}"
                                                    placeholder="Contoh: Staff Produksi"
                                                    :required="isExEmployee === '1'"
                                                    class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm text-gray-900 focus:ring-[#B11116] focus:border-[#B11116] outline-none shadow-sm">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section class="space-y-5 pt-4">
                                <h2
                                    class="text-xs font-black uppercase tracking-wider text-gray-400 pb-1 border-b border-gray-100">
                                    2. Tautan Profesional & Sosial Media
                                </h2>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div class="space-y-1.5">
                                        <label for="instagram"
                                            class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                            URL Instagram
                                        </label>
                                        <input id="instagram" name="instagram" type="url"
                                            value="{{ old('instagram') }}" placeholder="https://instagram.com/username"
                                            class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                    </div>

                                    <div class="space-y-1.5">
                                        <label for="linkedin"
                                            class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                            URL LinkedIn
                                        </label>
                                        <input id="linkedin" name="linkedin" type="url"
                                            value="{{ old('linkedin') }}" placeholder="https://linkedin.com/in/username"
                                            class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                    </div>
                                </div>
                            </section>

                            <section class="space-y-5 pt-4">
                                <h2
                                    class="text-xs font-black uppercase tracking-wider text-gray-400 pb-1 border-b border-gray-100">
                                    3. Fisik & Kondisi Kesehatan
                                </h2>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div class="space-y-1.5">
                                        <label for="tinggi_badan"
                                            class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                            Tinggi Badan (cm) <span class="text-[#B11116]" title="Wajib diisi">*</span>
                                        </label>
                                        <input id="tinggi_badan" name="tinggi_badan" type="number" min="100"
                                            max="250" required value="{{ old('tinggi_badan') }}"
                                            placeholder="Contoh: 170"
                                            class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none invalid:border-red-300 shadow-sm">
                                    </div>

                                    <div class="space-y-1.5">
                                        <label for="berat_badan"
                                            class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                            Berat Badan (kg) <span class="text-[#B11116]" title="Wajib diisi">*</span>
                                        </label>
                                        <input id="berat_badan" name="berat_badan" type="number" min="30"
                                            max="200" required value="{{ old('berat_badan') }}"
                                            placeholder="Contoh: 65"
                                            class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none invalid:border-red-300 shadow-sm">
                                    </div>

                                    <div class="space-y-1.5">
                                        <label for="status_pernikahan"
                                            class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                            Status Pernikahan <span class="text-[#B11116]" title="Wajib diisi">*</span>
                                        </label>
                                        <select id="status_pernikahan" name="status_pernikahan" required
                                            class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none invalid:border-red-300 shadow-sm">
                                            <option value="" disabled
                                                {{ old('status_pernikahan') ? '' : 'selected' }}>Pilih Status</option>
                                            <option value="belum_menikah"
                                                {{ old('status_pernikahan') == 'belum_menikah' ? 'selected' : '' }}>Belum
                                                Menikah</option>
                                            <option value="sudah_menikah"
                                                {{ old('status_pernikahan') == 'sudah_menikah' ? 'selected' : '' }}>Sudah
                                                Menikah</option>
                                            <option value="cerai_hidup"
                                                {{ old('status_pernikahan') == 'cerai_hidup' ? 'selected' : '' }}>Cerai
                                                Hidup</option>
                                            <option value="cerai_mati"
                                                {{ old('status_pernikahan') == 'cerai_mati' ? 'selected' : '' }}>Cerai Mati
                                            </option>
                                        </select>
                                    </div>

                                    <div class="space-y-1.5">
                                        <label for="riwayat_penyakit"
                                            class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                            Riwayat Penyakit
                                        </label>
                                        <input id="riwayat_penyakit" name="riwayat_penyakit" type="text"
                                            value="{{ old('riwayat_penyakit') }}"
                                            placeholder="Tuliskan riwayat atau kosongkan jika tidak ada"
                                            class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                    </div>

                                    <div class="space-y-1.5">
                                        <label for="perokok"
                                            class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                            Perokok? <span class="text-[#B11116]" title="Wajib diisi">*</span>
                                        </label>
                                        <select id="perokok" name="perokok" required
                                            class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none invalid:border-red-300 shadow-sm">
                                            <option value="" disabled
                                                {{ old('perokok') !== null ? '' : 'selected' }}>Pilih Jawaban</option>
                                            <option value="0" {{ old('perokok') === '0' ? 'selected' : '' }}>Tidak
                                            </option>
                                            <option value="1" {{ old('perokok') === '1' ? 'selected' : '' }}>Ya
                                            </option>
                                        </select>
                                    </div>

                                    <div class="space-y-1.5">
                                        <label for="bertato"
                                            class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                            Bertato? <span class="text-[#B11116]" title="Wajib diisi">*</span>
                                        </label>
                                        <select id="bertato" name="bertato" required
                                            class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none invalid:border-red-300 shadow-sm">
                                            <option value="" disabled
                                                {{ old('bertato') !== null ? '' : 'selected' }}>Pilih Jawaban</option>
                                            <option value="0" {{ old('bertato') === '0' ? 'selected' : '' }}>Tidak
                                            </option>
                                            <option value="1" {{ old('bertato') === '1' ? 'selected' : '' }}>Ya
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </section>

                            <section class="space-y-5 pt-4">
                                <h2
                                    class="text-xs font-black uppercase tracking-wider text-gray-400 pb-1 border-b border-gray-100">
                                    4. Ekspektasi & Kesiapan Kerja
                                </h2>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                                    <div class="space-y-1.5" x-data="{
                                        rawVal: @js(old('ekspektasi_gaji', '')),
                                        get formattedVal() {
                                            const clean = String(this.rawVal).replace(/[^0-9]/g, '');
                                            return clean ? new Intl.NumberFormat('id-ID').format(clean) : '';
                                        },
                                        formatInput(e) {
                                            this.rawVal = e.target.value.replace(/[^0-9]/g, '');
                                        }
                                    }">
                                        <label for="ekspektasi_gaji_display"
                                            class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                            Gaji yang Diharapkan <span class="text-[#B11116]" title="Wajib diisi">*</span>
                                        </label>
                                        <div class="relative flex items-center">
                                            <span
                                                class="absolute left-4 text-gray-500 font-bold text-sm select-none">Rp</span>
                                            <input id="ekspektasi_gaji_display" type="text" inputmode="numeric"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '');" required
                                                placeholder="6.500.000" :value="formattedVal"
                                                @input="formatInput($event)"
                                                class="w-full pl-11 pr-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none invalid:border-red-300 shadow-sm">
                                            <input type="hidden" id="ekspektasi_gaji" name="ekspektasi_gaji"
                                                :value="rawVal">
                                        </div>
                                    </div>

                                    <div class="space-y-1.5">
                                        <label for="ekspektasi_fasilitas"
                                            class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                            Fasilitas yang Diharapkan
                                        </label>
                                        <input id="ekspektasi_fasilitas" name="ekspektasi_fasilitas" type="text"
                                            value="{{ old('ekspektasi_fasilitas') }}"
                                            placeholder="Contoh: BPJS Kesehatan, Tunjangan Transport"
                                            class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                    </div>

                                    <div class="space-y-1.5">
                                        <label for="bersedia_dinas_luar"
                                            class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                            Bersedia Dinas Luar Kota? <span class="text-[#B11116]"
                                                title="Wajib diisi">*</span>
                                        </label>
                                        <select id="bersedia_dinas_luar" name="bersedia_dinas_luar" required
                                            class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none invalid:border-red-300 shadow-sm">
                                            <option value="" disabled
                                                {{ old('bersedia_dinas_luar') !== null ? '' : 'selected' }}>Pilih Jawaban
                                            </option>
                                            <option value="1"
                                                {{ old('bersedia_dinas_luar') === '1' ? 'selected' : '' }}>Ya</option>
                                            <option value="0"
                                                {{ old('bersedia_dinas_luar') === '0' ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </div>

                                    <div class="space-y-1.5">
                                        <label for="bersedia_penempatan_luar"
                                            class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                            Bersedia Ditempatkan di Luar Kota? <span class="text-[#B11116]"
                                                title="Wajib diisi">*</span>
                                        </label>
                                        <select id="bersedia_penempatan_luar" name="bersedia_penempatan_luar" required
                                            class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none invalid:border-red-300 shadow-sm">
                                            <option value="" disabled
                                                {{ old('bersedia_penempatan_luar') !== null ? '' : 'selected' }}>Pilih
                                                Jawaban</option>
                                            <option value="1"
                                                {{ old('bersedia_penempatan_luar') === '1' ? 'selected' : '' }}>Ya</option>
                                            <option value="0"
                                                {{ old('bersedia_penempatan_luar') === '0' ? 'selected' : '' }}>Tidak
                                            </option>
                                        </select>
                                    </div>

                                    <div class="space-y-1.5 md:col-span-2">
                                        <label for="referensi_perusahaan"
                                            class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                            Referensi Internal (Jika Ada)
                                        </label>
                                        <input id="referensi_perusahaan" name="referensi_perusahaan" type="text"
                                            value="{{ old('referensi_perusahaan') }}"
                                            placeholder="Nama & Jabatan Kerabat/Kenalan di Perusahaan"
                                            class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                                    </div>
                                </div>

                                @php
                                    $orderedDivisis = $divisis;
                                    if (old('minat_ids')) {
                                        $oldIds = old('minat_ids');
                                        $orderedDivisis = $divisis->sortBy(function ($item) use ($oldIds) {
                                            return array_search($item->id, $oldIds);
                                        });
                                    }
                                @endphp

                                <div class="md:col-span-2 space-y-4 pt-4 border-t border-gray-100 mt-2">
                                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-3">
                                        <div>
                                            <label class="text-xs font-black text-gray-800 uppercase tracking-wider block">
                                                Urutkan Minat Bekerja
                                            </label>
                                            <p class="text-xs text-gray-400 font-medium mt-0.5">
                                                Atur urutan prioritas bidang kerja yang paling Anda minati (drag & drop).
                                            </p>
                                        </div>
                                        <div
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-50 border border-red-100 rounded-lg text-[#B11116] self-start md:self-auto">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M8 9l4-4 4 4M8 15l4 4 4-4M12 5v14" />
                                            </svg>
                                            <span class="text-[10px] font-black uppercase tracking-wider">Dapat
                                                Digeser</span>
                                        </div>
                                    </div>

                                    <div id="minat-list" class="space-y-2.5">
                                        @foreach ($orderedDivisis as $index => $divisi)
                                            <div data-id="{{ $divisi->id }}"
                                                class="minat-item flex items-center bg-white p-3 rounded-xl border border-gray-200 hover:border-[#B11116] hover:shadow-sm transition-all duration-200 cursor-grab active:cursor-grabbing group select-none">

                                                <div
                                                    class="flex-shrink-0 flex items-center justify-center w-8 h-8 bg-red-50 rounded-lg border border-red-100 mr-3 group-hover:bg-[#B11116] transition-colors">
                                                    <span
                                                        class="text-xs font-black text-[#B11116] group-hover:text-white rank-number">{{ $loop->iteration }}</span>
                                                </div>

                                                <div class="flex-1 min-w-0">
                                                    <span
                                                        class="text-sm font-bold text-gray-800 block truncate">{{ $divisi->nama }}</span>
                                                    <span
                                                        class="text-[9px] font-semibold text-gray-400 uppercase tracking-wider">
                                                        Prioritas <span class="rank-label">{{ $loop->iteration }}</span>
                                                    </span>
                                                </div>

                                                <input type="hidden" name="minat_ids[]"
                                                    value="{{ $divisi->id }}">

                                                <div
                                                    class="flex items-center gap-2 pl-3 ml-3 border-l border-gray-100 text-gray-400 group-hover:text-[#B11116]">
                                                    <span
                                                        class="text-[10px] font-bold uppercase tracking-wider hidden sm:inline">Geser</span>
                                                    <div
                                                        class="w-7 h-7 rounded-lg bg-gray-50 group-hover:bg-red-50 flex items-center justify-center transition-colors">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                            stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M8 9l4-4 4 4M8 15l4 4 4-4" />
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </section>
                        </div>

                        <div class="pt-8 border-t border-gray-100 flex justify-end">
                            <button type="submit" id="btnSubmit" :disabled="submitting"
                                class="w-full sm:w-auto px-8 py-3 bg-[#B11116] hover:bg-red-800 text-white font-bold text-sm rounded-xl shadow-md transition-all flex items-center justify-center gap-2 cursor-pointer focus:ring-4 focus:ring-red-200 disabled:opacity-50 disabled:cursor-not-allowed">

                                <span x-show="!submitting">Simpan & Lanjut ke Step 2</span>

                                <span x-show="submitting" x-cloak class="inline-flex items-center gap-2">
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

                                <svg x-show="!submitting" class="w-4 h-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <style>
        @keyframes shuffleBounce {
            0% {
                transform: translateY(0) scale(1);
            }

            30% {
                transform: translateY(-4px) scale(1.01);
            }

            50% {
                transform: translateY(2px) scale(0.99);
            }

            100% {
                transform: translateY(0) scale(1);
            }
        }

        .animate-bounce-item {
            animation: shuffleBounce 0.35s ease-in-out;
        }

        .sortable-ghost-custom {
            opacity: 0.4;
            background-color: #fef2f2 !important;
            border-color: #B11116 !important;
        }

        .sortable-drag-custom {
            box-shadow: 0 10px 25px -5px rgba(177, 17, 22, 0.25);
            background-color: #ffffff !important;
            border-color: #B11116 !important;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const minatList = document.getElementById('minat-list');
            if (!minatList) return;

            Sortable.create(minatList, {
                animation: 250,
                easing: "cubic-bezier(1, 0, 0, 1)",
                ghostClass: 'sortable-ghost-custom',
                dragClass: 'sortable-drag-custom',
                onEnd: function(evt) {
                    updateRankNumbers();

                    if (evt.item) {
                        evt.item.classList.remove('animate-bounce-item');
                        void evt.item.offsetWidth;
                        evt.item.classList.add('animate-bounce-item');

                        setTimeout(() => {
                            evt.item.classList.remove('animate-bounce-item');
                        }, 350);
                    }
                }
            });

            function updateRankNumbers() {
                const items = minatList.querySelectorAll('.minat-item');
                items.forEach((item, index) => {
                    const newRank = index + 1;
                    const rankNumber = item.querySelector('.rank-number');
                    const rankLabel = item.querySelector('.rank-label');

                    if (rankNumber) rankNumber.textContent = newRank;
                    if (rankLabel) rankLabel.textContent = newRank;
                });
            }
        });
    </script>
@endsection
