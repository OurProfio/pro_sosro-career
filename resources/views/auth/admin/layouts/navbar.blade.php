@php
    $adminName = auth()->user()->admin?->name ?: 'Admin';
    $adminInitials = collect(explode(' ', trim($adminName)))
        ->filter()
        ->take(2)
        ->map(fn (string $namePart): string => strtoupper(substr($namePart, 0, 1)))
        ->implode('');
    $avatarColors = [
        ['background' => 'bg-rose-100', 'text' => 'text-rose-700'],
        ['background' => 'bg-amber-100', 'text' => 'text-amber-800'],
        ['background' => 'bg-emerald-100', 'text' => 'text-emerald-700'],
        ['background' => 'bg-sky-100', 'text' => 'text-sky-700'],
        ['background' => 'bg-violet-100', 'text' => 'text-violet-700'],
        ['background' => 'bg-fuchsia-100', 'text' => 'text-fuchsia-700'],
    ];
    $avatarColor = $avatarColors[crc32(strtolower($adminName)) % count($avatarColors)];
@endphp

<nav class="fixed top-0 z-50 w-full bg-neutral-primary-soft border-b border-default">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start rtl:justify-end">
                <button data-drawer-target="top-bar-sidebar" data-drawer-toggle="top-bar-sidebar"
                    aria-controls="top-bar-sidebar" type="button"
                    class="sm:hidden text-heading bg-transparent box-border border border-transparent hover:bg-neutral-secondary-medium focus:ring-4 focus:ring-neutral-tertiary font-medium leading-5 rounded-base text-sm p-2 focus:outline-none">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                            d="M5 7h14M5 12h14M5 17h10" />
                    </svg>
                </button>
                <a href="{{ route('admin.index') }}" class="flex ms-2 md:me-24">
                    <img src="{{ asset('assets/images/SGS Logo-Color.webp') }}" class="h-8 me-3" alt="FlowBite Logo" />
                </a>
            </div>
            <div class="flex items-center">
                <button data-tooltip-target="tooltip-email-limit" type="button"
                    class="inline-flex items-center gap-2 px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition-colors">
                    <i data-lucide="mail" class="w-3.5 h-3.5 text-slate-500"></i>
                    <span>Limit Email: 500/500</span>
                </button>

                <div id="tooltip-email-limit" role="tooltip"
                    class="absolute z-10 invisible inline-block px-3 py-2 text-xs font-medium text-white transition-opacity duration-300 bg-slate-800 rounded-xl shadow-xs opacity-0 tooltip">
                    Limit harian pengiriman email: <span class="font-bold text-emerald-400">500/500</span> terpakai
                    <div class="tooltip-arrow" data-popper-arrow></div>
                </div>
                <div class="flex items-center ms-3">
                    <div>
                        <button type="button"
                            class="hover:cursor-pointer flex text-sm bg-gray-800 rounded-full focus:ring-2 focus:ring-gray-300 dark:focus:ring-gray-600"
                            aria-expanded="false" data-dropdown-toggle="dropdown-user">
                            <span class="sr-only">Open user menu</span>
                            <span aria-hidden="true"
                                class="flex h-8 w-8 items-center justify-center rounded-full text-xs font-bold {{ $avatarColor['background'] }} {{ $avatarColor['text'] }}">
                                {{ $adminInitials ?: 'A' }}
                            </span>
                        </button>
                    </div>
                    <div class="z-50 hidden bg-neutral-primary-medium border border-default-medium rounded-base shadow-lg w-44"
                        id="dropdown-user">
                        <div class="px-4 py-3 border-b border-default-medium" role="none">
                            <p class="text-sm font-medium text-heading" role="none">
                                {{ $adminName }}
                            </p>
                            <p class="text-sm text-body truncate" role="none">
                                {{ auth()->user()->email }}
                            </p>
                        </div>
                        <ul class="p-2 text-sm text-body font-medium" role="none">
                            <li>
                                <form action="{{ route('auth.logout') }}" method="POST" class="w-full">
                                    @csrf
                                    <button type="submit"
                                        class="hover:cursor-pointer inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded text-left transition-colors"
                                        role="menuitem">
                                        Sign out
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
