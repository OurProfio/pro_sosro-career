@extends('guest.layouts.index')

@section('title', 'Selamat Datang')

@section('content')
    <!-- Google Fonts: Plus Jakarta Sans (Standar Tipografi Korporat Modern & Berkelas) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        /* Tipografi Profesional: Plus Jakarta Sans untuk Seluruh Elemen Modified */
        .font-brand-scope,
        #beranda,
        #beranda input,
        #beranda button,
        #beranda select,
        .custom-dropdown,
        #tentang,
        #produk,
        #perjalanan-karier,
        #program-kami,
        #lowongan,
        #testimoni-karyawan,
        #modalHeroVideo {
            font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        /* Judul Besar / Display Headings: Plus Jakarta Sans SemiBold dengan tracking rapi */
        .font-display-title,
        #beranda h1,
        #beranda h2,
        #tentang h2,
        #tentang h3,
        #produk h2,
        #produk h3,
        #perjalanan-karier h2,
        #perjalanan-karier h3,
        #program-kami h2,
        #program-kami h3,
        #lowongan h2,
        #testimoni-karyawan h2 {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif !important;
            letter-spacing: -0.025em;
        }
    </style>

    <section id="beranda"
        class="relative w-full min-h-[560px] sm:min-h-[600px] md:min-h-[640px] lg:min-h-[680px] bg-[#B11116] overflow-hidden flex flex-col justify-between pt-24 pb-8 md:pt-28 md:pb-10">

        <!-- SLIDES WRAPPER -->
        <div class="absolute inset-0 w-full h-full" id="jumbotronSlider">

            <!-- SLIDE 1 (Text di KIRI, Kurva di KIRI) -->
            <div class="slide-item absolute inset-0 w-full h-full transition-opacity duration-700 ease-in-out opacity-100 z-10"
                data-slide="0">
                <!-- Native Red SVG Curves (Kiri) -->
                <div class="absolute inset-0 w-full h-full pointer-events-none select-none overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-[#c8102e] via-[#B11116] to-[#7f0b0f]"></div>
                    <div
                        class="absolute -top-32 -left-32 w-[600px] md:w-[800px] h-[600px] md:h-[800px] rounded-full bg-radial from-[#e81928]/40 via-[#c8102e]/20 to-transparent blur-2xl">
                    </div>
                    <div
                        class="absolute -bottom-20 -right-20 w-[500px] md:w-[700px] h-[500px] md:h-[700px] rounded-full bg-radial from-[#660508]/60 to-transparent blur-3xl">
                    </div>

                    <!-- SVG Kurva Kiri -->
                    <svg class="absolute inset-0 w-full h-full" viewBox="0 0 1440 600" preserveAspectRatio="none"
                        fill="none" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <linearGradient id="slide1CurveMain" x1="0%" y1="0%" x2="100%"
                                y2="80%">
                                <stop offset="0%" stop-color="#df1a26" stop-opacity="0.9" />
                                <stop offset="40%" stop-color="#B11116" stop-opacity="0.95" />
                                <stop offset="100%" stop-color="#73080c" stop-opacity="0.85" />
                            </linearGradient>
                            <linearGradient id="slide1CurveLayer" x1="20%" y1="0%" x2="80%"
                                y2="100%">
                                <stop offset="0%" stop-color="#e8202d" stop-opacity="0.6" />
                                <stop offset="60%" stop-color="#B11116" stop-opacity="0.75" />
                                <stop offset="100%" stop-color="#8a0c10" stop-opacity="0.9" />
                            </linearGradient>
                            <linearGradient id="slide1WaveBottom" x1="0%" y1="0%" x2="100%"
                                y2="0%">
                                <stop offset="0%" stop-color="#B11116" />
                                <stop offset="45%" stop-color="#c8102e" />
                                <stop offset="100%" stop-color="#8b0a0e" />
                            </linearGradient>
                        </defs>
                        <path
                            d="M0,0 L620,0 C460,140 390,260 450,380 C510,500 680,520 920,540 C1140,558 1320,530 1440,545 L1440,600 L0,600 Z"
                            fill="url(#slide1CurveLayer)" />
                        <path
                            d="M0,0 L490,0 C350,130 300,250 360,370 C420,490 580,515 820,532 C1060,548 1280,522 1440,535 L1440,600 L0,600 Z"
                            fill="url(#slide1CurveMain)" />
                        <path d="M0,480 C260,450 500,515 800,488 C1100,460 1300,505 1440,495 L1440,600 L0,600 Z"
                            fill="url(#slide1WaveBottom)" opacity="0.92" />
                    </svg>

                    <!-- Ornamen Daun & Botol Sosro di Area Kurva Merah Kiri & Gelombang Bawah -->
                    <img src="{{ asset('assets/images/sosro-ornament.png') }}" alt=""
                        class="absolute -left-6 top-14 md:left-4 md:top-18 w-44 sm:w-56 md:w-68 lg:w-76 object-contain pointer-events-none select-none opacity-20 transform -rotate-12">
                    <img src="{{ asset('assets/images/sosro-ornament.png') }}" alt=""
                        class="absolute right-4 bottom-2 md:right-16 md:bottom-4 w-32 sm:w-40 md:w-48 object-contain pointer-events-none select-none opacity-20 transform rotate-45">
                </div>

                <!-- Konten Slide 1 (Kiri) -->
                <div class="relative z-20 max-w-7xl mx-auto px-6 md:px-12 w-full h-full flex items-center">
                    <div class="max-w-md lg:max-w-2xl text-left py-8 md:py-12">
                        <!-- Main Title (Plus Jakarta Sans) -->
                        <h1 data-i18n-key="hero_title"
                            class="font-display-title text-3xl sm:text-4xl md:text-5xl lg:text-[3.75rem] text-white font-semibold leading-[1.08] tracking-tight drop-shadow-md">
                            Work Together<br>As A Team
                        </h1>

                        <!-- Description -->
                        <p data-i18n-key="hero_desc"
                            class="text-white/95 text-sm sm:text-base md:text-lg mt-3.5 md:mt-4.5 max-w-xl font-normal leading-relaxed drop-shadow-sm">
                            Bergabunglah bersama kami, talenta muda maupun profesional berpengalaman. Kembangkan potensi
                            terbaikmu dan ciptakan karya berharga di industri FMCG terkemuka Indonesia.
                        </p>
                    </div>
                </div>
            </div>

            <!-- SLIDE 2 (Struktur Khusus: Impact Card & Skala Heritage Sosro - Berbeda Total dari Slide 1) -->
            <div class="slide-item absolute inset-0 w-full h-full transition-opacity duration-700 ease-in-out opacity-0 pointer-events-none z-0"
                data-slide="1">
                <!-- Native Red SVG Curves (Aliran Gelombang S-Curve Organik Berbeda dari Slide 1) -->
                <div class="absolute inset-0 w-full h-full pointer-events-none select-none overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-bl from-[#c8102e] via-[#B11116] to-[#7f0b0f]"></div>
                    <!-- Radial Glow Hangat khas Seduhan Teh Alami Sosro -->
                    <div
                        class="absolute -top-24 right-1/4 w-[550px] md:w-[750px] h-[550px] md:h-[750px] rounded-full bg-radial from-[#ff6b35]/25 via-[#c8102e]/20 to-transparent blur-3xl">
                    </div>
                    <div
                        class="absolute -bottom-24 -left-24 w-[450px] md:w-[650px] h-[450px] md:h-[650px] rounded-full bg-radial from-[#590407]/70 to-transparent blur-3xl">
                    </div>

                    <!-- SVG S-Curve Organik Dinamis Mengalir dari Kanan Atas ke Tengah Bawah -->
                    <svg class="absolute inset-0 w-full h-full" viewBox="0 0 1440 600" preserveAspectRatio="none"
                        fill="none" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <linearGradient id="slide2MainFlow" x1="100%" y1="10%" x2="0%" y2="90%">
                                <stop offset="0%" stop-color="#df1a26" stop-opacity="0.95" />
                                <stop offset="50%" stop-color="#B11116" stop-opacity="0.95" />
                                <stop offset="100%" stop-color="#690609" stop-opacity="0.9" />
                            </linearGradient>
                            <linearGradient id="slide2RippleLayer" x1="90%" y1="0%" x2="10%"
                                y2="100%">
                                <stop offset="0%" stop-color="#ff3b47" stop-opacity="0.5" />
                                <stop offset="60%" stop-color="#B11116" stop-opacity="0.7" />
                                <stop offset="100%" stop-color="#73080c" stop-opacity="0.85" />
                            </linearGradient>
                        </defs>
                        <!-- Layer Belakang S-Curve -->
                        <path d="M1440,0 L760,0 C880,140 640,260 700,390 C760,510 540,550 420,600 L1440,600 Z"
                            fill="url(#slide2RippleLayer)" />
                        <!-- Layer Depan S-Curve Mengalir -->
                        <path d="M1440,0 L880,0 C990,120 740,230 790,370 C840,490 660,535 520,600 L1440,600 Z"
                            fill="url(#slide2MainFlow)" />
                    </svg>

                    <!-- Ornamen Daun & Botol Sosro Mengikuti Lekukan S-Curve Kanan -->
                    <img src="{{ asset('assets/images/sosro-ornament.png') }}" alt=""
                        class="absolute right-4 top-10 md:right-16 md:top-14 w-40 sm:w-52 md:w-64 object-contain pointer-events-none select-none opacity-25 transform rotate-6">
                    <img src="{{ asset('assets/images/sosro-ornament.png') }}" alt=""
                        class="absolute right-1/3 bottom-4 w-32 sm:w-44 md:w-52 object-contain pointer-events-none select-none opacity-15 transform -rotate-45 hidden md:block">
                </div>

                <!-- Konten Slide 2 (Kanan: Be Part of Something Bigger) -->
                <div class="relative z-20 max-w-7xl mx-auto px-6 md:px-12 w-full h-full flex items-center justify-end">
                    <div class="max-w-md lg:max-w-2xl text-left py-8 md:py-12">
                        <!-- Main Title (Plus Jakarta Sans) -->
                        <h2 data-i18n-key="hero_title_2"
                            class="font-display-title text-3xl sm:text-4xl md:text-5xl lg:text-[3.75rem] text-white font-semibold leading-[1.08] tracking-tight drop-shadow-md">
                            Be Part of<br>Something Bigger
                        </h2>

                        <!-- Description -->
                        <p data-i18n-key="hero_desc_2"
                            class="text-white/95 text-sm sm:text-base md:text-lg mt-3.5 md:mt-4.5 max-w-xl font-normal leading-relaxed drop-shadow-sm">
                            Wujudkan ide terbaikmu dan kembangkan potensi tanpa batas bersama keluarga besar Rekso dalam
                            memajukan industri kebanggaan nusantara.
                        </p>
                    </div>
                </div>
            </div>

            <!-- SLIDE 3 (Adaptasi Desain Slide 1 & 2: Video Showcase Interaktif & Narasi Sosro) -->
            <div class="slide-item absolute inset-0 w-full h-full transition-opacity duration-700 ease-in-out opacity-0 pointer-events-none z-0"
                data-slide="2">
                <!-- Native Red SVG Curves & Glow (Harmonis dengan Slide 1 & 2) -->
                <div class="absolute inset-0 w-full h-full pointer-events-none select-none overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-[#c8102e] via-[#B11116] to-[#72070c]"></div>
                    <!-- Radial Glow Hangat Merah & Teh -->
                    <div
                        class="absolute -top-28 left-1/3 w-[650px] md:w-[850px] h-[650px] md:h-[850px] rounded-full bg-radial from-[#ff5b36]/20 via-[#c8102e]/15 to-transparent blur-3xl">
                    </div>
                    <div
                        class="absolute -bottom-28 right-0 w-[550px] md:w-[750px] h-[550px] md:h-[750px] rounded-full bg-radial from-[#550407]/70 to-transparent blur-3xl">
                    </div>

                    <!-- SVG Organic Fluid Wave Curves -->
                    <svg class="absolute inset-0 w-full h-full" viewBox="0 0 1440 600" preserveAspectRatio="none"
                        fill="none" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <linearGradient id="slide3CurveMain" x1="0%" y1="100%" x2="100%"
                                y2="0%">
                                <stop offset="0%" stop-color="#df1a26" stop-opacity="0.9" />
                                <stop offset="50%" stop-color="#B11116" stop-opacity="0.95" />
                                <stop offset="100%" stop-color="#690609" stop-opacity="0.85" />
                            </linearGradient>
                            <linearGradient id="slide3CurveLayer" x1="10%" y1="90%" x2="90%"
                                y2="10%">
                                <stop offset="0%" stop-color="#ff3b47" stop-opacity="0.45" />
                                <stop offset="50%" stop-color="#B11116" stop-opacity="0.65" />
                                <stop offset="100%" stop-color="#73080c" stop-opacity="0.85" />
                            </linearGradient>
                        </defs>
                        <path d="M0,600 L0,320 C240,280 480,380 720,340 C960,300 1200,160 1440,180 L1440,600 Z"
                            fill="url(#slide3CurveLayer)" />
                        <path d="M0,600 L0,380 C260,330 500,430 760,390 C1020,350 1240,220 1440,230 L1440,600 Z"
                            fill="url(#slide3CurveMain)" />
                    </svg>

                    <!-- Ornamen Daun Teh & Botol Sosro -->
                    <img src="{{ asset('assets/images/sosro-ornament.png') }}" alt=""
                        class="absolute left-6 bottom-4 md:left-12 md:bottom-8 w-44 sm:w-56 md:w-64 object-contain pointer-events-none select-none opacity-20 transform -rotate-12">
                    <img src="{{ asset('assets/images/sosro-ornament.png') }}" alt=""
                        class="absolute right-4 top-8 md:right-12 md:top-12 w-44 sm:w-56 md:w-64 object-contain pointer-events-none select-none opacity-20 transform rotate-12">
                </div>

                <!-- Konten Slide 3: 2-Kolom Seimbang (Teks Kiri, Video Card Kanan) -->
                <div class="relative z-20 max-w-7xl mx-auto px-6 md:px-12 w-full h-full flex items-center py-6 md:py-8">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center w-full">
                        <!-- Kolom Teks (Kiri) -->
                        <div class="lg:col-span-6 text-left">
                            <!-- Main Title (Plus Jakarta Sans) -->
                            <h2 data-i18n-key="hero_title_3"
                                class="font-display-title text-3xl sm:text-4xl md:text-5xl lg:text-[3.5rem] text-white font-semibold leading-[1.1] tracking-tight drop-shadow-md">
                                Kenali Lebih Dekat<br>Keluarga Sosro
                            </h2>

                            <!-- Description -->
                            <p data-i18n-key="hero_desc_3"
                                class="text-white/95 text-sm sm:text-base md:text-lg mt-3.5 md:mt-4.5 max-w-xl font-normal leading-relaxed drop-shadow-sm">
                                Saksikan bagaimana kebersamaan, dedikasi, dan inovasi mengalir nyata di setiap langkah
                                perjalanan kami menghadirkan yang terbaik bagi Indonesia.
                            </p>
                        </div>

                        <!-- Kolom Video Player Card (Kanan) -->
                        <div class="lg:col-span-6 flex justify-center lg:justify-end">
                            <div
                                class="relative w-full max-w-md lg:max-w-lg aspect-video rounded-3xl overflow-hidden shadow-2xl shadow-black/40 border-2 border-white/25 bg-black/60 group transition-all duration-300 hover:shadow-red-950/50 hover:border-white/40">
                                <!-- YouTube Video Embed: Autoplay muted saat slide aktif -->
                                <iframe id="slideHeroVideoIframe" class="w-full h-full object-cover"
                                    src="https://www.youtube-nocookie.com/embed/LXb3EKWsInQ?enablejsapi=1&mute=1&loop=1&playlist=LXb3EKWsInQ&controls=1&rel=0&modestbranding=1"
                                    title="Sosro Story Video" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen>
                                </iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Slider Navigation Controls (Dots & Arrows) -->
        <div class="relative z-30 max-w-7xl mx-auto px-6 md:px-12 w-full flex items-center justify-between mb-3 mt-auto">
            <!-- Slider Dots Indicator -->
            <div class="flex items-center gap-2" id="sliderDots">
                <button type="button"
                    class="slider-dot w-8 h-2 rounded-full bg-white transition-all duration-300 cursor-pointer shadow-xs"
                    data-target="0" aria-label="Slide 1"></button>
                <button type="button"
                    class="slider-dot w-2 h-2 rounded-full bg-white/40 hover:bg-white/70 transition-all duration-300 cursor-pointer shadow-xs"
                    data-target="1" aria-label="Slide 2"></button>
                <button type="button"
                    class="slider-dot w-2 h-2 rounded-full bg-white/40 hover:bg-white/70 transition-all duration-300 cursor-pointer shadow-xs"
                    data-target="2" aria-label="Slide 3"></button>
            </div>

            <!-- Slide Arrows (Left / Right) -->
            <div class="hidden sm:flex items-center gap-2">
                <button type="button" id="prevSlideBtn" aria-label="Slide Sebelumnya"
                    class="cursor-pointer hover:cursor-pointer flex h-8 w-8 items-center justify-center rounded-full bg-black/20 hover:bg-black/35 text-white backdrop-blur-sm border border-white/20 transition active:scale-95">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button type="button" id="nextSlideBtn" aria-label="Slide Berikutnya"
                    class="cursor-pointer hover:cursor-pointer flex h-8 w-8 items-center justify-center rounded-full bg-black/20 hover:bg-black/35 text-white backdrop-blur-sm border border-white/20 transition active:scale-95">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Floating Search & Filter Bar (Desain Mockup + Custom Themed Dropdowns + HCI Search Button) -->
        <div class="relative z-30 max-w-6xl mx-auto px-4 sm:px-6 w-full mt-3">
            <div class="flex flex-col md:flex-row items-stretch md:items-center gap-2.5 sm:gap-3">
                <!-- Search Input Pill -->
                <div
                    class="h-11 sm:h-12 flex-1 relative flex items-center bg-white rounded-full shadow-lg shadow-black/10 pl-5 pr-3 transition-all duration-200 hover:shadow-xl focus-within:ring-2 focus-within:ring-[#B11116]/30">
                    <label for="jobSearch" class="sr-only">Cari lowongan</label>
                    <input id="jobSearch" type="search" placeholder="Cari lowongan..."
                        data-i18n-key="search_placeholder"
                        class="w-full bg-transparent pr-2 text-xs sm:text-sm text-slate-800 placeholder:text-[#c77a87] focus:outline-none font-semibold border-0 focus:ring-0 [&::-webkit-search-cancel-button]:hidden" />

                    <!-- One-Click Clear Button (Nielsen Heuristic: User Control & Freedom) -->
                    <button type="button" id="btnClearSearch" aria-label="Hapus kata kunci pencarian"
                        title="Hapus teks pencarian"
                        class="hidden cursor-pointer p-1 rounded-full text-slate-400 hover:text-red-700 hover:bg-red-50 transition active:scale-90">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Hidden native selects to retain full JS & backend compatibility -->
                <select id="filterLocation" class="hidden">
                    <option value="">Semua Lokasi</option>
                    @foreach ($jobs->pluck('location')->unique()->filter()->values() as $loc)
                        <option value="{{ $loc }}">{{ $loc }}</option>
                    @endforeach
                </select>

                <select id="filterCategory" class="hidden">
                    <option value="">Semua Kategori</option>
                    @foreach ($jobs->pluck('category')->unique()->filter()->values() as $cat)
                        <option value="{{ $cat }}">{{ ucwords(str_replace('_', ' ', $cat)) }}</option>
                    @endforeach
                </select>

                <select id="filterBidang" class="hidden">
                    <option value="">Semua Bidang</option>
                    @foreach ($jobs->pluck('occupation')->unique()->filter()->values() as $occ)
                        <option value="{{ $occ }}">{{ $occ }}</option>
                    @endforeach
                </select>

                <!-- Location Custom Themed Dropdown -->
                <div class="custom-dropdown relative w-full md:w-auto" data-target="filterLocation">
                    <button type="button"
                        class="dropdown-trigger h-11 sm:h-12 w-full md:w-auto cursor-pointer rounded-full bg-white pl-5 pr-4 text-xs sm:text-sm font-semibold text-[#c77a87] shadow-lg shadow-black/10 hover:shadow-xl transition-all duration-200 flex items-center justify-between gap-3 border border-transparent hover:border-red-100 focus:outline-none focus:ring-2 focus:ring-[#B11116]/30">
                        <span class="dropdown-label truncate" data-default="Semua Lokasi">Semua Lokasi</span>
                        <svg class="dropdown-chevron w-4 h-4 shrink-0 text-[#a30f28] transition-transform duration-200"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="m6 9 6 6 6-6" />
                        </svg>
                    </button>
                    <!-- Custom Themed Option Menu -->
                    <div
                        class="dropdown-menu hidden absolute left-0 top-full mt-2 w-full md:w-56 bg-white/95 backdrop-blur-md rounded-2xl shadow-2xl border border-red-100/90 py-1.5 z-50 transform origin-top transition-all duration-200">
                        <div class="dropdown-options max-h-56 overflow-y-auto px-1.5 space-y-0.5">
                            <button type="button" data-value=""
                                class="dropdown-option w-full text-left px-3.5 py-2.5 rounded-xl text-xs sm:text-sm font-medium text-[#B11116] bg-red-50/70 hover:bg-red-50 flex items-center justify-between transition cursor-pointer">
                                <span>Semua Lokasi</span>
                                <svg class="option-check w-4 h-4 text-[#B11116]" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                            @foreach ($jobs->pluck('location')->unique()->filter()->values() as $loc)
                                <button type="button" data-value="{{ $loc }}"
                                    class="dropdown-option w-full text-left px-3.5 py-2.5 rounded-xl text-xs sm:text-sm font-medium text-slate-700 hover:text-[#B11116] hover:bg-red-50/80 flex items-center justify-between transition cursor-pointer">
                                    <span>{{ $loc }}</span>
                                    <svg class="option-check hidden w-4 h-4 text-[#B11116]" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Category Custom Themed Dropdown -->
                <div class="custom-dropdown relative w-full md:w-auto" data-target="filterCategory">
                    <button type="button"
                        class="dropdown-trigger h-11 sm:h-12 w-full md:w-auto cursor-pointer rounded-full bg-white pl-5 pr-4 text-xs sm:text-sm font-semibold text-[#c77a87] shadow-lg shadow-black/10 hover:shadow-xl transition-all duration-200 flex items-center justify-between gap-3 border border-transparent hover:border-red-100 focus:outline-none focus:ring-2 focus:ring-[#B11116]/30">
                        <span class="dropdown-label truncate" data-default="Semua Kategori">Semua Kategori</span>
                        <svg class="dropdown-chevron w-4 h-4 shrink-0 text-[#a30f28] transition-transform duration-200"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="m6 9 6 6 6-6" />
                        </svg>
                    </button>
                    <!-- Custom Themed Option Menu -->
                    <div
                        class="dropdown-menu hidden absolute left-0 top-full mt-2 w-full md:w-60 bg-white/95 backdrop-blur-md rounded-2xl shadow-2xl border border-red-100/90 py-1.5 z-50 transform origin-top transition-all duration-200">
                        <div class="dropdown-options max-h-56 overflow-y-auto px-1.5 space-y-0.5">
                            <button type="button" data-value=""
                                class="dropdown-option w-full text-left px-3.5 py-2.5 rounded-xl text-xs sm:text-sm font-medium text-[#B11116] bg-red-50/70 hover:bg-red-50 flex items-center justify-between transition cursor-pointer">
                                <span>Semua Kategori</span>
                                <svg class="option-check w-4 h-4 text-[#B11116]" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                            @foreach ($jobs->pluck('category')->unique()->filter()->values() as $cat)
                                <button type="button" data-value="{{ $cat }}"
                                    class="dropdown-option w-full text-left px-3.5 py-2.5 rounded-xl text-xs sm:text-sm font-medium text-slate-700 hover:text-[#B11116] hover:bg-red-50/80 flex items-center justify-between transition cursor-pointer">
                                    <span>{{ ucwords(str_replace('_', ' ', $cat)) }}</span>
                                    <svg class="option-check hidden w-4 h-4 text-[#B11116]" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Bidang Custom Themed Dropdown -->
                <div class="custom-dropdown relative w-full md:w-auto" data-target="filterBidang">
                    <button type="button"
                        class="dropdown-trigger h-11 sm:h-12 w-full md:w-auto cursor-pointer rounded-full bg-white pl-5 pr-4 text-xs sm:text-sm font-semibold text-[#c77a87] shadow-lg shadow-black/10 hover:shadow-xl transition-all duration-200 flex items-center justify-between gap-3 border border-transparent hover:border-red-100 focus:outline-none focus:ring-2 focus:ring-[#B11116]/30">
                        <span class="dropdown-label truncate" data-default="Semua Bidang">Semua Bidang</span>
                        <svg class="dropdown-chevron w-4 h-4 shrink-0 text-[#a30f28] transition-transform duration-200"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="m6 9 6 6 6-6" />
                        </svg>
                    </button>
                    <!-- Custom Themed Option Menu -->
                    <div
                        class="dropdown-menu hidden absolute left-0 top-full mt-2 w-full md:w-56 bg-white/95 backdrop-blur-md rounded-2xl shadow-2xl border border-red-100/90 py-1.5 z-50 transform origin-top transition-all duration-200">
                        <div class="dropdown-options max-h-56 overflow-y-auto px-1.5 space-y-0.5">
                            <button type="button" data-value=""
                                class="dropdown-option w-full text-left px-3.5 py-2.5 rounded-xl text-xs sm:text-sm font-medium text-[#B11116] bg-red-50/70 hover:bg-red-50 flex items-center justify-between transition cursor-pointer">
                                <span>Semua Bidang</span>
                                <svg class="option-check w-4 h-4 text-[#B11116]" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                            @foreach ($jobs->pluck('occupation')->unique()->filter()->values() as $occ)
                                <button type="button" data-value="{{ $occ }}"
                                    class="dropdown-option w-full text-left px-3.5 py-2.5 rounded-xl text-xs sm:text-sm font-medium text-slate-700 hover:text-[#B11116] hover:bg-red-50/80 flex items-center justify-between transition cursor-pointer">
                                    <span>{{ $occ }}</span>
                                    <svg class="option-check hidden w-4 h-4 text-[#B11116]" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Standalone Search CTA Button (Warna Merah Lebih Terang) -->
                <button type="button" id="btnSearch" aria-label="Cari lowongan" title="Cari (Tekan Enter)"
                    class="h-11 sm:h-12 px-6 sm:px-7 shrink-0 cursor-pointer rounded-full bg-[#dc2626] hover:bg-[#b91c1c] active:bg-[#991b1b] text-white text-xs sm:text-sm font-semibold shadow-lg shadow-black/20 hover:shadow-xl transition-all duration-200 hover:scale-[1.03] active:scale-[0.97] flex items-center justify-center gap-2 border-2 border-white/45 hover:border-white/75 focus:outline-none focus:ring-2 focus:ring-white/60 focus:ring-offset-2 focus:ring-offset-[#B11116]">
                    <svg class="h-4 w-4 sm:h-4.5 sm:w-4.5 text-white shrink-0" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="m21 21-4.35-4.35m1.35-5.4a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0Z" />
                    </svg>
                    <span data-i18n-key="search_btn">Cari</span>
                </button>
            </div>
        </div>
    </section>

    <!-- SECTION: TENTANG KAMI (TEKS STATIS + SLIDER GAMBAR) & NILAI PERUSAHAAN (GRID STATIS) -->
    <section id="tentang" class="relative w-full overflow-hidden">
        <!-- 1. Bagian Atas: Tentang Kami Showcase (Teks Statis + Slider Khusus Gambar + Pattern Bintik Gradasi & Ornamen Daun Teh) -->
        <div
            class="relative bg-gradient-to-b from-white via-[#fffafa] to-white pt-16 pb-32 sm:pt-20 sm:pb-40 md:pt-24 md:pb-48 overflow-hidden border-t border-red-100/50">
            <!-- Layer 1: Micro Dot-Matrix Pattern Bintik-Bintik Halus -->
            <div
                class="absolute inset-0 bg-[radial-gradient(#e5e7eb_1.3px,transparent_1.3px)] [background-size:22px_22px] opacity-60 pointer-events-none select-none">
            </div>

            <!-- Layer 2: Ambient Radial Glow Gradasi Hangat -->
            <div
                class="absolute -top-28 -left-28 w-[500px] h-[500px] rounded-full bg-radial from-red-100/65 via-rose-50/30 to-transparent blur-3xl pointer-events-none">
            </div>
            <div
                class="absolute top-1/3 left-1/3 w-[420px] h-[420px] rounded-full bg-radial from-amber-50/70 via-red-50/20 to-transparent blur-3xl pointer-events-none">
            </div>
            <div
                class="absolute -bottom-24 -right-24 w-[520px] h-[520px] rounded-full bg-radial from-red-100/55 via-amber-50/25 to-transparent blur-3xl pointer-events-none">
            </div>

            <!-- Layer 3: Ornamen Bulet-Bulet (Floating Circles) Halus tanpa Daun Teh -->
            <div class="absolute inset-0 pointer-events-none select-none overflow-hidden">
                <span class="absolute top-12 left-[12%] w-4 h-4 rounded-full bg-amber-300/45"></span>
                <span class="absolute top-24 left-[18%] w-2.5 h-2.5 rounded-full bg-red-300/40"></span>
                <span class="absolute bottom-36 left-[10%] w-6 h-6 rounded-full bg-orange-200/50"></span>
                <span class="absolute bottom-28 left-[26%] w-3.5 h-3.5 rounded-full bg-red-300/35"></span>
                <span class="absolute top-16 left-[46%] w-3 h-3 rounded-full bg-amber-300/40"></span>
                <span class="absolute bottom-40 left-[44%] w-5 h-5 rounded-full bg-amber-200/50"></span>
            </div>

            <div class="relative z-10 max-w-6xl mx-auto px-6">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                    <!-- Kolom Teks Quote Kiri (STATIS) -->
                    <div class="lg:col-span-6 flex flex-col justify-center text-left pr-0 lg:pr-4">
                        <div class="relative py-2">
                            <span
                                class="text-[#B11116] text-5xl sm:text-6xl font-serif leading-none select-none block -mb-3 sm:-mb-4">“</span>
                            <p
                                class="text-slate-800 text-base sm:text-lg md:text-xl lg:text-[1.35rem] leading-relaxed font-normal pl-3 sm:pl-4">
                                <span class="text-[#B11116] font-semibold">PT Sinar Sosro Gunung Slamat</span> yang
                                diresmikan pada 2 Desember 2024 merupakan gabungan dari dua perusahaan. PT Sinar Sosro,
                                pelopor teh siap minum dalam kemasan botol pertama di Indonesia & dunia, dengan PT Gunung
                                Slamat, perusahaan tertua di Rekso Group yang berdiri sejak 1940.
                            </p>
                            <span
                                class="text-[#B11116] text-5xl sm:text-6xl font-serif leading-none select-none block text-right mt-1">”</span>
                        </div>
                    </div>

                    <!-- Kolom Gambar Kanan (SLIDER HANYA PADA GAMBAR) -->
                    <div class="lg:col-span-6 flex flex-col items-center w-full" id="aboutPhotoSliderCard">
                        <div class="relative w-full aspect-[4/3] sm:aspect-[16/10] md:aspect-[4/3] max-w-lg lg:max-w-none">
                            <!-- Dekorasi Pinggiran Foto: Layered Offset Sesuai Warna Utama (#B11116) -->
                            <div
                                class="absolute -bottom-3.5 -right-3.5 w-full h-full rounded-3xl bg-gradient-to-br from-[#B11116]/25 via-red-200/65 to-rose-200/75 -z-10 transform rotate-2">
                            </div>
                            <div
                                class="absolute -top-3.5 -left-3.5 w-full h-full rounded-3xl border-2 border-[#B11116]/30 bg-red-50/35 -z-10 transform -rotate-1">
                            </div>

                            <!-- Photo Slides Container -->
                            <div
                                class="relative w-full h-full rounded-3xl overflow-hidden shadow-2xl shadow-red-950/10 border-2 border-white group bg-slate-100">
                                <!-- Photo 1: Griya Rekso Head Office -->
                                <div class="about-photo-slide absolute inset-0 w-full h-full transition-opacity duration-700 ease-in-out opacity-100 z-10"
                                    data-photo-idx="0">
                                    <img src="{{ asset('assets/images/beranda.webp') }}" alt="Griya Rekso Head Office"
                                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                                    <!-- Location Badge dengan Map Pin Icon -->
                                    <div
                                        class="absolute bottom-3.5 left-3.5 z-20 inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white/95 backdrop-blur-md shadow-md text-xs font-semibold text-slate-800 border border-white/70">
                                        <svg class="w-3.5 h-3.5 text-[#B11116] shrink-0" viewBox="0 0 24 24"
                                            fill="currentColor">
                                            <path
                                                d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5 2.5 2.5z" />
                                        </svg>
                                        <span>Griya Rekso, Head Office</span>
                                    </div>
                                </div>

                                <!-- Photo 2: Pabrik & Fasilitas Produksi Slawi -->
                                <div class="about-photo-slide absolute inset-0 w-full h-full transition-opacity duration-700 ease-in-out opacity-0 pointer-events-none z-0"
                                    data-photo-idx="1">
                                    <img src="{{ asset('assets/images/tentang-hero.webp') }}"
                                        alt="Pabrik dan Fasilitas Produksi"
                                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                                    <!-- Location Badge dengan Map Pin Icon -->
                                    <div
                                        class="absolute bottom-3.5 left-3.5 z-20 inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white/95 backdrop-blur-md shadow-md text-xs font-semibold text-slate-800 border border-white/70">
                                        <svg class="w-3.5 h-3.5 text-[#B11116] shrink-0" viewBox="0 0 24 24"
                                            fill="currentColor">
                                            <path
                                                d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5 2.5 2.5z" />
                                        </svg>
                                        <span>Pabrik, Slawi</span>
                                    </div>
                                </div>

                                <!-- Photo 3: Graha Rekso & Operational Hub -->
                                <div class="about-photo-slide absolute inset-0 w-full h-full transition-opacity duration-700 ease-in-out opacity-0 pointer-events-none z-0"
                                    data-photo-idx="2">
                                    <img src="{{ asset('assets/images/header-sosro-rekso.png') }}"
                                        alt="Graha Rekso Operational Hub"
                                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                                    <!-- Location Badge dengan Map Pin Icon -->
                                    <div
                                        class="absolute bottom-3.5 left-3.5 z-20 inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white/95 backdrop-blur-md shadow-md text-xs font-semibold text-slate-800 border border-white/70">
                                        <svg class="w-3.5 h-3.5 text-[#B11116] shrink-0" viewBox="0 0 24 24"
                                            fill="currentColor">
                                            <path
                                                d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5 2.5 2.5z" />
                                        </svg>
                                        <span>Griya Rekso & Operational Hub</span>
                                    </div>
                                </div>

                                <!-- Photo 4: Pusat Pelatihan & Pengembangan Talenta -->
                                <div class="about-photo-slide absolute inset-0 w-full h-full transition-opacity duration-700 ease-in-out opacity-0 pointer-events-none z-0"
                                    data-photo-idx="3">
                                    <img src="{{ asset('assets/images/training sosro.webp') }}"
                                        alt="Pusat Pelatihan dan Pengembangan"
                                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                                    <!-- Location Badge dengan Map Pin Icon -->
                                    <div
                                        class="absolute bottom-3.5 left-3.5 z-20 inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white/95 backdrop-blur-md shadow-md text-xs font-semibold text-slate-800 border border-white/70">
                                        <svg class="w-3.5 h-3.5 text-[#B11116] shrink-0" viewBox="0 0 24 24"
                                            fill="currentColor">
                                            <path
                                                d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5 2.5 2.5z" />
                                        </svg>
                                        <span>Pusat Pelatihan & Pengembangan</span>
                                    </div>
                                </div>

                                <!-- Prev & Next Arrows (Langsung di Atas Gambar) -->
                                <button type="button" id="aboutPhotoPrevBtn" aria-label="Foto Sebelumnya"
                                    class="cursor-pointer z-20 absolute left-3 top-1/2 -translate-y-1/2 flex h-8 w-8 sm:h-9 sm:w-9 items-center justify-center rounded-full bg-black/40 hover:bg-black/65 text-white backdrop-blur-sm border border-white/20 transition active:scale-95 shadow-md">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M15 19l-7-7 7-7" />
                                    </svg>
                                </button>
                                <button type="button" id="aboutPhotoNextBtn" aria-label="Foto Berikutnya"
                                    class="cursor-pointer z-20 absolute right-3 top-1/2 -translate-y-1/2 flex h-8 w-8 sm:h-9 sm:w-9 items-center justify-center rounded-full bg-black/40 hover:bg-black/65 text-white backdrop-blur-sm border border-white/20 transition active:scale-95 shadow-md">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Dots Pagination Khusus Slider Gambar -->
                        <div class="flex items-center justify-center gap-2 mt-5 sm:mt-6" id="aboutPhotoDots">
                            <button type="button"
                                class="about-photo-dot w-7 h-2 rounded-full bg-[#B11116] transition-all duration-300 cursor-pointer shadow-xs"
                                data-photo-target="0" aria-label="Foto 1"></button>
                            <button type="button"
                                class="about-photo-dot w-2 h-2 rounded-full bg-red-200 hover:bg-red-300 transition-all duration-300 cursor-pointer shadow-xs"
                                data-photo-target="1" aria-label="Foto 2"></button>
                            <button type="button"
                                class="about-photo-dot w-2 h-2 rounded-full bg-red-200 hover:bg-red-300 transition-all duration-300 cursor-pointer shadow-xs"
                                data-photo-target="2" aria-label="Foto 3"></button>
                            <button type="button"
                                class="about-photo-dot w-2 h-2 rounded-full bg-red-200 hover:bg-red-300 transition-all duration-300 cursor-pointer shadow-xs"
                                data-photo-target="3" aria-label="Foto 4"></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Bagian Bawah: NILAI PERUSAHAAN (Tanpa Fill Putih di Atas Kurva Agar Daun Teh Section Sebelumnya Tidak Tertutup) -->
        <div id="nilaiPerusahaanSection"
            class="relative z-10 w-full -mt-24 sm:-mt-32 md:-mt-40 lg:-mt-44 pt-28 pb-24 sm:pt-36 sm:pb-28 md:pt-44 md:pb-32 overflow-hidden bg-transparent">

            <!-- Kurva S-Curve Atas + Pita Gradasi Merah-Coral (Area Atas Kurva 100% Transparan Tanpa Putih) -->
            <div
                class="absolute top-0 inset-x-0 w-full h-24 sm:h-32 md:h-40 lg:h-44 overflow-hidden leading-none pointer-events-none select-none z-10">
                <svg class="relative block w-full h-full" viewBox="0 0 1440 220" preserveAspectRatio="none">
                    <defs>
                        <!-- Gradasi Pita S-Curve (Merah -> Coral Pink Terang -> Merah) -->
                        <linearGradient id="nilaiRibbonGrad" x1="0%" y1="0%" x2="100%"
                            y2="0%">
                            <stop offset="0%" stop-color="#cd1b27" />
                            <stop offset="18%" stop-color="#e93546" />
                            <stop offset="35%" stop-color="#f34759" />
                            <stop offset="55%" stop-color="#f04254" />
                            <stop offset="78%" stop-color="#e52f40" />
                            <stop offset="100%" stop-color="#cf1d29" />
                        </linearGradient>
                        <!-- Gradasi Isi Merah di Bawah Pita (Menyatu Mulus dengan Mesh Body di Bawahnya) -->
                        <linearGradient id="nilaiUnderCurveFill" x1="0%" y1="0%" x2="100%"
                            y2="0%">
                            <stop offset="0%" stop-color="#b81a23" />
                            <stop offset="28%" stop-color="#d41923" />
                            <stop offset="65%" stop-color="#9e1b20" />
                            <stop offset="100%" stop-color="#94191e" />
                        </linearGradient>
                        <!-- Shadow Halus di Bawah Pita -->
                        <filter id="ribbonDropShadow" x="-5%" y="-10%" width="110%" height="130%">
                            <feDropShadow dx="0" dy="6" stdDeviation="6" flood-color="#5e080c"
                                flood-opacity="0.35" />
                        </filter>
                    </defs>

                    <!-- Isi Merah di Bawah Kurva (Area di Atas Kurva Dibiarkan 100% Transparan) -->
                    <path d="M0,155 C190,39 420,27 700,122 C980,217 1260,205 1440,129 L1440,220 L0,220 Z"
                        fill="url(#nilaiUnderCurveFill)"></path>

                    <!-- Pita Gelombang S-Curve Ketebalan Presisi -->
                    <path
                        d="M0,148 C190,32 420,20 700,115 C980,210 1260,198 1440,122 L1440,164 C1260,240 980,252 700,157 C420,62 190,74 0,190 Z"
                        fill="url(#nilaiRibbonGrad)" filter="url(#ribbonDropShadow)"></path>
                </svg>
            </div>

            <!-- Pure CSS + JS Silky Mesh Gradient Background (Dimulai Tepat di Bawah Kurva Tanpa Menutupi Area Atas) -->
            <div class="absolute inset-x-0 bottom-0 top-[95px] sm:top-[127px] md:top-[159px] lg:top-[175px] pointer-events-none select-none overflow-hidden"
                style="background-color: #961b1e;">
                <!-- Base Multi-Stop Linear & Radial Mesh CSS -->
                <div class="absolute inset-0"
                    style="background:
                        radial-gradient(ellipse 65% 48% at 28% 8%, rgba(220, 24, 34, 0.92) 0%, rgba(190, 22, 30, 0.45) 52%, transparent 80%),
                        radial-gradient(ellipse 55% 45% at 76% 68%, rgba(212, 25, 34, 0.78) 0%, rgba(175, 24, 30, 0.35) 55%, transparent 82%),
                        radial-gradient(ellipse 60% 50% at 38% 58%, rgba(132, 20, 24, 0.95) 0%, transparent 70%),
                        radial-gradient(ellipse 50% 40% at 88% 22%, rgba(136, 21, 25, 0.88) 0%, transparent 75%),
                        linear-gradient(165deg, #b51b23 0%, #981b1f 42%, #8e181c 72%, #9e1b20 100%);">
                </div>

                <!-- Interactive / Ambient Mesh Glow Blobs (Dikontrol Halus via JS) -->
                <div id="nilaiMeshGlowLeft"
                    class="absolute -top-16 left-[8%] w-[55%] h-[60%] rounded-full pointer-events-none transition-transform duration-700 ease-out"
                    style="background: radial-gradient(circle, rgba(230, 25, 36, 0.55) 0%, rgba(200, 20, 30, 0.2) 50%, transparent 75%); filter: blur(48px);">
                </div>
                <div id="nilaiMeshGlowRight"
                    class="absolute bottom-[5%] right-[10%] w-[50%] h-[50%] rounded-full pointer-events-none transition-transform duration-700 ease-out"
                    style="background: radial-gradient(circle, rgba(218, 26, 36, 0.5) 0%, rgba(178, 22, 29, 0.18) 55%, transparent 75%); filter: blur(52px);">
                </div>
            </div>

            <!-- Ornamen Daun Teh & Botol Sosro di Sisi Kiri Atas, Kiri Bawah & Kanan Bawah Latar Merah (Persis Mockup) -->
            <img src="{{ asset('assets/images/sosro-ornament.png') }}" alt=""
                class="absolute -left-6 sm:-left-8 top-28 sm:top-36 w-44 sm:w-56 md:w-64 object-contain pointer-events-none select-none opacity-35 transform -rotate-6 z-10">
            <img src="{{ asset('assets/images/sosro-ornament.png') }}" alt=""
                class="absolute -left-8 sm:-left-10 bottom-6 sm:bottom-10 w-44 sm:w-56 md:w-64 object-contain pointer-events-none select-none opacity-30 transform rotate-12 z-10">
            <img src="{{ asset('assets/images/sosro-ornament.png') }}" alt=""
                class="absolute -right-8 sm:-right-10 bottom-6 sm:bottom-10 w-44 sm:w-56 md:w-64 object-contain pointer-events-none select-none opacity-30 transform -scale-x-100 -rotate-12 z-10">

            <div class="relative z-10 max-w-7xl mx-auto px-6">
                <!-- Section Title: NILAI PERUSAHAAN (Ukuran Tetap Sesuai Instruksi) -->
                <div class="text-center mb-16 sm:mb-20">
                    <h2
                        class="font-display-title text-2xl sm:text-3xl md:text-4xl lg:text-[2.6rem] text-white font-bold uppercase tracking-wider drop-shadow-sm">
                        Nilai Perusahaan
                    </h2>
                </div>

                <!-- 4 Kartu Statis (Skala Tipografi & Ikon Mengikuti Standar Keterbacaan IMK / HCI) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-14 sm:gap-10 lg:gap-7 items-stretch pt-8">
                    <!-- Kartu 1: NIAT BAIK HASIL BAIK -->
                    <div
                        class="relative bg-white rounded-[30px] px-6 pt-16 pb-8 drop-shadow-[0_12px_18px_rgba(75,5,8,0.38)] flex flex-col items-center text-center min-h-[340px] transition-transform duration-300 hover:-translate-y-1.5">
                        <!-- Kubah Bulat Menyatu di Puncak Kartu (Khusus Logo Bulat Niat Baik) -->
                        <div
                            class="absolute -top-13 left-1/2 -translate-x-1/2 w-28 h-28 rounded-full bg-white p-1.5 flex items-center justify-center">
                            <img src="{{ asset('assets/images/nilai-niat-baik.png') }}" alt="Niat Baik Hasil Baik"
                                class="w-full h-full object-contain">
                        </div>
                        <h3 style="font-weight: 800;"
                            class="font-display-title text-2xl sm:text-[1.6rem] font-extrabold text-[#9e1b24] leading-[1.15] mt-2 mb-6 uppercase tracking-tight">
                            NIAT BAIK<br>HASIL BAIK
                        </h3>
                        <p class="text-[#9e1b24] text-sm sm:text-[15px] leading-relaxed font-medium mt-auto">
                            Menjunjung ketulusan niat dan integritas moral dalam setiap keputusan bisnis dan interaksi
                            profesional
                        </p>
                    </div>

                    <!-- Kartu 2: ACCOUNTABLE CARE CREDIBLE -->
                    <div
                        class="relative bg-white rounded-[30px] px-6 pt-14 pb-8 drop-shadow-[0_12px_18px_rgba(75,5,8,0.38)] flex flex-col items-center text-center min-h-[340px] transition-transform duration-300 hover:-translate-y-1.5">
                        <!-- Tab Lebar Melengkung Menyatu di Puncak Kartu (Sesuai Figma) -->
                        <div
                            class="absolute -top-8 left-1/2 -translate-x-1/2 w-44 sm:w-48 h-16 rounded-t-[28px] bg-white px-4 pt-3 pb-1 flex items-center justify-center">
                            <img src="{{ asset('assets/images/nilai-acc.png') }}" alt="Accountable Care Credible"
                                class="w-full h-full object-contain">
                        </div>
                        <h3 style="font-weight: 800;"
                            class="font-display-title text-[#9e1b24] uppercase tracking-tight flex flex-col items-center mt-1 mb-6">
                            <span class="text-base sm:text-[17px] font-extrabold leading-tight">ACCOUNTABLE</span>
                            <span class="text-4xl sm:text-[2.65rem] font-extrabold leading-[0.95] my-1">CARE</span>
                            <span class="text-base sm:text-[17px] font-extrabold leading-tight">CREDIBLE</span>
                        </h3>
                        <p class="text-[#9e1b24] text-sm sm:text-[15px] leading-relaxed font-medium mt-auto">
                            Kepedulian terhadap mutu produk, akuntabilitas tugas, serta kredibilitas tinggi di mata
                            konsumen.
                        </p>
                    </div>

                    <!-- Kartu 3: TEKAD RENCANA ULAT JELI IMAN -->
                    <div
                        class="relative bg-white rounded-[30px] px-6 pt-14 pb-8 drop-shadow-[0_12px_18px_rgba(75,5,8,0.38)] flex flex-col items-center text-center min-h-[340px] transition-transform duration-300 hover:-translate-y-1.5">
                        <!-- Tab Lebar Melengkung Menyatu di Puncak Kartu (Sesuai Figma) -->
                        <div
                            class="absolute -top-8 left-1/2 -translate-x-1/2 w-44 sm:w-48 h-16 rounded-t-[28px] bg-white px-4 pt-3 pb-1 flex items-center justify-center">
                            <img src="{{ asset('assets/images/nilai-teruji.png') }}" alt="Tekad Rencana Ulat Jeli Iman"
                                class="w-full h-full object-contain">
                        </div>
                        <h3 style="font-weight: 800;"
                            class="font-display-title text-lg sm:text-[1.3rem] font-extrabold text-[#9e1b24] leading-[1.15] mt-1 mb-5 uppercase tracking-tight">
                            TEKAD<br>RENCANA<br>ULAT JELI<br>IMAN
                        </h3>
                        <p class="text-[#9e1b24] text-sm sm:text-[15px] leading-relaxed font-medium mt-auto">
                            Kesiapan menghadapi tantangan industri lewat perencanaan matang, kejelian, dan standar
                            keselamatan ketat
                        </p>
                    </div>

                    <!-- Kartu 4: HUMBLE HUMILITY HUMANITY -->
                    <div
                        class="relative bg-white rounded-[30px] px-6 pt-14 pb-8 drop-shadow-[0_12px_18px_rgba(75,5,8,0.38)] flex flex-col items-center text-center min-h-[340px] transition-transform duration-300 hover:-translate-y-1.5">
                        <!-- Tab Lebar Melengkung Menyatu di Puncak Kartu (Sesuai Figma) -->
                        <div
                            class="absolute -top-8 left-1/2 -translate-x-1/2 w-44 sm:w-48 h-16 rounded-t-[28px] bg-white px-3.5 pt-2.5 pb-1 flex items-center justify-center">
                            <img src="{{ asset('assets/images/nilai-3h.png') }}" alt="Humble Humility Humanity"
                                class="w-full h-full object-contain">
                        </div>
                        <h3 style="font-weight: 800;"
                            class="font-display-title text-xl sm:text-[1.45rem] font-extrabold text-[#9e1b24] leading-[1.15] mt-1 mb-6 uppercase tracking-tight">
                            HUMBLE<br>HUMILITY<br>HUMANITY
                        </h3>
                        <p class="text-[#9e1b24] text-sm sm:text-[15px] leading-relaxed font-medium mt-auto">
                            Menjunjung ketulusan niat dan integritas moral dalam setiap keputusan bisnis dan interaksi
                            profesional
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION BARU: INFINITE LOOPING SLIDER PRODUK (Bergerak Non-Stop & Bisa Digeser Manual) -->
    <section id="produk"
        class="relative w-full bg-white py-8 sm:py-10 md:py-12 overflow-hidden border-b border-slate-100 select-none">
        <!-- Fade Mask Halus di Tepi Kiri & Kanan -->
        <div
            class="pointer-events-none absolute inset-y-0 left-0 z-10 w-12 sm:w-24 bg-gradient-to-r from-white to-transparent">
        </div>
        <div
            class="pointer-events-none absolute inset-y-0 right-0 z-10 w-12 sm:w-24 bg-gradient-to-l from-white to-transparent">
        </div>

        <!-- Draggable + Auto-Looping Viewport -->
        <div id="productMarqueeViewport" class="w-full overflow-hidden cursor-grab active:cursor-grabbing touch-pan-y">
            <!-- Infinite Looping Track (2 Set Identik Agar Looping & Geser Manual 100% Mulus Tanpa Putus) -->
            <div id="productMarqueeTrack" class="flex w-max items-center will-change-transform">
                @for ($loopSet = 0; $loopSet < 2; $loopSet++)
                    <div class="flex items-center gap-10 sm:gap-14 md:gap-16 pr-10 sm:pr-14 md:pr-16 shrink-0"
                        @if ($loopSet === 1) aria-hidden="true" @endif>
                        <!-- 1. Teh Cap Poci -->
                        <div
                            class="flex items-center justify-center h-20 sm:h-24 md:h-28 w-auto shrink-0 transition-transform duration-300 hover:scale-110">
                            <img src="{{ asset('assets/images/produk-teh-poci.png') }}" alt="Teh Cap Poci"
                                draggable="false"
                                class="h-full w-auto max-w-[170px] sm:max-w-[200px] md:max-w-[220px] object-contain pointer-events-none select-none">
                        </div>

                        <!-- 2. Kanchā -->
                        <div
                            class="flex items-center justify-center h-14 sm:h-16 md:h-20 w-auto shrink-0 transition-transform duration-300 hover:scale-110">
                            <img src="{{ asset('assets/images/produk-kancha.png') }}" alt="Kancha" draggable="false"
                                class="h-full w-auto max-w-[180px] sm:max-w-[210px] md:max-w-[240px] object-contain pointer-events-none select-none">
                        </div>

                        <!-- 3. Teh Cap Botol -->
                        <div
                            class="flex items-center justify-center h-24 sm:h-28 md:h-32 w-auto shrink-0 transition-transform duration-300 hover:scale-110">
                            <img src="{{ asset('assets/images/produk-teh-cap-botol.png') }}" alt="Teh Cap Botol"
                                draggable="false"
                                class="h-full w-auto max-w-[150px] sm:max-w-[180px] md:max-w-[200px] object-contain pointer-events-none select-none">
                        </div>

                        <!-- 4. Prim-A -->
                        <div
                            class="flex items-center justify-center h-20 sm:h-24 md:h-28 w-auto shrink-0 transition-transform duration-300 hover:scale-110">
                            <img src="{{ asset('assets/images/produk-prima.png') }}" alt="Prim-A" draggable="false"
                                class="h-full w-auto max-w-[180px] sm:max-w-[210px] md:max-w-[240px] object-contain pointer-events-none select-none">
                        </div>

                        <!-- 5. Country Choice -->
                        <div
                            class="flex items-center justify-center h-20 sm:h-24 md:h-28 w-auto shrink-0 transition-transform duration-300 hover:scale-110">
                            <img src="{{ asset('assets/images/produk-country-choice.png') }}" alt="Country Choice"
                                draggable="false"
                                class="h-full w-auto max-w-[190px] sm:max-w-[220px] md:max-w-[250px] object-contain pointer-events-none select-none">
                        </div>

                        <!-- 6. Fruit Tea Sosro -->
                        <div
                            class="flex items-center justify-center h-22 sm:h-26 md:h-30 w-auto shrink-0 transition-transform duration-300 hover:scale-110">
                            <img src="{{ asset('assets/images/produk-fruit-tea.png') }}" alt="Fruit Tea Sosro"
                                draggable="false"
                                class="h-full w-auto max-w-[160px] sm:max-w-[190px] md:max-w-[210px] object-contain pointer-events-none select-none">
                        </div>

                        <!-- 7. S-Tee -->
                        <div
                            class="flex items-center justify-center h-20 sm:h-24 md:h-28 w-auto shrink-0 transition-transform duration-300 hover:scale-110">
                            <img src="{{ asset('assets/images/produk-s-tee.png') }}" alt="S-Tee" draggable="false"
                                class="h-full w-auto max-w-[180px] sm:max-w-[210px] md:max-w-[240px] object-contain pointer-events-none select-none">
                        </div>

                        <!-- 8. Tehbotol Sosro -->
                        <div
                            class="flex items-center justify-center h-20 sm:h-24 md:h-28 w-auto shrink-0 transition-transform duration-300 hover:scale-110">
                            <img src="{{ asset('assets/images/produk-tehbotol-sosro.jpg') }}" alt="Tehbotol Sosro"
                                draggable="false"
                                class="h-full w-auto max-w-[190px] sm:max-w-[220px] md:max-w-[250px] object-contain rounded-lg pointer-events-none select-none">
                        </div>

                        <!-- 9. Tebs -->
                        <div
                            class="flex items-center justify-center h-16 sm:h-20 md:h-24 w-auto shrink-0 transition-transform duration-300 hover:scale-110">
                            <img src="{{ asset('assets/images/produk-tebs.png') }}" alt="Tebs" draggable="false"
                                class="h-full w-auto max-w-[180px] sm:max-w-[210px] md:max-w-[240px] object-contain pointer-events-none select-none">
                        </div>

                        <!-- 10. Tasseo -->
                        <div
                            class="flex items-center justify-center h-16 sm:h-20 md:h-24 w-auto shrink-0 transition-transform duration-300 hover:scale-110">
                            <img src="{{ asset('assets/images/produk-tasseo.png') }}" alt="Tasseo" draggable="false"
                                class="h-full w-auto max-w-[190px] sm:max-w-[220px] md:max-w-[250px] object-contain pointer-events-none select-none">
                        </div>

                        <!-- 11. Sosro Heritage -->
                        <div
                            class="flex items-center justify-center h-20 sm:h-24 md:h-28 w-auto shrink-0 transition-transform duration-300 hover:scale-110">
                            <img src="{{ asset('assets/images/produk-heritage.png') }}" alt="Sosro Heritage"
                                draggable="false"
                                class="h-full w-auto max-w-[190px] sm:max-w-[220px] md:max-w-[250px] object-contain pointer-events-none select-none">
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </section>

    <!-- SECTION BARU: IKUTI PERJALANAN KARIER KAMI & PROGRAM KAMI (Sesuai Mockup + Improved Visual Background) -->
    <section id="perjalanan-karier" class="relative w-full overflow-hidden select-none">
        <!-- 1. BAGIAN ATAS: IKUTI PERJALANAN KARIER KAMI (Gradasi Merah ke Pink-Putih Halus di Bawah) -->
        <div class="relative w-full pt-14 sm:pt-18 md:pt-22 pb-24 sm:pb-28 md:pb-36 overflow-hidden"
            style="background: linear-gradient(180deg, #9e1820 0%, #b81d26 32%, #d4424b 64%, #f4b5b9 86%, #fff5f6 100%);">

            <!-- Subtle Dot Matrix & Radial Highlight di Area Atas -->
            <div class="absolute inset-0 pointer-events-none opacity-25"
                style="background-image: radial-gradient(rgba(255, 255, 255, 0.5) 1.25px, transparent 1.25px); background-size: 24px 24px; mask-image: linear-gradient(to bottom, rgba(0,0,0,0.8) 0%, transparent 80%); -webkit-mask-image: linear-gradient(to bottom, rgba(0,0,0,0.8) 0%, transparent 80%);">
            </div>
            <div class="absolute -top-24 right-1/4 w-[520px] h-[520px] rounded-full pointer-events-none blur-3xl opacity-35"
                style="background: radial-gradient(circle, #ff6b72 0%, transparent 70%);">
            </div>

            <!-- Ornamen Daun Teh & Botol Sosro Samar di Kanan Bawah (Sesuai Mockup Figma) -->
            <img src="{{ asset('assets/images/sosro-ornament.png') }}" alt=""
                class="absolute right-12 sm:right-24 bottom-6 sm:bottom-10 w-44 sm:w-56 md:w-64 object-contain pointer-events-none select-none opacity-25 transform -rotate-12">
            <img src="{{ asset('assets/images/sosro-ornament.png') }}" alt=""
                class="absolute -right-8 sm:-right-6 bottom-12 sm:bottom-16 w-36 sm:w-48 md:w-56 object-contain pointer-events-none select-none opacity-20 transform rotate-12">

            <!-- Konten Utama 2 Kolom: Kiri (Group 418.png) & Kanan (Teks + Ikon Sosmed) -->
            <div class="relative z-20 max-w-6xl mx-auto px-6">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-8 items-center">
                    <!-- Kolom Kiri: Collage Sosial Media Group 418.png -->
                    <div
                        class="lg:col-span-6 flex justify-center lg:justify-start relative z-30 -mb-14 sm:-mb-20 md:-mb-28">
                        <div
                            class="relative w-full max-w-[380px] sm:max-w-[440px] md:max-w-[490px] transition-transform duration-500 hover:scale-[1.015]">
                            <!-- Ambient Soft Glow di Belakang Mockup Sosmed -->
                            <div class="absolute inset-6 rounded-3xl bg-red-950/25 blur-2xl -z-10"></div>
                            <img src="{{ asset('assets/images/Group 418.png') }}"
                                alt="Official Social Media Sosro Career - Instagram & LinkedIn"
                                class="w-full h-auto object-contain drop-shadow-[0_20px_35px_rgba(80,10,14,0.28)]">
                        </div>
                    </div>

                    <!-- Kolom Kanan: Heading & Tombol Instagram / LinkedIn -->
                    <div
                        class="lg:col-span-6 flex flex-col items-center lg:items-start text-center lg:text-left lg:pl-8 pt-6 lg:pt-0">
                        <h2 style="font-weight: 800;"
                            class="font-display-title text-3xl sm:text-4xl md:text-5xl lg:text-[3.35rem] font-extrabold text-white uppercase leading-[1.12] tracking-wide drop-shadow-[0_4px_14px_rgba(120,10,16,0.35)]">
                            IKUTI<br>
                            PERJALANAN<br>
                            KARIER KAMI
                        </h2>

                        <!-- Ikon Sosial Media (Instagram & LinkedIn) Sesuai Mockup -->
                        <div class="mt-6 sm:mt-7 flex items-center gap-4 sm:gap-5">
                            <!-- Instagram @sosrocareer -->
                            <a href="https://www.instagram.com/sosrocareer/" target="_blank" rel="noopener noreferrer"
                                aria-label="Instagram Sosro Career (@sosrocareer)" title="Ikuti Instagram @sosrocareer"
                                class="group relative inline-flex items-center justify-center w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-white/85 hover:bg-white text-[#b81d26] shadow-lg shadow-red-950/15 backdrop-blur-md transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                                <svg class="w-8 h-8 sm:w-9 sm:h-9 transition-transform duration-300 group-hover:scale-110"
                                    viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                                </svg>
                            </a>

                            <!-- LinkedIn PT Sinar Sosro Gunung Slamat -->
                            <a href="https://www.linkedin.com/company/pt-sinar-sosro-gunung-slamat/" target="_blank"
                                rel="noopener noreferrer" aria-label="LinkedIn PT Sinar Sosro Gunung Slamat"
                                title="Ikuti LinkedIn PT Sinar Sosro Gunung Slamat"
                                class="group relative inline-flex items-center justify-center w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-white/85 hover:bg-white text-[#b81d26] shadow-lg shadow-red-950/15 backdrop-blur-md transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                                <svg class="w-8 h-8 sm:w-9 sm:h-9 transition-transform duration-300 group-hover:scale-110"
                                    viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.28 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 0 1 1.4 1.4v4.93h2.75M6.88 8.56a1.68 1.68 0 0 0 1.68-1.68c0-.93-.75-1.69-1.68-1.69a1.69 1.69 0 0 0-1.69 1.69c0 .93.76 1.68 1.69 1.68m1.39 9.94v-8.37H5.5v8.37h2.77z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. BAGIAN BAWAH: PROGRAM KAMI -->
        <div id="program-kami"
            class="relative z-10 w-full -mt-20 sm:-mt-24 md:-mt-32 pt-28 sm:pt-36 md:pt-44 pb-20 sm:pb-24 md:pb-28 overflow-hidden">

            <!-- Transisi Gelombang S-Curve Mulus (Tanpa Warna Merah Gelap di Kanan Atas yang Memotong Pattern) -->
            <div
                class="absolute top-0 inset-x-0 w-full h-24 sm:h-32 md:h-40 overflow-hidden leading-none pointer-events-none select-none z-10">
                <svg class="relative block w-full h-full" viewBox="0 0 1440 220" preserveAspectRatio="none">
                    <defs>
                        <!-- Layer Pita Utama (Vibrant Crimson-Coral Merata) -->
                        <linearGradient id="programWaveRibbonGrad" x1="0%" y1="0%" x2="100%"
                            y2="0%">
                            <stop offset="0%" stop-color="#d9202c" />
                            <stop offset="30%" stop-color="#f23847" />
                            <stop offset="70%" stop-color="#ff4757" />
                            <stop offset="100%" stop-color="#e02430" />
                        </linearGradient>
                        <filter id="programWaveShadow" x="-5%" y="-15%" width="110%" height="140%">
                            <feDropShadow dx="0" dy="4" stdDeviation="5" flood-color="#7a0c12"
                                flood-opacity="0.25" />
                        </filter>
                    </defs>

                    <!-- Isi di Bawah Kurva (Warna #b81b24 Sama Persis dengan Latar Utama Agar Tanpa Garis Potong) -->
                    <path d="M0,158 C260,78 540,86 820,146 C1080,202 1290,178 1440,128 L1440,220 L0,220 Z" fill="#b81b24">
                    </path>

                    <!-- Pita Utama S-Curve -->
                    <path
                        d="M0,148 C260,66 540,74 820,134 C1080,190 1290,166 1440,116 L1440,156 C1290,206 1080,230 820,174 C540,114 260,106 0,188 Z"
                        fill="url(#programWaveRibbonGrad)" filter="url(#programWaveShadow)"></path>
                </svg>
            </div>

            <!-- Latar Belakang Utama Program Kami: Menyatu Mulus dengan Fill Gelombang (#b81b24) Tanpa Warna Merah Gelap di Kanan Atas -->
            <div class="absolute inset-x-0 bottom-0 top-[95px] sm:top-[127px] md:top-[159px] pointer-events-none select-none overflow-hidden"
                style="background: linear-gradient(180deg, #b81b24 0%, #bd1d26 55%, #a6171f 100%);">
                <!-- Ambient Spotlight Halus di Tengah -->
                <div class="absolute top-1/3 left-1/2 -translate-x-1/2 w-[80%] h-[65%] rounded-full blur-3xl opacity-45"
                    style="background: radial-gradient(ellipse, rgba(242, 56, 71, 0.6) 0%, rgba(196, 30, 40, 0.2) 55%, transparent 75%);">
                </div>

                <!-- Pattern Bintik-Bintik Gradasi Halus (Fade Mulus di Atas Agar Tidak Terpotong Gelombang) -->
                <div class="absolute inset-0 opacity-22"
                    style="background-image: radial-gradient(rgba(255, 255, 255, 0.75) 1.5px, transparent 1.5px); background-size: 26px 26px; mask-image: linear-gradient(to bottom, transparent 0%, black 18%, black 85%, transparent 100%); -webkit-mask-image: linear-gradient(to bottom, transparent 0%, black 18%, black 85%, transparent 100%);">
                </div>

                <!-- Dekorasi Garis Lengkung Geometris di Latar Merah (Ditempatkan Agar Tidak Terpotong di Atas) -->
                <svg class="absolute inset-0 w-full h-full opacity-18" viewBox="0 0 1440 600" fill="none"
                    preserveAspectRatio="none">
                    <circle cx="140" cy="490" r="220" stroke="white" stroke-width="1.5"
                        stroke-dasharray="8 8" />
                    <circle cx="140" cy="490" r="300" stroke="white" stroke-width="1" opacity="0.6" />
                    <circle cx="1310" cy="360" r="190" stroke="white" stroke-width="1.5"
                        stroke-dasharray="8 8" />
                    <circle cx="1310" cy="360" r="260" stroke="white" stroke-width="1" opacity="0.6" />
                    <!-- Gelombang Ribbon Tipis Melintang di Belakang Kartu -->
                    <path d="M-60,380 C320,240 680,470 1060,320 C1260,240 1390,290 1500,260" stroke="white"
                        stroke-width="2" stroke-dasharray="6 10" opacity="0.35" />
                </svg>

                <!-- Ornamen Daun Teh & Botol Sosro -->
                <img src="{{ asset('assets/images/sosro-ornament.png') }}" alt=""
                    class="absolute -left-10 bottom-4 w-48 sm:w-60 md:w-68 object-contain opacity-25 transform rotate-12">
                <img src="{{ asset('assets/images/sosro-ornament.png') }}" alt=""
                    class="absolute -right-8 bottom-6 w-48 sm:w-60 md:w-64 object-contain opacity-25 transform -scale-x-100 -rotate-12">

                <!-- Pernak-Pernik Floating Sparkles & Bintang 4 Sudut -->
                <svg class="absolute top-16 left-[12%] w-6 h-6 text-rose-200/60 animate-pulse" viewBox="0 0 24 24"
                    fill="currentColor">
                    <path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z" />
                </svg>
                <svg class="absolute top-24 right-[15%] w-5 h-5 text-red-200/65 animate-pulse"
                    style="animation-delay: 1s;" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z" />
                </svg>
                <svg class="absolute bottom-12 left-[48%] w-4 h-4 text-white/45 animate-pulse"
                    style="animation-delay: 0.5s;" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z" />
                </svg>
                <span class="absolute top-28 left-[28%] w-3 h-3 rounded-full border-2 border-white/35"></span>
                <span class="absolute bottom-20 right-[25%] w-3.5 h-3.5 rounded-full bg-white/20"></span>
            </div>

            <!-- Konten PROGRAM KAMI -->
            <div class="relative z-20 max-w-6xl mx-auto px-6 pt-4 sm:pt-6">
                <!-- Judul Section + Aksen Garis Dekoratif (Tanpa Tooltip & Tanpa Warna Kuning) -->
                <div class="text-center mb-12 sm:mb-14">
                    <h2 style="font-weight: 800;"
                        class="font-display-title text-2xl sm:text-3xl md:text-4xl lg:text-[2.6rem] text-white font-extrabold uppercase tracking-wider drop-shadow-sm">
                        PROGRAM KAMI
                    </h2>
                    <!-- Aksen Garis Ornamen di Bawah Judul (Warna Merah Utama & Putih) -->
                    <div class="mt-3 flex items-center justify-center gap-2">
                        <span class="w-3 h-1.5 rounded-full bg-red-300/75"></span>
                        <span
                            class="w-14 h-1.5 rounded-full bg-gradient-to-r from-[#ff4757] via-white to-[#ff4757]"></span>
                        <span class="w-3 h-1.5 rounded-full bg-red-300/75"></span>
                    </div>
                </div>

                <!-- 3 Kartu Program (MANAGEMENT TRAINEE, MAGANG, PROFESSIONAL) -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-7 lg:gap-9 items-stretch">
                    <!-- Kartu 1: MANAGEMENT TRAINEE -->
                    <div
                        class="group relative bg-white rounded-[30px] p-7 sm:p-8 lg:p-9 shadow-[0_18px_38px_rgba(70,6,10,0.32)] flex flex-col justify-between transition-all duration-300 hover:-translate-y-2 hover:shadow-[0_24px_45px_rgba(70,6,10,0.45)] overflow-hidden border border-red-100/80">
                        <!-- Aksen Top Bar Warna Utama Merah Sosro -->
                        <div
                            class="absolute top-0 inset-x-0 h-2 bg-gradient-to-r from-[#B11116] via-[#e62e3a] to-[#B11116]">
                        </div>

                        <!-- Pernak-Pernik Sudut Bawah Kartu: Glow Merah Muda & Siluet Daun/Botol -->
                        <div
                            class="absolute -bottom-10 -right-10 w-36 h-36 rounded-full bg-gradient-to-tl from-red-100/70 via-rose-50/40 to-transparent pointer-events-none">
                        </div>
                        <img src="{{ asset('assets/images/sosro-ornament.png') }}" alt=""
                            class="absolute -bottom-4 -right-4 w-28 object-contain opacity-[0.08] pointer-events-none select-none transform -rotate-12 group-hover:opacity-[0.14] transition-opacity">

                        <div class="relative z-10">
                            <h3 style="font-weight: 800;"
                                class="font-display-title text-lg sm:text-xl lg:text-[1.35rem] font-extrabold text-[#b81d26] uppercase tracking-tight mb-4">
                                MANAGEMENT TRAINEE
                            </h3>

                            <!-- Garis Pembatas Aksen Merah -->
                            <div
                                class="w-12 h-1 rounded-full bg-[#B11116]/25 mb-6 group-hover:w-20 group-hover:bg-[#B11116] transition-all duration-300">
                            </div>

                            <ul
                                class="space-y-4 sm:space-y-5 text-[#9e1b24] text-sm sm:text-[15px] lg:text-base font-medium leading-snug">
                                <li class="flex items-start gap-3">
                                    <span
                                        class="mt-0.5 w-5 h-5 rounded-full bg-red-50 border border-red-200 flex items-center justify-center text-[#B11116] shrink-0 group-hover:bg-[#B11116] group-hover:text-white transition-colors">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </span>
                                    <span>Mentoring langsung dari Direksi Rekso</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <span
                                        class="mt-0.5 w-5 h-5 rounded-full bg-red-50 border border-red-200 flex items-center justify-center text-[#B11116] shrink-0 group-hover:bg-[#B11116] group-hover:text-white transition-colors">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </span>
                                    <span>Rotasi lintas fungsional pabrik &amp; cabang</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <span
                                        class="mt-0.5 w-5 h-5 rounded-full bg-red-50 border border-red-200 flex items-center justify-center text-[#B11116] shrink-0 group-hover:bg-[#B11116] group-hover:text-white transition-colors">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </span>
                                    <span>Jalur promosi kepemimpinan dipercepat</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Kartu 2: MAGANG -->
                    <div
                        class="group relative bg-white rounded-[30px] p-7 sm:p-8 lg:p-9 shadow-[0_18px_38px_rgba(70,6,10,0.32)] flex flex-col justify-between transition-all duration-300 hover:-translate-y-2 hover:shadow-[0_24px_45px_rgba(70,6,10,0.45)] overflow-hidden border border-red-100/80">
                        <!-- Aksen Top Bar Warna Utama Merah Sosro -->
                        <div
                            class="absolute top-0 inset-x-0 h-2 bg-gradient-to-r from-[#B11116] via-[#e62e3a] to-[#B11116]">
                        </div>

                        <!-- Pernak-Pernik Sudut Bawah Kartu: Glow Merah Muda & Siluet Daun/Botol -->
                        <div
                            class="absolute -bottom-10 -right-10 w-36 h-36 rounded-full bg-gradient-to-tl from-red-100/70 via-rose-50/40 to-transparent pointer-events-none">
                        </div>
                        <img src="{{ asset('assets/images/sosro-ornament.png') }}" alt=""
                            class="absolute -bottom-4 -right-4 w-28 object-contain opacity-[0.08] pointer-events-none select-none transform -rotate-12 group-hover:opacity-[0.14] transition-opacity">

                        <div class="relative z-10">
                            <h3 style="font-weight: 800;"
                                class="font-display-title text-lg sm:text-xl lg:text-[1.35rem] font-extrabold text-[#b81d26] uppercase tracking-tight mb-4">
                                MAGANG
                            </h3>

                            <!-- Garis Pembatas Aksen Merah -->
                            <div
                                class="w-12 h-1 rounded-full bg-[#B11116]/25 mb-6 group-hover:w-20 group-hover:bg-[#B11116] transition-all duration-300">
                            </div>

                            <ul
                                class="space-y-4 sm:space-y-5 text-[#9e1b24] text-sm sm:text-[15px] lg:text-base font-medium leading-snug">
                                <li class="flex items-start gap-3">
                                    <span
                                        class="mt-0.5 w-5 h-5 rounded-full bg-red-50 border border-red-200 flex items-center justify-center text-[#B11116] shrink-0 group-hover:bg-[#B11116] group-hover:text-white transition-colors">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </span>
                                    <span>Mentoring langsung dari Direksi Rekso</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <span
                                        class="mt-0.5 w-5 h-5 rounded-full bg-red-50 border border-red-200 flex items-center justify-center text-[#B11116] shrink-0 group-hover:bg-[#B11116] group-hover:text-white transition-colors">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </span>
                                    <span>Rotasi lintas fungsional pabrik &amp; cabang</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <span
                                        class="mt-0.5 w-5 h-5 rounded-full bg-red-50 border border-red-200 flex items-center justify-center text-[#B11116] shrink-0 group-hover:bg-[#B11116] group-hover:text-white transition-colors">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </span>
                                    <span>Jalur promosi kepemimpinan dipercepat</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Kartu 3: PROFESSIONAL -->
                    <div
                        class="group relative bg-white rounded-[30px] p-7 sm:p-8 lg:p-9 shadow-[0_18px_38px_rgba(70,6,10,0.32)] flex flex-col justify-between transition-all duration-300 hover:-translate-y-2 hover:shadow-[0_24px_45px_rgba(70,6,10,0.45)] overflow-hidden border border-red-100/80">
                        <!-- Aksen Top Bar Warna Utama Merah Sosro -->
                        <div
                            class="absolute top-0 inset-x-0 h-2 bg-gradient-to-r from-[#B11116] via-[#e62e3a] to-[#B11116]">
                        </div>

                        <!-- Pernak-Pernik Sudut Bawah Kartu: Glow Merah Muda & Siluet Daun/Botol -->
                        <div
                            class="absolute -bottom-10 -right-10 w-36 h-36 rounded-full bg-gradient-to-tl from-red-100/70 via-rose-50/40 to-transparent pointer-events-none">
                        </div>
                        <img src="{{ asset('assets/images/sosro-ornament.png') }}" alt=""
                            class="absolute -bottom-4 -right-4 w-28 object-contain opacity-[0.08] pointer-events-none select-none transform -rotate-12 group-hover:opacity-[0.14] transition-opacity">

                        <div class="relative z-10">
                            <h3 style="font-weight: 800;"
                                class="font-display-title text-lg sm:text-xl lg:text-[1.35rem] font-extrabold text-[#b81d26] uppercase tracking-tight mb-4">
                                PROFESSIONAL
                            </h3>

                            <!-- Garis Pembatas Aksen Merah -->
                            <div
                                class="w-12 h-1 rounded-full bg-[#B11116]/25 mb-6 group-hover:w-20 group-hover:bg-[#B11116] transition-all duration-300">
                            </div>

                            <ul
                                class="space-y-4 sm:space-y-5 text-[#9e1b24] text-sm sm:text-[15px] lg:text-base font-medium leading-snug">
                                <li class="flex items-start gap-3">
                                    <span
                                        class="mt-0.5 w-5 h-5 rounded-full bg-red-50 border border-red-200 flex items-center justify-center text-[#B11116] shrink-0 group-hover:bg-[#B11116] group-hover:text-white transition-colors">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </span>
                                    <span>Mentoring langsung dari Direksi Rekso</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <span
                                        class="mt-0.5 w-5 h-5 rounded-full bg-red-50 border border-red-200 flex items-center justify-center text-[#B11116] shrink-0 group-hover:bg-[#B11116] group-hover:text-white transition-colors">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </span>
                                    <span>Rotasi lintas fungsional pabrik &amp; cabang</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <span
                                        class="mt-0.5 w-5 h-5 rounded-full bg-red-50 border border-red-200 flex items-center justify-center text-[#B11116] shrink-0 group-hover:bg-[#B11116] group-hover:text-white transition-colors">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </span>
                                    <span>Jalur promosi kepemimpinan dipercepat</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION TERAKHIR: APA KATA KARYAWAN KAMI? (Background Putih Menyatu Utuh Antara Judul & Konten Utama) -->
    <section id="testimoni-karyawan" class="relative w-full bg-white py-16 sm:py-20 md:py-24 select-none overflow-hidden">
        <!-- Dekorasi Background Putih Menyatu: Pattern Bintik Gradasi Halus & Soft Radial Glow (Searah Gaya Section Tentang Kami) -->
        <div class="pointer-events-none select-none absolute inset-0 overflow-hidden">
            <div class="absolute inset-0 opacity-65"
                style="background-image: radial-gradient(rgba(177, 17, 22, 0.14) 1.5px, transparent 1.5px); background-size: 24px 24px; mask-image: radial-gradient(ellipse 80% 75% at 50% 50%, black 20%, transparent 85%); -webkit-mask-image: radial-gradient(ellipse 80% 75% at 50% 50%, black 20%, transparent 85%);">
            </div>
            <div class="absolute -top-20 left-1/4 w-[480px] h-[320px] rounded-full bg-red-100/45 blur-3xl"></div>
            <div class="absolute -bottom-20 right-1/4 w-[480px] h-[320px] rounded-full bg-rose-100/50 blur-3xl"></div>
        </div>

        <!-- Judul Section Menyatu di Latar Putih -->
        <div class="relative z-10 max-w-6xl mx-auto px-6 text-center mb-12 sm:mb-16 md:mb-20">
            <h2 style="font-weight: 800;"
                class="font-display-title text-2xl sm:text-3xl md:text-4xl font-extrabold text-[#B11116] uppercase tracking-wider">
                APA KATA KARYAWAN KAMI?
            </h2>
            <div class="mt-3 flex items-center justify-center gap-2">
                <span class="w-3 h-1.5 rounded-full bg-[#B11116]/30"></span>
                <span class="w-14 h-1.5 rounded-full bg-gradient-to-r from-[#B11116] via-[#ff4757] to-[#B11116]"></span>
                <span class="w-3 h-1.5 rounded-full bg-[#B11116]/30"></span>
            </div>
        </div>

        <!-- Konten Utama Slider di Atas Latar Putih yang Sama -->
        <div id="testimoniSliderArea" class="relative z-10 max-w-6xl mx-auto px-4 sm:px-8 md:px-12">

            <!-- Tombol Navigasi Kiri (<) -->
            <button type="button" id="testimoniPrevBtn" aria-label="Testimoni Sebelumnya"
                class="cursor-pointer z-30 absolute left-1 sm:left-2 md:left-3 top-1/2 -translate-y-1/2 flex h-10 w-10 sm:h-12 sm:w-12 items-center justify-center rounded-full bg-white hover:bg-[#B11116] text-[#B11116] hover:text-white border-2 border-red-100 hover:border-[#B11116] shadow-lg shadow-red-950/10 transition-all duration-200 active:scale-90">
                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            <!-- Tombol Navigasi Kanan (>) -->
            <button type="button" id="testimoniNextBtn" aria-label="Testimoni Berikutnya"
                class="cursor-pointer z-30 absolute right-1 sm:right-2 md:right-3 top-1/2 -translate-y-1/2 flex h-10 w-10 sm:h-12 sm:w-12 items-center justify-center rounded-full bg-white hover:bg-[#B11116] text-[#B11116] hover:text-white border-2 border-red-100 hover:border-[#B11116] shadow-lg shadow-red-950/10 transition-all duration-200 active:scale-90">
                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </button>

            <!-- Wrapper Kartu Showcase Testimoni -->
            <div class="mx-6 sm:mx-10 md:mx-12 relative">
                <!-- Layered Offset Frame Khas Sosro di Belakang Kartu (Seragam dengan Section Tentang Kami) -->
                <div
                    class="absolute -bottom-3 -right-3 inset-x-4 top-4 rounded-[32px] bg-gradient-to-br from-[#B11116]/20 via-red-200/55 to-rose-200/65 -z-10 transform rotate-1">
                </div>
                <div
                    class="absolute -top-3 -left-2 inset-x-4 bottom-3 rounded-[32px] border-2 border-[#B11116]/20 bg-red-50/40 -z-10 transform -rotate-1">
                </div>

                <!-- Slides Container -->
                <div class="relative min-h-[260px] sm:min-h-[240px] md:min-h-[250px] flex items-center">

                    <!-- SLIDE 1: April Riya Enziliana (Product Portfolio) -->
                    <div class="testimoni-slide w-full transition-all duration-500 ease-out opacity-100 translate-x-0 relative z-10"
                        data-testimoni-idx="0">
                        <div
                            class="relative flex flex-col md:flex-row items-center md:items-end bg-white rounded-[28px] border border-red-100 shadow-[0_20px_50px_rgba(177,17,22,0.12)] px-6 pt-6 pb-7 sm:px-8 sm:py-8 md:pl-0 md:pr-12 md:py-9 overflow-visible">
                            <!-- Top Accent Strip -->
                            <div
                                class="absolute top-0 inset-x-8 h-1.5 rounded-b-full bg-gradient-to-r from-[#B11116] via-[#ff4757] to-[#B11116]">
                            </div>

                            <!-- Pedestal Merah & Foto Cutout Karyawan 1 (Menjorok ke Atas Kartu) -->
                            <div class="relative md:w-64 lg:w-72 shrink-0 flex justify-center items-end mb-5 md:mb-0">
                                <!-- Arch Backdrop Merah di Belakang Foto Karyawan -->
                                <div
                                    class="w-40 h-36 sm:w-44 sm:h-40 md:w-48 md:h-44 rounded-t-full rounded-b-3xl bg-gradient-to-b from-[#e02430] to-[#B11116] shadow-lg shadow-red-900/20 relative overflow-hidden flex items-end justify-center">
                                    <img src="{{ asset('assets/images/sosro-ornament.png') }}" alt=""
                                        class="absolute -right-4 -bottom-4 w-28 object-contain opacity-25 transform -rotate-12 pointer-events-none">
                                </div>
                                <img src="{{ asset('assets/images/karyawan-1.png') }}"
                                    alt="April Riya Enziliana - Product Portfolio" draggable="false"
                                    class="absolute bottom-0 w-36 sm:w-40 md:w-48 lg:w-52 h-auto object-contain drop-shadow-[0_12px_20px_rgba(45,4,7,0.28)] pointer-events-none">
                            </div>

                            <!-- Teks Kutipan Testimoni -->
                            <div class="flex-1 text-center md:text-left relative z-10">
                                <!-- Watermark Quote & Ornamen di Sudut Kanan -->
                                <svg class="hidden sm:block absolute -top-4 right-0 w-16 h-16 md:w-20 md:h-20 text-[#B11116]/[0.07] pointer-events-none select-none"
                                    viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                                </svg>

                                <p
                                    class="text-slate-800 text-sm sm:text-base md:text-[17px] lg:text-[18px] leading-relaxed font-medium">
                                    “Lingkungan kerja yang produktif, dimana atasan dan rekan kerja sangat mensupport
                                    terhadap perkembangan kemampuan kinerja saya serta komunikasi yang terjalin dengan
                                    sangat baik.”
                                </p>
                                <div class="mt-5 inline-flex flex-col md:border-l-4 md:border-[#B11116] md:pl-3.5">
                                    <p class="font-extrabold text-slate-900 text-sm sm:text-base">April Riya Enziliana</p>
                                    <p class="text-[#B11116] italic text-xs sm:text-sm font-semibold">Product Portfolio</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SLIDE 2: Adeline Chrisatmaja (Accounting) -->
                    <div class="testimoni-slide w-full transition-all duration-500 ease-out opacity-0 translate-x-6 pointer-events-none hidden relative z-0"
                        data-testimoni-idx="1">
                        <div
                            class="relative flex flex-col md:flex-row items-center md:items-end bg-white rounded-[28px] border border-red-100 shadow-[0_20px_50px_rgba(177,17,22,0.12)] px-6 pt-6 pb-7 sm:px-8 sm:py-8 md:pl-0 md:pr-12 md:py-9 overflow-visible">
                            <!-- Top Accent Strip -->
                            <div
                                class="absolute top-0 inset-x-8 h-1.5 rounded-b-full bg-gradient-to-r from-[#B11116] via-[#ff4757] to-[#B11116]">
                            </div>

                            <!-- Pedestal Merah & Foto Cutout Karyawan 2 (Menjorok ke Atas Kartu) -->
                            <div class="relative md:w-64 lg:w-72 shrink-0 flex justify-center items-end mb-5 md:mb-0">
                                <!-- Arch Backdrop Merah di Belakang Foto Karyawan -->
                                <div
                                    class="w-40 h-36 sm:w-44 sm:h-40 md:w-48 md:h-44 rounded-t-full rounded-b-3xl bg-gradient-to-b from-[#e02430] to-[#B11116] shadow-lg shadow-red-900/20 relative overflow-hidden flex items-end justify-center">
                                    <img src="{{ asset('assets/images/sosro-ornament.png') }}" alt=""
                                        class="absolute -right-4 -bottom-4 w-28 object-contain opacity-25 transform -rotate-12 pointer-events-none">
                                </div>
                                <img src="{{ asset('assets/images/karyawan-2.png') }}"
                                    alt="Adeline Chrisatmaja - Accounting" draggable="false"
                                    class="absolute bottom-0 w-36 sm:w-40 md:w-48 lg:w-52 h-auto object-contain drop-shadow-[0_12px_20px_rgba(45,4,7,0.28)] pointer-events-none">
                            </div>

                            <!-- Teks Kutipan Testimoni -->
                            <div class="flex-1 text-center md:text-left relative z-10">
                                <!-- Watermark Quote & Ornamen di Sudut Kanan -->
                                <svg class="hidden sm:block absolute -top-4 right-0 w-16 h-16 md:w-20 md:h-20 text-[#B11116]/[0.07] pointer-events-none select-none"
                                    viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                                </svg>

                                <p
                                    class="text-slate-800 text-sm sm:text-base md:text-[17px] lg:text-[18px] leading-relaxed font-medium">
                                    “Bangga menjadi bagian dari PT Sinar Sosro Gunung Slamat (SGS) dimana PT Sinar Sosro
                                    Gunung Slamat salah satu perusahaan pelopor teh nomor satu di Indonesia.”
                                </p>
                                <div class="mt-5 inline-flex flex-col md:border-l-4 md:border-[#B11116] md:pl-3.5">
                                    <p class="font-extrabold text-slate-900 text-sm sm:text-base">Adeline Chrisatmaja</p>
                                    <p class="text-[#B11116] italic text-xs sm:text-sm font-semibold">Accounting</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SLIDE 3: Karyawan 3 (Operations & Supply Chain) -->
                    <div class="testimoni-slide w-full transition-all duration-500 ease-out opacity-0 translate-x-6 pointer-events-none hidden relative z-0"
                        data-testimoni-idx="2">
                        <div
                            class="relative flex flex-col md:flex-row items-center md:items-end bg-white rounded-[28px] border border-red-100 shadow-[0_20px_50px_rgba(177,17,22,0.12)] px-6 pt-6 pb-7 sm:px-8 sm:py-8 md:pl-0 md:pr-12 md:py-9 overflow-visible">
                            <!-- Top Accent Strip -->
                            <div
                                class="absolute top-0 inset-x-8 h-1.5 rounded-b-full bg-gradient-to-r from-[#B11116] via-[#ff4757] to-[#B11116]">
                            </div>

                            <!-- Pedestal Merah & Foto Cutout Karyawan 3 (Menjorok ke Atas Kartu) -->
                            <div class="relative md:w-64 lg:w-72 shrink-0 flex justify-center items-end mb-5 md:mb-0">
                                <!-- Arch Backdrop Merah di Belakang Foto Karyawan -->
                                <div
                                    class="w-40 h-36 sm:w-44 sm:h-40 md:w-48 md:h-44 rounded-t-full rounded-b-3xl bg-gradient-to-b from-[#e02430] to-[#B11116] shadow-lg shadow-red-900/20 relative overflow-hidden flex items-end justify-center">
                                    <img src="{{ asset('assets/images/sosro-ornament.png') }}" alt=""
                                        class="absolute -right-4 -bottom-4 w-28 object-contain opacity-25 transform -rotate-12 pointer-events-none">
                                </div>
                                <img src="{{ asset('assets/images/karyawan-3.png') }}"
                                    alt="Rizky Pratama - Operations & Supply Chain" draggable="false"
                                    class="absolute bottom-0 w-40 sm:w-44 md:w-52 lg:w-56 h-auto object-contain drop-shadow-[0_12px_20px_rgba(45,4,7,0.28)] pointer-events-none">
                            </div>

                            <!-- Teks Kutipan Testimoni -->
                            <div class="flex-1 text-center md:text-left relative z-10">
                                <!-- Watermark Quote & Ornamen di Sudut Kanan -->
                                <svg class="hidden sm:block absolute -top-4 right-0 w-16 h-16 md:w-20 md:h-20 text-[#B11116]/[0.07] pointer-events-none select-none"
                                    viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                                </svg>

                                <p
                                    class="text-slate-800 text-sm sm:text-base md:text-[17px] lg:text-[18px] leading-relaxed font-medium">
                                    “Budaya kerja kekeluargaan yang hangat serta kesempatan kolaborasi lintas divisi membuat
                                    saya terus bertumbuh dan bangga berkarya bersama PT Sinar Sosro Gunung Slamat.”
                                </p>
                                <div class="mt-5 inline-flex flex-col md:border-l-4 md:border-[#B11116] md:pl-3.5">
                                    <p class="font-extrabold text-slate-900 text-sm sm:text-base">Rizky Pratama</p>
                                    <p class="text-[#B11116] italic text-xs sm:text-sm font-semibold">Operations &amp;
                                        Supply Chain</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Dots Indicator Pill-Style Merah di Bawah Kartu -->
            <div class="flex items-center justify-center gap-2 mt-8 sm:mt-9" id="testimoniDots">
                <button type="button"
                    class="testimoni-dot w-8 h-2.5 rounded-full bg-[#B11116] transition-all duration-300 cursor-pointer shadow-xs"
                    data-testimoni-target="0" aria-label="Testimoni 1"></button>
                <button type="button"
                    class="testimoni-dot w-2.5 h-2.5 rounded-full bg-red-200 hover:bg-red-300 transition-all duration-300 cursor-pointer shadow-xs"
                    data-testimoni-target="1" aria-label="Testimoni 2"></button>
                <button type="button"
                    class="testimoni-dot w-2.5 h-2.5 rounded-full bg-red-200 hover:bg-red-300 transition-all duration-300 cursor-pointer shadow-xs"
                    data-testimoni-target="2" aria-label="Testimoni 3"></button>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const jobSearch = document.getElementById('jobSearch');
            const btnSearch = document.getElementById('btnSearch');
            const filterLocation = document.getElementById('filterLocation');
            const filterCategory = document.getElementById('filterCategory');
            const filterBidang = document.getElementById('filterBidang');
            const jobCount = document.getElementById('jobCount');
            const noJobFound = document.getElementById('noJobFound');
            const btnResetFilter = document.getElementById('btnResetFilter');
            const jobCards = document.querySelectorAll('.job-card');

            function updateBidangOptions() {
                if (!filterBidang) return;

                const searchVal = (jobSearch ? jobSearch.value : '').trim().toLowerCase();
                const locVal = (filterLocation ? filterLocation.value : '').trim().toLowerCase();
                const catVal = (filterCategory ? filterCategory.value : '').trim().toLowerCase();

                const prevSelectedVal = filterBidang.value;
                const availableBidangs = new Map();

                jobCards.forEach(card => {
                    const cardLoc = (card.dataset.location || '').toLowerCase();
                    const cardCat = (card.dataset.category || '').toLowerCase();
                    const cardSearch = (card.dataset.search || '').toLowerCase();
                    const cardBidName = card.dataset.bidangName || '';

                    const matchesLoc = !locVal || cardLoc === locVal;
                    const matchesCat = !catVal || cardCat === catVal;
                    const matchesSearch = !searchVal || cardSearch.includes(searchVal);

                    if (matchesLoc && matchesCat && matchesSearch && cardBidName.trim() !== '') {
                        availableBidangs.set(cardBidName.toLowerCase(), cardBidName);
                    }
                });

                filterBidang.innerHTML = '<option value="">Semua Bidang</option>';
                let stillHasSelected = false;

                availableBidangs.forEach((origName, lowerVal) => {
                    const opt = document.createElement('option');
                    opt.value = origName;
                    opt.textContent = origName;
                    if (prevSelectedVal && prevSelectedVal.toLowerCase() === lowerVal) {
                        opt.selected = true;
                        stillHasSelected = true;
                    }
                    filterBidang.appendChild(opt);
                });

                if (!stillHasSelected && prevSelectedVal !== '') {
                    filterBidang.value = '';
                }
                syncBidangCustomDropdown();
            }

            // Sync Custom Dropdown Options for Bidang dynamically
            function syncBidangCustomDropdown() {
                const bidangDropdown = document.querySelector('.custom-dropdown[data-target="filterBidang"]');
                if (!bidangDropdown || !filterBidang) return;

                const optionsContainer = bidangDropdown.querySelector('.dropdown-options');
                const triggerLabel = bidangDropdown.querySelector('.dropdown-label');
                const trigger = bidangDropdown.querySelector('.dropdown-trigger');
                if (!optionsContainer) return;

                let html = `
                    <button type="button" data-value="" class="dropdown-option w-full text-left px-3.5 py-2.5 rounded-xl text-xs sm:text-sm font-medium ${!filterBidang.value ? 'text-[#B11116] bg-red-50/70 font-semibold' : 'text-slate-700 hover:text-[#B11116] hover:bg-red-50/80'} flex items-center justify-between transition cursor-pointer">
                        <span>Semua Bidang</span>
                        <svg class="option-check ${!filterBidang.value ? '' : 'hidden'} w-4 h-4 text-[#B11116]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                    </button>
                `;

                Array.from(filterBidang.options).forEach(opt => {
                    if (!opt.value) return;
                    const isSelected = filterBidang.value === opt.value;
                    html += `
                        <button type="button" data-value="${opt.value}" class="dropdown-option w-full text-left px-3.5 py-2.5 rounded-xl text-xs sm:text-sm font-medium ${isSelected ? 'text-[#B11116] bg-red-50/70 font-semibold' : 'text-slate-700 hover:text-[#B11116] hover:bg-red-50/80'} flex items-center justify-between transition cursor-pointer">
                            <span>${opt.textContent}</span>
                            <svg class="option-check ${isSelected ? '' : 'hidden'} w-4 h-4 text-[#B11116]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        </button>
                    `;
                });

                optionsContainer.innerHTML = html;

                if (triggerLabel) {
                    triggerLabel.textContent = filterBidang.value || 'Semua Bidang';
                    if (filterBidang.value) {
                        trigger.classList.add('text-slate-800');
                        trigger.classList.remove('text-[#c77a87]');
                    } else {
                        trigger.classList.remove('text-slate-800');
                        trigger.classList.add('text-[#c77a87]');
                    }
                }
            }

            function filterJobs() {
                const searchVal = (jobSearch ? jobSearch.value : '').trim().toLowerCase();
                const locVal = (filterLocation ? filterLocation.value : '').trim().toLowerCase();
                const catVal = (filterCategory ? filterCategory.value : '').trim().toLowerCase();
                const bidVal = (filterBidang ? filterBidang.value : '').trim().toLowerCase();

                let visibleCount = 0;

                jobCards.forEach(card => {
                    const cardLoc = (card.dataset.location || '').toLowerCase();
                    const cardCat = (card.dataset.category || '').toLowerCase();
                    const cardBid = (card.dataset.bidang || '').toLowerCase();
                    const cardSearch = (card.dataset.search || '').toLowerCase();

                    const matchesLoc = !locVal || cardLoc === locVal;
                    const matchesCat = !catVal || cardCat === catVal;
                    const matchesBid = !bidVal || cardBid === bidVal;
                    const matchesSearch = !searchVal || cardSearch.includes(searchVal);

                    if (matchesLoc && matchesCat && matchesBid && matchesSearch) {
                        card.classList.remove('hidden');
                        visibleCount++;
                    } else {
                        card.classList.add('hidden');
                    }
                });

                if (jobCount) {
                    jobCount.textContent = visibleCount;
                }

                if (noJobFound) {
                    if (visibleCount === 0 && jobCards.length > 0) {
                        noJobFound.classList.remove('hidden');
                    } else {
                        noJobFound.classList.add('hidden');
                    }
                }
            }

            // HCI Search Clear Button (Nielsen Heuristic #3: User Control & Freedom)
            const btnClearSearch = document.getElementById('btnClearSearch');
            if (jobSearch) {
                jobSearch.addEventListener('input', function() {
                    if (btnClearSearch) {
                        if (jobSearch.value.trim().length > 0) {
                            btnClearSearch.classList.remove('hidden');
                        } else {
                            btnClearSearch.classList.add('hidden');
                        }
                    }
                });
                function submitSearchToLowongan() {
                    const params = new URLSearchParams();
                    if (jobSearch && jobSearch.value.trim()) {
                        params.set('search', jobSearch.value.trim());
                    }
                    if (filterLocation && filterLocation.value) {
                        params.set('location', filterLocation.value);
                    }
                    if (filterCategory && filterCategory.value) {
                        params.set('category', filterCategory.value);
                    }
                    if (filterBidang && filterBidang.value) {
                        params.set('bidang', filterBidang.value);
                    }
                    const query = params.toString();
                    window.location.href = "{{ route('guest.lowongan') }}" + (query ? '?' + query : '');
                }

                jobSearch.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        submitSearchToLowongan();
                    }
                });
            }

            if (btnClearSearch && jobSearch) {
                btnClearSearch.addEventListener('click', function() {
                    jobSearch.value = '';
                    btnClearSearch.classList.add('hidden');
                    jobSearch.focus();
                    updateBidangOptions();
                    filterJobs();
                });
            }

            if (btnSearch) {
                btnSearch.addEventListener('click', function() {
                    submitSearchToLowongan();
                });
            }

            // Custom Themed Dropdowns Controller
            const customDropdowns = document.querySelectorAll('.custom-dropdown');

            customDropdowns.forEach(dropdown => {
                const targetId = dropdown.dataset.target;
                const hiddenSelect = document.getElementById(targetId);
                const trigger = dropdown.querySelector('.dropdown-trigger');
                const menu = dropdown.querySelector('.dropdown-menu');
                const label = dropdown.querySelector('.dropdown-label');
                const chevron = dropdown.querySelector('.dropdown-chevron');
                const defaultText = label?.dataset.default || 'Pilih';

                if (!trigger || !menu) return;

                function openDropdown() {
                    customDropdowns.forEach(other => {
                        if (other !== dropdown) {
                            other.querySelector('.dropdown-menu')?.classList.add('hidden');
                            other.querySelector('.dropdown-chevron')?.classList.remove(
                            'rotate-180');
                        }
                    });
                    menu.classList.remove('hidden');
                    chevron?.classList.add('rotate-180');
                }

                function closeDropdown() {
                    menu.classList.add('hidden');
                    chevron?.classList.remove('rotate-180');
                }

                trigger.addEventListener('click', (e) => {
                    e.stopPropagation();
                    if (menu.classList.contains('hidden')) {
                        openDropdown();
                    } else {
                        closeDropdown();
                    }
                });

                function updateUiSelection(val, text) {
                    if (label) {
                        label.textContent = val ? text : defaultText;
                        if (val) {
                            label.classList.add('text-slate-800');
                            label.classList.remove('text-[#c77a87]');
                        } else {
                            label.classList.remove('text-slate-800');
                            label.classList.add('text-[#c77a87]');
                        }
                    }

                    dropdown.querySelectorAll('.dropdown-option').forEach(opt => {
                        const optVal = opt.dataset.value;
                        const check = opt.querySelector('.option-check');
                        if (optVal === val) {
                            opt.classList.add('text-[#B11116]', 'bg-red-50/70', 'font-semibold');
                            opt.classList.remove('text-slate-700');
                            check?.classList.remove('hidden');
                        } else {
                            opt.classList.remove('text-[#B11116]', 'bg-red-50/70', 'font-semibold');
                            opt.classList.add('text-slate-700');
                            check?.classList.add('hidden');
                        }
                    });
                }

                dropdown.addEventListener('click', (e) => {
                    const optionBtn = e.target.closest('.dropdown-option');
                    if (optionBtn) {
                        const val = optionBtn.dataset.value;
                        const text = optionBtn.querySelector('span')?.textContent || '';
                        if (hiddenSelect) {
                            hiddenSelect.value = val;
                            hiddenSelect.dispatchEvent(new Event('change'));
                        }
                        updateUiSelection(val, text);
                        closeDropdown();
                    }
                });

                // Sync initial selection
                if (hiddenSelect && hiddenSelect.value) {
                    const currentOpt = hiddenSelect.options[hiddenSelect.selectedIndex];
                    updateUiSelection(hiddenSelect.value, currentOpt ? currentOpt.textContent : hiddenSelect
                        .value);
                }
            });

            // Close dropdowns when clicking outside
            document.addEventListener('click', (e) => {
                if (!e.target.closest('.custom-dropdown')) {
                    customDropdowns.forEach(dropdown => {
                        dropdown.querySelector('.dropdown-menu')?.classList.add('hidden');
                        dropdown.querySelector('.dropdown-chevron')?.classList.remove('rotate-180');
                    });
                }
            });

            // Close dropdowns on Escape key
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    customDropdowns.forEach(dropdown => {
                        dropdown.querySelector('.dropdown-menu')?.classList.add('hidden');
                        dropdown.querySelector('.dropdown-chevron')?.classList.remove('rotate-180');
                    });
                }
            });

            if (filterLocation) {
                filterLocation.addEventListener('change', function() {
                    updateBidangOptions();
                });
            }

            if (filterCategory) {
                filterCategory.addEventListener('change', function() {
                    updateBidangOptions();
                });
            }

            if (btnResetFilter) {
                btnResetFilter.addEventListener('click', function() {
                    if (jobSearch) {
                        jobSearch.value = '';
                        if (btnClearSearch) btnClearSearch.classList.add('hidden');
                    }
                    if (filterLocation) filterLocation.value = '';
                    if (filterCategory) filterCategory.value = '';
                    if (filterBidang) filterBidang.value = '';

                    // Reset custom dropdown UI labels
                    customDropdowns.forEach(dropdown => {
                        const label = dropdown.querySelector('.dropdown-label');
                        const defaultText = label?.dataset.default || 'Semua';
                        if (label) {
                            label.textContent = defaultText;
                            label.classList.remove('text-slate-800');
                            label.classList.add('text-[#c77a87]');
                        }
                        dropdown.querySelectorAll('.dropdown-option').forEach(opt => {
                            const check = opt.querySelector('.option-check');
                            if (!opt.dataset.value) {
                                opt.classList.add('text-[#B11116]', 'bg-red-50/70',
                                    'font-semibold');
                                opt.classList.remove('text-slate-700');
                                check?.classList.remove('hidden');
                            } else {
                                opt.classList.remove('text-[#B11116]', 'bg-red-50/70',
                                    'font-semibold');
                                opt.classList.add('text-slate-700');
                                check?.classList.add('hidden');
                            }
                        });
                    });

                    updateBidangOptions();
                    filterJobs();
                });
            }

            // Sync with URL params if any
            const urlParams = new URLSearchParams(window.location.search);
            let hasParams = false;
            if (urlParams.get('search') && jobSearch) {
                jobSearch.value = urlParams.get('search');
                hasParams = true;
            }
            if (urlParams.get('location') && filterLocation) {
                filterLocation.value = urlParams.get('location');
                hasParams = true;
            }
            if (urlParams.get('category') && filterCategory) {
                filterCategory.value = urlParams.get('category');
                hasParams = true;
            }
            updateBidangOptions();
            if (urlParams.get('bidang') && filterBidang) {
                filterBidang.value = urlParams.get('bidang');
                hasParams = true;
            }
            filterJobs();

            // Hero Jumbotron Slider (Work Together As A Team & Be Part of Something Bigger)
            const slides = document.querySelectorAll('#jumbotronSlider .slide-item');
            const dots = document.querySelectorAll('#sliderDots .slider-dot');
            const prevBtn = document.getElementById('prevSlideBtn');
            const nextBtn = document.getElementById('nextSlideBtn');
            let currentSlide = 0;
            let slideTimer = null;

            function showSlide(index) {
                if (!slides.length) return;
                currentSlide = (index + slides.length) % slides.length;

                slides.forEach((slide, i) => {
                    if (i === currentSlide) {
                        slide.classList.remove('opacity-0', 'pointer-events-none', 'z-0');
                        slide.classList.add('opacity-100', 'pointer-events-auto', 'z-10');
                    } else {
                        slide.classList.remove('opacity-100', 'pointer-events-auto', 'z-10');
                        slide.classList.add('opacity-0', 'pointer-events-none', 'z-0');
                    }
                });

                dots.forEach((dot, i) => {
                    if (i === currentSlide) {
                        dot.classList.remove('w-2', 'bg-white/40');
                        dot.classList.add('w-8', 'bg-white');
                    } else {
                        dot.classList.remove('w-8', 'bg-white');
                        dot.classList.add('w-2', 'bg-white/40');
                    }
                });

                // Auto running / pause video pada Slide 3
                const slideVideo = document.getElementById('slideHeroVideoIframe');
                if (slideVideo && slideVideo.contentWindow) {
                    if (currentSlide === 2) {
                        slideVideo.contentWindow.postMessage('{"event":"command","func":"playVideo","args":""}',
                            '*');
                    } else {
                        slideVideo.contentWindow.postMessage('{"event":"command","func":"pauseVideo","args":""}',
                            '*');
                    }
                }
            }

            function nextSlide() {
                showSlide(currentSlide + 1);
            }

            function prevSlide() {
                showSlide(currentSlide - 1);
            }

            function startSlideTimer() {
                stopSlideTimer();
                slideTimer = setInterval(nextSlide, 6000);
            }

            function stopSlideTimer() {
                if (slideTimer) {
                    clearInterval(slideTimer);
                    slideTimer = null;
                }
            }

            if (slides.length > 1) {
                dots.forEach((dot, idx) => {
                    dot.addEventListener('click', () => {
                        showSlide(idx);
                        startSlideTimer();
                    });
                });

                if (prevBtn) {
                    prevBtn.addEventListener('click', () => {
                        prevSlide();
                        startSlideTimer();
                    });
                }

                if (nextBtn) {
                    nextBtn.addEventListener('click', () => {
                        nextSlide();
                        startSlideTimer();
                    });
                }

                const heroSection = document.getElementById('beranda');
                if (heroSection) {
                    heroSection.addEventListener('mouseenter', stopSlideTimer);
                    heroSection.addEventListener('mouseleave', startSlideTimer);

                    // Touch swipe support on mobile
                    let touchStartX = 0;
                    heroSection.addEventListener('touchstart', (e) => {
                        touchStartX = e.changedTouches[0].screenX;
                    }, {
                        passive: true
                    });

                    heroSection.addEventListener('touchend', (e) => {
                        const touchEndX = e.changedTouches[0].screenX;
                        const diff = touchStartX - touchEndX;
                        if (Math.abs(diff) > 45) {
                            if (diff > 0) nextSlide();
                            else prevSlide();
                            startSlideTimer();
                        }
                    }, {
                        passive: true
                    });
                }

                startSlideTimer();
            }
        });
    </script>

    <!-- MODAL 1: Notifikasi Belum Login -->
    <div id="modalBelumLogin"
        class="fixed inset-0 z-[100] hidden items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm transition-all"
        role="dialog" aria-modal="true">
        <div
            class="bg-white w-full max-w-md rounded-2xl shadow-2xl border border-slate-200 overflow-hidden transform transition-all">
            <div class="p-6 text-center">
                <div
                    class="w-12 h-12 rounded-2xl bg-amber-50 border border-amber-100 flex items-center justify-center text-amber-600 mx-auto mb-4 shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                    </svg>
                </div>
                <h3 class="text-base font-semibold text-slate-900">
                    Masuk ke Akun Diperlukan
                </h3>
                <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                    Anda harus masuk (login) ke akun Anda terlebih dahulu untuk dapat melamar posisi <span
                        id="modalLoginJobTitle" class="font-semibold text-slate-800"></span>.
                </p>
            </div>
            <div class="px-6 py-4 bg-slate-50/70 border-t border-slate-100 flex items-center justify-end gap-2.5">
                <button type="button" onclick="tutupModalBelumLogin()"
                    class="px-4 py-2 rounded-xl border border-slate-200 bg-white text-slate-600 hover:bg-slate-100 hover:text-slate-800 font-semibold text-xs transition cursor-pointer">
                    Batal
                </button>
                <a href="{{ route('guest.login') }}?required=1"
                    class="inline-flex items-center gap-1.5 px-5 py-2 rounded-xl bg-[#B11116] hover:bg-[#940e13] text-white font-semibold text-xs shadow-sm transition cursor-pointer">
                    Masuk Sekarang
                </a>
            </div>
        </div>
    </div>

    <!-- MODAL 2: Notifikasi Belum Isi Biodata -->
    <div id="modalBelumBiodata"
        class="fixed inset-0 z-[100] hidden items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm transition-all"
        role="dialog" aria-modal="true">
        <div
            class="bg-white w-full max-w-md rounded-2xl shadow-2xl border border-slate-200 overflow-hidden transform transition-all">
            <div class="p-6 text-center">
                <div
                    class="w-12 h-12 rounded-2xl bg-amber-50 border border-amber-100 flex items-center justify-center text-amber-600 mx-auto mb-4 shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                </div>
                <h3 class="text-base font-semibold text-slate-900">
                    Lengkapi Biodata Anda
                </h3>
                <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                    Anda harus melengkapi data biodata pelamar terlebih dahulu sebelum dapat melamar posisi <span
                        id="modalBiodataJobTitle" class="font-semibold text-slate-800"></span>.
                </p>
            </div>
            <div class="px-6 py-4 bg-slate-50/70 border-t border-slate-100 flex items-center justify-end gap-2.5">
                <button type="button" onclick="tutupModalBelumBiodata()"
                    class="px-4 py-2 rounded-xl border border-slate-200 bg-white text-slate-600 hover:bg-slate-100 hover:text-slate-800 font-semibold text-xs transition cursor-pointer">
                    Batal
                </button>
                <a href="{{ route('biodata.create') }}?required=1"
                    class="inline-flex items-center gap-1.5 px-5 py-2 rounded-xl bg-[#B11116] hover:bg-[#940e13] text-white font-semibold text-xs shadow-sm transition cursor-pointer">
                    Isi Biodata Sekarang
                </a>
            </div>
        </div>
    </div>

    <!-- MODAL 3: Konfirmasi Lamar (Sudah Login & Biodata Terisi) -->
    <div id="modalKonfirmasiLamar"
        class="fixed inset-0 z-[100] hidden items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm transition-all"
        role="dialog" aria-modal="true">
        <div
            class="bg-white w-full max-w-md rounded-2xl shadow-2xl border border-slate-200 overflow-hidden transform transition-all">
            <div class="p-6 text-center">
                <div
                    class="w-12 h-12 rounded-2xl bg-red-50 border border-red-100 flex items-center justify-center text-[#B11116] mx-auto mb-4 shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0zm-9 3.75h.008v.008H12v-.008z" />
                    </svg>
                </div>
                <h3 class="text-base font-semibold text-slate-900">
                    Kirim Lamaran Pekerjaan?
                </h3>
                <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                    Apakah Anda yakin ingin mengirimkan lamaran untuk posisi <span id="modalLamarJobTitle"
                        class="font-semibold text-slate-800"></span>?
                </p>
            </div>
            <div class="px-6 py-4 bg-slate-50/70 border-t border-slate-100 flex items-center justify-end gap-2.5">
                <button type="button" onclick="tutupModalLamar()"
                    class="px-4 py-2 rounded-xl border border-slate-200 bg-white text-slate-600 hover:bg-slate-100 hover:text-slate-800 font-semibold text-xs transition cursor-pointer">
                    Batal
                </button>
                <button type="button" id="btnSubmitLamar"
                    class="inline-flex items-center gap-1.5 px-5 py-2 rounded-xl bg-[#B11116] hover:bg-[#940e13] text-white font-semibold text-xs shadow-sm transition cursor-pointer">
                    Ya, Kirim Lamaran
                </button>
            </div>
        </div>
    </div>

    <!-- MODAL 4: Akun Administrator Tidak Dapat Melamar -->
    <div id="modalAkunAdmin"
        class="fixed inset-0 z-[100] hidden items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm transition-all"
        role="dialog" aria-modal="true">
        <div
            class="bg-white w-full max-w-md rounded-2xl shadow-2xl border border-slate-200 overflow-hidden transform transition-all">
            <div class="p-6 text-center">
                <div
                    class="w-12 h-12 rounded-2xl bg-amber-50 border border-amber-100 flex items-center justify-center text-amber-600 mx-auto mb-4 shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                </div>
                <h3 class="text-base font-semibold text-slate-900">
                    Akses Dibatasi
                </h3>
                <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                    Anda sedang masuk sebagai <span class="font-semibold text-slate-800">Administrator</span>. Akun
                    Administrator tidak dapat melamar lowongan pekerjaan. Silakan gunakan akun Pelamar untuk melamar
                    lowongan.
                </p>
            </div>
            <div class="px-6 py-4 bg-slate-50/70 border-t border-slate-100 flex items-center justify-end">
                <button type="button" onclick="tutupModalAkunAdmin()"
                    class="px-5 py-2 rounded-xl bg-slate-800 hover:bg-slate-900 text-white font-semibold text-xs transition cursor-pointer">
                    Mengerti
                </button>
            </div>
        </div>
    </div>

    <script>
        function getJobTitle(trigger) {
            if (typeof trigger === 'string') return trigger;
            return (trigger && trigger.dataset && trigger.dataset.title) ? trigger.dataset.title : '';
        }

        function handleBelumLogin(trigger) {
            const title = getJobTitle(trigger);
            const titleEl = document.getElementById('modalLoginJobTitle');
            if (titleEl) titleEl.textContent = title;
            const modal = document.getElementById('modalBelumLogin');
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        }

        function tutupModalBelumLogin() {
            const modal = document.getElementById('modalBelumLogin');
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        }

        function handleBelumBiodata(trigger) {
            const title = getJobTitle(trigger);
            const titleEl = document.getElementById('modalBiodataJobTitle');
            if (titleEl) titleEl.textContent = title;
            const modal = document.getElementById('modalBelumBiodata');
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        }

        function tutupModalBelumBiodata() {
            const modal = document.getElementById('modalBelumBiodata');
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        }

        function handleAkunAdmin() {
            const modal = document.getElementById('modalAkunAdmin');
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        }

        function tutupModalAkunAdmin() {
            const modal = document.getElementById('modalAkunAdmin');
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        }

        let pendingLamarForm = null;
        let pendingLamarButton = null;

        function konfirmasiLamar(button) {
            const title = getJobTitle(button);
            pendingLamarButton = button;
            pendingLamarForm = button.closest('form');

            const titleEl = document.getElementById('modalLamarJobTitle');
            if (titleEl) {
                titleEl.textContent = title;
            }

            const modal = document.getElementById('modalKonfirmasiLamar');
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        }

        function tutupModalLamar() {
            const modal = document.getElementById('modalKonfirmasiLamar');
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
            pendingLamarForm = null;
            pendingLamarButton = null;
        }

        document.getElementById('btnSubmitLamar')?.addEventListener('click', function() {
            if (pendingLamarForm && pendingLamarButton) {
                this.disabled = true;
                this.textContent = 'Mengirim...';
                pendingLamarButton.disabled = true;
                pendingLamarButton.textContent = 'Mengirim...';
                pendingLamarForm.submit();
            }
        });

        // Hero Video Modal Functions
        function bukaModalHeroVideo() {
            const modal = document.getElementById('modalHeroVideo');
            const modalIframe = document.getElementById('modalHeroVideoIframe');
            const slideVideo = document.getElementById('slideHeroVideoIframe');

            // Hentikan sejenak video di slide saat modal terbuka
            if (slideVideo && slideVideo.contentWindow) {
                slideVideo.contentWindow.postMessage('{"event":"command","func":"pauseVideo","args":""}', '*');
            }

            // Muat video ke dalam modal dengan suara aktif
            if (modalIframe && modalIframe.dataset.src) {
                modalIframe.src = modalIframe.dataset.src;
            }

            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        }

        function tutupModalHeroVideo() {
            const modal = document.getElementById('modalHeroVideo');
            const modalIframe = document.getElementById('modalHeroVideoIframe');
            const slideVideo = document.getElementById('slideHeroVideoIframe');

            // Kosongkan src iframe modal agar audio segera berhenti
            if (modalIframe) {
                modalIframe.src = '';
            }

            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }

            // Lanjutkan kembali pemutaran video di slide jika pengguna masih berada di slide 3
            if (typeof currentSlide !== 'undefined' && currentSlide === 2 && slideVideo && slideVideo.contentWindow) {
                slideVideo.contentWindow.postMessage('{"event":"command","func":"playVideo","args":""}', '*');
            }
        }

        // Tutup modal ketika klik area background (backdrop)
        ['modalBelumLogin', 'modalBelumBiodata', 'modalKonfirmasiLamar', 'modalAkunAdmin', 'modalHeroVideo'].forEach(
            function(id) {
                const modalEl = document.getElementById(id);
                if (modalEl) {
                    modalEl.addEventListener('click', function(e) {
                        if (e.target === modalEl) {
                            modalEl.classList.add('hidden');
                            modalEl.classList.remove('flex');
                        }
                    });
                }
            });

        // Tutup modal ketika tombol Escape ditekan
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                tutupModalBelumLogin();
                tutupModalBelumBiodata();
                tutupModalLamar();
                tutupModalAkunAdmin();
                tutupModalHeroVideo();
            }
        });

        // About Photo-Only Slider Controller (Hanya Gambar yang Bergeser)
        (function() {
            const photoSlides = document.querySelectorAll('.about-photo-slide');
            const photoDots = document.querySelectorAll('.about-photo-dot');
            const prevBtn = document.getElementById('aboutPhotoPrevBtn');
            const nextBtn = document.getElementById('aboutPhotoNextBtn');
            const sliderCard = document.getElementById('aboutPhotoSliderCard');

            if (!photoSlides.length) return;

            let currentPhotoIdx = 0;
            let photoTimer = null;

            function showPhoto(index) {
                if (index < 0) index = photoSlides.length - 1;
                if (index >= photoSlides.length) index = 0;
                currentPhotoIdx = index;

                photoSlides.forEach((slide, i) => {
                    if (i === currentPhotoIdx) {
                        slide.classList.remove('opacity-0', 'pointer-events-none', 'z-0');
                        slide.classList.add('opacity-100', 'z-10');
                    } else {
                        slide.classList.remove('opacity-100', 'z-10');
                        slide.classList.add('opacity-0', 'pointer-events-none', 'z-0');
                    }
                });

                photoDots.forEach((dot, i) => {
                    if (i === currentPhotoIdx) {
                        dot.classList.remove('w-2', 'bg-red-200');
                        dot.classList.add('w-7', 'bg-[#B11116]');
                    } else {
                        dot.classList.remove('w-7', 'bg-[#B11116]');
                        dot.classList.add('w-2', 'bg-red-200');
                    }
                });
            }

            function nextPhoto() {
                showPhoto(currentPhotoIdx + 1);
            }

            function prevPhoto() {
                showPhoto(currentPhotoIdx - 1);
            }

            function startPhotoTimer() {
                stopPhotoTimer();
                photoTimer = setInterval(nextPhoto, 4500);
            }

            function stopPhotoTimer() {
                if (photoTimer) {
                    clearInterval(photoTimer);
                    photoTimer = null;
                }
            }

            if (nextBtn) {
                nextBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    nextPhoto();
                    startPhotoTimer();
                });
            }

            if (prevBtn) {
                prevBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    prevPhoto();
                    startPhotoTimer();
                });
            }

            photoDots.forEach((dot, i) => {
                dot.addEventListener('click', () => {
                    showPhoto(i);
                    startPhotoTimer();
                });
            });

            if (sliderCard) {
                sliderCard.addEventListener('mouseenter', stopPhotoTimer);
                sliderCard.addEventListener('mouseleave', startPhotoTimer);

                let touchStartX = 0;
                sliderCard.addEventListener('touchstart', (e) => {
                    touchStartX = e.changedTouches[0].screenX;
                }, {
                    passive: true
                });

                sliderCard.addEventListener('touchend', (e) => {
                    const touchEndX = e.changedTouches[0].screenX;
                    const diff = touchStartX - touchEndX;
                    if (Math.abs(diff) > 40) {
                        if (diff > 0) nextPhoto();
                        else prevPhoto();
                        startPhotoTimer();
                    }
                }, {
                    passive: true
                });
            }

            startPhotoTimer();

            // Interactive & Ambient Mesh Gradient Controller untuk Background Nilai Perusahaan
            const nilaiSection = document.getElementById('nilaiPerusahaanSection');
            const meshLeft = document.getElementById('nilaiMeshGlowLeft');
            const meshRight = document.getElementById('nilaiMeshGlowRight');

            if (nilaiSection && meshLeft && meshRight) {
                nilaiSection.addEventListener('mousemove', (e) => {
                    const rect = nilaiSection.getBoundingClientRect();
                    const xRatio = ((e.clientX - rect.left) / rect.width - 0.5) * 2;
                    const yRatio = ((e.clientY - rect.top) / rect.height - 0.5) * 2;
                    meshLeft.style.transform = `translate3d(${xRatio * 18}px, ${yRatio * 14}px, 0)`;
                    meshRight.style.transform = `translate3d(${xRatio * -18}px, ${yRatio * -14}px, 0)`;
                }, {
                    passive: true
                });

                nilaiSection.addEventListener('mouseleave', () => {
                    meshLeft.style.transform = 'translate3d(0, 0, 0)';
                    meshRight.style.transform = 'translate3d(0, 0, 0)';
                }, {
                    passive: true
                });
            }

            // Infinite Auto-Looping + Manual Drag/Swipe Slider untuk Produk Sosro
            const marqueeViewport = document.getElementById('productMarqueeViewport');
            const marqueeTrack = document.getElementById('productMarqueeTrack');

            if (marqueeViewport && marqueeTrack) {
                let offsetX = 0;
                const autoSpeed = 0.85; // Kecepatan gerak otomatis (px per frame)
                let isDragging = false;
                let startClientX = 0;
                let startOffsetX = 0;

                function getHalfWidth() {
                    return marqueeTrack.scrollWidth / 2;
                }

                function normalizeOffset(val) {
                    const half = getHalfWidth();
                    if (!half || half <= 0) return 0;
                    return ((val % half) + half) % half;
                }

                function renderMarquee() {
                    if (!isDragging) {
                        offsetX = normalizeOffset(offsetX + autoSpeed);
                    }
                    marqueeTrack.style.transform = `translate3d(${-offsetX}px, 0, 0)`;
                    requestAnimationFrame(renderMarquee);
                }

                // Mouse Drag Events
                marqueeViewport.addEventListener('mousedown', (e) => {
                    isDragging = true;
                    startClientX = e.clientX;
                    startOffsetX = offsetX;
                });

                window.addEventListener('mousemove', (e) => {
                    if (!isDragging) return;
                    const deltaX = e.clientX - startClientX;
                    offsetX = normalizeOffset(startOffsetX - deltaX);
                }, {
                    passive: true
                });

                window.addEventListener('mouseup', () => {
                    if (isDragging) {
                        isDragging = false;
                    }
                });

                // Touch Swipe Events (Mobile / Tablet)
                marqueeViewport.addEventListener('touchstart', (e) => {
                    if (!e.touches || !e.touches.length) return;
                    isDragging = true;
                    startClientX = e.touches[0].clientX;
                    startOffsetX = offsetX;
                }, {
                    passive: true
                });

                marqueeViewport.addEventListener('touchmove', (e) => {
                    if (!isDragging || !e.touches || !e.touches.length) return;
                    const deltaX = e.touches[0].clientX - startClientX;
                    offsetX = normalizeOffset(startOffsetX - deltaX);
                }, {
                    passive: true
                });

                marqueeViewport.addEventListener('touchend', () => {
                    isDragging = false;
                }, {
                    passive: true
                });

                marqueeViewport.addEventListener('touchcancel', () => {
                    isDragging = false;
                }, {
                    passive: true
                });

                // Trackpad / Horizontal Wheel Support
                marqueeViewport.addEventListener('wheel', (e) => {
                    if (Math.abs(e.deltaX) > Math.abs(e.deltaY)) {
                        e.preventDefault();
                        offsetX = normalizeOffset(offsetX + e.deltaX);
                    }
                }, {
                    passive: false
                });

                requestAnimationFrame(renderMarquee);
            }

            // Slider Testimoni Karyawan ("APA KATA KARYAWAN KAMI?") - 3 Orang
            const testimoniSlides = document.querySelectorAll('#testimoni-karyawan .testimoni-slide');
            const testimoniDots = document.querySelectorAll('#testimoniDots .testimoni-dot');
            const testimoniPrevBtn = document.getElementById('testimoniPrevBtn');
            const testimoniNextBtn = document.getElementById('testimoniNextBtn');
            const testimoniArea = document.getElementById('testimoniSliderArea');
            let currentTestimoniIdx = 0;
            let testimoniTimer = null;

            function showTestimoniSlide(index) {
                if (!testimoniSlides.length) return;
                currentTestimoniIdx = (index + testimoniSlides.length) % testimoniSlides.length;

                testimoniSlides.forEach((slide, i) => {
                    if (i === currentTestimoniIdx) {
                        slide.classList.remove('hidden', 'opacity-0', 'translate-x-6', 'pointer-events-none',
                            'z-0');
                        slide.classList.add('opacity-100', 'translate-x-0', 'z-10');
                    } else {
                        slide.classList.remove('opacity-100', 'translate-x-0', 'z-10');
                        slide.classList.add('hidden', 'opacity-0', 'translate-x-6', 'pointer-events-none',
                            'z-0');
                    }
                });

                testimoniDots.forEach((dot, i) => {
                    if (i === currentTestimoniIdx) {
                        dot.classList.remove('w-2.5', 'bg-red-200', 'hover:bg-red-300');
                        dot.classList.add('w-8', 'bg-[#B11116]');
                    } else {
                        dot.classList.remove('w-8', 'bg-[#B11116]');
                        dot.classList.add('w-2.5', 'bg-red-200', 'hover:bg-red-300');
                    }
                });
            }

            function nextTestimoni() {
                showTestimoniSlide(currentTestimoniIdx + 1);
            }

            function prevTestimoni() {
                showTestimoniSlide(currentTestimoniIdx - 1);
            }

            function startTestimoniTimer() {
                stopTestimoniTimer();
                testimoniTimer = setInterval(nextTestimoni, 6000);
            }

            function stopTestimoniTimer() {
                if (testimoniTimer) {
                    clearInterval(testimoniTimer);
                    testimoniTimer = null;
                }
            }

            if (testimoniSlides.length > 1) {
                if (testimoniPrevBtn) {
                    testimoniPrevBtn.addEventListener('click', () => {
                        prevTestimoni();
                        startTestimoniTimer();
                    });
                }

                if (testimoniNextBtn) {
                    testimoniNextBtn.addEventListener('click', () => {
                        nextTestimoni();
                        startTestimoniTimer();
                    });
                }

                testimoniDots.forEach((dot, idx) => {
                    dot.addEventListener('click', () => {
                        showTestimoniSlide(idx);
                        startTestimoniTimer();
                    });
                });

                if (testimoniArea) {
                    testimoniArea.addEventListener('mouseenter', stopTestimoniTimer);
                    testimoniArea.addEventListener('mouseleave', startTestimoniTimer);

                    let touchStartX = 0;
                    testimoniArea.addEventListener('touchstart', (e) => {
                        if (e.changedTouches && e.changedTouches.length) {
                            touchStartX = e.changedTouches[0].screenX;
                        }
                    }, {
                        passive: true
                    });

                    testimoniArea.addEventListener('touchend', (e) => {
                        if (e.changedTouches && e.changedTouches.length) {
                            const diff = touchStartX - e.changedTouches[0].screenX;
                            if (Math.abs(diff) > 40) {
                                if (diff > 0) nextTestimoni();
                                else prevTestimoni();
                                startTestimoniTimer();
                            }
                        }
                    }, {
                        passive: true
                    });
                }

                startTestimoniTimer();
            }
        })();
    </script>

    <!-- MODAL: Video Profil Perusahaan (Layar Penuh / Theater View) -->
    <div id="modalHeroVideo"
        class="fixed inset-0 z-[110] hidden items-center justify-center p-4 sm:p-6 md:p-8 bg-slate-950/85 backdrop-blur-md transition-all"
        role="dialog" aria-modal="true">
        <div class="relative w-full max-w-5xl bg-black rounded-3xl overflow-hidden shadow-2xl border border-white/20">
            <!-- Close Button -->
            <button type="button" onclick="tutupModalHeroVideo()" aria-label="Tutup Video"
                class="absolute top-4 right-4 z-20 flex h-10 w-10 items-center justify-center rounded-full bg-black/70 text-white hover:bg-black/95 transition border border-white/25 cursor-pointer shadow-lg hover:scale-105">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <div class="aspect-video w-full flex items-center justify-center bg-black text-white relative">
                <!-- Theater Video Player -->
                <iframe id="modalHeroVideoIframe" class="w-full h-full object-cover" src=""
                    data-src="https://www.youtube-nocookie.com/embed/LXb3EKWsInQ?autoplay=1&controls=1&rel=0&modestbranding=1"
                    title="Sosro Story Theater Video" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen>
                </iframe>
            </div>
        </div>
    </div>
@endsection
