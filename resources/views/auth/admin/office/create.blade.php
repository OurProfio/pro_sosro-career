@extends('auth.admin.layouts.index')

@section('title', 'Tambah Data Kantor Cabang Baru')

@section('content')
    <div class="max-w-2xl mx-auto space-y-6 font-sans">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-slate-800">Tambah Kantor Baru</h2>
                <p class="text-sm text-slate-500">Isi formulir berikut untuk menambahkan data kantor ke sistem.</p>
            </div>
            <a href="{{ route('office.index') }}"
                class="inline-flex items-center gap-2 px-3.5 py-2 text-sm font-medium text-slate-600 hover:text-slate-900 bg-white hover:bg-slate-100 border border-slate-200 rounded-xl transition-colors">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
                <span>Kembali</span>
            </a>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-xs">
            <form action="{{ route('office.store') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700 mb-1.5">
                        Nama Kantor <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                        placeholder="Contoh: Kantor Pusat, Cabang Bandung"
                        class="w-full px-3.5 py-2.5 text-sm bg-white border rounded-xl outline-none transition-all placeholder:text-slate-400
                    {{ $errors->has('name') ? 'border-rose-500 focus:ring-2 focus:ring-rose-200' : 'border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-100' }}"
                        required>

                    @error('name')
                        <p class="mt-1.5 text-xs text-rose-500 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0zm-9 3.75h.008v.008H12v-.008z" />
                            </svg>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                <div>
                    <label for="type" class="block text-sm font-medium text-slate-700 mb-1.5">
                        Tipe / Jenis Kantor <span class="text-rose-500">*</span>
                    </label>
                    <select name="type" id="type"
                        class="w-full px-3.5 py-2.5 text-sm bg-white border rounded-xl outline-none transition-all
    {{ $errors->has('type') ? 'border-rose-500 focus:ring-2 focus:ring-rose-200' : 'border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-100' }}"
                        required>
                        <option value="" disabled {{ old('type') ? '' : 'selected' }}>-- Pilih Tipe Kantor --</option>
                        <option value="HO" {{ old('type') == 'HO' ? 'selected' : '' }}>Head Office (HO)</option>
                        <option value="KPW" {{ old('type') == 'KPW' ? 'selected' : '' }}>Kantor Perwakilan (KPW)</option>
                        <option value="Pabrik" {{ old('type') == 'Pabrik' ? 'selected' : '' }}>Pabrik</option>
                        <option value="Lainnya" {{ old('type') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>

                    @error('type')
                        <p class="mt-1.5 text-xs text-rose-500 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0zm-9 3.75h.008v.008H12v-.008z" />
                            </svg>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <a href="{{ route('office.index') }}"
                        class="px-4 py-2.5 text-sm font-medium text-slate-600 hover:text-slate-800 hover:bg-slate-100 rounded-xl transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="hover:cursor-pointer px-5 py-2.5 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 active:bg-blue-800 rounded-xl shadow-xs transition-colors">
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
