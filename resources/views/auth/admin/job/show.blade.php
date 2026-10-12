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

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden mt-10">
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
                                    <select
                                        class="stage-select min-w-[180px] px-3 py-2 text-sm text-slate-700 bg-white border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 disabled:bg-slate-100 disabled:cursor-not-allowed"
                                        data-update-url="{{ route('application.updateStage', $application) }}"
                                        data-current="{{ $application->stages_id }}"
                                        data-applicant-name="{{ $application->applicant->name ?? '-' }}"
                                        data-applicant-email="{{ $application->applicant->email ?? '-' }}"
                                        @disabled(in_array($application->status, ['accepted', 'rejected']))>
                                        <option value="">
                                            Pilih Stage
                                        </option>

                                        @foreach ($stages as $stage)
                                            <option value="{{ $stage->id }}" data-stage-name="{{ $stage->name }}"
                                                {{ $application->stages_id == $stage->id ? 'selected' : '' }}>
                                                {{ $stage->step }}. {{ $stage->name }}
                                            </option>
                                        @endforeach
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

                                        @if (! in_array($application->status, ['accepted', 'rejected']))
                                            <button type="button"
                                                class="accept-button hover:cursor-pointer inline-flex items-center px-3 py-2 text-xs font-semibold text-emerald-600 bg-emerald-50 hover:bg-emerald-100 border border-emerald-100 rounded-lg transition-colors"
                                                data-update-url="{{ route('application.updateStatus', $application) }}"
                                                data-applicant-name="{{ $application->applicant->name ?? '-' }}"
                                                data-applicant-email="{{ $application->applicant->email ?? '-' }}"
                                                data-office-type="{{ $job->office->type ?? '-' }}">
                                                Accepted
                                            </button>

                                            <form action="{{ route('application.updateStatus', $application) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menolak applicant ini? Email penolakan akan dikirim.')">
                                                @csrf
                                                @method('PATCH')

                                                <input type="hidden" name="status" value="rejected">

                                                <button type="submit"
                                                    class="hover:cursor-pointer inline-flex items-center px-3 py-2 text-xs font-semibold text-rose-600 bg-rose-50 hover:bg-rose-100 border border-rose-100 rounded-lg transition-colors">
                                                    Rejected
                                                </button>
                                            </form>
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

        function showFields(fieldId) {
            document.querySelectorAll('.stage-fields').forEach(field => {
                field.classList.add('hidden');
            });

            document.getElementById(fieldId).classList.remove('hidden');
        }

        function openStageModal(trigger, title) {
            stageForm.reset();
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

            stageModal.classList.add('hidden');
            stageModal.classList.remove('flex');
        }

        document.querySelectorAll('.stage-select').forEach(select => {
            select.addEventListener('change', function() {
                if (!this.value) {
                    this.value = this.dataset.current;
                    return;
                }

                const stageName = this.options[this.selectedIndex].dataset.stageName;

                activeStageSelect = this;
                openStageModal(this, 'Data Tahapan Applicant');

                stageIdInput.disabled = false;
                stageIdInput.value = this.value;
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

                    default:
                        showFields('fields-none');
                        break;
                }

                toggleMethodFields('interview_type', 'interview-virtual-field', 'interview-offline-field');
                toggleMethodFields('panel_bod_type', 'panel-bod-virtual-field', 'panel-bod-offline-field');
            });
        });

        document.querySelectorAll('.accept-button').forEach(button => {
            button.addEventListener('click', function() {
                activeStageSelect = null;
                openStageModal(this, 'Terima Applicant');

                stageIdInput.disabled = true;
                statusInput.disabled = false;
                document.getElementById('modal-stage-wrapper').classList.add('hidden');
                document.getElementById('modal-office-type').textContent = this.dataset.officeType;

                showFields('fields-accept');
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
