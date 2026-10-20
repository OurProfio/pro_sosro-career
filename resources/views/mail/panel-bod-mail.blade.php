<div>
    <p>Selamat pagi {{ $application->applicant?->name ?? 'Kandidat' }},</p>

    <p>Selamat, Anda lolos ke tahap interview bersama jajaran direksi (Panel BOD) untuk Management Trainee yang akan dilaksanakan pada:</p>

    <p>
        <strong>Tanggal:</strong> {{ $date ? \Carbon\Carbon::parse($date)->locale('id')->translatedFormat('l, d F Y') : 'Akan diinformasikan lebih lanjut' }}<br>
        <strong>Waktu:</strong> {{ $time ? $time.' WIB' : 'Akan diinformasikan lebih lanjut' }}
    </p>

    <p>Mohon dapat bergabung 10 menit sebelum jadwal yang ditentukan dan mengenakan pakaian sopan dan rapi. Tim HR akan menghubungi Anda melalui WhatsApp untuk mengonfirmasi kehadiran dan mengirimkan link ataupun lokasi interview.</p>

    <p>Salam,<br>
        HC – Recruitment<br>
        PT Sinar Sosro Gunung Slamat
    </p>

    <p><em>Email ini dikirim otomatis oleh sistem. Mohon tidak dibalas.</em></p>
</div>
