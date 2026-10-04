@extends('auth.admin.layouts.index')

@section('title', 'Tambah Lowongan Baru')

@section('content')
    <div class="max-w-2xl mx-auto space-y-6 font-sans">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-slate-800">Tambah Lowongan Baru</h2>
                <p class="text-sm text-slate-500">Isi formulir berikut untuk menambahkan lowongan pekerjaan baru.</p>
            </div>

            <a href="{{ route('job.index') }}"
                class="inline-flex items-center gap-2 px-3.5 py-2 text-sm font-medium text-slate-600 hover:text-slate-900 bg-white hover:bg-slate-100 border border-slate-200 rounded-xl transition-colors">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
                <span>Kembali</span>
            </a>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-xs">
            <form action="{{ route('job.store') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="title" class="block text-sm font-medium text-slate-700 mb-1.5">
                        Judul Lowongan <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}"
                        placeholder="Contoh: Senior Backend Developer"
                        class="w-full px-3.5 py-2.5 text-sm bg-white border rounded-xl outline-none transition-all placeholder:text-slate-400
                {{ $errors->has('title') ? 'border-rose-500 focus:ring-2 focus:ring-rose-200' : 'border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-100' }}"
                        required>

                    @error('title')
                        <p class="mt-1.5 text-xs text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="office_id" class="block text-sm font-medium text-slate-700 mb-1.5">
                        Kantor / Cabang <span class="text-rose-500">*</span>
                    </label>
                    <select name="office_id" id="office_id"
                        class="w-full px-3.5 py-2.5 text-sm bg-white border rounded-xl outline-none transition-all
                {{ $errors->has('office_id') ? 'border-rose-500 focus:ring-2 focus:ring-rose-200' : 'border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-100' }}"
                        required>
                        <option value="" disabled {{ old('office_id') ? '' : 'selected' }}>
                            -- Pilih Kantor / Cabang --
                        </option>

                        @foreach ($offices as $office)
                            <option value="{{ $office->id }}" {{ old('office_id') == $office->id ? 'selected' : '' }}>
                                {{ $office->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('office_id')
                        <p class="mt-1.5 text-xs text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="category" class="block text-sm font-medium text-slate-700 mb-1.5">
                        Kategori Lowongan <span class="text-rose-500">*</span>
                    </label>
                    <select name="category" id="category"
                        class="w-full px-3.5 py-2.5 text-sm bg-white border rounded-xl outline-none transition-all
                {{ $errors->has('category') ? 'border-rose-500 focus:ring-2 focus:ring-rose-200' : 'border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-100' }}"
                        required>
                        <option value="" disabled {{ old('category') ? '' : 'selected' }}>
                            -- Pilih Kategori --
                        </option>

                        <option value="profesional" {{ old('category') == 'profesional' ? 'selected' : '' }}>
                            Profesional
                        </option>

                        <option value="management_trainee" {{ old('category') == 'management_trainee' ? 'selected' : '' }}>
                            Management Trainee
                        </option>

                        <option value="internship" {{ old('category') == 'internship' ? 'selected' : '' }}>
                            Internship / PKL
                        </option>

                        <option value="magang" {{ old('category') == 'magang' ? 'selected' : '' }}>
                            Magang
                        </option>
                    </select>

                    @error('category')
                        <p class="mt-1.5 text-xs text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="occupation" class="block text-sm font-medium text-slate-700 mb-1.5">
                        Bidang Pekerjaan <span class="text-rose-500">*</span>
                    </label>
                    <select name="occupation" id="occupation"
                        class="w-full px-3.5 py-2.5 text-sm bg-white border rounded-xl outline-none transition-all
                {{ $errors->has('occupation') ? 'border-rose-500 focus:ring-2 focus:ring-rose-200' : 'border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-100' }}"
                        required>
                        <option value="" disabled {{ old('occupation') ? '' : 'selected' }}>
                            -- Pilih Bidang Pekerjaan --
                        </option>

                        @foreach ($divisions as $division)
                            <option value="{{ $division->name }}"
                                {{ old('occupation') == $division->name ? 'selected' : '' }}>
                                {{ $division->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('occupation')
                        <p class="mt-1.5 text-xs text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="type" class="block text-sm font-medium text-slate-700 mb-1.5">
                        Tipe Pekerjaan <span class="text-rose-500">*</span>
                    </label>
                    <select name="type" id="type"
                        class="w-full px-3.5 py-2.5 text-sm bg-white border rounded-xl outline-none transition-all
                {{ $errors->has('type') ? 'border-rose-500 focus:ring-2 focus:ring-rose-200' : 'border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-100' }}"
                        required>
                        <option value="" disabled {{ old('type') ? '' : 'selected' }}>
                            -- Pilih Tipe Pekerjaan --
                        </option>

                        <option value="Full-Time" {{ old('type') == 'Full-Time' ? 'selected' : '' }}>
                            Full-Time
                        </option>

                        <option value="Part-Time" {{ old('type') == 'Part-Time' ? 'selected' : '' }}>
                            Part-Time
                        </option>

                        <option value="Freelance" {{ old('type') == 'Freelance' ? 'selected' : '' }}>
                            Freelance
                        </option>

                        <option value="Kontrak" {{ old('type') == 'Kontrak' ? 'selected' : '' }}>
                            Kontrak
                        </option>
                    </select>

                    @error('type')
                        <p class="mt-1.5 text-xs text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="location" class="block text-sm font-medium text-slate-700 mb-1.5">
                        Lokasi Kerja <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="location" id="location" value="{{ old('location') }}"
                        placeholder="Contoh: Jakarta Selatan"
                        class="w-full px-3.5 py-2.5 text-sm bg-white border rounded-xl outline-none transition-all placeholder:text-slate-400
                {{ $errors->has('location') ? 'border-rose-500 focus:ring-2 focus:ring-rose-200' : 'border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-100' }}"
                        required>

                    @error('location')
                        <p class="mt-1.5 text-xs text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-slate-700 mb-1.5">
                        Deskripsi Pekerjaan <span class="text-rose-500">*</span>
                    </label>
                    <textarea name="description" id="description" rows="5"
                        placeholder="Tuliskan tanggung jawab dan rincian pekerjaan..."
                        class="w-full px-3.5 py-2.5 text-sm bg-white border rounded-xl outline-none transition-all placeholder:text-slate-400 resize-y
                {{ $errors->has('description') ? 'border-rose-500 focus:ring-2 focus:ring-rose-200' : 'border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-100' }}"
                        required>{{ old('description') }}</textarea>

                    @error('description')
                        <p class="mt-1.5 text-xs text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="qualification" class="block text-sm font-medium text-slate-700 mb-1.5">
                        Kualifikasi Pelamar <span class="text-rose-500">*</span>
                    </label>
                    <textarea name="qualification" id="qualification" rows="5"
                        placeholder="Tuliskan pendidikan, pengalaman, keahlian, dan persyaratan lainnya..."
                        class="w-full px-3.5 py-2.5 text-sm bg-white border rounded-xl outline-none transition-all placeholder:text-slate-400 resize-y
                {{ $errors->has('qualification') ? 'border-rose-500 focus:ring-2 focus:ring-rose-200' : 'border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-100' }}"
                        required>{{ old('qualification') }}</textarea>

                    @error('qualification')
                        <p class="mt-1.5 text-xs text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="opening_date" class="block text-sm font-medium text-slate-700 mb-1.5">
                            Tanggal Buka <span class="text-rose-500">*</span>
                        </label>
                        <input type="date" name="opening_date" id="opening_date" value="{{ old('opening_date') }}"
                            class="w-full px-3.5 py-2.5 text-sm bg-white border rounded-xl outline-none transition-all
                    {{ $errors->has('opening_date') ? 'border-rose-500 focus:ring-2 focus:ring-rose-200' : 'border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-100' }}"
                            required>

                        @error('opening_date')
                            <p class="mt-1.5 text-xs text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="closing_date" class="block text-sm font-medium text-slate-700 mb-1.5">
                            Tanggal Tutup <span class="text-rose-500">*</span>
                        </label>
                        <input type="date" name="closing_date" id="closing_date" value="{{ old('closing_date') }}"
                            class="w-full px-3.5 py-2.5 text-sm bg-white border rounded-xl outline-none transition-all
                    {{ $errors->has('closing_date') ? 'border-rose-500 focus:ring-2 focus:ring-rose-200' : 'border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-100' }}"
                            required>

                        @error('closing_date')
                            <p class="mt-1.5 text-xs text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-slate-700 mb-1.5">
                            Status Lowongan <span class="text-rose-500">*</span>
                        </label>
                        <select name="status" id="status"
                            class="w-full px-3.5 py-2.5 text-sm bg-white border rounded-xl outline-none transition-all
                    {{ $errors->has('status') ? 'border-rose-500 focus:ring-2 focus:ring-rose-200' : 'border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-100' }}"
                            required>
                            <option value="aktif" {{ old('status', 'aktif') == 'aktif' ? 'selected' : '' }}>
                                Aktif
                            </option>
                            <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>
                                Nonaktif
                            </option>
                            <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>
                                Selesai
                            </option>
                            <option value="dihapus" {{ old('status') == 'dihapus' ? 'selected' : '' }}>
                                Dihapus
                            </option>
                        </select>

                        @error('status')
                            <p class="mt-1.5 text-xs text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <a href="{{ route('job.index') }}"
                        class="px-4 py-2.5 text-sm font-medium text-slate-600 hover:text-slate-800 hover:bg-slate-100 rounded-xl transition-colors">
                        Batal
                    </a>

                    <button type="submit"
                        class="cursor-pointer px-5 py-2.5 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 active:bg-blue-800 rounded-xl shadow-xs transition-colors">
                        Simpan Lowongan
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection
