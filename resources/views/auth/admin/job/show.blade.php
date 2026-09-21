@extends('auth.admin.layouts.index')

@section('title', 'Detail Lowongan Pekerjaan')

@section('content')
    <div class="bg-white border-b border-slate-300 px-3 py-1.5 flex items-center justify-between shrink-0 select-none">
        <div class="flex items-center gap-2 text-[11px]">
            <a href="{{ route('job.index') }}" class="text-slate-500 hover:text-blue-600 flex items-center gap-1">
                <i data-lucide="briefcase" class="w-3.5 h-3.5"></i>
                <span>Kelola Lowongan</span>
            </a>
            <span class="text-slate-400">/</span>
            <span class="font-bold text-slate-800">Detail Lowongan: {{ $job->title }}</span>
        </div>

        <div class="flex items-center gap-1.5">
            <a href="{{ route('job.edit', $job->id) }}"
                class="px-2 py-0.5 bg-amber-600 hover:bg-amber-700 text-white rounded text-[10px] font-semibold flex items-center gap-1 transition-colors hover:cursor-pointer">
                <i data-lucide="edit-3" class="w-3 h-3"></i> Edit Data
            </a>
            <a href="{{ route('job.index') }}"
                class="px-2 py-0.5 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded text-[10px] font-semibold flex items-center gap-1 transition-colors hover:cursor-pointer">
                <i data-lucide="arrow-left" class="w-3 h-3"></i> Kembali
            </a>
        </div>
    </div>

    <div class="flex-1 p-3 overflow-y-auto">
        <div class="max-w-4xl mx-auto space-y-3">

            <!-- HEADER RINGKASAN UTAMA -->
            <div class="bg-white border border-slate-300 rounded shadow-sm overflow-hidden">
                <div class="bg-slate-800 text-white px-3 py-2 border-b border-slate-700 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i data-lucide="file-text" class="w-4 h-4 text-blue-400"></i>
                        <h1 class="font-bold text-xs tracking-wide uppercase">RINCIAN LOWONGAN PEKERJAAN</h1>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-[10px] font-mono text-slate-400">ID: #{{ $job->id }}</span>
                        <span
                            class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider
                            {{ $job->status == 'aktif' ? 'bg-emerald-500 text-white' : 'bg-slate-600 text-slate-200' }}">
                            {{ $job->status }}
                        </span>
                    </div>
                </div>

                <div class="p-4 grid grid-cols-1 md:grid-cols-2 gap-4 text-[11px] border-b border-slate-200">
                    <div>
                        <p class="text-[10px] font-mono uppercase text-slate-500 font-semibold">Judul Lowongan</p>
                        <p class="text-sm font-bold text-slate-900 mt-0.5">{{ $job->title }}</p>
                    </div>

                    <div>
                        <p class="text-[10px] font-mono uppercase text-slate-500 font-semibold">Penempatan Cabang / Kantor
                        </p>
                        <p class="text-sm font-semibold text-blue-700 mt-0.5 flex items-center gap-1">
                            <i data-lucide="building-2" class="w-3.5 h-3.5"></i>
                            {{ $job->office->name ?? ($job->office->title ?? 'Semua Cabang / Pusat') }}
                        </p>
                    </div>
                </div>

                <!-- METADATA GRID -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 p-3 bg-slate-50 border-b border-slate-200 text-[11px]">
                    <div>
                        <span class="text-[10px] text-slate-500 block font-mono uppercase">Kategori</span>
                        <span class="font-semibold text-slate-800">{{ $job->category }}</span>
                    </div>
                    <div>
                        <span class="text-[10px] text-slate-500 block font-mono uppercase">Bidang (Occupation)</span>
                        <span class="font-semibold text-slate-800">{{ $job->occupation }}</span>
                    </div>
                    <div>
                        <span class="text-[10px] text-slate-500 block font-mono uppercase">Tipe Pekerjaan</span>
                        <span class="font-semibold text-slate-800">{{ $job->type }}</span>
                    </div>
                    <div>
                        <span class="text-[10px] text-slate-500 block font-mono uppercase">Lokasi Kerja</span>
                        <span class="font-semibold text-slate-800">{{ $job->location }}</span>
                    </div>
                </div>
            </div>

            <!-- DETAIL DESKRIPSI & KUALIFIKASI -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-[11px]">
                <!-- DESKRIPSI -->
                <div class="bg-white border border-slate-300 rounded shadow-sm p-3 flex flex-col">
                    <div
                        class="border-b border-slate-200 pb-1.5 mb-2 flex items-center gap-1.5 font-bold text-slate-700 uppercase font-mono text-[10px]">
                        <i data-lucide="align-left" class="w-3.5 h-3.5 text-blue-600"></i>
                        <span>Deskripsi Pekerjaan</span>
                    </div>
                    <div class="text-slate-800 leading-relaxed whitespace-pre-line flex-1">
                        {{ $job->description }}
                    </div>
                </div>

                <!-- KUALIFIKASI -->
                <div class="bg-white border border-slate-300 rounded shadow-sm p-3 flex flex-col">
                    <div
                        class="border-b border-slate-200 pb-1.5 mb-2 flex items-center gap-1.5 font-bold text-slate-700 uppercase font-mono text-[10px]">
                        <i data-lucide="check-square" class="w-3.5 h-3.5 text-blue-600"></i>
                        <span>Kualifikasi Pelamar</span>
                    </div>
                    <div class="text-slate-800 leading-relaxed whitespace-pre-line flex-1">
                        {{ $job->qualification }}
                    </div>
                </div>
            </div>

            <!-- JADWAL PERIODE & TIMESTAMPS -->
            <div class="bg-white border border-slate-300 rounded shadow-sm p-3 text-[11px]">
                <div class="border-b border-slate-200 pb-1 mb-2 font-bold text-slate-700 uppercase font-mono text-[10px]">
                    Informasi Periode & Riwayat
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-4 gap-3">
                    <div class="bg-slate-50 p-2 rounded border border-slate-200">
                        <span class="text-[10px] text-slate-500 block font-mono uppercase">Periode Pendaftaran</span>
                        <span class="font-mono font-semibold text-slate-800">
                            {{ \Carbon\Carbon::parse($job->opening_date)->format('d/m/Y') }} –
                            {{ \Carbon\Carbon::parse($job->closing_date)->format('d/m/Y') }}
                        </span>
                    </div>

                    <div class="bg-slate-50 p-2 rounded border border-slate-200">
                        <span class="text-[10px] text-slate-500 block font-mono uppercase">Dibuat Oleh Admin</span>
                        <span class="font-semibold text-slate-800">
                            {{ $job->admin->name ?? ($job->admin->user->name ?? 'Admin #' . $job->admin_id) }}
                        </span>
                    </div>

                    <div class="bg-slate-50 p-2 rounded border border-slate-200">
                        <span class="text-[10px] text-slate-500 block font-mono uppercase">Tanggal Dibuat</span>
                        <span class="font-mono text-slate-700">
                            {{ $job->created_at ? $job->created_at->format('d/m/Y H:i') : '-' }}
                        </span>
                    </div>

                    <div class="bg-slate-50 p-2 rounded border border-slate-200">
                        <span class="text-[10px] text-slate-500 block font-mono uppercase">Terakhir Diperbarui</span>
                        <span class="font-mono text-slate-700">
                            {{ $job->updated_at ? $job->updated_at->format('d/m/Y H:i') : '-' }}
                        </span>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
