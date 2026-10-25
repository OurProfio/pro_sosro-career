@extends('auth.admin.layouts.index')

@section('title', 'Dashboard Rekrutmen - Sinar Sosro Gunung Slamat')

@section('content')
    <div class="flex flex-col w-full font-sans space-y-6" x-data="{ search: '' }">
        <!-- HEADER & IDENTITAS CABANG (Sesuai Standar HCI Admin) -->
        <section class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-3.5 border-b border-slate-200">
            <div class="space-y-0.5">
                <nav class="text-xs font-bold text-[#9b1b1f]">
                    <span>Portal Karir</span>
                </nav>
                <div class="flex flex-wrap items-center gap-3 pt-1">
                    <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900">Dashboard Rekrutmen</h1>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-50 border border-red-200/80 text-xs shadow-xs">
                        <span class="text-[#9b1b1f] font-bold flex items-center gap-1">
                            <span class="material-symbols-outlined text-[15px]">location_on</span>
                            {{ $officeName ?? 'Kantor Pusat' }}
                        </span>
                        <span class="w-1 h-1 rounded-full bg-red-300"></span>
                        <span class="inline-flex items-center gap-1 text-emerald-700 font-bold">
                            <span class="w-2 h-2 rounded-full bg-emerald-600 animate-pulse"></span>
                            Unit Aktif
                        </span>
                    </div>
                </div>
                <p class="text-xs text-slate-500">
                    Selamat datang kembali, <span class="font-semibold text-slate-700">{{ $adminName }}</span>. Pantau lamaran masuk dan kelola posisi aktif di unit kerja Anda.
                </p>
            </div>
        </section>

        <!-- EMPAT KARTU RINGKASAN (1 Baris Saja / 4 Grid Horizontal) -->
        <section aria-label="Ringkasan rekrutmen" class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
            <!-- Kartu 1: Pending -->
            <article class="bg-white p-5 rounded-xl border border-slate-200/90 shadow-xs flex flex-col justify-between relative overflow-hidden group hover:border-red-200 hover:shadow-md transition-all">
                <div class="absolute top-0 left-0 right-0 h-1 bg-[#A6192E]"></div>
                <div class="flex items-start justify-between gap-3">
                    <div class="flex flex-col">
                        <span class="text-xs text-slate-500 font-semibold">Perlu Dicek (Pending)</span>
                        <span class="text-2xl sm:text-3xl font-bold text-slate-900 mt-1">
                            {{ number_format($pendingApplicationsCount, 0, ',', '.') }}
                            <span class="text-sm font-normal text-slate-500">Pelamar</span>
                        </span>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-red-50 text-[#A6192E] border border-red-100 flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-[22px]">inbox</span>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between gap-2">
                    <span class="text-xs text-slate-500 truncate">{{ $isSuperAdmin ? 'Lamaran baru masuk di semua cabang' : 'Lamaran baru masuk di cabang ini' }}</span>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-red-50 text-[#A6192E] border border-red-200/70 text-[11px] font-bold shrink-0">
                        Perhatian
                    </span>
                </div>
            </article>

            <!-- Kartu 2: Progress -->
            <article class="bg-white p-5 rounded-xl border border-slate-200/90 shadow-xs flex flex-col justify-between relative overflow-hidden group hover:border-amber-200 hover:shadow-md transition-all">
                <div class="absolute top-0 left-0 right-0 h-1 bg-amber-500"></div>
                <div class="flex items-start justify-between gap-3">
                    <div class="flex flex-col">
                        <span class="text-xs text-slate-500 font-semibold">Sedang Seleksi (Progress)</span>
                        <span class="text-2xl sm:text-3xl font-bold text-slate-900 mt-1">
                            {{ number_format($inProgressApplicationsCount, 0, ',', '.') }}
                            <span class="text-sm font-normal text-slate-500">Kandidat</span>
                        </span>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-700 border border-amber-100 flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-[22px]">hourglass_top</span>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between gap-2">
                    <span class="text-xs text-slate-500 truncate">Tahap tes &amp; interview aktif</span>
                    <span class="text-[11px] text-amber-700 font-bold shrink-0">
                        Aktif Berjalan
                    </span>
                </div>
            </article>

            <!-- Kartu 3: Accepted -->
            <article class="bg-white p-5 rounded-xl border border-slate-200/90 shadow-xs flex flex-col justify-between relative overflow-hidden group hover:border-emerald-200 hover:shadow-md transition-all">
                <div class="absolute top-0 left-0 right-0 h-1 bg-emerald-600"></div>
                <div class="flex items-start justify-between gap-3">
                    <div class="flex flex-col">
                        <span class="text-xs text-slate-500 font-semibold">Diterima (Accepted)</span>
                        <span class="text-2xl sm:text-3xl font-bold text-slate-900 mt-1">
                            {{ number_format($acceptedApplicationsCount, 0, ',', '.') }}
                            <span class="text-sm font-normal text-slate-500">Orang</span>
                        </span>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-100 flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-[22px]">how_to_reg</span>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between gap-2">
                    <span class="text-xs text-slate-500 truncate">{{ $isSuperAdmin ? 'Lolos seleksi di semua cabang' : 'Lolos seleksi di cabang ini' }}</span>
                    <span class="inline-flex items-center gap-1 text-emerald-700 text-[11px] font-bold shrink-0">
                        <span class="material-symbols-outlined text-[15px]">check_circle</span>
                        Siap Onboarding
                    </span>
                </div>
            </article>

            <!-- Kartu 4: Active Jobs -->
            <article class="bg-white p-5 rounded-xl border border-slate-200/90 shadow-xs flex flex-col justify-between relative overflow-hidden group hover:border-red-200 hover:shadow-md transition-all">
                <div class="absolute top-0 left-0 right-0 h-1 bg-[#7f1d1d]"></div>
                <div class="flex items-start justify-between gap-3">
                    <div class="flex flex-col">
                        <span class="text-xs text-slate-500 font-semibold">Lowongan Aktif</span>
                        <span class="text-2xl sm:text-3xl font-bold text-slate-900 mt-1">
                            {{ number_format($activeJobsCount, 0, ',', '.') }}
                            <span class="text-sm font-normal text-slate-500">Posisi</span>
                        </span>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-rose-50 text-[#9b1b1f] border border-rose-100 flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-[22px]">work</span>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between gap-2">
                    <span class="text-xs text-slate-500 truncate">Posisi terbuka saat ini</span>
                    <span class="text-[11px] text-[#9b1b1f] font-bold truncate max-w-[130px] shrink-0">
                        {{ $officeName ?? 'Kantor Pusat' }}
                    </span>
                </div>
            </article>
        </section>

        <!-- AREA UTAMA: TEPAT 2 KOLOM (Grid 8 Kolom Kiri vs 4 Kolom Kanan) -->
        <div class="grid grid-cols-1 xl:grid-cols-12 gap-6 items-start">
            <!-- KOLOM KIRI (8 Kolom): Tabel Lamaran Terbaru -->
            <section class="xl:col-span-8 bg-white rounded-xl border border-slate-200/90 shadow-xs flex flex-col overflow-hidden">
                <!-- Header Tabel -->
                <div class="p-5 sm:px-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-2.5">
                        <h2 class="text-base sm:text-lg font-bold text-slate-900">
                            {{ $isSuperAdmin ? 'Lamaran Masuk Terbaru (Semua Cabang)' : 'Lamaran Terbaru di Cabang Ini' }}
                        </h2>
                        <span class="px-2.5 py-0.5 rounded-full bg-red-50 text-[#A6192E] border border-red-200/60 text-[11px] font-bold">
                            {{ $recentApplications->count() }} Data Terkini
                        </span>
                    </div>

                    <!-- Input Pencarian Simpel -->
                    <div class="relative w-full sm:w-64">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-[18px]">search</span>
                        <input
                            x-model="search"
                            type="text"
                            placeholder="Cari nama atau posisi..."
                            class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-xs pl-9 pr-3 py-2 rounded-lg outline-none focus:bg-white focus:border-[#A6192E] focus:ring-2 focus:ring-[#A6192E]/15 transition"
                        />
                    </div>
                </div>

                @if ($recentApplications->isNotEmpty())
                    <!-- Tabel Responsif -->
                    <div class="w-full overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50/90 border-b border-slate-200/80 text-slate-500 text-[11px] uppercase tracking-wider">
                                    <th class="py-3 px-6 font-bold">Pelamar</th>
                                    <th class="py-3 px-4 font-bold">Posisi Dilamar</th>
                                    <th class="py-3 px-4 font-bold text-center">Tahap Saat Ini</th>
                                    <th class="py-3 px-4 font-bold text-center">Tanggal Lamar</th>
                                    <th class="py-3 px-6 font-bold text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-sm text-slate-800">
                                @foreach ($recentApplications as $index => $application)
                                    @php
                                        $applicantName = $application->applicant?->name ?? 'Pelamar';
                                        $nameParts = preg_split('/\s+/', trim($applicantName)) ?: [];
                                        $initials = strtoupper(
                                            substr($nameParts[0] ?? 'P', 0, 1) .
                                            (isset($nameParts[1]) ? substr($nameParts[1], 0, 1) : '')
                                        );

                                        $latestEducation = $application->applicant?->educations
                                            ?->sortByDesc('graduation_year')
                                            ->first();

                                        $educationLabel = $latestEducation
                                            ? trim(($latestEducation->degree_level ?? '') . ' ' . ($latestEducation->major ?? ''))
                                            : ($application->applicant?->email ?? '-');

                                        $jobTitle = $application->job?->title ?? 'Lowongan tidak tersedia';
                                        $jobCategory = match (strtolower((string) ($application->job?->category ?? ''))) {
                                            'profesional', 'professional' => 'Profesional',
                                            'mt', 'management_trainee', 'management trainee' => 'Management Trainee',
                                            'internship', 'magang' => 'Internship',
                                            default => $application->job?->category ? ucfirst($application->job->category) : 'Profesional',
                                        };

                                        $stageName = $application->stage?->name ?? 'Screening CV';
                                        $badgeStyle = match ($application->status) {
                                            'pending' => 'bg-amber-50 text-amber-800 border-amber-200/80',
                                            'progress' => 'bg-red-50 text-[#A6192E] border-red-200/80',
                                            'accepted' => 'bg-emerald-50 text-emerald-700 border-emerald-200/80',
                                            'rejected' => 'bg-rose-100 text-rose-800 border-rose-200',
                                            default => 'bg-slate-100 text-slate-700 border-slate-200',
                                        };

                                        $avatarColors = [
                                            'bg-red-50 text-[#A6192E] border-red-200/70',
                                            'bg-rose-50 text-rose-800 border-rose-200/70',
                                            'bg-amber-50 text-amber-800 border-amber-200/70',
                                            'bg-emerald-50 text-emerald-800 border-emerald-200/70',
                                            'bg-slate-100 text-slate-700 border-slate-200',
                                        ];
                                        $avatarClass = $avatarColors[$index % count($avatarColors)];

                                        $searchHaystack = strtolower($applicantName . ' ' . $educationLabel . ' ' . $jobTitle . ' ' . $stageName);
                                    @endphp
                                    <tr
                                        x-show="!search || {{ Js::from($searchHaystack) }}.includes(search.toLowerCase())"
                                        class="hover:bg-red-50/30 transition-colors"
                                    >
                                        <td class="py-3.5 px-6">
                                            <div class="flex items-center gap-3">
                                                <div class="w-9 h-9 rounded-full border {{ $avatarClass }} text-xs flex items-center justify-center font-semibold shrink-0">
                                                    {{ $initials }}
                                                </div>
                                                <div class="flex flex-col min-w-0">
                                                    <span class="font-bold text-slate-900 truncate">{{ $applicantName }}</span>
                                                    <span class="text-xs text-slate-500 truncate">{{ $educationLabel }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-4">
                                            <div class="flex flex-col">
                                                <span class="font-semibold text-slate-800">{{ $jobTitle }}</span>
                                                <span class="text-[11px] font-medium text-slate-500">{{ $jobCategory }}</span>
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-4 text-center">
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full border text-[11px] font-bold {{ $badgeStyle }}">
                                                {{ $stageName }}
                                            </span>
                                        </td>
                                        <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                            <span class="text-xs text-slate-500 font-medium">
                                                {{ $application->created_at?->translatedFormat('d M Y, H:i') ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="py-3.5 px-6 text-center">
                                            @if ($application->applicant)
                                                <a href="{{ route('applicant.show', $application->applicant) }}"
                                                    class="inline-flex items-center justify-center px-3 py-1.5 rounded-lg bg-red-50 hover:bg-[#A6192E] text-[#A6192E] hover:text-white border border-red-200/70 hover:border-[#A6192E] text-xs font-bold transition-colors">
                                                    Lihat Detail
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
                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-red-50 text-[#A6192E]">
                            <span class="material-symbols-outlined text-[24px]">inbox</span>
                        </div>
                        <p class="mt-3 text-sm font-bold text-slate-800">Belum ada lamaran</p>
                        <p class="mt-1 text-xs text-slate-500">Lamaran baru yang masuk di unit kerja ini akan tampil di sini.</p>
                    </div>
                @endif

                <!-- Footer Tabel -->
                <div class="px-6 py-3.5 bg-slate-50/70 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-slate-500 text-xs font-medium">
                    <span>
                        Menampilkan {{ $recentApplications->count() }} pelamar teratas dari total {{ number_format($totalApplicationsCount, 0, ',', '.') }} lamaran masuk
                    </span>
                    <a href="{{ route('applicant.index') }}"
                        class="text-[#A6192E] hover:text-[#7f1d1d] font-bold inline-flex items-center gap-1 transition-colors">
                        <span>Lihat Semua Pelamar</span>
                        <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                    </a>
                </div>
            </section>

            <!-- KOLOM KANAN (4 Kolom): Lowongan Segera Berakhir -->
            <section class="xl:col-span-4 bg-white rounded-xl border border-slate-200/90 shadow-xs flex flex-col p-5 sm:p-6">
                <!-- Header Card -->
                <div class="flex items-center justify-between gap-3 pb-4 border-b border-slate-100">
                    <div class="flex items-center gap-2.5 min-w-0">
                        <div class="w-8 h-8 rounded-lg bg-red-50 text-[#A6192E] border border-red-100 flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-[20px]">timer</span>
                        </div>
                        <h2 class="text-base font-bold text-slate-900 truncate">Lowongan Segera Berakhir</h2>
                    </div>
                    <span class="whitespace-nowrap shrink-0 min-w-max px-2.5 py-1 rounded-md bg-red-50 text-[#A6192E] border border-red-200/70 text-[11px] font-bold">
                        Tutup &le; 7 Hari
                    </span>
                </div>

                <!-- List Item Lowongan -->
                @if ($closingSoonJobs->isNotEmpty())
                    <div class="flex flex-col gap-3 pt-4">
                        @foreach ($closingSoonJobs as $job)
                            @php
                                $daysRemaining = max(0, (int) today()->diffInDays(\Carbon\Carbon::parse($job->closing_date)->startOfDay(), false));
                                $countdownBadgeClass = match (true) {
                                    $daysRemaining <= 2 => 'bg-[#A6192E] text-white',
                                    $daysRemaining <= 4 => 'bg-amber-100 text-amber-900 border border-amber-200',
                                    default => 'bg-red-50 text-[#9b1b1f] border border-red-200/70',
                                };
                                $countdownLabel = $daysRemaining === 0 ? 'Hari ini' : $daysRemaining . ' hari lagi';
                            @endphp
                            <div class="p-4 rounded-xl bg-slate-50/80 hover:bg-red-50/40 border border-slate-200/70 hover:border-red-200 transition-all flex flex-col gap-2 group">
                                <div class="flex items-start justify-between gap-2">
                                    <a href="{{ route('job.show', $job) }}"
                                        class="text-sm font-bold text-slate-900 group-hover:text-[#A6192E] transition-colors line-clamp-1">
                                        {{ $job->title }}
                                    </a>
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[11px] font-bold shrink-0 {{ $countdownBadgeClass }}">
                                        <span>⏰ {{ $countdownLabel }}</span>
                                    </span>
                                </div>

                                <div class="flex items-center justify-between text-xs text-slate-500">
                                    <span class="flex items-center gap-1 text-slate-700 font-semibold">
                                        <span class="material-symbols-outlined text-[16px] text-[#A6192E]">group</span>
                                        {{ number_format($job->applications_count, 0, ',', '.') }} pelamar
                                    </span>
                                    <span class="truncate max-w-[140px]">{{ $job->office?->name ?? ($officeName ?? 'Unit Cabang') }}</span>
                                </div>

                                <div class="pt-1.5 border-t border-slate-200/60 flex justify-between items-center">
                                    <span class="text-[11px] text-slate-400">
                                        Tutup {{ \Carbon\Carbon::parse($job->closing_date)->translatedFormat('d M Y') }}
                                    </span>
                                    <a href="{{ route('job.show', $job) }}"
                                        class="text-[#A6192E] hover:text-[#7f1d1d] text-xs font-bold inline-flex items-center gap-0.5">
                                        <span>Cek Pelamar</span>
                                        <span class="material-symbols-outlined text-[15px]">chevron_right</span>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="py-8 text-center">
                        <div class="mx-auto flex h-10 w-10 items-center justify-center rounded-xl bg-slate-100 text-slate-400">
                            <span class="material-symbols-outlined text-[20px]">event_available</span>
                        </div>
                        <p class="mt-2.5 text-sm font-bold text-slate-800">Tidak ada lowongan yang segera berakhir</p>
                        <p class="mt-1 text-xs leading-5 text-slate-500">Lowongan aktif yang akan tutup dalam 7 hari ke depan akan tampil di sini.</p>
                    </div>
                @endif
            </section>
        </div>
    </div>
@endsection
