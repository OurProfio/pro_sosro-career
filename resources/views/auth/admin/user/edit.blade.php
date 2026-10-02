@extends('auth.admin.layouts.index')

@section('title', 'Edit Akun User')

@section('content')
    <div class="max-w-2xl mx-auto space-y-6 font-sans">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-slate-800">Edit Akun User</h2>
                <p class="text-sm text-slate-500">Perbarui data akun user pada sistem.</p>
            </div>
            <a href="{{ route('user.index') }}"
                class="inline-flex items-center gap-2 px-3.5 py-2 text-sm font-medium text-slate-600 hover:text-slate-900 bg-white hover:bg-slate-100 border border-slate-200 rounded-xl transition-colors">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
                <span>Kembali</span>
            </a>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-xs">
            <form action="{{ route('user.update', $user->id) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 mb-1.5">
                        Alamat Email <span class="text-rose-500">*</span>
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                        placeholder="Contoh: user@perusahaan.com"
                        class="w-full px-3.5 py-2.5 text-sm bg-white border rounded-xl outline-none transition-all placeholder:text-slate-400
                {{ $errors->has('email') ? 'border-rose-500 focus:ring-2 focus:ring-rose-200' : 'border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-100' }}"
                        required>

                    @error('email')
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
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-1.5">
                        Password Baru
                    </label>
                    <input type="password" name="password" id="password"
                        placeholder="Kosongkan jika tidak ingin mengubah password"
                        class="w-full px-3.5 py-2.5 text-sm bg-white border rounded-xl outline-none transition-all placeholder:text-slate-400
                {{ $errors->has('password') ? 'border-rose-500 focus:ring-2 focus:ring-rose-200' : 'border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-100' }}">
                    <p class="mt-1.5 text-xs text-slate-400 italic">Isi hanya jika ingin mengganti password user.</p>

                    @error('password')
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
                    <a href="{{ route('user.index') }}"
                        class="px-4 py-2.5 text-sm font-medium text-slate-600 hover:text-slate-800 hover:bg-slate-100 rounded-xl transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="hover:cursor-pointer px-5 py-2.5 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 active:bg-blue-800 rounded-xl shadow-xs transition-colors">
                        Perbarui Data
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
