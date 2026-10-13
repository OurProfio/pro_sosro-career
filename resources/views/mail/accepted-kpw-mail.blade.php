<div>
    <p>Selamat Pagi {{ $application->applicant->name }},</p>

    <p>Dengan ini kami mengucapkan Selamat Bergabung di PT Sinar Sosro Gunung Slamat untuk posisi :</p>

    <p><strong>Jabatan : {{ $application->job->title }}</strong></p>
    <p><strong>Lokasi Kerja : {{ $application->job->location }}</strong></p>

    <p>Hari pertama kerja Anda akan dimulai pada:</p>

    <p><strong>Tanggal : {{ \Carbon\Carbon::parse($startDate)->locale('id')->translatedFormat('l, d F Y') }}</strong></p>

    <p>Mengenai jam kerja dan ketentuan lain diantaranya sebagai berikut :</p>

    <p><strong>Senin – Jumat : Pukul 08.00 – 16.00</strong></p>
    <p><strong>Sabtu : Pukul 08.00 – 13.00</strong></p>
    <p><strong>Senin – Kamis : Memakai kemeja bebas, celana kain/jeans, dan sepatu tertutup</strong></p>
    <p><strong>Jumat : Memakai kemeja batik, celana kain/jeans, dan sepatu tertutup</strong></p>
    <p><strong>Sabtu : Memakai kemeja bebas, celana kain/jeans, dan sepatu tertutup</strong></p>

    <p>
        Pada hari pertama ke kantor. Silakan hadir <strong>sebelum</strong> pukul <strong>08.00</strong> di <strong>{{ $workAddress }}</strong> mengenakan pakaian kemeja batik dan menginformasikan ke satpam untuk hari pertama kerja dan akan bertemu dengan Tim Rekrutment PT.Sinar Sosro Gunung Slamat
    </p>

    <p>Demikian informasi ini kami sampaikan. Atas perhatian dan kerja samanya kami ucapkan terima kasih</p>

    <p>Regards,</p>

    <p>
        HC-OD &amp; Recruitment<br>
        PT.Sinar Sosro Gunung Slamat<br>
        Graha Rekso Lt.8<br>
        Jl. Bulevard Artha Gading No.Kav.A1<br>
        RT.18/RW.8, Klp. Gading Bar., Kec. Klp. Gading<br>
        Jakarta Utara, DKI Jakarta 14240<br>
        Email : <a href="mailto:recruitment.ho@sosro.com">recruitment.ho@sosro.com</a>
    </p>
</div>
