<nav class="bg-[#B11116] px-10 py-3 flex justify-between items-center text-white">
    <a href="{{ route('guest.index') }}">
        <img src="{{ asset('assets/images/SGS Logo-Putih.webp') }}" alt="Logo Sinar Sosro Gunung Slamat" class="h-11">
    </a>

    <div class="flex items-center space-x-4">
        @if (auth()->check())
            @php
                $accountName = auth()->user()->admin?->name ?? auth()->user()->applicant?->name;
                $accountRole = auth()->user()->admin ? 'Admin' : (auth()->user()->applicant ? 'Pelamar' : 'Pengguna');
                $accountDisplayName = filled($accountName) ? $accountName : $accountRole;
            @endphp

            <div class="relative" data-account-menu-root>
                <button type="button" data-account-menu-toggle aria-haspopup="true" aria-expanded="false" aria-controls="account-menu"
                    class="flex items-center space-x-3 bg-black/20 hover:bg-black/30 backdrop-blur-md border border-white/10 p-1.5 pl-4 pr-1.5 rounded-full transition-all duration-300 focus:outline-none group shadow-sm hover:cursor-pointer">

                    <div class="text-right hidden sm:block">
                        <p class="text-[11px] font-bold text-white tracking-wide leading-none mb-1 drop-shadow-sm">
                            {{ $accountDisplayName }}
                        </p>
                        <p
                            class="text-[9px] font-medium text-gray-200/80 leading-none truncate max-w-[130px] drop-shadow-sm">
                            {{ $accountRole }}
                        </p>
                    </div>

                    <div
                        class="h-8 w-8 rounded-full bg-red-600 text-white flex items-center justify-center font-bold shadow-md border border-white/20 transition group-hover:scale-105 group-active:scale-95">
                        {{ substr($accountDisplayName, 0, 1) }}
                    </div>
                </button>

                <div id="account-menu" data-account-menu hidden
                    class="absolute right-0 mt-2 w-52 bg-white rounded-2xl shadow-2xl py-2 z-[70] border border-gray-100 overflow-hidden">

                    <div class="px-4 py-3 border-b border-gray-50 mb-1">
                        <p class="text-sm font-bold text-gray-900 truncate">{{ $accountDisplayName }}</p>
                        <p class="text-[10px] text-gray-500 truncate">{{ Auth::user()->email }}</p>
                    </div>

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

                    <hr class="my-1 border-gray-50">

                    <form method="POST" action="{{ route('auth.logout') }}">
                        @csrf
                        <button type="submit"
                            class="group flex items-center w-full px-4 py-2.5 text-sm font-bold text-red-600 hover:bg-red-50 transition text-left hover:cursor-pointer">
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
                <a href="{{ route('guest.register') }}"
                    class="px-6 py-2 bg-white text-red-700 font-bold rounded-full hover:bg-gray-100 transition shadow-md hover:shadow-lg transform active:scale-95">
                    Daftar
                </a>
            @else
                <a href="{{ route('guest.login') }}"
                    class="px-6 py-2 bg-white text-red-700 font-bold rounded-full hover:bg-gray-100 transition shadow-md hover:shadow-lg transform active:scale-95">
                    Masuk
                </a>
            @endif
        @endif
    </div>
</nav>

<script>
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
