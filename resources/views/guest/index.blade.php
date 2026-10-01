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
            <!-- COUNTER POSISI TERBUKA -->
            <div class="inline-flex items-center px-4 py-1.5 rounded-full bg-red-50 border-red-100 mb-4">
                <p class="text-red-700 font-semibold text-sm">Posisi terbuka:
                    <span id="jobCount" class="bg-red-600 text-white px-2 py-0.5 rounded-full mx-1">
                        {{ $jobs->count() }}
                    </span>
                </p>
            </div>

            <!-- SEARCH & FILTER STRIP -->
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
                        @foreach ($jobs->pluck('location')->unique() as $loc)
                            <option value="{{ $loc }}">{{ $loc }}</option>
                        @endforeach
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
                        @foreach ($jobs->pluck('category')->unique() as $cat)
                            <option value="{{ $cat }}">{{ $cat }}</option>
                        @endforeach
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
                        @foreach ($jobs->pluck('occupation')->unique() as $occ)
                            <option value="{{ $occ }}">{{ $occ }}</option>
                        @endforeach
                    </select>
                    <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-red-700">
                        <svg class="w-5 h-5 transition-transform duration-300 rotate-180" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- DYNAMIC JOB LIST AREA -->
            <div id="jobList" class="grid md:grid-cols-2 gap-6">
                @forelse ($jobs as $job)
                    <div
                        class="job-card rounded-2xl p-6 md:p-8 bg-white shadow-xl hover:shadow-md transition flex flex-col justify-between gap-4">
                        <div>
                            <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                                <div>
                                    <h3 class="text-2xl font-bold text-black mb-2">
                                        {{ $job->title }}
                                    </h3>

                                    <div class="flex items-center gap-2 text-green-600 font-medium text-sm">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 8v4l3 3M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>Batas Lamar:
                                            <u>{{ \Carbon\Carbon::parse($job->closing_date)->translatedFormat('d F Y') }}</u></span>
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
                                    <span>{{ $job->location }} ({{ $job->office->name ?? 'Cabang' }})</span>
                                </div>

                                <div class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="size-5 text-gray-500">
                                        <path d="M8.25 10.875a2.625 2.625 0 1 1 5.25 0 2.625 2.625 0 0 1-5.25 0Z" />
                                        <path fill-rule="evenodd"
                                            d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.125 4.5a4.125 4.125 0 1 0 2.338 7.524l2.007 2.006a.75.75 0 1 0 1.06-1.06l-2.006-2.007a4.125 4.125 0 0 0-3.399-6.463Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span>{{ $job->occupation }} &bull; <strong
                                            class="text-slate-800">{{ $job->type }}</strong></span>
                                </div>
                            </div>

                            <div class="space-y-3 mb-6">
                                <details class="group">
                                    <summary class="cursor-pointer font-semibold text-black hover:text-red-700 transition">
                                        Kualifikasi</summary>
                                    <div class="mt-2 text-gray-600 max-w-none text-sm leading-relaxed whitespace-pre-line">
                                        {{ $job->qualification }}
                                    </div>
                                </details>

                                <details class="group">
                                    <summary class="cursor-pointer font-semibold text-black hover:text-red-700 transition">
                                        Deskripsi Pekerjaan</summary>
                                    <div class="mt-2 text-gray-600 max-w-none text-sm leading-relaxed whitespace-pre-line">
                                        {{ $job->description }}
                                    </div>
                                </details>
                            </div>
                        </div>

                        <div class="flex justify-end pt-2 border-t border-gray-100">
                            @auth
                                @php
                                    $applicant = auth()->user()->applicant;
                                    $sudahMelamar = $applicant
                                        ? \App\Models\Application::where('applicant_id', $applicant->id)
                                            ->where('job_id', $job->id)
                                            ->exists()
                                        : false;
                                @endphp

                                @if ($sudahMelamar)
                                    <button disabled
                                        class="bg-emerald-600 text-white font-semibold px-6 py-2 rounded-full text-sm cursor-not-allowed flex items-center gap-1.5 shadow-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        Sudah Dilamar
                                    </button>
                                @else
                                    <form action="{{ route('applications.store') }}" method="POST" class="form-apply">
                                        @csrf
                                        <input type="hidden" name="job_id" value="{{ $job->id }}">
                                        <button type="button" onclick="konfirmasiLamar(this)"
                                            data-title="{{ $job->title }}"
                                            class="bg-[#B11116] hover:bg-red-800 text-white font-semibold px-8 py-2.5 rounded-full transition cursor-pointer inline-block active:scale-95">
                                            Lamar
                                        </button>
                                    </form>
                                @endif
                            @else
                                <a href="{{ route('guest.login') }}"
                                    class="bg-[#B11116] hover:bg-red-800 text-white font-semibold px-8 py-2.5 rounded-full transition cursor-pointer inline-block">
                                    Lamar
                                </a>
                            @endauth
                        </div>
                    </div>
                @empty
                    <div
                        class="col-span-1 md:col-span-2 text-center py-12 bg-slate-50 rounded-2xl border border-dashed border-slate-300">
                        <p class="text-slate-500 font-semibold text-base">Saat ini belum ada lowongan pekerjaan yang
                            dibuka.</p>
                    </div>
                @endforelse
            </div>

            <!-- PAGINATION LINK -->
            @if ($jobs instanceof \Illuminate\Pagination\LengthAwarePaginator && $jobs->hasPages())
                <div id="pagination" class="flex justify-center items-center gap-2 mt-10 font-semibold text-sm">
                    {{ $jobs->links() }}
                </div>
            @endif
        </div>
    </section>
    {{-- SWEETALERT2 MODAL KONFIRMASI --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function konfirmasiLamar(button) {
            const title = button.getAttribute('data-title');
            const form = button.closest('form');

            Swal.fire({
                title: 'Konfirmasi Lamaran Pekerjaan',
                html: `<div class="text-gray-500 text-sm">Apakah Anda yakin ingin mengirimkan lamaran untuk posisi:</div>
                   <div class="font-bold text-gray-900 mt-2 text-base">${title}</div>`,
                icon: 'question',
                iconColor: '#B11116',
                showCancelButton: true,
                confirmButtonText: 'Ya, Kirim Lamaran',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                buttonsStyling: false,
                customClass: {
                    popup: 'rounded-2xl border-none shadow-2xl p-6 font-sans',
                    confirmButton: 'bg-[#B11116] hover:bg-red-800 text-white font-bold px-6 py-2.5 rounded-full text-xs mx-1.5 transition-all cursor-pointer',
                    cancelButton: 'bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold px-6 py-2.5 rounded-full text-xs mx-1.5 transition-all cursor-pointer'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    button.disabled = true;
                    button.innerHTML = `
                    <span class="flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Mengirim...
                    </span>
                `;
                    form.submit();
                }
            });
        }
    </script>

    {{-- FLASH MESSAGE ALERT --}}
    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                timer: 3000,
                showConfirmButton: false,
                customClass: {
                    popup: 'rounded-2xl font-sans'
                }
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: "{{ session('error') }}",
                confirmButtonColor: '#B11116',
                customClass: {
                    popup: 'rounded-2xl font-sans'
                }
            });
        @endif
    </script>
@endsection
