<div>
    <p>Selamat pagi {{ $application->applicant?->name ?? 'Kandidat' }},</p>

    <p>Melanjutkan proses seleksi untuk posisi {{ $application->job->title }}, kami mengundang Anda untuk mengikuti Medical Check Up (MCU) pada:</p>

    <p>
        <strong>Hari/tanggal:</strong> {{ $date ? \Carbon\Carbon::parse($date)->locale('id')->translatedFormat('l, d F Y') : 'Akan diinformasikan lebih lanjut' }}<br>
        <strong>Waktu:</strong> {{ $time ?? '08:00' }} WIB<br>
        <strong>Tempat:</strong> {{ $location ?? 'RS / Klinik Rekanan PT Sinar Sosro' }}<br>
        <strong>Alamat:</strong> {{ $address ?? '-' }}
    </p>

    <p><strong>Tanggal : {{ $date ? \Carbon\Carbon::parse($date)->locale('id')->isoFormat('dddd, D MMMM Y') : 'Akan diinformasikan lebih lanjut' }}</strong></p>
    <p><strong>Waktu : {{ $time ?? '08:00 WIB' }}</strong></p>
    <p><strong>Tempat : {{ $location ?? 'RS / Klinik Rekanan PT Sinar Sosro Gunung Slamat' }}</strong></p>
    <p><strong>Alamat : {{ $address ?? '-' }}</strong></p>
    <p>Untuk surat pengantar MCU akan kami kirimkan ke pihak RS/Klinik, sehingga Anda cukup langsung datang ke bagian MCU dengan membawa KTP dan menginformasikan dari PT Sinar Sosro Gunung Slamat.</p>

    <p>Salam,<br>
        HC – Recruitment<br>
        PT Sinar Sosro Gunung Slamat
    </p>

    <p><em>Email ini dikirim otomatis oleh sistem. Mohon tidak dibalas.</em></p>
</div>
