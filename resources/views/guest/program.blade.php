@extends('guest.layouts.index')

@section('title', 'Program')

@section('content')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        .font-brand-scope,
        #beranda-program,
        #beranda-program button,
        #beranda-program a,
        #niat-baik-hasil-baik,
        #detail-program,
        #testimoni-program {
            font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .font-display-title,
        #beranda-program h1,
        #niat-baik-hasil-baik h2,
        #detail-program h2,
        #testimoni-program h2 {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif !important;
            letter-spacing: -0.025em;
        }
    </style>

    <section id="beranda-program"
        class="relative w-full min-h-[560px] sm:min-h-[600px] md:min-h-[640px] lg:min-h-[680px] bg-[#B11116] overflow-hidden flex items-center justify-center pt-28 pb-16 md:pt-32 md:pb-20">

        <div class="absolute inset-0 w-full h-full pointer-events-none select-none overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-b from-[#8f090d] via-[#B11116] to-[#cf162a]"></div>

            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[620px] md:w-[920px] h-[420px] md:h-[580px] rounded-full bg-radial from-[#ff5e3a]/22 via-[#e81928]/25 to-transparent blur-3xl"></div>
            <div class="absolute -top-24 inset-x-0 mx-auto w-[480px] md:w-[680px] h-[320px] rounded-full bg-radial from-[#5c0407]/65 to-transparent blur-3xl"></div>

            <svg class="absolute inset-0 w-full h-full" viewBox="0 0 1440 600" preserveAspectRatio="none" fill="none" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <linearGradient id="programHorizonBack" x1="0%" y1="0%" x2="100%" y2="0%">
                        <stop offset="0%" stop-color="#df1a26" stop-opacity="0.72" />
                        <stop offset="50%" stop-color="#9e0e13" stop-opacity="0.88" />
                        <stop offset="100%" stop-color="#df1a26" stop-opacity="0.72" />
                    </linearGradient>
                    <linearGradient id="programHorizonFront" x1="50%" y1="0%" x2="50%" y2="100%">
                        <stop offset="0%" stop-color="#e8202d" stop-opacity="0.85" />
                        <stop offset="100%" stop-color="#78070b" stop-opacity="0.95" />
                    </linearGradient>
                </defs>

                <circle cx="720" cy="300" r="240" stroke="white" stroke-width="1.2" stroke-dasharray="6 10" opacity="0.16" />
                <circle cx="720" cy="300" r="370" stroke="white" stroke-width="1" stroke-dasharray="4 12" opacity="0.12" />

                <path d="M0,455 C320,535 510,390 720,390 C930,390 1120,535 1440,455 L1440,600 L0,600 Z"
                    fill="url(#programHorizonBack)" />
                <path d="M0,510 C340,565 530,445 720,445 C910,445 1100,565 1440,510 L1440,600 L0,600 Z"
                    fill="url(#programHorizonFront)" />
            </svg>

            <img src="{{ asset('assets/images/sosro-ornament.png') }}" alt=""
                class="absolute -left-10 bottom-10 md:left-6 md:bottom-14 w-40 sm:w-52 md:w-64 object-contain pointer-events-none select-none opacity-20 transform -rotate-12">
            <img src="{{ asset('assets/images/sosro-ornament.png') }}" alt=""
                class="absolute -right-10 bottom-10 md:right-6 md:bottom-14 w-40 sm:w-52 md:w-64 object-contain pointer-events-none select-none opacity-20 transform -scale-x-100 -rotate-12">
        </div>

        <div class="relative z-20 max-w-4xl mx-auto px-6 md:px-12 w-full text-center">
            <h1 data-i18n-key="program_hero_title" style="font-weight: 800;"
                class="font-display-title text-2xl sm:text-4xl md:text-5xl lg:text-[3.25rem] text-white font-extrabold uppercase leading-[1.14] tracking-tight drop-shadow-md">
                PELUANG MENANTI, MARI BERKEMBANG BERSAMA
            </h1>

            <p data-i18n-key="program_hero_desc"
                class="text-white/95 text-sm sm:text-base md:text-lg mt-5 md:mt-6 max-w-2xl mx-auto font-normal leading-relaxed drop-shadow-sm">
                Ikuti kegiatan dan program kami di PT Sinar Sosro Gunung Slamat untuk berkembang, memperluas jaringan, dan meraih kesuksesan bersama.
            </p>
        </div>
    </section>

    @php
        $programItems = [
            [
                'number' => 1,
                'short_title' => "Management\nTrainee",
                'title' => 'MANAGEMENT TRAINEE',
                'title_i18n' => 'prog_mt_title',
                'cover' => 'training sosro.webp',
                'prefix' => 'Program ',
                'highlight' => 'Management Trainee PT Sinar Sosro Gunung Slamat',
                'suffix' => ' merupakan jalur percepatan karier bagi fresh graduate dari berbagai jurusan melalui pelatihan terstruktur dan penugasan lintas unit kerja, guna menyiapkan talenta muda menjadi pemimpin masa depan perusahaan.',
                'desc_i18n' => 'prog_mt_desc',
                'gallery' => [
                    ['image' => 'training sosro.webp', 'alt' => 'Sesi pembekalan Management Trainee'],
                    ['image' => 'our_program.png', 'alt' => 'Kolaborasi proyek Management Trainee'],
                    ['image' => 'outbound_sosro.png', 'alt' => 'Kegiatan team building Management Trainee'],
                    ['image' => 'tentang-hero.webp', 'alt' => 'Pengenalan produk dan lini bisnis Sosro'],
                ],
                'testi_heading' => 'APA KATA MANAGEMENT TRAINEE KAMI?',
                'testi_heading_i18n' => 'prog_mt_testi_title',
                'testimonials' => [
                    ['name' => 'Ahmad Dhani', 'role' => 'MARKETING', 'image' => 'karyawan-4.png', 'quote' => '"Bergabung di SGS dengan filosofi \"Niat Baik Hasil Baik\" membantu saya menerapkan prinsip ini di dunia FMCG. Budaya kekeluargaan di SGS membuat proses belajar sangat bermakna."'],
                    ['name' => 'Rizky Pratama', 'role' => 'SUPPLY CHAIN', 'image' => 'karyawan-3.png', 'quote' => '"Rotasi lintas pabrik dan cabang membuka wawasan saya secara menyeluruh tentang operasional industri minuman berskala nasional."'],
                    ['name' => 'April Riya E.', 'role' => 'PRODUCT PORTFOLIO', 'image' => 'karyawan-1.png', 'quote' => '"Mentoring langsung dari para pemimpin berpengalaman memberi saya kepercayaan diri untuk mengambil tanggung jawab strategis sejak awal karier."'],
                    ['name' => 'Adeline C.', 'role' => 'FINANCE & ACCOUNTING', 'image' => 'karyawan-2.png', 'quote' => '"Program terstruktur ini menantang saya bertumbuh cepat sekaligus menanamkan nilai integritas dan kolaborasi tim."'],
                ],
            ],
            [
                'number' => 2,
                'short_title' => "Guru\nMagang",
                'title' => 'GURU MAGANG',
                'title_i18n' => 'prog_gm_title',
                'cover' => 'kegiatan sosial sosro.webp',
                'prefix' => 'Program ',
                'highlight' => 'Guru Magang PT Sinar Sosro Gunung Slamat',
                'suffix' => ' mendukung peningkatan kompetensi guru produktif SMK melalui pengalaman industri dan praktik kerja langsung, sekaligus membuka peluang PKL bagi siswa SMK yang selaras dengan kebutuhan dunia kerja.',
                'desc_i18n' => 'prog_gm_desc',
                'gallery' => [
                    ['image' => 'kegiatan sosial sosro.webp', 'alt' => 'Penandatanganan kerja sama Program Guru Magang'],
                    ['image' => 'training sosro.webp', 'alt' => 'Workshop dan berbagi wawasan industri'],
                    ['image' => 'outbound_sosro.png', 'alt' => 'Kebersamaan peserta Guru Magang bersama tim Sosro'],
                    ['image' => 'our_program.png', 'alt' => 'Diskusi kurikulum dan praktik kerja industri'],
                ],
                'testi_heading' => 'APA KATA GURU MAGANG KAMI?',
                'testi_heading_i18n' => 'prog_gm_testi_title',
                'testimonials' => [
                    ['name' => 'Suko Drajat', 'role' => 'SMK MITRA INDUSTRI', 'image' => 'karyawan-3.png', 'quote' => '"Pengalaman praktik langsung di fasilitas produksi Sosro memberi wawasan standar industri terkini untuk kami bawa kembali ke ruang kelas."'],
                    ['name' => 'Nadia Putri', 'role' => 'TEKNIK OTOMASI', 'image' => 'karyawan-1.png', 'quote' => '"Tim mentor sangat terbuka membagikan standar keselamatan kerja dan teknologi otomasi yang dibutuhkan lulusan SMK saat ini."'],
                    ['name' => 'Bagas Prakoso', 'role' => 'TEKNIK PEMESINAN', 'image' => 'karyawan-4.png', 'quote' => '"Sinergi antara PT Sinar Sosro Gunung Slamat dan sekolah vokasi sangat membantu menjembatani kurikulum dengan kebutuhan dunia kerja nyata."'],
                    ['name' => 'Rina Kartika', 'role' => 'QUALITY ASSURANCE', 'image' => 'karyawan-2.png', 'quote' => '"Program ini memperkuat kompetensi praktis guru sekaligus membuka jalur pemagangan berkualitas bagi siswa kami."'],
                ],
            ],
            [
                'number' => 3,
                'short_title' => "Pemagangan\nSales",
                'title' => 'PEMAGANGAN SALES',
                'title_i18n' => 'prog_ps_title',
                'cover' => 'our_program.png',
                'prefix' => 'Program ',
                'highlight' => 'Pemagangan Sales PT Sinar Sosro Gunung Slamat',
                'suffix' => ' membekali talenta muda dengan keterampilan penjualan lapangan, strategi distribusi produk, dan pemahaman pasar FMCG secara langsung bersama tim komersial berpengalaman.',
                'desc_i18n' => 'prog_ps_desc',
                'gallery' => [
                    ['image' => 'our_program.png', 'alt' => 'Briefing tim Pemagangan Sales'],
                    ['image' => 'hero-slide-team.jpg', 'alt' => 'Aksi lapangan bersama tim komersial'],
                    ['image' => 'beranda.webp', 'alt' => 'Ragam portofolio produk unggulan Sinar Sosro'],
                    ['image' => 'outbound_sosro.png', 'alt' => 'Kekompakan tim area sales'],
                ],
                'testi_heading' => 'APA KATA PEMAGANGAN SALES KAMI?',
                'testi_heading_i18n' => 'prog_ps_testi_title',
                'testimonials' => [
                    ['name' => 'Dimas Saputra', 'role' => 'SALES & DISTRIBUTION', 'image' => 'karyawan-4.png', 'quote' => '"Terjun langsung ke pasar membuat saya paham teknik negosiasi, pengelolaan outlet, dan ritme distribusi FMCG yang sesungguhnya."'],
                    ['name' => 'Fajar Nugroho', 'role' => 'GENERAL TRADE', 'image' => 'karyawan-3.png', 'quote' => '"Pendampingan supervisor lapangan sangat membantu saya berkembang dari nol hingga percaya diri mencapai target tim."'],
                    ['name' => 'Clara Wijaya', 'role' => 'MODERN TRADE', 'image' => 'karyawan-1.png', 'quote' => '"Setiap hari selalu ada tantangan baru dan kesempatan belajar cara membangun relasi jangka panjang dengan mitra."'],
                    ['name' => 'Melati Kusuma', 'role' => 'AREA PROMOTION', 'image' => 'karyawan-2.png', 'quote' => '"Budaya kerja yang suportif membuat saya menikmati proses belajar strategi pemasaran langsung di lapangan."'],
                ],
            ],
            [
                'number' => 4,
                'short_title' => 'Internship',
                'title' => 'INTERNSHIP',
                'title_i18n' => 'prog_int_title',
                'cover' => 'hero-slide-team.jpg',
                'prefix' => 'Program ',
                'highlight' => 'Internship PT Sinar Sosro Gunung Slamat',
                'suffix' => ' memberikan kesempatan bagi mahasiswa aktif dan lulusan baru untuk terlibat langsung dalam proyek nyata lintas departemen bersama para mentor profesional.',
                'desc_i18n' => 'prog_int_desc',
                'gallery' => [
                    ['image' => 'hero-slide-team.jpg', 'alt' => 'Kegiatan sosial & kolaborasi peserta Internship'],
                    ['image' => 'our_program.png', 'alt' => 'Diskusi proyek lintas tim di kantor'],
                    ['image' => 'training sosro.webp', 'alt' => 'Sesi pembelajaran dan mentoring profesional'],
                    ['image' => 'program-hero.webp', 'alt' => 'Menjadi bagian dari keluarga Insan Sosro'],
                ],
                'testi_heading' => 'APA KATA INTERNSHIP KAMI?',
                'testi_heading_i18n' => 'prog_int_testi_title',
                'testimonials' => [
                    ['name' => 'Kevin Hartanto', 'role' => 'HUMAN CAPITAL', 'image' => 'karyawan-4.png', 'quote' => '"Selama magang saya dipercaya menangani proyek rekrutmen nyata dan mendapat umpan balik konstruktif setiap minggu."'],
                    ['name' => 'Sinta Maharani', 'role' => 'BUSINESS DEVELOPMENT', 'image' => 'karyawan-2.png', 'quote' => '"Lingkungan kerjanya ramah dan kolaboratif; ide dari anak magang pun benar-benar didengarkan dalam diskusi tim."'],
                    ['name' => 'Yusuf Maulana', 'role' => 'INFORMATION TECHNOLOGY', 'image' => 'karyawan-3.png', 'quote' => '"Saya belajar langsung bagaimana sistem digital mendukung proses bisnis perusahaan FMCG berskala besar."'],
                    ['name' => 'Aulia Rahman', 'role' => 'BRAND MARKETING', 'image' => 'karyawan-1.png', 'quote' => '"Pengalaman internship di SGS menjadi pijakan karier terbaik sebelum memasuki dunia kerja penuh waktu."'],
                ],
            ],
        ];
    @endphp

    <section id="niat-baik-hasil-baik" class="relative w-full bg-white pt-16 pb-10 sm:pt-20 sm:pb-12 overflow-hidden">
        <div class="max-w-5xl mx-auto px-6 md:px-10">
            <div class="flex flex-col md:flex-row md:items-stretch gap-8 md:gap-10">

                <div class="md:w-44 lg:w-48 shrink-0 flex flex-col justify-start pt-1">
                    <h2 data-i18n-key="niat_baik_title" style="font-weight: 800;"
                        class="font-display-title text-2xl sm:text-3xl md:text-[2.1rem] font-extrabold text-slate-950 uppercase leading-[1.08] tracking-tight">
                        NIAT<br>BAIK<br>HASIL<br>BAIK.
                    </h2>
                </div>

                <div class="flex-1 grid grid-cols-2 sm:flex sm:flex-row gap-3 md:gap-4 h-auto sm:h-[290px] md:h-[320px]"
                    id="programAccordionGrid">
                    @foreach ($programItems as $idx => $item)
                        @php $isActive = $idx === 0; @endphp
                        <button type="button"
                            data-program-card="{{ $idx }}"
                            aria-pressed="{{ $isActive ? 'true' : 'false' }}"
                            class="program-accordion-card group relative h-48 sm:h-full rounded-2xl overflow-hidden cursor-pointer text-left transition-[flex-grow,box-shadow,transform] duration-500 ease-out focus:outline-none {{ $isActive ? 'sm:flex-[2.6] shadow-xl ring-2 ring-[#B11116]/30' : 'sm:flex-1 shadow-md hover:shadow-lg' }}">

                            <img src="{{ asset('assets/images/' . $item['cover']) }}"
                                alt="{{ $item['title'] }}"
                                class="program-card-img absolute inset-0 w-full h-full object-cover transition-all duration-500 {{ $isActive ? 'grayscale-0 opacity-100 scale-100' : 'grayscale opacity-50 scale-105' }}">

                            <div
                                class="program-card-overlay-collapsed absolute inset-0 bg-gradient-to-b from-white/95 via-[#d86b6f]/75 to-[#B11116] transition-opacity duration-500 {{ $isActive ? 'opacity-0' : 'opacity-100' }}">
                            </div>

                            <div
                                class="program-card-overlay-expanded absolute inset-0 bg-gradient-to-t from-[#B11116] via-[#B11116]/45 to-transparent transition-opacity duration-500 {{ $isActive ? 'opacity-100' : 'opacity-0' }}">
                            </div>

                            <div
                                class="program-card-collapsed absolute inset-x-0 bottom-5 px-2 flex flex-col items-center text-center text-white transition-all duration-300 {{ $isActive ? 'opacity-0 pointer-events-none translate-y-2' : 'opacity-100 translate-y-0' }}">
                                <span class="text-3xl sm:text-4xl font-extrabold leading-none drop-shadow-xs">
                                    {{ $item['number'] }}
                                </span>
                                <span class="w-[1.5px] h-6 bg-white/85 my-2"></span>
                                <span class="text-[11px] sm:text-xs font-bold leading-tight whitespace-pre-line drop-shadow-xs">
                                    {{ $item['short_title'] }}
                                </span>
                            </div>

                            <div
                                class="program-card-expanded absolute inset-x-0 bottom-0 p-4 sm:p-5 flex items-end gap-3 text-white transition-all duration-400 {{ $isActive ? 'opacity-100 translate-y-0' : 'opacity-0 pointer-events-none translate-y-3' }}">
                                <span class="text-4xl sm:text-5xl font-extrabold leading-none drop-shadow-sm shrink-0">
                                    {{ $item['number'] }}
                                </span>
                                <span class="w-[2px] h-10 bg-white/90 shrink-0 mb-0.5"></span>
                                <span class="text-base sm:text-lg font-bold leading-tight whitespace-pre-line drop-shadow-sm">
                                    {{ $item['short_title'] }}
                                </span>
                            </div>
                        </button>
                    @endforeach
                </div>

            </div>
        </div>
    </section>

    <section id="detail-program" class="relative w-full bg-white py-10 sm:py-12 overflow-hidden">
        <div class="max-w-5xl mx-auto px-6 md:px-10">
            @foreach ($programItems as $idx => $item)
                <div class="program-detail-panel {{ $idx === 0 ? 'block opacity-100' : 'hidden opacity-0' }} transition-opacity duration-300"
                    data-program-detail="{{ $idx }}">
                    <div class="text-center max-w-3xl mx-auto">
                        <h2 data-i18n-key="{{ $item['title_i18n'] }}" style="font-weight: 800;"
                            class="font-display-title text-xl sm:text-2xl md:text-[1.65rem] font-extrabold text-slate-950 uppercase tracking-tight">
                            {{ $item['title'] }}
                        </h2>
                        <p class="mt-4 text-slate-700 text-sm sm:text-base leading-relaxed font-normal">
                            {{ $item['prefix'] }}<strong class="font-semibold text-slate-900">{{ $item['highlight'] }}</strong>{{ $item['suffix'] }}
                        </p>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3.5 sm:gap-5 max-w-4xl mx-auto mt-9 sm:mt-11">
                        @foreach ($item['gallery'] as $photo)
                            <div class="group relative aspect-square rounded-2xl overflow-hidden bg-[#B11116]/10 shadow-md hover:shadow-xl transition-all duration-300">
                                <img src="{{ asset('assets/images/' . $photo['image']) }}"
                                    alt="{{ $photo['alt'] }}"
                                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <section id="testimoni-program" class="relative w-full bg-white pt-8 pb-16 sm:pt-10 sm:pb-24 overflow-hidden">
        <div class="max-w-5xl mx-auto px-6 md:px-10">
            @foreach ($programItems as $idx => $item)
                <div class="program-testimoni-panel {{ $idx === 0 ? 'block opacity-100' : 'hidden opacity-0' }} transition-opacity duration-300"
                    data-program-testimoni="{{ $idx }}">
                    <h2 data-i18n-key="{{ $item['testi_heading_i18n'] }}" style="font-weight: 800;"
                        class="font-display-title text-xl sm:text-2xl md:text-[1.65rem] font-extrabold text-slate-950 uppercase tracking-tight text-center mb-9 sm:mb-11">
                        {{ $item['testi_heading'] }}
                    </h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
                        @foreach ($item['testimonials'] as $testi)
                            <div
                                class="group relative bg-white rounded-2xl border border-red-200/80 hover:border-[#B11116] shadow-xs hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden flex flex-col">
                                <div
                                    class="bg-[#B11116] text-white text-center font-extrabold text-xs uppercase tracking-wide overflow-hidden max-h-0 opacity-0 group-hover:max-h-10 group-hover:py-2 group-hover:opacity-100 transition-all duration-300 px-3">
                                    {{ $testi['name'] }}
                                </div>

                                <div class="px-4 pt-6 pb-6 text-center flex-1 flex flex-col items-center">
                                    <div class="w-20 h-20 rounded-full overflow-hidden bg-slate-200 border-2 border-slate-100 shadow-xs shrink-0">
                                        <img src="{{ asset('assets/images/' . $testi['image']) }}"
                                            alt="{{ $testi['name'] }}"
                                            class="w-full h-full object-cover object-top">
                                    </div>

                                    <p class="mt-4 text-[#B11116] font-extrabold text-sm uppercase tracking-tight">
                                        {{ $testi['role'] }}
                                    </p>

                                    <p class="mt-2 text-slate-600 text-xs leading-relaxed">
                                        {{ $testi['quote'] }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const cards = document.querySelectorAll('.program-accordion-card');
            const detailPanels = document.querySelectorAll('.program-detail-panel');
            const testiPanels = document.querySelectorAll('.program-testimoni-panel');
            if (!cards.length) return;

            let activeIdx = 0;

            function activateProgram(targetIdx) {
                if (targetIdx === activeIdx || targetIdx < 0 || targetIdx >= cards.length) {
                    return;
                }

                cards.forEach((card, idx) => {
                    const isCurrent = idx === targetIdx;
                    card.setAttribute('aria-pressed', isCurrent ? 'true' : 'false');

                    card.classList.toggle('sm:flex-[2.6]', isCurrent);
                    card.classList.toggle('shadow-xl', isCurrent);
                    card.classList.toggle('ring-2', isCurrent);
                    card.classList.toggle('ring-[#B11116]/30', isCurrent);

                    card.classList.toggle('sm:flex-1', !isCurrent);
                    card.classList.toggle('shadow-md', !isCurrent);

                    const img = card.querySelector('.program-card-img');
                    if (img) {
                        img.classList.toggle('grayscale-0', isCurrent);
                        img.classList.toggle('opacity-100', isCurrent);
                        img.classList.toggle('scale-100', isCurrent);
                        img.classList.toggle('grayscale', !isCurrent);
                        img.classList.toggle('opacity-50', !isCurrent);
                        img.classList.toggle('scale-105', !isCurrent);
                    }

                    const collapsedOverlay = card.querySelector('.program-card-overlay-collapsed');
                    const expandedOverlay = card.querySelector('.program-card-overlay-expanded');
                    if (collapsedOverlay) {
                        collapsedOverlay.classList.toggle('opacity-0', isCurrent);
                        collapsedOverlay.classList.toggle('opacity-100', !isCurrent);
                    }
                    if (expandedOverlay) {
                        expandedOverlay.classList.toggle('opacity-100', isCurrent);
                        expandedOverlay.classList.toggle('opacity-0', !isCurrent);
                    }

                    const collapsedContent = card.querySelector('.program-card-collapsed');
                    const expandedContent = card.querySelector('.program-card-expanded');
                    if (collapsedContent) {
                        collapsedContent.classList.toggle('opacity-0', isCurrent);
                        collapsedContent.classList.toggle('pointer-events-none', isCurrent);
                        collapsedContent.classList.toggle('translate-y-2', isCurrent);
                        collapsedContent.classList.toggle('opacity-100', !isCurrent);
                        collapsedContent.classList.toggle('translate-y-0', !isCurrent);
                    }
                    if (expandedContent) {
                        expandedContent.classList.toggle('opacity-100', isCurrent);
                        expandedContent.classList.toggle('translate-y-0', isCurrent);
                        expandedContent.classList.toggle('opacity-0', !isCurrent);
                        expandedContent.classList.toggle('pointer-events-none', !isCurrent);
                        expandedContent.classList.toggle('translate-y-3', !isCurrent);
                    }
                });

                const switchPanels = (panels) => {
                    panels.forEach((panel, idx) => {
                        const isCurrent = idx === targetIdx;
                        if (isCurrent) {
                            panel.classList.remove('hidden', 'opacity-0');
                            panel.classList.add('block', 'opacity-100');
                        } else {
                            panel.classList.remove('block', 'opacity-100');
                            panel.classList.add('hidden', 'opacity-0');
                        }
                    });
                };

                switchPanels(detailPanels);
                switchPanels(testiPanels);
                activeIdx = targetIdx;
            }

            cards.forEach((card) => {
                const idx = Number(card.getAttribute('data-program-card'));
                card.addEventListener('mouseenter', () => activateProgram(idx));
                card.addEventListener('click', () => activateProgram(idx));
                card.addEventListener('focus', () => activateProgram(idx));
            });
        });
    </script>
@endsection
