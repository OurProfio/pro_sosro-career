@extends('auth.admin.layouts.index')

@section('title', 'Detail Pelamar')

@section('content')

    <div class="applicant-show-page min-h-screen bg-slate-50 px-4 py-6 sm:px-6 lg:px-8">

        <div class="print-applicant-heading hidden">
            <div>
                <h1>Profil Applicant</h1>
                <p>Informasi kandidat dan riwayat lamaran</p>
            </div>
            <p>Dicetak {{ now()->format('d/m/Y H:i') }}</p>
        </div>

        <div class="mx-auto max-w-7xl">

            <div class="no-print mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <div class="mb-1 flex items-center gap-2 text-sm text-slate-500">
                        <a href="{{ route('applicant.index') }}" class="transition hover:text-[#B11116]">
                            Applicant
                        </a>
                        <span>/</span>
                        <span class="text-slate-700">Detail</span>
                    </div>

                    <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                        Detail Pelamar
                    </h1>

                    <p class="mt-1 text-sm text-slate-500">
                        Informasi lengkap dan riwayat lamaran kandidat.
                    </p>
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ route('applicant.index') }}"
                        class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali
                    </a>

                    <a href="{{ route('applicant.print', $applicant) }}" target="_blank"
                        class="inline-flex items-center gap-2 rounded-xl bg-[#B11116] px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#940e13]">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 9V2h12v7M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2M6 14h12v8H6v-8z" />
                        </svg>
                        Cetak
                    </a>
                </div>
            </div>

            {{-- Main Card --}}
            <div class="applicant-print-card overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                <div class="grid grid-cols-1 lg:grid-cols-12">

                    {{-- =====================================================
                SIDEBAR
            ====================================================== --}}
                    <aside class="border-b border-slate-200 bg-slate-50/70 p-6 lg:col-span-4 lg:border-b-0 lg:border-r">

                        {{-- Profile --}}
                        <div class="text-center">

                            <div
                                class="mx-auto h-28 w-28 overflow-hidden rounded-2xl border-4 border-white bg-slate-100 shadow-sm">
                                @if ($applicant->photo_url)
                                    <img src="{{ asset('storage/' . $applicant->photo_url) }}" alt="{{ $applicant->name }}"
                                        class="h-full w-full object-cover">
                                @else
                                    <div
                                        class="flex h-full w-full items-center justify-center text-3xl font-bold text-slate-400">
                                        {{ strtoupper(substr($applicant->name ?? 'A', 0, 1)) }}
                                    </div>
                                @endif
                            </div>

                            <h2 class="mt-4 text-xl font-bold text-slate-900">
                                {{ $applicant->name }}
                            </h2>

                        </div>

                        {{-- Contact --}}
                        <div class="mt-8">
                            <h3 class="mb-3 text-xs font-bold uppercase tracking-wider text-slate-400">
                                Kontak
                            </h3>

                            <div class="space-y-3">

                                <div class="flex gap-3">
                                    <div
                                        class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-red-50 text-[#B11116]">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>

                                    <div class="min-w-0">
                                        <p class="text-xs text-slate-400">Email</p>
                                        <p class="break-all text-sm font-medium text-slate-700">
                                            {{ $applicant->email ?? '-' }}
                                        </p>
                                    </div>
                                </div>

                                <div class="flex gap-3">
                                    <div
                                        class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-red-50 text-[#B11116]">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.95.68l1.5 4.49a1 1 0 01-.5 1.21l-2.1 1.05a16 16 0 006.42 6.42l1.05-2.1a1 1 0 011.21-.5l4.49 1.5a1 1 0 01.68.95V19a2 2 0 01-2 2h-1C10.16 21 3 13.84 3 5z" />
                                        </svg>
                                    </div>

                                    <div>
                                        <p class="text-xs text-slate-400">Nomor Telepon</p>
                                        <p class="text-sm font-medium text-slate-700">
                                            {{ $applicant->phone_number ?? '-' }}
                                        </p>
                                    </div>
                                </div>

                                @if ($applicant->linkedin)
                                    <div class="flex gap-3">
                                        <div
                                            class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-red-50 text-[#B11116]">
                                            <span class="text-xs font-bold">in</span>
                                        </div>

                                        <div class="min-w-0">
                                            <p class="text-xs text-slate-400">LinkedIn</p>
                                            <p class="break-all text-sm font-medium text-slate-700">
                                                {{ $applicant->linkedin }}
                                            </p>
                                        </div>
                                    </div>
                                @endif

                                @if ($applicant->instagram)
                                    <div class="flex gap-3">
                                        <div
                                            class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-red-50 text-[#B11116]">
                                            <span class="text-xs font-bold">@</span>
                                        </div>

                                        <div class="min-w-0">
                                            <p class="text-xs text-slate-400">Instagram</p>
                                            <p class="break-all text-sm font-medium text-slate-700">
                                                {{ $applicant->instagram }}
                                            </p>
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>

                        {{-- Personal Information --}}
                        <div class="mt-8 border-t border-slate-200 pt-6">

                            <h3 class="mb-4 text-xs font-bold uppercase tracking-wider text-slate-400">
                                Data Pribadi
                            </h3>

                            <div class="space-y-4">

                                <div>
                                    <p class="text-xs text-slate-400">NIK</p>
                                    <p class="mt-1 text-sm font-medium text-slate-700">
                                        {{ $applicant->nik ?? '-' }}
                                    </p>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-xs text-slate-400">Jenis Kelamin</p>
                                        <p class="mt-1 text-sm font-medium text-slate-700">
                                            @if ($applicant->gender === 'l')
                                                Laki-laki
                                            @elseif ($applicant->gender === 'p')
                                                Perempuan
                                            @else
                                                -
                                            @endif
                                        </p>
                                    </div>

                                    <div>
                                        <p class="text-xs text-slate-400">Agama</p>
                                        <p class="mt-1 text-sm font-medium text-slate-700">
                                            {{ $applicant->religion_name ?? $applicant->religion ?? '-' }}
                                        </p>
                                    </div>
                                </div>

                                <div>
                                    <p class="text-xs text-slate-400">Status Pernikahan</p>
                                    <p class="mt-1 text-sm font-medium text-slate-700">
                                        @switch($applicant->marital_status)
                                            @case('single')
                                                Belum Menikah
                                            @break

                                            @case('married')
                                                Menikah
                                            @break

                                            @case('divorced')
                                                Cerai
                                            @break

                                            @case('widowed')
                                                Duda/Janda
                                            @break

                                            @default
                                                -
                                        @endswitch
                                    </p>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-xs text-slate-400">Tempat Lahir</p>
                                        <p class="mt-1 text-sm font-medium text-slate-700">
                                            {{ $applicant->place_of_birth ?? '-' }}
                                        </p>
                                    </div>

                                    <div>
                                        <p class="text-xs text-slate-400">Tanggal Lahir</p>
                                        <p class="mt-1 text-sm font-medium text-slate-700">
                                            {{ $applicant->date_of_birth ? \Carbon\Carbon::parse($applicant->date_of_birth)->format('d M Y') : '-' }}
                                        </p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-xs text-slate-400">Tinggi</p>
                                        <p class="mt-1 text-sm font-medium text-slate-700">
                                            {{ $applicant->height ? $applicant->height . ' cm' : '-' }}
                                        </p>
                                    </div>

                                    <div>
                                        <p class="text-xs text-slate-400">Berat</p>
                                        <p class="mt-1 text-sm font-medium text-slate-700">
                                            {{ $applicant->weight ? $applicant->weight . ' kg' : '-' }}
                                        </p>
                                    </div>
                                </div>

                                <div>
                                    <p class="text-xs text-slate-400">Golongan Darah</p>
                                    <p class="mt-1 text-sm font-medium text-slate-700">
                                        {{ $applicant->blood_type ? 'Golongan ' . $applicant->blood_type : '-' }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-xs text-slate-400">SIM</p>
                                    <p class="mt-1 text-sm font-medium text-slate-700">
                                        @if (is_array($applicant->driver_licenses))
                                            {{ count($applicant->driver_licenses) ? implode(', ', $applicant->driver_licenses) : '-' }}
                                        @else
                                            {{ $applicant->driver_licenses ?? '-' }}
                                        @endif
                                    </p>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-xs text-slate-400">Perokok</p>
                                        <p class="mt-1 text-sm font-medium text-slate-700">
                                            {{ $applicant->is_smoker ? 'Ya' : 'Tidak' }}
                                        </p>
                                    </div>

                                    <div>
                                        <p class="text-xs text-slate-400">Tato</p>
                                        <p class="mt-1 text-sm font-medium text-slate-700">
                                            {{ $applicant->has_tattoo ? 'Ya' : 'Tidak' }}
                                        </p>
                                    </div>
                                </div>

                                <div>
                                    <p class="text-xs text-slate-400">Riwayat Medis</p>
                                    <p class="mt-1 text-sm leading-6 text-slate-700">
                                        {{ $applicant->medical_history ?: 'Tidak ada informasi.' }}
                                    </p>
                                </div>

                            </div>
                        </div>

                        {{-- Address --}}
                        <div class="mt-8 border-t border-slate-200 pt-6">

                            <h3 class="mb-4 text-xs font-bold uppercase tracking-wider text-slate-400">
                                Alamat
                            </h3>

                            <div class="space-y-4">

                                <div>
                                    <p class="text-xs text-slate-400">Alamat KTP</p>
                                    <p class="mt-1 text-sm leading-6 text-slate-700">
                                        {{ $applicant->address_ktp ?? '-' }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-xs text-slate-400">Alamat Domisili</p>
                                    <p class="mt-1 text-sm leading-6 text-slate-700">
                                        {{ $applicant->address_domisili ?? '-' }}
                                    </p>
                                </div>

                            </div>
                        </div>

                        {{-- Job Interests --}}
                        <div class="mt-8 border-t border-slate-200 pt-6">
                            <h3 class="mb-4 text-xs font-bold uppercase tracking-wider text-slate-400">
                                Minat Pekerjaan
                            </h3>

                            @php
                                $interests = $applicant->interest?->interests;
                                $interests = is_array($interests) ? array_slice($interests, 0, 5) : (filled($interests) ? [$interests] : []);
                            @endphp

                            @if (count($interests))
                                <ol class="space-y-2">
                                    @foreach ($interests as $interestIndex => $interest)
                                        <li class="flex items-center gap-2 text-sm font-medium text-slate-700">
                                            <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-red-50 text-xs font-bold text-[#B11116]">
                                                {{ $interestIndex + 1 }}
                                            </span>
                                            <span>{{ is_array($interest) ? ($interest['name'] ?? '-') : ($interestNames->get((int) $interest, $interest)) }}</span>
                                        </li>
                                    @endforeach
                                </ol>
                            @else
                                <p class="text-sm text-slate-400">Belum ada minat pekerjaan yang dipilih.</p>
                            @endif
                        </div>

                    </aside>


                    {{-- =====================================================
                MAIN CONTENT
            ====================================================== --}}
                    <main class="p-6 lg:col-span-8 lg:p-8">

                        {{-- Application Summary --}}
                        <section class="mb-8">

                            <div class="mb-4 flex items-center justify-between gap-4">
                                <div>
                                    <h2 class="text-lg font-bold text-slate-900">
                                        Riwayat Lamaran
                                    </h2>
                                    <p class="mt-1 text-sm text-slate-500">
                                        Daftar lowongan yang pernah dilamar oleh kandidat.
                                    </p>
                                </div>

                                <div
                                    class="flex h-10 min-w-10 items-center justify-center rounded-xl bg-red-50 px-3 text-sm font-bold text-[#B11116]">
                                    {{ $applicant->applications->count() }}
                                </div>
                            </div>

                            @if ($applicant->applications->count())
                                <div class="space-y-4">
                                    @foreach ($applicant->applications->sortByDesc('created_at') as $application)
                                        <article class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:border-slate-300 hover:shadow-md">
                                            <div class="flex flex-col gap-4 border-b border-slate-100 bg-slate-50/70 p-5 sm:flex-row sm:items-start sm:justify-between">
                                                <div class="flex min-w-0 items-start gap-3">
                                                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-red-50 text-[#B11116]">
                                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 7h-9m3 10H5m12 0 2 2 2-2m-4-10 2-2 2 2M5 7h2m-2 10h2" />
                                                        </svg>
                                                    </div>
                                                    <div class="min-w-0">
                                                        <h3 class="text-base font-bold leading-6 text-slate-900">
                                                            {{ $application->job->title ?? 'Lowongan tidak tersedia' }}
                                                        </h3>
                                                        @if ($application->job)
                                                            <p class="mt-1 text-sm text-slate-500">
                                                                {{ ucwords(str_replace('_', ' ', $application->job->category ?? '')) }}
                                                                @if ($application->job->occupation)
                                                                    <span class="px-1 text-slate-300">·</span>{{ $application->job->occupation }}
                                                                @endif
                                                            </p>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="shrink-0 rounded-xl border border-slate-200 bg-white px-3 py-2 sm:text-right">
                                                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Tanggal Melamar</p>
                                                    <p class="mt-0.5 text-sm font-semibold text-slate-700">
                                                        {{ $application->created_at?->format('d M Y') ?? '-' }}
                                                        <span class="font-normal text-slate-400">{{ $application->created_at?->format('H:i') ?? '' }}</span>
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="grid gap-4 p-5 sm:grid-cols-2">
                                                <div class="grid grid-cols-2 gap-3">
                                                    <div class="rounded-xl border border-slate-100 bg-slate-50 p-3">
                                                        <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Lokasi</p>
                                                        <p class="mt-1 text-sm font-medium text-slate-700">{{ $application->job->location ?? '-' }}</p>
                                                    </div>
                                                    <div class="rounded-xl border border-slate-100 bg-slate-50 p-3">
                                                        <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Tipe Pekerjaan</p>
                                                        <p class="mt-1 text-sm font-medium text-slate-700">{{ $application->job->type ?? '-' }}</p>
                                                    </div>
                                                </div>

                                                <div class="flex flex-wrap items-center gap-3 sm:justify-end">
                                                    <div class="min-w-36 rounded-xl border border-slate-100 px-3 py-2">
                                                        <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Tahap Seleksi</p>
                                                        @if ($application->stage)
                                                            <p class="mt-1 text-sm font-semibold text-slate-700">{{ $application->stage->name }}</p>
                                                            <p class="text-xs text-slate-400">Tahap {{ $application->stage->step }}</p>
                                                        @else
                                                            <p class="mt-1 text-sm font-medium text-slate-500">Belum ditentukan</p>
                                                        @endif
                                                    </div>

                                                    <div>
                                                        <p class="mb-1 text-[10px] font-bold uppercase tracking-wider text-slate-400">Status</p>
                                                        @switch($application->status)
                                                            @case('pending')
                                                                <span class="inline-flex rounded-full bg-slate-100 px-3 py-1.5 text-xs font-bold text-slate-600">Pending</span>
                                                            @break
                                                            @case('progress')
                                                                <span class="inline-flex rounded-full bg-blue-50 px-3 py-1.5 text-xs font-bold text-blue-700">Progress</span>
                                                            @break
                                                            @case('accepted')
                                                                <span class="inline-flex rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-bold text-emerald-700">Accepted</span>
                                                            @break
                                                            @case('rejected')
                                                                <span class="inline-flex rounded-full bg-red-50 px-3 py-1.5 text-xs font-bold text-red-700">Rejected</span>
                                                            @break
                                                            @case('cancelled')
                                                                <span class="inline-flex rounded-full bg-gray-100 px-3 py-1.5 text-xs font-bold text-gray-700">Dibatalkan</span>
                                                            @break
                                                            @default
                                                                <span class="inline-flex rounded-full bg-slate-100 px-3 py-1.5 text-xs font-bold text-slate-600">{{ ucfirst($application->status ?? '-') }}</span>
                                                        @endswitch
                                                    </div>
                                                </div>
                                            </div>

                                            @if ($application->job)
                                                <div class="flex justify-end border-t border-slate-100 px-5 py-3">
                                                    <a href="{{ route('job.show', $application->job) }}"
                                                        class="no-print inline-flex items-center gap-2 rounded-lg bg-[#B11116] px-3.5 py-2 text-xs font-semibold text-white transition hover:bg-[#940e13] focus:outline-none focus:ring-2 focus:ring-[#B11116] focus:ring-offset-2">
                                                        Detail Lowongan
                                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                        </svg>
                                                    </a>
                                                </div>
                                            @endif
                                        </article>
                                    @endforeach
                                </div>
                                {{-- Application Notes --}}
                                @php
                                    $applicationsWithNotes = $applicant->applications->filter(
                                        fn($application) => filled($application->notes),
                                    );
                                @endphp

                                @if ($applicationsWithNotes->count())
                                    <div class="mt-4 rounded-2xl border border-amber-200 bg-amber-50 p-5">

                                        <div class="flex gap-3">

                                            <div
                                                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-amber-100 text-amber-700">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z" />
                                                </svg>
                                            </div>

                                            <div class="min-w-0">
                                                <h3 class="text-sm font-bold text-amber-900">
                                                    Catatan Lamaran
                                                </h3>

                                                <div class="mt-3 space-y-3">

                                                    @foreach ($applicationsWithNotes->sortByDesc('created_at') as $application)
                                                        <div class="rounded-xl border border-amber-200 bg-white/70 p-3">

                                                            <p class="text-xs font-semibold text-slate-700">
                                                                {{ $application->job->title ?? 'Lowongan' }}
                                                            </p>

                                                            <p class="mt-1 text-sm leading-6 text-slate-600">
                                                                {{ $application->notes }}
                                                            </p>

                                                        </div>
                                                    @endforeach

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                @endif
                            @else
                                <div
                                    class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-10 text-center">

                                    <div
                                        class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-white text-slate-400 shadow-sm">
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h6l5 5v11a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>

                                    <h3 class="mt-4 text-sm font-bold text-slate-700">
                                        Belum Ada Riwayat Lamaran
                                    </h3>

                                    <p class="mt-1 text-sm text-slate-500">
                                        Kandidat belum memiliki data lamaran.
                                    </p>

                                </div>

                            @endif

                        </section>


                        {{-- Work Experience --}}
                        <section class="border-t border-slate-200 pt-8">

                            <div class="mb-5">
                                <h2 class="text-lg font-bold text-slate-900">
                                    Pengalaman Kerja
                                </h2>

                                <p class="mt-1 text-sm text-slate-500">
                                    Riwayat pengalaman profesional kandidat.
                                </p>
                            </div>

                            @if ($applicant->workExperiences->count())

                                <div class="space-y-4">

                                    @foreach ($applicant->workExperiences->sortByDesc(fn($exp) => [$exp->end_date ?? '9999-12-31', $exp->start_date]) as $experience)
                                        <div class="rounded-2xl border border-slate-200 p-5">

                                            <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">

                                                <div>
                                                    <h3 class="font-bold text-slate-900">
                                                        {{ $experience->position ?? '-' }}
                                                    </h3>

                                                    <p class="mt-1 text-sm font-medium text-[#B11116]">
                                                        {{ $experience->company_name ?? '-' }}
                                                    </p>

                                                    @if ($experience->division)
                                                        <p class="mt-1 text-xs text-slate-500">
                                                            {{ $experience->division }}
                                                        </p>
                                                    @endif
                                                </div>

                                                <span
                                                    class="inline-flex w-fit rounded-lg bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-600">
                                                    {{ $experience->start_date ? \Carbon\Carbon::parse($experience->start_date)->format('M Y') : '-' }}
                                                    -
                                                    {{ $experience->end_date ? \Carbon\Carbon::parse($experience->end_date)->format('M Y') : 'Sekarang' }}
                                                </span>

                                            </div>

                                            <div class="mt-4 grid gap-4 border-t border-slate-100 pt-4 sm:grid-cols-2">

                                                <div>
                                                    <p class="text-xs text-slate-400">Gaji</p>
                                                    <p class="mt-1 text-sm font-medium text-slate-700">
                                                        {{ $experience->salary ?? '-' }}
                                                    </p>
                                                </div>

                                                <div>
                                                    <p class="text-xs text-slate-400">Fasilitas</p>
                                                    <p class="mt-1 text-sm font-medium text-slate-700">
                                                        {{ $experience->facility ?? '-' }}
                                                    </p>
                                                </div>

                                                <div>
                                                    <p class="text-xs text-slate-400">Referensi</p>
                                                    <p class="mt-1 text-sm font-medium text-slate-700">
                                                        {{ $experience->reference_name ?? '-' }}
                                                    </p>
                                                </div>

                                                <div>
                                                    <p class="text-xs text-slate-400">Alasan Berhenti</p>
                                                    <p class="mt-1 text-sm font-medium text-slate-700">
                                                        {{ $experience->reason_for_leaving ?? '-' }}
                                                    </p>
                                                </div>

                                            </div>

                                        </div>
                                    @endforeach

                                </div>
                            @else
                                <div
                                    class="rounded-2xl border border-dashed border-slate-300 p-8 text-center text-sm text-slate-500">
                                    Belum ada data pengalaman kerja.
                                </div>

                            @endif

                        </section>


                        {{-- Education --}}
                        <section class="mt-8 border-t border-slate-200 pt-8">

                            <div class="mb-5">
                                <h2 class="text-lg font-bold text-slate-900">
                                    Pendidikan
                                </h2>

                                <p class="mt-1 text-sm text-slate-500">
                                    Riwayat pendidikan formal kandidat.
                                </p>
                            </div>

                            @if ($applicant->educations->count())

                                <div class="space-y-4">

                                    @foreach ($applicant->educations->sortByDesc('graduation_year') as $education)
                                        <div class="rounded-2xl border border-slate-200 p-5">

                                            <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">

                                                <div>
                                                    <span
                                                        class="inline-flex rounded-lg bg-red-50 px-2.5 py-1 text-xs font-bold text-[#B11116]">
                                                        {{ $education->degree_level ?? '-' }}
                                                    </span>

                                                    <h3 class="mt-3 font-bold text-slate-900">
                                                        {{ $education->institution_name ?? '-' }}
                                                    </h3>

                                                    <p class="mt-1 text-sm text-slate-500">
                                                        {{ $education->major ?? '-' }}
                                                    </p>
                                                </div>

                                                <div class="text-left sm:text-right">
                                                    <p class="text-xs text-slate-400">
                                                        Tahun
                                                    </p>

                                                    <p class="mt-1 text-sm font-semibold text-slate-700">
                                                        {{ $education->entry_year ?? '-' }}
                                                        -
                                                        {{ $education->graduation_year ?? 'Sekarang' }}
                                                    </p>
                                                </div>

                                            </div>

                                            @if ($education->gpa !== null)
                                                <div class="mt-4 border-t border-slate-100 pt-4">
                                                    <p class="text-xs text-slate-400">IPK / GPA</p>
                                                    <p class="mt-1 text-sm font-semibold text-slate-700">
                                                        {{ $education->gpa }}
                                                    </p>
                                                </div>
                                            @endif

                                        </div>
                                    @endforeach

                                </div>
                            @else
                                <div
                                    class="rounded-2xl border border-dashed border-slate-300 p-8 text-center text-sm text-slate-500">
                                    Belum ada data pendidikan.
                                </div>

                            @endif

                        </section>


                        {{-- Family --}}
                        <section class="mt-8 border-t border-slate-200 pt-8">

                            <div class="mb-5">
                                <h2 class="text-lg font-bold text-slate-900">
                                    Data Keluarga
                                </h2>

                                <p class="mt-1 text-sm text-slate-500">
                                    Informasi keluarga kandidat.
                                </p>
                            </div>

                            @if ($applicant->families->count())

                                <div class="overflow-hidden rounded-2xl border border-slate-200">

                                    <div class="overflow-x-auto">

                                        <table class="w-full min-w-[700px] text-left">

                                            <thead class="bg-slate-50">
                                                <tr class="border-b border-slate-200">
                                                    <th
                                                        class="px-5 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">
                                                        Nama
                                                    </th>
                                                    <th
                                                        class="px-5 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">
                                                        Hubungan
                                                    </th>
                                                    <th
                                                        class="px-5 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">
                                                        Tanggal Lahir
                                                    </th>
                                                    <th
                                                        class="px-5 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">
                                                        Pendidikan
                                                    </th>
                                                    <th
                                                        class="px-5 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">
                                                        Pekerjaan
                                                    </th>
                                                    <th
                                                        class="px-5 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">
                                                        Telepon
                                                    </th>
                                                </tr>
                                            </thead>

                                            <tbody class="divide-y divide-slate-100">

                                                @foreach ($applicant->families as $family)
                                                    <tr class="transition hover:bg-slate-50/70">

                                                        <td class="px-5 py-4 text-sm font-semibold text-slate-800">
                                                            <div class="flex items-center gap-2">
                                                                <span>{{ $family->name ?? '-' }}</span>
                                                                @if ($family->status === 'deceased')
                                                                    <span class="inline-flex rounded bg-slate-100 px-1.5 py-0.5 text-[10px] font-bold text-slate-600">Meninggal (+)</span>
                                                                @elseif ($family->status === 'divorced')
                                                                    <span class="inline-flex rounded bg-amber-100 px-1.5 py-0.5 text-[10px] font-bold text-amber-700">Cerai</span>
                                                                @endif
                                                            </div>
                                                        </td>

                                                        <td class="px-5 py-4 text-sm text-slate-600">
                                                            {{ $family->relationship ?? '-' }}
                                                        </td>

                                                        <td class="px-5 py-4 text-sm text-slate-600">
                                                            {{ $family->date_of_birth ? \Carbon\Carbon::parse($family->date_of_birth)->format('d M Y') : '-' }}
                                                        </td>

                                                        <td class="px-5 py-4 text-sm text-slate-600">
                                                            {{ $family->education ?? '-' }}
                                                        </td>

                                                        <td class="px-5 py-4 text-sm text-slate-600">
                                                            {{ $family->work ?? '-' }}
                                                        </td>

                                                        <td class="px-5 py-4 text-sm text-slate-600">
                                                            {{ $family->phone_number ?? '-' }}
                                                        </td>

                                                    </tr>
                                                @endforeach

                                            </tbody>

                                        </table>

                                    </div>

                                </div>
                            @else
                                <div
                                    class="rounded-2xl border border-dashed border-slate-300 p-8 text-center text-sm text-slate-500">
                                    Belum ada data keluarga.
                                </div>

                            @endif

                        </section>


                        {{-- Training --}}
                        <section class="mt-8 border-t border-slate-200 pt-8">

                            <div class="mb-5">
                                <h2 class="text-lg font-bold text-slate-900">
                                    Pelatihan & Sertifikasi
                                </h2>

                                <p class="mt-1 text-sm text-slate-500">
                                    Pelatihan atau sertifikasi yang pernah diikuti kandidat.
                                </p>
                            </div>

                            @if ($applicant->trainings->count())

                                <div class="grid gap-4 sm:grid-cols-2">

                                    @foreach ($applicant->trainings as $training)
                                        <div class="rounded-2xl border border-slate-200 p-5">

                                            <div class="flex items-start gap-3">

                                                <div
                                                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-red-50 text-[#B11116]">
                                                    <svg class="h-5 w-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 12.5V17l7 4 7-4v-4.5" />
                                                    </svg>
                                                </div>

                                                <div class="min-w-0">

                                                    <h3 class="font-bold text-slate-900">
                                                        {{ $training->training_name ?? '-' }}
                                                    </h3>

                                                    <p class="mt-1 text-sm text-slate-500">
                                                        {{ $training->organizer ?? '-' }}
                                                    </p>

                                                    @if ($training->finished)
                                                        <p class="mt-2 text-xs font-medium text-emerald-600">
                                                            Selesai
                                                        </p>
                                                    @endif

                                                </div>

                                            </div>

                                        </div>
                                    @endforeach

                                </div>
                            @else
                                <div
                                    class="rounded-2xl border border-dashed border-slate-300 p-8 text-center text-sm text-slate-500">
                                    Belum ada data pelatihan atau sertifikasi.
                                </div>

                            @endif

                        </section>


                        {{-- Documents --}}
                        <section class="mt-8 border-t border-slate-200 pt-8">

                            <div class="mb-5">
                                <h2 class="text-lg font-bold text-slate-900">
                                    Dokumen Pelamar
                                </h2>

                                <p class="mt-1 text-sm text-slate-500">
                                    Status kelengkapan dokumen kandidat.
                                </p>
                            </div>

                            <div class="grid gap-3 sm:grid-cols-2">

                                @foreach (['KTP', 'Ijazah', 'Transkrip Nilai', 'SKCK'] as $document)
                                    <div
                                        class="flex items-center justify-between rounded-xl border border-slate-200 bg-white p-4">

                                        <div class="flex items-center gap-3">

                                            <div
                                                class="flex h-9 w-9 items-center justify-center rounded-lg bg-slate-100 text-slate-500">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M7 21h10a2 2 0 002-2V9l-5-5H7a2 2 0 00-2 2v13a2 2 0 002 2z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M14 4v5h5" />
                                                </svg>
                                            </div>

                                            <span class="text-sm font-medium text-slate-700">
                                                {{ $document }}
                                            </span>

                                        </div>

                                        <span
                                            class="rounded-lg bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-500">
                                            Belum tersedia
                                        </span>

                                    </div>
                                @endforeach

                            </div>

                        </section>

                        {{-- Ekspektasi & Informasi Tambahan --}}
                        @if ($applicant->expectation)
                            <section class="mt-8 border-t border-slate-200 pt-8">
                                <div class="mb-5">
                                    <h2 class="text-lg font-bold text-slate-900">
                                        Ekspektasi & Informasi Tambahan
                                    </h2>
                                    <p class="mt-1 text-sm text-slate-500">
                                        Ekspektasi gaji, fasilitas, kesiapan, dan sumber informasi kandidat.
                                    </p>
                                </div>

                                <div class="grid gap-4 sm:grid-cols-2">
                                    <div class="rounded-xl border border-slate-200 bg-white p-4">
                                        <p class="text-xs text-slate-400">Ekspektasi Gaji</p>
                                        <p class="mt-1 text-sm font-semibold text-slate-800">
                                            {{ $applicant->expectation->salary_expectation ? 'Rp ' . number_format($applicant->expectation->salary_expectation, 0, ',', '.') : '-' }}
                                        </p>
                                    </div>

                                    <div class="rounded-xl border border-slate-200 bg-white p-4">
                                        <p class="text-xs text-slate-400">Sumber Informasi Lowongan</p>
                                        <p class="mt-1 text-sm font-semibold text-slate-800">
                                            {{ $applicant->expectation->job_source ?? '-' }}
                                        </p>
                                    </div>

                                    @if ($applicant->expectation->reference_by)
                                        <div class="rounded-xl border border-slate-200 bg-white p-4 sm:col-span-2">
                                            <p class="text-xs text-slate-400">Referensi Karyawan (Referral)</p>
                                            <p class="mt-1 text-sm font-semibold text-slate-800">
                                                {{ $applicant->expectation->reference_by }}
                                            </p>
                                        </div>
                                    @endif

                                    <div class="rounded-xl border border-slate-200 bg-white p-4">
                                        <p class="text-xs text-slate-400">Kesiapan Relokasi</p>
                                        <p class="mt-1 text-sm font-medium text-slate-700">
                                            {{ $applicant->expectation->ready_to_relocate ? 'Bersedia' : 'Tidak Bersedia' }}
                                        </p>
                                    </div>

                                    <div class="rounded-xl border border-slate-200 bg-white p-4">
                                        <p class="text-xs text-slate-400">Kesiapan Dinas Luar Kota</p>
                                        <p class="mt-1 text-sm font-medium text-slate-700">
                                            {{ $applicant->expectation->ready_to_travel ? 'Bersedia' : 'Tidak Bersedia' }}
                                        </p>
                                    </div>

                                    @if ($applicant->expectation->facility_expectation)
                                        <div class="rounded-xl border border-slate-200 bg-white p-4 sm:col-span-2">
                                            <p class="text-xs text-slate-400">Ekspektasi Fasilitas</p>
                                            <p class="mt-1 text-sm font-medium text-slate-700">
                                                {{ $applicant->expectation->facility_expectation }}
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </section>
                        @endif

                    </main>

                </div>

            </div>

        </div>
    </div>

    <style>
        @media print {
            @page {
                size: A4;
                margin: 12mm 10mm;
            }

            html,
            body {
                width: 100% !important;
                margin: 0 !important;
                background: white !important;
                color: #0f172a !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            body > nav,
            #top-bar-sidebar,
            .no-print,
            .alert {
                display: none !important;
            }

            body > div.p-4 {
                max-height: none !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            body > div.p-4 > div.p-4 {
                padding: 0 !important;
            }

            .applicant-show-page {
                min-height: 0 !important;
                margin: 0 !important;
                padding: 0 !important;
                background: white !important;
            }

            .applicant-show-page > .mx-auto {
                width: 100% !important;
                max-width: none !important;
                margin: 0 !important;
            }

            .print-applicant-heading {
                display: flex !important;
                align-items: flex-end;
                justify-content: space-between;
                gap: 1rem;
                margin-bottom: 1rem;
                padding-bottom: 0.75rem;
                border-bottom: 2px solid #0f172a;
            }

            .print-applicant-heading h1 {
                margin: 0;
                font-size: 18pt;
                font-weight: 800;
            }

            .print-applicant-heading p {
                margin: 0.2rem 0 0;
                font-size: 8pt;
                color: #475569;
            }

            .applicant-print-card {
                overflow: visible !important;
                border: 1px solid #cbd5e1 !important;
                border-radius: 0 !important;
                box-shadow: none !important;
            }

            .applicant-print-card > .grid {
                grid-template-columns: 30% minmax(0, 1fr) !important;
            }

            .applicant-print-card aside {
                display: block !important;
                border-right: 1px solid #cbd5e1 !important;
                border-bottom: 0 !important;
                background: #f8fafc !important;
                padding: 1rem !important;
            }

            .applicant-print-card main {
                min-width: 0 !important;
                padding: 1rem !important;
            }

            .applicant-print-card .overflow-x-auto {
                overflow: visible !important;
            }

            .applicant-print-card table {
                width: 100% !important;
                min-width: 0 !important;
                table-layout: auto !important;
                border-collapse: collapse !important;
            }

            .applicant-print-card th,
            .applicant-print-card td {
                padding: 0.35rem !important;
                font-size: 8pt !important;
                overflow-wrap: anywhere;
            }

            .applicant-print-card section,
            .applicant-print-card tr,
            .applicant-print-card .rounded-2xl {
                break-inside: avoid;
                page-break-inside: avoid;
            }

            .applicant-print-card .shadow-sm,
            .applicant-print-card .shadow,
            .applicant-print-card .shadow-md,
            .applicant-print-card .shadow-lg {
                box-shadow: none !important;
            }

            .applicant-print-card .rounded-2xl,
            .applicant-print-card .rounded-xl {
                border-radius: 0 !important;
            }
        }
    </style>

@endsection
