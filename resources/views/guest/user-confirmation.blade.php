@extends('guest.layouts.index')

@section('title', 'Konfirmasi User')

@section('content')
    @php
        $education = $applicant->educations->first();
        $currentDecision = old('decision', $confirmation->decision);
        $decisionLabels = ['approved' => 'Disetujui', 'rejected' => 'Ditolak'];
    @endphp

    <div class="flex flex-col items-center justify-center px-4 py-8">
        <div
            class="w-full sm:max-w-xl bg-white shadow-[0_20px_50px_rgba(0,0,0,0.05)] rounded-2xl p-8 md:p-10 border border-gray-100">

            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800 tracking-tight">
                    Konfirmasi <span class="text-red-600">User</span>
                </h2>
                <p class="text-gray-500 mt-2 font-medium">
                    Mohon tinjau ringkasan kandidat berikut dan berikan keputusan Anda.
                </p>
            </div>

            @if (session('success'))
                <div class="mb-6 rounded-lg bg-green-50 border border-green-200 text-green-700 px-4 py-3 text-sm">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-6 rounded-lg bg-red-50 border border-red-200 text-red-700 px-4 py-3 text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <div class="flex items-center gap-4 mb-6">
                <img src="{{ asset('storage/' . $applicant->photo_url) }}" alt="Foto {{ $applicant->name }}"
                    class="w-20 h-20 rounded-full object-cover border border-gray-200">
                <div>
                    <p class="text-xl font-bold text-gray-800">{{ $applicant->name }}</p>
                    <p class="text-gray-600">{{ $application->job->title }}</p>
                    <p class="text-sm text-gray-500">{{ $application->job->office->name ?? '-' }}</p>
                </div>
            </div>

            <div class="mb-6">
                <h3 class="font-bold text-gray-800 mb-1">Pendidikan Terakhir</h3>
                <p class="text-gray-600 text-sm">
                    @if ($education)
                        {{ $education->degree_level }} &ndash; {{ $education->institution_name }} &ndash; {{ $education->major }}
                    @else
                        -
                    @endif
                </p>
            </div>

            <div class="mb-6">
                <h3 class="font-bold text-gray-800 mb-1">Pengalaman Kerja</h3>
                @forelse ($applicant->workExperiences as $experience)
                    <div class="text-sm text-gray-600 mb-2">
                        <p class="font-semibold">{{ $experience->company_name }} &ndash; {{ $experience->position }}</p>
                        <p class="text-gray-500">{{ $experience->start_date ?? '-' }} &ndash; {{ $experience->end_date ?? '-' }}</p>
                    </div>
                @empty
                    <p class="text-gray-600 text-sm">-</p>
                @endforelse
            </div>

            <a href="{{ route('user-confirmation.detail', request()->route('token')) }}"
                class="mb-6 flex w-full items-center justify-center rounded-lg border border-red-600 py-3 font-bold text-red-600 transition-all hover:bg-red-50">
                Lihat Detail Pelamar
            </a>

            @if ($confirmation->decided_at)
                <div class="mb-6 rounded-lg bg-gray-50 border border-gray-200 px-4 py-3 text-sm text-gray-700">
                    Keputusan Anda saat ini:
                    <strong>{{ $decisionLabels[$confirmation->decision] ?? '-' }}</strong>,
                    {{ $confirmation->decided_at->translatedFormat('d M Y H:i') }}
                </div>
            @endif

            @if ($isLocked)
                <div class="rounded-lg bg-yellow-50 border border-yellow-200 text-yellow-800 px-4 py-3 text-sm">
                    Proses seleksi kandidat ini sudah dilanjutkan oleh tim rekrutmen.
                </div>
            @else
                <form method="POST" action="{{ route('user-confirmation.update', request()->route('token')) }}"
                    class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div>
                        <span class="block font-bold text-gray-800 mb-2">Keputusan</span>
                        <div class="flex gap-6">
                            <label class="inline-flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="decision" value="approved" class="accent-red-600"
                                    @checked($currentDecision === 'approved')>
                                <span>Setuju</span>
                            </label>
                            <label class="inline-flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="decision" value="rejected" class="accent-red-600"
                                    @checked($currentDecision === 'rejected')>
                                <span>Tolak</span>
                            </label>
                        </div>
                        @error('decision')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="note" class="block font-bold text-gray-800 mb-2">Catatan (opsional)</label>
                        <textarea id="note" name="note" rows="4" maxlength="1000"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-600">{{ old('note', $confirmation->note) }}</textarea>
                        @error('note')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="w-full bg-red-600 hover:bg-red-700 text-white py-3.5 rounded-lg font-bold transition-all shadow-md hover:shadow-lg active:scale-[0.98] cursor-pointer">
                        Simpan Keputusan
                    </button>
                </form>
            @endif
        </div>
    </div>
@endsection
