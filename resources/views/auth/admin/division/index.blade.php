@extends('auth.admin.layouts.index')

@section('title', 'Kelola Divisi Lowongan')

@section('content')
    <div
        class="bg-white border-b border-slate-300 px-3 py-1.5 flex flex-wrap items-center justify-between gap-2 shrink-0 select-none">
        <div class="flex items-center gap-1.5 flex-wrap">
            <div class="relative">
                <i data-lucide="search" class="w-3.5 h-3.5 absolute left-2 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" placeholder="Cari nama division..."
                    class="pl-7 pr-2 py-1 bg-slate-50 border border-slate-300 rounded text-[11px] w-56 focus:bg-white focus:outline-none focus:border-blue-600 font-sans">
            </div>

            <button
                class="px-2 py-1 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded text-[11px] font-medium flex items-center gap-1 transition-colors hover:cursor-pointer">
                <i data-lucide="filter" class="w-3 h-3"></i> Apply Filter
            </button>
        </div>

        <div class="flex items-center gap-1.5">
            <a href="{{ route('division.create') }}"
                class="px-2 py-1 bg-emerald-700 hover:bg-emerald-800 text-white rounded text-[11px] font-medium flex items-center gap-1 shadow-sm transition-colors hover:cursor-pointer">
                <i data-lucide="plus" class="w-3 h-3"></i> Tambah Divisi Baru
            </a>
        </div>
    </div>

    <!-- METRIC KPI STRIP -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-2 p-2 bg-slate-200/60 border-b border-slate-300 shrink-0 text-[11px]">
        <div class="bg-white p-2 rounded border border-slate-300 flex items-center justify-between">
            <div>
                <p class="text-slate-500 text-[10px] uppercase font-semibold">Total Divisi Lowongan</p>
                <p class="text-sm font-bold font-mono text-slate-900">{{ $divisions->count() }}</p>
            </div>
            <div class="p-1.5 bg-blue-50 text-blue-600 rounded">
                <i data-lucide="briefcase" class="w-4 h-4"></i>
            </div>
        </div>
    </div>

    <!-- HIGH DENSITY DATA TABLE AREA -->
    <div class="flex-1 p-2 overflow-hidden flex flex-col">
        <div class="bg-white border border-slate-300 rounded flex-1 flex flex-col overflow-hidden">

            <div class="flex-1 overflow-auto">
                <table class="w-full text-left border-collapse text-[11px]">
                    <thead
                        class="bg-slate-200 sticky top-0 z-10 text-slate-700 font-semibold border-b border-slate-300 uppercase tracking-tight font-mono text-[10px]">
                        <tr>
                            <th class="p-1.5 border-r border-slate-300 w-12 text-center">No</th>
                            <th class="p-1.5 border-r border-slate-300">Nama Divisi / Departemen</th>
                            <th class="p-1.5 border-r border-slate-300 w-44">Tipe Lowongan</th>
                            <th class="p-1.5 border-r border-slate-300 w-44">Tanggal Dibuat</th>
                            <th class="p-1.5 text-center w-24">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 font-sans">
                        @forelse ($divisions as $index => $divisi)
                            <tr class="bg-white hover:bg-slate-100 transition-colors">
                                <td class="p-1.5 border-r border-slate-200 text-center font-mono text-slate-500">
                                    {{ $index + 1 }}
                                </td>
                                <td class="p-1.5 border-r border-slate-200 font-semibold text-slate-900 truncate max-w-xs">
                                    {{ $divisi->name }}
                                </td>
                                <td class="p-1.5 border-r border-slate-200 font-semibold text-slate-900 truncate max-w-xs">
                                    {{ $divisi->type }}
                                </td>
                                <td class="p-1.5 border-r border-slate-200 font-mono text-slate-600">
                                    {{ $divisi->created_at ? $divisi->created_at->format('d/m/Y H:i') : '-' }}
                                </td>
                                <td class="p-1.5 text-center font-sans flex justify-center items-center gap-2">
                                    <a href="{{ route('division.edit', $divisi->id) }}"
                                        class="text-blue-600 hover:text-blue-800 font-semibold text-[10px] transition-colors mt-0.5">Edit</a>

                                    <form action="{{ route('division.destroy', $divisi->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('Apakah Anda yakin ingin menghapus divisi ini?')"
                                            class="text-rose-600 hover:text-rose-800 font-semibold text-[10px] hover:cursor-pointer transition-colors">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-4 text-center text-slate-500 text-xs italic font-sans">
                                    Belum ada data divisi lowongan yang terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- TABLE FOOTER -->
            <div
                class="bg-slate-200 border-t border-slate-300 px-3 py-1 flex items-center justify-between text-[11px] text-slate-700 font-mono shrink-0 select-none">
                <span>Total Record: {{ $divisions->count() }} Divisi</span>
            </div>
        </div>
    </div>
@endsection
