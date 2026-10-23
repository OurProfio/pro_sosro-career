@extends('auth.admin.layouts.index')

@section('title', 'Manajemen Pengguna & Hak Akses - Sinar Sosro Gunung Slamat')

@section('content')
    @php
        $totalAdmins = $admins->count();
        $superadminCount = $admins->where('role', 'superadmin')->count();
        $adminCabangCount = $admins->where('role', 'admin')->count();

        $assignedOfficeIds = $admins->pluck('office_id')->filter()->unique();
        $totalOfficesCount = $offices->count();
        $assignedCount = $assignedOfficeIds->count();
        $unassignedCount = max(0, $totalOfficesCount - $assignedCount);
        $percentFilled = $totalOfficesCount > 0 ? round(($assignedCount / $totalOfficesCount) * 100, 1) : 0;

        $avatarPalettes = [
            ['bg' => 'bg-rose-100', 'text' => 'text-[#A6192E]'],
            ['bg' => 'bg-amber-100', 'text' => 'text-amber-800'],
            ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-700'],
            ['bg' => 'bg-sky-100', 'text' => 'text-sky-700'],
            ['bg' => 'bg-violet-100', 'text' => 'text-violet-700'],
            ['bg' => 'bg-fuchsia-100', 'text' => 'text-fuchsia-700'],
            ['bg' => 'bg-teal-100', 'text' => 'text-teal-800'],
        ];
    @endphp

    <div class="flex flex-col w-full font-sans space-y-6"
        x-data="{
            search: '',
            selectedRole: 'all',
            selectedOffice: 'all',
            openCreateModal: {{ $errors->any() && !old('_method') ? 'true' : 'false' }},
            openEditModal: {{ $errors->any() && old('_method') === 'PUT' ? 'true' : 'false' }},
            openDeleteModal: false,
            editData: {
                id: '{{ old('edit_id') }}',
                name: '{{ old('name') }}',
                email: '{{ old('email') }}',
                role: '{{ old('role', 'admin') }}',
                office_id: '{{ old('office_id') }}'
            },
            deleteData: {
                id: null,
                name: ''
            },
            openEdit(admin) {
                this.editData = {
                    id: admin.id,
                    name: admin.name,
                    email: admin.user ? admin.user.email : '',
                    role: admin.role,
                    office_id: admin.office_id || ''
                };
                this.openEditModal = true;
            },
            openDelete(admin) {
                this.deleteData = {
                    id: admin.id,
                    name: admin.name
                };
                this.openDeleteModal = true;
            },
            resetFilters() {
                this.search = '';
                this.selectedRole = 'all';
                this.selectedOffice = 'all';
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
                    <span class="text-[#9b1b1f] font-bold">Manajemen Pengguna</span>
                </nav>
                <div class="flex items-center gap-2.5">
                    <h1 class="text-xl font-bold tracking-tight text-slate-900">Manajemen Pengguna &amp; Hak Akses</h1>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        Internal Holding
                    </span>
                </div>
                <p class="text-xs text-slate-500 max-w-2xl">
                    Kelola akun Superadmin pusat dan Administrator cabang/pabrik PT Sinar Sosro &amp; Gunung Slamat serta pengawasan hak akses operasional.
                </p>
            </div>
            <div class="flex items-center gap-2 shrink-0">
                <button type="button" @click="openCreateModal = true"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#A6192E] hover:bg-[#7f1d1d] text-white text-xs font-bold shadow-sm shadow-red-950/20 hover:shadow-md transition duration-150 ease-in-out cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                    <span>Tambah Admin Baru</span>
                </button>
            </div>
        </section>

        <!-- Section 2: Bento Metric Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
            <!-- Card 1: Total Admin -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200/90 flex flex-col justify-between relative overflow-hidden group hover:shadow-md transition">
                <div class="flex items-start justify-between relative z-10">
                    <div class="w-11 h-11 rounded-xl bg-slate-100 flex items-center justify-center text-[#A6192E] shadow-2xs">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700">
                        {{ $totalAdmins }} Total
                    </span>
                </div>
                <div class="mt-4 relative z-10">
                    <div class="text-2xl font-bold text-slate-900 tracking-tight">{{ $totalAdmins }} <span class="text-xs font-normal text-slate-500">Akun</span></div>
                    <div class="text-xs font-bold text-slate-700 mt-0.5">Total Administrator</div>
                    <p class="text-[11px] text-slate-400 mt-0.5">Semua tingkatan hak akses terdaftar</p>
                </div>
            </div>

            <!-- Card 2: Superadmin -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200/90 flex flex-col justify-between relative overflow-hidden group hover:shadow-md transition">
                <div class="flex items-start justify-between relative z-10">
                    <div class="w-11 h-11 rounded-xl bg-red-50 text-[#A6192E] flex items-center justify-center shadow-2xs">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-red-50 text-[#A6192E] border border-red-100">
                        Pusat / KPB
                    </span>
                </div>
                <div class="mt-4 relative z-10">
                    <div class="text-2xl font-bold text-[#A6192E] tracking-tight">{{ $superadminCount }} <span class="text-xs font-normal text-slate-500">Personil</span></div>
                    <div class="text-xs font-bold text-slate-700 mt-0.5">Superadmin (Holding)</div>
                    <p class="text-[11px] text-slate-400 mt-0.5">Akses penuh sistem &amp; seluruh unit kerja</p>
                </div>
            </div>

            <!-- Card 3: Admin Cabang & Pabrik -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200/90 flex flex-col justify-between relative overflow-hidden group hover:shadow-md transition">
                <div class="flex items-start justify-between relative z-10">
                    <div class="w-11 h-11 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center shadow-2xs">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-800 border border-amber-200/60">
                        Unit Kerja
                    </span>
                </div>
                <div class="mt-4 relative z-10">
                    <div class="text-2xl font-bold text-slate-900 tracking-tight">{{ $adminCabangCount }} <span class="text-xs font-normal text-slate-500">Personil</span></div>
                    <div class="text-xs font-bold text-slate-700 mt-0.5">Admin Cabang &amp; Pabrik</div>
                    <p class="text-[11px] text-slate-400 mt-0.5">PIC Pabrik, KPW, &amp; Perwakilan</p>
                </div>
            </div>

            <!-- Card 4: Cakupan Unit Kerja -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200/90 flex flex-col justify-between relative overflow-hidden group hover:shadow-md transition">
                <div class="flex items-start justify-between relative z-10">
                    <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center shadow-2xs">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200/60">
                        {{ $percentFilled }}% Terisi
                    </span>
                </div>
                <div class="mt-4 relative z-10">
                    <div class="flex items-baseline justify-between">
                        <div class="text-2xl font-bold text-slate-900 tracking-tight">{{ $assignedCount }} <span class="text-xs font-normal text-slate-400">/ {{ $totalOfficesCount }} Unit</span></div>
                        @if ($unassignedCount > 0)
                            <span class="text-[10px] font-bold text-amber-700 bg-amber-50 border border-amber-200 px-2 py-0.5 rounded-md">{{ $unassignedCount }} Belum Terisi</span>
                        @else
                            <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md">Lengkap</span>
                        @endif
                    </div>
                    <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden mt-2">
                        <div class="bg-emerald-600 h-full rounded-full transition-all duration-500" style="width: {{ $percentFilled }}%"></div>
                    </div>
                    <p class="text-[11px] text-slate-400 mt-1.5 truncate">
                        {{ $unassignedCount > 0 ? 'Beberapa unit kerja belum memiliki admin khusus' : 'Seluruh unit kerja telah memiliki penugasan admin' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Section 3: Toolbar Sebaris (Search & Filters) -->
        <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-200/90 flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-3">
            <!-- Search Input -->
            <div class="relative flex-1 min-w-[260px]">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="text" x-model="search"
                    class="w-full pl-10 pr-4 py-2 bg-slate-50/80 border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:bg-white focus:border-[#A6192E] focus:ring-2 focus:ring-[#A6192E]/20 transition"
                    placeholder="Cari nama administrator, email resmi Sosro...">
            </div>

            <!-- Filters Row -->
            <div class="flex flex-wrap items-center gap-2">
                <!-- Role Filter -->
                <div class="min-w-[140px]">
                    <select x-model="selectedRole"
                        class="w-full py-2 px-3 bg-slate-50/80 border border-slate-200 rounded-xl text-xs text-slate-700 font-medium focus:bg-white focus:border-[#A6192E] focus:ring-2 focus:ring-[#A6192E]/20 transition cursor-pointer">
                        <option value="all">Semua Role</option>
                        <option value="superadmin">Superadmin</option>
                        <option value="admin">Admin Cabang</option>
                    </select>
                </div>

                <!-- Office Filter -->
                <div class="min-w-[180px]">
                    <select x-model="selectedOffice"
                        class="w-full py-2 px-3 bg-slate-50/80 border border-slate-200 rounded-xl text-xs text-slate-700 font-medium focus:bg-white focus:border-[#A6192E] focus:ring-2 focus:ring-[#A6192E]/20 transition cursor-pointer">
                        <option value="all">Semua Kantor / Unit</option>
                        @foreach ($offices as $office)
                            <option value="{{ $office->id }}">{{ $office->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Reset Button -->
                <button type="button" @click="resetFilters()"
                    class="p-2 text-slate-400 hover:text-slate-700 hover:bg-slate-100 border border-slate-200 rounded-xl transition cursor-pointer"
                    title="Reset Filter Pencarian">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Section 4: Tabel Data Admin Modern -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/90 overflow-hidden flex flex-col">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-rose-50/50 text-[11px] font-bold text-slate-500 uppercase tracking-wider border-b border-rose-100/60 select-none">
                            <th scope="col" class="py-3.5 pl-6 pr-4 min-w-[240px]">ADMIN / PENGGUNA</th>
                            <th scope="col" class="py-3.5 px-4 min-w-[150px]">ROLE &amp; HAK AKSES</th>
                            <th scope="col" class="py-3.5 px-4 min-w-[220px]">PENUGASAN KANTOR / UNIT</th>
                            <th scope="col" class="py-3.5 px-4 min-w-[110px] text-center">STATUS</th>
                            <th scope="col" class="py-3.5 px-4 min-w-[140px]">TANGGAL BERGABUNG</th>
                            <th scope="col" class="py-3.5 pr-6 pl-4 text-center min-w-[120px]">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs">
                        @forelse ($admins as $index => $admin)
                            @php
                                $palette = $avatarPalettes[$index % count($avatarPalettes)];
                                $nameWords = explode(' ', trim($admin->name));
                                $initials = strtoupper(substr($nameWords[0] ?? 'A', 0, 1) . substr($nameWords[1] ?? '', 0, 1));
                                if (strlen($initials) < 2) {
                                    $initials = strtoupper(substr($admin->name, 0, 2));
                                }
                            @endphp
                            <tr class="hover:bg-slate-50/70 transition-colors group"
                                x-show="
                                    (search === '' ||
                                     '{{ strtolower(addslashes($admin->name)) }}'.includes(search.toLowerCase()) ||
                                     '{{ strtolower(addslashes($admin->user->email ?? '')) }}'.includes(search.toLowerCase()))
                                    &&
                                    (selectedRole === 'all' || '{{ $admin->role }}' === selectedRole)
                                    &&
                                    (selectedOffice === 'all' || '{{ $admin->office_id }}' === selectedOffice)
                                ">
                                <td class="py-4 pl-6 pr-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl {{ $palette['bg'] }} {{ $palette['text'] }} font-bold flex items-center justify-center text-xs shrink-0 shadow-2xs border border-slate-100">
                                            {{ $initials }}
                                        </div>
                                        <div class="flex flex-col min-w-0">
                                            <span class="font-bold text-slate-900 group-hover:text-[#A6192E] transition-colors truncate">
                                                {{ $admin->name }}
                                            </span>
                                            <span class="text-[11px] text-slate-400 truncate">
                                                {{ $admin->user->email ?? '-' }}
                                            </span>
                                        </div>
                                    </div>
                                </td>

                                <td class="py-4 px-4 whitespace-nowrap">
                                    @if ($admin->role === 'superadmin')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-rose-50 text-[#A6192E] border border-red-100">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                            </svg>
                                            Superadmin
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                                            <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                            Admin Cabang
                                        </span>
                                    @endif
                                </td>

                                <td class="py-4 px-4">
                                    @if ($admin->role === 'superadmin')
                                        <div class="flex items-center gap-1.5 text-slate-700 font-medium">
                                            <svg class="w-4 h-4 text-[#A6192E] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span class="font-semibold text-slate-800">Semua Unit &amp; Pusat (Global)</span>
                                        </div>
                                    @else
                                        <div class="flex items-center gap-1.5 text-slate-700">
                                            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            <span>{{ $admin->office->name ?? '-' }}</span>
                                        </div>
                                    @endif
                                </td>

                                <td class="py-4 px-4 text-center whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                        Aktif
                                    </span>
                                </td>

                                <td class="py-4 px-4 text-slate-500 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($admin->created_at)->translatedFormat('d M Y') }}
                                </td>

                                <td class="py-4 pr-6 pl-4 text-center whitespace-nowrap">
                                    <div class="inline-flex items-center justify-center gap-1 bg-slate-50 p-1 rounded-lg border border-slate-200/80">
                                        <button type="button"
                                            @click="openEdit({{ $admin->toJson() }})"
                                            class="p-1.5 text-slate-500 hover:text-[#A6192E] hover:bg-white rounded-md transition cursor-pointer"
                                            title="Edit Data Admin">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 15.07a4.5 4.5 0 0 1-1.897 1.13l-2.685.805.805-2.685a4.5 4.5 0 0 1 1.13-1.897L16.862 4.487Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 7.125 16.875 4.5" />
                                            </svg>
                                        </button>

                                        <button type="button"
                                            @click="openDelete({{ $admin->toJson() }})"
                                            class="p-1.5 text-slate-500 hover:text-red-600 hover:bg-white rounded-md transition cursor-pointer"
                                            title="Hapus Akun">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                        </svg>
                                        <p class="text-xs font-medium">Belum ada data akun administrator.</p>
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
                    Menampilkan <span class="font-bold text-slate-800">{{ $admins->count() }}</span> total administrator
                </div>
            </div>
        </div>

        <!-- Section 5: Telemetry Banner (Jika ada kantor cabang belum memiliki admin) -->
        @if ($unassignedCount > 0)
            <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-200/90 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 border-l-4 border-l-amber-500">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-xs font-bold text-slate-800">{{ $unassignedCount }} Unit Kerja Memerlukan Penugasan Admin PIC</div>
                        <div class="text-[11px] text-slate-500">Terdapat kantor cabang atau pabrik yang belum memiliki administrator aktif.</div>
                    </div>
                </div>
                <button type="button" @click="openCreateModal = true"
                    class="px-3.5 py-1.5 rounded-lg bg-amber-50 text-amber-800 hover:bg-amber-100 border border-amber-200 text-xs font-semibold transition shrink-0 cursor-pointer">
                    Tugaskan Admin Sekarang
                </button>
            </div>
        @endif

        <!-- MODAL 1: Tambah Admin Baru (Alpine.js with Teleport & Backdrop Blur) -->
        <template x-teleport="body">
            <div x-show="openCreateModal"
                x-cloak
                style="display: none;"
                class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
                role="dialog"
                aria-modal="true"
                aria-labelledby="modal-create-title"
                @keydown.escape.window="openCreateModal = false">

                <div x-show="openCreateModal"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    @click.outside="openCreateModal = false"
                    class="bg-white w-full max-w-xl rounded-2xl shadow-2xl border border-slate-200 flex flex-col max-h-[92vh] overflow-hidden">

                    <!-- Modal Header -->
                    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-white shrink-0">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-red-50 border border-red-100/70 flex items-center justify-center text-[#A6192E] shadow-2xs">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-slate-900 leading-tight" id="modal-create-title">Tambah Admin Baru</h3>
                                <p class="text-[11px] text-slate-500 mt-0.5">Buat akun administrator baru untuk tim pusat atau perwakilan cabang.</p>
                            </div>
                        </div>
                        <button type="button" @click="openCreateModal = false" aria-label="Tutup Modal" class="p-1.5 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-lg transition cursor-pointer">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Form Container -->
                    <form action="{{ route('admin.store') }}" method="POST" class="flex flex-col flex-1 min-h-0 overflow-hidden">
                        @csrf
                        <div class="flex-1 overflow-y-auto px-6 py-5 space-y-4">
                            <!-- Nama Lengkap -->
                            <div class="space-y-1.5">
                                <label for="create_name" class="block text-[11px] font-semibold text-slate-700 uppercase tracking-wider">
                                    Nama Lengkap <span class="text-[#A6192E] font-bold">*</span>
                                </label>
                                <input type="text" name="name" id="create_name" value="{{ old('name') }}"
                                    class="w-full px-4 py-2 text-xs rounded-xl border {{ $errors->has('name') ? 'border-red-500 ring-1 ring-red-500' : 'border-slate-200' }} bg-slate-50/50 hover:border-slate-300 focus:bg-white focus:border-[#A6192E] focus:ring-2 focus:ring-[#A6192E]/20 text-slate-800 placeholder-slate-400 transition"
                                    placeholder="Contoh: Hendra Gunawan, S.T." required>
                                @error('name')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email Resmi -->
                            <div class="space-y-1.5">
                                <label for="create_email" class="block text-[11px] font-semibold text-slate-700 uppercase tracking-wider">
                                    Email Resmi <span class="text-[#A6192E] font-bold">*</span>
                                </label>
                                <input type="email" name="email" id="create_email" value="{{ old('email') }}"
                                    class="w-full px-4 py-2 text-xs rounded-xl border {{ $errors->has('email') ? 'border-red-500 ring-1 ring-red-500' : 'border-slate-200' }} bg-slate-50/50 hover:border-slate-300 focus:bg-white focus:border-[#A6192E] focus:ring-2 focus:ring-[#A6192E]/20 text-slate-800 placeholder-slate-400 transition"
                                    placeholder="hendra.gunawan@sosro.com" required>
                                @error('email')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="space-y-1.5">
                                <label for="create_password" class="block text-[11px] font-semibold text-slate-700 uppercase tracking-wider">
                                    Kata Sandi (Password) <span class="text-[#A6192E] font-bold">*</span>
                                </label>
                                <input type="password" name="password" id="create_password"
                                    class="w-full px-4 py-2 text-xs rounded-xl border {{ $errors->has('password') ? 'border-red-500 ring-1 ring-red-500' : 'border-slate-200' }} bg-slate-50/50 hover:border-slate-300 focus:bg-white focus:border-[#A6192E] focus:ring-2 focus:ring-[#A6192E]/20 text-slate-800 placeholder-slate-400 transition"
                                    placeholder="Minimal 8 karakter" required>
                                @error('password')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Role & Office Grid -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="space-y-1.5">
                                    <label for="create_role" class="block text-[11px] font-semibold text-slate-700 uppercase tracking-wider">
                                        Tingkat Hak Akses <span class="text-[#A6192E] font-bold">*</span>
                                    </label>
                                    <select name="role" id="create_role"
                                        class="w-full appearance-none px-4 pr-10 py-2 text-xs rounded-xl border {{ $errors->has('role') ? 'border-red-500 ring-1 ring-red-500' : 'border-slate-200' }} bg-slate-50/50 hover:border-slate-300 focus:bg-white focus:border-[#A6192E] focus:ring-2 focus:ring-[#A6192E]/20 text-slate-700 cursor-pointer transition"
                                        required>
                                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin Cabang</option>
                                        <option value="superadmin" {{ old('role') === 'superadmin' ? 'selected' : '' }}>Superadmin (Holding)</option>
                                    </select>
                                    @error('role')
                                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="space-y-1.5">
                                    <label for="create_office_id" class="block text-[11px] font-semibold text-slate-700 uppercase tracking-wider">
                                        Penugasan Kantor / Unit <span class="text-[#A6192E] font-bold">*</span>
                                    </label>
                                    <select name="office_id" id="create_office_id"
                                        class="w-full appearance-none px-4 pr-10 py-2 text-xs rounded-xl border {{ $errors->has('office_id') ? 'border-red-500 ring-1 ring-red-500' : 'border-slate-200' }} bg-slate-50/50 hover:border-slate-300 focus:bg-white focus:border-[#A6192E] focus:ring-2 focus:ring-[#A6192E]/20 text-slate-700 cursor-pointer transition"
                                        required>
                                        <option value="" disabled {{ old('office_id') ? '' : 'selected' }}>-- Pilih Unit Kerja --</option>
                                        @foreach ($offices as $office)
                                            <option value="{{ $office->id }}" {{ old('office_id') == $office->id ? 'selected' : '' }}>
                                                {{ $office->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('office_id')
                                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Modal Footer -->
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
                                Simpan Administrator
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </template>

        <!-- MODAL 2: Edit Data Admin (Alpine.js with Teleport & Backdrop Blur) -->
        <template x-teleport="body">
            <div x-show="openEditModal"
                x-cloak
                style="display: none;"
                class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
                role="dialog"
                aria-modal="true"
                aria-labelledby="modal-edit-title"
                @keydown.escape.window="openEditModal = false">

                <div x-show="openEditModal"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    @click.outside="openEditModal = false"
                    class="bg-white w-full max-w-xl rounded-2xl shadow-2xl border border-slate-200 flex flex-col max-h-[92vh] overflow-hidden">

                    <!-- Modal Header -->
                    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-white shrink-0">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-amber-50 border border-amber-100/70 flex items-center justify-center text-amber-700 shadow-2xs">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 15.07a4.5 4.5 0 0 1-1.897 1.13l-2.685.805.805-2.685a4.5 4.5 0 0 1 1.13-1.897L16.862 4.487Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 7.125 16.875 4.5" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-slate-900 leading-tight" id="modal-edit-title">Perbarui Data Administrator</h3>
                                <p class="text-[11px] text-slate-500 mt-0.5">Ubah nama, email, kantor cabang, atau perbarui kata sandi akun.</p>
                            </div>
                        </div>
                        <button type="button" @click="openEditModal = false" aria-label="Tutup Modal" class="p-1.5 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-lg transition cursor-pointer">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Form Container -->
                    <form :action="'{{ url('admin/admin') }}/' + editData.id" method="POST" class="flex flex-col flex-1 min-h-0 overflow-hidden">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="edit_id" :value="editData.id">

                        <div class="flex-1 overflow-y-auto px-6 py-5 space-y-4">
                            <!-- Nama Lengkap -->
                            <div class="space-y-1.5">
                                <label for="edit_name" class="block text-[11px] font-semibold text-slate-700 uppercase tracking-wider">
                                    Nama Lengkap <span class="text-[#A6192E] font-bold">*</span>
                                </label>
                                <input type="text" name="name" id="edit_name" x-model="editData.name"
                                    class="w-full px-4 py-2 text-xs rounded-xl border {{ $errors->has('name') ? 'border-red-500 ring-1 ring-red-500' : 'border-slate-200' }} bg-slate-50/50 hover:border-slate-300 focus:bg-white focus:border-[#A6192E] focus:ring-2 focus:ring-[#A6192E]/20 text-slate-800 placeholder-slate-400 transition"
                                    required>
                                @error('name')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email Resmi -->
                            <div class="space-y-1.5">
                                <label for="edit_email" class="block text-[11px] font-semibold text-slate-700 uppercase tracking-wider">
                                    Email Resmi <span class="text-[#A6192E] font-bold">*</span>
                                </label>
                                <input type="email" name="email" id="edit_email" x-model="editData.email"
                                    class="w-full px-4 py-2 text-xs rounded-xl border {{ $errors->has('email') ? 'border-red-500 ring-1 ring-red-500' : 'border-slate-200' }} bg-slate-50/50 hover:border-slate-300 focus:bg-white focus:border-[#A6192E] focus:ring-2 focus:ring-[#A6192E]/20 text-slate-800 placeholder-slate-400 transition"
                                    required>
                                @error('email')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password Baru (Opsional) -->
                            <div class="space-y-1.5">
                                <div class="flex items-center justify-between">
                                    <label for="edit_password" class="block text-[11px] font-semibold text-slate-700 uppercase tracking-wider">
                                        Kata Sandi Baru
                                    </label>
                                    <span class="text-[10px] text-slate-400">Kosongkan jika tidak ingin mengubah</span>
                                </div>
                                <input type="password" name="password" id="edit_password"
                                    class="w-full px-4 py-2 text-xs rounded-xl border {{ $errors->has('password') ? 'border-red-500 ring-1 ring-red-500' : 'border-slate-200' }} bg-slate-50/50 hover:border-slate-300 focus:bg-white focus:border-[#A6192E] focus:ring-2 focus:ring-[#A6192E]/20 text-slate-800 placeholder-slate-400 transition"
                                    placeholder="Masukkan kata sandi baru (minimal 8 karakter)">
                                @error('password')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Role & Office Grid -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="space-y-1.5">
                                    <label for="edit_role" class="block text-[11px] font-semibold text-slate-700 uppercase tracking-wider">
                                        Tingkat Hak Akses <span class="text-[#A6192E] font-bold">*</span>
                                    </label>
                                    <select name="role" id="edit_role" x-model="editData.role"
                                        class="w-full appearance-none px-4 pr-10 py-2 text-xs rounded-xl border {{ $errors->has('role') ? 'border-red-500 ring-1 ring-red-500' : 'border-slate-200' }} bg-slate-50/50 hover:border-slate-300 focus:bg-white focus:border-[#A6192E] focus:ring-2 focus:ring-[#A6192E]/20 text-slate-700 cursor-pointer transition"
                                        required>
                                        <option value="admin">Admin Cabang</option>
                                        <option value="superadmin">Superadmin (Holding)</option>
                                    </select>
                                    @error('role')
                                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="space-y-1.5">
                                    <label for="edit_office_id" class="block text-[11px] font-semibold text-slate-700 uppercase tracking-wider">
                                        Penugasan Kantor / Unit <span class="text-[#A6192E] font-bold">*</span>
                                    </label>
                                    <select name="office_id" id="edit_office_id" x-model="editData.office_id"
                                        class="w-full appearance-none px-4 pr-10 py-2 text-xs rounded-xl border {{ $errors->has('office_id') ? 'border-red-500 ring-1 ring-red-500' : 'border-slate-200' }} bg-slate-50/50 hover:border-slate-300 focus:bg-white focus:border-[#A6192E] focus:ring-2 focus:ring-[#A6192E]/20 text-slate-700 cursor-pointer transition"
                                        required>
                                        <option value="" disabled>-- Pilih Unit Kerja --</option>
                                        @foreach ($offices as $office)
                                            <option value="{{ $office->id }}">
                                                {{ $office->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('office_id')
                                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Modal Footer -->
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

        <!-- MODAL 3: Konfirmasi Hapus Admin (Alpine.js with Teleport & Backdrop Blur) -->
        <template x-teleport="body">
            <div x-show="openDeleteModal"
                x-cloak
                style="display: none;"
                class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
                role="dialog"
                aria-modal="true"
                aria-labelledby="delete-admin-modal-title"
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

                        <h3 class="text-base font-bold text-slate-900" id="delete-admin-modal-title">
                            Hapus Akun Administrator?
                        </h3>

                        <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                            Apakah Anda yakin ingin menghapus akun <span class="font-bold text-slate-800" x-text="deleteData.name"></span>?
                            Tindakan ini akan menghapus hak akses akun ke portal rekrutmen.
                        </p>
                    </div>

                    <form :action="'{{ url('admin/admin') }}/' + deleteData.id" method="POST" class="px-6 py-4 bg-slate-50/70 border-t border-slate-100 flex items-center justify-end gap-2.5">
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
                            Ya, Hapus Akun
                        </button>
                    </form>
                </div>
            </div>
        </template>
    </div>
@endsection
