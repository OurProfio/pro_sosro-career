<div>
    <p>Selamat pagi {{ $application->applicant?->name ?? 'Kandidat' }},</p>

    <p>Melanjutkan proses seleksi untuk posisi {{ $application->job->title }}, Anda kami undang untuk mengikuti interview online pada:</p>

    <p>
        <strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($date)->locale('id')->translatedFormat('l, d F Y') }}<br>
        <strong>Waktu:</strong> {{ $time }} WIB<br>
        <strong>Media:</strong> Online (Zoom / Google Meet)<br>
        <strong>Link:</strong> <a href="{{ $link }}">{{ $link }}</a>
    </p>

    <p>Mohon bergabung 5 hingga 10 menit sebelum jadwal, pastikan koneksi internet stabil dan kamera aktif, serta kenakan pakaian rapi dan sopan.</p>

    <p>Salam,<br>
        HC – Recruitment<br>
        PT Sinar Sosro Gunung Slamat
    </p>

    <p><em>Email ini dikirim otomatis oleh sistem. Mohon tidak dibalas.</em></p>
</div>
