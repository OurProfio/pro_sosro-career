<aside class="w-56 bg-white h-screen mt-10 text-gray-300 flex flex-col">
    <a href="{{ route('admin.dashboard') }}"
        class="transition-colors {{ request()->is('admin/dashboard') ? 'bg-blue-600 text-white' : 'text-black hover:bg-slate-700 hover:text-white' }}">
        <span class="truncate text-[11px]">Dashboard</span>
    </a>

    <a href="{{ route('office.index') }}"
        class="transition-colors {{ request()->is('office*') ? 'bg-blue-600 text-white' : 'text-black hover:bg-slate-700 hover:text-white' }}">
        <span class="truncate text-[11px]">Kantor Cabang</span>
    </a>

    <a href="{{ route('division.index') }}"
        class="transition-colors {{ request()->is('division*') ? 'bg-blue-600 text-white' : 'text-black hover:bg-slate-700 hover:text-white' }}">
        <span class="truncate text-[11px]">Divisi Lowongan</span>
    </a>

    <a href="{{ route('job.index') }}"
        class="transition-colors {{ request()->is('job*') && !request()->is('job/dashboard') ? 'bg-blue-600 text-white' : 'text-black hover:bg-slate-700 hover:text-white' }}">
        <span class="truncate text-[11px]">Lowongan</span>
    </a>

    <a href="{{ route('admin.index') }}"
        class="transition-colors {{ request()->is('admin*') && !request()->is('admin/dashboard') ? 'bg-blue-600 text-white' : 'text-black hover:bg-slate-700 hover:text-white' }}">
        <span class="truncate text-[11px]">Admin</span>
    </a>

    <a href="{{ route('user.index') }}"
        class="transition-colors {{ request()->is('user*') ? 'bg-blue-600 text-white' : 'text-black hover:bg-slate-700 hover:text-white' }}">
        <span class="truncate text-[11px]">User</span>
    </a>
</aside>
