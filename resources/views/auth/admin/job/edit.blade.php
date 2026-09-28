@extends('auth.admin.layouts.index')

@section('title', 'Edit Data Lowongan')

@section('content')
    <div class="bg-white border-b border-slate-300 px-3 py-1.5 flex items-center justify-between shrink-0 select-none">
        <div class="flex items-center gap-2 text-[11px]">
            <a href="{{ route('job.index') }}" class="text-slate-500 hover:text-blue-600 flex items-center gap-1">
                <i data-lucide="briefcase" class="w-3.5 h-3.5"></i>
                <span>Kelola Lowongan</span>
            </a>
            <span class="text-slate-400">/</span>
            <span class="font-bold text-slate-800">Edit Lowongan: {{ $job->title }}</span>
        </div>

        <a href="{{ route('job.index') }}"
            class="px-2 py-0.5 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded text-[10px] font-semibold flex items-center gap-1 transition-colors hover:cursor-pointer">
            <i data-lucide="arrow-left" class="w-3 h-3"></i> Kembali ke Daftar
        </a>
    </div>

    <div class="flex-1 p-3 overflow-y-auto">
        <div class="max-w-4xl mx-auto bg-white border border-slate-300 rounded shadow-sm overflow-hidden">

            <div class="bg-slate-800 text-white px-3 py-2 border-b border-slate-700 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i data-lucide="edit-3" class="w-4 h-4 text-amber-400"></i>
                    <h1 class="font-bold text-xs tracking-wide">FORMULIR PERUBAHAN DATA LOWONGAN PEKERJAAN</h1>
                </div>
                <span class="text-[10px] font-mono text-slate-400">ID: {{ $job->id }}</span>
            </div>

            <form action="{{ route('job.update', $job->id) }}" method="POST" class="p-4 space-y-4">
                @csrf
                @method('PUT')

                <!-- SEKSI 1: INFORMASI UTAMA LOWONGAN -->
                <div class="space-y-3">
                    <div class="border-b border-slate-200 pb-1 flex items-center justify-between">
                        <span class="font-bold text-[11px] text-slate-700 uppercase tracking-tight font-mono">
                            1. Informasi Utama Lowongan
                        </span>
                        <span class="text-[10px] text-rose-600 font-medium">* Wajib Diisi</span>
                    </div>

                    <div class="grid grid-cols-1 gap-3 text-[11px]">
                        <!-- Judul Lowongan -->
                        <div class="grid grid-cols-1 sm:grid-cols-4 items-center gap-2">
                            <label for="title" class="font-semibold text-slate-700 sm:text-right">
                                Judul Lowongan <span class="text-rose-600">*</span>
                            </label>
                            <div class="sm:col-span-3">
                                <input type="text" id="title" name="title" value="{{ old('title', $job->title) }}"
                                    placeholder="Contoh: Senior Backend Developer, Management Trainee..."
                                    class="w-full px-2 py-1 bg-slate-50 border border-slate-300 rounded text-[11px] font-sans text-slate-900 focus:bg-white focus:outline-none focus:border-blue-600 @error('title') border-rose-500 @enderror"
                                    required>
                                @error('title')
                                    <span class="text-[10px] text-rose-600 mt-0.5 block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Kantor / Cabang Penempatan -->
                        <div class="grid grid-cols-1 sm:grid-cols-4 items-center gap-2">
                            <label for="office_id" class="font-semibold text-slate-700 sm:text-right">
                                Kantor / Cabang <span class="text-rose-600">*</span>
                            </label>
                            <div class="sm:col-span-3">
                                <select id="office_id" name="office_id"
                                    class="w-full px-2 py-1 bg-slate-50 border border-slate-300 rounded text-[11px] font-sans text-slate-900 focus:bg-white focus:outline-none focus:border-blue-600 @error('office_id') border-rose-500 @enderror"
                                    required>
                                    <option value="" disabled>-- Pilih Lokasi Cabang --</option>
                                    @foreach ($offices as $office)
                                        <option value="{{ $office->id }}"
                                            {{ old('office_id', $job->office_id) == $office->id ? 'selected' : '' }}>
                                            {{ $office->name ?? $office->title }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('office_id')
                                    <span class="text-[10px] text-rose-600 mt-0.5 block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Kategori & Bidang Pekerjaan -->
                        <div class="grid grid-cols-1 sm:grid-cols-4 items-center gap-2">
                            <label for="category" class="font-semibold text-slate-700 sm:text-right">
                                Kategori & Bidang <span class="text-rose-600">*</span>
                            </label>
                            <div class="sm:col-span-3 grid grid-cols-1 sm:grid-cols-2 gap-2">
                                <div>
                                    <select id="category" name="category"
                                        class="w-full px-2 py-1 bg-slate-50 border border-slate-300 rounded text-[11px] font-sans text-slate-900 focus:bg-white focus:outline-none focus:border-blue-600 @error('category') border-rose-500 @enderror"
                                        required>
                                        <option value="" disabled>-- Pilih Kategori --</option>
                                        <option value="profesional"
                                            {{ old('category', $job->category) == 'profesional' ? 'selected' : '' }}>
                                            Profesional</option>
                                        <option value="management_trainee"
                                            {{ old('category', $job->category) == 'management_trainee' ? 'selected' : '' }}>
                                            Management Trainee</option>
                                        <option value="internship"
                                            {{ old('category', $job->category) == 'internship' ? 'selected' : '' }}>Magang /
                                            Internship</option>
                                    </select>
                                    @error('category')
                                        <span class="text-[10px] text-rose-600 mt-0.5 block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <select id="occupation" name="occupation"
                                        class="w-full px-2 py-1 bg-slate-50 border border-slate-300 rounded text-[11px] font-sans text-slate-900 focus:bg-white focus:outline-none focus:border-blue-600 @error('occupation') border-rose-500 @enderror"
                                        required>
                                        <option value="" disabled>-- Pilih Bidang --</option>
                                        @foreach ($divisions as $division)
                                            <option value="{{ $division->name }}"
                                                {{ old('occupation', $job->occupation) == $division->name ? 'selected' : '' }}>
                                                {{ $division->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('occupation')
                                        <span class="text-[10px] text-rose-600 mt-0.5 block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Tipe Lowongan & Lokasi Kerja -->
                        <div class="grid grid-cols-1 sm:grid-cols-4 items-center gap-2">
                            <label for="type" class="font-semibold text-slate-700 sm:text-right">
                                Tipe & Lokasi Kerja <span class="text-rose-600">*</span>
                            </label>
                            <div class="sm:col-span-3 grid grid-cols-1 sm:grid-cols-2 gap-2">
                                <div>
                                    <select id="type" name="type"
                                        class="w-full px-2 py-1 bg-slate-50 border border-slate-300 rounded text-[11px] font-sans text-slate-900 focus:bg-white focus:outline-none focus:border-blue-600 @error('type') border-rose-500 @enderror"
                                        required>
                                        <option value="" disabled>-- Pilih Tipe Kerja --</option>
                                        <option value="Full-Time"
                                            {{ old('type', $job->type) == 'Full-Time' ? 'selected' : '' }}>Full-Time
                                        </option>
                                        <option value="Part-Time"
                                            {{ old('type', $job->type) == 'Part-Time' ? 'selected' : '' }}>Part-Time
                                        </option>
                                        <option value="Freelance"
                                            {{ old('type', $job->type) == 'Freelance' ? 'selected' : '' }}>Freelance
                                        </option>
                                        <option value="Kontrak"
                                            {{ old('type', $job->type) == 'Kontrak' ? 'selected' : '' }}>Kontrak</option>
                                    </select>
                                    @error('type')
                                        <span class="text-[10px] text-rose-600 mt-0.5 block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <input type="text" id="location" name="location"
                                        value="{{ old('location', $job->location) }}"
                                        placeholder="Lokasi Kerja (misal: Jakarta Selatan)"
                                        class="w-full px-2 py-1 bg-slate-50 border border-slate-300 rounded text-[11px] font-sans text-slate-900 focus:bg-white focus:outline-none focus:border-blue-600 @error('location') border-rose-500 @enderror"
                                        required>
                                    @error('location')
                                        <span class="text-[10px] text-rose-600 mt-0.5 block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SEKSI 2: DETAIL DESKRIPSI & KUALIFIKASI -->
                <div class="space-y-3 pt-2">
                    <div class="border-b border-slate-200 pb-1 flex items-center justify-between">
                        <span class="font-bold text-[11px] text-slate-700 uppercase tracking-tight font-mono">
                            2. Detail & Kualifikasi
                        </span>
                    </div>

                    <div class="grid grid-cols-1 gap-3 text-[11px]">
                        <!-- Deskripsi Pekerjaan -->
                        <div class="grid grid-cols-1 sm:grid-cols-4 items-start gap-2">
                            <label for="description" class="font-semibold text-slate-700 sm:text-right pt-1">
                                Deskripsi Pekerjaan <span class="text-rose-600">*</span>
                            </label>
                            <div class="sm:col-span-3">
                                <textarea id="description" name="description" rows="4"
                                    placeholder="Tuliskan tanggung jawab dan rincian pekerjaan..."
                                    class="w-full px-2 py-1 bg-slate-50 border border-slate-300 rounded text-[11px] font-sans text-slate-900 focus:bg-white focus:outline-none focus:border-blue-600 @error('description') border-rose-500 @enderror"
                                    required>{{ old('description', $job->description ?? $job->jobdescription) }}</textarea>
                                @error('description')
                                    <span class="text-[10px] text-rose-600 mt-0.5 block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Kualifikasi -->
                        <div class="grid grid-cols-1 sm:grid-cols-4 items-start gap-2">
                            <label for="qualification" class="font-semibold text-slate-700 sm:text-right pt-1">
                                Kualifikasi Pelamar <span class="text-rose-600">*</span>
                            </label>
                            <div class="sm:col-span-3">
                                <textarea id="qualification" name="qualification" rows="4"
                                    placeholder="Tuliskan persyaratan pendidikan, pengalaman, keahlian..."
                                    class="w-full px-2 py-1 bg-slate-50 border border-slate-300 rounded text-[11px] font-sans text-slate-900 focus:bg-white focus:outline-none focus:border-blue-600 @error('qualification') border-rose-500 @enderror"
                                    required>{{ old('qualification', $job->qualification) }}</textarea>
                                @error('qualification')
                                    <span class="text-[10px] text-rose-600 mt-0.5 block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SEKSI 3: PERIODE & STATUS LOWONGAN -->
                <div class="space-y-3 pt-2">
                    <div class="border-b border-slate-200 pb-1 flex items-center justify-between">
                        <span class="font-bold text-[11px] text-slate-700 uppercase tracking-tight font-mono">
                            3. Periode Pendaftaran & Status
                        </span>
                    </div>

                    <div class="grid grid-cols-1 gap-3 text-[11px]">
                        <!-- Tanggal Mulai & Akhir -->
                        <div class="grid grid-cols-1 sm:grid-cols-4 items-center gap-2">
                            <label class="font-semibold text-slate-700 sm:text-right">
                                Periode Lowongan <span class="text-rose-600">*</span>
                            </label>
                            <div class="sm:col-span-3 grid grid-cols-1 sm:grid-cols-2 gap-2">
                                <div>
                                    <label for="opening_date" class="text-[10px] text-slate-500 block">Tanggal
                                        Buka</label>
                                    <input type="date" id="opening_date" name="opening_date"
                                        value="{{ old('opening_date', \Carbon\Carbon::parse($job->opening_date)->format('Y-m-d')) }}"
                                        class="w-full px-2 py-1 bg-slate-50 border border-slate-300 rounded text-[11px] font-sans text-slate-900 focus:bg-white focus:outline-none focus:border-blue-600 @error('opening_date') border-rose-500 @enderror"
                                        required>
                                    @error('opening_date')
                                        <span class="text-[10px] text-rose-600 mt-0.5 block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <label for="closing_date" class="text-[10px] text-slate-500 block">Tanggal
                                        Tutup</label>
                                    <input type="date" id="closing_date" name="closing_date"
                                        value="{{ old('closing_date', \Carbon\Carbon::parse($job->closing_date)->format('Y-m-d')) }}"
                                        class="w-full px-2 py-1 bg-slate-50 border border-slate-300 rounded text-[11px] font-sans text-slate-900 focus:bg-white focus:outline-none focus:border-blue-600 @error('closing_date') border-rose-500 @enderror"
                                        required>
                                    @error('closing_date')
                                        <span class="text-[10px] text-rose-600 mt-0.5 block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Status Lowongan -->
                        <div class="grid grid-cols-1 sm:grid-cols-4 items-center gap-2">
                            <label for="status" class="font-semibold text-slate-700 sm:text-right">
                                Status Publikasi <span class="text-rose-600">*</span>
                            </label>
                            <div class="sm:col-span-3">
                                <select id="status" name="status"
                                    class="w-full px-2 py-1 bg-slate-50 border border-slate-300 rounded text-[11px] font-sans text-slate-900 focus:bg-white focus:outline-none focus:border-blue-600 @error('status') border-rose-500 @enderror"
                                    required>
                                    <option value="aktif" {{ old('status', $job->status) == 'aktif' ? 'selected' : '' }}>
                                        Aktif</option>
                                    <option value="nonaktif"
                                        {{ old('status', $job->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                    <option value="selesai"
                                        {{ old('status', $job->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    <option value="dihapus"
                                        {{ old('status', $job->status) == 'dihapus' ? 'selected' : '' }}>Dihapus</option>
                                </select>
                                @error('status')
                                    <span class="text-[10px] text-rose-600 mt-0.5 block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- BUTTON ACTIONS -->
                <div class="pt-3 border-t border-slate-200 flex items-center justify-end gap-2">
                    <a href="{{ route('job.index') }}"
                        class="px-3 py-1 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded text-[11px] font-semibold transition-colors hover:cursor-pointer">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-3 py-1 bg-amber-600 hover:bg-amber-700 text-white rounded text-[11px] font-semibold flex items-center gap-1 shadow-sm transition-colors hover:cursor-pointer">
                        <i data-lucide="rotate-cw" class="w-3.5 h-3.5"></i> Perbarui Data Lowongan
                    </button>
                </div>

            </form>

        </div>
    </div>
@endsection
