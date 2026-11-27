<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UI Design Preview — Input Message &amp; Validasi Form</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-slate-800 antialiased min-h-screen font-sans">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-10">

        <header class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-50 text-[#B11116] border border-red-100 mb-2">
                    DEV / UI PLAYGROUND
                </span>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">
                    Katalog Input Message &amp; Validasi Form
                </h1>
                <p class="text-sm text-slate-500 mt-1">
                    Perbandingan rekomendasi standar IMK (bagian atas) dengan seluruh gaya pesan di sekitar input yang saat ini ada di Sosro Career Hub (bagian bawah).
                </p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="#imk-input" class="px-3 py-1.5 rounded-lg text-xs font-bold bg-[#B11116] hover:bg-red-800 text-white transition">Rekomendasi IMK</a>
                <a href="#existing-counter" class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-700 transition">Counter Biodata</a>
                <a href="#existing-register" class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-700 transition">Register &amp; Login</a>
                <a href="#existing-sizes" class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-700 transition">Perbedaan Ukuran</a>
                <a href="#existing-other" class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-700 transition">Helper &amp; Tanpa Teks</a>
            </div>
        </header>

        <section id="imk-input" class="bg-white rounded-2xl border-2 border-[#B11116]/20 p-6 sm:p-7 shadow-sm space-y-6">
            <div class="space-y-1.5 pb-5 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                        REKOMENDASI STANDAR IMK / HCI
                    </span>
                    <span class="text-xs font-medium text-slate-400">Reward Early, Punish Late + WCAG 2.1 AA</span>
                </div>
                <h2 class="text-xl font-bold text-slate-900">
                    Desain Input Message yang Baik &amp; Benar (Coba Ketik Langsung di Bawah)
                </h2>
                <p class="text-xs text-slate-600 max-w-3xl leading-relaxed">
                    Setiap input cukup punya <strong>1 slot pesan</strong> (error menggantikan helper text agar tidak dobel), ukuran font seragam <strong>12px (`text-xs`)</strong>, warna helper kontras tinggi (<strong>`text-slate-500`</strong> bukan `gray-400`), ikon status agar ramah buta warna, dan validasi <strong>Reward Early, Punish Late</strong> (jangan langsung merah selagi user baru mengetik — tampilkan counter netral dulu, hijau begitu valid, baru merah saat pindah field / `blur`).
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 text-xs">
                <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/70">
                    <p class="font-bold text-slate-800">1. Reward Early, Punish Late</p>
                    <p class="text-slate-600 mt-0.5">Counter netral saat mengetik, langsung hijau saat valid, merah baru muncul saat <code class="text-[11px]">blur</code> / submit.</p>
                </div>
                <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/70">
                    <p class="font-bold text-slate-800">2. 1 Slot Pesan (Anti Dobel)</p>
                    <p class="text-slate-600 mt-0.5">Saat ada error, pesan error menggantikan helper text sehingga tidak bertumpuk 2 baris.</p>
                </div>
                <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/70">
                    <p class="font-bold text-slate-800">3. Kontras &amp; Ukuran Seragam</p>
                    <p class="text-slate-600 mt-0.5">Selalu <code class="text-[11px]">text-xs</code> (12px) + <code class="text-[11px]">text-slate-500</code> (WCAG AA), tidak ada lagi <code class="text-[11px]">text-[10px]</code> atau <code class="text-[11px]">gray-400</code>.</p>
                </div>
                <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/70">
                    <p class="font-bold text-slate-800">4. Ikon + Solusi Jelas</p>
                    <p class="text-slate-600 mt-0.5">Pesan error pakai ikon + solusi nyata (contoh: link <em>Masuk di sini</em> saat email sudah dipakai).</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-2">
                <div class="space-y-1.5">
                    <div class="flex items-center justify-between">
                        <label for="imk_nik" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                            NIK (Sesuai KTP) <span class="text-[#B11116]">*</span>
                        </label>
                        <span id="imk_nik_counter" class="text-xs font-semibold tabular-nums text-slate-500">0 / 16 digit</span>
                    </div>
                    <div class="relative">
                        <input id="imk_nik" type="text" inputmode="numeric" maxlength="16"
                            placeholder="Ketik 16 digit angka KTP..."
                            aria-describedby="imk_nik_msg"
                            class="w-full px-4 py-2.5 pr-10 bg-white rounded-xl border border-slate-300 text-slate-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-xs">
                        <span id="imk_nik_icon" class="hidden absolute inset-y-0 right-3 flex items-center pointer-events-none"></span>
                    </div>
                    <p id="imk_nik_msg" class="text-xs text-slate-500 flex items-center gap-1.5">
                        Masukkan 16 digit angka sesuai KTP. Coba ketik sebagian lalu klik di luar input.
                    </p>
                </div>

                <div class="space-y-1.5">
                    <label for="imk_email_error" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                        Alamat Email (Contoh Error Server) <span class="text-[#B11116]">*</span>
                    </label>
                    <div class="relative">
                        <input id="imk_email_error" type="email" value="budi.santoso@gmail.com" aria-invalid="true" aria-describedby="imk_email_msg"
                            class="w-full px-4 py-2.5 pr-10 bg-white rounded-xl border border-red-500 ring-2 ring-red-100 text-slate-900 text-sm outline-none shadow-xs">
                        <span class="absolute inset-y-0 right-3 flex items-center text-red-600 pointer-events-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                            </svg>
                        </span>
                    </div>
                    <p id="imk_email_msg" role="alert" class="text-xs text-red-600 font-medium flex items-start gap-1.5 leading-snug">
                        <svg class="w-3.5 h-3.5 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0 3.75h.008" />
                        </svg>
                        <span>Email ini sudah terdaftar. Gunakan email lain atau <a href="#imk-input" class="underline font-bold hover:text-red-800">Masuk di sini</a>.</span>
                    </p>
                </div>

                <div class="space-y-1.5">
                    <label for="imk_password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                        Password Baru (Live Checklist) <span class="text-[#B11116]">*</span>
                    </label>
                    <input id="imk_password" type="password" placeholder="Ketik password minimal 8 karakter..."
                        class="w-full px-4 py-2.5 bg-white rounded-xl border border-slate-300 text-slate-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-xs">
                    <div class="flex flex-wrap gap-x-4 gap-y-1 pt-0.5 text-xs">
                        <span id="imk_pw_len" class="inline-flex items-center gap-1 text-slate-500 transition-colors">
                            <span class="w-3.5 h-3.5 rounded-full border border-slate-300 inline-flex items-center justify-center text-[10px]">•</span>
                            Minimal 8 karakter
                        </span>
                        <span id="imk_pw_num" class="inline-flex items-center gap-1 text-slate-500 transition-colors">
                            <span class="w-3.5 h-3.5 rounded-full border border-slate-300 inline-flex items-center justify-center text-[10px]">•</span>
                            Mengandung angka
                        </span>
                    </div>
                </div>

                <div class="space-y-1.5">
                    <div class="flex items-center justify-between">
                        <label for="imk_email_locked" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                            Email Akun (Read-Only / Terkunci)
                        </label>
                        <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-slate-500">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                            </svg>
                            Terkunci
                        </span>
                    </div>
                    <input id="imk_email_locked" type="email" value="budi.santoso@gmail.com" readonly
                        class="w-full px-4 py-2.5 bg-slate-100 rounded-xl border border-slate-200 text-slate-600 text-sm cursor-not-allowed outline-none">
                    <p class="text-xs text-slate-500">Mengikuti email akun yang terdaftar dan tidak dapat diubah di biodata.</p>
                </div>

                <div class="space-y-1.5">
                    <div class="flex items-center justify-between">
                        <label for="imk_optional" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                            Username LinkedIn
                        </label>
                        <span class="text-xs font-normal text-slate-500">Opsional</span>
                    </div>
                    <input id="imk_optional" type="text" placeholder="Contoh: budi-santoso"
                        class="w-full px-4 py-2.5 bg-white rounded-xl border border-slate-300 text-slate-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-xs">
                    <p class="text-xs text-slate-500">Cukup tulis username saja tanpa https://linkedin.com/in/.</p>
                </div>

                <div class="space-y-1.5">
                    <label for="imk_valid" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                        Kode Pos (State Valid) <span class="text-[#B11116]">*</span>
                    </label>
                    <div class="relative">
                        <input id="imk_valid" type="text" value="17132" readonly
                            class="w-full px-4 py-2.5 pr-10 bg-white rounded-xl border border-emerald-500 text-slate-900 text-sm outline-none shadow-xs">
                        <span class="absolute inset-y-0 right-3 flex items-center text-emerald-600 pointer-events-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </span>
                    </div>
                    <p class="text-xs text-emerald-700 font-medium flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        Kode pos valid (5 digit).
                    </p>
                </div>
            </div>
        </section>

        <div class="flex items-center gap-4 pt-2">
            <div class="h-px flex-1 bg-slate-200"></div>
            <span class="text-xs font-bold uppercase tracking-widest text-slate-400">Input Message Existing di Web Anda Saat Ini</span>
            <div class="h-px flex-1 bg-slate-200"></div>
        </div>

        <section id="existing-counter" class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs space-y-5">
            <div class="pb-4 border-b border-slate-100">
                <h2 class="text-lg font-bold text-slate-900">1. Live Digit Counter di Biodata (NIK, No. HP, Kode Pos)</h2>
                <p class="text-xs text-slate-500 mt-0.5">
                    Sumber: <code class="px-1.5 py-0.5 bg-slate-100 rounded text-slate-700">biodata/create/biodata.blade.php</code> &amp; <code class="px-1.5 py-0.5 bg-slate-100 rounded text-slate-700">biodata/edit.blade.php</code>
                    — Catatan IMK: langsung merah saat baru ketik 1 digit (premature error) &amp; helper awal pakai <code class="px-1 py-0.5 bg-slate-100 rounded">text-[11px] text-gray-400</code> (kontras rendah).
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div class="space-y-1.5">
                    <label for="old_nik" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                        NIK (Sesuai KTP) <span class="text-[#B11116]">*</span>
                    </label>
                    <input id="old_nik" type="text" inputmode="numeric" maxlength="16" placeholder="Coba ketik angka..."
                        class="w-full px-4 py-2.5 bg-white rounded-xl border border-gray-300 text-gray-900 text-sm transition-all focus:border-[#B11116] focus:ring-2 focus:ring-red-100 outline-none shadow-sm">
                    <span id="old_msg_nik" class="text-[11px] text-gray-400 block transition-colors">Harus berisi 16 digit angka.</span>
                </div>

                <div class="space-y-1.5">
                    <label for="old_phone" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                        No. Telepon / WA <span class="text-[#B11116]">*</span>
                    </label>
                    <input id="old_phone" type="tel" inputmode="numeric" maxlength="15" value="081234"
                        class="w-full px-4 py-2.5 bg-white rounded-xl border border-red-500 text-gray-900 text-sm outline-none shadow-sm">
                    <span class="text-[11px] text-red-600 font-medium block">Minimal 10 digit angka (6/10 digit).</span>
                </div>

                <div class="space-y-1.5">
                    <label for="old_postal" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                        Kode Pos KTP
                    </label>
                    <input id="old_postal" type="text" value="17132" readonly
                        class="w-full px-4 py-2.5 bg-white rounded-xl border border-emerald-500 text-gray-900 text-sm outline-none shadow-sm">
                    <span class="text-[11px] text-emerald-600 font-medium block">✓ Kode pos valid (5 digit).</span>
                </div>
            </div>
        </section>

        <section id="existing-register" class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs space-y-5">
            <div class="pb-4 border-b border-slate-100">
                <h2 class="text-lg font-bold text-slate-900">2. Error Server + Helper Text Dobel &amp; Password Terpisah (Register)</h2>
                <p class="text-xs text-slate-500 mt-0.5">
                    Sumber: <code class="px-1.5 py-0.5 bg-slate-100 rounded text-slate-700">resources/views/guest/register.blade.php</code>
                    — Catatan IMK: saat email sudah dipakai, pesan error (<code class="px-1 py-0.5 bg-slate-100 rounded">text-sm</code>) &amp; helper text tampil bertumpuk; error password ditaruh di bawah grid terpisah dari inputnya.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block font-semibold text-gray-700 text-sm mb-1">Alamat Email</label>
                    <input type="email" value="budi.santoso@gmail.com" readonly
                        class="block w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 text-sm outline-none">
                    <p class="text-sm text-red-600 mt-1.5 font-medium">Email sudah terdaftar.</p>
                    <span class="text-xs text-gray-400 mt-1.5 block">Gunakan alamat email resmi yang aktif (contoh: nama@domain.com).</span>
                </div>

                <div class="space-y-3">
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block font-semibold text-gray-700 text-sm mb-1">Password</label>
                            <input type="password" value="12345" readonly
                                class="block w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 text-sm outline-none">
                            <span class="text-xs text-gray-400 mt-1 block">Minimal 8 karakter.</span>
                        </div>
                        <div>
                            <label class="block font-semibold text-gray-700 text-sm mb-1">Konfirmasi</label>
                            <input type="password" value="1234" readonly
                                class="block w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 text-sm outline-none">
                            <span class="text-xs text-gray-400 mt-1 block">Ulangi password di atas.</span>
                        </div>
                    </div>
                    <div class="space-y-1">
                        <p class="text-sm text-red-600 font-medium">Password minimal 8 karakter.</p>
                        <p class="text-sm text-red-600 font-medium">Konfirmasi password tidak cocok.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="existing-sizes" class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs space-y-5">
            <div class="pb-4 border-b border-slate-100">
                <h2 class="text-lg font-bold text-slate-900">3. Perbedaan 3 Ukuran Font Error di Halaman Berbeda</h2>
                <p class="text-xs text-slate-500 mt-0.5">
                    Saat ini ada 3 ukuran font error berbeda: <code class="px-1 py-0.5 bg-slate-100 rounded">text-sm</code> (Login/Register), <code class="px-1 py-0.5 bg-slate-100 rounded">text-xs</code> (Biodata/Keluarga/Pendidikan), dan <code class="px-1 py-0.5 bg-slate-100 rounded">text-[10px]</code> (Referensi Pengalaman Kerja).
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div class="space-y-1.5">
                    <label class="block font-semibold text-gray-700 text-sm">Login Admin (<code class="text-xs">text-sm</code>)</label>
                    <input type="email" value="salah@sosro.com" readonly class="block w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm">
                    <p class="text-sm text-red-600 mt-1.5 font-medium">Email atau kata sandi salah.</p>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Biodata (<code class="normal-case">text-xs</code>)</label>
                    <input type="text" value="" readonly placeholder="Nama Lengkap" class="w-full px-4 py-2.5 bg-white rounded-xl border border-red-500 ring-1 ring-red-500 text-sm">
                    <p class="text-xs text-red-600 font-medium mt-1">Nama lengkap wajib diisi.</p>
                </div>

                <div class="space-y-1">
                    <label class="block text-[11px] font-semibold text-gray-600">Referensi Kerja (<code>text-[10px]</code>)</label>
                    <input type="text" value="" readonly placeholder="Nama Referensi" class="w-full px-3 py-2 bg-white rounded-xl border border-red-500 ring-1 ring-red-500 text-xs">
                    <p class="text-[10px] text-red-600 font-medium">Nomor telepon referensi maksimal 20 karakter.</p>
                </div>
            </div>
        </section>

        <section id="existing-other" class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs space-y-5">
            <div class="pb-4 border-b border-slate-100">
                <h2 class="text-lg font-bold text-slate-900">4. Helper Text Admin &amp; Border Merah Tanpa Pesan Teks</h2>
                <p class="text-xs text-slate-500 mt-0.5">
                    Sumber: <code class="px-1.5 py-0.5 bg-slate-100 rounded text-slate-700">modal-email.blade.php</code>, <code class="px-1.5 py-0.5 bg-slate-100 rounded text-slate-700">admin/user/edit.blade.php</code>, dan Tinggi/Berat Badan di <code class="px-1.5 py-0.5 bg-slate-100 rounded text-slate-700">biodata.blade.php</code>.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div>
                    <label class="block mb-2 text-sm font-semibold text-slate-700">Request Code FPTK (Modal)</label>
                    <input type="text" placeholder="Contoh: RCR20261117235" readonly class="block w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm">
                    <p class="mt-1 text-xs text-slate-400">Kode FPTK dari HRIS yang akan disimpan ke data transfer HRIS.</p>
                </div>

                <div>
                    <label class="block mb-2 text-sm font-semibold text-slate-700">Password User (Admin Edit)</label>
                    <input type="password" placeholder="••••••••" readonly class="block w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm">
                    <p class="mt-1.5 text-xs text-slate-400 italic">Isi hanya jika ingin mengganti password user.</p>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Tinggi Badan (cm) — Tanpa Pesan</label>
                    <input type="number" value="50" readonly class="w-full px-4 py-2.5 bg-white rounded-xl border border-red-500 text-sm">
                    <span class="text-[11px] text-slate-400 block">(Di biodata sekarang cuma merah border-nya, tidak ada teks keterangan min 100–250 cm)</span>
                </div>
            </div>
        </section>

    </div>

    <x-notification />

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const imkNik = document.getElementById('imk_nik');
            const imkNikCounter = document.getElementById('imk_nik_counter');
            const imkNikMsg = document.getElementById('imk_nik_msg');
            const imkNikIcon = document.getElementById('imk_nik_icon');
            let nikTouched = false;

            const iconCheck = '<svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>';
            const iconError = '<svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" /></svg>';

            function updateImkNik(showErrorOnIncomplete) {
                imkNik.value = imkNik.value.replace(/[^0-9]/g, '');
                const len = imkNik.value.length;
                imkNikCounter.textContent = `${len} / 16 digit`;

                imkNik.classList.remove('border-slate-300', 'border-emerald-500', 'border-red-500', 'ring-2', 'ring-red-100');

                if (len === 16) {
                    imkNik.classList.add('border-emerald-500');
                    imkNik.removeAttribute('aria-invalid');
                    imkNikCounter.className = 'text-xs font-semibold tabular-nums text-emerald-700';
                    imkNikIcon.innerHTML = iconCheck;
                    imkNikIcon.classList.remove('hidden');
                    imkNikMsg.className = 'text-xs text-emerald-700 font-medium flex items-center gap-1.5';
                    imkNikMsg.innerHTML = `${iconCheck}<span>NIK valid (16 digit angka).</span>`;
                } else if (showErrorOnIncomplete && len > 0) {
                    imkNik.classList.add('border-red-500', 'ring-2', 'ring-red-100');
                    imkNik.setAttribute('aria-invalid', 'true');
                    imkNikCounter.className = 'text-xs font-semibold tabular-nums text-red-600';
                    imkNikIcon.innerHTML = iconError;
                    imkNikIcon.classList.remove('hidden');
                    imkNikMsg.className = 'text-xs text-red-600 font-medium flex items-center gap-1.5';
                    imkNikMsg.innerHTML = `${iconError}<span>NIK masih kurang ${16 - len} digit lagi (wajib 16 digit sesuai KTP).</span>`;
                } else {
                    imkNik.classList.add('border-slate-300');
                    imkNik.removeAttribute('aria-invalid');
                    imkNikCounter.className = 'text-xs font-semibold tabular-nums text-slate-500';
                    imkNikIcon.classList.add('hidden');
                    imkNikMsg.className = 'text-xs text-slate-500 flex items-center gap-1.5';
                    imkNikMsg.textContent = len === 0
                        ? 'Masukkan 16 digit angka sesuai KTP. Coba ketik sebagian lalu klik di luar input.'
                        : `Sedang mengetik — butuh ${16 - len} digit lagi (tidak langsung merah sebelum selesai).`;
                }
            }

            imkNik.addEventListener('input', () => updateImkNik(nikTouched));
            imkNik.addEventListener('blur', () => {
                if (imkNik.value.length > 0 && imkNik.value.length < 16) {
                    nikTouched = true;
                    updateImkNik(true);
                }
            });

            const imkPw = document.getElementById('imk_password');
            const imkPwLen = document.getElementById('imk_pw_len');
            const imkPwNum = document.getElementById('imk_pw_num');

            function setCheck(el, ok, label) {
                el.className = ok
                    ? 'inline-flex items-center gap-1 text-emerald-700 font-medium transition-colors'
                    : 'inline-flex items-center gap-1 text-slate-500 transition-colors';
                el.innerHTML = ok
                    ? `<span class="w-3.5 h-3.5 rounded-full bg-emerald-600 text-white inline-flex items-center justify-center text-[10px]">✓</span>${label}`
                    : `<span class="w-3.5 h-3.5 rounded-full border border-slate-300 inline-flex items-center justify-center text-[10px]">•</span>${label}`;
            }

            imkPw.addEventListener('input', () => {
                setCheck(imkPwLen, imkPw.value.length >= 8, 'Minimal 8 karakter');
                setCheck(imkPwNum, /[0-9]/.test(imkPw.value), 'Mengandung angka');
            });

            const oldNik = document.getElementById('old_nik');
            const oldMsgNik = document.getElementById('old_msg_nik');
            oldNik.addEventListener('input', () => {
                oldNik.value = oldNik.value.replace(/[^0-9]/g, '');
                const len = oldNik.value.length;
                oldNik.classList.remove('border-gray-300', 'border-red-500', 'border-emerald-500');
                if (len === 0) {
                    oldNik.classList.add('border-gray-300');
                    oldMsgNik.className = 'text-[11px] text-gray-400 block transition-colors';
                    oldMsgNik.textContent = 'Harus berisi 16 digit angka.';
                } else if (len < 16) {
                    oldNik.classList.add('border-red-500');
                    oldMsgNik.className = 'text-[11px] text-red-600 font-medium block transition-colors';
                    oldMsgNik.textContent = `Masih kurang ${16 - len} digit lagi (${len}/16 digit).`;
                } else {
                    oldNik.classList.add('border-emerald-500');
                    oldMsgNik.className = 'text-[11px] text-emerald-600 font-medium block transition-colors';
                    oldMsgNik.textContent = '✓ NIK valid (16 digit).';
                }
            });
        });
    </script>
</body>

</html>
