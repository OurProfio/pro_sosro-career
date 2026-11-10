@extends('guest.layouts.index')

@section('title', 'Detail Profil Kandidat - ' . ($applicant->name ?? 'Pelamar'))

@section('content')
    <div class="applicant-show-page max-w-7xl mx-auto w-full px-4 py-6 flex flex-col">
        <section class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-3.5 border-b border-slate-200">
            <div class="flex items-center gap-3.5">
                <a class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-white border border-slate-200 shadow-2xs text-slate-600 hover:text-[#9b1b1f] hover:bg-slate-100 transition shrink-0"
                    href="{{ route('user-confirmation.show', $token) }}" title="Kembali ke Konfirmasi">
                    <span class="material-symbols-outlined text-[20px]">arrow_back</span>
                </a>
                <div class="space-y-0.5">
                    <a class="text-xs text-slate-400 font-medium hover:text-[#9b1b1f] transition" href="{{ route('user-confirmation.show', $token) }}">
                        Kembali ke Konfirmasi
                    </a>
                    <h1 class="text-xl font-bold text-slate-900 tracking-tight">Detail Profil Kandidat</h1>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-2.5">
                <a class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-white border border-slate-200 text-slate-700 hover:text-[#9b1b1f] text-xs font-semibold shadow-2xs transition-all hover:bg-slate-100"
                    href="{{ route('user-confirmation.print', $token) }}" target="_blank">
                    <span class="material-symbols-outlined text-[16px] text-[#9b1b1f]">picture_as_pdf</span>
                    PDF Resume
                </a>
                <span class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-[#9b1b1f] text-white shadow-2xs font-bold text-xs tracking-wide">
                    <span class="w-1.5 h-1.5 rounded-full bg-red-200 animate-pulse"></span>
                    <span>Tahap: {{ $latestApplication->stage?->name ? ucwords($latestApplication->stage->name) : ucfirst($latestApplication->status ?? 'Pending') }}</span>
                </span>
            </div>
        </section>

        @include('auth.admin.applicant.partials.profile', ['isPublic' => true])
    </div>
@endsection
