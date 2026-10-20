<div>
    <p>Selamat pagi {{ $application->applicant?->name ?? 'Kandidat' }},</p>

    <p>Sebagai bagian dari proses seleksi untuk Management Trainee, Anda diminta untuk mengerjakan studi kasus dengan topik berikut:</p>

    <p><strong>“{{ $topic ?? '-' }}”</strong></p>

    <p>Silakan buat materi mengenai topik tersebut dengan ketentuan sebagai berikut:</p>

    <p>
        <strong>Batas pengumpulan:</strong> {{ $deadline ? \Carbon\Carbon::parse($deadline)->locale('id')->translatedFormat('l, d F Y H:i').' WIB' : 'Akan diinformasikan lebih lanjut' }}<br>
        <strong>Pengumpulan:</strong> @if ($link)<a href="{{ $link }}">{{ $link }}</a>@else - @endif<br>
        <strong>Format jawaban:</strong> PDF / PPT maksimal 10 slide, max 10 MB
    </p>

    <p>Mohon dikumpulkan tepat waktu sesuai dengan jam yang telah disepakati. Jawaban yang dikumpulkan setelah batas waktu tidak dapat kami proses.</p>

    <p>Semangat dan semoga sukses!</p>

    <p>Salam,<br>
        HC – Recruitment<br>
        PT Sinar Sosro Gunung Slamat
    </p>

    <p><em>Email ini dikirim otomatis oleh sistem. Mohon tidak dibalas.</em></p>
</div>
