@extends('auth.admin.layouts.index')

@section('title', 'Tambah Data Admin Baru')

@section('content')
    <div class="bg-white border-b border-slate-300 px-3 py-1.5 flex items-center justify-between shrink-0 select-none">
        <div class="flex items-center gap-2 text-[11px]">
            <a href="{{ route('admin.index') }}" class="text-slate-500 hover:text-blue-600 flex items-center gap-1">
                <i data-lucide="users" class="w-3.5 h-3.5"></i>
                <span>Kelola Admin</span>
            </a>
            <span class="text-slate-400">/</span>
            <span class="font-bold text-slate-800">Tambah Admin Baru</span>
        </div>

        <a href="{{ route('admin.index') }}"
            class="px-2 py-0.5 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded text-[10px] font-semibold flex items-center gap-1 transition-colors hover:cursor-pointer">
            <i data-lucide="arrow-left" class="w-3 h-3"></i> Kembali ke Daftar
        </a>
    </div>

    <div class="flex-1 p-3 overflow-y-auto">
        <div class="max-w-4xl mx-auto bg-white border border-slate-300 rounded shadow-sm overflow-hidden">

            <div class="bg-slate-800 text-white px-3 py-2 border-b border-slate-700 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i data-lucide="user-plus" class="w-4 h-4 text-blue-400"></i>
                    <h1 class="font-bold text-xs tracking-wide">FORMULIR REGISTRASI AKUN ADMIN BARU</h1>
                </div>
            </div>

            @if ($offices->isEmpty())
                <div class="m-4 p-3 bg-amber-50 border border-amber-300 rounded flex items-start gap-2.5 text-amber-800">
                    <i data-lucide="alert-triangle" class="w-4 h-4 text-amber-600 shrink-0 mt-0.5"></i>
                    <div class="text-[11px] space-y-1">
                        <p class="font-bold">Belum Ada Data Kantor Cabang Terdaftar!</p>
                        <p>Sistem membutuhkan setidaknya 1 kantor cabang terdaftar untuk mengaitkan akun admin. Silakan buat data
                            kantor cabang terlebih dahulu sebelum melanjutkan.</p>
                        <div class="pt-1">
                            <a href="{{ route('office.create') }}"
                                class="inline-flex items-center gap-1 px-2 py-1 bg-amber-600 hover:bg-amber-700 text-white font-semibold rounded text-[10px] transition-colors">
                                <i data-lucide="plus" class="w-3 h-3"></i> Buat Data Cabang Sekarang
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('admin.store') }}" method="POST" class="p-4 space-y-4">
                @csrf

                <div class="space-y-3">
                    <div class="border-b border-slate-200 pb-1 flex items-center justify-between">
                        <span class="font-bold text-[11px] text-slate-700 uppercase tracking-tight font-mono">
                            1. Informasi Akun & Kredensial (User)
                        </span>
                        <span class="text-[10px] text-rose-600 font-medium">* Wajib Diisi</span>
                    </div>

                    <div class="grid grid-cols-1 gap-2 text-[11px]">

                        <div class="grid grid-cols-1 sm:grid-cols-4 items-center gap-2">
                            <label for="name" class="font-semibold text-slate-700 sm:text-right">
                                Nama Lengkap <span class="text-rose-600">*</span>
                            </label>
                            <div class="sm:col-span-3">
                                <input type="text" id="name" name="name" value="{{ old('name') }}"
                                    placeholder="Masukkan nama lengkap admin..."
                                    class="w-full px-2 py-1 bg-slate-50 border border-slate-300 rounded text-[11px] font-sans text-slate-900 focus:bg-white focus:outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600 @error('name') border-rose-500 @enderror"
                                    {{ $offices->isEmpty() ? 'disabled' : '' }} required>
                                @error('name')
                                    <span class="text-[10px] text-rose-600 mt-0.5 block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-4 items-center gap-2">
                            <label for="email" class="font-semibold text-slate-700 sm:text-right">
                                Alamat Email <span class="text-rose-600">*</span>
                            </label>
                            <div class="sm:col-span-3">
                                <input type="email" id="email" name="email" value="{{ old('email') }}"
                                    placeholder="contoh: admin@perusahaan.com"
                                    class="w-full px-2 py-1 bg-slate-50 border border-slate-300 rounded text-[11px] font-mono text-slate-900 focus:bg-white focus:outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600 @error('email') border-rose-500 @enderror"
                                    {{ $offices->isEmpty() ? 'disabled' : '' }} required>
                                @error('email')
                                    <span class="text-[10px] text-rose-600 mt-0.5 block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="grid grid-cols-1 sm:grid-cols-4 items-center gap-2">
                            <label for="password" class="font-semibold text-slate-700 sm:text-right">
                                Password <span class="text-rose-600">*</span>
                            </label>
                            <div class="sm:col-span-3">
                                <input type="password" id="password" name="password" placeholder="Minimal 8 karakter..."
                                    class="w-full px-2 py-1 bg-slate-50 border border-slate-300 rounded text-[11px] font-mono text-slate-900 focus:bg-white focus:outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600 @error('password') border-rose-500 @enderror"
                                    {{ $offices->isEmpty() ? 'disabled' : '' }} required>
                                @error('password')
                                    <span class="text-[10px] text-rose-600 mt-0.5 block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                    </div>
                </div>

                <div class="space-y-3 pt-2">
                    <div class="border-b border-slate-200 pb-1 flex items-center justify-between">
                        <span class="font-bold text-[11px] text-slate-700 uppercase tracking-tight font-mono">
                            2. Penempatan Cabang & Hak Akses (Admin Profil)
                        </span>
                    </div>

                    <div class="grid grid-cols-1 gap-2 text-[11px]">

                        <div class="grid grid-cols-1 sm:grid-cols-4 items-center gap-2">
                            <label for="office_id" class="font-semibold text-slate-700 sm:text-right">
                                Penempatan Cabang <span class="text-rose-600">*</span>
                            </label>
                            <div class="sm:col-span-3">
                                <select id="office_id" name="office_id"
                                    class="w-full px-2 py-1 bg-slate-50 border border-slate-300 rounded text-[11px] font-sans text-slate-900 focus:bg-white focus:outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600 @error('office_id') border-rose-500 @enderror"
                                    {{ $offices->isEmpty() ? 'disabled' : '' }} required>
                                    <option value="" disabled {{ old('office_id') == '' ? 'selected' : '' }}>-- Pilih
                                        Lokasi Cabang --</option>
                                    @foreach ($offices as $office)
                                        <option value="{{ $office->id }}"
                                            {{ old('office_id') == $office->id ? 'selected' : '' }}>
                                            {{ $office->name }} ({{ $office->type }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('office_id')
                                    <span class="text-[10px] text-rose-600 mt-0.5 block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-4 items-center gap-2">
                            <label for="role" class="font-semibold text-slate-700 sm:text-right">
                                Hak Akses (Role) <span class="text-rose-600">*</span>
                            </label>
                            <div class="sm:col-span-3">
                                <select id="role" name="role"
                                    class="w-full px-2 py-1 bg-slate-50 border border-slate-300 rounded text-[11px] font-sans text-slate-900 focus:bg-white focus:outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600 @error('role') border-rose-500 @enderror"
                                    {{ $offices->isEmpty() ? 'disabled' : '' }} required>
                                    <option value="" disabled {{ old('role') == '' ? 'selected' : '' }}>-- Pilih
                                        Level Role --</option>
                                    <option value="admin" {{ old('role', 'admin') == 'admin' ? 'selected' : '' }}>
                                        Admin (Akses Standar Cabang)
                                    </option>
                                    <option value="superadmin" {{ old('role') == 'superadmin' ? 'selected' : '' }}>
                                        Superadmin (Akses Penuh Sistem)
                                    </option>
                                </select>
                                @error('role')
                                    <span class="text-[10px] text-rose-600 mt-0.5 block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                    </div>
                </div>

                <div class="pt-3 border-t border-slate-200 flex items-center justify-end gap-2">
                    <a href="{{ route('admin.index') }}"
                        class="px-3 py-1 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded text-[11px] font-semibold transition-colors hover:cursor-pointer">
                        Batal
                    </a>
                    <button type="reset"
                        class="px-3 py-1 bg-slate-100 hover:bg-slate-200 text-slate-600 border border-slate-300 rounded text-[11px] font-semibold transition-colors hover:cursor-pointer"
                        {{ $offices->isEmpty() ? 'disabled' : '' }}>
                        Reset Form
                    </button>
                    <button type="submit"
                        class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded text-[11px] font-semibold flex items-center gap-1 shadow-sm transition-colors hover:cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed"
                        {{ $offices->isEmpty() ? 'disabled' : '' }}>
                        <i data-lucide="save" class="w-3.5 h-3.5"></i> Simpan Akun Admin
                    </button>
                </div>

            </form>

        </div>
    </div>
@endsection
