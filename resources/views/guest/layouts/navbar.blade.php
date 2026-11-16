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
    // Kamus Terjemahan Halaman Guest (ID / EN)
    const translations = {
        id: {
            nav_home: 'Beranda',
            nav_about: 'Tentang',
            nav_program: 'Program',
            nav_vacancies: 'Lowongan',
            nav_contact: 'Kontak',
            btn_login: 'Masuk',
            btn_register: 'Daftar',
            hero_title: 'Work Together As A Team',
            hero_desc: 'Bergabunglah bersama kami, talenta muda maupun profesional berpengalaman. Kembangkan potensi terbaikmu dan ciptakan karya berharga di industri FMCG terkemuka Indonesia.',
            hero_tag_1: 'Lingkungan Kolaboratif',
            hero_tag_2: 'Pengembangan Karir',
            hero_tag_3: 'Peluang Nasional',
            hero_kicker_2: 'Warisan & Masa Depan Sosro',
            hero_title_2: 'Be Part of Something Bigger.',
            hero_desc_2: 'Wujudkan ide terbaikmu dan kembangkan potensi tanpa batas bersama keluarga besar Rekso dalam memajukan industri kebanggaan nusantara.',
            hero_title_3: 'Kenali Lebih Dekat Keluarga Sosro',
            hero_desc_3: 'Saksikan bagaimana kebersamaan, dedikasi, dan inovasi mengalir nyata di setiap langkah perjalanan kami menghadirkan yang terbaik bagi Indonesia.',
            hero_btn_explore: 'Jelajahi Lowongan',
            hero_btn_about: 'Tentang Kami',
            hero_company_line: 'PT Sinar Sosro • PT Gunung Slamat • Rekso Group',
            hero_cta_2: 'Lihat Posisi',
            hero_btn: 'Lihat Lowongan',
            section_career_label: 'Karier bersama kami',
            section_career_title: 'Temukan lowongan yang sesuai',
            section_career_desc: 'Gunakan pencarian dan filter untuk menemukan posisi berdasarkan lokasi, kategori, atau bidang pekerjaan.',
            search_placeholder: 'Cari posisi, lokasi, atau kata kunci...',
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
            step_int_title: 'Interview',
            step_int_desc: 'Pendalaman kompetensi, motivasi, dan kesesuaian kandidat.',
            step_case_title: 'Study Case',
            step_case_desc: 'Evaluasi kemampuan analisis dan pemecahan masalah.',
            step_mcu_title: 'MCU',
            step_mcu_desc: 'Medical Check-Up, pemeriksaan kesehatan untuk memastikan kesiapan kerja.',
            step_onboard_title: 'On-Boarding',
            step_onboard_desc: 'Proses pengenalan dan penyesuaian karyawan baru dengan perusahaan.',
            dept_section_title: 'DEPARTEMEN PERUSAHAAN',
            activities_section_title: 'KEGIATAN PERUSAHAAN',
            act_1: 'Kolaborasi Tim Insan Sosro',
            act_2: 'Kebersamaan & Sportivitas Rekso Trofeo',
            act_3: 'Factory Xperience & Pengembangan Talenta',
            act_4: 'Aksi Lingkungan Langkah Prima',
            act_5: 'Kemitraan Pendidikan & Sosial',
            act_6: 'Produk Kebanggaan Sinar Sosro Gunung Slamat',
            program_hero_title: 'PELUANG MENANTI, MARI BERKEMBANG BERSAMA',
            program_hero_desc: 'Ikuti kegiatan dan program kami di PT Sinar Sosro Gunung Slamat untuk berkembang, memperluas jaringan, dan meraih kesuksesan bersama.',
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
            hero_title: 'Work Together As A Team',
            hero_desc: 'Join our team as young talent or experienced professionals. Unleash your greatest potential and build a meaningful career with Indonesia\'s leading FMCG family.',
            hero_tag_1: 'Collaborative Culture',
            hero_tag_2: 'Career Growth',
            hero_tag_3: 'Nationwide Opportunities',
            hero_kicker_2: 'Sosro Legacy & Future',
            hero_title_2: 'Be Part of Something Bigger.',
            hero_desc_2: 'Bring your greatest ideas to life and unlock boundless potential together with the Rekso family in empowering Indonesia\'s proud industry.',
            hero_title_3: 'Get Closer to the Sosro Family',
            hero_desc_3: 'Experience how togetherness, dedication, and innovation come to life in our journey to bring natural goodness to Indonesia.',
            hero_btn_explore: 'Explore Vacancies',
            hero_btn_about: 'About Us',
            hero_company_line: 'PT Sinar Sosro • PT Gunung Slamat • Rekso Group',
            hero_cta_2: 'Explore Roles',
            hero_btn: 'Explore Vacancies',
            section_career_label: 'Career with us',
            section_career_title: 'Find the right opportunity for you',
            section_career_desc: 'Use keyword search and filters to discover positions by location, category, or role.',
            search_placeholder: 'Search by title, location, or keyword...',
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
            career_path_desc: 'PT Sinar Sosro Gunung Slamat is committed to developing every employee’s career through internal programs designed to strengthen competencies and prepare talent to advance to the next career level with confidence.',
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
            activities_section_title: 'COMPANY ACTIVITIES',
            act_1: 'Sosro People Team Collaboration',
            act_2: 'Rekso Trofeo Togetherness & Sportsmanship',
            act_3: 'Factory Xperience & Talent Development',
            act_4: 'Langkah Prima Environmental Action',
            act_5: 'Education & Social Partnership',
            act_6: 'Proud Products of Sinar Sosro Gunung Slamat',
            program_hero_title: 'OPPORTUNITIES AWAIT, LET’S GROW TOGETHER',
            program_hero_desc: 'Join our activities and programs at PT Sinar Sosro Gunung Slamat to grow, expand your network, and achieve success together.',
            prog_mt_testi_title: 'WHAT OUR MANAGEMENT TRAINEES SAY?',
            prog_gm_testi_title: 'WHAT OUR VISITING TEACHERS SAY?',
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

    function setLanguage(lang) {
        localStorage.setItem('preferred_lang', lang);
        applyLanguage(lang);

        // Close dropdown
        const langMenu = document.querySelector('[data-lang-menu]');
        if (langMenu) {
            langMenu.hidden = true;
        }
    }

    function applyLanguage(lang) {
        const flagContainer = document.getElementById('current-lang-flag');
        const labelContainer = document.getElementById('current-lang-label');

        if (labelContainer) {
            labelContainer.textContent = lang.toUpperCase();
        }

        if (flagContainer) {
            if (lang === 'en') {
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

        const dict = translations[lang] || translations.id;

        // Ganti elemen berdasar data-i18n-key
        document.querySelectorAll('[data-i18n-key]').forEach((el) => {
            const key = el.getAttribute('data-i18n-key');
            if (dict[key]) {
                if (el.tagName === 'INPUT') {
                    el.placeholder = dict[key];
                } else if (el.querySelector('svg')) {
                    // Jika elemen berisi icon SVG, update atribut aksesibilitas, jangan timpa SVG-nya
                    el.setAttribute('aria-label', dict[key]);
                    el.setAttribute('title', dict[key]);
                } else {
                    el.textContent = dict[key];
                }
            }
        });
    }

    // Header & Translate Button Scroll Effect: Transparan saat di Jumbotron / Hero, Solid saat discroll
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
            handleScroll(); // Trigger saat load
        }

        // Inisialisasi Bahasa Tersimpan
        const savedLang = localStorage.getItem('preferred_lang') || 'id';
        applyLanguage(savedLang);
    });

    // Language Dropdown Toggle
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

    // Account Dropdown Menu Toggle
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
