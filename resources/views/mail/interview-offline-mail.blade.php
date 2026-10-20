<div>
    <p>Selamat pagi {{ $application->applicant?->name ?? 'Kandidat' }},</p>

    <p>Melanjutkan proses seleksi untuk posisi {{ $application->job->title }}, Anda kami undang untuk mengikuti interview offline pada:</p>

    <p>
        <strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($date)->locale('id')->translatedFormat('l, d F Y') }}<br>
        <strong>Waktu:</strong> {{ $time }} WIB<br>
        <strong>Alamat:</strong> {{ $address }}
    </p>

    <p>Mohon hadir 15 menit sebelum jadwal, bawa KTP dan kenakan pakaian rapi dan sopan. Sesampainya di lokasi, silakan menginformasikan kepada petugas bahwa Anda akan mengikuti interview di PT Sinar Sosro Gunung Slamat.</p>

    <p>Salam,<br>
        HC – Recruitment<br>
        PT Sinar Sosro Gunung Slamat
    </p>

    <p><em>Email ini dikirim otomatis oleh sistem. Mohon tidak dibalas.</em></p>
</div>
