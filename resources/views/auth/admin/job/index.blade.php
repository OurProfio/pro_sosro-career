        @extends('auth.admin.layouts.index')

@section('title', 'Kelola Lowongan Pekerjaan')

@section('content')
    <div class="space-y-4 font-sans">

        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="text-lg font-bold text-slate-800">
                    Daftar Lowongan
                </h2>

                <p class="text-xs text-slate-500">
                    Kelola data lowongan pekerjaan yang tersedia dalam sistem.
                </p>
            </div>

            <a href="{{ route('job.create') }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white text-xs font-semibold rounded-xl shadow-xs transition-colors">

                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor">

                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />

                </svg>

                <span>Tambah Lowongan</span>

            </a>
        </div>

        <div class="relative overflow-x-auto bg-white shadow-xs rounded-2xl border border-slate-200">

            <table class="w-full text-xs text-left rtl:text-right text-slate-700 border-collapse">

                <thead>
                    <tr
                        class="bg-slate-50 border-b border-slate-200 text-slate-500 font-semibold uppercase tracking-wider text-[11px]">

                        <th scope="col" class="px-6 py-3.5 w-12 text-center">
                            No
                        </th>

                        <th scope="col" class="px-6 py-3.5">
                            Lowongan
                        </th>

                        <th scope="col" class="px-6 py-3.5">
                            Kategori
                        </th>

                        <th scope="col" class="px-6 py-3.5">
                            Pekerjaan
                        </th>

                        <th scope="col" class="px-6 py-3.5">
                            Tipe
                        </th>

                        <th scope="col" class="px-6 py-3.5">
                            Kantor
                        </th>

                        <th scope="col" class="px-6 py-3.5">
                            Lokasi
                        </th>

                        <th scope="col" class="px-6 py-3.5">
                            Periode
                        </th>

                        <th scope="col" class="px-6 py-3.5">
                            Status
                        </th>

                        <th scope="col" class="px-6 py-3.5 w-28 text-center">
                            Aksi
                        </th>

                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-200">

                    @forelse ($jobs as $index => $job)
                        <tr class="bg-white hover:bg-slate-50/80 transition-colors">

                            <td class="px-6 py-4 text-center font-medium text-slate-400">
                                {{ $index + 1 }}
                            </td>

                            <th scope="row" class="px-6 py-4 font-bold text-slate-800 whitespace-nowrap">
                                {{ $job->title }}
                            </th>

                            <td class="px-6 py-4 text-slate-600 whitespace-nowrap">
                                {{ ucwords(str_replace('_', ' ', $job->category)) }}
                            </td>

                            <td class="px-6 py-4 text-slate-600 whitespace-nowrap">
                                {{ $job->occupation }}
                            </td>

                            <td class="px-6 py-4 text-slate-600 whitespace-nowrap">
                                {{ $job->type }}
                            </td>

                            <td class="px-6 py-4 text-slate-600 whitespace-nowrap">
                                {{ $job->office->name }}
                            </td>

                            <td class="px-6 py-4 text-slate-600 whitespace-nowrap">
                                {{ $job->location }}
                            </td>

                            <td class="px-6 py-4 text-slate-500 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($job->opening_date)->format('d M Y') }}
                                -
                                {{ \Carbon\Carbon::parse($job->closing_date)->format('d M Y') }}
                            </td>

                            <td class="px-6 py-4">

                                @if ($job->status === 'aktif')
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                        Aktif
                                    </span>
                                @elseif ($job->status === 'nonaktif')
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                                        Nonaktif
                                    </span>
                                @elseif ($job->status === 'selesai')
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-semibold bg-blue-50 text-blue-700 border border-blue-100">
                                        Selesai
                                    </span>
                                @elseif ($job->status === 'dihapus')
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-semibold bg-rose-50 text-rose-700 border border-rose-100">
                                        Dihapus
                                    </span>
                                @endif

                            </td>

                            <td class="px-6 py-4 text-center">

                                <div class="flex items-center justify-center gap-1">

                                    <a href="{{ route('job.show', $job->id) }}" title="Lihat Detail"
                                        class="p-1.5 text-slate-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">

                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">

                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.036 12.322a1.012 1.012 0 010-.644C3.423 7.51 7.36 4.5 12 4.5c4.64 0 8.577 3.01 9.964 7.178.07.21.07.434 0 .644C20.577 16.49 16.64 19.5 12 19.5c-4.64 0-8.577-3.01-9.964-7.178Z" />

                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0Z" />

                                        </svg>

                                    </a>

                                    <a href="{{ route('job.edit', $job->id) }}" title="Edit"
                                        class="p-1.5 text-slate-500 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors">
                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 15.07a4.5 4.5 0 0 1-1.897 1.13l-2.685.805.805-2.685a4.5 4.5 0 0 1 1.13-1.897L16.862 4.487Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19.5 7.125 16.875 4.5" />
                                        </svg>
                                    </a>

                                    <form action="{{ route('job.destroy', $job->id) }}" method="POST" class="inline">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" title="Hapus"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus lowongan ini?')"
                                            class="hover:cursor-pointer p-1.5 text-slate-500 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors">
                                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 01-3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />

                                            </svg>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="10" class="px-6 py-12 text-center text-slate-400">

                                <div class="flex flex-col items-center justify-center gap-2">

                                    <svg class="w-8 h-8 text-slate-300" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">

                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M20.25 7.5l-8.25-4.5-8.25 4.5m16.5 0v9l-8.25 4.5m8.25-13.5L12 12m0 0L3.75 7.5M12 12v9" />

                                    </svg>

                                    <p class="text-xs font-medium">
                                        Belum ada data lowongan yang terdaftar.
                                    </p>

                                </div>

                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

    </div>
@endsection
