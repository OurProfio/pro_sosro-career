@php
    $isHome = request()->routeIs('guest.index');
    $isLowongan = request()->routeIs('guest.lowongan');
    $isTentang = request()->routeIs('guest.tentang');
    $isProgram = request()->routeIs('guest.program');
    $isKontak = request()->routeIs('guest.kontak');
    $isTransparentNav = $isHome || $isLowongan || $isTentang || $isProgram || $isKontak;
@endphp

<header id="main-header"
    class="{{ $isTransparentNav ? 'fixed top-0 inset-x-0 z-50 transition-all duration-300 bg-transparent' : 'sticky top-0 z-50 bg-[#B11116] shadow-md' }}">
    <nav class="max-w-7xl mx-auto px-6 md:px-10 py-3.5 flex justify-between items-center text-white">
        <a href="{{ route('guest.index') }}" class="flex items-center gap-2 group transition-transform active:scale-95">
            <img src="{{ asset('assets/images/SGS Logo-Putih.webp') }}" alt="Logo Sinar Sosro Gunung Slamat" class="h-10 md:h-11 object-contain drop-shadow-sm">
        </a>

        <div class="hidden lg:flex items-center gap-8 text-sm font-semibold tracking-wide">
            <a href="{{ route('guest.index') }}#beranda" data-i18n-key="nav_home"
                class="py-1 border-b-2 {{ $isHome ? 'border-white text-white' : 'border-transparent text-white/80 hover:text-white hover:border-white/40' }} transition-all duration-200 drop-shadow-sm">
                Beranda
            </a>
            <a href="{{ route('guest.tentang') }}" data-i18n-key="nav_about"
                class="py-1 border-b-2 {{ $isTentang ? 'border-white text-white' : 'border-transparent text-white/80 hover:text-white hover:border-white/40' }} transition-all duration-200 drop-shadow-sm">
                Tentang
            </a>
            <a href="{{ route('guest.program') }}" data-i18n-key="nav_program"
                class="py-1 border-b-2 {{ $isProgram ? 'border-white text-white' : 'border-transparent text-white/80 hover:text-white hover:border-white/40' }} transition-all duration-200 drop-shadow-sm">
                Program
            </a>
            <a href="{{ route('guest.lowongan') }}" data-i18n-key="nav_vacancies"
                class="py-1 border-b-2 {{ $isLowongan ? 'border-white text-white' : 'border-transparent text-white/80 hover:text-white hover:border-white/40' }} transition-all duration-200 drop-shadow-sm">
                Lowongan
            </a>
            <a href="{{ route('guest.kontak') }}" data-i18n-key="nav_contact"
                class="py-1 border-b-2 {{ $isKontak ? 'border-white text-white' : 'border-transparent text-white/80 hover:text-white hover:border-white/40' }} transition-all duration-200 drop-shadow-sm">
                Kontak
            </a>
        </div>

        <div class="flex items-center space-x-4">
            <div class="relative" data-lang-menu-root>
                <button type="button" data-lang-menu-toggle aria-haspopup="true" aria-expanded="false" id="lang-menu-btn"
                    class="inline-flex items-center gap-2 px-3 py-1.5 md:px-3.5 md:py-2 rounded-full transition-all duration-300 text-sm font-semibold text-white hover:cursor-pointer {{ $isTransparentNav ? 'bg-transparent border border-white/20 hover:border-white/40' : 'bg-black/20 hover:bg-black/30 border border-white/20' }}">
                    <span id="current-lang-flag" class="inline-block w-5 h-3.5 rounded-[2px] overflow-hidden shadow-xs border border-white/30 bg-white shrink-0">
                        <span class="block h-1.75 bg-red-600"></span>
                        <span class="block h-1.75 bg-white"></span>
                    </span>
                    <span id="current-lang-label" class="font-semibold tracking-wider text-sm drop-shadow-sm">ID</span>
                    <svg class="w-4 h-4 text-white/90 transition-transform duration-200" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                    </svg>
                </button>

                <div data-lang-menu hidden
                    class="absolute right-0 mt-2 w-40 bg-white rounded-2xl shadow-2xl py-2 z-[70] border border-gray-100 overflow-hidden text-sm font-semibold text-gray-700">
                    <button type="button" onclick="setLanguage('id')"
                        class="w-full flex items-center gap-3 px-4 py-2.5 hover:bg-red-50 hover:text-[#B11116] transition text-left cursor-pointer">
                        <span class="inline-block w-5 h-3.5 rounded-[2px] overflow-hidden border border-gray-300 bg-white shrink-0 shadow-xs">
                            <span class="block h-1.75 bg-red-600"></span>
                            <span class="block h-1.75 bg-white"></span>
                        </span>
                        <span class="font-semibold">Indonesia</span>
                    </button>
                    <button type="button" onclick="setLanguage('en')"
                        class="w-full flex items-center gap-3 px-4 py-2.5 hover:bg-red-50 hover:text-[#B11116] transition text-left cursor-pointer">
                        <span class="inline-block w-5 h-3.5 rounded-[2px] overflow-hidden border border-gray-300 shrink-0 shadow-xs">
                            <svg class="w-full h-full block" viewBox="0 0 60 36">
                                <clipPath id="uk-clip-menu"><rect width="60" height="36" /></clipPath>
                                <g clip-path="url(#uk-clip-menu)">
                                    <path d="M0,0 v36 h60 v-36 z" fill="#012169" />
                                    <path d="M0,0 L60,36 M60,0 L0,36" stroke="#fff" stroke-width="6" />
                                    <path d="M0,0 L60,36 M60,0 L0,36" stroke="#C8102E" stroke-width="3" />
                                    <path d="M30,0 v36 M0,18 h60" stroke="#fff" stroke-width="10" />
                                    <path d="M30,0 v36 M0,18 h60" stroke="#C8102E" stroke-width="6" />
                                </g>
                            </svg>
                        </span>
                        <span class="font-semibold">English</span>
                    </button>
                </div>
            </div>

            @if (auth()->check())
            @php
                $user = auth()->user();
                $applicant = $user->applicant;
                $admin = $user->admin;

                $accountRole = $admin ? 'Admin' : 'Pelamar';

                if ($admin?->name) {
                    $accountDisplayName = $admin->name;
                } elseif ($applicant?->name) {
                    $accountDisplayName = $applicant->name;
                } else {
                    $emailName = explode('@', $user->email)[0] ?? 'Pelamar';
                    $accountDisplayName = ucwords(str_replace(['.', '_', '-'], ' ', $emailName));
                }

                $avatarInitial = strtoupper(substr($accountDisplayName, 0, 1));
            @endphp

            <div class="relative" data-account-menu-root>
                <button type="button" data-account-menu-toggle aria-haspopup="true" aria-expanded="false" aria-controls="account-menu"
                    class="flex items-center space-x-3 bg-black/20 hover:bg-black/30 backdrop-blur-md border border-white/10 p-1.5 pl-4 pr-1.5 rounded-full transition-all duration-300 focus:outline-none group shadow-sm hover:cursor-pointer">

                    <div class="text-right hidden sm:block">
                        <p class="text-[11px] font-semibold text-white tracking-wide leading-none mb-1 drop-shadow-sm">
                            {{ $accountDisplayName }}
                        </p>
                        <p
                            class="text-[9px] font-medium text-gray-200/80 leading-none truncate max-w-[130px] drop-shadow-sm">
                            {{ $accountRole }}
                        </p>
                    </div>

                    <div
                        class="h-8 w-8 rounded-full bg-red-600 text-white flex items-center justify-center font-semibold shadow-md border border-white/20 transition group-hover:scale-105 group-active:scale-95">
                        {{ $avatarInitial }}
                    </div>
                </button>

                <div id="account-menu" data-account-menu hidden
                    class="absolute right-0 mt-2 w-52 bg-white rounded-2xl shadow-2xl py-2 z-[70] border border-gray-100 overflow-hidden">

                    <div class="px-4 py-3 border-b border-gray-50 mb-1">
                        <p class="text-sm font-semibold text-gray-900 truncate">{{ $accountDisplayName }}</p>
                        <p class="text-[10px] text-gray-500 truncate">{{ Auth::user()->email }}</p>
                    </div>

                    @if ($admin || $user->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}"
                            class="group flex items-center px-4 py-2.5 text-sm font-semibold text-gray-700 hover:bg-red-50 transition">
                            <div
                                class="w-7 h-7 rounded-lg bg-gray-100 flex items-center justify-center mr-3 group-hover:bg-gray-200 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="size-4 text-[#B11116]">
                                    <path fill-rule="evenodd"
                                        d="M4.25 2A2.25 2.25 0 0 0 2 4.25v2.5A2.25 2.25 0 0 0 4.25 9h2.5A2.25 2.25 0 0 0 9 6.75v-2.5A2.25 2.25 0 0 0 6.75 2h-2.5Zm0 9A2.25 2.25 0 0 0 2 13.25v2.5A2.25 2.25 0 0 0 4.25 18h2.5A2.25 2.25 0 0 0 9 15.75v-2.5A2.25 2.25 0 0 0 6.75 11h-2.5Zm9-9A2.25 2.25 0 0 0 11 4.25v2.5A2.25 2.25 0 0 0 13.25 9h2.5A2.25 2.25 0 0 0 18 6.75v-2.5A2.25 2.25 0 0 0 15.75 2h-2.5Zm0 9A2.25 2.25 0 0 0 11 13.25v2.5A2.25 2.25 0 0 0 13.25 18h2.5A2.25 2.25 0 0 0 18 15.75v-2.5A2.25 2.25 0 0 0 15.75 11h-2.5Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            Dashboard Admin
                        </a>
                    @else
                        <a href="{{ route('applicant.dashboard') }}"
                            class="group flex items-center px-4 py-2.5 text-sm font-semibold text-gray-700 hover:bg-red-50 transition">
                            <div
                                class="w-7 h-7 rounded-lg bg-gray-100 flex items-center justify-center mr-3 group-hover:bg-gray-200 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="size-4 text-[#B11116]">
                                    <path fill-rule="evenodd"
                                        d="M4.25 2A2.25 2.25 0 0 0 2 4.25v2.5A2.25 2.25 0 0 0 4.25 9h2.5A2.25 2.25 0 0 0 9 6.75v-2.5A2.25 2.25 0 0 0 6.75 2h-2.5Zm0 9A2.25 2.25 0 0 0 2 13.25v2.5A2.25 2.25 0 0 0 4.25 18h2.5A2.25 2.25 0 0 0 9 15.75v-2.5A2.25 2.25 0 0 0 6.75 11h-2.5Zm9-9A2.25 2.25 0 0 0 11 4.25v2.5A2.25 2.25 0 0 0 13.25 9h2.5A2.25 2.25 0 0 0 18 6.75v-2.5A2.25 2.25 0 0 0 15.75 2h-2.5Zm0 9A2.25 2.25 0 0 0 11 13.25v2.5A2.25 2.25 0 0 0 13.25 18h2.5A2.25 2.25 0 0 0 18 15.75v-2.5A2.25 2.25 0 0 0 15.75 11h-2.5Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            Dashboard Pelamar
                        </a>
                    @endif

                    <hr class="my-1 border-gray-50">

                    <form method="POST" action="{{ route('auth.logout') }}">
                        @csrf
                        <button type="submit"
                            class="group flex items-center w-full px-4 py-2.5 text-sm font-semibold text-red-600 hover:bg-red-50 transition text-left hover:cursor-pointer">
                            <div
                                class="w-7 h-7 rounded-lg bg-gray-100 flex items-center justify-center mr-3 group-hover:bg-red-100 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-log-out w-4">
                                    <path d="m16 17 5-5-5-5" />
                                    <path d="M21 12H9" />
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                </svg>
                            </div>
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        @else
            @if (request()->routeIs('admin.login'))
                {{-- Di halaman login admin, tombol tidak ditampilkan agar bersih dan fokus --}}
            @elseif (request()->routeIs('guest.login'))
                <a href="{{ route('guest.register') }}" data-i18n-key="btn_register"
                    class="px-6 py-2 bg-white text-red-700 font-semibold rounded-full hover:bg-gray-100 transition shadow-md hover:shadow-lg transform active:scale-95">
                    Daftar
                </a>
            @else
                <a href="{{ route('guest.login') }}" data-i18n-key="btn_login"
                    class="px-6 py-2 bg-white text-red-700 font-semibold rounded-full hover:bg-gray-100 transition shadow-md hover:shadow-lg transform active:scale-95">
                    Masuk
                </a>
            @endif
        @endif
    </div>
</nav>
</header>

<script>
    const translations = {
        id: {
            nav_home: 'Beranda',
            nav_about: 'Tentang',
            nav_program: 'Program',
            nav_vacancies: 'Lowongan',
            nav_contact: 'Kontak',
            btn_login: 'Masuk',
            btn_register: 'Daftar',
            hero_title: 'Bekerja Bersama<br>Sebagai Satu Tim',
            hero_desc: 'Bergabunglah bersama kami, talenta muda maupun profesional berpengalaman. Kembangkan potensi terbaikmu dan ciptakan karya berharga di industri FMCG terkemuka Indonesia.',
            hero_tag_1: 'Lingkungan Kolaboratif',
            hero_tag_2: 'Pengembangan Karir',
            hero_tag_3: 'Peluang Nasional',
            hero_kicker_2: 'Warisan & Masa Depan Sosro',
            hero_title_2: 'Jadilah Bagian dari<br>Sesuatu yang Lebih Besar',
            hero_desc_2: 'Wujudkan ide terbaikmu dan kembangkan potensi tanpa batas bersama keluarga besar Rekso dalam memajukan industri kebanggaan nusantara.',
            hero_title_3: 'Kenali Lebih Dekat<br>Keluarga Sosro',
            hero_desc_3: 'Saksikan bagaimana kebersamaan, dedikasi, dan inovasi mengalir nyata di setiap langkah perjalanan kami menghadirkan yang terbaik bagi Indonesia.',
            hero_btn_explore: 'Jelajahi Lowongan',
            hero_btn_about: 'Tentang Kami',
            hero_company_line: 'PT Sinar Sosro • PT Gunung Slamat • Rekso Group',
            hero_cta_2: 'Lihat Posisi',
            hero_btn: 'Lihat Lowongan',
            section_career_label: 'Karier bersama kami',
            section_career_title: 'Temukan lowongan yang sesuai',
            section_career_desc: 'Gunakan pencarian dan filter untuk menemukan posisi berdasarkan lokasi, kategori, atau bidang pekerjaan.',
            search_placeholder: 'Cari lowongan...',
            search_btn: 'Cari',
            opt_all_locations: 'Semua Lokasi',
            opt_all_categories: 'Semua Kategori',
            opt_all_fields: 'Semua Bidang',
            vacancies_available: 'lowongan tersedia',
            apply_btn: 'Lamar posisi ini',
            about_hero_badge: 'The Good Beverage Company',
            about_hero_title: 'INTIP KESERUAN INSAN SINAR SOSRO GUNUNG SLAMAT',
            about_hero_desc: 'Berlandaskan ambisi sebagai The Good Beverage Company, Sinar Sosro Gunung Slamat membuka peluang untuk tumbuh dan berkembang bersama para ahlinya.',
            about_moment_1: 'Kebersamaan & Sportivitas',
            about_moment_2: 'Tumbuh Bersama Ahli',
            career_path_kicker: 'JENJANG',
            career_path_title: 'KARIER',
            career_path_desc: 'PT Sinar Sosro Gunung Slamat berkomitmen mengembangkan karier setiap karyawan melalui program-program internal yang dirancang untuk meningkatkan kompetensi dan kesiapan talenta dalam menghadapi jenjang karier berikutnya dengan lebih percaya diri.',
            recruitment_kicker: 'PROSES',
            recruitment_title: 'REKRUTMEN',
            step_cv_title: 'Seleksi CV',
            step_cv_desc: 'Penilaian kesesuaian kualifikasi kandidat dengan posisi yang dilamar.',
            step_psy_title: 'Psikotes',
            step_psy_desc: 'Pengukuran aspek psikologis dan kemampuan kognitif kandidat.',
            step_biodata_title: 'Form Biodata',
            step_biodata_desc: 'Pengumpulan data diri sebagai kelengkapan administrasi.',
            step_int_title: 'Wawancara',
            step_int_desc: 'Pendalaman kompetensi, motivasi, dan kesesuaian kandidat.',
            step_case_title: 'Studi Kasus',
            step_case_desc: 'Evaluasi kemampuan analisis dan pemecahan masalah.',
            step_mcu_title: 'MCU',
            step_mcu_desc: 'Medical Check-Up, pemeriksaan kesehatan untuk memastikan kesiapan kerja.',
            step_onboard_title: 'Orientasi Kerja',
            step_onboard_desc: 'Proses pengenalan dan penyesuaian karyawan baru dengan perusahaan.',
            dept_section_title: 'DEPARTEMEN PERUSAHAAN',
            dept_ecom: 'E-Commerce',
            dept_export: 'Export',
            dept_fa: 'Finance & Accounting',
            dept_pabrikan: 'Pabrikan',
            dept_hc: 'Human Capital',
            dept_iabpm: 'Internal Audit & Business Process Management',
            dept_it: 'IT',
            dept_mkt: 'Marketing',
            dept_sd: 'Sales & Distribution',
            dept_opc: 'Operations Controller',
            dept_sap: 'Strategic Account & Partnership',
            dept_ndp: 'National Development & Promotion',
            dept_sc: 'Supply Chain',
            dept_tea: 'Tea Institute',
            activities_section_title: 'KEGIATAN PERUSAHAAN',
            act_1: 'Kolaborasi Tim Insan Sosro',
            act_2: 'Kebersamaan & Sportivitas Rekso Trofeo',
            act_3: 'Factory Xperience & Pengembangan Talenta',
            act_4: 'Aksi Lingkungan Langkah Prima',
            act_5: 'Kemitraan Pendidikan & Sosial',
            act_6: 'Produk Kebanggaan Sinar Sosro Gunung Slamat',
            program_hero_title: 'PELUANG MENANTI, MARI BERKEMBANG BERSAMA',
            program_hero_desc: 'Ikuti kegiatan dan program kami di PT Sinar Sosro Gunung Slamat untuk berkembang, memperluas jaringan, dan meraih kesuksesan bersama.',
            niat_baik_title: 'NIAT<br>BAIK<br>HASIL<br>BAIK.',
            prog_mt_title: 'MANAGEMENT TRAINEE',
            prog_gm_title: 'GURU MAGANG',
            prog_ps_title: 'PEMAGANGAN SALES',
            prog_int_title: 'INTERNSHIP',
            prog_mt_testi_title: 'APA KATA MANAGEMENT TRAINEE KAMI?',
            prog_gm_testi_title: 'APA KATA GURU MAGANG KAMI?',
            prog_ps_testi_title: 'APA KATA PEMAGANGAN SALES KAMI?',
            prog_int_testi_title: 'APA KATA INTERNSHIP KAMI?',
            kontak_hero_title: 'CARI TAHU LEBIH TENTANG KARIER SINAR SOSRO GUNUNG SLAMAT',
            kontak_hero_subtitle: 'Kami siap membantu!',
            kontak_hero_desc: 'Hubungi kami melalui form di bawah ini.',
            kontak_card_title: 'Saluran Resmi Rekrutmen',
            kontak_hours_label: 'Jam Operasional',
            kontak_hours_value: 'Senin - Jumat, 08:00 - 17:00 WIB',
            kontak_office_label: 'Kantor Pusat',
            kontak_form_title: 'KIRIM PESAN',
            kontak_submit_btn: 'Kirim Pesan',
            kontak_faq_title: 'PERTANYAAN YANG SERING DIAJUKAN (FAQ)?'
        },
        en: {
            nav_home: 'Home',
            nav_about: 'About',
            nav_program: 'Programs',
            nav_vacancies: 'Vacancies',
            nav_contact: 'Contact',
            btn_login: 'Sign In',
            btn_register: 'Register',
            hero_title: 'Work Together<br>As A Team',
            hero_desc: 'Join our team as young talent or experienced professionals. Unleash your greatest potential and build a meaningful career with Indonesia\'s leading FMCG family.',
            hero_tag_1: 'Collaborative Culture',
            hero_tag_2: 'Career Growth',
            hero_tag_3: 'Nationwide Opportunities',
            hero_kicker_2: 'Sosro Legacy & Future',
            hero_title_2: 'Be Part of<br>Something Bigger',
            hero_desc_2: 'Bring your greatest ideas to life and unlock boundless potential together with the Rekso family in empowering Indonesia\'s proud industry.',
            hero_title_3: 'Get Closer to the<br>Sosro Family',
            hero_desc_3: 'Experience how togetherness, dedication, and innovation come to life in our journey to bring natural goodness to Indonesia.',
            hero_btn_explore: 'Explore Vacancies',
            hero_btn_about: 'About Us',
            hero_company_line: 'PT Sinar Sosro • PT Gunung Slamat • Rekso Group',
            hero_cta_2: 'Explore Roles',
            hero_btn: 'Explore Vacancies',
            section_career_label: 'Career with us',
            section_career_title: 'Find the right opportunity for you',
            section_career_desc: 'Use keyword search and filters to discover positions by location, category, or role.',
            search_placeholder: 'Search vacancies...',
            search_btn: 'Search',
            opt_all_locations: 'All Locations',
            opt_all_categories: 'All Categories',
            opt_all_fields: 'All Fields',
            vacancies_available: 'vacancies available',
            apply_btn: 'Apply for this position',
            about_hero_badge: 'The Good Beverage Company',
            about_hero_title: 'DISCOVER THE SPIRIT OF SINAR SOSRO GUNUNG SLAMAT PEOPLE',
            about_hero_desc: 'Driven by our ambition as The Good Beverage Company, Sinar Sosro Gunung Slamat opens opportunities to grow and thrive alongside industry experts.',
            about_moment_1: 'Togetherness & Sportsmanship',
            about_moment_2: 'Grow With The Experts',
            career_path_kicker: 'CAREER',
            career_path_title: 'PATH',
            career_path_desc: 'PT Sinar Sosro Gunung Slamat is committed to developing every employee\'s career through internal programs designed to strengthen competencies and prepare talent to advance to the next career level with confidence.',
            recruitment_kicker: 'RECRUITMENT',
            recruitment_title: 'PROCESS',
            step_cv_title: 'CV Screening',
            step_cv_desc: 'Assessment of candidate qualifications against the applied role.',
            step_psy_title: 'Psychotest',
            step_psy_desc: 'Measurement of psychological aspects and cognitive abilities.',
            step_biodata_title: 'Biodata Form',
            step_biodata_desc: 'Collection of personal data for administrative completeness.',
            step_int_title: 'Interview',
            step_int_desc: 'In-depth evaluation of competency, motivation, and role fit.',
            step_case_title: 'Case Study',
            step_case_desc: 'Evaluation of analytical thinking and problem-solving skills.',
            step_mcu_title: 'MCU',
            step_mcu_desc: 'Medical Check-Up to ensure health and readiness for work.',
            step_onboard_title: 'On-Boarding',
            step_onboard_desc: 'Introduction and adaptation process for new employees in the company.',
            dept_section_title: 'COMPANY DEPARTMENTS',
            dept_ecom: 'E-Commerce',
            dept_export: 'Export',
            dept_fa: 'Finance & Accounting',
            dept_pabrikan: 'Manufacturing',
            dept_hc: 'Human Capital',
            dept_iabpm: 'Internal Audit & Business Process Management',
            dept_it: 'IT',
            dept_mkt: 'Marketing',
            dept_sd: 'Sales & Distribution',
            dept_opc: 'Operations Controller',
            dept_sap: 'Strategic Account & Partnership',
            dept_ndp: 'National Development & Promotion',
            dept_sc: 'Supply Chain',
            dept_tea: 'Tea Institute',
            activities_section_title: 'COMPANY ACTIVITIES',
            act_1: 'Sosro People Team Collaboration',
            act_2: 'Rekso Trofeo Togetherness & Sportsmanship',
            act_3: 'Factory Xperience & Talent Development',
            act_4: 'Langkah Prima Environmental Action',
            act_5: 'Education & Social Partnership',
            act_6: 'Proud Products of Sinar Sosro Gunung Slamat',
            program_hero_title: 'OPPORTUNITIES AWAIT, LET\'S GROW TOGETHER',
            program_hero_desc: 'Join our activities and programs at PT Sinar Sosro Gunung Slamat to grow, expand your network, and achieve success together.',
            niat_baik_title: 'GOOD<br>INTENT<br>GOOD<br>RESULTS.',
            prog_mt_title: 'MANAGEMENT TRAINEE',
            prog_gm_title: 'TEACHER APPRENTICESHIP',
            prog_ps_title: 'SALES APPRENTICESHIP',
            prog_int_title: 'INTERNSHIP',
            prog_mt_testi_title: 'WHAT OUR MANAGEMENT TRAINEES SAY?',
            prog_gm_testi_title: 'WHAT OUR TEACHER APPRENTICES SAY?',
            prog_ps_testi_title: 'WHAT OUR SALES APPRENTICES SAY?',
            prog_int_testi_title: 'WHAT OUR INTERNS SAY?',
            kontak_hero_title: 'DISCOVER MORE ABOUT CAREERS AT SINAR SOSRO GUNUNG SLAMAT',
            kontak_hero_subtitle: 'We are here to help!',
            kontak_hero_desc: 'Contact us through the form below.',
            kontak_card_title: 'Official Recruitment Channels',
            kontak_hours_label: 'Operating Hours',
            kontak_hours_value: 'Monday - Friday, 08:00 - 17:00 WIB',
            kontak_office_label: 'Head Office',
            kontak_form_title: 'SEND A MESSAGE',
            kontak_submit_btn: 'Send Message',
            kontak_faq_title: 'FREQUENTLY ASKED QUESTIONS (FAQ)?'
        }
    };

    const placeholderMapEn = {
        'Cari lowongan...': 'Search vacancies...',
        'Cari lowongan berdasarkan posisi, lokasi, divisi...': 'Search vacancies by role, location, division...',
        'Nama Lengkap': 'Full Name',
        'Email': 'Email Address',
        'Pesan': 'Your Message',
        'Cari Nama, NIK, atau Email...': 'Search Name, ID, or Email...',
        'Masukkan email Anda': 'Enter your email address',
        'nama@email.com': 'name@email.com',
        'admin@sosro.com': 'admin@sosro.com'
    };

    const dropdownDefaultMapEn = {
        'Semua Lokasi': 'All Locations',
        'Semua Kategori': 'All Categories',
        'Semua Bidang': 'All Fields'
    };

    const htmlBlockMapEn = {
        'NIAT BAIK HASIL BAIK': 'GOOD INTENT<br>GOOD RESULTS',
        'TEKAD RENCANA ULET JELI IMAN': 'RESOLVE<br>PLAN<br>DILIGENCE<br>FAITH',
        'IKUTI PERJALANAN KARIER KAMI': 'FOLLOW<br>OUR CAREER<br>JOURNEY',
        'Program Management Trainee PT Sinar Sosro Gunung Slamat merupakan jalur percepatan karier bagi fresh graduate dari berbagai jurusan melalui pelatihan terstruktur dan penugasan lintas unit kerja, guna menyiapkan talenta muda menjadi pemimpin masa depan perusahaan.': 'The <strong class="font-semibold text-slate-900">PT Sinar Sosro Gunung Slamat Management Trainee Program</strong> is a career acceleration track for fresh graduates from diverse majors through structured training and cross-unit assignments, preparing young talent to become future company leaders.',
        'Program Guru Magang PT Sinar Sosro Gunung Slamat mendukung peningkatan kompetensi guru produktif SMK melalui pengalaman industri dan praktik kerja langsung, sekaligus membuka peluang PKL bagi siswa SMK yang selaras dengan kebutuhan dunia kerja.': 'The <strong class="font-semibold text-slate-900">PT Sinar Sosro Gunung Slamat Teacher Apprenticeship Program</strong> supports vocational school teachers\' competency through direct industry experience and hands-on practice, while creating internship opportunities for vocational students aligned with industry needs.',
        'Program Pemagangan Sales PT Sinar Sosro Gunung Slamat membekali talenta muda dengan keterampilan penjualan lapangan, strategi distribusi produk, dan pemahaman pasar FMCG secara langsung bersama tim komersial berpengalaman.': 'The <strong class="font-semibold text-slate-900">PT Sinar Sosro Gunung Slamat Sales Apprenticeship Program</strong> equips young talent with field sales skills, product distribution strategies, and hands-on FMCG market understanding alongside experienced commercial teams.',
        'Program Internship PT Sinar Sosro Gunung Slamat memberikan kesempatan bagi mahasiswa aktif dan lulusan baru untuk terlibat langsung dalam proyek nyata lintas departemen bersama para mentor profesional.': 'The <strong class="font-semibold text-slate-900">PT Sinar Sosro Gunung Slamat Internship Program</strong> gives active university students and fresh graduates the opportunity to engage directly in real cross-department projects alongside professional mentors.',
        'Masuk ke Akun Anda': 'Sign In to <span class="text-red-600">Your Account</span>',
        'Masuk sebagai Admin': 'Sign In as <span class="text-[#d97706]">Admin</span>',
        'Buat Akun Baru': 'Create a <span class="text-red-600">New Account</span>'
    };

    const phraseMapEn = {
        // Navbar account dropdown
        'Pelamar': 'Applicant',
        'Dashboard Admin': 'Admin Dashboard',
        'Dashboard Pelamar': 'Applicant Dashboard',
        'Keluar': 'Sign Out',

        // Beranda Hero Slide 3 badge
        'Cerita & Budaya Sosro': 'Sosro Story & Culture',

        // Lowongan Hero
        'BERSAMA KAMI, MENJADI BAGIAN SINAR SOSRO GUNUNG SLAMAT': 'TOGETHER WITH US, BECOME PART OF SINAR SOSRO GUNUNG SLAMAT',
        'Bergabunglah dengan kami, baik sebagai talenta muda maupun profesional berpengalaman. Pilih kategori yang sesuai untuk mengembangkan potensi karirmu.': 'Join us as young talent or an experienced professional. Choose the category that fits you to grow your career potential.',

        // Beranda & Lowongan search / filter / listing
        'Cari lowongan': 'Search vacancies',
        'Semua Lokasi': 'All Locations',
        'Semua Kategori': 'All Categories',
        'Semua Bidang': 'All Fields',
        'Cari': 'Search',
        'Karier bersama kami': 'Career with us',
        'Temukan lowongan yang sesuai': 'Find the right opportunity for you',
        'Gunakan pencarian dan filter untuk menemukan posisi berdasarkan lokasi, kategori, atau bidang pekerjaan.': 'Use keyword search and filters to discover positions by location, category, or role.',
        'lowongan tersedia': 'vacancies available',
        'Batas lamaran': 'Application deadline',
        'Lokasi': 'Location',
        'Cabang': 'Branch',
        '(Cabang)': '(Branch)',
        'Bidang': 'Field',
        'Tipe pekerjaan': 'Employment type',
        'Kualifikasi': 'Qualifications',
        'Deskripsi pekerjaan': 'Job description',
        'Periksa kualifikasi sebelum mengirim lamaran.': 'Review the qualifications before submitting your application.',
        'Lamar posisi ini': 'Apply for this position',
        'Sudah dilamar': 'Already applied',
        'Lamaran Tidak Terpilih': 'Application Not Selected',
        'Saat ini belum ada lowongan pekerjaan yang dibuka.': 'There are currently no open job vacancies.',
        'Tidak ada lowongan ditemukan': 'No vacancies found',
        'Tidak ada posisi yang cocok dengan kata kunci atau filter yang Anda pilih.': 'No positions match your selected keywords or filters.',
        'Atur Ulang Filter': 'Reset Filters',
        'Reset Filter': 'Reset Filters',

        // Application confirmation & guard modals
        'Masuk ke Akun Diperlukan': 'Sign In Required',
        'Anda harus masuk (login) ke akun Anda terlebih dahulu untuk dapat melamar posisi': 'You must sign in to your account first to apply for the position',
        'Batal': 'Cancel',
        'Masuk Sekarang': 'Sign In Now',
        'Lengkapi Biodata Anda': 'Complete Your Profile',
        'Anda harus melengkapi data biodata pelamar terlebih dahulu sebelum dapat melamar posisi': 'You must complete your applicant profile data first before applying for',
        'Isi Biodata Sekarang': 'Complete Profile Now',
        'Lengkapi Biodata Sekarang': 'Complete Profile Now',
        'Kirim Lamaran Pekerjaan?': 'Submit Job Application?',
        'Apakah Anda yakin ingin mengirimkan lamaran untuk posisi': 'Are you sure you want to submit an application for',
        'Ya, Kirim Lamaran': 'Yes, Submit Application',
        'Akses Dibatasi': 'Access Restricted',
        'Anda sedang masuk sebagai': 'You are currently signed in as',
        '. Akun Administrator tidak dapat melamar lowongan pekerjaan. Silakan gunakan akun Pelamar untuk melamar lowongan.': '. Administrator accounts cannot apply for job vacancies. Please use an Applicant account to apply.',
        'Mengerti': 'Understood',

        // Beranda About section & Photo Slider
        'yang diresmikan pada 2 Desember 2024 merupakan gabungan dari dua perusahaan. PT Sinar Sosro, pelopor teh siap minum dalam kemasan botol pertama di Indonesia & dunia, dengan PT Gunung Slamat, perusahaan tertua di Rekso Group yang berdiri sejak 1940.': 'was officially established on December 2, 2024 through the merger of two companies: PT Sinar Sosro, the pioneer of bottled ready-to-drink tea in Indonesia and the world, and PT Gunung Slamat, the oldest company in Rekso Group founded in 1940.',
        'Griya Rekso, Kantor Pusat': 'Griya Rekso, Head Office',
        'Pabrik, Slawi': 'Factory, Slawi',
        'Griya Rekso & Pusat Operasional': 'Griya Rekso & Operational Hub',
        'Pusat Pelatihan & Pengembangan': 'Training & Development Center',

        // Beranda Nilai Perusahaan
        'Nilai Perusahaan': 'Company Values',
        'Menjunjung ketulusan niat dan integritas moral dalam setiap keputusan bisnis dan interaksi profesional': 'Upholding sincere intent and moral integrity in every business decision and professional interaction.',
        'Kepedulian terhadap mutu produk, akuntabilitas tugas, serta kredibilitas tinggi di mata konsumen.': 'Caring for product quality, task accountability, and high credibility in the eyes of consumers.',
        'Kesiapan menghadapi tantangan industri lewat perencanaan matang, kejelian, dan standar keselamatan ketat': 'Readiness to face industry challenges through thorough planning, sharp focus, and strict safety standards.',

        // Beranda Program Kami Flip Cards
        'PROGRAM KAMI': 'OUR PROGRAMS',
        'Jalur percepatan kepemimpinan intensif untuk fresh graduate terbaik.': 'Intensive leadership acceleration track for top fresh graduates.',
        'Lihat Manfaat & Rotasi': 'View Benefits & Rotation',
        'Lihat Benefit & Rotasi': 'View Benefits & Rotation',
        'Balik Kartu': 'Flip Card',
        'Detail Program': 'Program Details',
        'Mentoring langsung dari Direksi Rekso': 'Direct mentoring from Rekso Board of Directors',
        'Rotasi lintas fungsional pabrik & cabang': 'Cross-functional rotation across factories & branches',
        'Jalur promosi kepemimpinan dipercepat': 'Accelerated leadership promotion track',
        'MAGANG': 'INTERNSHIP',
        'Pengalaman kerja nyata dan pembimbingan langsung bagi mahasiswa & SMK.': 'Real work experience and direct mentoring for university & vocational students.',
        'Lihat Manfaat & Pembimbingan': 'View Benefits & Mentoring',
        'Lihat Benefit & Pembimbingan': 'View Benefits & Mentoring',
        'PROFESIONAL': 'PROFESSIONAL',
        'Kembangkan keahlian strategis bersama brand minuman kebanggaan Indonesia.': 'Develop strategic expertise with Indonesia\'s proud beverage brand.',
        'Lihat Manfaat & Kolaborasi': 'View Benefits & Collaboration',
        'Lihat Benefit & Kolaborasi': 'View Benefits & Collaboration',

        // Beranda Testimoni Karyawan
        'APA KATA KARYAWAN KAMI?': 'WHAT DO OUR EMPLOYEES SAY?',
        '“Lingkungan kerja yang produktif, dimana atasan dan rekan kerja sangat mensupport terhadap perkembangan kemampuan kinerja saya serta komunikasi yang terjalin dengan sangat baik.”': '“A productive work environment where supervisors and colleagues strongly support my performance growth, backed by excellent communication.”',
        '“Bangga menjadi bagian dari PT Sinar Sosro Gunung Slamat (SGS) dimana PT Sinar Sosro Gunung Slamat salah satu perusahaan pelopor teh nomor satu di Indonesia.”': '“Proud to be part of PT Sinar Sosro Gunung Slamat (SGS), Indonesia\'s number one pioneering tea company.”',
        '“Budaya kerja kekeluargaan yang hangat serta kesempatan kolaborasi lintas divisi membuat saya terus bertumbuh dan bangga berkarya bersama PT Sinar Sosro Gunung Slamat.”': '“A warm family-like work culture and cross-division collaboration opportunities keep me growing and proud to work at PT Sinar Sosro Gunung Slamat.”',

        // Program Page Accordion & Testimoni
        'Guru Magang': 'Teacher\nApprentice',
        'Pemagangan Sales': 'Sales\nApprentice',
        'SMK MITRA INDUSTRI': 'PARTNER VOCATIONAL SCHOOL',
        'TEKNIK OTOMASI': 'AUTOMATION ENGINEERING',
        'TEKNIK PEMESINAN': 'MACHINING ENGINEERING',
        '"Bergabung di SGS dengan filosofi \\"Niat Baik Hasil Baik\\" membantu saya menerapkan prinsip ini di dunia FMCG. Budaya kekeluargaan di SGS membuat proses belajar sangat bermakna."': '"Joining SGS with the \\"Good Intent Good Results\\" philosophy helps me apply this principle in the FMCG world. The family culture at SGS makes the learning process truly meaningful."',
        '"Rotasi lintas pabrik dan cabang membuka wawasan saya secara menyeluruh tentang operasional industri minuman berskala nasional."': '"Rotations across factories and branches gave me comprehensive insight into national-scale beverage industry operations."',
        '"Mentoring langsung dari para pemimpin berpengalaman memberi saya kepercayaan diri untuk mengambil tanggung jawab strategis sejak awal karier."': '"Direct mentoring from experienced leaders gave me the confidence to take on strategic responsibilities early in my career."',
        '"Program terstruktur ini menantang saya bertumbuh cepat sekaligus menanamkan nilai integritas dan kolaborasi tim."': '"This structured program challenged me to grow rapidly while instilling the values of integrity and teamwork."',
        '"Pengalaman praktik langsung di fasilitas produksi Sosro memberi wawasan standar industri terkini untuk kami bawa kembali ke ruang kelas."': '"Hands-on practice at Sosro\'s production facilities provided up-to-date industry standard insights to bring back to our classrooms."',
        '"Tim mentor sangat terbuka membagikan standar keselamatan kerja dan teknologi otomasi yang dibutuhkan lulusan SMK saat ini."': '"The mentor team openly shared workplace safety standards and automation technologies needed by today\'s vocational graduates."',
        '"Sinergi antara PT Sinar Sosro Gunung Slamat dan sekolah vokasi sangat membantu menjembatani kurikulum dengan kebutuhan dunia kerja nyata."': '"The synergy between PT Sinar Sosro Gunung Slamat and vocational schools greatly helps bridge school curricula with real industry needs."',
        '"Program ini memperkuat kompetensi praktis guru sekaligus membuka jalur pemagangan berkualitas bagi siswa kami."': '"This program strengthens teachers\' practical competencies while opening quality apprenticeship pathways for our students."',
        '"Terjun langsung ke pasar membuat saya paham teknik negosiasi, pengelolaan outlet, dan ritme distribusi FMCG yang sesungguhnya."': '"Going directly into the market helped me understand negotiation techniques, outlet management, and real FMCG distribution rhythms."',
        '"Pendampingan supervisor lapangan sangat membantu saya berkembang dari nol hingga percaya diri mencapai target tim."': '"Guidance from field supervisors helped me grow from scratch into confidently achieving team targets."',
        '"Setiap hari selalu ada tantangan baru dan kesempatan belajar cara membangun relasi jangka panjang dengan mitra."': '"Every day brings new challenges and opportunities to learn how to build long-term relationships with partners."',
        '"Budaya kerja yang suportif membuat saya menikmati proses belajar strategi pemasaran langsung di lapangan."': '"A supportive work culture lets me enjoy learning field marketing strategies directly on the ground."',
        '"Selama magang saya dipercaya menangani proyek rekrutmen nyata dan mendapat umpan balik konstruktif setiap minggu."': '"During my internship I was trusted to handle real recruitment projects and received constructive feedback every week."',
        '"Lingkungan kerjanya ramah dan kolaboratif; ide dari anak magang pun benar-benar didengarkan dalam diskusi tim."': '"The work environment is friendly and collaborative; even interns\' ideas are genuinely listened to in team discussions."',
        '"Saya belajar langsung bagaimana sistem digital mendukung proses bisnis perusahaan FMCG berskala besar."': '"I learned firsthand how digital systems support the business processes of a large-scale FMCG company."',
        '"Pengalaman internship di SGS menjadi pijakan karier terbaik sebelum memasuki dunia kerja penuh waktu."': '"My internship experience at SGS became the best career stepping stone before entering the full-time workforce."',

        // Kontak Page & FAQ
        'Telepon': 'Phone',
        'Nama Lengkap': 'Full Name',
        'Pesan': 'Message',
        'Tujuan Wilayah': 'Target Region',
        'Kantor Pusat': 'Head Office',
        'Kantor Pusat (Head Office)': 'Head Office',
        'Pabrik / Unit Produksi': 'Factory / Production Unit',
        'Graha Rekso Lt. 8 - 10, Jl. Bulevard Artha Gading Kav. A1, Kelapa Gading, Jakarta Utara': 'Graha Rekso 8th–10th Floor, Jl. Boulevard Artha Gading Kav. A1, Kelapa Gading, North Jakarta',
        'Tahapan apa saja jika ingin melamar di PT Sinar Sosro Gunung Slamat?': 'What are the stages when applying to PT Sinar Sosro Gunung Slamat?',
        'Tahapan umumnya: Pendaftaran Akun, Melengkapi Profil, Pemilihan Lowongan, Seleksi oleh HRD/User, hingga Penawaran Kerja.': 'General stages: Account Registration, Profile Completion, Vacancy Selection, HRD/User Selection, up to the Job Offer.',
        'Tahapan umumnya: Pendaftaran Akun, Melengkapi Profil, Pemilihan Lowongan, Seleksi oleh HRD/User, hingga Offering.': 'General stages: Account Registration, Profile Completion, Vacancy Selection, HRD/User Selection, up to the Job Offer.',
        'Dokumen apa saja yang harus dipersiapkan sebelum membuat akun?': 'What documents should I prepare before creating an account?',
        'Siapkan CV terbaru, Ijazah Pendidikan Terakhir, Transkrip Nilai, dan KTP dalam format digital (misalnya PDF) untuk diunggah.': 'Prepare your latest CV, Latest Diploma, Academic Transcript, and National ID (KTP) in digital format (e.g., PDF) for upload.',
        'Apakah saya bisa melamar lebih dari satu posisi?': 'Can I apply for more than one position?',
        'Ya, pada umumnya diperbolehkan, namun kami sangat menyarankan Anda fokus melamar pada posisi yang paling sesuai dengan kualifikasi dan minat Anda.': 'Yes, it is generally permitted, though we strongly recommend focusing on the position that best matches your qualifications and interests.',
        'Berapa jangka waktu dari masing-masing tahapan proses seleksi?': 'How long does each stage of the selection process take?',
        'Jangka waktu proses seleksi dapat memakan waktu 2 hingga 4 minggu sejak tanggal penutupan lamaran. Mohon menunggu informasi resmi dari HRD.': 'The selection process may take 2 to 4 weeks from the application closing date. Please wait for official updates from HRD.',
        'Apakah saya bisa memperbarui profil dan CV saya?': 'Can I update my profile and CV?',
        'Apakah saya bisa melakukan update terhadap profil dan CV saya?': 'Can I update my profile and CV?',
        'Ya, Anda dapat memperbarui data profil dan mengunggah CV terbaru di akun Anda. Perubahan akan berlaku untuk lamaran yang akan datang.': 'Yes, you can update your profile data and upload a new CV in your account. Changes will apply to future applications.',
        'Apa yang harus dilakukan jika lupa kata sandi?': 'What should I do if I forget my password?',
        'Apa yang harus dilakukan jika lupa password?': 'What should I do if I forget my password?',
        'Gunakan fitur "Lupa Kata Sandi" di halaman masuk. Masukkan email terdaftar Anda, dan ikuti instruksi yang dikirimkan ke email Anda untuk membuat kata sandi baru.': 'Use the "Forgot Password" feature on the sign-in page. Enter your registered email and follow the instructions sent to your inbox to set a new password.',
        'Gunakan fitur "Lupa Kata Sandi" di halaman login. Masukkan email terdaftar Anda, dan ikuti instruksi yang dikirimkan ke email Anda untuk membuat password baru.': 'Use the "Forgot Password" feature on the login page. Enter your registered email and follow the instructions sent to your inbox to set a new password.',
        'Mengapa saya gagal menyimpan data?': 'Why did saving my data fail?',
        'Cek koneksi internet Anda. Pastikan format file dokumen sudah benar (misalnya PDF) dan ukurannya tidak melebihi batas maksimum yang ditetapkan.': 'Check your internet connection. Make sure your document format is correct (e.g., PDF) and the file size does not exceed the maximum limit.',
        'Setelah selesai melamar posisi yang dituju, apakah tahapan selanjutnya?': 'After applying for a position, what are the next steps?',
        'Tahapan seleksi meliputi Seleksi Administrasi, Psikotes, Wawancara HRD, Wawancara User, dan Tes Kesehatan (MCU). Tahapan bisa bervariasi per posisi.': 'Selection stages include Administrative Screening, Psychotest, HRD Interview, User Interview, and Medical Check-Up (MCU). Stages may vary by position.',
        'Bagaimana melihat status proses untuk setiap posisi yang sudah saya lamar?': 'How can I check the process status for each position I applied to?',
        'Anda dapat melihat status terbaru melalui menu "Riwayat Lamaran" setelah Anda masuk ke akun pelamar.': 'You can view the latest status in the "Application History" menu after signing in to your applicant account.',
        'Apakah ada pungutan biaya dalam proses seleksi?': 'Are there any fees during the selection process?',
        'Tidak. Seluruh proses rekrutmen PT Sinar Sosro Gunung Slamat bersifat GRATIS.': 'No. The entire recruitment process at PT Sinar Sosro Gunung Slamat is FREE of charge.',

        // Footer
        'Kantor Pusat:': 'Head Office:',
        'Graha Rekso Lantai 8 - 10. Jalan Bulevard Artha Gading No.Kav.A1 RT/RW 18/08 Kelapa Gading, Jakarta Utara Daerah Khusus Ibukota Jakarta 14240': 'Graha Rekso 8th–10th Floor, Jl. Boulevard Artha Gading Kav. A1, Kelapa Gading, North Jakarta 14240',
        'Telepon:': 'Phone:',
        'Jam Operasional:': 'Operating Hours:',
        'Senin - Jumat: 08:00 - 17:00': 'Monday - Friday: 08:00 - 17:00',
        'Sabtu - Minggu: Tutup': 'Saturday - Sunday: Closed',
        'Media Sosial': 'Social Media',
        'Hak cipta dilindungi undang-undang.': 'All Rights Reserved.',

        // Login & Register
        'Selamat datang kembali! Silakan masuk untuk melanjutkan.': 'Welcome back! Please sign in to continue.',
        'Masuk': 'Sign In',
        'Belum punya akun?': 'Don\'t have an account?',
        'Daftar di sini': 'Register here',
        'Silakan masuk menggunakan akun administrator Anda untuk mengelola sistem rekrutmen.': 'Please sign in with your administrator account to manage the recruitment system.',
        'Email Administrator': 'Administrator Email',
        'Masuk ke Portal Admin': 'Sign In to Admin Portal',
        'Bukan administrator? Masuk sebagai Pelamar': 'Not an administrator? Sign In as Applicant',
        'Mulai langkah karier Anda bersama PT Sinar Sosro Gunung Slamat.': 'Start your career journey with PT Sinar Sosro Gunung Slamat.',
        'Alamat Email': 'Email Address',
        'Gunakan alamat email resmi yang aktif (contoh: nama@domain.com).': 'Use an active official email address (e.g., name@domain.com).',
        'Minimal 8 karakter.': 'Minimum 8 characters.',
        'Konfirmasi Password': 'Confirm Password',
        'Ulangi password di atas.': 'Repeat the password above.',
        'Daftarkan Akun': 'Create Account',
        'Sudah terdaftar?': 'Already registered?',
        'Masuk di sini': 'Sign in here',
        'PT Sinar Sosro Gunung Slamat. Seluruh data Anda terjaga kerahasiaannya.': 'PT Sinar Sosro Gunung Slamat. All your data is kept strictly confidential.'
    };

    const normalizeText = (str) => (str || '').replace(/\s+/g, ' ').trim();

    function applyTextNodeTranslation(rootNode, lang) {
        if (!rootNode) return;
        const walker = document.createTreeWalker(rootNode, NodeFilter.SHOW_TEXT);
        let node;
        while ((node = walker.nextNode())) {
            const parent = node.parentElement;
            if (!parent) continue;
            if (parent.closest('script, style, [data-i18n-key], [data-i18n-html-locked="1"]')) continue;

            if (node.__origText === undefined) {
                node.__origText = node.nodeValue;
            }

            if (lang === 'en') {
                const match = node.__origText.match(/^(\s*)([\s\S]*?)(\s*)$/);
                if (!match) continue;
                const key = normalizeText(match[2]);
                if (key && phraseMapEn[key] !== undefined) {
                    const nextValue = match[1] + phraseMapEn[key] + match[3];
                    if (node.nodeValue !== nextValue) {
                        node.nodeValue = nextValue;
                    }
                }
            } else if (node.__origText !== undefined && node.nodeValue !== node.__origText) {
                node.nodeValue = node.__origText;
            }
        }
    }

    function setLanguage(lang) {
        localStorage.setItem('preferred_lang', lang);
        applyLanguage(lang);

        const langMenu = document.querySelector('[data-lang-menu]');
        if (langMenu) {
            langMenu.hidden = true;
        }
    }

    function applyLanguage(lang) {
        const normalizedLang = lang === 'en' ? 'en' : 'id';
        document.documentElement.lang = normalizedLang;

        const flagContainer = document.getElementById('current-lang-flag');
        const labelContainer = document.getElementById('current-lang-label');

        if (labelContainer) {
            labelContainer.textContent = normalizedLang.toUpperCase();
        }

        if (flagContainer) {
            if (normalizedLang === 'en') {
                flagContainer.innerHTML = `
                    <svg class="w-full h-full block" viewBox="0 0 60 36">
                        <clipPath id="uk-clip-btn"><rect width="60" height="36" /></clipPath>
                        <g clip-path="url(#uk-clip-btn)">
                            <path d="M0,0 v36 h60 v-36 z" fill="#012169" />
                            <path d="M0,0 L60,36 M60,0 L0,36" stroke="#fff" stroke-width="6" />
                            <path d="M0,0 L60,36 M60,0 L0,36" stroke="#C8102E" stroke-width="3" />
                            <path d="M30,0 v36 M0,18 h60" stroke="#fff" stroke-width="10" />
                            <path d="M30,0 v36 M0,18 h60" stroke="#C8102E" stroke-width="6" />
                        </g>
                    </svg>
                `;
                flagContainer.className = 'inline-block w-5 h-3.5 rounded-[2px] overflow-hidden border border-white/40 shrink-0 shadow-xs';
            } else {
                flagContainer.innerHTML = '<span class="block h-1.75 bg-red-600"></span><span class="block h-1.75 bg-white"></span>';
                flagContainer.className = 'inline-block w-5 h-3.5 rounded-[2px] overflow-hidden shadow-xs border border-white/30 bg-white shrink-0';
            }
        }

        const dict = translations[normalizedLang] || translations.id;

        document.querySelectorAll('[data-i18n-key]').forEach((el) => {
            const key = el.getAttribute('data-i18n-key');
            if (!dict[key]) return;

            if (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') {
                el.placeholder = dict[key];
            } else if (el.querySelector('svg')) {
                el.setAttribute('aria-label', dict[key]);
                el.setAttribute('title', dict[key]);
            } else if (dict[key].includes('<')) {
                el.innerHTML = dict[key];
            } else {
                el.textContent = dict[key];
            }
        });

        document.querySelectorAll('input[placeholder], textarea[placeholder]').forEach((el) => {
            if (el.hasAttribute('data-i18n-key')) return;
            if (el.dataset.origPlaceholder === undefined) {
                el.dataset.origPlaceholder = el.placeholder;
            }
            const orig = el.dataset.origPlaceholder;
            if (normalizedLang === 'en' && placeholderMapEn[orig]) {
                el.placeholder = placeholderMapEn[orig];
            } else {
                el.placeholder = orig;
            }
        });

        document.querySelectorAll('.dropdown-label[data-default]').forEach((labelEl) => {
            if (labelEl.dataset.origDefault === undefined) {
                labelEl.dataset.origDefault = labelEl.dataset.default;
            }
            const origDefault = labelEl.dataset.origDefault;
            const enDefault = dropdownDefaultMapEn[origDefault] || origDefault;
            const targetDefault = normalizedLang === 'en' ? enDefault : origDefault;
            const currentNorm = normalizeText(labelEl.textContent);

            labelEl.dataset.default = targetDefault;
            if (currentNorm === origDefault || currentNorm === enDefault) {
                labelEl.textContent = targetDefault;
            }
        });

        document.querySelectorAll('header h1, header h2, header h3, header p, main h1, main h2, main h3, main p, footer h1, footer h2, footer h3, footer h4, footer p').forEach((el) => {
            if (el.hasAttribute('data-i18n-key') || el.querySelector('[data-i18n-key]')) return;

            if (el.dataset.origHtml === undefined) {
                const norm = normalizeText(el.innerHTML.replace(/<br\s*\/?>/gi, ' ').replace(/<[^>]+>/g, ''));
                if (!htmlBlockMapEn[norm]) return;
                el.dataset.origHtml = el.innerHTML;
                el.dataset.origNorm = norm;
            }

            if (normalizedLang === 'en') {
                el.setAttribute('data-i18n-html-locked', '1');
                el.innerHTML = htmlBlockMapEn[el.dataset.origNorm];
            } else {
                el.removeAttribute('data-i18n-html-locked');
                el.innerHTML = el.dataset.origHtml;
            }
        });

        document.querySelectorAll('header, main, footer').forEach((sectionEl) => {
            applyTextNodeTranslation(sectionEl, normalizedLang);
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        const header = document.getElementById('main-header');
        const langBtn = document.getElementById('lang-menu-btn');
        const isTransparentNav = {{ $isTransparentNav ? 'true' : 'false' }};

        if (header && isTransparentNav) {
            const handleScroll = () => {
                const scrollY = window.scrollY || window.pageYOffset;
                if (scrollY > 50) {
                    header.classList.remove('bg-transparent');
                    header.classList.add('bg-[#B11116]', 'shadow-md', 'backdrop-blur-md');

                    if (langBtn) {
                        langBtn.classList.remove('bg-transparent', 'border-transparent');
                        langBtn.classList.add('bg-black/20', 'border-white/20');
                    }
                } else {
                    header.classList.remove('bg-[#B11116]', 'shadow-md', 'backdrop-blur-md');
                    header.classList.add('bg-transparent');

                    if (langBtn) {
                        langBtn.classList.remove('bg-black/20', 'border-white/20');
                        langBtn.classList.add('bg-transparent', 'border-transparent');
                    }
                }
            };

            window.addEventListener('scroll', handleScroll, { passive: true });
            handleScroll();
        }

        const savedLang = localStorage.getItem('preferred_lang') || 'id';
        applyLanguage(savedLang);

        document.querySelectorAll('.custom-dropdown[data-target="filterBidang"]').forEach((dropdown) => {
            const observeConfig = { childList: true, subtree: true };
            const observer = new MutationObserver(() => {
                const activeLang = localStorage.getItem('preferred_lang') || 'id';
                if (activeLang !== 'en') return;

                observer.disconnect();
                try {
                    const labelEl = dropdown.querySelector('.dropdown-label');
                    if (labelEl && normalizeText(labelEl.textContent) === 'Semua Bidang' && labelEl.textContent !== 'All Fields') {
                        labelEl.textContent = 'All Fields';
                    }
                    const optionsContainer = dropdown.querySelector('.dropdown-options');
                    if (optionsContainer) {
                        applyTextNodeTranslation(optionsContainer, 'en');
                    }
                } finally {
                    observer.observe(dropdown, observeConfig);
                }
            });
            observer.observe(dropdown, observeConfig);
        });
    });

    document.querySelectorAll('[data-lang-menu-root]').forEach((root) => {
        const toggle = root.querySelector('[data-lang-menu-toggle]');
        const menu = root.querySelector('[data-lang-menu]');

        if (!toggle || !menu) return;

        toggle.addEventListener('click', (e) => {
            e.stopPropagation();
            menu.hidden = !menu.hidden;
        });

        document.addEventListener('click', (e) => {
            if (!root.contains(e.target)) {
                menu.hidden = true;
            }
        });
    });

    document.querySelectorAll('[data-account-menu-root]').forEach((root) => {
        const toggle = root.querySelector('[data-account-menu-toggle]');
        const menu = root.querySelector('[data-account-menu]');

        if (!toggle || !menu) {
            return;
        }

        const setMenuOpen = (isOpen) => {
            menu.hidden = !isOpen;
            toggle.setAttribute('aria-expanded', String(isOpen));
        };

        toggle.addEventListener('click', () => {
            setMenuOpen(toggle.getAttribute('aria-expanded') !== 'true');
        });

        document.addEventListener('click', (event) => {
            if (!root.contains(event.target)) {
                setMenuOpen(false);
            }
        });

        root.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && !menu.hidden) {
                setMenuOpen(false);
                toggle.focus();
            }
        });
    });
</script>
