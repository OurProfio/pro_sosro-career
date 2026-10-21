@extends('auth.admin.layouts.index')

@section('title', 'Detail Lowongan Pekerjaan')

@section('content')
    <div class="space-y-6 font-sans" x-data="{ openEditModal: {{ $errors->any() ? 'true' : 'false' }} }">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-bold text-slate-800">Detail Lowongan</h2>
                <p class="text-sm text-slate-500">
                    Informasi lengkap mengenai lowongan pekerjaan.
                </p>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('job.index') }}"
                    class="inline-flex items-center gap-2 px-3.5 py-2 text-sm font-medium text-slate-600 hover:text-slate-900 bg-white hover:bg-slate-100 border border-slate-200 rounded-xl transition-colors">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                    Kembali
                </a>

                <button type="button" @click="openEditModal = true"
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-[#A6192E] hover:bg-[#7f1d1d] rounded-xl transition-colors cursor-pointer shadow-sm">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 15.07a4.5 4.5 0 0 1-1.897 1.13l-2.685.805.805-2.685a4.5 4.5 0 0 1 1.13-1.897L16.862 4.487Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 7.125 16.875 4.5" />
                    </svg>
                    Edit Lowongan
                </button>
            </div>
        </div>

    <div class="bg-white border border-slate-200 rounded-2xl shadow-xs overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h3 class="text-lg font-bold text-slate-800">
                        {{ $job->title }}
                    </h3>

                    <p class="text-sm text-slate-500 mt-1">
                        {{ ucwords(str_replace('_', ' ', $job->category)) }}
                    </p>
                </div>

                <div>
                    @if ($job->status === 'aktif')
                        <span
                            class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">
                            Aktif
                        </span>
                    @elseif ($job->status === 'nonaktif')
                        <span
                            class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                            Nonaktif
                        </span>
                    @elseif ($job->status === 'selesai')
                        <span
                            class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-100">
                            Selesai
                        </span>
                    @elseif ($job->status === 'dihapus')
                        <span
                            class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-100">
                            Dihapus
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <div class="p-6 space-y-6">
            <div>
                <h4 class="text-sm font-bold text-slate-800 mb-4">
                    Informasi Lowongan
                </h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                        <p class="text-xs text-slate-400 mb-1">Bidang Pekerjaan</p>
                        <p class="text-sm font-semibold text-slate-700">
                            {{ $job->occupation }}
                        </p>
                    </div>

                    <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                        <p class="text-xs text-slate-400 mb-1">Tipe Pekerjaan</p>
                        <p class="text-sm font-semibold text-slate-700">
                            {{ $job->type }}
                        </p>
                    </div>

                    <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                        <p class="text-xs text-slate-400 mb-1">Kantor / Cabang</p>
                        <p class="text-sm font-semibold text-slate-700">
                            {{ $job->office->name ?? '-' }}
                        </p>
                    </div>

                    <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                        <p class="text-xs text-slate-400 mb-1">Lokasi Kerja</p>
                        <p class="text-sm font-semibold text-slate-700">
                            {{ $job->location }}
                        </p>
                    </div>

                    <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                        <p class="text-xs text-slate-400 mb-1">Tanggal Buka</p>
                        <p class="text-sm font-semibold text-slate-700">
                            {{ \Carbon\Carbon::parse($job->opening_date)->format('d M Y') }}
                        </p>
                    </div>

                    <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                        <p class="text-xs text-slate-400 mb-1">Tanggal Tutup</p>
                        <p class="text-sm font-semibold text-slate-700">
                            {{ \Carbon\Carbon::parse($job->closing_date)->format('d M Y') }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="pt-5 border-t border-slate-100">
                <h4 class="text-sm font-bold text-slate-800 mb-3">
                    Deskripsi Pekerjaan
                </h4>

                <div class="text-sm text-slate-600 leading-relaxed whitespace-pre-line">
                    {{ $job->description }}
                </div>
            </div>

            <div class="pt-5 border-t border-slate-100">
                <h4 class="text-sm font-bold text-slate-800 mb-3">
                    Kualifikasi Pelamar
                </h4>

                <div class="text-sm text-slate-600 leading-relaxed whitespace-pre-line">
                    {{ $job->qualification }}
                </div>
            </div>
        </div>
    </div>

    @php
        $totalApplicants = $job->applications->count();
        $acceptedApplicants = $job->applications->where('status', 'accepted')->count();
        $rejectedApplicants = $job->applications->where('status', 'rejected')->count();
        $inProgressApplicants = $job->applications->whereNotIn('status', ['accepted', 'rejected'])->count();
    @endphp

    <div class="mt-8">
        <div class="mb-4">
            <h3 class="text-base font-bold text-slate-800">Statistik Pelamar Lowongan</h3>
            <p class="text-xs text-slate-500">Ringkasan kandidat yang telah mendaftar pada lowongan ini.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Pelamar</p>
                    <p class="mt-1.5 text-2xl font-extrabold text-slate-900">{{ number_format($totalApplicants, 0, ',', '.') }}</p>
                    <p class="mt-1 text-[11px] text-slate-400">Total lamaran masuk</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-amber-200/80 p-5 shadow-xs flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-amber-600 uppercase tracking-wider">Dalam Proses</p>
                    <p class="mt-1.5 text-2xl font-extrabold text-slate-900">{{ number_format($inProgressApplicants, 0, ',', '.') }}</p>
                    <p class="mt-1 text-[11px] text-slate-400">Sedang seleksi / review</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-emerald-200/80 p-5 shadow-xs flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-emerald-600 uppercase tracking-wider">Diterima (Accepted)</p>
                    <p class="mt-1.5 text-2xl font-extrabold text-slate-900">{{ number_format($acceptedApplicants, 0, ',', '.') }}</p>
                    <p class="mt-1 text-[11px] text-slate-400">Lolos seleksi akhir</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-rose-200/80 p-5 shadow-xs flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-rose-600 uppercase tracking-wider">Ditolak (Rejected)</p>
                    <p class="mt-1.5 text-2xl font-extrabold text-slate-900">{{ number_format($rejectedApplicants, 0, ',', '.') }}</p>
                    <p class="mt-1 text-[11px] text-slate-400">Tidak lolos kualifikasi</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden mt-8">
        <div class="px-6 py-5 border-b border-slate-200">
            <div>
                <h2 class="text-lg font-bold text-slate-800">Daftar Applicant</h2>
                <p class="text-sm text-slate-500 mt-1">
                    Daftar applicant yang melamar pada lowongan ini.
                </p>
            </div>
        </div>

        @if ($job->applications->isEmpty())
            <div class="px-6 py-10 text-center">
                <p class="text-sm text-slate-500">
                    Belum ada applicant yang melamar pada lowongan ini.
                </p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200">
                            <th class="px-6 py-3 text-left font-semibold text-slate-600">
                                No
                            </th>
                            <th class="px-6 py-3 text-left font-semibold text-slate-600">
                                Applicant
                            </th>
                            <th class="px-6 py-3 text-left font-semibold text-slate-600">
                                Email
                            </th>
                            <th class="px-6 py-3 text-left font-semibold text-slate-600">
                                Tanggal Melamar
                            </th>
                            <th class="px-6 py-3 text-left font-semibold text-slate-600">
                                Stage
                            </th>
                            <th class="px-6 py-3 text-left font-semibold text-slate-600">
                                Status
                            </th>
                            <th class="px-6 py-3 text-left font-semibold text-slate-600">
                                Action
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        @foreach ($job->applications as $application)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 text-slate-600">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="px-6 py-4">
                                    <div class="font-medium text-slate-800">
                                        {{ $application->applicant->name ?? '-' }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-slate-600">
                                    {{ $application->applicant->email ?? '-' }}
                                </td>

                                <td class="px-6 py-4 text-slate-600">
                                    {{ $application->created_at?->format('d M Y') ?? '-' }}
                                </td>

                                <td class="px-6 py-4">
                                    @php
                                        $currentStage = $stages->firstWhere('id', $application->stages_id);
                                        $currentStep = $currentStage?->step ?? 0;
                                    @endphp

                                    <select
                                        class="stage-select min-w-[180px] px-3 py-2 text-sm text-slate-700 bg-white border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 disabled:bg-slate-100 disabled:cursor-not-allowed"
                                        data-stage-url="{{ route('application.updateStage', $application) }}"
                                        data-status-url="{{ route('application.updateStatus', $application) }}"
                                        data-current="{{ $application->status === 'accepted' ? 'status:accepted' : ($application->status === 'rejected' ? 'status:rejected' : ($application->stages_id ? 'stage:' . $application->stages_id : '')) }}"
                                        data-applicant-name="{{ $application->applicant->name ?? '-' }}"
                                        data-applicant-email="{{ $application->applicant->email ?? '-' }}"
                                        data-office-type="{{ $job->office->type ?? '-' }}"
                                        @disabled(in_array($application->status, ['accepted', 'rejected', 'cancelled']))>
                                        <option value="">
                                            Pilih Stage
                                        </option>

                                        @foreach ($stages as $stage)
                                            {{-- Tahapan sebelumnya disembunyikan/tidak dapat dipilih --}}
                                            @if ($stage->step >= $currentStep)
                                                <option value="stage:{{ $stage->id }}" data-stage-name="{{ $stage->name }}"
                                                    {{ $application->status !== 'accepted' && $application->status !== 'rejected' && $application->status !== 'cancelled' && $application->stages_id == $stage->id ? 'selected' : '' }}>
                                                    {{ $stage->step }}. {{ $stage->name }}
                                                </option>
                                            @endif
                                        @endforeach

                                        <optgroup label="Keputusan Akhir">
                                            <option value="status:accepted" {{ $application->status === 'accepted' ? 'selected' : '' }}>
                                                Accepted
                                            </option>
                                            <option value="status:rejected" {{ $application->status === 'rejected' ? 'selected' : '' }}>
                                                Rejected
                                            </option>
                                        </optgroup>
                                    </select>
                                </td>

                                <td class="px-6 py-4">
                                    @if ($application->status === 'pending')
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-100">
                                            Pending
                                        </span>
                                    @elseif ($application->status === 'progress')
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-100">
                                            Progress
                                        </span>
                                    @elseif ($application->status === 'accepted')
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                            Accepted
                                        </span>
                                    @elseif ($application->status === 'rejected')
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-100">
                                            Rejected
                                        </span>
                                    @elseif ($application->status === 'cancelled')
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-gray-100 text-gray-700 border border-gray-200">
                                            Dibatalkan
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-slate-50 text-slate-700 border border-slate-200 capitalize">
                                            {{ $application->status }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        @if ($application->applicant)
                                            <a href="{{ route('applicant.show', $application->applicant) }}"
                                                class="w-max inline-flex items-center px-3 py-2 text-xs font-semibold text-blue-600 bg-blue-50 hover:bg-blue-100 border border-blue-100 rounded-lg transition-colors">
                                                Lihat Detail
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <!-- BEGIN: Modal Edit Lowongan (Alpine.js) -->
    <div x-show="openEditModal"
        x-cloak
        style="display: none;"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
        role="dialog"
        aria-modal="true"
        aria-labelledby="modal-edit-title"
        @keydown.escape.window="openEditModal = false">
        
        <div x-show="openEditModal"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            @click.outside="openEditModal = false"
            class="bg-white w-full max-w-3xl rounded-2xl shadow-2xl border border-slate-200 flex flex-col max-h-[92vh] overflow-hidden">
            
            <!-- Modal Header -->
            <div class="px-8 py-5 border-b border-slate-100 flex items-center justify-between bg-white shrink-0">
                <div class="flex items-center gap-3.5">
                    <div class="w-10 h-10 rounded-xl bg-red-50 border border-red-100/70 flex items-center justify-center text-[#A6192E] shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 15.07a4.5 4.5 0 0 1-1.897 1.13l-2.685.805.805-2.685a4.5 4.5 0 0 1 1.13-1.897L16.862 4.487Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 7.125 16.875 4.5" />
                        </svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="text-lg font-bold text-slate-900 leading-tight" id="modal-edit-title">Edit Data Lowongan</h3>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-red-50 text-[#A6192E] border border-red-100/70">ID: #{{ $job->id }}</span>
                        </div>
                        <p class="text-xs text-slate-500 mt-0.5">Perbarui informasi dan rincian lowongan kerja ini.</p>
                    </div>
                </div>
                <button type="button" @click="openEditModal = false" aria-label="Tutup Modal" class="p-1.5 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-lg transition cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </button>
            </div>

            <!-- Form Container -->
            <form action="{{ route('job.update', $job->id) }}" method="POST" class="flex flex-col flex-1 min-h-0 overflow-hidden">
                @csrf
                @method('PUT')
                <div class="flex-1 overflow-y-auto px-8 py-6 space-y-6">
                    <!-- Group 1: Informasi Dasar -->
                    <div class="space-y-4">
                        <div class="flex items-center gap-2 pb-1 border-b border-slate-100">
                            <span class="w-2 h-2 rounded-full bg-[#A6192E]"></span>
                            <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider">Informasi Dasar</h4>
                        </div>

                        <div class="space-y-1.5">
                            <label for="modal_edit_title" class="block text-[11px] font-semibold text-slate-700 uppercase tracking-wider">
                                Judul Lowongan <span class="text-[#A6192E] font-bold">*</span>
                            </label>
                            <input type="text" name="title" id="modal_edit_title" value="{{ old('title', $job->title) }}"
                                class="w-full px-4 py-2.5 text-xs rounded-xl border {{ $errors->has('title') ? 'border-red-500 ring-1 ring-red-500' : 'border-slate-200' }} bg-slate-50/50 hover:border-slate-300 focus:bg-white focus:border-[#A6192E] focus:ring-2 focus:ring-[#A6192E]/20 text-slate-800 placeholder-slate-400 transition"
                                placeholder="Contoh: Senior Backend Developer" required>
                            @error('title')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label for="modal_edit_office_id" class="block text-[11px] font-semibold text-slate-700 uppercase tracking-wider">
                                    Kantor / Cabang <span class="text-[#A6192E] font-bold">*</span>
                                </label>
                                <div class="relative">
                                    <select name="office_id" id="modal_edit_office_id"
                                        class="w-full appearance-none px-4 pr-10 py-2.5 text-xs rounded-xl border {{ $errors->has('office_id') ? 'border-red-500 ring-1 ring-red-500' : 'border-slate-200' }} bg-slate-50/50 hover:border-slate-300 focus:bg-white focus:border-[#A6192E] focus:ring-2 focus:ring-[#A6192E]/20 text-slate-700 cursor-pointer transition"
                                        required>
                                        <option value="" disabled>-- Pilih Kantor / Cabang --</option>
                                        @if (isset($offices))
                                            @foreach ($offices as $office)
                                                <option value="{{ $office->id }}" {{ old('office_id', $job->office_id) == $office->id ? 'selected' : '' }}>
                                                    {{ $office->name ?? $office->title }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <svg class="w-4 h-4 text-slate-400 absolute right-3.5 top-3 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M19 9l-7 7-7-7" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </div>
                                @error('office_id')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-1.5">
                                <label for="modal_edit_category" class="block text-[11px] font-semibold text-slate-700 uppercase tracking-wider">
                                    Kategori Lowongan <span class="text-[#A6192E] font-bold">*</span>
                                </label>
                                <div class="relative">
                                    <select name="category" id="modal_edit_category"
                                        class="w-full appearance-none px-4 pr-10 py-2.5 text-xs rounded-xl border {{ $errors->has('category') ? 'border-red-500 ring-1 ring-red-500' : 'border-slate-200' }} bg-slate-50/50 hover:border-slate-300 focus:bg-white focus:border-[#A6192E] focus:ring-2 focus:ring-[#A6192E]/20 text-slate-700 cursor-pointer transition"
                                        required>
                                        <option value="" disabled>-- Pilih Kategori --</option>
                                        <option value="profesional" {{ old('category', $job->category) == 'profesional' ? 'selected' : '' }}>Profesional</option>
                                        <option value="management_trainee" {{ old('category', $job->category) == 'management_trainee' ? 'selected' : '' }}>Management Trainee</option>
                                        <option value="internship" {{ old('category', $job->category) == 'internship' ? 'selected' : '' }}>Internship / PKL</option>
                                        <option value="magang" {{ old('category', $job->category) == 'magang' ? 'selected' : '' }}>Magang</option>
                                    </select>
                                    <svg class="w-4 h-4 text-slate-400 absolute right-3.5 top-3 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M19 9l-7 7-7-7" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </div>
                                @error('category')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label for="modal_edit_occupation" class="block text-[11px] font-semibold text-slate-700 uppercase tracking-wider">
                                    Bidang Pekerjaan <span class="text-[#A6192E] font-bold">*</span>
                                </label>
                                <div class="relative">
                                    <select name="occupation" id="modal_edit_occupation"
                                        class="w-full appearance-none px-4 pr-10 py-2.5 text-xs rounded-xl border {{ $errors->has('occupation') ? 'border-red-500 ring-1 ring-red-500' : 'border-slate-200' }} bg-slate-50/50 hover:border-slate-300 focus:bg-white focus:border-[#A6192E] focus:ring-2 focus:ring-[#A6192E]/20 text-slate-700 cursor-pointer transition"
                                        required>
                                        <option value="" disabled>-- Pilih Bidang Pekerjaan --</option>
                                        @if (isset($divisions))
                                            @foreach ($divisions as $division)
                                                <option value="{{ $division->name }}" {{ old('occupation', $job->occupation) == $division->name ? 'selected' : '' }}>
                                                    {{ $division->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <svg class="w-4 h-4 text-slate-400 absolute right-3.5 top-3 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M19 9l-7 7-7-7" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </div>
                                @error('occupation')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-1.5">
                                <label for="modal_edit_type" class="block text-[11px] font-semibold text-slate-700 uppercase tracking-wider">
                                    Tipe Pekerjaan <span class="text-[#A6192E] font-bold">*</span>
                                </label>
                                <div class="relative">
                                    <select name="type" id="modal_edit_type"
                                        class="w-full appearance-none px-4 pr-10 py-2.5 text-xs rounded-xl border {{ $errors->has('type') ? 'border-red-500 ring-1 ring-red-500' : 'border-slate-200' }} bg-slate-50/50 hover:border-slate-300 focus:bg-white focus:border-[#A6192E] focus:ring-2 focus:ring-[#A6192E]/20 text-slate-700 cursor-pointer transition"
                                        required>
                                        <option value="" disabled>-- Pilih Tipe Pekerjaan --</option>
                                        <option value="Full-Time" {{ old('type', $job->type) == 'Full-Time' ? 'selected' : '' }}>Full-Time (Tetap)</option>
                                        <option value="Kontrak" {{ old('type', $job->type) == 'Kontrak' ? 'selected' : '' }}>Kontrak (PKWT)</option>
                                        <option value="Part-Time" {{ old('type', $job->type) == 'Part-Time' ? 'selected' : '' }}>Part Time</option>
                                        <option value="Freelance" {{ old('type', $job->type) == 'Freelance' ? 'selected' : '' }}>Freelance</option>
                                    </select>
                                    <svg class="w-4 h-4 text-slate-400 absolute right-3.5 top-3 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M19 9l-7 7-7-7" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </div>
                                @error('type')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label for="modal_edit_location" class="block text-[11px] font-semibold text-slate-700 uppercase tracking-wider">
                                Lokasi Kerja <span class="text-[#A6192E] font-bold">*</span>
                            </label>
                            <input type="text" name="location" id="modal_edit_location" value="{{ old('location', $job->location) }}"
                                class="w-full px-4 py-2.5 text-xs rounded-xl border {{ $errors->has('location') ? 'border-red-500 ring-1 ring-red-500' : 'border-slate-200' }} bg-slate-50/50 hover:border-slate-300 focus:bg-white focus:border-[#A6192E] focus:ring-2 focus:ring-[#A6192E]/20 text-slate-800 placeholder-slate-400 transition"
                                placeholder="Contoh: Jakarta Selatan" required>
                            @error('location')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Group 2: Rincian Lowongan -->
                    <div class="space-y-4">
                        <div class="flex items-center gap-2 pb-1 border-b border-slate-100">
                            <span class="w-2 h-2 rounded-full bg-[#A6192E]"></span>
                            <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider">Rincian Posisi</h4>
                        </div>

                        <div class="space-y-1.5">
                            <label for="modal_edit_description" class="block text-[11px] font-semibold text-slate-700 uppercase tracking-wider">
                                Deskripsi Pekerjaan <span class="text-[#A6192E] font-bold">*</span>
                            </label>
                            <textarea name="description" id="modal_edit_description" rows="4"
                                class="w-full px-4 py-2.5 text-xs rounded-xl border {{ $errors->has('description') ? 'border-red-500 ring-1 ring-red-500' : 'border-slate-200' }} bg-slate-50/50 hover:border-slate-300 focus:bg-white focus:border-[#A6192E] focus:ring-2 focus:ring-[#A6192E]/20 text-slate-800 placeholder-slate-400 transition leading-relaxed resize-y"
                                placeholder="Tuliskan tanggung jawab dan rincian pekerjaan..." required>{{ old('description', $job->description) }}</textarea>
                            @error('description')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1.5">
                            <label for="modal_edit_qualification" class="block text-[11px] font-semibold text-slate-700 uppercase tracking-wider">
                                Kualifikasi Pelamar <span class="text-[#A6192E] font-bold">*</span>
                            </label>
                            <textarea name="qualification" id="modal_edit_qualification" rows="4"
                                class="w-full px-4 py-2.5 text-xs rounded-xl border {{ $errors->has('qualification') ? 'border-red-500 ring-1 ring-red-500' : 'border-slate-200' }} bg-slate-50/50 hover:border-slate-300 focus:bg-white focus:border-[#A6192E] focus:ring-2 focus:ring-[#A6192E]/20 text-slate-800 placeholder-slate-400 transition leading-relaxed resize-y"
                                placeholder="Tuliskan pendidikan, pengalaman, keahlian, dan persyaratan lainnya..." required>{{ old('qualification', $job->qualification) }}</textarea>
                            @error('qualification')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Group 3: Periode Waktu -->
                    <div class="space-y-4">
                        <div class="flex items-center gap-2 pb-1 border-b border-slate-100">
                            <span class="w-2 h-2 rounded-full bg-[#A6192E]"></span>
                            <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider">Periode Waktu Publikasi</h4>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label for="modal_edit_opening_date" class="block text-[11px] font-semibold text-slate-700 uppercase tracking-wider">
                                    Tanggal Buka <span class="text-[#A6192E] font-bold">*</span>
                                </label>
                                <input type="date" name="opening_date" id="modal_edit_opening_date" value="{{ old('opening_date', $job->opening_date ? \Carbon\Carbon::parse($job->opening_date)->format('Y-m-d') : '') }}"
                                    class="w-full px-4 py-2.5 text-xs rounded-xl border {{ $errors->has('opening_date') ? 'border-red-500 ring-1 ring-red-500' : 'border-slate-200' }} bg-slate-50/50 hover:border-slate-300 focus:bg-white focus:border-[#A6192E] focus:ring-2 focus:ring-[#A6192E]/20 text-slate-700 transition"
                                    required>
                                @error('opening_date')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-1.5">
                                <label for="modal_edit_closing_date" class="block text-[11px] font-semibold text-slate-700 uppercase tracking-wider">
                                    Tanggal Tutup <span class="text-[#A6192E] font-bold">*</span>
                                </label>
                                <input type="date" name="closing_date" id="modal_edit_closing_date" value="{{ old('closing_date', $job->closing_date ? \Carbon\Carbon::parse($job->closing_date)->format('Y-m-d') : '') }}"
                                    class="w-full px-4 py-2.5 text-xs rounded-xl border {{ $errors->has('closing_date') ? 'border-red-500 ring-1 ring-red-500' : 'border-slate-200' }} bg-slate-50/50 hover:border-slate-300 focus:bg-white focus:border-[#A6192E] focus:ring-2 focus:ring-[#A6192E]/20 text-slate-700 transition"
                                    required>
                                @error('closing_date')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="px-8 py-4 bg-slate-50/70 border-t border-slate-100 flex items-center justify-end gap-3 shrink-0">
                    <button type="button" @click="openEditModal = false" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-100 hover:text-slate-800 font-semibold text-xs transition duration-150 cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-[#A6192E] hover:bg-[#7f1d1d] text-white font-bold text-xs shadow-sm shadow-red-950/20 hover:shadow-md transition duration-150 ease-in-out cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!-- END: Modal Edit Lowongan -->
</div>

    <x-application.modal-email />

    <script>
        const stageModal = document.getElementById('stage-email-modal');
        const stageForm = document.getElementById('stage-email-form');
        const stageIdInput = document.getElementById('modal-stage-id');
        const statusInput = document.getElementById('modal-status');
        let activeStageSelect = null;

        const submitBtn = document.getElementById('modal-submit-btn');

        function resetSubmitButton() {
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<span>Lanjutkan</span>';
            }
        }

        function showFields(fieldId) {
            document.querySelectorAll('.stage-fields').forEach(field => {
                field.classList.add('hidden');
            });

            document.getElementById(fieldId).classList.remove('hidden');
        }

        function openStageModal(trigger, title) {
            stageForm.reset();
            resetSubmitButton();
            stageForm.action = trigger.dataset.updateUrl;

            document.getElementById('modal-title').textContent = title;
            document.getElementById('modal-applicant-name').textContent = trigger.dataset.applicantName;
            document.getElementById('modal-applicant-email').textContent = trigger.dataset.applicantEmail;

            stageModal.classList.remove('hidden');
            stageModal.classList.add('flex');
        }

        function closeStageModal() {
            if (activeStageSelect) {
                activeStageSelect.value = activeStageSelect.dataset.current;
                activeStageSelect = null;
            }

            resetSubmitButton();
            stageModal.classList.add('hidden');
            stageModal.classList.remove('flex');
        }

        stageForm?.addEventListener('submit', function(e) {
            if (submitBtn) {
                if (submitBtn.disabled) {
                    e.preventDefault();
                    return;
                }
                submitBtn.disabled = true;
                submitBtn.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                    </svg>
                    <span>Memproses...</span>
                `;
            }
        });

        document.querySelectorAll('.stage-select').forEach(select => {
            select.addEventListener('change', function() {
                if (!this.value) {
                    this.value = this.dataset.current;
                    return;
                }

                activeStageSelect = this;

                if (this.value === 'status:accepted') {
                    openStageModal(this, 'Terima Applicant');
                    stageForm.action = this.dataset.statusUrl;

                    stageIdInput.disabled = true;
                    statusInput.disabled = false;
                    statusInput.value = 'accepted';
                    document.getElementById('modal-stage-wrapper').classList.add('hidden');
                    document.getElementById('modal-office-type').textContent = this.dataset.officeType;

                    showFields('fields-accept');
                    return;
                }

                if (this.value === 'status:rejected') {
                    openStageModal(this, 'Tolak Applicant');
                    stageForm.action = this.dataset.statusUrl;

                    stageIdInput.disabled = true;
                    statusInput.disabled = false;
                    statusInput.value = 'rejected';
                    document.getElementById('modal-stage-wrapper').classList.add('hidden');

                    showFields('fields-reject');
                    return;
                }

                // Pilihan stage (format value: stage:123)
                const rawStageId = this.value.replace('stage:', '');
                const stageName = this.options[this.selectedIndex].dataset.stageName;

                openStageModal(this, 'Data Tahapan Applicant');
                stageForm.action = this.dataset.stageUrl;

                stageIdInput.disabled = false;
                stageIdInput.value = rawStageId;
                statusInput.disabled = true;
                document.getElementById('modal-stage-wrapper').classList.remove('hidden');
                document.getElementById('modal-stage-name').value = stageName;

                switch (stageName.startsWith('interview') ? 'interview' : stageName) {
                    case 'psikotes':
                        showFields('fields-psikotes');
                        break;

                    case 'interview':
                        showFields('fields-interview');
                        break;

                    case 'mcu':
                        showFields('fields-mcu');
                        break;

                    case 'study case':
                        showFields('fields-study-case');
                        break;

                    case 'panel bod':
                        showFields('fields-panel-bod');
                        break;

                    case 'offering':
                        showFields('fields-offering');
                        break;

                    default:
                        showFields('fields-none');
                        break;
                }

                toggleMethodFields('interview_type', 'interview-virtual-field', 'interview-offline-field');
                toggleMethodFields('panel_bod_type', 'panel-bod-virtual-field', 'panel-bod-offline-field');
            });
        });

        stageModal.querySelectorAll('[data-modal-hide]').forEach(button => {
            button.addEventListener('click', closeStageModal);
        });

        function toggleMethodFields(selectId, virtualFieldId, offlineFieldId) {
            const isVirtual = document.getElementById(selectId).value === 'virtual';

            document.getElementById(virtualFieldId).classList.toggle('hidden', !isVirtual);
            document.getElementById(offlineFieldId).classList.toggle('hidden', isVirtual);
        }

        document.getElementById('interview_type').addEventListener('change', () => {
            toggleMethodFields('interview_type', 'interview-virtual-field', 'interview-offline-field');
        });

        document.getElementById('panel_bod_type').addEventListener('change', () => {
            toggleMethodFields('panel_bod_type', 'panel-bod-virtual-field', 'panel-bod-offline-field');
        });
    </script>
@endsection
