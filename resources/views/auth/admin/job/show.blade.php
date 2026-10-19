@extends('auth.admin.layouts.index')

@section('title', 'Detail Lowongan Pekerjaan')

@section('content')
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

            <a href="{{ route('job.edit', $job->id) }}"
                class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-xl transition-colors">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 15.07a4.5 4.5 0 0 1-1.897 1.13l-2.685.805.805-2.685a4.5 4.5 0 0 1 1.13-1.897L16.862 4.487Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 7.125 16.875 4.5" />
                </svg>
                Edit Lowongan
            </a>
        </div>
    </div>

    @if ($job->approval_status === 'rejected' && $job->rejection_reason)
        <div class="px-4 py-3 text-sm text-rose-700 bg-rose-50 border border-rose-100 rounded-xl">
            <span class="font-semibold">Ditolak oleh HO:</span> {{ $job->rejection_reason }}
        </div>
    @endif

    @can('approve', $job)
        @if ($job->approval_status === 'pending')
            <div class="p-4 bg-amber-50 border border-amber-100 rounded-2xl space-y-3">
                <p class="text-sm font-semibold text-amber-800">Lowongan ini menunggu persetujuan Anda.</p>

                <div class="flex flex-wrap items-start gap-3">
                    <form method="POST" action="{{ route('job.approve', $job) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            class="px-4 py-2 text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl transition-colors">
                            Setujui
                        </button>
                    </form>

                    <form method="POST" action="{{ route('job.reject', $job) }}" class="flex flex-1 gap-2">
                        @csrf
                        @method('PATCH')
                        <div class="flex-1">
                            <input type="text" name="rejection_reason" value="{{ old('rejection_reason') }}"
                                placeholder="Alasan penolakan" required
                                class="w-full px-3 py-2 text-sm border border-slate-200 rounded-xl">
                            @error('rejection_reason')
                                <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit"
                            class="px-4 py-2 text-sm font-semibold text-white bg-rose-600 hover:bg-rose-700 rounded-xl transition-colors">
                            Tolak
                        </button>
                    </form>
                </div>
            </div>
        @endif
    @endcan

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

                <div class="mt-1">
                    @if ($job->approval_status === 'pending')
                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-100">Menunggu Persetujuan</span>
                    @elseif ($job->approval_status === 'rejected')
                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-100">Ditolak</span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">Disetujui</span>
                    @endif
                </div>
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
