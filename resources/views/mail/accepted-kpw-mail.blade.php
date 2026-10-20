<div>
    <p>Selamat pagi {{ $application->applicant?->name ?? 'Kandidat' }},</p>

    <p>Selamat bergabung di PT Sinar Sosro Gunung Slamat sebagai {{ $application->job->title }}. Hari pertama kerja Anda akan dimulai pada {{ \Carbon\Carbon::parse($startDate)->locale('id')->translatedFormat('l, d F Y') }}.</p>

    <p>Mohon membawa berkas ASLI KTP, Kartu Keluarga, Akta Kelahiran, Ijazah, Transkrip Nilai, Buku Nikah dan SIM (jika ada) untuk dilakukan pengecekan.</p>

    <p>Pada hari pertama ke kantor, silakan hadir pukul 08.00 WIB di {{ $workAddress }} mengenakan pakaian batik dan menginformasikan ke satpam untuk hari pertama masuk kerja dan akan bertemu dengan tim Recruitment.</p>

    <p><strong>Jam kerja</strong><br>
        <strong>Senin–Jumat:</strong> 08.00–16.00 WIB<br>
        <strong>Sabtu:</strong> 08.00–13.00 WIB
    </p>

    <p><strong>Ketentuan pakaian</strong><br>
        <strong>Senin–Kamis:</strong> kemeja bebas, celana kain/jeans, sepatu tertutup<br>
        <strong>Jumat:</strong> kemeja batik, celana kain/jeans, sepatu tertutup<br>
        <strong>Sabtu:</strong> kemeja bebas, celana kain/jeans, sepatu tertutup
    </p>

    <p>Salam,<br>
        HC-OD &amp; Recruitment<br>
        PT Sinar Sosro Gunung Slamat
    </p>

    <p><em>Email ini dikirim otomatis oleh sistem. Mohon tidak dibalas.</em></p>
</div>
