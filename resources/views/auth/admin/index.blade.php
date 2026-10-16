@extends('auth.admin.layouts.index')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="space-y-6 font-sans">
        <section class="flex flex-col gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:flex-row sm:items-center sm:justify-between sm:p-6">
            <div>
                <p class="text-sm font-semibold text-[#B11116]">Dashboard Admin</p>
                <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                    Selamat datang, {{ $adminName }}
                </h1>
                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Pantau proses rekrutmen dan tindak lanjuti lamaran yang masuk.
                </p>
            </div>

            <div class="flex flex-col gap-2 sm:items-end">
                <span class="inline-flex w-fit items-center gap-2 rounded-full bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-700">
                    <svg class="h-4 w-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 21h18M5 21V7l8-4v18m-8-9h8m-4-4h.01M17 21V11l4-2v12M17 14h.01M17 17h.01" />
                    </svg>
                    {{ $isSuperAdmin ? 'Semua kantor' : ($officeName ?? 'Kantor admin') }}
                </span>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('applicant.index') }}"
                        class="inline-flex min-h-10 items-center justify-center rounded-lg border border-slate-200 bg-white px-3.5 text-xs font-semibold text-slate-700 transition hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-slate-400 focus:ring-offset-2">
                        Lihat pelamar
                    </a>
                    <a href="{{ route('job.create') }}"
                        class="inline-flex min-h-10 items-center justify-center rounded-lg bg-[#B11116] px-3.5 text-xs font-semibold text-white transition hover:bg-[#940e13] focus:outline-none focus:ring-2 focus:ring-[#B11116] focus:ring-offset-2">
                        Tambah lowongan
                    </a>
                </div>
            </div>
        </section>

        <section aria-label="Ringkasan rekrutmen" class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <article class="rounded-2xl border border-amber-200 bg-white p-5 shadow-sm">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-sm font-medium text-slate-600">Perlu ditinjau</p>
                        <p class="mt-2 text-3xl font-bold tracking-tight text-slate-900">{{ number_format($pendingApplicationsCount, 0, ',', '.') }}</p>
                        <p class="mt-1 text-xs text-slate-500">Lamaran menunggu peninjauan</p>
                    </div>
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-50 text-amber-700">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4l2.5 1.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </span>
                </div>
            </article>

            <article class="rounded-2xl border border-blue-200 bg-white p-5 shadow-sm">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-sm font-medium text-slate-600">Dalam proses</p>
                        <p class="mt-2 text-3xl font-bold tracking-tight text-slate-900">{{ number_format($inProgressApplicationsCount, 0, ',', '.') }}</p>
                        <p class="mt-1 text-xs text-slate-500">Lamaran dalam tahap seleksi</p>
                    </div>
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-700">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 16.5 9 11l3.5 3.5L20 7m0 0h-5m5 0v5" />
                        </svg>
                    </span>
                </div>
            </article>

            <article class="rounded-2xl border border-emerald-200 bg-white p-5 shadow-sm">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-sm font-medium text-slate-600">Lowongan aktif</p>
                        <p class="mt-2 text-3xl font-bold tracking-tight text-slate-900">{{ number_format($activeJobsCount, 0, ',', '.') }}</p>
                        <p class="mt-1 text-xs text-slate-500">Posisi yang sedang dibuka</p>
                    </div>
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 7h-9m3 10H5m12 0 2 2 2-2m-4-10 2-2 2 2M5 7h2m-2 10h2" />
                        </svg>
                    </span>
                </div>
            </article>

            <article class="rounded-2xl border border-rose-200 bg-white p-5 shadow-sm">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-sm font-medium text-slate-600">Pelamar</p>
                        <p class="mt-2 text-3xl font-bold tracking-tight text-slate-900">{{ number_format($applicantsCount, 0, ',', '.') }}</p>
                        <p class="mt-1 text-xs text-slate-500">Pelamar pada cakupan data ini</p>
                    </div>
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-rose-50 text-rose-700">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 18.5a4 4 0 0 0-8 0m12 0a4 4 0 0 0-3-3.87M4 18.5a4 4 0 0 1 3-3.87m9-6.13a4 4 0 1 1-8 0 4 4 0 0 1 8 0Zm4 1a3 3 0 1 1-2-2.83M3 9.5a3 3 0 1 0 2-2.83" />
                        </svg>
                    </span>
                </div>
            </article>
        </section>

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
            <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm xl:col-span-2">
                <div class="flex flex-col gap-3 border-b border-slate-100 p-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                    <div>
                        <h2 class="text-lg font-bold text-slate-900">Lamaran terbaru</h2>
                        <p class="mt-1 text-sm text-slate-500">Enam lamaran terbaru dalam cakupan data Anda.</p>
                    </div>
                    <a href="{{ route('applicant.index') }}" class="text-sm font-semibold text-[#B11116] hover:text-[#940e13] focus:outline-none focus:underline">
                        Buka daftar pelamar <span aria-hidden="true">&rarr;</span>
                    </a>
                </div>

                @if ($recentApplications->isNotEmpty())
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[680px] text-left text-sm">
                            <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                                <tr>
                                    <th scope="col" class="px-5 py-3 font-semibold sm:px-6">Pelamar</th>
                                    <th scope="col" class="px-5 py-3 font-semibold">Lowongan</th>
                                    <th scope="col" class="px-5 py-3 font-semibold">Tahap / status</th>
                                    <th scope="col" class="px-5 py-3 font-semibold">Diterima</th>
                                    <th scope="col" class="px-5 py-3 text-right font-semibold sm:px-6">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach ($recentApplications as $application)
                                    <tr class="transition hover:bg-slate-50/70">
                                        <td class="px-5 py-4 sm:px-6">
                                            <p class="font-semibold text-slate-800">{{ $application->applicant?->name ?? 'Pelamar' }}</p>
                                            <p class="mt-0.5 text-xs text-slate-500">{{ $application->applicant?->email ?? '-' }}</p>
                                        </td>
                                        <td class="px-5 py-4 font-medium text-slate-700">{{ $application->job?->title ?? 'Lowongan tidak tersedia' }}</td>
                                        <td class="px-5 py-4">
                                            <p class="text-xs font-medium text-slate-700">{{ $application->stage?->name ?? 'Tahap belum ditentukan' }}</p>
                                            @switch($application->status)
                                                @case('pending')
                                                    <span class="mt-1 inline-flex rounded-full bg-amber-50 px-2 py-0.5 text-[11px] font-semibold text-amber-800">Menunggu</span>
                                                @break
                                                @case('progress')
                                                    <span class="mt-1 inline-flex rounded-full bg-blue-50 px-2 py-0.5 text-[11px] font-semibold text-blue-700">Dalam proses</span>
                                                @break
                                                @case('accepted')
                                                    <span class="mt-1 inline-flex rounded-full bg-emerald-50 px-2 py-0.5 text-[11px] font-semibold text-emerald-700">Diterima</span>
                                                @break
                                                @case('rejected')
                                                    <span class="mt-1 inline-flex rounded-full bg-rose-50 px-2 py-0.5 text-[11px] font-semibold text-rose-700">Ditolak</span>
                                                @break
                                                @case('cancelled')
                                                    <span class="mt-1 inline-flex rounded-full bg-gray-100 px-2 py-0.5 text-[11px] font-semibold text-gray-700">Dibatalkan</span>
                                                @break
                                            @endswitch
                                        </td>
                                        <td class="whitespace-nowrap px-5 py-4 text-xs text-slate-500">
                                            {{ $application->created_at?->translatedFormat('d M Y, H:i') ?? '-' }}
                                        </td>
                                        <td class="px-5 py-4 text-right sm:px-6">
                                            @if ($application->applicant)
                                                <a href="{{ route('applicant.show', $application->applicant) }}"
                                                    class="inline-flex min-h-9 items-center justify-center rounded-lg border border-slate-200 px-3 text-xs font-semibold text-slate-700 transition hover:border-[#B11116] hover:text-[#B11116] focus:outline-none focus:ring-2 focus:ring-[#B11116]/30">
                                                    Detail
                                                </a>
                                            @else
                                                <span class="text-xs text-slate-400">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-10 text-center">
                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-slate-100 text-slate-500">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7h8m-8 4h8m-8 4h5M5 3h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z" />
                            </svg>
                        </div>
                        <p class="mt-3 text-sm font-semibold text-slate-800">Belum ada lamaran</p>
                        <p class="mt-1 text-sm text-slate-500">Lamaran baru akan muncul di sini.</p>
                    </div>
                @endif
            </section>

            <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-100 p-5 sm:px-6">
                    <h2 class="text-lg font-bold text-slate-900">Segera berakhir</h2>
                    <p class="mt-1 text-sm text-slate-500">Lowongan aktif dengan batas lamaran tujuh hari ke depan.</p>
                </div>

                @if ($closingSoonJobs->isNotEmpty())
                    <ul class="divide-y divide-slate-100">
                        @foreach ($closingSoonJobs as $job)
                            <li class="p-5 transition hover:bg-slate-50/70 sm:px-6">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="min-w-0">
                                        <a href="{{ route('job.show', $job) }}" class="line-clamp-2 text-sm font-semibold text-slate-800 hover:text-[#B11116] focus:outline-none focus:underline">
                                            {{ $job->title }}
                                        </a>
                                        <p class="mt-1 text-xs text-slate-500">{{ $job->applications_count }} lamaran</p>
                                    </div>
                                    <span class="shrink-0 rounded-lg bg-amber-50 px-2.5 py-1.5 text-right text-[11px] font-semibold text-amber-800">
                                        {{ \Carbon\Carbon::parse($job->closing_date)->translatedFormat('d M Y') }}
                                    </span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="p-8 text-center">
                        <p class="text-sm font-semibold text-slate-800">Tidak ada lowongan yang segera berakhir</p>
                        <p class="mt-1 text-xs leading-5 text-slate-500">Lowongan aktif yang akan tutup dalam tujuh hari akan tampil di sini.</p>
                    </div>
                @endif
            </section>
        </div>
    </div>
@endsection
