<div>
    <p>Selamat pagi {{ $application->applicant?->name ?? 'Kandidat' }},</p>

    <p>
        Terima kasih telah melamar pada posisi {{ $application->job->title }} di PT Sinar Sosro Gunung Slamat. Anda kami undang untuk mengikuti psikotes online dengan detail sebagai berikut:
    </p>

    <p>
        <strong>Periode Tes:</strong> {{ $date ? \Carbon\Carbon::parse($date)->locale('id')->translatedFormat('l, d F Y') : 'Sesuai jadwal yang diinformasikan' }}<br>
        <strong>Durasi:</strong> ± 2 – 3 Jam<br>
        <strong>Link Tes:</strong> <a href="{{ $link ?? 'https://joinsosro.com/psikotest' }}">{{ $link ?? 'joinsosro.com/psikotest' }}</a>
        @if ($code)
            <br>
            <strong>Kode Tes:</strong> {{ $code }}
        @endif
    </p>

    <p>Anda bisa mengerjakan tes kapan saja selama periode di atas, dapat diakses hingga 23.00 WIB pada hari terakhir periode tes. Setelah periode berakhir, link tes tidak dapat diakses kembali.</p>

    <p><strong>Ketentuan Psikotes Online</strong></p>
    <ol>
        <li>Tes dikerjakan dengan Laptop dan menggunakan browser Mozilla Firefox atau Google Chrome dan tutup semua tab search selain tes ini.</li>
        <li>Pastikan koneksi internet yang Anda gunakan stabil dan akses kamera serta location sudah diaktifkan.</li>
        <li>Pastikan Anda mengerjakan Tes ini secara individual, tanpa adanya bantuan dari pihak manapun.</li>
        <li>Tes akan terdiri dari tes inteligensi dan tes kepribadian. Harap perhatikan dengan seksama instruksi dari setiap soal dari masing-masing bagian tes.</li>
        <li>Untuk tes kepribadian, tidak ada jawaban benar atau salah. Silakan memilih jawaban secara spontan yang paling menggambarkan diri Anda.</li>
        <li>Apabila terjadi kendala saat mengerjakan tes, silakan refresh browser yang Anda gunakan dan dapat login kembali dengan kode yang sama dan password yang sebelumnya telah dibuat.</li>
        <li>Pastikan Anda menyelesaikan setiap sesi tes dan klik “Jawab/Selesai”.</li>
        <li>Segala upaya kecurangan dapat terdeteksi dan dapat mengakibatkan Anda tidak dapat melanjutkan proses di PT Sinar Sosro Gunung Slamat, oleh karena itu percayalah pada kemampuan diri Anda sendiri, karena percaya diri adalah kunci kesuksesan.</li>
    </ol>

    <p>Semoga sukses!</p>

    <p>Salam,<br>
        HC – Recruitment<br>
        PT Sinar Sosro Gunung Slamat
    </p>

    <p><em>Email ini dikirim otomatis oleh sistem. Mohon tidak dibalas.</em></p>
</div>
