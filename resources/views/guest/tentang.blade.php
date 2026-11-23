@extends('guest.layouts.index')

@section('title', 'Tentang Kami')

@section('content')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        .font-brand-scope,
        #beranda-tentang,
        #beranda-tentang button,
        #beranda-tentang a {
            font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .font-display-title,
        #beranda-tentang h1,
        #jenjang-karier h2,
        #proses-rekrutmen h2,
        #proses-rekrutmen h3,
        #departemen-perusahaan h2,
        #kegiatan-perusahaan h2 {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif !important;
            letter-spacing: -0.025em;
        }

        #jenjang-karier,
        #proses-rekrutmen,
        #departemen-perusahaan,
        #kegiatan-perusahaan {
            font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        @keyframes deptMarqueeScroll {
            0% {
                transform: translate3d(0, 0, 0);
            }

            100% {
                transform: translate3d(-50%, 0, 0);
            }
        }

        .dept-marquee-track {
            display: flex;
            width: max-content;
            animation: deptMarqueeScroll 55s linear infinite;
            will-change: transform;
        }

        .dept-marquee-track:hover {
            animation-play-state: paused;
        }

        @media (prefers-reduced-motion: reduce) {
            .dept-marquee-track {
                animation: none;
            }
        }
    </style>

    <section id="beranda-tentang"
        class="relative w-full min-h-[560px] sm:min-h-[600px] md:min-h-[640px] lg:min-h-[680px] bg-[#B11116] overflow-hidden flex items-center pt-28 pb-14 md:pt-32 md:pb-16">

        <div class="absolute inset-0 w-full h-full pointer-events-none select-none overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-tr from-[#78080c] via-[#B11116] to-[#cf1529]"></div>

            <div class="absolute inset-0 bg-[radial-gradient(rgba(255,255,255,0.16)_1px,transparent_1px)] [background-size:24px_24px] opacity-25"></div>

            <div class="absolute -top-28 right-1/4 w-[580px] md:w-[780px] h-[580px] md:h-[780px] rounded-full bg-radial from-[#ff6b35]/20 via-[#e81928]/25 to-transparent blur-3xl"></div>
            <div class="absolute -bottom-24 -left-24 w-[520px] md:w-[700px] h-[520px] md:h-[700px] rounded-full bg-radial from-[#590407]/70 to-transparent blur-3xl"></div>

            <svg class="absolute inset-0 w-full h-full" viewBox="0 0 1440 600" preserveAspectRatio="none" fill="none" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <linearGradient id="curveLayerTentang" x1="100%" y1="0%" x2="10%" y2="100%">
                        <stop offset="0%" stop-color="#e8202d" stop-opacity="0.55" />
                        <stop offset="55%" stop-color="#B11116" stop-opacity="0.8" />
                        <stop offset="100%" stop-color="#690609" stop-opacity="0.92" />
                    </linearGradient>
                    <linearGradient id="curveMainTentang" x1="85%" y1="0%" x2="0%" y2="85%">
                        <stop offset="0%" stop-color="#df1a26" stop-opacity="0.85" />
                        <stop offset="45%" stop-color="#B11116" stop-opacity="0.95" />
                        <stop offset="100%" stop-color="#73080c" stop-opacity="0.9" />
                    </linearGradient>
                    <linearGradient id="waveAccentTentang" x1="0%" y1="100%" x2="100%" y2="40%">
                        <stop offset="0%" stop-color="#8b0a0e" stop-opacity="0.9" />
                        <stop offset="50%" stop-color="#c8102e" stop-opacity="0.7" />
                        <stop offset="100%" stop-color="#df1a26" stop-opacity="0.4" />
                    </linearGradient>
                </defs>

                <path d="M1440,0 L760,0 C930,130 980,270 860,390 C740,510 520,535 280,555 C160,565 70,550 0,565 L0,600 L1440,600 Z"
                    fill="url(#curveLayerTentang)" />
                <path d="M1440,0 L920,0 C1070,120 1110,250 1000,375 C890,495 660,520 400,540 C220,554 90,535 0,550 L0,600 L1440,600 Z"
                    fill="url(#curveMainTentang)" />
                <path d="M0,495 C300,535 620,455 960,490 C1180,512 1330,475 1440,485 L1440,600 L0,600 Z"
                    fill="url(#waveAccentTentang)" opacity="0.88" />
            </svg>

            <img src="{{ asset('assets/images/sosro-ornament.png') }}" alt=""
                class="absolute -right-8 top-12 md:right-8 md:top-16 w-44 sm:w-56 md:w-68 object-contain pointer-events-none select-none opacity-20 transform rotate-12">
            <img src="{{ asset('assets/images/sosro-ornament.png') }}" alt=""
                class="absolute left-4 bottom-2 md:left-14 md:bottom-4 w-32 sm:w-40 md:w-48 object-contain pointer-events-none select-none opacity-15 transform -rotate-45">
        </div>

        <div class="relative z-20 max-w-7xl mx-auto px-6 md:px-12 w-full">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-10 lg:gap-12 items-center">

                <div class="md:col-span-6 lg:col-span-7 text-left">
                    <h1 data-i18n-key="about_hero_title" style="font-weight: 800;"
                        class="font-display-title text-2xl sm:text-3xl md:text-4xl lg:text-[3.1rem] text-white font-extrabold uppercase leading-[1.14] tracking-tight drop-shadow-md">
                        INTIP KESERUAN INSAN SINAR SOSRO GUNUNG SLAMAT
                    </h1>

                    <p data-i18n-key="about_hero_desc"
                        class="text-white/95 text-sm sm:text-base md:text-lg mt-4 md:mt-5 max-w-2xl font-normal leading-relaxed drop-shadow-sm">
                        Berlandaskan ambisi sebagai The Good Beverage Company, Sinar Sosro Gunung Slamat membuka peluang untuk tumbuh dan berkembang bersama para ahlinya.
                    </p>
                </div>

                <div class="md:col-span-6 lg:col-span-5 flex justify-center md:justify-end">
                    <div class="relative w-full max-w-md lg:max-w-lg pb-4 sm:pb-6 pl-0 sm:pl-6">
                        <div class="hidden sm:block absolute top-3 right-0 -bottom-1 left-9 rounded-3xl border border-white/25 bg-white/5 transform rotate-2 pointer-events-none"></div>

                        <div class="relative aspect-[4/3] w-full rounded-3xl overflow-hidden shadow-2xl shadow-black/40 border-2 border-white/30 bg-black/30 group z-10">
                            <img src="{{ asset('assets/images/outbound_sosro.png') }}"
                                alt="Kebersamaan Insan Sinar Sosro Gunung Slamat"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/55 via-transparent to-transparent"></div>
                        </div>

                        <div class="hidden sm:block relative -mt-20 -ml-2 w-48 md:w-56 aspect-[4/3] rounded-2xl overflow-hidden shadow-2xl shadow-black/40 border-2 border-white/90 bg-slate-900 z-20 transform -rotate-2 transition-transform duration-500 hover:rotate-0">
                            <img src="{{ asset('assets/images/training sosro.webp') }}"
                                alt="Pengembangan Talenta Sinar Sosro Gunung Slamat"
                                class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section id="jenjang-karier" class="relative w-full bg-white py-16 sm:py-20 md:py-24 overflow-hidden">
        <div class="max-w-5xl mx-auto px-6 md:px-10">

            <div class="relative pt-2 sm:pt-4">
                <div class="mb-12 sm:mb-0 sm:absolute sm:top-4 sm:left-0 z-30">
                    <p data-i18n-key="career_path_kicker"
                        class="text-lg sm:text-xl md:text-2xl font-bold text-slate-950 uppercase tracking-tight leading-none">
                        JENJANG
                    </p>
                    <h2 data-i18n-key="career_path_title" style="font-weight: 800;"
                        class="font-display-title text-3xl sm:text-4xl md:text-[2.75rem] font-extrabold text-slate-950 uppercase tracking-tight leading-[1.02] mt-1">
                        KARIER
                    </h2>
                </div>

                <div class="grid grid-cols-4 gap-2 sm:gap-2.5 md:gap-3 items-end pt-8 sm:pt-12">

                    <div id="stepEntryLevel" class="relative flex flex-col justify-end">
                        <div id="karakterKarierWrapper"
                            class="absolute bottom-full left-1/2 -translate-x-1/2 mb-0 translate-y-[2px] z-20 pointer-events-none select-none w-16 sm:w-20 md:w-24 lg:w-28 will-change-transform">
                            
                            <svg class="w-full h-auto drop-shadow-md overflow-visible" viewBox="0 0 100 125" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <ellipse cx="50" cy="123" rx="22" ry="3.5" fill="rgba(15, 23, 42, 0.28)" />

                                <g id="karakterBackLeg" style="transform-origin: 43px 74px; will-change: transform;">
                                    <path d="M40 74 L47 74 L44 98 L37 97 Z" fill="#1e293b" />
                                    <path d="M37 97 L44 98 L41 118 L34 117 Z" fill="#334155" />
                                    <path d="M32 116 L43 118 L44 123 L28 123 C28 120 30 117 32 116 Z" fill="#090d16" />
                                    <path d="M34 118 C37 119 40 119 42 118" stroke="#475569" stroke-width="0.8" fill="none" />
                                    <path d="M28 122 L44 122 L44 123 L28 123 Z" fill="#1e293b" />
                                </g>

                                <g id="karakterFrontLeg" style="transform-origin: 53px 74px; will-change: transform;">
                                    <path d="M50 74 L58 74 L65 96 L57 97 Z" fill="#334155" />
                                    <path d="M57 97 L65 96 L68 117 L61 118 Z" fill="#1e293b" />
                                    <path d="M58 117 L71 116 L76 123 L55 123 C55 120 56 117 58 117 Z" fill="#090d16" />
                                    <path d="M60 118 C64 117 68 117 71 118" stroke="#475569" stroke-width="0.8" fill="none" />
                                    <path d="M55 122 L76 122 L76 123 L55 123 Z" fill="#1e293b" />
                                </g>

                                <g class="character-far-arm">
                                    <path d="M43 42 L34 56 C33 58 35 60 37 60 L44 48 Z" fill="#1e293b" />
                                    <path d="M34 56 L33 58 L37 60 L38 58 Z" fill="#ffffff" />
                                    <circle cx="35" cy="62" r="3.2" fill="#fed7aa" />
                                </g>

                                <g class="character-torso">
                                    <path d="M37 42 C39 38 51 36 60 39 L62 74 C57 77 46 78 39 76 L35 48 Z" fill="#1e293b" />
                                    <path d="M49 38 L54 56 L59 39 Z" fill="#f8fafc" />
                                    <path d="M47 37 L54 44 L51 45 L46 39 Z" fill="#ffffff" />
                                    <path d="M61 38 L54 44 L57 45 L62 40 Z" fill="#ffffff" />
                                    <polygon points="53,43 55,43 55.5,45 52.5,45" fill="#8f0c11" />
                                    <path d="M53 45 L55 45 L56 58 L54 62 L52 58 Z" fill="#B11116" />
                                    <path d="M46 38 L50 50 L45 53 L44 43 Z" fill="#0f172a" />
                                    <path d="M61 39 L57 52 L62 55 L63 44 Z" fill="#0f172a" />
                                    <rect x="41" y="48" width="5" height="1.5" rx="0.5" fill="#ffffff" />
                                    <circle cx="56" cy="58" r="1.2" fill="#94a3b8" />
                                    <circle cx="56" cy="65" r="1.2" fill="#94a3b8" />
                                    <path d="M52 40 C53 48 57 55 57 60" stroke="#B11116" stroke-width="1.3" stroke-linecap="round" fill="none" />
                                    <rect x="54" y="59" width="6" height="8" rx="1.2" fill="#ffffff" stroke="#cbd5e1" stroke-width="0.7" />
                                    <rect x="55" y="60.5" width="4" height="2.5" fill="#B11116" />
                                </g>

                                <g class="character-near-arm">
                                    <path d="M55 42 L64 54 L62 67 L57 63 L51 46 Z" fill="#0f172a" />
                                    <path d="M62 67 L60 69 L56 65 L57 63 Z" fill="#ffffff" />
                                    <circle cx="61" cy="70" r="3.5" fill="#fed7aa" />

                                    <g class="briefcase">
                                        <rect x="52" y="70" width="22" height="15" rx="2.5" fill="#3f2314" stroke="#1f1109" stroke-width="1" />
                                        <rect x="54" y="72" width="18" height="5" rx="1" fill="#4d2c19" />
                                        <rect x="62.5" y="75" width="3" height="3" rx="0.5" fill="#fbbf24" stroke="#b45309" stroke-width="0.5" />
                                        <path d="M59 70 C59 66 65 66 65 70" stroke="#1f1109" stroke-width="2" fill="none" stroke-linecap="round" />
                                        <line x1="53" y1="78" x2="73" y2="78" stroke="#1f1109" stroke-width="0.8" />
                                    </g>
                                </g>

                                <g class="character-head">
                                    <path d="M49 31 L55 31 L54 39 L48 38 Z" fill="#fed7aa" />

                                    <path d="M45 22 C45 14 51 11 58 12 C60 12.5 61 14 61.5 16 L65.5 21 L62 22.5 L63 25.5 L62.5 28 C59 31.5 53 32 49 32 C45.5 28 45 25 45 22 Z" fill="#fed7aa" />

                                    <ellipse cx="48.5" cy="23.5" rx="2.5" ry="3.2" fill="#fed7aa" />
                                    <path d="M48.5 22 C49.5 23 49.5 24.5 48.2 25" stroke="#f59e0b" stroke-width="0.75" fill="none" stroke-linecap="round" />

                                    <path d="M44 21 C43 11 50 6.5 59 7 C63 7.5 65 10 64.5 13 C61.5 13.5 58 13.5 56.5 15.5 L53.5 17.5 L51.5 22 L48.5 20.5 C46 20.5 44.5 21.5 44 23.5 Z" fill="#090d16" />
                                    <path d="M49 9 C53 8 58 8.5 61.5 10.5" stroke="#334155" stroke-width="1.2" stroke-linecap="round" fill="none" />

                                    <path d="M57 16 C59.5 15 62 15.5 63.5 16.5" stroke="#090d16" stroke-width="1.4" stroke-linecap="round" fill="none" />

                                    <ellipse cx="61" cy="19" rx="1.5" ry="1.7" fill="#090d16" />
                                    <circle cx="61.5" cy="18.5" r="0.55" fill="#ffffff" />

                                    <path d="M60.5 24.5 C61.5 25.2 62.5 25 63 24.5" stroke="#b91c1c" stroke-width="1.1" stroke-linecap="round" fill="none" />
                                </g>
                            </svg>
                        </div>

                        <div
                            class="w-full h-16 sm:h-20 md:h-24 lg:h-28 rounded-t-xl sm:rounded-t-2xl bg-gradient-to-b from-[#bd1419] to-[#a10d12] shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex items-center justify-center px-2 text-center">
                            <span class="text-white font-bold text-xs sm:text-base md:text-xl tracking-tight leading-tight">
                                Entry Level
                            </span>
                        </div>
                    </div>

                    <div id="stepAssociate" class="relative flex flex-col justify-end">
                        <div
                            class="relative z-10 w-full h-24 sm:h-32 md:h-36 lg:h-44 rounded-t-xl sm:rounded-t-2xl bg-gradient-to-b from-[#bd1419] to-[#a10d12] shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex items-center justify-center px-2 text-center">
                            <span class="text-white font-bold text-xs sm:text-base md:text-xl tracking-tight leading-tight">
                                Associate
                            </span>
                        </div>
                    </div>

                    <div class="relative flex flex-col justify-end">
                        <div
                            class="w-full h-32 sm:h-44 md:h-48 lg:h-60 rounded-t-xl sm:rounded-t-2xl bg-gradient-to-b from-[#bd1419] to-[#a10d12] shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex items-center justify-center px-2 text-center">
                            <span class="text-white font-bold text-xs sm:text-base md:text-xl tracking-tight leading-tight">
                                Mid Level
                            </span>
                        </div>
                    </div>

                    <div class="relative flex flex-col justify-end">
                        <div
                            class="w-full h-40 sm:h-56 md:h-60 lg:h-76 rounded-t-xl sm:rounded-t-2xl bg-gradient-to-b from-[#bd1419] to-[#a10d12] shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex items-start justify-center pt-5 sm:pt-7 md:pt-9 lg:pt-11 px-2 text-center">
                            <span class="text-white font-bold text-xs sm:text-base md:text-xl tracking-tight leading-tight">
                                Senior
                            </span>
                        </div>
                    </div>

                </div>
            </div>

            <p data-i18n-key="career_path_desc"
                class="mt-8 sm:mt-10 text-slate-800 text-sm sm:text-base md:text-lg leading-relaxed font-normal text-justify sm:text-left">
                PT Sinar Sosro Gunung Slamat berkomitmen mengembangkan karier setiap karyawan melalui program-program internal yang dirancang untuk meningkatkan kompetensi dan kesiapan talenta dalam menghadapi jenjang karier berikutnya dengan lebih percaya diri.
            </p>

        </div>
    </section>

    @php
        $recruitmentSlides = [
            [
                'key' => 'pro-hire',
                'steps' => [
                    [
                        'number' => 1,
                        'title' => 'Seleksi CV',
                        'title_i18n' => 'step_cv_title',
                        'desc' => 'Penilaian kesesuaian kualifikasi kandidat dengan posisi yang dilamar.',
                        'desc_i18n' => 'step_cv_desc',
                    ],
                    [
                        'number' => 2,
                        'title' => 'Psikotes',
                        'title_i18n' => 'step_psy_title',
                        'desc' => 'Pengukuran aspek psikologis dan kemampuan kognitif kandidat.',
                        'desc_i18n' => 'step_psy_desc',
                    ],
                    [
                        'number' => 3,
                        'title' => 'Wawancara',
                        'title_i18n' => 'step_int_title',
                        'desc' => 'Pendalaman kompetensi, motivasi, dan kesesuaian kandidat.',
                        'desc_i18n' => 'step_int_desc',
                    ],
                    [
                        'number' => 4,
                        'title' => 'MCU',
                        'title_i18n' => 'step_mcu_title',
                        'desc' => 'Medical Check-Up, pemeriksaan kesehatan untuk memastikan kesiapan kerja.',
                        'desc_i18n' => 'step_mcu_desc',
                    ],
                    [
                        'number' => 5,
                        'title' => 'Orientasi Kerja',
                        'title_i18n' => 'step_onboard_title',
                        'desc' => 'Proses pengenalan dan penyesuaian karyawan baru dengan perusahaan.',
                        'desc_i18n' => 'step_onboard_desc',
                    ],
                ],
            ],
            [
                'key' => 'management-trainee',
                'steps' => [
                    [
                        'number' => 1,
                        'title' => 'Seleksi CV',
                        'title_i18n' => 'step_cv_title',
                        'desc' => 'Penilaian kesesuaian kualifikasi kandidat dengan posisi yang dilamar.',
                        'desc_i18n' => 'step_cv_desc',
                    ],
                    [
                        'number' => 2,
                        'title' => 'Psikotes',
                        'title_i18n' => 'step_psy_title',
                        'desc' => 'Pengukuran aspek psikologis dan kemampuan kognitif kandidat.',
                        'desc_i18n' => 'step_psy_desc',
                    ],
                    [
                        'number' => 3,
                        'title' => 'Form Biodata',
                        'title_i18n' => 'step_biodata_title',
                        'desc' => 'Pengumpulan data diri sebagai kelengkapan administrasi.',
                        'desc_i18n' => 'step_biodata_desc',
                    ],
                    [
                        'number' => 4,
                        'title' => 'Wawancara',
                        'title_i18n' => 'step_int_title',
                        'desc' => 'Pendalaman kompetensi, motivasi, dan kesesuaian kandidat.',
                        'desc_i18n' => 'step_int_desc',
                    ],
                    [
                        'number' => 5,
                        'title' => 'Studi Kasus',
                        'title_i18n' => 'step_case_title',
                        'desc' => 'Evaluasi kemampuan analisis dan pemecahan masalah.',
                        'desc_i18n' => 'step_case_desc',
                    ],
                    [
                        'number' => 6,
                        'title' => 'MCU',
                        'title_i18n' => 'step_mcu_title',
                        'desc' => 'Medical Check-Up, pemeriksaan kesehatan untuk memastikan kesiapan kerja.',
                        'desc_i18n' => 'step_mcu_desc',
                    ],
                    [
                        'number' => 7,
                        'title' => 'Orientasi Kerja',
                        'title_i18n' => 'step_onboard_title',
                        'desc' => 'Proses pengenalan dan penyesuaian karyawan baru dengan perusahaan.',
                        'desc_i18n' => 'step_onboard_desc',
                    ],
                ],
            ],
        ];
    @endphp

    <section id="proses-rekrutmen"
        class="relative w-full bg-gradient-to-b from-[#bd1419] via-[#B11116] to-[#980c10] text-white py-16 sm:py-20 md:py-24 overflow-hidden">

        <div class="absolute inset-0 pointer-events-none select-none overflow-hidden">
            <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full bg-radial from-[#df1a26]/35 to-transparent blur-3xl"></div>
            <div class="absolute -bottom-24 -right-24 w-96 h-96 rounded-full bg-radial from-[#660508]/55 to-transparent blur-3xl"></div>
        </div>

        <div class="relative z-10 max-w-5xl mx-auto px-6 md:px-10">

            <div class="flex items-center justify-between gap-4 sm:gap-6 mb-12 sm:mb-14">
                <div class="shrink-0">
                    <h2 data-i18n-key="recruitment_kicker" style="font-weight: 800;"
                        class="font-display-title text-2xl sm:text-3xl md:text-4xl font-extrabold uppercase tracking-tight leading-none">
                        PROSES
                    </h2>
                    <p data-i18n-key="recruitment_title"
                        class="text-base sm:text-xl md:text-2xl font-bold uppercase tracking-tight leading-tight mt-0.5 text-white/95">
                        REKRUTMEN
                    </p>
                </div>

                <div class="h-[1.5px] bg-white/80 flex-1"></div>

                <div class="shrink-0 text-right">
                    <button type="button" data-recruitment-target="0"
                        class="recruitment-track-label cursor-pointer text-lg sm:text-xl md:text-2xl font-extrabold uppercase tracking-tight leading-tight text-white transition-opacity duration-300">
                        PRO-HIRE
                    </button>
                    <button type="button" data-recruitment-target="1"
                        class="recruitment-track-label hidden cursor-pointer text-base sm:text-xl md:text-2xl font-extrabold uppercase tracking-tight leading-tight text-right text-white transition-opacity duration-300">
                        MANAGEMENT<br>TRAINEE
                    </button>
                </div>
            </div>

            <div class="relative" id="recruitmentSlider">

                <button type="button" id="recruitmentPrevBtn" aria-label="Tahapan Sebelumnya"
                    class="opacity-0 pointer-events-none cursor-pointer absolute left-0 sm:left-2 md:left-4 top-1/2 -translate-y-1/2 z-30 flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 rounded-full text-white hover:bg-white/15 transition-all duration-300 active:scale-90">
                    <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                <button type="button" id="recruitmentNextBtn" aria-label="Tahapan Berikutnya"
                    class="opacity-100 cursor-pointer absolute right-0 sm:right-2 md:right-4 top-1/2 -translate-y-1/2 z-30 flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 rounded-full text-white hover:bg-white/15 transition-all duration-300 active:scale-90">
                    <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7" />
                    </svg>
                </button>

                <div class="max-w-3xl mx-auto px-8 sm:px-14">
                    @foreach ($recruitmentSlides as $slideIndex => $slide)
                        <div class="recruitment-slide {{ $slideIndex === 0 ? 'block opacity-100' : 'hidden opacity-0' }} transition-all duration-300 ease-out"
                            data-recruitment-slide="{{ $slideIndex }}">
                            <div class="flex flex-col">
                                @foreach ($slide['steps'] as $step)
                                    @php
                                        $isOdd = $step['number'] % 2 !== 0;
                                        $lineClass = $loop->first
                                            ? 'top-[24px] bottom-0'
                                            : ($loop->last
                                                ? 'top-0 h-[24px]'
                                                : 'top-0 bottom-0');
                                    @endphp

                                    <div class="grid grid-cols-[24px_1fr] sm:grid-cols-[1fr_40px_1fr] items-stretch">

                                        <div class="col-start-1 row-start-1 sm:col-start-2 relative flex justify-center">
                                            <span class="absolute left-1/2 -translate-x-1/2 w-[2.5px] bg-white {{ $lineClass }}"></span>
                                            <span class="relative z-10 mt-[17px] w-3.5 h-3.5 rounded-full bg-white shadow-xs shrink-0"></span>
                                        </div>

                                        <div class="col-start-2 row-start-1 pl-4 {{ $loop->last ? 'pb-2' : 'pb-7 sm:pb-9' }} {{ $isOdd ? 'sm:col-start-1 sm:pl-0 sm:pr-5' : 'sm:col-start-3 sm:pl-5' }}">
                                            <div class="flex items-start gap-3 sm:gap-4 {{ $isOdd ? 'sm:flex-row-reverse sm:text-right' : 'text-left' }}">
                                                <span class="text-3xl sm:text-4xl font-extrabold text-white leading-none pt-1 shrink-0 select-none">
                                                    {{ $step['number'] }}
                                                </span>
                                                <div class="max-w-xs {{ $isOdd ? 'sm:ml-auto' : '' }}">
                                                    <h3 data-i18n-key="{{ $step['title_i18n'] }}"
                                                        class="text-base sm:text-lg font-bold text-white leading-snug">
                                                        {{ $step['title'] }}
                                                    </h3>
                                                    <p data-i18n-key="{{ $step['desc_i18n'] }}"
                                                        class="text-xs sm:text-sm text-white/90 leading-relaxed mt-1">
                                                        {{ $step['desc'] }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>

            <div class="flex items-center justify-center gap-2.5 mt-10 sm:mt-12" id="recruitmentDots">
                <button type="button"
                    class="recruitment-dot w-2.5 h-2.5 rounded-full bg-white scale-110 transition-all duration-300 cursor-pointer"
                    data-recruitment-target="0" aria-label="Proses Rekrutmen Pro-Hire"></button>
                <button type="button"
                    class="recruitment-dot w-2.5 h-2.5 rounded-full bg-white/40 hover:bg-white/75 transition-all duration-300 cursor-pointer"
                    data-recruitment-target="1" aria-label="Proses Rekrutmen Management Trainee"></button>
            </div>

        </div>
    </section>

    @php
        $companyDepartments = [
            ['name' => 'E-Commerce', 'image' => 'karyawan-1.png', 'i18n' => 'dept_ecom'],
            ['name' => 'Export', 'image' => 'karyawan-2.png', 'i18n' => 'dept_export'],
            ['name' => 'Finance & Accounting', 'image' => 'karyawan-3.png', 'i18n' => 'dept_fa'],
            ['name' => 'Pabrikan', 'image' => 'karyawan-4.png', 'i18n' => 'dept_pabrikan'],
            ['name' => 'Human Capital', 'image' => 'karyawan-1.png', 'i18n' => 'dept_hc'],
            ['name' => 'Internal Audit & Business Process Management', 'image' => 'karyawan-2.png', 'i18n' => 'dept_iabpm'],
            ['name' => 'IT', 'image' => 'karyawan-3.png', 'i18n' => 'dept_it'],
            ['name' => 'Marketing', 'image' => 'karyawan-4.png', 'i18n' => 'dept_mkt'],
            ['name' => 'Sales & Distribution', 'image' => 'karyawan-1.png', 'i18n' => 'dept_sd'],
            ['name' => 'Operations Controller', 'image' => 'karyawan-2.png', 'i18n' => 'dept_opc'],
            ['name' => 'Strategic Account & Partnership', 'image' => 'karyawan-3.png', 'i18n' => 'dept_sap'],
            ['name' => 'National Development & Promotion', 'image' => 'karyawan-4.png', 'i18n' => 'dept_ndp'],
            ['name' => 'Supply Chain', 'image' => 'karyawan-1.png', 'i18n' => 'dept_sc'],
            ['name' => 'Tea Institute', 'image' => 'karyawan-2.png', 'i18n' => 'dept_tea'],
        ];

        $companyActivities = [
            ['image' => 'our_program.png', 'caption' => 'Kolaborasi Tim Insan Sosro', 'i18n' => 'act_1'],
            ['image' => 'outbound_sosro.png', 'caption' => 'Kebersamaan & Sportivitas Rekso Trofeo', 'i18n' => 'act_2'],
            ['image' => 'training sosro.webp', 'caption' => 'Factory Xperience & Pengembangan Talenta', 'i18n' => 'act_3'],
            ['image' => 'hero-slide-team.jpg', 'caption' => 'Aksi Lingkungan Langkah Prima', 'i18n' => 'act_4'],
            ['image' => 'kegiatan sosial sosro.webp', 'caption' => 'Kemitraan Pendidikan & Sosial', 'i18n' => 'act_5'],
            ['image' => 'tentang-hero.webp', 'caption' => 'Produk Kebanggaan Sinar Sosro Gunung Slamat', 'i18n' => 'act_6'],
        ];
    @endphp

    <section id="departemen-perusahaan" class="relative w-full bg-white py-16 sm:py-20 md:py-24 overflow-hidden">
        <div class="absolute inset-0 pointer-events-none select-none overflow-hidden">
            <img src="{{ asset('assets/images/sosro-ornament.png') }}" alt=""
                class="absolute -left-10 top-1/2 -translate-y-1/2 w-56 sm:w-72 object-contain opacity-[0.06] transform -rotate-12">
            <img src="{{ asset('assets/images/sosro-ornament.png') }}" alt=""
                class="absolute -right-10 top-1/2 -translate-y-1/2 w-56 sm:w-72 object-contain opacity-[0.06] transform rotate-12">
        </div>

        <div class="relative z-10 max-w-6xl mx-auto px-6 md:px-10 mb-8 sm:mb-10 text-center">
            <h2 data-i18n-key="dept_section_title" style="font-weight: 800;"
                class="font-display-title text-xl sm:text-2xl md:text-[1.75rem] font-extrabold text-slate-950 uppercase tracking-tight">
                DEPARTEMEN PERUSAHAAN
            </h2>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-0 sm:px-6">
            <div class="relative overflow-hidden py-4" id="departemenSliderViewport">
                <div class="hidden sm:block pointer-events-none absolute inset-y-0 left-0 w-14 md:w-20 bg-gradient-to-r from-white to-transparent z-30"></div>
                <div class="hidden sm:block pointer-events-none absolute inset-y-0 right-0 w-14 md:w-20 bg-gradient-to-l from-white to-transparent z-30"></div>

                <div class="dept-marquee-track">
                    @for ($copy = 0; $copy < 2; $copy++)
                        <div class="flex gap-5 sm:gap-6 pr-5 sm:pr-6 shrink-0" @if ($copy === 1) aria-hidden="true" @endif>
                            @foreach ($companyDepartments as $dept)
                                <div class="w-48 sm:w-52 md:w-56 shrink-0 pt-10 select-none group">
                                    <div
                                        class="relative h-52 sm:h-56 rounded-t-2xl bg-gradient-to-b from-[#bd1419] to-[#a10d12] shadow-md group-hover:shadow-xl transition-all duration-300">
                                        <div class="absolute inset-0 rounded-t-2xl overflow-hidden pointer-events-none">
                                            <img src="{{ asset('assets/images/sosro-ornament.png') }}" alt=""
                                                class="absolute -right-4 -bottom-4 w-28 object-contain opacity-20 transform -rotate-12">
                                        </div>
                                        <img src="{{ asset('assets/images/' . $dept['image']) }}"
                                            alt="{{ $dept['name'] }}" draggable="false"
                                            class="absolute bottom-0 left-1/2 -translate-x-1/2 h-[116%] w-auto max-w-none object-contain drop-shadow-[0_10px_18px_rgba(45,4,7,0.28)] transition-transform duration-300 group-hover:scale-[1.03] pointer-events-none">
                                    </div>

                                    <div
                                        class="relative z-20 -mt-1 bg-white border border-red-200 rounded-xl px-3 py-2.5 min-h-[64px] flex items-center justify-center text-center shadow-sm group-hover:border-[#B11116]/60 transition-colors">
                                        <span data-i18n-key="{{ $dept['i18n'] }}"
                                            class="text-[#B11116] font-extrabold text-[11px] sm:text-xs md:text-sm uppercase tracking-tight leading-snug">
                                            {{ $dept['name'] }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </section>

    <section id="kegiatan-perusahaan" class="relative w-full bg-white pb-16 sm:pb-20 md:pb-24 pt-2 sm:pt-4 overflow-hidden">
        <div class="max-w-5xl mx-auto px-6 md:px-10">
            <h2 data-i18n-key="activities_section_title" style="font-weight: 800;"
                class="font-display-title text-xl sm:text-2xl md:text-[1.75rem] font-extrabold text-slate-950 uppercase tracking-tight mb-6 sm:mb-8">
                KEGIATAN PERUSAHAAN
            </h2>

            <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5 sm:gap-3.5 rounded-2xl overflow-hidden shadow-sm">
                @foreach ($companyActivities as $activity)
                    <div class="group relative aspect-[4/3] overflow-hidden bg-slate-100">
                        <img src="{{ asset('assets/images/' . $activity['image']) }}"
                            alt="{{ $activity['caption'] }}"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/15 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-3 sm:p-4">
                            <span data-i18n-key="{{ $activity['i18n'] }}"
                                class="text-white text-xs sm:text-sm font-semibold leading-snug drop-shadow-sm">
                                {{ $activity['caption'] }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const slider = document.getElementById('recruitmentSlider');
            if (!slider) return;

            const slides = document.querySelectorAll('.recruitment-slide');
            const dots = document.querySelectorAll('.recruitment-dot');
            const labels = document.querySelectorAll('.recruitment-track-label');
            const prevBtn = document.getElementById('recruitmentPrevBtn');
            const nextBtn = document.getElementById('recruitmentNextBtn');

            let currentIdx = 0;
            const autoAdvanceDelayMs = 10000;
            let autoAdvanceTimer = null;

            function showSlide(targetIdx) {
                if (targetIdx < 0 || targetIdx >= slides.length || targetIdx === currentIdx) {
                    return;
                }

                const outgoing = slides[currentIdx];
                const incoming = slides[targetIdx];

                outgoing.classList.remove('opacity-100');
                outgoing.classList.add('opacity-0');
                setTimeout(() => {
                    outgoing.classList.add('hidden');
                    outgoing.classList.remove('block');

                    incoming.classList.remove('hidden');
                    incoming.classList.add('block');
                    requestAnimationFrame(() => {
                        incoming.classList.remove('opacity-0');
                        incoming.classList.add('opacity-100');
                    });
                }, 150);

                currentIdx = targetIdx;

                // Update track label header (PRO-HIRE / MANAGEMENT TRAINEE)
                labels.forEach((label, idx) => {
                    label.classList.toggle('hidden', idx !== currentIdx);
                });

                // Update dots
                dots.forEach((dot, idx) => {
                    if (idx === currentIdx) {
                        dot.classList.remove('bg-white/40', 'hover:bg-white/75');
                        dot.classList.add('bg-white', 'scale-110');
                    } else {
                        dot.classList.remove('bg-white', 'scale-110');
                        dot.classList.add('bg-white/40', 'hover:bg-white/75');
                    }
                });

                // Update arrows visibility
                if (prevBtn) {
                    prevBtn.classList.toggle('opacity-0', currentIdx === 0);
                    prevBtn.classList.toggle('pointer-events-none', currentIdx === 0);
                    prevBtn.classList.toggle('opacity-100', currentIdx > 0);
                }

                if (nextBtn) {
                    const isLast = currentIdx === slides.length - 1;
                    nextBtn.classList.toggle('opacity-0', isLast);
                    nextBtn.classList.toggle('pointer-events-none', isLast);
                    nextBtn.classList.toggle('opacity-100', !isLast);
                }
            }

            function startAutoAdvance() {
                stopAutoAdvance();
                autoAdvanceTimer = setInterval(() => {
                    const nextIdx = (currentIdx + 1) % slides.length;
                    showSlide(nextIdx);
                }, autoAdvanceDelayMs);
            }

            function stopAutoAdvance() {
                if (autoAdvanceTimer) {
                    clearInterval(autoAdvanceTimer);
                    autoAdvanceTimer = null;
                }
            }

            function goToSlideManual(targetIdx) {
                showSlide(targetIdx);
                startAutoAdvance();
            }

            if (prevBtn) {
                prevBtn.addEventListener('click', () => goToSlideManual(currentIdx - 1));
            }

            if (nextBtn) {
                nextBtn.addEventListener('click', () => goToSlideManual(currentIdx + 1));
            }

            dots.forEach((dot) => {
                dot.addEventListener('click', () => {
                    const idx = Number(dot.getAttribute('data-recruitment-target'));
                    goToSlideManual(idx);
                });
            });

            // Klik label jalur di kanan atas untuk berganti jalur langsung
            labels.forEach((label) => {
                label.addEventListener('click', () => {
                    const nextIdx = currentIdx === 0 ? 1 : 0;
                    goToSlideManual(nextIdx);
                });
            });

            // Dukungan swipe pada layar sentuh
            let touchStartX = 0;
            slider.addEventListener('touchstart', (e) => {
                touchStartX = e.changedTouches[0].screenX;
                stopAutoAdvance();
            }, { passive: true });

            slider.addEventListener('touchend', (e) => {
                const diff = e.changedTouches[0].screenX - touchStartX;
                if (Math.abs(diff) > 45) {
                    if (diff < 0) goToSlideManual(currentIdx + 1);
                    else goToSlideManual(currentIdx - 1);
                } else {
                    startAutoAdvance();
                }
            }, { passive: true });

            startAutoAdvance();

            // Animasi Parallax Karakter Insan Sosro Melangkah dari Entry Level ke Associate saat Scroll
            (function () {
                const section = document.getElementById('jenjang-karier');
                const step1 = document.getElementById('stepEntryLevel');
                const step2 = document.getElementById('stepAssociate');
                const wrapper = document.getElementById('karakterKarierWrapper');
                const frontLeg = document.getElementById('karakterFrontLeg');
                const backLeg = document.getElementById('karakterBackLeg');

                if (!section || !step1 || !step2 || !wrapper) return;

                // Cek preferensi aksesibilitas
                if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                    return;
                }

                let ticking = false;

                function updateKarakterScroll() {
                    const rectSection = section.getBoundingClientRect();
                    const vh = window.innerHeight || document.documentElement.clientHeight;

                    // Lewati komputasi jika section masih jauh dari viewport
                    if (rectSection.bottom < -100 || rectSection.top > vh + 100) {
                        ticking = false;
                        return;
                    }

                    // Hitung delta X & delta Y riil antara pusat Step 1 dan pusat Step 2
                    const r1 = step1.getBoundingClientRect();
                    const r2 = step2.getBoundingClientRect();

                    // Perpindahan horizontal dari Step 1 ke Step 2
                    const deltaX = (r2.left + r2.width / 2) - (r1.left + r1.width / 2);
                    // Perpindahan vertikal (Step 2 lebih tinggi, jadi r2.top < r1.top, deltaY bernilai negatif)
                    const deltaY = r2.top - r1.top;

                    // Progress scroll:
                    // Karakter di Entry Level saat section baru masuk di bagian bawah layar (78% vh)
                    // Karakter melangkah naik dan tiba di Associate saat section berada di posisi baca ideal (25% vh)
                    const startY = vh * 0.78;
                    const endY = vh * 0.25;
                    const rawProgress = (startY - rectSection.top) / (startY - endY);
                    const progress = Math.max(0, Math.min(1, rawProgress));

                    // Easing kurva halus untuk langkah melangkah yang natural
                    const ease = progress * progress * (3 - 2 * progress);

                    // Efek lengkungan langkah tubuh karakter (hop arc ke atas saat menaiki tangga)
                    const hopHeight = Math.min(22, Math.max(10, Math.abs(deltaY) * 0.25));
                    const hopArc = Math.sin(ease * Math.PI) * hopHeight;

                    // Perpindahan posisi tubuh
                    const currentX = deltaX * ease;
                    const currentY = (deltaY * ease) - hopArc;

                    // Sedikit kemiringan tubuh saat melangkah maju
                    const tilt = Math.sin(ease * Math.PI) * 5;

                    wrapper.style.transform = `translate3d(calc(-50% + ${currentX.toFixed(2)}px), ${currentY.toFixed(2)}px, 0) rotate(${tilt.toFixed(1)}deg)`;

                    // ANIMASI KAKI NAIK KE ATAS:
                    // Saat melangkah naik (0 < progress < 1), kaki depan terangkat tinggi ke atas menaiki tangga
                    if (frontLeg && backLeg) {
                        const legPhase = Math.sin(ease * Math.PI);
                        const frontRot = -32 * legPhase;      // Kaki depan terangkat tinggi dan mengayun ke tangga atas
                        const frontLift = 14 * legPhase;      // Kaki terangkat naik 14px ke atas
                        const backRot = 16 * legPhase;       // Kaki belakang mendorong dari bawah

                        frontLeg.style.transform = `translate3d(0, ${-frontLift.toFixed(2)}px, 0) rotate(${frontRot.toFixed(1)}deg)`;
                        backLeg.style.transform = `rotate(${backRot.toFixed(1)}deg)`;
                    }

                    ticking = false;
                }

                function onScroll() {
                    if (!ticking) {
                        requestAnimationFrame(updateKarakterScroll);
                        ticking = true;
                    }
                }

                window.addEventListener('scroll', onScroll, { passive: true });
                window.addEventListener('resize', onScroll, { passive: true });
                updateKarakterScroll();
            })();
        });
    </script>
@endsection
