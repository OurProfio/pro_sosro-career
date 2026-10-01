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
                                    {{ $user->role }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-slate-500 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($user->created_at)->translatedFormat('d M Y H:i') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400">
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
