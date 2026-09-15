@extends('auth.admin.layouts.index')

@section('title', 'Edit Data Divisi')

@section('content')
    <div class="bg-white border-b border-slate-300 px-3 py-1.5 flex items-center justify-between shrink-0 select-none">
        <div class="flex items-center gap-2 text-[11px]">
            <a href="{{ route('divisi.index') }}" class="text-slate-500 hover:text-blue-600 flex items-center gap-1">
                <i data-lucide="briefcase" class="w-3.5 h-3.5"></i>
                <span>Kelola Divisi</span>
            </a>
            <span class="text-slate-400">/</span>
            <span class="font-bold text-slate-800">Edit Divisi: {{ $divisi->nama }}</span>
        </div>

        <a href="{{ route('divisi.index') }}"
            class="px-2 py-0.5 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded text-[10px] font-semibold flex items-center gap-1 transition-colors hover:cursor-pointer">
            <i data-lucide="arrow-left" class="w-3 h-3"></i> Kembali ke Daftar
        </a>
    </div>

    <div class="flex-1 p-3 overflow-y-auto">
        <div class="max-w-4xl mx-auto bg-white border border-slate-300 rounded shadow-sm overflow-hidden">

            <div class="bg-slate-800 text-white px-3 py-2 border-b border-slate-700 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i data-lucide="edit-3" class="w-4 h-4 text-amber-400"></i>
                    <h1 class="font-bold text-xs tracking-wide">FORMULIR PERUBAHAN DATA DIVISI</h1>
                </div>
                <span class="text-[10px] font-mono text-slate-400">ID: {{ $divisi->id }}</span>
            </div>

            <form action="{{ route('divisi.update', $divisi->id) }}" method="POST" class="p-4 space-y-4">
                @csrf
                @method('PUT')

                <div class="space-y-3">
                    <div class="border-b border-slate-200 pb-1 flex items-center justify-between">
                        <span class="font-bold text-[11px] text-slate-700 uppercase tracking-tight font-mono">
                            1. Informasi Divisi
                        </span>
                        <span class="text-[10px] text-rose-600 font-medium">* Wajib Diisi</span>
                    </div>

                    <div class="grid grid-cols-1 gap-2 text-[11px]">
                        <div class="grid grid-cols-1 sm:grid-cols-4 items-center gap-2">
                            <label for="nama" class="font-semibold text-slate-700 sm:text-right">
                                Nama Divisi <span class="text-rose-600">*</span>
                            </label>
                            <div class="sm:col-span-3">
                                <input type="text" id="nama" name="nama" value="{{ old('nama', $divisi->nama) }}"
                                    placeholder="Contoh: Information Technology, Human Capital..."
                                    class="w-full px-2 py-1 bg-slate-50 border border-slate-300 rounded text-[11px] font-sans text-slate-900 focus:bg-white focus:outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600 @error('nama') border-rose-500 @enderror"
                                    required>
                                @error('nama')
                                    <span class="text-[10px] text-rose-600 mt-0.5 block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-200 flex items-center justify-end gap-2">
                    <a href="{{ route('divisi.index') }}"
                        class="px-3 py-1 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded text-[11px] font-semibold transition-colors hover:cursor-pointer">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-3 py-1 bg-amber-600 hover:bg-amber-700 text-white rounded text-[11px] font-semibold flex items-center gap-1 shadow-sm transition-colors hover:cursor-pointer">
                        <i data-lucide="rotate-cw" class="w-3.5 h-3.5"></i> Perbarui Data Divisi
                    </button>
                </div>

            </form>

        </div>
    </div>
@endsection
