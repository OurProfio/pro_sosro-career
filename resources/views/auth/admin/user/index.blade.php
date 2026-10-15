@extends('auth.admin.layouts.index')

@section('title', 'Kelola Akun User')

@section('content')
    <div class="space-y-4 font-sans">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="text-lg font-bold text-slate-800">Daftar Pengguna System (Users)</h2>
                <p class="text-xs text-slate-500">Kelola semua kredensial akun pengguna baik Admin maupun Applicant.</p>
            </div>
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
                            Alamat Email
                        </th>
                        <th scope="col" class="px-6 py-3.5">
                            Role Utama
                        </th>
                        <th scope="col" class="px-6 py-3.5">
                            Dibuat Pada
                        </th>
                        <th scope="col" class="px-6 py-3.5 text-center">
                            Aksi
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-200">
                    @forelse ($users as $index => $user)
                        <tr class="bg-white hover:bg-slate-50/80 transition-colors">
                            <td class="px-6 py-4 text-center font-medium text-slate-400">
                                {{ $index + 1 }}
                            </td>

                            <th scope="row" class="px-6 py-4 font-bold text-slate-800 whitespace-nowrap">
                                {{ $user->email }}
                            </th>

                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-semibold uppercase {{ $user->role == 'admin' ? 'bg-indigo-50 text-indigo-700 border border-indigo-200' : 'bg-emerald-50 text-emerald-700 border border-emerald-200' }}">
                                    {{ $user->role == 'admin' ? 'Admin' : 'Pelamar' }}
                                </span>
                            </td>


                            <td class="px-6 py-4 text-slate-500 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($user->created_at)->translatedFormat('d M Y H:i') }}
                            </td>

                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-1">
                                    <a href="{{ route('user.edit', $user->id) }}" title="Edit"
                                        class="p-1.5 text-slate-500 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors">
                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>
                                    </a>

                                    <form action="{{ route('user.destroy', $user->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Hapus"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus akun admin ini?')"
                                            class="hover:cursor-pointer p-1.5 text-slate-500 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors">
                                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <svg class="w-8 h-8 text-slate-300" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                    </svg>
                                    <p class="text-xs font-medium">Belum ada data user yang terdaftar.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
