@extends('auth.admin.layouts.index')

@section('title', 'Tambah Divisi Baru')

@section('content')
    <div class="max-w-2xl mx-auto space-y-4 font-sans">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="text-lg font-bold text-slate-800">Tambah Divisi Baru</h2>
                <p class="text-xs text-slate-500">Buat divisi atau departemen baru dalam sistem.</p>
            </div>
            <a href="{{ route('division.index') }}"
                class="inline-flex items-center gap-2 px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition-colors">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
                <span>Kembali</span>
            </a>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-6">
            <form action="{{ route('division.store') }}" method="POST" class="space-y-4">
                @csrf

                <div class="space-y-1.5">
                    <label for="name" class="block text-xs font-semibold text-slate-700">
                        Nama Divisi <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                        placeholder="Masukkan nama divisi"
                        class="w-full px-3.5 py-2 text-xs bg-slate-50/50 border rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 transition-all {{ $errors->has('name') ? 'border-rose-400 focus:border-rose-500' : 'border-slate-200 focus:border-blue-500' }}">
                    @error('name')
                        <p class="text-[11px] text-rose-500 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end gap-2 pt-4 border-t border-slate-100">
                    <a href="{{ route('division.index') }}"
                        class="px-4 py-2 text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-4 py-2 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 active:bg-blue-800 rounded-xl transition-colors shadow-xs">
                        Simpan Divisi
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
