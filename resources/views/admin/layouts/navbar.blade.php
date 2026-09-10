<header class="fixed top-0 left-0 right-0 h-10 bg-slate-900 text-white px-3 flex items-center justify-between shrink-0 z-30 select-none">
    <div class="flex items-center gap-3">
        <button @click="sidebarOpen = !sidebarOpen" class="text-slate-400 hover:cursor-pointer hover:text-white transition-colors">
            <i data-lucide="menu" class="w-4 h-4"></i>
        </button>
        <div class="flex items-center gap-2">
            <span class="font-semibold text-xs tracking-wide text-slate-200">
                Dashboard Admin<span class="text-[10px] bg-slate-800 text-blue-400 px-1 py-0.5 rounded border border-slate-700 font-mono">v1.0.0</span>
            </span>
        </div>
    </div>

    <div class="flex items-center gap-4 text-[11px]">
       
        <div class="flex items-center gap-2 cursor-pointer hover:text-slate-200">
            <i data-lucide="user-check" class="w-3.5 h-3.5 text-blue-400"></i>
            {{-- <span class="font-medium text-slate-300">{{ auth()->user()->name ?? $user->admin->role }} {{ $user->admin->role == 'admin' ? 'Admin' : 'Super Admin' }}</span> --}}
            <i data-lucide="chevron-down" class="w-3 h-3 text-slate-500"></i>
        </div>
    </div>
</header>
