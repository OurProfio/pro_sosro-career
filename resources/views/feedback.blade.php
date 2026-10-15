<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback & Kritik Saran - Sosro Career Hub</title>

    <!-- Google Font: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        @include('auth.admin.layouts.components.style')
    @endif
</head>

<body class="bg-[#F8F9FA] text-[#141D23] font-sans antialiased min-h-screen py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center mb-3">
                <img src="{{ asset('assets/images/SGS Logo-Color.webp') }}" class="h-10 w-auto" alt="Logo Sosro" />
            </div>
            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-[#FDF2F2] text-[#B42C33] border border-[#B42C33]/20 mb-2">
                Fitur Sementara
            </span>
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900">
                Kritik & Saran Sistem
            </h1>
            <p class="mt-2 text-sm text-slate-500 max-w-md mx-auto">
                Bantu kami menyempurnakan Sosro Career Hub. Ceritakan kendala, kritik, atau ide perbaikan yang Anda temukan.
            </p>
        </div>

        <!-- Success Alert -->
        @if (session('success'))
            <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-start gap-3 shadow-xs">
                <svg class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="flex-1">
                    <p class="font-semibold">Berhasil Terkirim</p>
                    <p class="text-xs text-emerald-700 mt-0.5">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <!-- Error Summary -->
        @if ($errors->any())
            <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-sm flex items-start gap-3 shadow-xs">
                <svg class="w-5 h-5 text-rose-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <div class="flex-1">
                    <p class="font-semibold">Mohon periksa formulir</p>
                    <p class="text-xs text-rose-700 mt-0.5">{{ $errors->first() }}</p>
                </div>
            </div>
        @endif

        <!-- Card Form -->
        <div class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-sm">
            <form action="{{ route('feedback.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Upload Screenshot (Optional) -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label for="screenshot" class="block text-sm font-semibold text-slate-800">
                            Screenshot Tampilan
                        </label>
                        <span class="text-xs text-slate-400 font-normal">Opsional (bisa dikosongkan)</span>
                    </div>

                    <div id="drop-zone" class="relative group border-2 border-dashed border-slate-200 hover:border-[#B42C33] rounded-2xl p-5 text-center transition-all bg-slate-50/50 hover:bg-[#FDF2F2]/30 cursor-pointer">
                        <input type="file" name="screenshot" id="screenshot" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" onchange="previewImage(event)">

                        <div id="preview-placeholder" class="flex flex-col items-center justify-center gap-2 pointer-events-none">
                            <div class="w-12 h-12 rounded-2xl bg-white text-slate-400 group-hover:text-[#B42C33] flex items-center justify-center shadow-xs border border-slate-100 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <p class="text-xs font-semibold text-slate-700">
                                Klik atau tarik gambar screenshot ke sini
                            </p>
                            <p class="text-[11px] text-slate-400">
                                Format PNG, JPG, JPEG, atau WEBP (Maksimal 5MB)
                            </p>
                        </div>

                        <!-- Image Preview Container -->
                        <div id="preview-container" class="hidden flex-col items-center justify-center gap-3">
                            <img id="image-preview" src="#" alt="Preview Screenshot" class="max-h-56 rounded-xl border border-slate-200 shadow-xs object-contain" />
                            <p id="file-name" class="text-xs font-medium text-slate-600 truncate max-w-xs"></p>
                            <span class="text-[11px] text-[#B42C33] underline font-semibold">Ganti Gambar</span>
                        </div>
                    </div>

                    @error('screenshot')
                        <p class="mt-1.5 text-xs text-rose-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Textarea Penjelasan -->
                <div>
                    <label for="notes" class="block text-sm font-semibold text-slate-800 mb-2">
                        Penjelasan Kritik / Saran <span class="text-[#B42C33]">*</span>
                    </label>
                    <textarea
                        name="notes"
                        id="notes"
                        rows="5"
                        placeholder="Jelaskan secara detail apa yang membuat Anda kurang puas, kendala yang dialami, atau rekomendasi ide perbaikan..."
                        class="w-full px-4 py-3 text-sm bg-white rounded-2xl border border-slate-200 text-slate-800 placeholder:text-slate-400 focus:outline-none focus:border-[#B42C33] focus:ring-2 focus:ring-[#B42C33]/15 transition-all shadow-xs resize-y"
                        required>{{ old('notes') }}</textarea>

                    @error('notes')
                        <p class="mt-1.5 text-xs text-rose-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Action Button -->
                <div class="pt-2">
                    <button type="submit"
                        class="w-full inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-[#B42C33] hover:bg-[#92101e] active:bg-[#780d19] text-white text-sm font-semibold rounded-2xl shadow-sm hover:shadow transition-all duration-200 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                        <span>Kirim Kritik & Saran</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Footer note -->
        <p class="text-center text-xs text-slate-400 mt-6">
            Halaman ini adalah utilitas pengujian internal sementara (akses langsung via URL).
        </p>
    </div>

    <script>
        function previewImage(event) {
            const input = event.target;
            const previewPlaceholder = document.getElementById('preview-placeholder');
            const previewContainer = document.getElementById('preview-container');
            const imagePreview = document.getElementById('image-preview');
            const fileName = document.getElementById('file-name');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    fileName.textContent = input.files[0].name;
                    previewPlaceholder.classList.add('hidden');
                    previewContainer.classList.remove('hidden');
                    previewContainer.classList.add('flex');
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>

</html>
