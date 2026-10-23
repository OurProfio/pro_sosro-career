@extends('auth.admin.layouts.index')

@section('title', 'Database Pelamar Kerja - Sinar Sosro Gunung Slamat')

@section('content')
    <div class="flex flex-col w-full font-sans space-y-6" x-data="{
        search: '',
        selectedDivision: '',
        selectedEducation: '',
        selectedSosro: '',
        activeTab: 'all',
        sortDesc: true
    }">
        <!-- Top Navigation & Header Overview Banner -->
        <section class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-3.5 border-b border-slate-200">
            <div class="space-y-0.5">
                <nav class="flex items-center gap-1.5 text-xs text-slate-400 font-medium">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-[#9b1b1f] transition">Portal Karir</a>
                    <span class="material-symbols-outlined text-xs">chevron_right</span>
                    <span class="text-[#9b1b1f] font-bold">Database Pelamar</span>
                </nav>
                <div class="flex items-center gap-2">
                    <h1 class="text-xl font-bold tracking-tight text-slate-900">Database Pelamar Kerja</h1>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-50 text-[#A6192E] border border-red-100/70">
                        Internal Rekrutmen
                    </span>
                </div>
                <p class="text-xs text-slate-500">
                    Kelola profil lengkap, riwayat pendidikan, rekam jejak pengalaman kerja, dan histori kandidat PT Sinar Sosro & Gunung Slamat.
                </p>
            </div>
        </section>

        @php
            $totalCount = $applicants->count();
            $eksSosroCount = $applicants->filter(function($app) {
                return $app->has_applied_sosro === 'ya' || $app->workExperiences->contains(function($exp) {
                    return str_contains(strtolower($exp->company_name ?? ''), 'sosro') || str_contains(strtolower($exp->company_name ?? ''), 'gunung slamat');
                });
            })->count();
            $freshGradCount = $applicants->filter(fn($app) => $app->workExperiences->isEmpty())->count();
            $shortlistCount = $applicants->filter(function($app) {
                return $app->applications->contains(fn($a) => in_array($a->status, ['progress', 'accepted']));
            })->count();
            $experiencedCount = $applicants->filter(fn($app) => $app->workExperiences->isNotEmpty())->count();
        @endphp

        <!-- Key Metrics & Metric Bar -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-200/90 flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Total Pelamar</p>
                    <p class="text-2xl font-bold text-slate-900 mt-0.5">{{ $totalCount }}</p>
                    <span class="text-[10px] text-emerald-600 font-medium inline-flex items-center gap-0.5 mt-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                        <span>Terdaftar aktif</span>
                    </span>
                </div>
                <div class="w-10 h-10 rounded-xl bg-red-50 text-[#A6192E] flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-200/90 flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Eks Karyawan / Magang</p>
                    <p class="text-2xl font-bold text-slate-900 mt-0.5">{{ $eksSosroCount }}</p>
                    <span class="text-[10px] text-amber-600 font-medium inline-flex items-center gap-0.5 mt-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Histori Sosro Group</span>
                    </span>
                </div>
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-200/90 flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Fresh Graduate</p>
                    <p class="text-2xl font-bold text-slate-900 mt-0.5">{{ $freshGradCount }}</p>
                    <span class="text-[10px] text-sky-600 font-medium inline-flex items-center gap-0.5 mt-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                        </svg>
                        <span>Pool Talenta Muda</span>
                    </span>
                </div>
                <div class="w-10 h-10 rounded-xl bg-sky-50 text-sky-700 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M12 14l9-5-9-5-9 5 9 5z"></path>
                        <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                    </svg>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-200/90 flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Shortlist / Progress</p>
                    <p class="text-2xl font-bold text-slate-900 mt-0.5">{{ $shortlistCount }}</p>
                    <span class="text-[10px] text-purple-600 font-medium inline-flex items-center gap-0.5 mt-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                        <span>Dalam Tahap Seleksi</span>
                    </span>
                </div>
                <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-700 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Filter Category Tabs & Search Bar -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/90 p-4">
            <div class="flex items-center gap-2 overflow-x-auto pb-2 border-b border-slate-100">
                <button type="button" @click="activeTab = 'all'"
                    :class="activeTab === 'all' ? 'bg-[#A6192E] text-white' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50'"
                    class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-lg text-xs font-semibold shadow-sm transition-all whitespace-nowrap cursor-pointer">
                    <span>Semua Pelamar</span>
                    <span :class="activeTab === 'all' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600'" class="px-1.5 py-0.2 rounded-full text-[10px]">{{ $totalCount }}</span>
                </button>

                <button type="button" @click="activeTab = 'sosro'"
                    :class="activeTab === 'sosro' ? 'bg-[#A6192E] text-white' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50'"
                    class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-lg text-xs font-medium transition-all whitespace-nowrap cursor-pointer">
                    <span>Eks Karyawan Sosro</span>
                    <span :class="activeTab === 'sosro' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600'" class="px-1.5 py-0.2 rounded-full text-[10px]">{{ $eksSosroCount }}</span>
                </button>

                <button type="button" @click="activeTab = 'fresh'"
                    :class="activeTab === 'fresh' ? 'bg-[#A6192E] text-white' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50'"
                    class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-lg text-xs font-medium transition-all whitespace-nowrap cursor-pointer">
                    <span>Fresh Graduate</span>
                    <span :class="activeTab === 'fresh' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600'" class="px-1.5 py-0.2 rounded-full text-[10px]">{{ $freshGradCount }}</span>
                </button>

                <button type="button" @click="activeTab = 'experienced'"
                    :class="activeTab === 'experienced' ? 'bg-[#A6192E] text-white' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50'"
                    class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-lg text-xs font-medium transition-all whitespace-nowrap cursor-pointer">
                    <span>Berpengalaman</span>
                    <span :class="activeTab === 'experienced' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600'" class="px-1.5 py-0.2 rounded-full text-[10px]">{{ $experiencedCount }}</span>
                </button>

                <button type="button" @click="activeTab = 'shortlist'"
                    :class="activeTab === 'shortlist' ? 'bg-[#A6192E] text-white' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50'"
                    class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-lg text-xs font-medium transition-all whitespace-nowrap cursor-pointer">
                    <span>Shortlist / Lolos Review</span>
                    <span :class="activeTab === 'shortlist' ? 'bg-white/20 text-white' : 'bg-rose-50 text-[#A6192E]'" class="px-1.5 py-0.2 rounded-full text-[10px] font-semibold">{{ $shortlistCount }}</span>
                </button>
            </div>

            <!-- Multi-field Search and Filter Bar -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-3 mt-4">
                <!-- Search Input -->
                <div class="md:col-span-5 relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" x-model="search"
                        class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:bg-white focus:border-[#A6192E] focus:ring-2 focus:ring-[#A6192E]/20 transition-all"
                        placeholder="Cari pelamar berdasarkan nama, keahlian, universitas, atau posisi...">
                </div>

                <!-- Divisi Dropdown -->
                <div class="md:col-span-2">
                    <select x-model="selectedDivision"
                        class="w-full py-2.5 px-3 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 font-medium focus:bg-white focus:border-[#A6192E] focus:ring-2 focus:ring-[#A6192E]/20 transition-all">
                        <option value="">Semua Minat Divisi</option>
                        @if (isset($divisions))
                            @foreach ($divisions as $div)
                                <option value="{{ strtolower($div->name) }}">{{ $div->name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <!-- Pendidikan Dropdown -->
                <div class="md:col-span-2">
                    <select x-model="selectedEducation"
                        class="w-full py-2.5 px-3 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 font-medium focus:bg-white focus:border-[#A6192E] focus:ring-2 focus:ring-[#A6192E]/20 transition-all">
                        <option value="">Pendidikan Terakhir</option>
                        <option value="s2">S2 / Magister</option>
                        <option value="s1">S1 / Sarjana</option>
                        <option value="d4">D4 / Sarjana Terapan</option>
                        <option value="d3">D3 / Diploma</option>
                        <option value="smk">SMK / SMA Sederajat</option>
                    </select>
                </div>

                <!-- Status Eks Sosro -->
                <div class="md:col-span-2">
                    <select x-model="selectedSosro"
                        class="w-full py-2.5 px-3 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 font-medium focus:bg-white focus:border-[#A6192E] focus:ring-2 focus:ring-[#A6192E]/20 transition-all">
                        <option value="">Histori Sosro: Semua</option>
                        <option value="ya">Eks Sosro (Ya)</option>
                        <option value="tidak">Non-Sosro (Baru)</option>
                    </select>
                </div>

                <!-- Sort By -->
                <div class="md:col-span-1">
                    <button type="button" @click="sortDesc = !sortDesc"
                        class="w-full py-2.5 px-3 bg-slate-50 hover:bg-slate-100 border border-slate-200 rounded-xl text-xs text-slate-700 font-medium flex items-center justify-center gap-1.5 transition-all cursor-pointer"
                        title="Urutkan Hasil">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                        </svg>
                        <span class="hidden lg:inline text-[11px]" x-text="sortDesc ? 'Terbaru' : 'Terlama'">Terbaru</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Main Table Container -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/90 overflow-hidden flex flex-col">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-rose-50/50 text-[11px] font-bold text-slate-500 uppercase tracking-wider border-b border-rose-100/60">
                            <th class="py-3.5 pl-6 pr-3 w-12 text-center">NO.</th>
                            <th class="py-3.5 px-4 min-w-[210px] text-center">PELAMAR</th>
                            <th class="py-3.5 px-4 min-w-[190px] text-center">PENDIDIKAN TERAKHIR</th>
                            <th class="py-3.5 px-4 min-w-[200px] text-center">PENGALAMAN TERAKHIR</th>
                            <th class="py-3.5 px-4 text-center min-w-[90px]">UMUR</th>
                            <th class="py-3.5 px-4 text-center min-w-[110px]">GENDER</th>
                            <th class="py-3.5 px-4 min-w-[180px] text-center">HISTORI SOSRO</th>
                            <th class="py-3.5 pr-6 pl-4 text-center min-w-[130px]">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs">
                        @forelse ($applicants as $index => $applicant)
                            @php
                                $lastEducation = $applicant->educations->sortByDesc('graduation_year')->first();
                                $lastExperience = $applicant->workExperiences->sortByDesc(fn($e) => [$e->end_date ?? '9999-12-31', $e->start_date])->first();
                                
                                $age = $applicant->date_of_birth ? \Carbon\Carbon::parse($applicant->date_of_birth)->age : null;
                                
                                $isEksSosro = ($applicant->has_applied_sosro === 'ya') || $applicant->workExperiences->contains(function($exp) {
                                    return str_contains(strtolower($exp->company_name ?? ''), 'sosro') || str_contains(strtolower($exp->company_name ?? ''), 'gunung slamat');
                                });

                                $domisili = $applicant->address_domisili ?: ($applicant->address_ktp ?: '-');
                                // ringkas alamat kota bila panjang
                                $domisiliShort = \Illuminate\Support\Str::limit($domisili, 25);

                                $interests = $applicant->interest?->interests;
                                $interestStr = is_array($interests) ? implode(' ', array_map(fn($i) => is_array($i) ? ($i['name'] ?? '') : (string)$i, $interests)) : (string)$interests;

                                $hasShortlist = $applicant->applications->contains(fn($a) => in_array($a->status, ['progress', 'accepted']));
                                $isFresh = $applicant->workExperiences->isEmpty();

                                $eduLevel = strtolower($lastEducation->degree_level ?? '');
                            @endphp
                            <tr class="hover:bg-slate-50/70 transition-colors group"
                                x-show="
                                    (activeTab === 'all' || 
                                     (activeTab === 'sosro' && {{ $isEksSosro ? 'true' : 'false' }}) || 
                                     (activeTab === 'fresh' && {{ $isFresh ? 'true' : 'false' }}) || 
                                     (activeTab === 'experienced' && {{ !$isFresh ? 'true' : 'false' }}) || 
                                     (activeTab === 'shortlist' && {{ $hasShortlist ? 'true' : 'false' }}))
                                    &&
                                    (search === '' || 
                                     '{{ strtolower(addslashes($applicant->name)) }}'.includes(search.toLowerCase()) || 
                                     '{{ strtolower(addslashes($lastEducation->major ?? '')) }}'.includes(search.toLowerCase()) || 
                                     '{{ strtolower(addslashes($lastEducation->institution_name ?? '')) }}'.includes(search.toLowerCase()) || 
                                     '{{ strtolower(addslashes($lastExperience->position ?? '')) }}'.includes(search.toLowerCase()) || 
                                     '{{ strtolower(addslashes($lastExperience->company_name ?? '')) }}'.includes(search.toLowerCase()))
                                    &&
                                    (selectedDivision === '' || '{{ strtolower(addslashes($interestStr)) }}'.includes(selectedDivision.toLowerCase()))
                                    &&
                                    (selectedEducation === '' || '{{ $eduLevel }}'.includes(selectedEducation.toLowerCase()))
                                    &&
                                    (selectedSosro === '' || (selectedSosro === 'ya' && {{ $isEksSosro ? 'true' : 'false' }}) || (selectedSosro === 'tidak' && !{{ $isEksSosro ? 'true' : 'false' }}))
                                ">
                                <td class="py-4 pl-6 pr-3 text-center text-slate-400 font-medium">
                                    {{ $index + 1 }}
                                </td>

                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-3">
                                        @if ($applicant->photo_url)
                                            <img class="w-10 h-10 rounded-full object-cover shrink-0 shadow-sm border border-slate-200"
                                                src="{{ asset('storage/' . $applicant->photo_url) }}"
                                                alt="{{ $applicant->name }}">
                                        @else
                                            <div class="w-10 h-10 rounded-full bg-slate-100 text-slate-600 font-bold flex items-center justify-center text-xs shrink-0 border border-slate-200">
                                                {{ strtoupper(substr($applicant->name ?? 'A', 0, 2)) }}
                                            </div>
                                        @endif
                                        <div class="min-w-0">
                                            <a href="{{ route('applicant.show', $applicant) }}"
                                                class="font-bold text-slate-900 group-hover:text-[#A6192E] transition-colors leading-tight block truncate">
                                                {{ $applicant->name }}
                                            </a>
                                            <p class="text-[11px] text-slate-500 mt-0.5 truncate" title="{{ $domisili }}">
                                                {{ $domisiliShort }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <td class="py-4 px-4">
                                    @if ($lastEducation)
                                        <div>
                                            <p class="font-semibold text-slate-800 leading-tight">
                                                {{ $lastEducation->degree_level ?? '-' }} {{ $lastEducation->major ? '· ' . $lastEducation->major : '' }}
                                                @if ($lastEducation->gpa)
                                                    <span class="text-emerald-700 text-[11px] font-bold">(IPK {{ $lastEducation->gpa }})</span>
                                                @endif
                                            </p>
                                            <p class="text-[11px] text-slate-500 mt-0.5">
                                                {{ $lastEducation->institution_name ?? '-' }}
                                                @if ($lastEducation->graduation_year)
                                                    ({{ $lastEducation->graduation_year }})
                                                @endif
                                            </p>
                                        </div>
                                    @else
                                        <span class="text-slate-400 italic">Belum diisi</span>
                                    @endif
                                </td>

                                <td class="py-4 px-4">
                                    @if ($lastExperience)
                                        <div>
                                            <p class="font-semibold text-slate-800 leading-tight">
                                                {{ $lastExperience->position ?? '-' }}
                                            </p>
                                            <p class="text-[11px] text-slate-500 mt-0.5">
                                                {{ $lastExperience->company_name ?? '-' }}
                                                @if ($lastExperience->start_date)
                                                    • <span class="text-slate-700 font-medium">
                                                        {{ \Carbon\Carbon::parse($lastExperience->start_date)->format('M Y') }} - {{ $lastExperience->end_date ? \Carbon\Carbon::parse($lastExperience->end_date)->format('M Y') : 'Sekarang' }}
                                                    </span>
                                                @endif
                                            </p>
                                        </div>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-sky-50 text-sky-700">
                                            Fresh Graduate
                                        </span>
                                    @endif
                                </td>

                                <td class="py-4 px-4 text-center">
                                    @if ($age)
                                        <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-md text-xs font-semibold bg-slate-100 text-slate-800">
                                            {{ $age }} Th
                                        </span>
                                    @else
                                        <span class="text-slate-400">-</span>
                                    @endif
                                </td>

                                <td class="py-4 px-4 text-center">
                                    @if ($applicant->gender === 'l')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-sky-50 text-sky-700">
                                            <span class="w-1.5 h-1.5 rounded-full bg-sky-600"></span> Laki-laki
                                        </span>
                                    @elseif ($applicant->gender === 'p')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-pink-100 text-pink-700">
                                            <span class="w-1.5 h-1.5 rounded-full bg-pink-600"></span> Perempuan
                                        </span>
                                    @else
                                        <span class="text-slate-400">-</span>
                                    @endif
                                </td>

                                <td class="py-4 px-4 text-center">
                                    @if ($isEksSosro)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200/60">
                                            <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            <span>
                                                @if ($applicant->previous_applied_position)
                                                    Eks Sosro ({{ $applicant->previous_applied_position }})
                                                @else
                                                    Eks Karyawan / Magang
                                                @endif
                                            </span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-medium bg-slate-100 text-slate-600">
                                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                            </svg>
                                            <span>Non-Sosro (Kandidat Baru)</span>
                                        </span>
                                    @endif
                                </td>

                                <td class="py-4 pr-6 pl-4 text-center whitespace-nowrap">
                                    <div class="inline-flex items-center justify-center gap-1 bg-slate-50 p-1 rounded-lg border border-slate-200/80">
                                        <a href="{{ route('applicant.show', $applicant) }}"
                                            class="p-1.5 text-slate-500 hover:text-[#A6192E] hover:bg-white rounded-md transition cursor-pointer"
                                            title="Lihat Profil Pelamar">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('applicant.print', $applicant) }}" target="_blank"
                                            class="p-1.5 text-slate-500 hover:text-slate-900 hover:bg-white rounded-md transition cursor-pointer"
                                            title="Cetak Berkas CV">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-12 text-center text-slate-400">
                                    Belum ada data pelamar yang terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Table Footer (Tanpa Tombol Pagination) -->
            <div class="p-4 bg-slate-50/50 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                <div class="font-medium">
                    Menampilkan <span class="font-bold text-slate-800">{{ $applicants->count() }}</span> total pelamar
                </div>
            </div>
        </div>
    </div>
@endsection
