@extends('auth.admin.layouts.index')

@section('title', 'Pesan Masuk & Laporan - Sinar Sosro Gunung Slamat')

@section('content')
    @php
        $totalMessages = $messages->count();
        $pendingCount = $messages->where('status', '!=', 'resolved')->count();
        $resolvedCount = $messages->where('status', 'resolved')->count();
        $uniqueRegions = $messages->pluck('region')->filter()->unique()->values();
    @endphp

    <div class="flex flex-col w-full font-sans space-y-6"
        x-data="{
            search: '',
            selectedStatus: 'all',
            selectedRegion: 'all',
            selectedDispatch: 'all',
            openDetailModal: false,
            openDeleteModal: false,
            detailData: {
                id: null,
                name: '',
                email: '',
                region: '',
                message: '',
                reply_message: '',
                status: 'unread',
                assigned_office_id: '',
                assigned_office_name: 'Pusat (Superadmin)',
                assigned_at_formatted: '-',
                ip_address: '-',
                created_at_formatted: '',
                resolved_at_formatted: '-',
                is_registered: false,
                account_email: '',
                account_label: 'Tamu Publik'
            },
            deleteData: {
                id: null,
                name: '',
                email: ''
            },
            openDetail(item) {
                this.detailData = { ...item };
                this.openDetailModal = true;
            },
            openDelete(item) {
                this.deleteData = { ...item };
                this.openDeleteModal = true;
            },
            resetFilters() {
                this.search = '';
                this.selectedStatus = 'all';
                this.selectedRegion = 'all';
                this.selectedDispatch = 'all';
            }
        }">

        <section class="flex flex-col md:flex-row md:items-end justify-between gap-4 pb-4 border-b border-slate-200">
            <div class="space-y-1">
                <nav class="flex items-center gap-1.5 text-xs text-slate-400 font-medium">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-[#9b1b1f] transition">Portal Karir</a>
                    <span class="material-symbols-outlined text-xs">chevron_right</span>
                    <span class="text-[#9b1b1f] font-bold">Pesan Masuk &amp; Laporan</span>
                </nav>
                <div class="flex items-center gap-2.5">
                    <h1 class="text-xl font-bold tracking-tight text-slate-900">Pesan Masuk &amp; Laporan</h1>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-50 text-[#A6192E] border border-red-200/60">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#A6192E] {{ $pendingCount > 0 ? 'animate-pulse' : '' }}"></span>
                        {{ $pendingCount > 0 ? $pendingCount . ' Belum Ditangani' : 'Semua Sudah Ditangani' }}
                    </span>
                </div>
                <p class="text-xs text-slate-500 max-w-2xl">
                    @if ($isSuperAdmin)
                        Tinjau pesan masuk dari halaman Kontak, tangani langsung atau kirimkan ke Admin Cabang terkait.
                    @else
                        Daftar pesan masuk yang diarahkan oleh Superadmin untuk ditindaklanjuti oleh kantor cabang Anda.
                    @endif
                </p>
            </div>
        </section>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200/90 flex flex-col justify-between relative overflow-hidden group hover:shadow-md transition">
                <div class="flex items-start justify-between relative z-10">
                    <div class="w-11 h-11 rounded-xl bg-slate-100 flex items-center justify-center text-[#A6192E] shadow-2xs">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700">
                        {{ $totalMessages }} Total
                    </span>
                </div>
                <div class="mt-4 relative z-10">
                    <div class="text-2xl font-bold text-slate-900 tracking-tight">{{ $totalMessages }} <span class="text-xs font-normal text-slate-500">Pesan</span></div>
                    <div class="text-xs font-bold text-slate-700 mt-0.5">Total Pesan Masuk</div>
                    <p class="text-[11px] text-slate-400 mt-0.5">Akumulasi pesan pada cakupan Anda</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200/90 flex flex-col justify-between relative overflow-hidden group hover:shadow-md transition">
                <div class="flex items-start justify-between relative z-10">
                    <div class="w-11 h-11 rounded-xl bg-rose-50 text-[#A6192E] flex items-center justify-center shadow-2xs">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-[#A6192E] border border-red-100">
                        Menunggu Aksi
                    </span>
                </div>
                <div class="mt-4 relative z-10">
                    <div class="text-2xl font-bold text-[#A6192E] tracking-tight">{{ $pendingCount }} <span class="text-xs font-normal text-slate-500">Pesan</span></div>
                    <div class="text-xs font-bold text-slate-700 mt-0.5">Belum Ditangani</div>
                    <p class="text-[11px] text-slate-400 mt-0.5">Pesan baru menunggu tindak lanjut</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200/90 flex flex-col justify-between relative overflow-hidden group hover:shadow-md transition">
                <div class="flex items-start justify-between relative z-10">
                    <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center shadow-2xs">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200/60">
                        Tuntas
                    </span>
                </div>
                <div class="mt-4 relative z-10">
                    <div class="text-2xl font-bold text-slate-900 tracking-tight">{{ $resolvedCount }} <span class="text-xs font-normal text-slate-500">Pesan</span></div>
                    <div class="text-xs font-bold text-slate-700 mt-0.5">Sudah Ditangani</div>
                    <p class="text-[11px] text-slate-400 mt-0.5">Laporan telah ditangani &amp; selesai</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-200/90 flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-3">
            <div class="relative flex-1 min-w-[240px]">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="text" x-model="search"
                    class="w-full pl-10 pr-4 py-2 bg-slate-50/80 border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:bg-white focus:border-[#A6192E] focus:ring-2 focus:ring-[#A6192E]/20 transition"
                    placeholder="Cari nama pengirim, email, wilayah, atau isi pesan...">
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <div class="min-w-[150px]">
                    <select x-model="selectedStatus"
                        class="w-full py-2 px-3 bg-slate-50/80 border border-slate-200 rounded-xl text-xs text-slate-700 font-medium focus:bg-white focus:border-[#A6192E] focus:ring-2 focus:ring-[#A6192E]/20 transition cursor-pointer">
                        <option value="all">Semua Status</option>
                        <option value="pending">Belum Ditangani</option>
                        <option value="resolved">Sudah Ditangani</option>
                    </select>
                </div>

                @if ($isSuperAdmin)
                    <div class="min-w-[190px]">
                        <select x-model="selectedDispatch"
                            class="w-full py-2 px-3 bg-slate-50/80 border border-slate-200 rounded-xl text-xs text-slate-700 font-medium focus:bg-white focus:border-[#A6192E] focus:ring-2 focus:ring-[#A6192E]/20 transition cursor-pointer">
                            <option value="all">Semua Penanganan</option>
                            <option value="unassigned">Pusat (Superadmin)</option>
                            @foreach ($groupedOffices as $groupLabel => $offices)
                                <optgroup label="{{ $groupLabel }}">
                                    @foreach ($offices as $office)
                                        <option value="{{ $office->id }}">{{ $office->name }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>
                @endif

                <div class="min-w-[170px]">
                    <select x-model="selectedRegion"
                        class="w-full py-2 px-3 bg-slate-50/80 border border-slate-200 rounded-xl text-xs text-slate-700 font-medium focus:bg-white focus:border-[#A6192E] focus:ring-2 focus:ring-[#A6192E]/20 transition cursor-pointer">
                        <option value="all">Semua Wilayah Tujuan</option>
                        @foreach ($uniqueRegions as $region)
                            <option value="{{ $region }}">{{ $region }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="button" @click="resetFilters()"
                    class="p-2 text-slate-400 hover:text-slate-700 hover:bg-slate-100 border border-slate-200 rounded-xl transition cursor-pointer"
                    title="Reset Filter Pencarian">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/90 overflow-hidden flex flex-col">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-rose-50/50 text-[11px] font-bold text-slate-500 uppercase tracking-wider border-b border-rose-100/60 select-none">
                            <th scope="col" class="py-3.5 pl-6 pr-4 min-w-[210px]">PENGIRIM</th>
                            <th scope="col" class="py-3.5 px-4 min-w-[160px]">TUJUAN WILAYAH</th>
                            @if ($isSuperAdmin)
                                <th scope="col" class="py-3.5 px-4 min-w-[170px]">PENANGANAN</th>
                            @endif
                            <th scope="col" class="py-3.5 px-4 min-w-[250px]">PESAN / LAPORAN</th>
                            <th scope="col" class="py-3.5 px-4 min-w-[140px] text-center">STATUS</th>
                            <th scope="col" class="py-3.5 px-4 min-w-[130px]">WAKTU MASUK</th>
                            <th scope="col" class="py-3.5 pr-6 pl-4 text-center min-w-[110px]">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs">
                        @forelse ($messages as $msg)
                            @php
                                $searchHaystack = strtolower($msg->name . ' ' . $msg->email . ' ' . $msg->region . ' ' . $msg->message . ' ' . ($msg->assignedOffice?->name ?? ''));
                                $accountLabel = $msg->user_id ? 'Akun Terdaftar (' . ($msg->user?->role === 'admin' ? 'Admin' : 'Pelamar') . ')' : 'Tamu Publik';
                                $dispatchFilterValue = $msg->assigned_office_id ? (string) $msg->assigned_office_id : 'unassigned';
                                $statusFilterValue = $msg->status === 'resolved' ? 'resolved' : 'pending';
                                $payload = [
                                    'id' => $msg->id,
                                    'name' => $msg->name,
                                    'email' => $msg->email,
                                    'region' => $msg->region,
                                    'message' => $msg->message,
                                    'reply_message' => $msg->reply_message ?? '',
                                    'status' => $msg->status,
                                    'assigned_office_id' => $msg->assigned_office_id ? (string) $msg->assigned_office_id : '',
                                    'assigned_office_name' => $msg->assignedOffice?->name ?? 'Pusat (Superadmin)',
                                    'assigned_at_formatted' => $msg->assigned_at ? $msg->assigned_at->translatedFormat('d M Y, H:i') . ' WIB' : '-',
                                    'ip_address' => $msg->ip_address ?? '-',
                                    'created_at_formatted' => $msg->created_at?->translatedFormat('d M Y, H:i') . ' WIB',
                                    'resolved_at_formatted' => $msg->resolved_at ? $msg->resolved_at->translatedFormat('d M Y, H:i') . ' WIB' : '-',
                                    'is_registered' => (bool) $msg->user_id,
                                    'account_email' => $msg->user?->email ?? '',
                                    'account_label' => $accountLabel,
                                ];
                            @endphp
                            <tr class="hover:bg-slate-50/70 transition-colors group"
                                x-show="
                                    (search === '' || (@js($searchHaystack)).includes(search.toLowerCase()))
                                    &&
                                    (selectedStatus === 'all' || @js($statusFilterValue) === selectedStatus)
                                    &&
                                    (selectedRegion === 'all' || @js($msg->region) === selectedRegion)
                                    &&
                                    (selectedDispatch === 'all' || @js($dispatchFilterValue) === selectedDispatch)
                                ">
                                <td class="py-4 pl-6 pr-4">
                                    <div class="flex flex-col gap-1">
                                        <span class="font-bold text-slate-900 group-hover:text-[#A6192E] transition-colors">
                                            {{ $msg->name }}
                                        </span>
                                        <span class="text-[11px] text-slate-500">{{ $msg->email }}</span>
                                        <div>
                                            @if ($msg->user_id)
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200/60">
                                                    <span class="w-1 h-1 rounded-full bg-indigo-500"></span>
                                                    Akun Terdaftar
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-medium bg-slate-100 text-slate-600 border border-slate-200/70">
                                                    Tamu Publik
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <td class="py-4 px-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-medium bg-slate-100 text-slate-700 border border-slate-200/80">
                                        {{ $msg->region }}
                                    </span>
                                </td>

                                @if ($isSuperAdmin)
                                    <td class="py-4 px-4">
                                        @if ($msg->assignedOffice)
                                            <div class="flex flex-col gap-0.5">
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[11px] font-semibold bg-sky-50 text-sky-800 border border-sky-200/70 w-fit">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-sky-500"></span>
                                                    {{ $msg->assignedOffice->name }}
                                                </span>
                                                @if ($msg->assigned_at)
                                                    <span class="text-[10px] text-slate-400">
                                                        Dikirim {{ $msg->assigned_at->translatedFormat('d M Y, H:i') }}
                                                    </span>
                                                @endif
                                            </div>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[11px] font-medium bg-amber-50 text-amber-800 border border-amber-200/70">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                                Pusat (Superadmin)
                                            </span>
                                        @endif
                                    </td>
                                @endif

                                <td class="py-4 px-4">
                                    <p class="text-slate-700 leading-relaxed line-clamp-2 max-w-md">
                                        {{ \Illuminate\Support\Str::limit($msg->message, 120) }}
                                    </p>
                                </td>

                                <td class="py-4 px-4 text-center whitespace-nowrap">
                                    @if ($msg->status === 'resolved')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200/70">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Sudah Ditangani
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-rose-50 text-[#A6192E] border border-red-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-[#A6192E] animate-pulse"></span>
                                            Belum Ditangani
                                        </span>
                                    @endif
                                </td>

                                <td class="py-4 px-4 text-slate-500 whitespace-nowrap">
                                    <div class="font-medium text-slate-700">
                                        {{ $msg->created_at?->translatedFormat('d M Y') }}
                                    </div>
                                    <div class="text-[11px] text-slate-400">
                                        {{ $msg->created_at?->format('H:i') }} WIB
                                    </div>
                                </td>

                                <td class="py-4 pr-6 pl-4 text-center whitespace-nowrap">
                                    <div class="inline-flex items-center justify-center gap-1 bg-slate-50 p-1 rounded-lg border border-slate-200/80">
                                        <button type="button"
                                            @click="openDetail(@js($payload))"
                                            class="p-1.5 text-slate-500 hover:text-[#A6192E] hover:bg-white rounded-md transition cursor-pointer"
                                            title="Detail &amp; Penanganan">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>

                                        @if ($isSuperAdmin)
                                            <button type="button"
                                                @click="openDelete(@js(['id' => $msg->id, 'name' => $msg->name, 'email' => $msg->email]))"
                                                class="p-1.5 text-slate-500 hover:text-red-600 hover:bg-white rounded-md transition cursor-pointer"
                                                title="Hapus Pesan">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $isSuperAdmin ? 7 : 6 }}" class="px-6 py-12 text-center text-slate-400">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        <p class="text-xs font-medium">Belum ada pesan masuk pada cakupan Anda.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-4 bg-slate-50/50 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                <div class="font-medium">
                    Menampilkan <span class="font-bold text-slate-800">{{ $totalMessages }}</span> total pesan &amp; laporan kontak
                </div>
            </div>
        </div>

        <template x-teleport="body">
            <div x-show="openDetailModal"
                x-cloak
                style="display: none;"
                class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
                role="dialog"
                aria-modal="true"
                aria-labelledby="modal-detail-message-title"
                @keydown.escape.window="openDetailModal = false">

                <div x-show="openDetailModal"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="bg-white w-full max-w-2xl rounded-2xl shadow-2xl border border-slate-200 flex flex-col max-h-[92vh] overflow-hidden">

                    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-white shrink-0">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-red-50 border border-red-100/70 flex items-center justify-center text-[#A6192E] shadow-2xs">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-slate-900 leading-tight" id="modal-detail-message-title">Detail Pesan &amp; Penanganan</h3>
                                <p class="text-[11px] text-slate-500 mt-0.5" x-text="detailData.created_at_formatted"></p>
                            </div>
                        </div>
                        <button type="button" @click="openDetailModal = false" aria-label="Tutup Modal"
                            class="p-1.5 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-lg transition cursor-pointer">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </button>
                    </div>

                    <form :action="'{{ url('/admin/contact-message') }}/' + detailData.id + '/status'" method="POST"
                        class="flex flex-col flex-1 min-h-0 overflow-hidden">
                        @csrf
                        @method('PATCH')

                        <div class="flex-1 overflow-y-auto px-6 py-5 space-y-5">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 bg-slate-50 rounded-xl p-4 border border-slate-200/80 text-xs">
                                <div>
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Nama Pengirim</span>
                                    <p class="font-bold text-slate-900 mt-0.5" x-text="detailData.name"></p>
                                </div>
                                <div>
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Alamat Email</span>
                                    <p class="font-medium text-slate-800 mt-0.5 break-all" x-text="detailData.email"></p>
                                </div>
                                <div>
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Tujuan Wilayah</span>
                                    <p class="font-medium text-slate-800 mt-0.5" x-text="detailData.region"></p>
                                </div>
                                <div>
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Status Akun &amp; IP</span>
                                    <p class="font-medium text-slate-800 mt-0.5">
                                        <span x-text="detailData.account_label"></span>
                                        <span class="text-slate-400" x-text="'(' + detailData.ip_address + ')'"></span>
                                    </p>
                                </div>
                                <div>
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Penanganan Saat Ini</span>
                                    <p class="font-semibold text-slate-800 mt-0.5" x-text="detailData.assigned_office_name"></p>
                                </div>
                                <div>
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Waktu Diselesaikan</span>
                                    <p class="font-medium text-slate-700 mt-0.5" x-text="detailData.resolved_at_formatted"></p>
                                </div>
                            </div>

                            <div class="space-y-1.5">
                                <label class="block text-[11px] font-semibold text-slate-700 uppercase tracking-wider">Isi Pesan / Keluhan</label>
                                <div class="rounded-xl border border-slate-200 bg-white p-4 text-xs sm:text-sm text-slate-800 leading-relaxed whitespace-pre-line"
                                    x-text="detailData.message"></div>
                            </div>

                            <div class="space-y-1.5" x-show="detailData.status === 'resolved' && detailData.reply_message">
                                <label class="block text-[11px] font-semibold text-emerald-700 uppercase tracking-wider">Balasan Email Terkirim</label>
                                <div class="rounded-xl border border-emerald-200 bg-emerald-50/70 p-4 text-xs sm:text-sm text-emerald-950 leading-relaxed whitespace-pre-line"
                                    x-text="detailData.reply_message"></div>
                            </div>

                            @if ($isSuperAdmin)
                                <div class="space-y-4 pt-2 border-t border-slate-100">
                                    <div class="space-y-1.5">
                                        <label for="detail_assigned_office" class="block text-[11px] font-semibold text-slate-700 uppercase tracking-wider">
                                            Arahkan Penanganan
                                        </label>
                                        <select id="detail_assigned_office" name="assigned_office_id" x-model="detailData.assigned_office_id"
                                            class="w-full py-2.5 px-3.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-800 focus:bg-white focus:border-[#A6192E] focus:ring-2 focus:ring-[#A6192E]/20 transition cursor-pointer">
                                            <option value="">Tangani Sendiri — Head Office (Kirim Balasan Email)</option>
                                            @foreach ($groupedOffices as $groupLabel => $offices)
                                                <optgroup label="{{ $groupLabel }}">
                                                    @foreach ($offices as $office)
                                                        <option value="{{ $office->id }}">
                                                            {{ $office->name }} ({{ $office->admin->pluck('name')->join(', ') }})
                                                        </option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                        <p class="text-[11px] text-slate-500">
                                            Pilih <strong>Tangani Sendiri</strong> untuk membalas langsung ke email pelapor, atau pilih <strong>Admin Cabang</strong> untuk melempar pesan ini ke cabang terkait.
                                        </p>
                                    </div>

                                    <div class="space-y-1.5" x-show="detailData.assigned_office_id === ''">
                                        <label for="detail_reply_message" class="block text-[11px] font-semibold text-slate-700 uppercase tracking-wider">
                                            Balasan / Solusi ke Email Pelapor <span class="text-red-600">*</span>
                                        </label>
                                        <textarea id="detail_reply_message" name="reply_message" rows="4"
                                            x-model="detailData.reply_message"
                                            :required="detailData.assigned_office_id === ''"
                                            placeholder="Contoh: Sudah saya ubah password akun Anda menjadi 123678, silakan coba login kembali."
                                            class="w-full py-2.5 px-3.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:bg-white focus:border-[#A6192E] focus:ring-2 focus:ring-[#A6192E]/20 transition resize-y"></textarea>
                                        <p class="text-[11px] text-slate-500">
                                            Teks ini akan langsung dikirim ke email pelapor dan status pesan otomatis menjadi <strong>Sudah Ditangani</strong>.
                                        </p>
                                    </div>
                                </div>
                            @else
                                <div class="space-y-1.5 pt-2 border-t border-slate-100" x-show="detailData.status !== 'resolved'">
                                    <label for="branch_reply_message" class="block text-[11px] font-semibold text-slate-700 uppercase tracking-wider">
                                        Balasan / Solusi ke Email Pelapor <span class="text-red-600">*</span>
                                    </label>
                                    <textarea id="branch_reply_message" name="reply_message" rows="4"
                                        x-model="detailData.reply_message"
                                        required
                                        placeholder="Contoh: Kendala Anda sudah kami tindaklanjuti, silakan coba kembali."
                                        class="w-full py-2.5 px-3.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:bg-white focus:border-[#A6192E] focus:ring-2 focus:ring-[#A6192E]/20 transition resize-y"></textarea>
                                    <p class="text-[11px] text-slate-500">
                                        Teks ini akan langsung dikirim ke email pelapor dan status pesan otomatis menjadi <strong>Sudah Ditangani</strong>.
                                    </p>
                                </div>

                                <div class="pt-2 border-t border-slate-100" x-show="detailData.status === 'resolved'">
                                    <div class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold">
                                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>Pesan ini sudah ditangani pada <span x-text="detailData.resolved_at_formatted"></span>.</span>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/70 flex items-center justify-end gap-2.5 shrink-0">
                            <button type="button" @click="openDetailModal = false"
                                class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-200/70 transition cursor-pointer">
                                Tutup
                            </button>

                            @if ($isSuperAdmin)
                                <button type="submit"
                                    :class="detailData.assigned_office_id === '' ? 'bg-emerald-600 hover:bg-emerald-700' : 'bg-[#A6192E] hover:bg-[#7f1d1d]'"
                                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-white text-xs font-bold shadow-sm transition cursor-pointer">
                                    <span x-text="detailData.assigned_office_id === '' ? 'Kirim Balasan Email' : 'Lempar ke Admin Cabang'"></span>
                                </button>
                            @else
                                <button type="submit"
                                    x-show="detailData.status !== 'resolved'"
                                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-sm transition cursor-pointer">
                                    <span>Kirim Balasan Email</span>
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </template>

        @if ($isSuperAdmin)
            <template x-teleport="body">
                <div x-show="openDeleteModal"
                    x-cloak
                    style="display: none;"
                    class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
                    role="dialog"
                    aria-modal="true"
                    aria-labelledby="modal-delete-message-title"
                    @keydown.escape.window="openDeleteModal = false">

                    <div x-show="openDeleteModal"
                        x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        class="bg-white w-full max-w-md rounded-2xl shadow-2xl border border-slate-200 overflow-hidden">

                        <form :action="'{{ url('/admin/contact-message') }}/' + deleteData.id" method="POST">
                            @csrf
                            @method('DELETE')

                            <div class="p-6 text-center space-y-3">
                                <div class="w-12 h-12 rounded-2xl bg-red-50 text-red-600 flex items-center justify-center mx-auto border border-red-100">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>
                                <h3 class="text-base font-bold text-slate-900" id="modal-delete-message-title">Hapus Pesan Masuk?</h3>
                                <p class="text-xs text-slate-500 leading-relaxed">
                                    Anda yakin ingin menghapus pesan dari <span class="font-bold text-slate-800" x-text="deleteData.name"></span>
                                    (<span class="text-slate-700" x-text="deleteData.email"></span>)? Tindakan ini tidak dapat dibatalkan.
                                </p>
                            </div>

                            <div class="px-6 py-4 bg-slate-50/80 border-t border-slate-100 flex items-center justify-end gap-2.5">
                                <button type="button" @click="openDeleteModal = false"
                                    class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-200/70 transition cursor-pointer">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="px-4 py-2 rounded-xl bg-red-600 hover:bg-red-700 text-white text-xs font-bold shadow-sm transition cursor-pointer">
                                    Ya, Hapus Pesan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </template>
        @endif
    </div>
@endsection
