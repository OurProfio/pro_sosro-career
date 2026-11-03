{{--
    Detail profil kandidat, dipakai halaman admin dan halaman detail konfirmasi user.
    Butuh: $applicant, $latestApplication, $stages, $interestNames; $isPublic menyembunyikan link khusus admin.
--}}
@php
    $latestApplication = $latestApplication ?? $applicant->applications->sortByDesc('created_at')->first();
    $stages = $stages ?? collect();

    $age = $applicant->date_of_birth ? \Carbon\Carbon::parse($applicant->date_of_birth)->age : null;
    $genderLabel = match (strtolower((string) $applicant->gender)) {
        'l' => 'Laki-laki',
        'p' => 'Perempuan',
        default => '-',
    };

    $maritalLabel = match ($applicant->marital_status) {
        'single' => 'Belum Menikah',
        'married' => 'Menikah',
        'divorced' => 'Cerai',
        'widowed' => 'Duda/Janda',
        default => '-',
    };

    $rawPhone = preg_replace('/[^0-9]/', '', (string) $applicant->phone_number);
    $waPhone = str_starts_with($rawPhone, '0') ? '62' . substr($rawPhone, 1) : $rawPhone;

    $sosroExp = $applicant->workExperiences->first(function ($exp) {
        $company = strtolower((string) $exp->company_name);
        return str_contains($company, 'sosro') || str_contains($company, 'gunung slamat') || str_contains($company, 'rekso');
    });

    $bmi = null;
    $bmiStatus = null;
    if ($applicant->height > 0 && $applicant->weight > 0) {
        $heightM = $applicant->height / 100;
        $bmi = round($applicant->weight / ($heightM * $heightM), 1);
        $bmiStatus = match (true) {
            $bmi < 18.5 => 'Kurang',
            $bmi <= 24.9 => 'Ideal',
            $bmi <= 29.9 => 'Berlebih',
            default => 'Obesitas',
        };
    }

    $licenses = is_array($applicant->driver_licenses)
        ? array_filter($applicant->driver_licenses)
        : (filled($applicant->driver_licenses) ? [$applicant->driver_licenses] : []);

    $totalMonths = 0;
    foreach ($applicant->workExperiences as $exp) {
        if ($exp->start_date) {
            $start = \Carbon\Carbon::parse($exp->start_date);
            $end = $exp->end_date ? \Carbon\Carbon::parse($exp->end_date) : now();
            if ($end->greaterThanOrEqualTo($start)) {
                $totalMonths += $start->diffInMonths($end);
            }
        }
    }
    $totalYears = intdiv((int) $totalMonths, 12);
    $remMonths = ((int) $totalMonths) % 12;
    $totalExpText = $totalMonths > 0
        ? trim(($totalYears > 0 ? $totalYears . ' Tahun ' : '') . ($remMonths > 0 ? $remMonths . ' Bulan' : ''))
        : 'Fresh Graduate';

    $interests = $applicant->interest?->interests;
    $interests = is_array($interests) ? array_slice($interests, 0, 5) : (filled($interests) ? [$interests] : []);
@endphp

<!-- COMPACT TWO-COLUMN GRID ARCHITECTURE -->
<div class="grid grid-cols-1 xl:grid-cols-12 gap-4 items-start mt-3.5">
    <!-- LEFT SIDEBAR: PROFILE, CONTACT, & BIODATA -->
    <div class="xl:col-span-4 space-y-3.5">
        <!-- Candidate Main Card -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-2xs p-4 relative overflow-hidden">
            <div class="flex items-center gap-3.5">
                <!-- Profile Photo -->
                <div class="relative shrink-0">
                    @if ($applicant->photo_url)
                        <img class="w-20 h-20 rounded-xl object-cover border border-slate-200 shadow-2xs"
                            src="{{ asset('storage/' . $applicant->photo_url) }}" alt="{{ $applicant->name }}">
                    @else
                        <div class="w-20 h-20 rounded-xl bg-red-50 text-[#9b1b1f] border border-red-100 flex items-center justify-center text-2xl font-bold shadow-2xs">
                            {{ strtoupper(substr($applicant->name ?? 'A', 0, 1)) }}
                        </div>
                    @endif
                    @if ($applicant->nik)
                        <span class="absolute -bottom-1 -right-1 bg-[#9b1b1f] text-white p-0.5 rounded shadow" title="Terverifikasi NIK & Biodata">
                            <span class="material-symbols-outlined text-[13px] block">verified</span>
                        </span>
                    @endif
                </div>

                <div class="min-w-0 flex-1">
                    <div class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold bg-red-50 text-[#9b1b1f] border border-red-100 mb-1">
                        <span class="w-1 h-1 rounded-full bg-[#9b1b1f]"></span>
                        {{ $applicant->nik ? 'Terverifikasi NIK & Berkas' : 'Biodata Pelamar' }}
                    </div>
                    <h2 class="text-base font-bold text-slate-900 leading-tight truncate" title="{{ $applicant->name }}">
                        {{ $applicant->name }}
                    </h2>
                    <p class="text-xs text-slate-500 mt-0.5">
                        {{ $age ? $age . ' Tahun' : 'Usia -' }} • {{ $genderLabel }}
                    </p>
                    <div class="mt-1.5 inline-flex items-center gap-1 px-2 py-0.5 rounded bg-slate-100 text-slate-700 text-[10px] font-semibold border border-slate-200">
                        <span class="material-symbols-outlined text-[#9b1b1f] text-[13px]">verified_user</span>
                        @if ($sosroExp)
                            Eks {{ $sosroExp->company_name }}
                        @elseif ($applicant->has_applied_sosro === 'y')
                            Pernah Melamar Sosro ({{ $applicant->previous_applied_year ?? '-' }})
                        @else
                            Pelamar Baru (Non-Alumni)
                        @endif
                    </div>
                </div>
            </div>

            <!-- Quick Contacts List (Dense) -->
            <div class="mt-3 pt-3 border-t border-slate-100 space-y-1.5">
                <div class="flex items-center justify-between text-xs py-1 px-2 rounded-lg bg-slate-50 border border-slate-100">
                    <div class="flex items-center gap-2 min-w-0">
                        <span class="material-symbols-outlined text-[14px] text-slate-500">mail</span>
                        <span class="font-medium text-slate-700 truncate text-[11px]">{{ $applicant->email ?? '-' }}</span>
                    </div>
                    @if ($applicant->email)
                        <button class="text-slate-400 hover:text-[#9b1b1f] transition-colors p-0.5"
                            onclick="navigator.clipboard.writeText('{{ $applicant->email }}')" title="Salin Email" type="button">
                            <span class="material-symbols-outlined text-[14px]">content_copy</span>
                        </button>
                    @endif
                </div>

                <div class="flex items-center justify-between text-xs py-1 px-2 rounded-lg bg-slate-50 border border-slate-100">
                    <div class="flex items-center gap-2 min-w-0">
                        <span class="material-symbols-outlined text-[14px] text-[#9b1b1f]">chat</span>
                        <span class="font-semibold text-slate-800 truncate text-[11px]">{{ $applicant->phone_number ?? '-' }}</span>
                    </div>
                    @if ($waPhone)
                        <a class="px-2 py-0.5 rounded text-[10px] font-bold bg-[#9b1b1f] text-white hover:bg-[#83161a] transition-colors shrink-0"
                            href="https://wa.me/{{ $waPhone }}" target="_blank" rel="noopener noreferrer">
                            Chat WA
                        </a>
                    @endif
                </div>

                @if ($applicant->linkedin)
                    <div class="flex items-center justify-between text-xs py-1 px-2 rounded-lg bg-slate-50 border border-slate-100">
                        <div class="flex items-center gap-2 min-w-0">
                            <span class="material-symbols-outlined text-[14px] text-slate-600">work</span>
                            <span class="font-medium text-slate-700 truncate text-[11px]">{{ $applicant->linkedin }}</span>
                        </div>
                        <a class="text-slate-400 hover:text-[#9b1b1f] p-0.5 transition-colors"
                            href="{{ str_starts_with($applicant->linkedin, 'http') ? $applicant->linkedin : 'https://' . $applicant->linkedin }}"
                            target="_blank" rel="noopener noreferrer">
                            <span class="material-symbols-outlined text-[14px]">open_in_new</span>
                        </a>
                    </div>
                @endif

                @if ($applicant->instagram)
                    <div class="flex items-center justify-between text-xs py-1 px-2 rounded-lg bg-slate-50 border border-slate-100">
                        <div class="flex items-center gap-2 min-w-0">
                            <span class="material-symbols-outlined text-[14px] text-slate-600">alternate_email</span>
                            <span class="font-medium text-slate-700 truncate text-[11px]">{{ $applicant->instagram }}</span>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Biodata Fisik & Sipil (Dense) -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-2xs p-3.5 space-y-2.5">
            <div class="flex items-center justify-between pb-1.5 border-b border-slate-100">
                <h3 class="text-[11px] font-bold uppercase tracking-wider text-slate-500 flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-[#9b1b1f] text-[15px]">badge</span>
                    Data Pribadi &amp; Fisik
                </h3>
                <span class="text-[9px] font-bold text-slate-500 bg-slate-100 px-1.5 py-0.5 rounded border border-slate-200">e-KTP</span>
            </div>

            <div class="space-y-2 text-xs">
                <div class="flex items-center justify-between py-1 px-2 bg-slate-50 rounded border border-slate-100">
                    <span class="text-slate-500 text-[11px]">NIK KTP</span>
                    <div class="flex items-center gap-1">
                        <span class="font-mono font-bold text-slate-800 text-[11px]">
                            {{ $applicant->nik ?? '-' }}
                        </span>
                        @if ($applicant->nik)
                            <button class="text-slate-400 hover:text-slate-700"
                                onclick="navigator.clipboard.writeText('{{ $applicant->nik }}')" title="Salin NIK" type="button">
                                <span class="material-symbols-outlined text-[13px]">content_copy</span>
                            </button>
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-1.5 text-[11px]">
                    <div class="p-1.5 rounded bg-slate-50 border border-slate-100">
                        <span class="text-[9px] text-slate-400 block font-semibold">TTL</span>
                        <span class="font-bold text-slate-800">
                            {{ $applicant->place_of_birth ?? '-' }}{{ $applicant->date_of_birth ? ', ' . \Carbon\Carbon::parse($applicant->date_of_birth)->translatedFormat('d M Y') : '' }}
                        </span>
                    </div>
                    <div class="p-1.5 rounded bg-slate-50 border border-slate-100">
                        <span class="text-[9px] text-slate-400 block font-semibold">Agama</span>
                        <span class="font-bold text-slate-800">{{ $applicant->religion_name ?? $applicant->religion ?? '-' }}</span>
                    </div>
                    <div class="p-1.5 rounded bg-slate-50 border border-slate-100">
                        <span class="text-[9px] text-slate-400 block font-semibold">Status Pernikahan</span>
                        <span class="font-bold text-slate-800">{{ $maritalLabel }}</span>
                    </div>
                    <div class="p-1.5 rounded bg-slate-50 border border-slate-100">
                        <span class="text-[9px] text-slate-400 block font-semibold">Golongan Darah</span>
                        <span class="font-bold text-[#9b1b1f]">{{ $applicant->blood_type ? 'Golongan ' . strtoupper($applicant->blood_type) : '-' }}</span>
                    </div>
                </div>

                <!-- Metrik Fisik & Lisensi -->
                <div class="p-2 rounded bg-slate-50 border border-slate-100">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-slate-600 font-medium text-[10px]">Postur Fisik</span>
                        @if ($bmi)
                            <span class="px-1.5 py-0.5 rounded text-[9px] font-bold bg-red-50 text-[#9b1b1f] border border-red-100">
                                BMI: {{ $bmi }} ({{ $bmiStatus }})
                            </span>
                        @endif
                    </div>
                    <div class="flex items-center justify-around text-center pt-0.5">
                        <div>
                            <p class="text-[9px] text-slate-400">Tinggi</p>
                            <p class="text-xs font-bold text-slate-800">
                                {{ $applicant->height ?? '-' }} <span class="text-[9px] font-normal text-slate-500">cm</span>
                            </p>
                        </div>
                        <div class="h-4 w-px bg-slate-200"></div>
                        <div>
                            <p class="text-[9px] text-slate-400">Berat</p>
                            <p class="text-xs font-bold text-slate-800">
                                {{ $applicant->weight ?? '-' }} <span class="text-[9px] font-normal text-slate-500">kg</span>
                            </p>
                        </div>
                        <div class="h-4 w-px bg-slate-200"></div>
                        <div>
                            <p class="text-[9px] text-slate-400">Lisensi</p>
                            <div class="flex flex-wrap gap-1 justify-center mt-0.5">
                                @forelse ($licenses as $sim)
                                    <span class="px-1 py-0.5 bg-slate-200 text-slate-800 font-bold rounded text-[9px]">
                                        {{ str_starts_with(strtoupper($sim), 'SIM') ? strtoupper($sim) : 'SIM ' . strtoupper($sim) }}
                                    </span>
                                @empty
                                    <span class="text-[10px] font-semibold text-slate-400">-</span>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kebiasaan & Medis -->
                <div class="flex flex-wrap gap-1.5 pt-0.5">
                    @php
                        $isSmoker = in_array(strtolower((string) $applicant->is_smoker), ['1', 'y', 'yes', 'true'], true);
                        $hasTattoo = in_array(strtolower((string) $applicant->has_tattoo), ['1', 'y', 'yes', 'true'], true);
                    @endphp
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-semibold {{ $isSmoker ? 'bg-slate-100 text-slate-700 border-slate-200' : 'bg-red-50 text-[#9b1b1f] border-red-100' }} border">
                        <span class="material-symbols-outlined text-[12px]">{{ $isSmoker ? 'smoking_rooms' : 'smoke_free' }}</span>
                        {{ $isSmoker ? 'Perokok' : 'Tidak Merokok' }}
                    </span>
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                        <span class="material-symbols-outlined text-[12px]">check_circle</span>
                        {{ $hasTattoo ? 'Bertato' : 'Bebas Tato' }}
                    </span>
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-semibold bg-red-50 text-[#9b1b1f] border border-red-100">
                        <span class="material-symbols-outlined text-[12px]">health_and_safety</span>
                        {{ filled($applicant->medical_history) ? $applicant->medical_history : 'Tidak Ada Riwayat Penyakit' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Alamat Lengkap (Compact) -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-2xs p-3.5 space-y-2">
            <h3 class="text-[11px] font-bold uppercase tracking-wider text-slate-500 flex items-center gap-1.5 pb-1 border-b border-slate-100">
                <span class="material-symbols-outlined text-[#9b1b1f] text-[15px]">home_pin</span>
                Data Alamat
            </h3>
            <div class="space-y-1.5 text-xs">
                <div class="p-2 rounded bg-slate-50 border border-slate-100">
                    <span class="text-[9px] font-bold uppercase tracking-wider text-slate-400 block mb-0.5">Sesuai KTP</span>
                    <p class="text-slate-800 leading-snug font-medium text-[11px]">
                        {{ $applicant->address_ktp ?? '-' }}
                        @if ($applicant->postal_code_ktp)
                            <span class="text-slate-500">({{ $applicant->postal_code_ktp }})</span>
                        @endif
                    </p>
                </div>
                <div class="p-2 rounded bg-red-50/50 border border-red-100 text-slate-800">
                    <div class="flex items-center justify-between mb-0.5">
                        <span class="text-[9px] font-bold uppercase tracking-wider text-[#9b1b1f]">Domisili Sekarang</span>
                        @if ($applicant->postal_code_domisili)
                            <span class="text-[9px] font-bold text-[#9b1b1f] bg-red-100 px-1.5 py-0.5 rounded">
                                Kode Pos {{ $applicant->postal_code_domisili }}
                            </span>
                        @endif
                    </div>
                    <p class="leading-snug font-medium text-[11px]">
                        {{ $applicant->address_domisili ?? '-' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Minat Pekerjaan / Divisi (Compact) -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-2xs p-3.5 space-y-2">
            <div class="flex items-center justify-between pb-1 border-b border-slate-100">
                <h3 class="text-[11px] font-bold uppercase tracking-wider text-slate-500 flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-[#9b1b1f] text-[15px]">target</span>
                    Prioritas Minat Karir
                </h3>
                <span class="text-[10px] font-medium text-slate-400">Top 5</span>
            </div>

            @if (count($interests))
                <div class="space-y-1.5">
                    @foreach ($interests as $idx => $interest)
                        @php
                            $interestLabel = is_array($interest) ? ($interest['name'] ?? '-') : ($interestNames->get((int) $interest, $interest));
                            $isFirst = $idx === 0;
                        @endphp
                        @if ($isFirst)
                            <div class="flex items-center justify-between p-2 rounded bg-red-50 text-[#9b1b1f] border border-red-200 font-bold text-[11px]">
                                <div class="flex items-center gap-2 min-w-0">
                                    <span class="w-4 h-4 rounded-full bg-[#9b1b1f] text-white flex items-center justify-center text-[9px] shrink-0">1</span>
                                    <span class="truncate">{{ $interestLabel }}</span>
                                </div>
                                <span class="text-[9px] font-bold uppercase tracking-wider px-1.5 py-0.5 bg-[#9b1b1f] text-white rounded shrink-0">Prioritas</span>
                            </div>
                        @else
                            <div class="flex items-center justify-between p-1.5 rounded bg-slate-50 text-slate-800 font-medium text-[11px] border border-slate-100">
                                <div class="flex items-center gap-2 min-w-0">
                                    <span class="w-4 h-4 rounded-full bg-slate-200 text-slate-700 flex items-center justify-center text-[9px] shrink-0">{{ $idx + 1 }}</span>
                                    <span class="truncate">{{ $interestLabel }}</span>
                                </div>
                                <span class="text-[9px] text-slate-400 shrink-0">Pilihan {{ $idx + 1 }}</span>
                            </div>
                        @endif
                    @endforeach
                </div>
            @else
                <p class="text-xs text-slate-400 py-2 text-center">Belum ada minat divisi yang dipilih.</p>
            @endif
        </div>
    </div>

    <!-- RIGHT MAIN CONTENT: COMPREHENSIVE HISTORY -->
    <div class="xl:col-span-8 space-y-3.5">
        <!-- 1. CARD: Riwayat Lamaran (Latest Application Only) -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-2xs p-4 relative overflow-hidden">
            @if ($latestApplication)
                @php
                    $statusBadge = match ($latestApplication->status) {
                        'accepted' => ['label' => 'Diterima', 'class' => 'bg-emerald-50 text-emerald-700 border-emerald-200', 'dot' => 'bg-emerald-600'],
                        'rejected' => ['label' => 'Ditolak', 'class' => 'bg-red-50 text-red-700 border-red-200', 'dot' => 'bg-red-600'],
                        'cancelled' => ['label' => 'Dibatalkan', 'class' => 'bg-slate-100 text-slate-600 border-slate-200', 'dot' => 'bg-slate-400'],
                        'progress' => ['label' => 'Sedang Diproses', 'class' => 'bg-red-50 text-[#9b1b1f] border-red-200', 'dot' => 'bg-[#9b1b1f] animate-pulse'],
                        default => ['label' => 'Menunggu Review', 'class' => 'bg-amber-50 text-amber-700 border-amber-200', 'dot' => 'bg-amber-500 animate-pulse'],
                    };

                    $currentStep = $latestApplication->stage?->step ?? 1;
                    $totalSteps = $stages->count() ?: 5;
                    $progressPercent = $totalSteps > 0 ? (int) round(($currentStep / $totalSteps) * 100) : 0;
                @endphp

                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-3 border-b border-slate-100">
                    <div>
                        <div class="flex items-center gap-1.5 mb-1">
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-red-100 text-[#9b1b1f]">LAMARAN TERBARU</span>
                            <span class="text-[11px] text-slate-400">
                                • {{ $latestApplication->created_at ? $latestApplication->created_at->translatedFormat('d F Y, H:i') . ' WIB' : '-' }}
                            </span>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 tracking-tight">
                            {{ $latestApplication->job?->title ?? 'Lowongan Tidak Tersedia' }}
                        </h3>
                        @if ($latestApplication->job)
                            <p class="text-xs font-semibold text-slate-600 mt-0.5 flex flex-wrap items-center gap-2">
                                <span class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[13px] text-slate-400">factory</span>
                                    {{ $latestApplication->job->office?->name ?? $latestApplication->job->location ?? '-' }}
                                </span>
                                <span>•</span>
                                <span class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[13px] text-slate-400">engineering</span>
                                    {{ $latestApplication->job->occupation ?? ucwords(str_replace('_', ' ', $latestApplication->job->category ?? '-')) }}
                                </span>
                                @if ($latestApplication->job->type)
                                    <span>•</span>
                                    <span class="text-[#9b1b1f] font-bold">{{ $latestApplication->job->type }}</span>
                                @endif
                            </p>
                        @endif
                    </div>

                    <div class="flex sm:flex-col items-end gap-1 shrink-0">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold border {{ $statusBadge['class'] }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $statusBadge['dot'] }}"></span>
                            {{ $statusBadge['label'] }}
                        </span>
                        @if ($latestApplication->job && ! ($isPublic ?? false))
                            <a class="no-print text-[11px] font-bold text-[#9b1b1f] hover:underline inline-flex items-center gap-0.5"
                                href="{{ route('job.show', $latestApplication->job) }}">
                                Detail Lowongan
                                <span class="material-symbols-outlined text-[13px]">arrow_forward</span>
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Hiring Pipeline Progress Tracker -->
                @if ($stages->count())
                    <div class="py-3">
                        <div class="flex items-center justify-between text-xs mb-2">
                            <span class="font-bold text-slate-800 text-[11px]">Pipeline Seleksi Rekrutmen</span>
                            <span class="font-semibold text-[#9b1b1f] text-[11px]">
                                Tahap {{ $currentStep }} dari {{ $totalSteps }} ({{ $progressPercent }}%)
                            </span>
                        </div>
                        @php
                            $stageColsClass = match (min($stages->count(), 5)) {
                                1 => 'sm:grid-cols-1',
                                2 => 'sm:grid-cols-2',
                                3 => 'sm:grid-cols-3',
                                4 => 'sm:grid-cols-4',
                                default => 'sm:grid-cols-5',
                            };
                        @endphp
                        <div class="grid grid-cols-2 {{ $stageColsClass }} gap-1.5">
                            @foreach ($stages as $stageItem)
                                @php
                                    $isPassed = $latestApplication->stage && $stageItem->step < $latestApplication->stage->step;
                                    $isCurrent = $latestApplication->stage && $stageItem->id === $latestApplication->stage->id;
                                @endphp
                                @if ($isCurrent)
                                    <div class="p-2 rounded-lg bg-[#9b1b1f] text-white shadow-2xs">
                                        <div class="flex items-center gap-1 text-[10px] font-bold">
                                            <span class="material-symbols-outlined text-[13px] text-red-200">timer</span>
                                            <span class="truncate">{{ ucwords($stageItem->name) }}</span>
                                        </div>
                                        <p class="text-[9px] text-red-100 mt-0.5 font-bold">Tahap Saat Ini</p>
                                    </div>
                                @elseif ($isPassed)
                                    <div class="p-2 rounded-lg bg-red-50 text-slate-800 border border-red-100">
                                        <div class="flex items-center gap-1 text-[10px] font-bold text-[#9b1b1f]">
                                            <span class="material-symbols-outlined text-[13px]">check_circle</span>
                                            <span class="truncate">{{ ucwords($stageItem->name) }}</span>
                                        </div>
                                        <p class="text-[9px] text-slate-600 mt-0.5 font-medium">Lolos Tahap</p>
                                    </div>
                                @else
                                    <div class="p-2 rounded-lg bg-slate-50 text-slate-400 border border-slate-100">
                                        <div class="flex items-center gap-1 text-[10px] font-semibold">
                                            <span class="material-symbols-outlined text-[13px]">radio_button_unchecked</span>
                                            <span class="truncate">{{ ucwords($stageItem->name) }}</span>
                                        </div>
                                        <p class="text-[9px] mt-0.5 text-slate-400">Menunggu</p>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- HR Notes Box (Compact) -->
                <div class="p-2.5 rounded-lg bg-slate-50 border border-slate-200 flex items-start gap-2.5 {{ $stages->count() ? '' : 'mt-3' }}">
                    <span class="material-symbols-outlined text-[#9b1b1f] text-[17px] mt-0.5">sticky_note_2</span>
                    <div class="text-xs min-w-0 flex-1">
                        <span class="font-bold text-slate-800 text-[11px]">Catatan HR Reviewer:</span>
                        <p class="text-slate-600 leading-snug mt-0.5 text-[11px]">
                            {{ filled($latestApplication->notes) ? '"' . $latestApplication->notes . '"' : 'Belum ada catatan khusus untuk lamaran terbaru kandidat ini.' }}
                        </p>
                    </div>
                </div>
            @else
                <div class="py-6 text-center">
                    <span class="material-symbols-outlined text-slate-300 text-3xl">work_off</span>
                    <h3 class="text-sm font-bold text-slate-700 mt-1">Belum Ada Riwayat Lamaran</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Kandidat ini belum melamar pada lowongan pekerjaan manapun.</p>
                </div>
            @endif
        </div>

        <!-- 2. CARD: Pengalaman Kerja (Compact) -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-2xs p-4 space-y-3">
            <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <span class="w-6 h-6 rounded bg-red-50 flex items-center justify-center text-[#9b1b1f]">
                        <span class="material-symbols-outlined text-[16px]">business_center</span>
                    </span>
                    <h3 class="text-sm font-bold text-slate-900">Riwayat Pengalaman Kerja</h3>
                </div>
                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-700 border border-slate-200">
                    Total: {{ $totalExpText }}
                </span>
            </div>

            @if ($applicant->workExperiences->count())
                <div class="space-y-2.5">
                    @foreach ($applicant->workExperiences->sortByDesc(fn($exp) => [$exp->end_date ?? '9999-12-31', $exp->start_date]) as $experience)
                        @php
                            $compLower = strtolower((string) $experience->company_name);
                            $isRekso = str_contains($compLower, 'sosro') || str_contains($compLower, 'gunung slamat') || str_contains($compLower, 'rekso');
                        @endphp
                        <div class="p-3 rounded-lg {{ $isRekso ? 'bg-red-50/40 border-red-100' : 'bg-slate-50 border-slate-200' }} border space-y-2">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1">
                                <div>
                                    <div class="flex items-center gap-1.5">
                                        <h4 class="text-xs font-bold text-slate-900">{{ $experience->position ?? '-' }}</h4>
                                        @if ($isRekso)
                                            <span class="px-1.5 py-0.5 rounded text-[9px] font-bold bg-[#9b1b1f] text-white">REKSO GROUP</span>
                                        @endif
                                    </div>
                                    <p class="text-[11px] font-semibold text-[#9b1b1f]">
                                        {{ $experience->company_name ?? '-' }}
                                        @if ($experience->division)
                                            • <span class="text-slate-600 font-normal">{{ $experience->division }}</span>
                                        @endif
                                    </p>
                                </div>
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-white text-slate-700 border border-slate-200 shrink-0">
                                    {{ $experience->start_date ? \Carbon\Carbon::parse($experience->start_date)->translatedFormat('M Y') : '-' }}
                                    -
                                    {{ $experience->end_date ? \Carbon\Carbon::parse($experience->end_date)->translatedFormat('M Y') : 'Sekarang' }}
                                </span>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-2 text-xs">
                                <div class="p-1.5 rounded bg-white border border-slate-100">
                                    <span class="text-[9px] text-slate-400 block font-semibold">Gaji Terakhir</span>
                                    <span class="font-bold text-slate-800 text-[11px]">
                                        {{ is_numeric($experience->salary) ? 'Rp ' . number_format((float) $experience->salary, 0, ',', '.') : ($experience->salary ?? '-') }}
                                    </span>
                                </div>
                                <div class="p-1.5 rounded bg-white border border-slate-100">
                                    <span class="text-[9px] text-slate-400 block font-semibold">Fasilitas Diperoleh</span>
                                    <span class="font-medium text-slate-700 text-[11px] truncate block" title="{{ $experience->facility }}">
                                        {{ $experience->facility ?: '-' }}
                                    </span>
                                </div>
                                <div class="p-1.5 rounded bg-white border border-slate-100">
                                    <span class="text-[9px] text-slate-400 block font-semibold">Referensi Atasan</span>
                                    <span class="font-medium text-slate-800 text-[11px] truncate block">
                                        {{ $experience->reference_name ?: '-' }}
                                        @if ($experience->reference_phone)
                                            ({{ $experience->reference_phone }})
                                        @endif
                                    </span>
                                </div>
                            </div>

                            <div class="text-[11px] bg-white p-2 rounded border border-slate-100 leading-snug">
                                <span class="font-semibold text-slate-500">Alasan Keluar:</span>
                                <span class="text-slate-700">{{ $experience->reason_for_leaving ?: '-' }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="p-6 text-center text-xs text-slate-400 bg-slate-50 rounded-lg border border-dashed border-slate-200">
                    Belum ada data riwayat pengalaman kerja.
                </div>
            @endif
        </div>

        <!-- 3. CARD: Pendidikan Formal (Compact) -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-2xs p-4 space-y-2.5">
            <div class="flex items-center gap-2 pb-1.5 border-b border-slate-100">
                <span class="w-6 h-6 rounded bg-red-50 flex items-center justify-center text-[#9b1b1f]">
                    <span class="material-symbols-outlined text-[16px]">school</span>
                </span>
                <h3 class="text-sm font-bold text-slate-900">Pendidikan Formal</h3>
            </div>

            @if ($applicant->educations->count())
                <div class="space-y-2">
                    @foreach ($applicant->educations->sortByDesc('graduation_year') as $education)
                        <div class="p-2.5 rounded-lg bg-slate-50 border border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                            <div>
                                <div class="flex items-center gap-1.5">
                                    <span class="px-1.5 py-0.5 rounded text-[9px] font-bold bg-slate-200 text-slate-800 uppercase">
                                        {{ $education->degree_level ?? '-' }}
                                    </span>
                                    <h4 class="text-xs font-bold text-slate-900">
                                        {{ $education->major ? $education->major . ' — ' : '' }}{{ $education->institution_name ?? '-' }}
                                    </h4>
                                </div>
                                <p class="text-[10px] text-slate-500 mt-0.5">
                                    {{ $education->location ? $education->location . ' • ' : '' }}Periode: {{ $education->entry_year ?? '-' }} - {{ $education->graduation_year ?? 'Sekarang' }}
                                </p>
                            </div>
                            @if ($education->gpa !== null)
                                <div class="text-right shrink-0">
                                    <span class="text-[9px] text-slate-400 block">IPK / Nilai</span>
                                    <span class="text-xs font-bold text-slate-900">
                                        {{ $education->gpa }}
                                    </span>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="p-6 text-center text-xs text-slate-400 bg-slate-50 rounded-lg border border-dashed border-slate-200">
                    Belum ada data pendidikan formal.
                </div>
            @endif
        </div>

        <!-- 4. CARD: Pelatihan & Sertifikasi -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-2xs p-4 space-y-2.5">
            <div class="flex items-center justify-between pb-1.5 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <span class="w-6 h-6 rounded bg-red-50 flex items-center justify-center text-[#9b1b1f]">
                        <span class="material-symbols-outlined text-[16px]">card_membership</span>
                    </span>
                    <h3 class="text-sm font-bold text-slate-900">Pelatihan &amp; Sertifikasi Profesi</h3>
                </div>
                <span class="px-2 py-0.5 text-[10px] font-bold rounded bg-red-50 text-[#9b1b1f] border border-red-100">
                    {{ $applicant->trainings->count() }} Sertifikat
                </span>
            </div>

            @if ($applicant->trainings->count())
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2.5">
                    @foreach ($applicant->trainings as $training)
                        <div class="p-2.5 rounded-lg bg-slate-50 border border-slate-100 space-y-1">
                            <div class="flex items-start justify-between gap-2">
                                <h4 class="text-xs font-bold text-slate-900 leading-snug">{{ $training->training_name ?? '-' }}</h4>
                                <span class="material-symbols-outlined text-[#9b1b1f] text-[16px] shrink-0">workspace_premium</span>
                            </div>
                            <p class="text-[10px] text-slate-500">{{ $training->organizer ?? '-' }}</p>
                            <div class="flex items-center justify-between pt-1 text-[10px]">
                                <span class="font-bold text-[#9b1b1f] bg-red-50 border border-red-100 px-1.5 py-0.5 rounded">
                                    {{ $training->finished ? \Carbon\Carbon::parse($training->finished)->format('Y') . ' • Selesai' : 'Terdaftar' }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="p-6 text-center text-xs text-slate-400 bg-slate-50 rounded-lg border border-dashed border-slate-200">
                    Belum ada data pelatihan atau sertifikasi.
                </div>
            @endif
        </div>

        <!-- 5. CARD: Data Keluarga (Compact Table) -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-2xs p-4 space-y-2.5">
            <div class="flex items-center gap-2 pb-1.5 border-b border-slate-100">
                <span class="w-6 h-6 rounded bg-red-50 flex items-center justify-center text-[#9b1b1f]">
                    <span class="material-symbols-outlined text-[16px]">groups</span>
                </span>
                <h3 class="text-sm font-bold text-slate-900">Data Susunan Keluarga</h3>
            </div>

            @if ($applicant->families->count())
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="text-[9px] font-bold text-slate-400 uppercase tracking-wider bg-slate-50">
                                <th class="py-1.5 px-2 rounded-l">Hubungan</th>
                                <th class="py-1.5 px-2">Nama</th>
                                <th class="py-1.5 px-2">Tgl Lahir</th>
                                <th class="py-1.5 px-2">Pendidikan</th>
                                <th class="py-1.5 px-2">Pekerjaan</th>
                                <th class="py-1.5 px-2 rounded-r">Telepon</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 font-medium text-slate-700 text-[11px]">
                            @foreach ($applicant->families as $family)
                                <tr class="hover:bg-slate-50/50">
                                    <td class="py-1.5 px-2 font-bold text-slate-900 capitalize">{{ $family->relationship ?? '-' }}</td>
                                    <td class="py-1.5 px-2 font-semibold text-slate-900">
                                        <div class="flex items-center gap-1.5">
                                            <span>{{ $family->name ?? '-' }}</span>
                                            @if ($family->status === 'deceased')
                                                <span class="px-1.5 py-0.5 rounded bg-slate-100 text-[9px] font-bold text-slate-600">(Alm)</span>
                                            @elseif ($family->status === 'divorced')
                                                <span class="px-1.5 py-0.5 rounded bg-amber-50 text-[9px] font-bold text-amber-700">Cerai</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-1.5 px-2 text-slate-500">
                                        {{ $family->date_of_birth ? \Carbon\Carbon::parse($family->date_of_birth)->translatedFormat('d M Y') : '-' }}
                                    </td>
                                    <td class="py-1.5 px-2">{{ $family->education ?? '-' }}</td>
                                    <td class="py-1.5 px-2">
                                        <span class="px-1.5 py-0.5 bg-slate-100 rounded text-[10px]">{{ $family->work ?? '-' }}</span>
                                    </td>
                                    <td class="py-1.5 px-2 font-mono font-semibold text-slate-800 text-[10px]">
                                        {{ $family->phone_number ?? '-' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-6 text-center text-xs text-slate-400 bg-slate-50 rounded-lg border border-dashed border-slate-200">
                    Belum ada data keluarga.
                </div>
            @endif
        </div>

        <!-- 6. CARD: Kelengkapan Dokumen -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-2xs p-4 space-y-2.5">
            <div class="flex items-center justify-between pb-1.5 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <span class="w-6 h-6 rounded bg-red-50 flex items-center justify-center text-[#9b1b1f]">
                        <span class="material-symbols-outlined text-[16px]">folder</span>
                    </span>
                    <h3 class="text-sm font-bold text-slate-900">Kelengkapan Dokumen</h3>
                </div>
                <span class="text-[10px] font-bold text-slate-600 bg-slate-100 border border-slate-200 px-2 py-0.5 rounded-full">
                    Status Berkas
                </span>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 text-xs">
                @foreach (['KTP Asli', 'Ijazah Terakhir', 'Transkrip Nilai', 'SKCK Kepolisian'] as $document)
                    <div class="p-2 rounded bg-slate-50 border border-slate-100 flex items-center justify-between">
                        <div class="min-w-0">
                            <p class="text-[11px] font-bold text-slate-800 truncate">{{ $document }}</p>
                            <span class="text-[9px] text-slate-500 font-medium">Belum tersedia</span>
                        </div>
                        <span class="material-symbols-outlined text-[15px] text-slate-300">description</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- 7. CARD: Kompensasi & Kesiapan -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-2xs p-4 space-y-2.5">
            <div class="flex items-center gap-2 pb-1.5 border-b border-slate-100">
                <span class="w-6 h-6 rounded bg-red-50 flex items-center justify-center text-[#9b1b1f]">
                    <span class="material-symbols-outlined text-[16px]">payments</span>
                </span>
                <h3 class="text-sm font-bold text-slate-900">Ekspektasi Kompensasi &amp; Kesiapan Kerja</h3>
            </div>

            @if ($applicant->expectation)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-xs">
                    <div class="p-2.5 rounded bg-slate-50 border border-slate-100 space-y-0.5">
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Ekspektasi Gaji Pokok</span>
                        <div class="flex items-baseline gap-1.5">
                            <span class="text-sm font-bold text-[#9b1b1f]">
                                {{ $applicant->expectation->salary_expectation ? 'Rp ' . number_format($applicant->expectation->salary_expectation, 0, ',', '.') : '-' }}
                            </span>
                        </div>
                        <p class="text-[10px] text-slate-500">Per Bulan</p>
                    </div>

                    <div class="p-2.5 rounded bg-slate-50 border border-slate-100 space-y-0.5">
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Referensi Karyawan Rekso</span>
                        <div class="text-[11px] font-bold text-slate-800">
                            {{ $applicant->expectation->reference_by ?: 'Tidak Ada Referensi' }}
                        </div>
                        <p class="text-[10px] text-slate-500">Kenalan / Referral Internal</p>
                    </div>

                    <div class="p-2.5 rounded bg-slate-50 border border-slate-100 space-y-1">
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider block">Kesiapan Mobilitas</span>
                        <div class="flex items-center justify-between text-[11px]">
                            <span class="text-slate-700">Relokasi Luar Kota:</span>
                            <span class="px-1.5 py-0.5 rounded text-[9px] font-bold {{ $applicant->expectation->ready_to_relocate ? 'bg-red-50 text-[#9b1b1f] border-red-100' : 'bg-slate-200 text-slate-600 border-slate-300' }} border">
                                {{ $applicant->expectation->ready_to_relocate ? 'Bersedia' : 'Tidak Bersedia' }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between text-[11px]">
                            <span class="text-slate-700">Dinas Luar Kota:</span>
                            <span class="px-1.5 py-0.5 rounded text-[9px] font-bold {{ $applicant->expectation->ready_to_travel ? 'bg-red-50 text-[#9b1b1f] border-red-100' : 'bg-slate-200 text-slate-600 border-slate-300' }} border">
                                {{ $applicant->expectation->ready_to_travel ? 'Bersedia' : 'Tidak Bersedia' }}
                            </span>
                        </div>
                    </div>

                    <div class="p-2.5 rounded bg-slate-50 border border-slate-100 space-y-0.5">
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Sumber Informasi &amp; Fasilitas</span>
                        <p class="text-[11px] font-bold text-slate-800 truncate">{{ $applicant->expectation->job_source ?: '-' }}</p>
                        <p class="text-[10px] text-slate-500 leading-tight pt-0.5">
                            Fasilitas diharapkan: {{ $applicant->expectation->facility_expectation ?: '-' }}
                        </p>
                    </div>
                </div>
            @else
                <div class="p-6 text-center text-xs text-slate-400 bg-slate-50 rounded-lg border border-dashed border-slate-200">
                    Belum ada data ekspektasi gaji & kesiapan kerja.
                </div>
            @endif
        </div>
    </div>
</div>
