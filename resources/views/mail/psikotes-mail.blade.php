<div>
    <p>Selamat Pagi {{ $application->applicant?->name ?? 'Kandidat' }},</p>

    <p>
        Dengan ini kami dari PT. Sinar Sosro Gunung Slamat mengundang Saudara/i untuk mengikuti Seleksi Psikotes secara online yang dapat diakses melalui laptop/gadget pribadi Anda, dengan <strong>estimasi waktu pengerjaan 2-3 jam. Psikotes online akan dilaksanakan pada :</strong>
    </p>

    <p><strong>Tanggal : {{ $date ? \Carbon\Carbon::parse($date)->locale('id')->isoFormat('dddd, D MMMM Y') : 'Fleksibel / Sesuai Jadwal' }}</strong></p>
    <p><strong>Waktu : {{ $time ?? '08:00 - 17:00 WIB' }}</strong></p>
    <p><strong>Link Psikotes : <a href="{{ $link ?? 'https://joinsosro.com/psikotest' }}">{{ $link ?? 'joinsosro.com/psikotest' }}</a></strong></p>
    <p>
        <strong>KODE TES : {{ $code ?? '(Untuk mendapatkan KODE TES, Anda dapat melihat pada menu Riwayat Lamaran akun Sosro Career Anda)' }}</strong>
    </p>

    <p><strong>Berikut kami sampaikan beberapa informasi mengenai Psikotes Online tersebut :</strong></p>
    <ol>
        <li>Silakan buka link Psikotes terlampir pada laptop pribadi Anda.</li>
        <li>Gunakan <strong>KODE TES</strong> untuk login, masukkan password (password bebas yang Anda buat sendiri) kemudian lengkapi data diri Anda.</li>
        <li><strong>KODE TES</strong> pada poin ke-2 dapat diakses pada pukul 08:00 WIB - 17:00 WIB (di luar jam tersebut kode tidak dapat diakses).</li>
        <li>Pastikan koneksi internet yang Anda gunakan stabil serta akses kamera dan lokasi (GPS) sudah diaktifkan.</li>
    </ol>

    <p><strong>KETENTUAN PSIKOTES ONLINE :</strong></p>
    <ol>
        <li>Tes dikerjakan dengan Laptop dan menggunakan browser Mozilla Firefox atau Google Chrome, serta tutup semua tab search selain tes ini.</li>
        <li>Pastikan bahwa kamera laptop dan lokasi Anda tetap menyala selama proses psikotes berlangsung.</li>
        <li>Pastikan Anda mengerjakan tes ini secara individual, tanpa adanya bantuan dari pihak manapun.</li>
        <li>Tes akan terdiri dari tes inteligensi dan tes kepribadian. Harap perhatikan dengan seksama instruksi dari setiap soal masing-masing bagian tes.</li>
        <li>Untuk tes kepribadian, tidak ada jawaban benar atau salah. Silakan memilih jawaban secara spontan yang paling menggambarkan diri Anda.</li>
        <li>Apabila terjadi kendala saat mengerjakan tes, silakan refresh browser yang Anda gunakan dan dapat login kembali dengan kode yang sama dan password yang sebelumnya telah dibuat.</li>
        <li>Pastikan Anda menyelesaikan setiap sesi tes dan klik Jawab/Selesai.</li>
        <li>Segala upaya kecurangan dapat terdeteksi dan dapat mengakibatkan Anda tidak dapat melanjutkan proses di PT Sinar Sosro Gunung Slamat. Oleh karena itu percayalah pada kemampuan diri Anda sendiri.</li>
    </ol>

    <p>Regards,</p>

    <p>
        HC-OD &amp; Recruitment<br>
        PT. Sinar Sosro Gunung Slamat<br>
        Graha Rekso Lt.8<br>
        Jl. Bulevard Artha Gading No.Kav.A1<br>
        RT.18/RW.8, Klp. Gading Bar., Kec. Klp. Gading<br>
        Jakarta Utara, DKI Jakarta 14240<br>
        Email : <a href="mailto:recruitment.ho@sosro.com">recruitment.ho@sosro.com</a>
    </p>
</div>
