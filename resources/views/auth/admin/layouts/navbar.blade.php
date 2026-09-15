<header
    class="fixed top-0 left-0 right-0 h-10 bg-slate-900 text-white px-3 flex items-center justify-between shrink-0 z-30 select-none">
    <div class="flex items-center gap-3">
        <button @click="sidebarOpen = !sidebarOpen"
            class="text-slate-400 hover:cursor-pointer hover:text-white transition-colors">
            <i data-lucide="menu" class="w-4 h-4"></i>
        </button>
        <div class="flex items-center gap-2">
            <span class="font-semibold text-xs tracking-wide text-slate-200">
                Dashboard Admin <span
                    class="text-[10px] bg-slate-800 text-blue-400 px-1 py-0.5 rounded border border-slate-700 font-mono">v1.0.0</span>
            </span>
        </div>
    </div>

    <div class="flex items-center gap-3 text-[11px]">

        <div x-data="{ profileOpen: false }" class="relative">
            <button @click="profileOpen = !profileOpen" @click.away="profileOpen = false"
                class="flex items-center gap-2 cursor-pointer hover:text-slate-200 transition-colors focus:outline-none">
                <i data-lucide="user-check" class="w-3.5 h-3.5 text-blue-400"></i>
                <span class="font-medium text-slate-300">
                    {{ auth()->user()->nama ?? 'Guest' }}
                    @if (auth()->user() && auth()->user()->admin)
                        <span class="text-slate-500 text-[10px]">
                            ({{ auth()->user()->admin->role == 'superadmin' ? 'Super Admin' : 'Admin' }})
                        </span>
                    @endif
                </span>
                <i data-lucide="chevron-down" class="w-3 h-3 text-slate-500"></i>
            </button>

            <div x-show="profileOpen" x-cloak x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95"
                class="absolute right-0 mt-1.5 w-48 bg-white text-slate-800 border border-slate-300 rounded shadow-lg overflow-hidden z-50 text-[11px]">
                <div class="p-2.5 bg-slate-50 border-b border-slate-200">
                    <p class="font-bold truncate text-slate-900">{{ auth()->user()->nama ?? 'Guest' }}</p>
                    <p class="text-[10px] text-slate-500 font-mono truncate">{{ auth()->user()->email ?? '-' }}</p>
                    @if (auth()->user() && auth()->user()->admin && auth()->user()->admin->cabang)
                        <div class="mt-1 flex items-center gap-1 text-[10px] text-blue-600 font-semibold">
                            <i data-lucide="building-2" class="w-3 h-3"></i>
                            <span class="truncate">{{ auth()->user()->admin->cabang->nama }}</span>
                        </div>
                    @endif
                </div>

                <div class="p-1">
                    <form action="{{ route('auth.logout') }}" method="POST" class="w-full">
                        @csrf
                        <button type="submit"
                            class="w-full px-2 py-1.5 text-left text-rose-600 hover:bg-rose-50 rounded font-semibold flex items-center gap-1.5 transition-colors cursor-pointer">
                            <i data-lucide="log-out" class="w-3.5 h-3.5"></i> Logout / Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
