@extends('auth.admin.layouts.index')

@section('title', 'Kelola Lowongan Pekerjaan')

@section('content')
	<div class="p-4 sm:p-6 lg:p-8 space-y-6 font-sans min-h-[calc(100vh-4rem)]">
		<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
			<div>
				<h1 class="text-xl sm:text-2xl font-bold text-slate-800 tracking-tight">Manajemen Lowongan</h1>
				<p class="text-xs sm:text-sm text-slate-500 mt-0.5">Kelola dan pantau status publikasi lowongan kerja
					perusahaan Anda.</p>
			</div>
			<div>
				<a href="{{ route('job.create') }}"
					class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white text-xs sm:text-sm font-semibold rounded-xl shadow-xs transition-colors">
					<i data-lucide="plus" class="w-4 h-4"></i>
					<span>Buat Lowongan</span>
				</a>
			</div>
		</div>

		<div class="bg-white border border-slate-200 rounded-2xl shadow-xs overflow-hidden">
			<div class="overflow-x-auto">
				<table class="w-full text-left border-collapse">
					<thead>
						<tr
							class="bg-slate-50 border-b border-slate-200 text-slate-500 font-semibold text-[11px] uppercase tracking-wider">
							<th class="py-3 px-4 w-12 text-center">No</th>
							<th class="py-3 px-4">Informasi Lowongan</th>
							<th class="py-3 px-4 w-32">Kandidat</th>
							<th class="py-3 px-4 w-36">Terbuat</th>
							<th class="py-3 px-4 w-40">Batas Waktu</th>
							<th class="py-3 px-4 w-32">Status</th>
							<th class="py-3 px-4 w-28 text-center">Aksi</th>
						</tr>
					</thead>
					<tbody class="divide-y divide-slate-200 text-xs text-slate-700">
						@forelse ($jobs as $index => $job)
							@php
								// Logika helper untuk status & batas waktu
								$isExpired = \Carbon\Carbon::parse($job->closing_date)->isPast();
								$status = strtolower($job->status); // aktif, tidak aktif, selesai
							@endphp
							<tr class="hover:bg-slate-50/80 transition-colors">

								<!-- 1. NO -->
								<td class="py-3.5 px-4 text-center font-medium text-slate-400">
									{{ $index + 1 }}
								</td>

								<!-- 2. INFORMASI LOWONGAN -->
								<td class="py-3.5 px-4">
									<div class="flex flex-col gap-0.5">
										<a href="{{ route('job.show', $job->id) }}"
											class="font-bold text-slate-800 hover:text-blue-600 text-sm transition-colors line-clamp-1">
											{{ $job->title }}
										</a>
										<div class="flex items-center gap-1.5 text-[11px] text-slate-500">
											<span>{{ $job->type ?? 'Management Trainee' }}</span>
											<span>•</span>
											<span>{{ $job->occupation ?? 'Administrasi' }}</span>
										</div>
									</div>
								</td>

								<!-- 3. KANDIDAT / PELAMAR -->
								<td class="py-3.5 px-4">
									<a href="{{ route('job.show', $job->id) }}"
										class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs font-semibold transition-colors">
										<i data-lucide="users" class="w-3.5 h-3.5 text-slate-500"></i>
										<span>{{ $job->applications->count() ?? 0 }} Pelamar</span>
									</a>
								</td>

								<!-- 4. TERBUAT (DIBUAT OLEH & TANGGAL) -->
								<td class="py-3.5 px-4">
									<div class="flex flex-col">
										<span
											class="font-medium text-slate-800">{{ \Carbon\Carbon::parse($job->created_at)->translatedFormat('d M Y') }}</span>
										<span class="text-[10px] text-slate-400 font-medium truncate max-w-[120px]"
											title="{{ $job->created_by ?? 'Admin' }}">
											{{ $job->created_by ?? 'HO' }}
										</span>
									</div>
								</td>

								<!-- 5. BATAS WAKTU -->
								<td class="py-3.5 px-4">
									<div class="flex flex-col">
										<span
											class="font-medium text-slate-800">{{ \Carbon\Carbon::parse($job->closing_date)->translatedFormat('d M Y') }}</span>
										@if ($isExpired)
											<span class="text-[10px] text-rose-500 font-semibold">Sudah Berakhir</span>
										@else
											<span class="text-[10px] text-amber-600 font-semibold">
												{{ \Carbon\Carbon::parse($job->closing_date)->diffForHumans() }}
											</span>
										@endif
									</div>
								</td>

								<!-- 6. STATUS BADGE -->
								<td class="py-3.5 px-4">
									@if ($isExpired || $status == 'selesai')
										<span
											class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200">
											<span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
											Selesai
										</span>
									@elseif($status == 'aktif')
										<span
											class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
											<span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
											Aktif
										</span>
									@else
										<span
											class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
											<span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
											Tidak Aktif
										</span>
									@endif
								</td>

								<!-- 7. AKSI (ACTION BUTTONS) -->
								<td class="py-3.5 px-4 text-center">
									<div class="flex items-center justify-center gap-1">
										<a href="{{ route('job.edit', $job->id) }}" title="Edit"
											class="p-1.5 text-slate-500 hover:text-amber-600 hover:bg-slate-100 rounded-lg transition-colors">
											<i data-lucide="pencil" class="w-4 h-4"></i>
										</a>
										<form action="{{ route('job.destroy', $job->id) }}" method="POST"
											class="inline">
											@csrf
											@method('DELETE')
											<button type="submit" title="Hapus"
												onclick="return confirm('Apakah Anda yakin ingin menghapus lowongan ini?')"
												class="p-1.5 text-slate-500 hover:text-rose-600 hover:bg-slate-100 rounded-lg transition-colors">
												<i data-lucide="trash-2" class="w-4 h-4"></i>
											</button>
										</form>
									</div>
								</td>

							</tr>
						@empty
							<tr>
								<td colspan="7" class="py-12 text-center text-slate-400">
									<div class="flex flex-col items-center justify-center gap-2">
										<i data-lucide="inbox" class="w-8 h-8 text-slate-300"></i>
										<p class="text-xs font-medium">Belum ada data lowongan pekerjaan yang terdaftar.</p>
									</div>
								</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>

	</div>
@endsection
