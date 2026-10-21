 <aside id="top-bar-sidebar"
     class="fixed top-0 left-0 z-40 w-64 h-full bg-white border-r border-slate-200/80 transition-transform -translate-x-full sm:translate-x-0"
     aria-label="Sidebar">
     <div class="h-full overflow-y-auto pt-16">
         @php
             $admin = auth()->user()->admin;
             $isSuperAdmin = $admin?->role === 'superadmin';
         @endphp

         <!-- Navigation Links -->
         <nav class="p-3 space-y-1" data-purpose="sidebar-menu">
             <!-- Dashboard (Dapat diakses Superadmin & Admin) -->
             @php
                 $isDashboardActive = request()->routeIs('admin.dashboard');
             @endphp
             <a class="flex items-center justify-between px-3.5 py-2.5 rounded-lg text-sm font-medium transition-colors group {{ $isDashboardActive ? 'bg-red-50 text-[#A6192E] font-semibold border border-red-100/70 shadow-sm' : 'text-slate-600 hover:text-red-800 hover:bg-slate-50' }}"
                 href="{{ route('admin.dashboard') }}">
                 <div class="flex items-center gap-3">
                     <svg class="w-5 h-5 {{ $isDashboardActive ? 'text-[#A6192E]' : 'text-slate-400 group-hover:text-red-700' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                         <path d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" stroke-linecap="round" stroke-linejoin="round"></path>
                     </svg>
                     <span>Dashboard</span>
                 </div>
                 @if ($isDashboardActive)
                     <span class="w-1.5 h-4 bg-[#A6192E] rounded-full"></span>
                 @endif
             </a>

             <!-- Lowongan (Dapat diakses Superadmin & Admin) -->
             @php
                 $isJobActive = request()->routeIs('job.*') || request()->routeIs('admin.job.*');
             @endphp
             <a class="flex items-center justify-between px-3.5 py-2.5 rounded-lg text-sm font-semibold transition-colors group {{ $isJobActive ? 'bg-red-50 text-[#A6192E] border border-red-100/70 shadow-sm' : 'text-slate-600 hover:text-red-800 hover:bg-slate-50' }}"
                 href="{{ route('job.index') }}">
                 <div class="flex items-center gap-3">
                     <svg class="w-5 h-5 {{ $isJobActive ? 'text-[#A6192E]' : 'text-slate-400 group-hover:text-red-700' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                         <path d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round"></path>
                     </svg>
                     <span>Lowongan</span>
                 </div>
                 @if ($isJobActive)
                     <span class="w-1.5 h-4 bg-[#A6192E] rounded-full"></span>
                 @endif
             </a>

             <!-- Pelamar / Applicant (Dapat diakses Superadmin & Admin) -->
             @php
                 $isApplicantAccountActive = request()->routeIs('applicant.*');
             @endphp
             <a class="flex items-center justify-between px-3.5 py-2.5 rounded-lg text-sm font-medium transition-colors group {{ $isApplicantAccountActive ? 'bg-red-50 text-[#A6192E] font-semibold border border-red-100/70 shadow-sm' : 'text-slate-600 hover:text-red-800 hover:bg-slate-50' }}"
                 href="{{ route('applicant.index') }}">
                 <div class="flex items-center gap-3">
                     <svg class="w-5 h-5 {{ $isApplicantAccountActive ? 'text-[#A6192E]' : 'text-slate-400 group-hover:text-red-700' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                         <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round"></path>
                     </svg>
                     <span>Pelamar</span>
                 </div>
                 @if ($isApplicantAccountActive)
                     <span class="w-1.5 h-4 bg-[#A6192E] rounded-full"></span>
                 @endif
             </a>

             {{-- Menu Khusus Superadmin --}}
             @if ($isSuperAdmin)
                 <div class="pt-3 pb-1 px-3">
                     <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Superadmin Area</p>
                 </div>

                 <!-- Kantor -->
                 @php
                     $isOfficeActive = request()->routeIs('office.*') || request()->routeIs('admin.office.*');
                 @endphp
                 <a class="flex items-center justify-between px-3.5 py-2.5 rounded-lg text-sm font-medium transition-colors group {{ $isOfficeActive ? 'bg-red-50 text-[#A6192E] font-semibold border border-red-100/70 shadow-sm' : 'text-slate-600 hover:text-red-800 hover:bg-slate-50' }}"
                     href="{{ route('office.index') }}">
                     <div class="flex items-center gap-3">
                         <svg class="w-5 h-5 {{ $isOfficeActive ? 'text-[#A6192E]' : 'text-slate-400 group-hover:text-red-700' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                         </svg>
                         <span>Kantor</span>
                     </div>
                     @if ($isOfficeActive)
                         <span class="w-1.5 h-4 bg-[#A6192E] rounded-full"></span>
                     @endif
                 </a>

                 <!-- Divisi -->
                 @php
                     $isDivisionActive = request()->routeIs('division.*');
                 @endphp
                 <a class="flex items-center justify-between px-3.5 py-2.5 rounded-lg text-sm font-medium transition-colors group {{ $isDivisionActive ? 'bg-red-50 text-[#A6192E] font-semibold border border-red-100/70 shadow-sm' : 'text-slate-600 hover:text-red-800 hover:bg-slate-50' }}"
                     href="{{ route('division.index') }}">
                     <div class="flex items-center gap-3">
                         <svg class="w-5 h-5 {{ $isDivisionActive ? 'text-[#A6192E]' : 'text-slate-400 group-hover:text-red-700' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                         </svg>
                         <span>Divisi</span>
                     </div>
                     @if ($isDivisionActive)
                         <span class="w-1.5 h-4 bg-[#A6192E] rounded-full"></span>
                     @endif
                 </a>

                 <!-- Admin -->
                 @php
                     $isAdminActive = request()->routeIs('admin.index', 'admin.create', 'admin.edit', 'admin.show');
                 @endphp
                 <a class="flex items-center justify-between px-3.5 py-2.5 rounded-lg text-sm font-medium transition-colors group {{ $isAdminActive ? 'bg-red-50 text-[#A6192E] font-semibold border border-red-100/70 shadow-sm' : 'text-slate-600 hover:text-red-800 hover:bg-slate-50' }}"
                     href="{{ route('admin.index') }}">
                     <div class="flex items-center gap-3">
                         <svg class="w-5 h-5 {{ $isAdminActive ? 'text-[#A6192E]' : 'text-slate-400 group-hover:text-red-700' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                         </svg>
                         <span>Admin</span>
                     </div>
                     @if ($isAdminActive)
                         <span class="w-1.5 h-4 bg-[#A6192E] rounded-full"></span>
                     @endif
                 </a>

                 <!-- Pengguna (Users) -->
                 @php
                     $isUserActive = request()->routeIs('user.*');
                 @endphp
                 <a class="flex items-center justify-between px-3.5 py-2.5 rounded-lg text-sm font-medium transition-colors group {{ $isUserActive ? 'bg-red-50 text-[#A6192E] font-semibold border border-red-100/70 shadow-sm' : 'text-slate-600 hover:text-red-800 hover:bg-slate-50' }}"
                     href="{{ route('user.index') }}">
                     <div class="flex items-center gap-3">
                         <svg class="w-5 h-5 {{ $isUserActive ? 'text-[#A6192E]' : 'text-slate-400 group-hover:text-red-700' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                             <path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" stroke-linecap="round" stroke-linejoin="round"></path>
                         </svg>
                         <span>Pengguna</span>
                     </div>
                     @if ($isUserActive)
                         <span class="w-1.5 h-4 bg-[#A6192E] rounded-full"></span>
                     @endif
                 </a>
             @endif
         </nav>
     </div>
 </aside>
