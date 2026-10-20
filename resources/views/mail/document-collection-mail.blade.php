<div>
    <p>Selamat pagi {{ $application->applicant?->name ?? 'Kandidat' }},</p>

    <p>Selamat! Anda dinyatakan LOLOS tahap Medical Check Up. Langkah berikutnya, mohon lengkapi berkas pada profile website karir kami:</p>

    <p>
        <a href="{{ route('biodata.index') }}" style="display: inline-block; padding: 12px 24px; background-color: #dc2626; color: #ffffff; text-decoration: none; border-radius: 6px; font-weight: bold;">Lengkapi Berkas</a>
    </p>

    <p>Anda akan diminta login terlebih dahulu. Batas pengumpulan kelengkapan berkas adalah {{ $deadline ? \Carbon\Carbon::parse($deadline)->locale('id')->translatedFormat('l, d F Y H:i').' WIB' : 'akan diinformasikan lebih lanjut' }}. Pastikan semua dokumen hasil scan terbaca dengan jelas.</p>

    <p>Salam,<br>
        HC – Recruitment<br>
        PT Sinar Sosro Gunung Slamat
    </p>

    <p><em>Email ini dikirim otomatis oleh sistem. Mohon tidak dibalas.</em></p>
</div>
