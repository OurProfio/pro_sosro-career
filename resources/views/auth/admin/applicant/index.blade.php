@extends('auth.admin.layouts.index')

@section('title', 'Daftar Pelamar')

@section('content')
    <div class="space-y-4 font-sans">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="text-lg font-bold text-slate-800">Daftar Akun Pelamar</h2>
                <p class="text-xs text-slate-500">Kelola informasi profil dan akun pelamar kerja.</p>
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
                            Foto & Nama
                        </th>
                        <th scope="col" class="px-6 py-3.5">
                            NIK
                        </th>
                        <th scope="col" class="px-6 py-3.5">
                            Email
                        </th>
                        <th scope="col" class="px-6 py-3.5">
                            No. Telepon
                        </th>
                        <th scope="col" class="px-6 py-3.5">
                            L/P
                        </th>
                        <th scope="col" class="px-6 py-3.5">
                            Status Nikah
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
                    @forelse ($applicants as $index => $applicant)
                        <tr class="bg-white hover:bg-slate-50/80 transition-colors">
                            <td class="px-6 py-4 text-center font-medium text-slate-400">
                                {{ $index + 1 }}
                            </td>

                            <th scope="row" class="px-6 py-4 font-bold text-slate-800 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <img class="w-8 h-8 rounded-full object-cover border border-slate-200"
                                        src="{{ asset('storage/' . $applicant->photo_url) }}"
                                        alt="{{ $applicant->name }}" />
                                    <span>{{ $applicant->name }}</span>
                                </div>
                            </th>

                            <td class="px-6 py-4 text-slate-600 whitespace-nowrap">
                                {{ $applicant->nik }}
                            </td>

                            <td class="px-6 py-4 text-slate-600 whitespace-nowrap">
                                {{ $applicant->email }}
                            </td>

                            <td class="px-6 py-4 text-slate-600 whitespace-nowrap">
                                {{ $applicant->phone_number }}
                            </td>

                            <td class="px-6 py-4 uppercase">
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold {{ $applicant->gender == 'l' ? 'bg-blue-50 text-blue-700' : 'bg-pink-50 text-pink-700' }}">
                                    {{ $applicant->gender }}
                                </span>
                            </td>

                            <td class="px-6 py-4 capitalize text-slate-600 whitespace-nowrap">
                                {{ $applicant->marital_status }}
                            </td>

                            <td class="px-6 py-4 text-slate-500 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($applicant->created_at)->translatedFormat('d M Y H:i') }}
                            </td>

                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('applicant.show', $applicant) }}"
                                    class="inline-flex items-center rounded-lg bg-[#B11116] px-3 py-1.5 text-[11px] font-semibold text-white transition hover:bg-[#8f0e12] focus:outline-none focus:ring-2 focus:ring-[#B11116] focus:ring-offset-2">
                                    Show
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-12 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <svg class="w-8 h-8 text-slate-300" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                    </svg>
                                    <p class="text-xs font-medium">Belum ada data pelamar yang terdaftar.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
