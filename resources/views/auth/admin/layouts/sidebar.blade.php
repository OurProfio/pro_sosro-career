<aside :class="!sidebarOpen ? 'w-48' : 'w-11'"
    class="fixed top-10 left-0 h-[calc(100vh-2.5rem)] bg-slate-800 border-r border-slate-700 flex flex-col justify-between transition-all duration-200 shrink-0 z-20 select-none">

    <nav class="p-1 space-y-0.5 overflow-y-auto">
        <a href="#"
            class="flex items-center gap-2.5 px-2 py-1.5 rounded text-slate-300 hover:bg-slate-700 hover:text-white transition-colors">
            <i data-lucide="layout-grid" class="w-4 h-4 text-slate-400 shrink-0"></i>
            <span x-show="!sidebarOpen" class="truncate text-[11px] font-medium">Dashboard</span>
        </a>

        <a href="{{ route('admin.index') }}"
            class="flex items-center gap-2.5 px-2 py-1.5 rounded font-medium transition-colors {{ request()->is('admin*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
            <i data-lucide="user-star"
                class="w-4 h-4 shrink-0 {{ request()->is('admin*') ? 'text-white' : 'text-slate-400' }}"></i>
            <span x-show="!sidebarOpen" class="truncate text-[11px]">Admin</span>
        </a>

        <a href="{{ route('cabang.index') }}"
            class="flex items-center gap-2.5 px-2 py-1.5 rounded font-medium transition-colors {{ request()->is('cabang*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
            <i data-lucide="factory"
                class="w-4 h-4 shrink-0 {{ request()->is('cabang*') ? 'text-white' : 'text-slate-400' }}"></i>
            <span x-show="!sidebarOpen" class="truncate text-[11px]">Cabang</span>
        </a>

        <a href="{{ route('divisi.index') }}"
            class="flex items-center gap-2.5 px-2 py-1.5 rounded font-medium transition-colors {{ request()->is('divisi*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
            <i data-lucide="briefcase"
                class="w-4 h-4 shrink-0 {{ request()->is('divisi*') ? 'text-white' : 'text-slate-400' }}"></i>
            <span x-show="!sidebarOpen" class="truncate text-[11px]">Divisi Lowongan</span>
        </a>
    </nav>

    <div x-show="!sidebarOpen" class="p-2 border-t border-slate-700 text-[10px] text-slate-400 font-mono">
        <p class="truncate font-semibold">NEXUS ERP v4.12</p>
        <p class="text-slate-500 truncate">Core System</p>
    </div>
</aside>
