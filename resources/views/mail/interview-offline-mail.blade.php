<div>
    <p>Selamat Pagi {{ $application->applicant->name }},</p>

    <p>
        Melanjutkan proses rekrutmen yang sudah anda laksanakan sebelumnya, melalui pemberitahuan ini kami mengundang Anda untuk dapat mengikuti proses interview dengan PT Sinar Sosro Gunung Slamat pada:
    </p>

    <p><strong>Tanggal : {{ \Carbon\Carbon::parse($date)->locale('id')->translatedFormat('l, d F Y') }}</strong></p>
    <p><strong>Waktu : {{ $time }} WIB</strong></p>
    <p><strong>Alamat : {{ $address }}</strong></p>

    <p>Pada saat proses interview, baik pria/wanita mengenakan pakaian rapi dan sopan.</p>

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
