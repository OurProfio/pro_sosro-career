@extends('auth.admin.layouts.index')

@section('title', 'Manajemen Akun Pengguna - Sinar Sosro')

@section('content')
    @php
        $totalUsers = $users->count();
        $adminCount = $users->where('role', 'admin')->count();
        $applicantCount = $users->where('role', '!=', 'admin')->count();
        $verifiedCount = $users->whereNotNull('email_verified_at')->count();
        $percentVerified = $totalUsers > 0 ? round(($verifiedCount / $totalUsers) * 100, 1) : 0;

        $avatarPalettes = [
            ['bg' => 'bg-rose-100', 'text' => 'text-[#A6192E]'],
            ['bg' => 'bg-amber-100', 'text' => 'text-amber-800'],
            ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-700'],
            ['bg' => 'bg-sky-100', 'text' => 'text-sky-700'],
            ['bg' => 'bg-violet-100', 'text' => 'text-violet-700'],
            ['bg' => 'bg-teal-100', 'text' => 'text-teal-800'],
        ];
    @endphp

    <div class="flex flex-col w-full font-sans space-y-6"
        x-data="{
            search: '',
            selectedRole: 'all',
            openCreateModal: {{ $errors->any() && !old('_method') ? 'true' : 'false' }},
            openEditModal: {{ $errors->any() && old('_method') === 'PUT' ? 'true' : 'false' }},
            openDeleteModal: false,
            editData: {
                id: '{{ old('edit_id') }}',
                email: '{{ old('email') }}'
            },
            deleteData: {
                id: null,
                email: '',
                role: ''
            },
            openEdit(user) {
                this.editData = {
                    id: user.id,
                    email: user.email
                };
                this.openEditModal = true;
            },
            openDelete(user) {
                this.deleteData = {
                    id: user.id,
                    email: user.email,
                    role: user.role
                };
                this.openDeleteModal = true;
            },
            resetFilters() {
                this.search = '';
                this.selectedRole = 'all';
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
                    <span class="text-[#9b1b1f] font-bold">Akun Pengguna Sistem</span>
                </nav>
                <div class="flex items-center gap-2.5">
                    <h1 class="text-xl font-bold tracking-tight text-slate-900">Manajemen Akun Pengguna (Users)</h1>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        Kredensial &amp; Akses
                    </span>
                </div>
                <p class="text-xs text-slate-500 max-w-2xl">
                    Kelola data kredensial akun pengguna sistem, hak akses login Administrator maupun akun Pelamar (Applicant).
                </p>
            </div>
            <div class="flex items-center gap-2 shrink-0">
                <button type="button" @click="openCreateModal = true"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#A6192E] hover:bg-[#7f1d1d] text-white text-xs font-bold shadow-sm shadow-red-950/20 hover:shadow-md transition duration-150 ease-in-out cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                    <span>+ Tambah Akun User</span>
                </button>
            </div>
        </section>

        <!-- Section 2: Bento Metric Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
            <!-- Card 1: Total Pengguna -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200/90 flex flex-col justify-between relative overflow-hidden group hover:shadow-md transition">
                <div class="flex items-start justify-between relative z-10">
                    <div class="w-11 h-11 rounded-xl bg-slate-100 flex items-center justify-center text-[#A6192E] shadow-2xs">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                        </svg>
                    </div>
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700">
                        {{ $totalUsers }} Total
                    </span>
                </div>
                <div class="mt-4 relative z-10">
                    <div class="text-2xl font-bold text-slate-900 tracking-tight">{{ $totalUsers }} <span class="text-xs font-normal text-slate-500">Akun</span></div>
                    <div class="text-xs font-bold text-slate-700 mt-0.5">Total Pengguna Terdaftar</div>
                    <p class="text-[11px] text-slate-400 mt-0.5">Seluruh akun sistem aktif</p>
                </div>
            </div>

            <!-- Card 2: Akun Administrator -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200/90 flex flex-col justify-between relative overflow-hidden group hover:shadow-md transition">
                <div class="flex items-start justify-between relative z-10">
                    <div class="w-11 h-11 rounded-xl bg-rose-50 border border-rose-100/70 flex items-center justify-center text-[#A6192E] shadow-2xs">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                        </svg>
                    </div>
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-[#A6192E]">
                        {{ $adminCount }} Akun
                    </span>
                </div>
                <div class="mt-4 relative z-10">
                    <div class="text-2xl font-bold text-slate-900 tracking-tight">{{ $adminCount }} <span class="text-xs font-normal text-slate-500">Admin</span></div>
                    <div class="text-xs font-bold text-slate-700 mt-0.5">Akun Administrator</div>
                    <p class="text-[11px] text-slate-400 mt-0.5">Akses panel dashboard &amp; manajemen</p>
                </div>
            </div>

            <!-- Card 3: Akun Pelamar (Applicant) -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200/90 flex flex-col justify-between relative overflow-hidden group hover:shadow-md transition">
                <div class="flex items-start justify-between relative z-10">
                    <div class="w-11 h-11 rounded-xl bg-emerald-50 border border-emerald-100/70 flex items-center justify-center text-emerald-700 shadow-2xs">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                    </div>
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700">
                        {{ $applicantCount }} Pelamar
                    </span>
                </div>
                <div class="mt-4 relative z-10">
                    <div class="text-2xl font-bold text-slate-900 tracking-tight">{{ $applicantCount }} <span class="text-xs font-normal text-slate-500">Kandidat</span></div>
                    <div class="text-xs font-bold text-slate-700 mt-0.5">Akun Pelamar Karir</div>
                    <p class="text-[11px] text-slate-400 mt-0.5">Kandidat pelamar kerja eksternal</p>
                </div>
            </div>

            <!-- Card 4: Email Terverifikasi -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200/90 flex flex-col justify-between relative overflow-hidden group hover:shadow-md transition">
                <div class="flex items-start justify-between relative z-10">
                    <div class="w-11 h-11 rounded-xl bg-sky-50 border border-sky-100/70 flex items-center justify-center text-sky-700 shadow-2xs">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                        </svg>
                    </div>
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-sky-50 text-sky-700">
                        {{ $percentVerified }}% Verified
                    </span>
                </div>
                <div class="mt-4 relative z-10">
                    <div class="text-2xl font-bold text-slate-900 tracking-tight">{{ $verifiedCount }} <span class="text-xs font-normal text-slate-500">Terverifikasi</span></div>
                    <div class="text-xs font-bold text-slate-700 mt-0.5">Email Terverifikasi</div>
                    <p class="text-[11px] text-slate-400 mt-0.5">Memiliki status otentikasi email aktif</p>
                </div>
            </div>
        </div>

        <!-- Section 3: Toolbar Sebaris (Search & Filter) -->
        <div class="bg-white rounded-2xl p-3.5 shadow-sm border border-slate-200/90 flex flex-col md:flex-row md:items-center justify-between gap-3">
            <div class="flex-1 flex flex-col sm:flex-row sm:items-center gap-2.5">
                <!-- Search Input -->
                <div class="relative flex-1 max-w-md">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                    </span>
                    <input type="text" x-model="search" placeholder="Cari email atau nama pengguna..."
                        class="w-full pl-9 pr-8 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50/50 hover:border-slate-300 focus:bg-white focus:border-[#A6192E] focus:ring-2 focus:ring-[#A6192E]/20 text-slate-800 placeholder-slate-400 transition" />
                    <button type="button" x-show="search.length > 0" @click="search = ''"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 cursor-pointer">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Role Filter -->
                <div class="relative min-w-[200px]">
                    <select x-model="selectedRole"
                        class="w-full appearance-none pl-3.5 pr-8 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50/50 hover:border-slate-300 focus:bg-white focus:border-[#A6192E] focus:ring-2 focus:ring-[#A6192E]/20 text-slate-700 cursor-pointer transition">
                        <option value="all">Semua Role Pengguna</option>
                        <option value="admin">Administrator (Admin)</option>
                        <option value="user">Pelamar / Kandidat (User)</option>
                    </select>
                    <span class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </span>
                </div>

                <!-- Reset Button -->
                <button type="button" x-show="search !== '' || selectedRole !== 'all'" @click="resetFilters()"
                    class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-[#A6192E] hover:bg-slate-100 transition cursor-pointer shrink-0">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                    <span>Reset Filter</span>
                </button>
            </div>

            <div class="text-xs text-slate-400 font-medium pl-1 shrink-0">
                Menampilkan <span class="font-bold text-slate-700">{{ $totalUsers }}</span> akun pengguna
            </div>
        </div>

        <!-- Section 4: Modern Table -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/90 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-xs text-left text-slate-700 border-collapse">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-200 text-slate-500 font-semibold uppercase tracking-wider text-[11px]">
                            <th scope="col" class="px-6 py-3.5">Akun Pengguna / Email</th>
                            <th scope="col" class="px-5 py-3.5">Role &amp; Hak Akses</th>
                            <th scope="col" class="px-5 py-3.5">Profil Terkait</th>
                            <th scope="col" class="px-5 py-3.5">Tanggal Bergabung</th>
                            <th scope="col" class="px-5 py-3.5 text-center w-28">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($users as $index => $user)
                            @php
                                $role = $user->role;
                                $profileName = $user->admin?->name ?? $user->applicant?->name ?? 'Pengguna Sistem';
                                $palette = $avatarPalettes[$index % count($avatarPalettes)];
                                $initials = strtoupper(substr($profileName ?: $user->email, 0, 2));
                                $searchableText = strtolower(addslashes($user->email . ' ' . $profileName . ' ' . ($user->admin?->office?->name ?? '')));
                            @endphp
                            <tr class="hover:bg-slate-50/80 transition"
                                x-show="(selectedRole === 'all' || selectedRole === '{{ $role }}') &&
                                        ('{{ $searchableText }}'.includes(search.toLowerCase().trim()))">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl {{ $palette['bg'] }} {{ $palette['text'] }} font-bold text-xs flex items-center justify-center shrink-0 shadow-2xs">
                                            {{ $initials }}
                                        </div>
                                        <div class="min-w-0">
                                            <div class="flex items-center gap-1.5">
                                                <span class="font-bold text-slate-900 truncate">{{ $user->email }}</span>
                                                @if ($user->email_verified_at)
                                                    <span title="Email Terverifikasi" class="text-sky-500 inline-flex items-center">
                                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                                        </svg>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="text-[11px] text-slate-500 truncate mt-0.5">
                                                {{ $profileName }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-4">
                                    @if ($role === 'admin')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-rose-50 text-[#A6192E] border border-rose-200/70">
                                            <span class="w-1.5 h-1.5 rounded-full bg-[#A6192E]"></span>
                                            Administrator
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/70">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Pelamar
                                        </span>
                                    @endif
                                </td>
                                <td class="px-5 py-4">
                                    @if ($role === 'admin')
                                        <div class="flex items-center gap-1.5 text-slate-700">
                                            <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                            <span class="font-medium truncate max-w-xs">{{ $user->admin?->office?->name ?? 'Admin Holding / Pusat' }}</span>
                                        </div>
                                    @else
                                        <div class="flex items-center gap-1.5 text-slate-600">
                                            <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z" />
                                            </svg>
                                            <span class="truncate">{{ $user->applicant ? 'Biodata Pelamar' : 'Belum isi biodata' }}</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-5 py-4 text-slate-500 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($user->created_at)->translatedFormat('d M Y, H:i') }}
                                </td>
                                <td class="px-5 py-4 text-center">
                                    <div class="inline-flex items-center justify-center gap-1 bg-slate-50 p-1 rounded-lg border border-slate-200/80">
                                        <button type="button"
                                            @click="openEdit({{ json_encode(['id' => $user->id, 'email' => $user->email, 'role' => $user->role]) }})"
                                            class="p-1.5 text-slate-500 hover:text-[#A6192E] hover:bg-white rounded-md transition cursor-pointer"
                                            title="Edit Kredensial Pengguna">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 15.07a4.5 4.5 0 0 1-1.897 1.13l-2.685.805.805-2.685a4.5 4.5 0 0 1 1.13-1.897L16.862 4.487Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 7.125 16.875 4.5" />
                                            </svg>
                                        </button>
                                        <button type="button"
                                            @click="openDelete({{ json_encode(['id' => $user->id, 'email' => $user->email, 'role' => $user->role]) }})"
                                            class="p-1.5 text-slate-500 hover:text-red-600 hover:bg-white rounded-md transition cursor-pointer"
                                            title="Hapus Akun Pengguna">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                        </svg>
                                        <p class="text-xs font-semibold text-slate-500">Belum ada akun pengguna terdaftar.</p>
                                        <p class="text-[11px] text-slate-400">Klik tombol "Tambah Akun User" untuk mendaftarkan akun baru.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- MODAL 1: Tambah Pengguna Baru -->
        <template x-teleport="body">
            <div x-show="openCreateModal"
                x-cloak
                style="display: none;"
                class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
                role="dialog"
                aria-modal="true"
                aria-labelledby="modal-create-user-title"
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
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-slate-900 leading-tight" id="modal-create-user-title">Tambah Akun Pengguna</h3>
                                <p class="text-[11px] text-slate-500 mt-0.5">Daftarkan kredensial email dan kata sandi pengguna baru.</p>
                            </div>
                        </div>
                        <button type="button" @click="openCreateModal = false" aria-label="Tutup Modal" class="p-1.5 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-lg transition cursor-pointer">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </button>
                    </div>

                    <form action="{{ route('user.store') }}" method="POST" class="flex flex-col flex-1 min-h-0 overflow-hidden">
                        @csrf

                        <div class="flex-1 overflow-y-auto px-6 py-5 space-y-4">
                            <div class="space-y-1.5">
                                <label for="create_user_email" class="block text-[11px] font-semibold text-slate-700 uppercase tracking-wider">
                                    Alamat Email <span class="text-[#A6192E] font-bold">*</span>
                                </label>
                                <input type="email" name="email" id="create_user_email" value="{{ old('email') }}"
                                    placeholder="Contoh: user@perusahaan.com"
                                    class="w-full px-4 py-2 text-xs rounded-xl border {{ $errors->has('email') ? 'border-red-500 ring-1 ring-red-500' : 'border-slate-200' }} bg-slate-50/50 hover:border-slate-300 focus:bg-white focus:border-[#A6192E] focus:ring-2 focus:ring-[#A6192E]/20 text-slate-800 placeholder-slate-400 transition"
                                    required>
                                @error('email')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-1.5">
                                <label for="create_user_password" class="block text-[11px] font-semibold text-slate-700 uppercase tracking-wider">
                                    Kata Sandi <span class="text-[#A6192E] font-bold">*</span>
                                </label>
                                <input type="password" name="password" id="create_user_password"
                                    placeholder="Minimal 8 karakter kombinasi aman"
                                    class="w-full px-4 py-2 text-xs rounded-xl border {{ $errors->has('password') ? 'border-red-500 ring-1 ring-red-500' : 'border-slate-200' }} bg-slate-50/50 hover:border-slate-300 focus:bg-white focus:border-[#A6192E] focus:ring-2 focus:ring-[#A6192E]/20 text-slate-800 placeholder-slate-400 transition"
                                    required>
                                @error('password')
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
                                Simpan Akun
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </template>

        <!-- MODAL 2: Perbarui Akun Pengguna -->
        <template x-teleport="body">
            <div x-show="openEditModal"
                x-cloak
                style="display: none;"
                class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
                role="dialog"
                aria-modal="true"
                aria-labelledby="modal-edit-user-title"
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
                                <h3 class="text-base font-bold text-slate-900 leading-tight" id="modal-edit-user-title">Perbarui Akun Pengguna</h3>
                                <p class="text-[11px] text-slate-500 mt-0.5">Ubah alamat email atau atur ulang kata sandi pengguna.</p>
                            </div>
                        </div>
                        <button type="button" @click="openEditModal = false" aria-label="Tutup Modal" class="p-1.5 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-lg transition cursor-pointer">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </button>
                    </div>

                    <form :action="'{{ url('admin/user') }}/' + editData.id" method="POST" class="flex flex-col flex-1 min-h-0 overflow-hidden">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="edit_id" :value="editData.id">

                        <div class="flex-1 overflow-y-auto px-6 py-5 space-y-4">
                            <div class="space-y-1.5">
                                <label for="edit_user_email" class="block text-[11px] font-semibold text-slate-700 uppercase tracking-wider">
                                    Alamat Email <span class="text-[#A6192E] font-bold">*</span>
                                </label>
                                <input type="email" name="email" id="edit_user_email" x-model="editData.email"
                                    class="w-full px-4 py-2 text-xs rounded-xl border {{ $errors->has('email') ? 'border-red-500 ring-1 ring-red-500' : 'border-slate-200' }} bg-slate-50/50 hover:border-slate-300 focus:bg-white focus:border-[#A6192E] focus:ring-2 focus:ring-[#A6192E]/20 text-slate-800 placeholder-slate-400 transition"
                                    required>
                                @error('email')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-1.5">
                                <label for="edit_user_password" class="block text-[11px] font-semibold text-slate-700 uppercase tracking-wider">
                                    Kata Sandi Baru <span class="text-slate-400 font-normal lowercase">(opsional)</span>
                                </label>
                                <input type="password" name="password" id="edit_user_password"
                                    placeholder="Kosongkan jika tidak ingin mengubah kata sandi"
                                    class="w-full px-4 py-2 text-xs rounded-xl border {{ $errors->has('password') ? 'border-red-500 ring-1 ring-red-500' : 'border-slate-200' }} bg-slate-50/50 hover:border-slate-300 focus:bg-white focus:border-[#A6192E] focus:ring-2 focus:ring-[#A6192E]/20 text-slate-800 placeholder-slate-400 transition">
                                <p class="text-[11px] text-slate-400 mt-1 italic">Isi kolom kata sandi hanya jika ingin mengganti password akun ini.</p>
                                @error('password')
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

        <!-- MODAL 3: Konfirmasi Hapus Akun -->
        <template x-teleport="body">
            <div x-show="openDeleteModal"
                x-cloak
                style="display: none;"
                class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
                role="dialog"
                aria-modal="true"
                aria-labelledby="delete-user-modal-title"
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

                        <h3 class="text-base font-bold text-slate-900" id="delete-user-modal-title">
                            Hapus Akun Pengguna?
                        </h3>

                        <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                            Apakah Anda yakin ingin menghapus akun <span class="font-bold text-slate-800" x-text="deleteData.email"></span>?
                            Seluruh data profil atau akses terkait akun ini tidak dapat dipulihkan kembali.
                        </p>
                    </div>

                    <form :action="'{{ url('admin/user') }}/' + deleteData.id" method="POST" class="px-6 py-4 bg-slate-50/70 border-t border-slate-100 flex items-center justify-end gap-2.5">
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
