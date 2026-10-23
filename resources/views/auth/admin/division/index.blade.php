@extends('auth.admin.layouts.index')

@section('title', 'Data Divisi & Departemen - Sinar Sosro')

@section('content')
    @php
        $totalDivisions = $divisions->count();
    @endphp

    <div class="flex flex-col w-full font-sans space-y-6"
        x-data="{
            search: '',
            openCreateModal: {{ $errors->any() && !old('_method') ? 'true' : 'false' }},
            openEditModal: {{ $errors->any() && old('_method') === 'PUT' ? 'true' : 'false' }},
            openDeleteModal: false,
            editData: {
                id: '{{ old('edit_id') }}',
                name: '{{ old('name') }}'
            },
            deleteData: {
                id: null,
                name: ''
            },
            openEdit(division) {
                this.editData = {
                    id: division.id,
                    name: division.name
                };
                this.openEditModal = true;
            },
            openDelete(division) {
                this.deleteData = {
                    id: division.id,
                    name: division.name
                };
                this.openDeleteModal = true;
            },
            resetFilters() {
                this.search = '';
            }
        }">

        <!-- Section 1: Header & Breadcrumb -->
        <section class="flex flex-col md:flex-row md:items-end justify-between gap-4 pb-4 border-b border-slate-200">
            <div class="space-y-1">
                <nav class="flex items-center gap-1.5 text-xs text-slate-400 font-medium">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-[#9b1b1f] transition">Portal Karir</a>
                    <span class="material-symbols-outlined text-xs">chevron_right</span>
                    <span class="text-slate-500">Operasional &amp; Konfigurasi</span>
                    <span class="material-symbols-outlined text-xs">chevron_right</span>
                    <span class="text-[#9b1b1f] font-bold">Data Divisi &amp; Departemen</span>
                </nav>
                <div class="flex items-center gap-2.5">
                    <h1 class="text-xl font-bold tracking-tight text-slate-900">Data Divisi &amp; Departemen</h1>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        Struktur Organisasi
                    </span>
                </div>
                <p class="text-xs text-slate-500 max-w-2xl">
                    Kelola daftar divisi dan klasifikasi departemen kerja pada sistem rekrutmen PT Sinar Sosro &amp; Gunung Slamat.
                </p>
            </div>
            <div class="flex items-center gap-2 shrink-0">
                <button type="button" @click="openCreateModal = true"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#A6192E] hover:bg-[#7f1d1d] text-white text-xs font-bold shadow-sm shadow-red-950/20 hover:shadow-md transition duration-150 ease-in-out cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                    <span>+ Tambah Divisi Baru</span>
                </button>
            </div>
        </section>

        <!-- Section 2: Bento Metric Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <!-- Card 1: Total Divisi -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200/90 flex flex-col justify-between relative overflow-hidden group hover:shadow-md transition">
                <div class="flex items-start justify-between relative z-10">
                    <div class="w-11 h-11 rounded-xl bg-slate-100 flex items-center justify-center text-[#A6192E] shadow-2xs">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700">
                        {{ $totalDivisions }} Total
                    </span>
                </div>
                <div class="mt-4 relative z-10">
                    <div class="text-2xl font-bold text-slate-900 tracking-tight">{{ $totalDivisions }} <span class="text-xs font-normal text-slate-500">Divisi</span></div>
                    <div class="text-xs font-bold text-slate-700 mt-0.5">Total Divisi Terdaftar</div>
                    <p class="text-[11px] text-slate-400 mt-0.5">Departemen operasional &amp; holding</p>
                </div>
            </div>

            <!-- Card 2: Status Akses -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200/90 flex flex-col justify-between relative overflow-hidden group hover:shadow-md transition">
                <div class="flex items-start justify-between relative z-10">
                    <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center shadow-2xs">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200/60">
                        Aktif
                    </span>
                </div>
                <div class="mt-4 relative z-10">
                    <div class="text-2xl font-bold text-slate-900 tracking-tight">{{ $totalDivisions }} <span class="text-xs font-normal text-slate-500">Aktif</span></div>
                    <div class="text-xs font-bold text-slate-700 mt-0.5">Status Terbuka (Open)</div>
                    <p class="text-[11px] text-slate-400 mt-0.5">Dapat dipilih pada pembuatan lowongan kerja</p>
                </div>
            </div>

            <!-- Card 3: Standar Rekso -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200/90 flex flex-col justify-between relative overflow-hidden group hover:shadow-md transition">
                <div class="flex items-start justify-between relative z-10">
                    <div class="w-11 h-11 rounded-xl bg-red-50 text-[#A6192E] flex items-center justify-center shadow-2xs">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-red-50 text-[#A6192E] border border-red-100">
                        Holding
                    </span>
                </div>
                <div class="mt-4 relative z-10">
                    <div class="text-2xl font-bold text-[#A6192E] tracking-tight">Sosro ATS</div>
                    <div class="text-xs font-bold text-slate-700 mt-0.5">Klasifikasi Terpusat</div>
                    <p class="text-[11px] text-slate-400 mt-0.5">Sinkron dengan modul minat kandidat pelamar</p>
                </div>
            </div>
        </div>

        <!-- Section 3: Toolbar Sebaris (Search) -->
        <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-200/90 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
            <div class="relative flex-1 min-w-[260px]">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="text" x-model="search"
                    class="w-full pl-10 pr-4 py-2 bg-slate-50/80 border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:bg-white focus:border-[#A6192E] focus:ring-2 focus:ring-[#A6192E]/20 transition"
                    placeholder="Cari nama divisi atau departemen...">
            </div>

            <button type="button" @click="resetFilters()"
                class="p-2 text-slate-400 hover:text-slate-700 hover:bg-slate-100 border border-slate-200 rounded-xl transition cursor-pointer self-end sm:self-auto"
                title="Reset Pencarian">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
            </button>
        </div>

        <!-- Section 4: Tabel Data Divisi Modern -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/90 overflow-hidden flex flex-col">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-rose-50/50 text-[11px] font-bold text-slate-500 uppercase tracking-wider border-b border-rose-100/60 select-none">
                            <th scope="col" class="py-3.5 pl-6 pr-4 min-w-[280px]">NAMA DIVISI / DEPARTEMEN</th>
                            <th scope="col" class="py-3.5 px-4 min-w-[150px]">TIPE / KLASIFIKASI</th>
                            <th scope="col" class="py-3.5 px-4 min-w-[160px]">DIBUAT PADA</th>
                            <th scope="col" class="py-3.5 pr-6 pl-4 text-center min-w-[120px]">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs">
                        @forelse ($divisions as $index => $division)
                            <tr class="hover:bg-slate-50/70 transition-colors group"
                                x-show="search === '' || '{{ strtolower(addslashes($division->name)) }}'.includes(search.toLowerCase())">
                                <td class="py-4 pl-6 pr-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center shrink-0 border border-slate-200">
                                            <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                            </svg>
                                        </div>
                                        <div class="flex flex-col min-w-0">
                                            <span class="font-bold text-slate-900 group-hover:text-[#A6192E] transition-colors truncate">
                                                {{ $division->name }}
                                            </span>
                                        </div>
                                    </div>
                                </td>

                                <td class="py-4 px-4 whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        {{ $division->type ? ucfirst($division->type) : 'Open' }}
                                    </span>
                                </td>

                                <td class="py-4 px-4 text-slate-500 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($division->created_at)->translatedFormat('d M Y') }}
                                </td>

                                <td class="py-4 pr-6 pl-4 text-center whitespace-nowrap">
                                    <div class="inline-flex items-center justify-center gap-1 bg-slate-50 p-1 rounded-lg border border-slate-200/80">
                                        <button type="button"
                                            @click="openEdit({{ $division->toJson() }})"
                                            class="p-1.5 text-slate-500 hover:text-[#A6192E] hover:bg-white rounded-md transition cursor-pointer"
                                            title="Edit Divisi">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 15.07a4.5 4.5 0 0 1-1.897 1.13l-2.685.805.805-2.685a4.5 4.5 0 0 1 1.13-1.897L16.862 4.487Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 7.125 16.875 4.5" />
                                            </svg>
                                        </button>

                                        <button type="button"
                                            @click="openDelete({{ $division->toJson() }})"
                                            class="p-1.5 text-slate-500 hover:text-red-600 hover:bg-white rounded-md transition cursor-pointer"
                                            title="Hapus Divisi">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-slate-400">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                        </svg>
                                        <p class="text-xs font-medium">Belum ada data divisi yang terdaftar.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Table Footer -->
            <div class="p-4 bg-slate-50/50 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                <div class="font-medium">
                    Menampilkan <span class="font-bold text-slate-800">{{ $divisions->count() }}</span> total divisi &amp; departemen
                </div>
            </div>
        </div>

        <!-- MODAL 1: Tambah Divisi Baru -->
        <template x-teleport="body">
            <div x-show="openCreateModal"
                x-cloak
                style="display: none;"
                class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
                role="dialog"
                aria-modal="true"
                aria-labelledby="modal-create-division-title"
                @keydown.escape.window="openCreateModal = false">

                <div x-show="openCreateModal"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    @click.outside="openCreateModal = false"
                    class="bg-white w-full max-w-lg rounded-2xl shadow-2xl border border-slate-200 flex flex-col max-h-[92vh] overflow-hidden">

                    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-white shrink-0">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-red-50 border border-red-100/70 flex items-center justify-center text-[#A6192E] shadow-2xs">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-slate-900 leading-tight" id="modal-create-division-title">Tambah Divisi Baru</h3>
                                <p class="text-[11px] text-slate-500 mt-0.5">Daftarkan divisi baru yang akan digunakan untuk penempatan lowongan kerja.</p>
                            </div>
                        </div>
                        <button type="button" @click="openCreateModal = false" aria-label="Tutup Modal" class="p-1.5 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-lg transition cursor-pointer">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </button>
                    </div>

                    <form action="{{ route('division.store') }}" method="POST" class="flex flex-col flex-1 min-h-0 overflow-hidden">
                        @csrf
                        <div class="flex-1 overflow-y-auto px-6 py-5 space-y-4">
                            <div class="space-y-1.5">
                                <label for="create_division_name" class="block text-[11px] font-semibold text-slate-700 uppercase tracking-wider">
                                    Nama Divisi / Departemen <span class="text-[#A6192E] font-bold">*</span>
                                </label>
                                <input type="text" name="name" id="create_division_name" value="{{ old('name') }}"
                                    class="w-full px-4 py-2 text-xs rounded-xl border {{ $errors->has('name') ? 'border-red-500 ring-1 ring-red-500' : 'border-slate-200' }} bg-slate-50/50 hover:border-slate-300 focus:bg-white focus:border-[#A6192E] focus:ring-2 focus:ring-[#A6192E]/20 text-slate-800 placeholder-slate-400 transition"
                                    placeholder="Contoh: Human Capital & Corporate Affairs" required>
                                @error('name')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="px-6 py-4 bg-slate-50/70 border-t border-slate-100 flex items-center justify-end gap-2.5 shrink-0">
                            <button type="button" @click="openCreateModal = false"
                                class="px-4 py-2 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-100 hover:text-slate-800 font-semibold text-xs transition duration-150 cursor-pointer">
                                Batal
                            </button>
                            <button type="submit"
                                class="inline-flex items-center gap-2 px-5 py-2 rounded-xl bg-[#A6192E] hover:bg-[#7f1d1d] text-white font-bold text-xs shadow-sm shadow-red-950/20 hover:shadow-md transition duration-150 ease-in-out cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                                Simpan Divisi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </template>

        <!-- MODAL 2: Edit Data Divisi -->
        <template x-teleport="body">
            <div x-show="openEditModal"
                x-cloak
                style="display: none;"
                class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
                role="dialog"
                aria-modal="true"
                aria-labelledby="modal-edit-division-title"
                @keydown.escape.window="openEditModal = false">

                <div x-show="openEditModal"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    @click.outside="openEditModal = false"
                    class="bg-white w-full max-w-lg rounded-2xl shadow-2xl border border-slate-200 flex flex-col max-h-[92vh] overflow-hidden">

                    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-white shrink-0">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-amber-50 border border-amber-100/70 flex items-center justify-center text-amber-700 shadow-2xs">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 15.07a4.5 4.5 0 0 1-1.897 1.13l-2.685.805.805-2.685a4.5 4.5 0 0 1 1.13-1.897L16.862 4.487Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 7.125 16.875 4.5" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-slate-900 leading-tight" id="modal-edit-division-title">Perbarui Data Divisi</h3>
                                <p class="text-[11px] text-slate-500 mt-0.5">Ubah nama divisi atau departemen.</p>
                            </div>
                        </div>
                        <button type="button" @click="openEditModal = false" aria-label="Tutup Modal" class="p-1.5 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-lg transition cursor-pointer">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </button>
                    </div>

                    <form :action="'{{ url('admin/division') }}/' + editData.id" method="POST" class="flex flex-col flex-1 min-h-0 overflow-hidden">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="edit_id" :value="editData.id">

                        <div class="flex-1 overflow-y-auto px-6 py-5 space-y-4">
                            <div class="space-y-1.5">
                                <label for="edit_division_name" class="block text-[11px] font-semibold text-slate-700 uppercase tracking-wider">
                                    Nama Divisi / Departemen <span class="text-[#A6192E] font-bold">*</span>
                                </label>
                                <input type="text" name="name" id="edit_division_name" x-model="editData.name"
                                    class="w-full px-4 py-2 text-xs rounded-xl border {{ $errors->has('name') ? 'border-red-500 ring-1 ring-red-500' : 'border-slate-200' }} bg-slate-50/50 hover:border-slate-300 focus:bg-white focus:border-[#A6192E] focus:ring-2 focus:ring-[#A6192E]/20 text-slate-800 placeholder-slate-400 transition"
                                    required>
                                @error('name')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="px-6 py-4 bg-slate-50/70 border-t border-slate-100 flex items-center justify-end gap-2.5 shrink-0">
                            <button type="button" @click="openEditModal = false"
                                class="px-4 py-2 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-100 hover:text-slate-800 font-semibold text-xs transition duration-150 cursor-pointer">
                                Batal
                            </button>
                            <button type="submit"
                                class="inline-flex items-center gap-2 px-5 py-2 rounded-xl bg-[#A6192E] hover:bg-[#7f1d1d] text-white font-bold text-xs shadow-sm shadow-red-950/20 hover:shadow-md transition duration-150 ease-in-out cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </template>

        <!-- MODAL 3: Konfirmasi Hapus Divisi -->
        <template x-teleport="body">
            <div x-show="openDeleteModal"
                x-cloak
                style="display: none;"
                class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
                role="dialog"
                aria-modal="true"
                aria-labelledby="delete-division-modal-title"
                @keydown.escape.window="openDeleteModal = false">

                <div x-show="openDeleteModal"
                    x-transition:enter="ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="ease-in duration-150"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    @click.outside="openDeleteModal = false"
                    class="bg-white w-full max-w-md rounded-2xl shadow-2xl border border-slate-200 overflow-hidden">

                    <div class="p-6 text-center">
                        <div class="w-12 h-12 rounded-2xl bg-red-50 border border-red-100 flex items-center justify-center text-[#A6192E] mx-auto mb-4 shadow-2xs">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg>
                        </div>

                        <h3 class="text-base font-bold text-slate-900" id="delete-division-modal-title">
                            Hapus Data Divisi?
                        </h3>

                        <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                            Apakah Anda yakin ingin menghapus divisi <span class="font-bold text-slate-800" x-text="deleteData.name"></span>?
                            Data yang dihapus tidak dapat dipulihkan kembali.
                        </p>
                    </div>

                    <form :action="'{{ url('admin/division') }}/' + deleteData.id" method="POST" class="px-6 py-4 bg-slate-50/70 border-t border-slate-100 flex items-center justify-end gap-2.5">
                        @csrf
                        @method('DELETE')
                        <button type="button" @click="openDeleteModal = false"
                            class="px-4 py-2 rounded-xl border border-slate-200 bg-white text-slate-600 hover:bg-slate-100 hover:text-slate-800 font-semibold text-xs transition cursor-pointer">
                            Batal
                        </button>
                        <button type="submit"
                            class="inline-flex items-center gap-1.5 px-5 py-2 rounded-xl bg-[#A6192E] hover:bg-[#7f1d1d] text-white font-bold text-xs shadow-sm transition cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg>
                            Ya, Hapus Divisi
                        </button>
                    </form>
                </div>
            </div>
        </template>
    </div>
@endsection
