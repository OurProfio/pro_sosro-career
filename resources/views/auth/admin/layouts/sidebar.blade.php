<aside :class="!sidebarOpen ? 'w-48' : 'w-11'"
    class="fixed top-10 left-0 h-[calc(100vh-2.5rem)] bg-slate-800 border-r border-slate-700 flex flex-col justify-between transition-all duration-200 shrink-0 z-20 select-none">

    <nav class="p-1 space-y-0.5 overflow-y-auto">
        <a href="{{ route('admin.dashboard') }}"
            class="flex items-center gap-2.5 px-2 py-1.5 rounded font-medium transition-colors {{ request()->is('admin/dashboard') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
            <i data-lucide="layout-grid"
                class="w-4 h-4 shrink-0 {{ request()->is('admin/dashboard') ? 'text-white' : 'text-slate-400' }}"></i>
            <span x-show="!sidebarOpen" class="truncate text-[11px] font-medium">Dashboard</span>
        </a>

        <a href="{{ route('office.index') }}"
            class="flex items-center gap-2.5 px-2 py-1.5 rounded font-medium transition-colors {{ request()->is('office*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
            <i data-lucide="factory"
                class="w-4 h-4 shrink-0 {{ request()->is('office*') ? 'text-white' : 'text-slate-400' }}"></i>
            <span x-show="!sidebarOpen" class="truncate text-[11px]">Kantor Cabang</span>
        </a>

        <a href="{{ route('division.index') }}"
            class="flex items-center gap-2.5 px-2 py-1.5 rounded font-medium transition-colors {{ request()->is('division*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
            <i data-lucide="briefcase"
                class="w-4 h-4 shrink-0 {{ request()->is('division*') ? 'text-white' : 'text-slate-400' }}"></i>
            <span x-show="!sidebarOpen" class="truncate text-[11px]">Divisi Lowongan</span>
        </a>

        <a href="{{ route('job.index') }}"
            class="flex items-center gap-2.5 px-2 py-1.5 rounded font-medium transition-colors {{ request()->is('job*') && !request()->is('job/dashboard') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
            <i data-lucide="user-star"
                class="w-4 h-4 shrink-0 {{ request()->is('job*') && !request()->is('job/dashboard') ? 'text-white' : 'text-slate-400' }}"></i>
            <span x-show="!sidebarOpen" class="truncate text-[11px]">Lowongan</span>
        </a>

        <a href="{{ route('admin.index') }}"
            class="flex items-center gap-2.5 px-2 py-1.5 rounded font-medium transition-colors {{ request()->is('admin*') && !request()->is('admin/dashboard') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
            <i data-lucide="user-star"
                class="w-4 h-4 shrink-0 {{ request()->is('admin*') && !request()->is('admin/dashboard') ? 'text-white' : 'text-slate-400' }}"></i>
            <span x-show="!sidebarOpen" class="truncate text-[11px]">Admin</span>
        </a>

        <a href="{{ route('user.index') }}"
            class="flex items-center gap-2.5 px-2 py-1.5 rounded font-medium transition-colors {{ request()->is('user*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
            <i data-lucide="users"
                class="w-4 h-4 shrink-0 {{ request()->is('user*') ? 'text-white' : 'text-slate-400' }}"></i>
            <span x-show="!sidebarOpen" class="truncate text-[11px]">User</span>
        </a>
    </nav>
</aside>
