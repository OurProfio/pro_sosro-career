<div>
    <p>Selamat pagi Bapak/Ibu,</p>

    <p>Kami dari tim HC – Recruitment PT Sinar Sosro Gunung Slamat memohon konfirmasi Bapak/Ibu atas kandidat berikut:</p>

    <p>
        Nama kandidat: <strong>{{ $confirmation->application->applicant?->name }}</strong><br>
        Posisi: <strong>{{ $confirmation->application->job->title }}</strong><br>
        Penempatan: <strong>{{ $confirmation->application->job->office?->name }}</strong>
    </p>

    <p>Klik tombol di bawah ini untuk melihat profil kandidat dan memberikan keputusan:</p>

    <p>
        <a href="{{ $url }}" style="display: inline-block; padding: 12px 24px; background-color: #dc2626; color: #ffffff; text-decoration: none; border-radius: 6px; font-weight: bold;">Lihat &amp; Beri Keputusan</a>
    </p>

    <p>Link ini berlaku selama 7 hari.</p>

    <p>Salam,<br>
        HC – Recruitment<br>
        PT Sinar Sosro Gunung Slamat
    </p>

    <p><em>Email ini dikirim otomatis oleh sistem. Mohon tidak dibalas.</em></p>
</div>
