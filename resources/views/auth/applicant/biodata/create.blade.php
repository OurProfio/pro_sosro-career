@extends('auth.applicant.layouts.index')

@section('title', 'Biodata Pelamar')

@section('content')
    <div class="py-8 md:py-12 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto font-figtree">

        <!-- STEPPER HEADER -->
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

        <form action="{{ route('biodata.store') }}" method="POST" id="biodataForm">
            @csrf
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-6 sm:p-10">
                    <header class="mb-8 pb-4 border-b border-gray-100">
                        <h1 class="text-2xl font-black text-gray-900 tracking-tight">
                            Data <span class="text-[#B11116]">Personal</span>
                        </h1>
                        <p class="text-gray-500 text-sm mt-1">
                            Isi informasi identitas diri Anda secara akurat sesuai dengan dokumen resmi (KTP).
                        </p>
                    </header>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        <!-- NIK -->
                        <div class="space-y-1.5">
                            <label for="nik" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                NIK (Sesuai KTP) <span class="text-[#B11116]" title="Wajib diisi">*</span>
                            </label>
                            <input id="nik" name="nik" type="text" inputmode="numeric" required
                                pattern="[0-9]{16}" maxlength="16"
                                value="{{ old('nik', auth()->user()->applicant->nik ?? '') }}"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '');" placeholder="16 digit angka KTP"
                                class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none invalid:border-red-300 shadow-sm">
                            <span class="text-[11px] text-gray-400 block">Harus berisi 16 digit angka.</span>
                        </div>

                        <div class="space-y-1.5">
                            <label for="name" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Nama Lengkap <span class="text-[#B11116]" title="Wajib diisi">*</span>
                            </label>
                            <input id="name" name="name" type="text" required
                                value="{{ old('name', auth()->user()->applicant->name ?? '') }}"
                                placeholder="Nama Lengkap Sesuai KTP"
                                class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none invalid:border-red-300 shadow-sm">
                        </div>

                        <!-- EMAIL -->
                        <div class="space-y-1.5">
                            <label for="email" class="block text-xs font-bold text-gray-400 uppercase tracking-wider">
                                Alamat Email
                            </label>
                            <input id="email" name="email" type="email"
                                value="{{ old('email', auth()->user()->applicant->email ?? (auth()->user()->email ?? '')) }}"
                                readonly
                                class="w-full px-4 py-2.5 bg-gray-50 text-gray-500 rounded-xl border border-gray-200 font-semibold text-sm cursor-not-allowed outline-none">
                        </div>

                        <!-- NO TELEPON -->
                        <div class="space-y-1.5">
                            <label for="no_telepon" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                No. Telepon / WA <span class="text-[#B11116]" title="Wajib diisi">*</span>
                            </label>
                            <input id="no_telepon" name="no_telepon" type="tel" inputmode="numeric" required
                                pattern="[0-9]{10,15}"
                                value="{{ old('no_telepon', auth()->user()->applicant->no_telepon ?? '') }}"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '');" placeholder="Contoh: 081234567890"
                                class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none invalid:border-red-300 shadow-sm">
                        </div>

                        <!-- JENIS KELAMIN -->
                        <div class="space-y-1.5">
                            <span class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Jenis Kelamin <span class="text-[#B11116]" title="Wajib diisi">*</span>
                            </span>
                            <div class="flex items-center gap-6 py-2">
                                <label for="jk_l" class="inline-flex items-center cursor-pointer group">
                                    <input id="jk_l" type="radio" name="jenis_kelamin" value="l" required
                                        {{ old('jenis_kelamin', auth()->user()->applicant->jenis_kelamin ?? '') == 'l' ? 'checked' : '' }}
                                        class="w-4 h-4 text-[#B11116] border-gray-300 focus:ring-[#B11116]">
                                    <span
                                        class="ml-2 text-sm font-medium text-gray-700 group-hover:text-gray-900">Laki-laki</span>
                                </label>
                                <label for="jk_p" class="inline-flex items-center cursor-pointer group">
                                    <input id="jk_p" type="radio" name="jenis_kelamin" value="p" required
                                        {{ old('jenis_kelamin', auth()->user()->applicant->jenis_kelamin ?? '') == 'p' ? 'checked' : '' }}
                                        class="w-4 h-4 text-[#B11116] border-gray-300 focus:ring-[#B11116]">
                                    <span
                                        class="ml-2 text-sm font-medium text-gray-700 group-hover:text-gray-900">Perempuan</span>
                                </label>
                            </div>
                        </div>

                        <!-- AGAMA -->
                        <div class="space-y-1.5">
                            <label for="agama" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Agama <span class="text-[#B11116]" title="Wajib diisi">*</span>
                            </label>
                            <select id="agama" name="agama" required
                                class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none invalid:border-red-300 shadow-sm">
                                <option value="" disabled
                                    {{ old('agama', auth()->user()->applicant->agama ?? '') ? '' : 'selected' }}>Pilih Agama
                                </option>
                                @foreach (['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Khonghucu', 'Lainnya'] as $agamaOption)
                                    <option value="{{ $agamaOption }}"
                                        {{ old('agama', auth()->user()->applicant->agama ?? '') == $agamaOption ? 'selected' : '' }}>
                                        {{ $agamaOption }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- TEMPAT LAHIR -->
                        <div class="space-y-1.5">
                            <label for="tempat_lahir"
                                class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Tempat Lahir <span class="text-[#B11116]" title="Wajib diisi">*</span>
                            </label>
                            <input id="tempat_lahir" name="tempat_lahir" type="text" required
                                value="{{ old('tempat_lahir', auth()->user()->applicant->tempat_lahir ?? '') }}"
                                placeholder="Kota Lahir"
                                class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none invalid:border-red-300 shadow-sm">
                        </div>

                        <!-- TANGGAL LAHIR -->
                        <div class="space-y-1.5">
                            <label for="tanggal_lahir"
                                class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Tanggal Lahir <span class="text-[#B11116]" title="Wajib diisi">*</span>
                            </label>
                            <input id="tanggal_lahir" name="tanggal_lahir" type="date" required
                                value="{{ old('tanggal_lahir', auth()->user()->applicant->tanggal_lahir ?? '') }}"
                                class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none invalid:border-red-300 shadow-sm">
                        </div>

                        <!-- TINGGI BADAN -->
                        <div class="space-y-1.5">
                            <label for="tinggi_badan"
                                class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Tinggi Badan (cm) <span class="text-[#B11116]" title="Wajib diisi">*</span>
                            </label>
                            <input id="tinggi_badan" name="tinggi_badan" type="number" min="100" max="250"
                                required value="{{ old('tinggi_badan', auth()->user()->applicant->tinggi_badan ?? '') }}"
                                placeholder="Contoh: 170"
                                class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none invalid:border-red-300 shadow-sm">
                        </div>

                        <!-- BERAT BADAN -->
                        <div class="space-y-1.5">
                            <label for="berat_badan"
                                class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Berat Badan (kg) <span class="text-[#B11116]" title="Wajib diisi">*</span>
                            </label>
                            <input id="berat_badan" name="berat_badan" type="number" min="30" max="200"
                                required value="{{ old('berat_badan', auth()->user()->applicant->berat_badan ?? '') }}"
                                placeholder="Contoh: 65"
                                class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none invalid:border-red-300 shadow-sm">
                        </div>

                        <!-- STATUS PERNIKAHAN -->
                        <div class="space-y-1.5 md:col-span-2">
                            <label for="status_pernikahan"
                                class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Status Pernikahan <span class="text-[#B11116]" title="Wajib diisi">*</span>
                            </label>
                            <select id="status_pernikahan" name="status_pernikahan" required
                                class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none invalid:border-red-300 shadow-sm">
                                <option value="" disabled
                                    {{ old('status_pernikahan', auth()->user()->applicant->status_pernikahan ?? '') ? '' : 'selected' }}>
                                    Pilih Status</option>
                                <option value="belum_menikah"
                                    {{ old('status_pernikahan', auth()->user()->applicant->status_pernikahan ?? '') == 'belum_menikah' ? 'selected' : '' }}>
                                    Belum Menikah</option>
                                <option value="sudah_menikah"
                                    {{ old('status_pernikahan', auth()->user()->applicant->status_pernikahan ?? '') == 'sudah_menikah' ? 'selected' : '' }}>
                                    Sudah Menikah</option>
                                <option value="cerai_hidup"
                                    {{ old('status_pernikahan', auth()->user()->applicant->status_pernikahan ?? '') == 'cerai_hidup' ? 'selected' : '' }}>
                                    Cerai Hidup</option>
                                <option value="cerai_mati"
                                    {{ old('status_pernikahan', auth()->user()->applicant->status_pernikahan ?? '') == 'cerai_mati' ? 'selected' : '' }}>
                                    Cerai Mati</option>
                            </select>
                        </div>

                    </div>

                    <!-- SUBMIT BUTTON -->
                    <div class="pt-8 border-t border-gray-100 flex justify-end mt-8">
                        <button type="submit" id="btnSubmit"
                            class="w-full sm:w-auto px-8 py-3 bg-[#B11116] hover:bg-red-800 text-white font-bold text-sm rounded-xl shadow-md transition-all flex items-center justify-center gap-2 cursor-pointer focus:ring-4 focus:ring-red-200 disabled:opacity-50 disabled:cursor-not-allowed">

                            <span id="btnText">Simpan & Lanjut ke Step 2</span>

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
        document.addEventListener('DOMContentLoaded', function() {
            const biodataForm = document.getElementById('biodataForm');
            const btnSubmit = document.getElementById('btnSubmit');
            const btnText = document.getElementById('btnText');
            const btnLoadingText = document.getElementById('btnLoadingText');
            const btnArrow = document.getElementById('btnArrow');

            if (biodataForm && btnSubmit) {
                biodataForm.addEventListener('submit', function() {
                    btnSubmit.disabled = true;
                    if (btnText) btnText.classList.add('hidden');
                    if (btnArrow) btnArrow.classList.add('hidden');
                    if (btnLoadingText) btnLoadingText.classList.remove('hidden');
                });
            }
        });
    </script>
@endsection
