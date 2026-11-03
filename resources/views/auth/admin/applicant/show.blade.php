@extends('auth.admin.layouts.index')

@section('title', 'Detail Profil Kandidat - ' . ($applicant->name ?? 'Pelamar'))

@section('content')
    <div class="applicant-show-page flex flex-col w-full pb-8">
        <!-- TOP CONTEXTUAL BAR (UNIFIED HCI PATTERN) -->
        <section class="no-print flex flex-col md:flex-row md:items-center justify-between gap-4 pb-3.5 border-b border-slate-200">
            <div class="flex items-center gap-3.5">
                <a class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-white border border-slate-200 shadow-2xs text-slate-600 hover:text-[#9b1b1f] hover:bg-slate-100 transition shrink-0"
                    href="{{ route('applicant.index') }}" title="Kembali ke Database Pelamar">
                    <span class="material-symbols-outlined text-[20px]">arrow_back</span>
                </a>
                <div class="space-y-0.5">
                    <nav class="flex items-center gap-1.5 text-xs text-slate-400 font-medium">
                        <a class="hover:text-[#9b1b1f] transition" href="{{ route('admin.dashboard') }}">Portal Karir</a>
                        <span class="material-symbols-outlined text-xs">chevron_right</span>
                        <a class="hover:text-[#9b1b1f] transition" href="{{ route('applicant.index') }}">Database Pelamar</a>
                        <span class="material-symbols-outlined text-xs">chevron_right</span>
                        <span class="text-[#9b1b1f] font-bold">{{ $applicant->name }}</span>
                    </nav>
                    <h1 class="text-xl font-bold text-slate-900 tracking-tight">Detail Profil Kandidat</h1>
                </div>
            </div>

            <!-- Top Action Buttons -->
            <div class="flex flex-wrap items-center gap-2.5">
                <a class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-white border border-slate-200 text-slate-700 hover:text-[#9b1b1f] text-xs font-semibold shadow-2xs transition-all hover:bg-slate-100"
                    href="{{ route('applicant.print', $applicant) }}" target="_blank">
                    <span class="material-symbols-outlined text-[16px] text-[#9b1b1f]">picture_as_pdf</span>
                    PDF Resume
                </a>
                @if ($latestApplication)
                    <div class="relative inline-block text-left">
                        <span class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-[#9b1b1f] text-white shadow-2xs font-bold text-xs tracking-wide">
                            <span class="w-1.5 h-1.5 rounded-full bg-red-200 animate-pulse"></span>
                            <span>Tahap: {{ $latestApplication->stage?->name ? ucwords($latestApplication->stage->name) : ucfirst($latestApplication->status ?? 'Pending') }}</span>
                        </span>
                    </div>
                @endif
            </div>
        </section>

        @include('auth.admin.applicant.partials.profile', ['isPublic' => false])
    </div>
@endsection
