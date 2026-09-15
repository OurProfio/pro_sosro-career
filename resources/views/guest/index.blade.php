@extends('guest.layouts.index')

@section('title', 'Selamat Datang')

@section('content')
    <section class="relative w-full overflow-hidden bg-black">
        <img src="{{ asset('assets/images/lowongan-hero.webp') }}" alt="Intip Keseruan Insan Sinar Sosro Gunung Slamat"
            class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-x-0 bottom-0 h-1/2 bg-gradient-to-t from-red-900 via-red/80 to-transparent"></div>
        <div class="flex items-center justify-center px-6 py-40 md:px-20 max-w-7xl mx-auto">
            <div class="w-full text-center md:text-left z-10">
                <h1
                    class="text-4xl md:text-5xl lg:text-[2.7rem] text-white font-bold uppercase leading-[1.1] md:max-w-[700px] drop-shadow-lg">
                    Bersama Kami, Menjadi Bagian Sinar Sosro Gunung Slamat
                </h1>
                <p class="text-lg md:text-xl text-white mt-6 md:mt-8 max-w-2xl">
                    Bergabunglah dengan tim kami, baik sebagai talenta muda maupun profesional berpengalaman. Pilih kategori
                    yang sesuai untuk mengembangkan potensi karirmu.
                </p>
                <a href="#lowongan"
                    class="max-md:mx-auto hover:cursor-pointer px-6 py-2 rounded-full bg-white text-red-700 font-bold block mt-5 w-max hover:bg-red-700 hover:text-white transition shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                    Lihat Lowongan
                </a>
            </div>
        </div>
    </section>

    <section class="py-20 bg-white" id="lowongan">
        <div class="max-w-6xl mx-auto px-6">
            <div class="inline-flex items-center px-4 py-1.5 rounded-full bg-red-50 border-red-100 mb-4">
                <p class="text-red-700 font-semibold text-sm">Posisi terbuka:
                    <span id="jobCount" class="bg-red-600 text-white px-2 py-0.5 rounded-full mx-1">
                        20
                    </span>
                </p>
            </div>

            <div class="flex flex-col lg:flex-row gap-4 justify-center items-center mb-10">
                <div class="relative flex items-center w-full lg:w-2/5 bg-white rounded-full shadow-md overflow-hidden">
                    <div class="pl-5 text-red-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" placeholder="Cari lowongan..."
                        class="w-full px-4 py-3.5 border-none focus:ring-0 focus:outline-none text-red-800 bg-transparent font-semibold" />
                    <button
                        class="bg-[#B11116] text-white px-8 py-2.5 rounded-full font-bold mr-1.5 hover:bg-red-800 transition shadow-md">
                        Cari
                    </button>
                </div>

                <div class="relative w-full lg:w-1/5 font-semibold group">
                    <select id="filterLocation"
                        class="appearance-none w-full bg-white border-none rounded-full px-6 py-4 shadow-md text-red-700 focus:outline-none focus:ring-2 focus:ring-red-700/20 cursor-pointer pr-12">
                        <option value="">Semua Lokasi</option>
                    </select>
                    <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-red-700">
                        <svg class="w-5 h-5 transition-transform duration-300 rotate-180" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>

                <div class="relative w-full lg:w-1/5 font-semibold">
                    <select id="filterCategory"
                        class="appearance-none w-full bg-white border-none rounded-full px-6 py-4 shadow-md text-red-700 focus:outline-none focus:ring-2 focus:ring-red-700/20 cursor-pointer pr-12">
                        <option value="">Semua Kategori</option>
                    </select>
                    <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-red-700">
                        <svg class="w-5 h-5 transition-transform duration-300 rotate-180" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>

                <div class="relative w-full lg:w-1/5 font-semibold">
                    <select id="filterBidang"
                        class="appearance-none w-full bg-white border-none rounded-full px-6 py-4 shadow-md text-red-700 focus:outline-none focus:ring-2 focus:ring-red-700/20 cursor-pointer pr-12">
                        <option value="">Semua Bidang</option>
                    </select>
                    <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-red-700">
                        <svg class="w-5 h-5 transition-transform duration-300 rotate-180" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
            </div>

            <div id="jobList" class="grid md:grid-cols-2 gap-6">
                <div
                    class="job-card rounded-2xl p-6 md:p-8 bg-white shadow-xl hover:shadow-md transition flex flex-col justify-between gap-4">
                    <div>
                        <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                            <div>
                                <h3 class="text-2xl font-bold text-black mb-2">
                                    Software Engineer (Backend)
                                </h3>

                                <div class="flex items-center gap-2 text-green-600 font-medium text-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 8v4l3 3M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Batas Lamar: <u>30 September 2026</u></span>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col gap-2 text-gray-600 mt-4 mb-5 text-sm">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="size-5 text-gray-500">
                                    <path fill-rule="evenodd"
                                        d="m11.54 22.351.07.04.028.016a.76.76 0 0 0 .723 0l.028-.015.071-.041a16.975 16.975 0 0 0 1.144-.742 19.58 19.58 0 0 0 2.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 0 0-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 0 0 2.682 2.282 16.975 16.975 0 0 0 1.145.742ZM12 13.5a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>Jakarta Barat (Head Office)</span>
                            </div>

                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="size-5 text-gray-500">
                                    <path d="M8.25 10.875a2.625 2.625 0 1 1 5.25 0 2.625 2.625 0 0 1-5.25 0Z" />
                                    <path fill-rule="evenodd"
                                        d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.125 4.5a4.125 4.125 0 1 0 2.338 7.524l2.007 2.006a.75.75 0 1 0 1.06-1.06l-2.006-2.007a4.125 4.125 0 0 0-3.399-6.463Z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>Information Technology</span>
                            </div>
                        </div>

                        <div class="space-y-3 mb-6">
                            <details class="group">
                                <summary class="cursor-pointer font-semibold text-black hover:text-red-700 transition">
                                    Kualifikasi</summary>
                                <div class="mt-2 text-gray-600 prose prose-sm max-w-none">
                                    <ul class="list-disc pl-4 space-y-1 text-sm">
                                        <li>Pendidikan min. S1 Teknik Informatika / Sistem Informasi</li>
                                        <li>Pengalaman min. 2 tahun menguasai Framework Laravel & PHP</li>
                                        <li>Memahami konsep RESTful API dan arsitektur database MySQL</li>
                                        <li>Dapat bekerja secara tim maupun mandiri</li>
                                    </ul>
                                </div>
                            </details>

                            <details class="group">
                                <summary class="cursor-pointer font-semibold text-black hover:text-red-700 transition">
                                    Deskripsi Pekerjaan</summary>
                                <div class="mt-2 text-gray-600 max-w-none">
                                    <ul class="list-disc pl-4 space-y-1 text-sm">
                                        <li>Merancang dan mengembangkan API backend sistem ERP internal</li>
                                        <li>Melakukan optimasi kueri database dan performa aplikasi</li>
                                        <li>Melakukan integrasi dengan layanan pihak ketiga</li>
                                    </ul>
                                </div>
                            </details>
                        </div>
                    </div>

                    <div class="flex justify-end pt-2 border-t border-gray-100">
                        <button type="button"
                            class="bg-[#B11116] hover:bg-red-800 text-white font-semibold px-8 py-2.5 rounded-full transition cursor-pointer">
                            Lamar
                        </button>
                    </div>
                </div>

                <div
                    class="job-card rounded-2xl p-6 md:p-8 bg-white shadow-xl hover:shadow-md transition flex flex-col justify-between gap-4">
                    <div>
                        <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                            <div>
                                <h3 class="text-2xl font-bold text-black mb-2">
                                    Human Capital Generalist
                                </h3>

                                <div class="flex items-center gap-2 text-green-600 font-medium text-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 8v4l3 3M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Batas Lamar: <u>15 Oktober 2026</u></span>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col gap-2 text-gray-600 mt-4 mb-5 text-sm">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="size-5 text-gray-500">
                                    <path fill-rule="evenodd"
                                        d="m11.54 22.351.07.04.028.016a.76.76 0 0 0 .723 0l.028-.015.071-.041a16.975 16.975 0 0 0 1.144-.742 19.58 19.58 0 0 0 2.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 0 0-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 0 0 2.682 2.282 16.975 16.975 0 0 0 1.145.742ZM12 13.5a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>Cikarang Hub</span>
                            </div>

                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="size-5 text-gray-500">
                                    <path d="M8.25 10.875a2.625 2.625 0 1 1 5.25 0 2.625 2.625 0 0 1-5.25 0Z" />
                                    <path fill-rule="evenodd"
                                        d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.125 4.5a4.125 4.125 0 1 0 2.338 7.524l2.007 2.006a.75.75 0 1 0 1.06-1.06l-2.006-2.007a4.125 4.125 0 0 0-3.399-6.463Z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>Human Capital</span>
                            </div>
                        </div>

                        <div class="space-y-3 mb-6">
                            <details class="group">
                                <summary class="cursor-pointer font-semibold text-black hover:text-red-700 transition">
                                    Kualifikasi</summary>
                                <div class="mt-2 text-gray-600 prose prose-sm max-w-none">
                                    <ul class="list-disc pl-4 space-y-1 text-sm">
                                        <li>S1 Psikologi / Hukum / Manajemen SDM</li>
                                        <li>Pengalaman min. 1 tahun di bidang Rekrutmen atau Hubungan Industrial</li>
                                        <li>Komunikatif, terbiasa dengan target fulfillment karyawan</li>
                                    </ul>
                                </div>
                            </details>

                            <details class="group">
                                <summary class="cursor-pointer font-semibold text-black hover:text-red-700 transition">
                                    Deskripsi Pekerjaan</summary>
                                <div class="mt-2 text-gray-600 max-w-none">
                                    <ul class="list-disc pl-4 space-y-1 text-sm">
                                        <li>Mengelola end-to-end proses rekrutmen karyawan cabang</li>
                                        <li>Mengurus administrasi keikutsertaan BPJS Ketenagakerjaan</li>
                                    </ul>
                                </div>
                            </details>
                        </div>
                    </div>

                    <div class="flex justify-end pt-2 border-t border-gray-100">
                        <button type="button"
                            class="bg-[#B11116] hover:bg-red-800 text-white font-semibold px-8 py-2.5 rounded-full transition cursor-pointer">
                            Lamar
                        </button>
                    </div>
                </div>

            </div>

            <div id="pagination" class="flex justify-center items-center gap-2 mt-10 font-semibold text-sm">
                <button type="button"
                    class="px-3 py-1.5 rounded-lg border border-gray-300 text-gray-500 hover:bg-gray-100 transition cursor-pointer"
                    disabled>&lt;</button>
                <button type="button"
                    class="px-3 py-1.5 rounded-lg bg-[#B11116] text-white shadow-sm cursor-pointer">1</button>
                <button type="button"
                    class="px-3 py-1.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100 transition cursor-pointer">2</button>
                <button type="button"
                    class="px-3 py-1.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100 transition cursor-pointer">&gt;</button>
            </div>
        </div>
    </section>
@endsection
