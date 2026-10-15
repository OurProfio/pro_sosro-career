 <aside id="top-bar-sidebar"
     class="fixed top-0 left-0 z-40 w-64 h-full transition-transform -translate-x-full sm:translate-x-0"
     aria-label="Sidebar">
     <div class="h-full px-3 py-4 overflow-y-auto bg-neutral-primary-soft border-e border-default">
         <a href="{{ route('admin.dashboard') }}" class="flex items-center ps-2.5 mb-5">
             <img src="{{ asset('assets/images/SGS Logo-Color.webp') }}" class="h-8 me-3" />
             <span class="self-center text-lg text-heading font-semibold whitespace-nowrap">Flowbite</span>
         </a>
         <ul class="space-y-2 font-medium">
             @php
                 $isDashboardActive = request()->routeIs('admin.dashboard');
             @endphp
             <li>
                 <a href="{{ route('admin.dashboard') }}"
                     class="flex items-center px-3 py-2 font-semibold rounded-xl transition-all group {{ $isDashboardActive ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                     <svg class="shrink-0 w-4 h-4 transition duration-75 {{ $isDashboardActive ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}"
                         aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                         fill="none" viewBox="0 0 24 24">
                         <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                             d="M10 6.025A7.5 7.5 0 1 0 17.975 14H10V6.025Z" />
                         <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                             d="M13.5 3c-.169 0-.334.014-.5.025V11h7.975c.011-.166.025-.331.025-.5A7.5 7.5 0 0 0 13.5 3Z" />
                     </svg>

                     <span class="flex-1 ms-3 whitespace-nowrap">Dashboard</span>

                     @if ($isDashboardActive)
                         <span class="w-1.5 h-1.5 rounded-full bg-blue-600"></span>
                     @endif
                 </a>
             </li>

             @php
                 $isOfficeActive = request()->routeIs('office.*') || request()->routeIs('admin.office.*');
             @endphp
             <li>
                 <a href="{{ route('office.index') }}"
                     class="flex items-center px-3 py-2 font-semibold rounded-xl transition-all group {{ $isOfficeActive ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                     <i data-lucide="building-2"
                         class="w-4 h-4 shrink-0 transition duration-75 {{ $isOfficeActive ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}"></i>

                     <span class="flex-1 ms-3 whitespace-nowrap">Kantor</span>

                     @if ($isOfficeActive)
                         <span class="w-1.5 h-1.5 rounded-full bg-blue-600"></span>
                     @endif
                 </a>
             </li>

             @php
                 $isAdminActive = request()->routeIs('admin.index', 'admin.create', 'admin.edit', 'admin.show');
             @endphp
             <li>
                 <a href="{{ route('admin.index') }}"
                     class="flex items-center px-3 py-2 font-semibold rounded-xl transition-all group {{ $isAdminActive ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                     <i data-lucide="shield-user"
                         class="w-4 h-4 shrink-0 transition duration-75 {{ $isAdminActive ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}">
                     </i>

                     <span class="flex-1 ms-3 whitespace-nowrap">
                         Admin
                     </span>

                     @if ($isAdminActive)
                         <span class="w-1.5 h-1.5 rounded-full bg-blue-600"></span>
                     @endif

                 </a>
             </li>

             @php
                 $isApplicantAccountActive = request()->routeIs('applicant.*');
             @endphp
             <li>
                 <a href="{{ route('applicant.index') }}"
                     class="flex items-center px-3 py-2 font-semibold rounded-xl transition-all group {{ $isApplicantAccountActive ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                     <i data-lucide="user-check"
                         class="w-4 h-4 shrink-0 transition duration-75 {{ $isApplicantAccountActive ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}">
                     </i>

                     <span class="flex-1 ms-3 whitespace-nowrap">
                         Applicant
                     </span>

                     @if ($isApplicantAccountActive)
                         <span class="w-1.5 h-1.5 rounded-full bg-blue-600"></span>
                     @endif
                 </a>
             </li>

             @php
                 $isUserActive = request()->routeIs('user.*');
             @endphp
             <li>
                 <a href="{{ route('user.index') }}"
                     class="flex items-center px-3 py-2 font-semibold rounded-xl transition-all group {{ $isUserActive ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                     <i data-lucide="user-cog"
                         class="w-4 h-4 shrink-0 transition duration-75 {{ $isUserActive ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}">
                     </i>

                     <span class="flex-1 ms-3 whitespace-nowrap">
                         Users
                     </span>

                     @if ($isUserActive)
                         <span class="w-1.5 h-1.5 rounded-full bg-blue-600"></span>
                     @endif
                 </a>
             </li>

             @php
                 $isDivisionActive = request()->routeIs('division.*');
             @endphp
             <li>
                 <a href="{{ route('division.index') }}"
                     class="flex items-center px-3 py-2 font-semibold rounded-xl transition-all group {{ $isDivisionActive ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                     <i data-lucide="layers"
                         class="w-4 h-4 shrink-0 transition duration-75 {{ $isDivisionActive ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}">
                     </i>

                     <span class="flex-1 ms-3 whitespace-nowrap">
                         Divisi
                     </span>

                     @if ($isDivisionActive)
                         <span class="w-1.5 h-1.5 rounded-full bg-blue-600"></span>
                     @endif
                 </a>
             </li>

             @php
                 $isJobActive = request()->routeIs('job.*') || request()->routeIs('admin.job.*');
             @endphp
             <li>
                 <a href="{{ route('job.index') }}"
                     class="flex items-center px-3 py-2 font-semibold rounded-xl transition-all group {{ $isJobActive ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">

                     <i data-lucide="briefcase-business"
                         class="w-4 h-4 shrink-0 transition duration-75 {{ $isJobActive ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}"></i>

                     <span class="flex-1 ms-3 whitespace-nowrap">
                         Lowongan
                     </span>

                     @if ($isJobActive)
                         <span class="w-1.5 h-1.5 rounded-full bg-blue-600"></span>
                     @endif

                 </a>
             </li>
         </ul>
     </div>
 </aside>
