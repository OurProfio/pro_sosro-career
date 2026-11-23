@extends('guest.layouts.index')

@section('title', 'Kontak')

@section('content')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        .font-brand-scope,
        #beranda-kontak,
        #beranda-kontak button,
        #beranda-kontak a,
        #kirim-pesan,
        #kirim-pesan input,
        #kirim-pesan select,
        #kirim-pesan textarea,
        #kirim-pesan button,
        #faq,
        #faq button {
            font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .font-display-title,
        #beranda-kontak h1,
        #kirim-pesan h2,
        #faq h2 {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif !important;
            letter-spacing: -0.025em;
        }
    </style>

    <section id="beranda-kontak"
        class="relative w-full min-h-[560px] sm:min-h-[600px] md:min-h-[640px] lg:min-h-[680px] bg-[#B11116] overflow-hidden flex items-center pt-28 pb-14 md:pt-32 md:pb-16">

        <div class="absolute inset-0 w-full h-full pointer-events-none select-none overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-tl from-[#78080c] via-[#B11116] to-[#cf1529]"></div>

            <div
                class="absolute inset-0 bg-[linear-gradient(to_right,rgba(255,255,255,0.06)_1px,transparent_1px),linear-gradient(to_bottom,rgba(255,255,255,0.06)_1px,transparent_1px)] [background-size:48px_48px]">
            </div>

            <div class="absolute -bottom-28 -left-24 w-[580px] md:w-[780px] h-[580px] md:h-[780px] rounded-full bg-radial from-[#ff5e3a]/20 via-[#e81928]/25 to-transparent blur-3xl"></div>
            <div class="absolute -top-24 -right-24 w-[520px] md:w-[700px] h-[520px] md:h-[700px] rounded-full bg-radial from-[#5c0407]/70 to-transparent blur-3xl"></div>

            <svg class="absolute inset-0 w-full h-full" viewBox="0 0 1440 600" preserveAspectRatio="none" fill="none" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <linearGradient id="curveLayerKontak" x1="0%" y1="100%" x2="100%" y2="0%">
                        <stop offset="0%" stop-color="#e8202d" stop-opacity="0.65" />
                        <stop offset="50%" stop-color="#B11116" stop-opacity="0.82" />
                        <stop offset="100%" stop-color="#690609" stop-opacity="0.92" />
                    </linearGradient>
                    <linearGradient id="curveMainKontak" x1="15%" y1="100%" x2="90%" y2="10%">
                        <stop offset="0%" stop-color="#df1a26" stop-opacity="0.88" />
                        <stop offset="50%" stop-color="#B11116" stop-opacity="0.95" />
                        <stop offset="100%" stop-color="#73080c" stop-opacity="0.9" />
                    </linearGradient>
                </defs>

                <path d="M0,190 C280,290 540,460 890,410 C1140,375 1290,190 1440,80 L1440,600 L0,600 Z"
                    fill="url(#curveLayerKontak)" />
                <path d="M0,300 C320,380 600,520 960,465 C1200,428 1330,275 1440,180 L1440,600 L0,600 Z"
                    fill="url(#curveMainKontak)" />
            </svg>

            <img src="{{ asset('assets/images/sosro-ornament.png') }}" alt=""
                class="absolute -left-8 top-14 md:left-6 md:top-16 w-40 sm:w-52 md:w-64 object-contain pointer-events-none select-none opacity-15 transform -rotate-12">
            <img src="{{ asset('assets/images/sosro-ornament.png') }}" alt=""
                class="absolute right-4 bottom-2 md:right-14 md:bottom-4 w-32 sm:w-44 md:w-52 object-contain pointer-events-none select-none opacity-20 transform rotate-12">
        </div>

        <div class="relative z-20 max-w-7xl mx-auto px-6 md:px-12 w-full">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-10 lg:gap-12 items-center">

                <div class="md:col-span-6 lg:col-span-7 text-left">
                    <h1 data-i18n-key="kontak_hero_title" style="font-weight: 800;"
                        class="font-display-title text-2xl sm:text-3xl md:text-4xl lg:text-[3.05rem] text-white font-extrabold uppercase leading-[1.14] tracking-tight drop-shadow-md">
                        CARI TAHU LEBIH TENTANG KARIER SINAR SOSRO GUNUNG SLAMAT
                    </h1>

                    <p data-i18n-key="kontak_hero_subtitle"
                        class="text-white font-bold text-base sm:text-lg md:text-xl mt-5 drop-shadow-sm">
                        Kami siap membantu!
                    </p>
                    <p data-i18n-key="kontak_hero_desc"
                        class="text-white/95 text-sm sm:text-base md:text-lg mt-1.5 max-w-2xl font-normal leading-relaxed drop-shadow-sm">
                        Hubungi kami melalui form di bawah ini.
                    </p>
                </div>

                <div class="md:col-span-6 lg:col-span-5 flex justify-center md:justify-end">
                    <div
                        class="w-full max-w-md rounded-3xl bg-white/12 backdrop-blur-md border border-white/25 p-6 sm:p-7 text-white shadow-2xl shadow-black/25 space-y-5">
                        <div class="flex items-center justify-between border-b border-white/20 pb-3.5">
                            <h2 data-i18n-key="kontak_card_title" class="text-sm sm:text-base font-extrabold uppercase tracking-wider text-white">
                                Saluran Resmi Rekrutmen
                            </h2>
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-300"></span>
                        </div>

                        <div class="space-y-4 text-xs sm:text-sm">
                            <div class="flex items-start gap-3.5">
                                <span class="w-9 h-9 rounded-xl bg-white/15 border border-white/20 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </span>
                                <div>
                                    <p class="font-semibold text-white/75 text-[11px] uppercase tracking-wider">Email</p>
                                    <a href="mailto:recruitment.hrd@sosro.com" class="block font-semibold text-white hover:underline mt-0.5">
                                        recruitment.hrd@sosro.com
                                    </a>
                                    <a href="mailto:recruitment.ho@sosro.com" class="block font-semibold text-white/90 hover:underline">
                                        recruitment.ho@sosro.com
                                    </a>
                                </div>
                            </div>

                            <div class="flex items-start gap-3.5">
                                <span class="w-9 h-9 rounded-xl bg-white/15 border border-white/20 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </span>
                                <div>
                                    <p class="font-semibold text-white/75 text-[11px] uppercase tracking-wider">Telepon</p>
                                    <p class="font-semibold text-white mt-0.5">(021) 4585 6268</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3.5">
                                <span class="w-9 h-9 rounded-xl bg-white/15 border border-white/20 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </span>
                                <div>
                                    <p data-i18n-key="kontak_hours_label" class="font-semibold text-white/75 text-[11px] uppercase tracking-wider">Jam Operasional</p>
                                    <p data-i18n-key="kontak_hours_value" class="font-semibold text-white mt-0.5">Senin - Jumat, 08:00 - 17:00 WIB</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3.5">
                                <span class="w-9 h-9 rounded-xl bg-white/15 border border-white/20 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </span>
                                <div>
                                    <p data-i18n-key="kontak_office_label" class="font-semibold text-white/75 text-[11px] uppercase tracking-wider">Kantor Pusat</p>
                                    <p class="font-medium text-white/95 leading-snug mt-0.5">
                                        Graha Rekso Lt. 8 - 10, Jl. Bulevard Artha Gading Kav. A1, Kelapa Gading, Jakarta Utara
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    @php
        $faqItems = [
            [
                'question' => 'Tahapan apa saja jika ingin melamar di PT Sinar Sosro Gunung Slamat?',
                'answer' => 'Tahapan umumnya: Pendaftaran Akun, Melengkapi Profil, Pemilihan Lowongan, Seleksi oleh HRD/User, hingga Penawaran Kerja.',
            ],
            [
                'question' => 'Dokumen apa saja yang harus dipersiapkan sebelum membuat akun?',
                'answer' => 'Siapkan CV terbaru, Ijazah Pendidikan Terakhir, Transkrip Nilai, dan KTP dalam format digital (misalnya PDF) untuk diunggah.',
            ],
            [
                'question' => 'Apakah saya bisa melamar lebih dari satu posisi?',
                'answer' => 'Ya, pada umumnya diperbolehkan, namun kami sangat menyarankan Anda fokus melamar pada posisi yang paling sesuai dengan kualifikasi dan minat Anda.',
            ],
            [
                'question' => 'Berapa jangka waktu dari masing-masing tahapan proses seleksi?',
                'answer' => 'Jangka waktu proses seleksi dapat memakan waktu 2 hingga 4 minggu sejak tanggal penutupan lamaran. Mohon menunggu informasi resmi dari HRD.',
            ],
            [
                'question' => 'Apakah saya bisa memperbarui profil dan CV saya?',
                'answer' => 'Ya, Anda dapat memperbarui data profil dan mengunggah CV terbaru di akun Anda. Perubahan akan berlaku untuk lamaran yang akan datang.',
            ],
            [
                'question' => 'Apa yang harus dilakukan jika lupa kata sandi?',
                'answer' => 'Gunakan fitur "Lupa Kata Sandi" di halaman masuk. Masukkan email terdaftar Anda, dan ikuti instruksi yang dikirimkan ke email Anda untuk membuat kata sandi baru.',
            ],
            [
                'question' => 'Mengapa saya gagal menyimpan data?',
                'answer' => 'Cek koneksi internet Anda. Pastikan format file dokumen sudah benar (misalnya PDF) dan ukurannya tidak melebihi batas maksimum yang ditetapkan.',
            ],
            [
                'question' => 'Setelah selesai melamar posisi yang dituju, apakah tahapan selanjutnya?',
                'answer' => 'Tahapan seleksi meliputi Seleksi Administrasi, Psikotes, Wawancara HRD, Wawancara User, dan Tes Kesehatan (MCU). Tahapan bisa bervariasi per posisi.',
            ],
            [
                'question' => 'Bagaimana melihat status proses untuk setiap posisi yang sudah saya lamar?',
                'answer' => 'Anda dapat melihat status terbaru melalui menu "Riwayat Lamaran" setelah Anda masuk ke akun pelamar.',
            ],
            [
                'question' => 'Apakah ada pungutan biaya dalam proses seleksi?',
                'answer' => 'Tidak. Seluruh proses rekrutmen PT Sinar Sosro Gunung Slamat bersifat GRATIS.',
            ],
        ];
    @endphp

    <section id="kirim-pesan" class="relative w-full bg-white py-16 sm:py-20 overflow-hidden">
        <div class="max-w-5xl mx-auto px-6 md:px-10">
            <h2 data-i18n-key="kontak_form_title" style="font-weight: 800;"
                class="font-display-title text-xl sm:text-2xl md:text-[1.75rem] font-extrabold text-slate-950 uppercase tracking-tight text-center mb-8 sm:mb-10">
                KIRIM PESAN
            </h2>

            <div
                class="max-w-xl mx-auto bg-white rounded-2xl border border-slate-100 shadow-[0_18px_50px_rgba(15,23,42,0.12)] p-6 sm:p-8">
                <form action="{{ route('guest.kontak.store') }}" method="POST" class="space-y-4 sm:space-y-5">
                    @csrf

                    <div>
                        <label for="contactName" class="sr-only">Nama Lengkap</label>
                        <input id="contactName" name="name" type="text"
                            value="{{ old('name', auth()->user()?->applicant?->name ?? auth()->user()?->admin?->name ?? '') }}"
                            required placeholder="Nama Lengkap"
                            class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-800 placeholder:text-slate-400 focus:border-[#B11116] focus:outline-none focus:ring-2 focus:ring-[#B11116]/20 transition">
                        @error('name')
                            <p class="mt-1.5 text-xs font-medium text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="contactEmail" class="sr-only">Email</label>
                        <input id="contactEmail" name="email" type="email"
                            value="{{ old('email', auth()->user()?->email ?? '') }}" required placeholder="Email"
                            class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-800 placeholder:text-slate-400 focus:border-[#B11116] focus:outline-none focus:ring-2 focus:ring-[#B11116]/20 transition">
                        @error('email')
                            <p class="mt-1.5 text-xs font-medium text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="contactRegion" class="sr-only">Tujuan Wilayah</label>
                        <div class="relative">
                            <select id="contactRegion" name="region" required
                                class="w-full appearance-none rounded-lg border border-slate-300 bg-white pl-4 pr-11 py-3 text-sm text-slate-800 focus:border-[#B11116] focus:outline-none focus:ring-2 focus:ring-[#B11116]/20 transition cursor-pointer">
                                <option value="" disabled {{ old('region') ? '' : 'selected' }}>Tujuan Wilayah</option>
                                @foreach ($regions as $region)
                                    <option value="{{ $region }}" {{ old('region') === $region ? 'selected' : '' }}>
                                        {{ $region }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="pointer-events-none absolute inset-y-0 right-3.5 flex items-center text-slate-500">
                                <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </div>
                        @error('region')
                            <p class="mt-1.5 text-xs font-medium text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="contactMessage" class="sr-only">Pesan</label>
                        <textarea id="contactMessage" name="message" rows="5" required
                            placeholder="Pesan"
                            class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-800 placeholder:text-slate-400 focus:border-[#B11116] focus:outline-none focus:ring-2 focus:ring-[#B11116]/20 transition resize-y">{{ old('message') }}</textarea>
                        @error('message')
                            <p class="mt-1.5 text-xs font-medium text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-2 text-center">
                        <button type="submit" data-i18n-key="kontak_submit_btn"
                            class="inline-flex items-center justify-center px-8 py-2.5 rounded-full bg-[#B11116] hover:bg-[#930d12] text-white font-bold text-sm shadow-md hover:shadow-lg transition-all duration-200 cursor-pointer active:scale-95">
                            Kirim Pesan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <section id="faq" class="relative w-full bg-white pt-4 pb-16 sm:pb-24 overflow-hidden">
        <div class="max-w-4xl mx-auto px-6 md:px-10">
            <h2 data-i18n-key="kontak_faq_title" style="font-weight: 800;"
                class="font-display-title text-xl sm:text-2xl md:text-[1.75rem] font-extrabold text-slate-950 uppercase tracking-tight mb-7 sm:mb-8">
                PERTANYAAN YANG SERING DIAJUKAN (FAQ)?
            </h2>

            <div class="space-y-3 sm:space-y-3.5" id="faqAccordion">
                @foreach ($faqItems as $idx => $faq)
                    <div class="faq-item rounded-xl overflow-hidden border border-red-200/80 shadow-xs transition-shadow duration-200 hover:shadow-md">
                        <button type="button"
                            class="faq-toggle w-full flex items-center justify-between gap-4 px-5 py-3.5 sm:px-6 sm:py-4 bg-gradient-to-r from-[#b81217] to-[#a10d12] hover:from-[#c41419] hover:to-[#ad0f15] text-white text-left font-semibold text-sm sm:text-base transition-colors cursor-pointer"
                            aria-expanded="false"
                            aria-controls="faq-answer-{{ $idx }}">
                            <span>{{ $faq['question'] }}</span>
                            <svg class="faq-chevron w-5 h-5 shrink-0 text-white transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div id="faq-answer-{{ $idx }}" class="faq-answer hidden bg-red-50/40 px-5 py-4 sm:px-6 text-slate-700 text-xs sm:text-sm leading-relaxed border-t border-red-100">
                            {{ $faq['answer'] }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggles = document.querySelectorAll('#faqAccordion .faq-toggle');
            toggles.forEach((toggle) => {
                toggle.addEventListener('click', () => {
                    const isExpanded = toggle.getAttribute('aria-expanded') === 'true';
                    const answerId = toggle.getAttribute('aria-controls');
                    const answer = document.getElementById(answerId);
                    const chevron = toggle.querySelector('.faq-chevron');

                    toggle.setAttribute('aria-expanded', isExpanded ? 'false' : 'true');
                    if (answer) {
                        answer.classList.toggle('hidden', isExpanded);
                    }
                    if (chevron) {
                        chevron.classList.toggle('rotate-180', !isExpanded);
                    }
                });
            });
        });
    </script>
@endsection
