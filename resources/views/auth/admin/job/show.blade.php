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
                                    <form action="" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <select name="stages_id"
                                            class="stage-select min-w-[180px] px-3 py-2 text-sm text-slate-700 bg-white border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                            data-application-id="{{ $application->id }}"
                                            data-applicant-name="{{ $application->applicant->name ?? '-' }}"
                                            data-applicant-email="{{ $application->applicant->email ?? '-' }}">
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
                                    </form>
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

                                        @if ($application->status !== 'rejected')
                                            <form action="" method="POST"
                                                onsubmit="return confirm('Yakin ingin menolak applicant ini?')">
                                                @csrf

                                                <button type="submit"
                                                    class="hover:cursor-pointer inline-flex items-center px-3 py-2 text-xs font-semibold text-rose-600 bg-rose-50 hover:bg-rose-100 border border-rose-100 rounded-lg transition-colors">
                                                    Rejected
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-xs text-slate-400">
                                                Rejected
                                            </span>
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
        document.querySelectorAll('.stage-select').forEach(select => {
            select.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];

                if (!this.value) {
                    return;
                }

                const applicationId = this.dataset.applicationId;
                const applicantName = this.dataset.applicantName;
                const applicantEmail = this.dataset.applicantEmail;
                const stageId = this.value;
                const stageName = selectedOption.dataset.stageName;

                document.getElementById('modal-application-id').value = applicationId;
                document.getElementById('modal-stage-id').value = stageId;

                document.getElementById('modal-applicant-name').textContent = applicantName;
                document.getElementById('modal-applicant-email').textContent = applicantEmail;
                document.getElementById('modal-stage-name').value = stageName;

                document.querySelectorAll('.stage-fields').forEach(field => {
                    field.classList.add('hidden');
                });

                switch (stageName) {
                    case 'psikotes':
                        document.getElementById('fields-psikotes').classList.remove('hidden');
                        break;

                    case 'interview':
                        document.getElementById('fields-interview').classList.remove('hidden');
                        break;

                    case 'mcu':
                        document.getElementById('fields-mcu').classList.remove('hidden');
                        break;

                    case 'study case':
                        document.getElementById('fields-study-case').classList.remove('hidden');
                        break;

                    case 'panel bod':
                        document.getElementById('fields-panel-bod').classList.remove('hidden');
                        break;

                    default:
                        document.getElementById('fields-none').classList.remove('hidden');
                        break;
                }

                const modal = document.getElementById('stage-email-modal');

                modal.classList.remove('hidden');
                modal.classList.add('flex');
            });
        });

        document.getElementById('interview_type')?.addEventListener('change', function() {
            const virtualField = document.getElementById('interview-virtual-field');
            const offlineField = document.getElementById('interview-offline-field');

            if (this.value === 'virtual') {
                virtualField.classList.remove('hidden');
                offlineField.classList.add('hidden');
            } else {
                virtualField.classList.add('hidden');
                offlineField.classList.remove('hidden');
            }
        });

        document.getElementById('panel_bod_type')?.addEventListener('change', function() {
            const virtualField = document.getElementById('panel-bod-virtual-field');
            const offlineField = document.getElementById('panel-bod-offline-field');

            if (this.value === 'virtual') {
                virtualField.classList.remove('hidden');
                offlineField.classList.add('hidden');
            } else {
                virtualField.classList.add('hidden');
                offlineField.classList.remove('hidden');
            }
        });
    </script>
@endsection
