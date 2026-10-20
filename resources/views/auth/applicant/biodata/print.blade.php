<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=794">
<title>{{ trim(implode(' - ', array_filter(['Formulir Biodata Calon Karyawan', mb_strtoupper($applicant->name, 'UTF-8'), !empty($jobTitle) ? mb_strtoupper($jobTitle, 'UTF-8') : '']))) }}</title>
<style>
@page{size:A4;margin:0}
*{box-sizing:border-box}
body{margin:0;background:#d9d9d9;font:12.5px/1.2 Carlito,Calibri,Arial,sans-serif;color:#000;-webkit-print-color-adjust:exact;print-color-adjust:exact}
.pg{width:210mm;height:296.6mm;margin:14px auto;background:#fff;position:relative;overflow:hidden;padding:118px 74px 0 72px;box-shadow:0 0 6px #0004}
.fn{position:absolute;right:74px;top:12px;width:178px;height:22px;border:1px solid #000;box-shadow:1px 1px 0 #000;font-weight:bold;font-size:11px;line-height:20px;text-align:center;z-index:2}
.lg{position:absolute;left:72px;right:74px;top:2.5rem;height:auto}
.lg img{width:100%;height:auto;display:block}
.pn{position:absolute;right:46px;bottom:22px;font-size:10px}
.ttl{text-align:center;font-weight:bold;font-size:15px;line-height:20px;margin-top:12px}
.hr{border-top:1px solid #000;margin-top:5px}
input[type=text],textarea{font:inherit;color:#000;border:0;border-bottom:1px solid #000;background:none;height:16px;padding:0 2px;outline:0;border-radius:0;min-width:0;text-transform:uppercase;pointer-events:none}
input[type=checkbox]{margin:0 4px 0 0;width:11px;height:11px;vertical-align:-1px;pointer-events:none}
.r{display:flex;align-items:flex-end;height:18px;margin:0 40px 0 30px}
.r>.l{width:131px;flex:none}.r>.c{width:8px;flex:none}
.f{flex:1}
.w{flex:none}
.g{display:flex;align-items:flex-end}
.s.x{text-decoration:line-through}
i.sm{font-size:10px}
table{border-collapse:collapse;table-layout:fixed;width:692px;margin-left:-18px}
td,th{border:1px solid #000;padding:1px 3px;font-size:10.5px;text-align:left;vertical-align:middle;word-break:break-word;overflow-wrap:anywhere;white-space:normal;height:auto}
th{text-align:center;font-weight:bold;padding:2px 0}
td div.cell-data{outline:0;min-height:14px;word-break:break-word;overflow-wrap:anywhere;white-space:normal;line-height:1.2;text-transform:uppercase;pointer-events:none}
.t2{width:606px;margin-left:19px}
.jr{display:flex;align-items:flex-end;height:18px;margin:0 5px 0 36px;position:relative}
.jr .n{position:absolute;left:-26px}
.jr .l{width:143px;flex:none}.jr .c{width:8px;flex:none}
.jy{display:flex;align-items:flex-end;height:18px;margin-left:19px}
.jy .t{width:46px;flex:none;font-size:12px}
.jy .l{width:150px;flex:none;box-sizing:border-box}.jy .c{width:8px;flex:none}
.q{display:flex;align-items:flex-end;height:19px;margin-left:30px}
.q input{flex:1;margin-left:3px;pointer-events:none}
.np{position:fixed;right:20px;top:20px;background:#B11116;color:#fff;border:0;border-radius:8px;padding:8px 16px;font:bold 13px sans-serif;cursor:pointer;z-index:9999;box-shadow:0 4px 12px rgba(0,0,0,0.25);transition:background .2s;pointer-events:auto}
.np:hover{background:#940e13}
@media print{body{background:#fff}.pg{margin:0;box-shadow:none;break-after:page}.np{display:none}}
</style>
</head>
<body>
<button type="button" class="np" onclick="window.print()">🖨️ Cetak / Simpan PDF</button>
@php
    $u = fn ($v) => mb_strtoupper((string) ($v ?? ''), 'UTF-8');
    $bulanIndo = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
    ];

    $fmtDate = function ($d) use ($bulanIndo, $u) {
        if (!$d) return '';
        try {
            $c = \Carbon\Carbon::parse($d);
            $m = $bulanIndo[(int) $c->format('n')] ?? $c->format('F');
            return $u($c->format('j') . ' ' . $m . ' ' . $c->format('Y'));
        } catch (\Throwable $e) {
            return $u((string) $d);
        }
    };

    $esc = fn ($v) => e($u($v));
    // $I(lebar|null, nilai): kolom isian bergaris bawah
    $I = fn ($w = null, $v = '') => '<input type="text" class="' . ($w ? 'w' : 'f') . '"' . ($w ? ' style="width:' . $w . 'px"' : '') . ' value="' . e($u($v)) . '" readonly tabindex="-1">';
    $R = fn ($l, $f, $s = '') => '<div class="r" style="' . $s . '"><span class="l">' . $l . '</span><span class="c">:</span>' . $f . '</div>';
    $cell = function ($v, $align = '') use ($u) {
        $val = trim((string) ($v ?? ''));
        $display = $val !== '' ? e($u($val)) : '&nbsp;';
        $style = '';
        if ($align) {
            $style .= 'text-align:' . $align . ';';
        }
        return '<td><div class="cell-data"' . ($style ? ' style="' . $style . '"' : '') . '>' . $display . '</div></td>';
    };

    $isAdmin = auth()->check() && (auth()->user()->role === 'admin' || auth()->user()->admin !== null);

    $genderLabel = ['l' => 'LAKI-LAKI', 'p' => 'PEREMPUAN'][$applicant->gender] ?? '';
    $marital = $applicant->marital_status;
    $rawMaritalDate = (string) ($applicant->marital_date ?? '');
    $maritalYear = strlen($rawMaritalDate) > 4 ? substr($rawMaritalDate, 0, 4) : $rawMaritalDate;

    $bloodTypes = ['A', 'B', 'AB', 'O'];
    $bloodHtml = collect($bloodTypes)->map(function ($bt) use ($applicant) {
        $matches = $applicant->blood_type === $bt;
        $strike = (!empty($applicant->blood_type) && !$matches) ? ' x' : '';
        $bold = $matches ? 'font-weight:bold;' : '';
        return '<span class="s' . $strike . '" style="' . $bold . '">' . $bt . '</span>';
    })->implode(' / ');

    $job = $applicant->workExperiences->first();
    $expectation = $expectation ?? null;
    $yesNo = fn ($b) => $b ? 'YA' : 'TIDAK';

    $byRel = fn ($rel) => $applicant->families->where('relationship', $rel)->values();
    $father = $byRel('father')->first();
    $mother = $byRel('mother')->first();
    $parentsDivorced = ($father?->status === 'divorced' || $mother?->status === 'divorced');

    $famRows = function ($rows) use ($fmtDate, $cell, $parentsDivorced, $applicant, $u) {
        $out = '';
        foreach ($rows as [$label, $f, $genderFixed]) {
            $lp = '';
            $displayName = $f?->name ?? '';
            $statusKawin = '';
            if ($f && !empty($f->name)) {
                $lp = !empty($f->gender) ? strtoupper($f->gender) : ($genderFixed ?? '');
                if (($f->status ?? '') === 'deceased') {
                    $displayName .= ' (+)';
                }

                if (in_array($f->relationship, ['father', 'mother'])) {
                    if ($parentsDivorced) {
                        $statusKawin = 'BERCERAI';
                    } elseif ($f->status === 'deceased') {
                        $statusKawin = 'MENINGGAL';
                    } else {
                        $statusKawin = 'MENIKAH';
                    }
                } elseif ($f->relationship === 'spouse') {
                    $statusKawin = match ($applicant->marital_status) {
                        'divorced' => 'BERCERAI',
                        'widowed' => 'MENINGGAL',
                        default => 'MENIKAH',
                    };
                } elseif ($f->relationship === 'child') {
                    $statusKawin = 'BELUM MENIKAH';
                } elseif (!empty($f->status)) {
                    $statusKawin = match ($f->status) {
                        'divorced' => 'BERCERAI',
                        'deceased' => 'MENINGGAL',
                        default => 'MENIKAH',
                    };
                }
            }
            $out .= '<tr><td><div class="cell-data">' . $u($label) . '</div></td>'
                . $cell($displayName)
                . $cell($lp, 'center')
                . $cell($statusKawin, 'center')
                . $cell($f ? trim($f->place_of_birth . ', ' . $fmtDate($f->date_of_birth), ' ,') : '')
                . $cell($f?->education)
                . $cell($f?->work) . '</tr>';
        }
        return $out;
    };
    $famHead = '<tr><th style="width:82px">Hubungan<th style="width:169px">Nama<th style="width:42px">L / P<th style="width:85px">Status Kawin<th style="width:144px">Tempat / Tgl. Lahir<th style="width:79px">Pendidikan<th style="width:91px">Pekerjaan</tr>';

    $spouseGender = $applicant->gender === 'l' ? 'P' : ($applicant->gender === 'p' ? 'L' : '');
    $nuclear = [['Suami /Istri', $byRel('spouse')->first(), $spouseGender]];
    foreach (range(0, 4) as $i) { $nuclear[] = ['Anak ' . ($i + 1), $byRel('child')->get($i), null]; }
    $biological = [
        ['Ayah', $byRel('father')->first(), 'L'],
        ['Ibu', $byRel('mother')->first(), 'P'],
        ['Ayah Mertua', null, 'L'],
        ['Ibu Mertua', null, 'P']
    ];
    foreach (range(0, 4) as $i) { $biological[] = ['Saudara ' . ($i + 1), $byRel('sibling')->get($i), null]; }

    $jobRows = [
        ['Nama Perusahaan', 'company_name'],
        ['Alamat Perusahaan', 'company_address', 'a'],
        ['No. Telp Perusahaan', 'company_phone'],
        ['Jabatan Terakhir', 'position'],
        ['Divisi / Departemen', 'division'],
        ['Periode Bekerja', null, 'p'],
        ['Gaji', 'salary'],
        ['Fasilitas / Tunjangan', 'facility'],
        ['Alasan Keluar', 'reason_for_leaving'],
        ['Nama Atasan Langsung', 'reference_name'],
        ['Jabatan', 'reference_position'],
        ['Nomor HP Atasan', 'reference_phone'],
    ];
    $jobHtml = function ($no, $a = 0, $b = null) use ($jobRows, $applicant, $I, $fmtDate, $u) {
        $w = $applicant->workExperiences->get($no - 1);
        $out = '';
        $slice = $b === null ? array_slice($jobRows, $a) : array_slice($jobRows, $a, $b - $a, true);
        foreach ($slice as $idx => $row) {
            [$label, $key, $kind] = $row + [null, null, null];
            $num = $idx === 0 ? '<span class="n">' . $no . '.</span>' : '';
            $val = $key && $w ? ($key === 'salary' && $w->salary ? number_format($w->salary, 0, ',', '.') : $w->$key) : '';
            if ($kind === 'p') {
                $field = $I(130, $w ? $fmtDate($w->start_date) : '') . '<span style="width:50px;text-align:center" class="w">sampai</span>' . $I(130, $w ? $fmtDate($w->end_date) : '');
            } else {
                $field = $I(0, $val);
            }
            $out .= '<div class="jr">' . $num . '<span class="l">' . $label . '</span><span class="c">:</span>' . $field . '</div>';
            if ($kind === 'a') {
                $out .= '<div class="jr" style="padding-left:151px">' . $I(0) . '</div>';
            }
        }
        return $out;
    };

    $ranks = collect($expectationInterests ?? [])->values()->flip()->map(fn ($i) => $i + 1);
    $divisionList = $divisions->values();
    $half = (int) ceil($divisionList->count() / 2);
    $interestRows = '';
    foreach (range(0, max($half - 1, 0)) as $i) {
        $l = $divisionList->get($i);
        $r = $divisionList->get($i + $half);
        $interestRows .= '<tr><td><div class="cell-data">' . e($u($l?->name)) . '</div></td><td>' . ($l ? '<div class="cell-data" style="text-align:center">' . ($ranks[$l->id] ?? '') . '</div>' : '&nbsp;') . '</td>'
            . '<td><div class="cell-data">' . e($u($r?->name)) . '</div></td><td>' . ($r ? '<div class="cell-data" style="text-align:center">' . ($ranks[$r->id] ?? '') . '</div>' : '&nbsp;') . '</td></tr>';
    }
    $sosroExps = $applicant->workExperiences->filter(function ($exp) {
        $cn = strtolower((string) ($exp->company_name ?? ''));
        return str_contains($cn, 'sosro') || str_contains($cn, 'gunung slamat') || str_contains($cn, 'rekso');
    })->values();
    $hasWorkedSosro = $sosroExps->isNotEmpty();

    $jy = function ($no) use ($I, $sosroExps, $fmtDate) {
        $exp = $sosroExps->get($no - 1);
        $out = '';
        $rows = [
            ['Nama PT', $exp?->company_name],
            ['Kota', ''],
            ['Jabatan', $exp?->position],
            ['Departemen', $exp?->division],
            ['Periode Bekerja', 'p', $exp && $exp->start_date ? $fmtDate($exp->start_date) : '', $exp ? ($exp->end_date ? $fmtDate($exp->end_date) : 'SEKARANG') : ''],
        ];
        foreach ($rows as $i => $row) {
            $l = $row[0];
            $val = $row[1] ?? null;
            if ($val === 'p') {
                $field = $I(130, $row[2] ?? '') . '<span class="w" style="width:50px;text-align:center">sampai</span>' . $I(130, $row[3] ?? '');
            } else {
                $field = $I(0, $val ?? '');
            }
            $label = $i === 0 ? $no . '. ' . $l : $l;
            $pad = $i === 0 ? '' : 'padding-left:18px;';
            $tTag = ($no === 1 && $i === 0) ? '<span class="t">Jika Ya,</span>' : '<span class="t"></span>';
            $out .= '<div class="jy">' . $tTag . '<span class="l" style="' . $pad . '">' . $label . '</span><span class="c">:</span>' . $field . '</div>';
        }
        return $out;
    };

    $hariIndo = [
        'Sunday' => 'Minggu',
        'Monday' => 'Senin',
        'Tuesday' => 'Selasa',
        'Wednesday' => 'Rabu',
        'Thursday' => 'Kamis',
        'Friday' => 'Jumat',
        'Saturday' => 'Sabtu',
    ];
    $now = now();
    $hari = $hariIndo[$now->format('l')] ?? $now->format('l');
    $todaySignature = $u($hari . ', ' . $fmtDate($now));
@endphp

<div class="pg"><div class="fn">No Form: HC-ODR.FRM.001.00</div><div class="lg"><img src="{{ asset('assets/images/header-sosro-rekso.png') }}" alt="Sinar Sosro Rekso"></div><div class="pn">1</div>
<div class="ttl">FORMULIR BIODATA CALON KARYAWAN</div><div class="hr"></div>
@if ($isAdmin)
<div class="g" style="margin-top:12px;height:18px"><b style="font-size:12.5px;margin-left:11px;white-space:nowrap">Jabatan yang dilamar :&nbsp;</b>{!! $I(0, $jobTitle ?? '') !!}</div><div class="hr" style="margin-top:9px"></div>
@endif
<div style="margin:10px 0 6px 8px"><b><u>A.&nbsp;&nbsp; IDENTITAS DIRI</u></b></div>
<div style="display:flex;margin:0 40px 0 30px;gap:20px;align-items:flex-start">
    <div style="flex:1;min-width:0;display:flex;flex-direction:column;gap:7px">
        <div class="r" style="margin:0">{!! '<span class="l">Nama Lengkap</span><span class="c">:</span>' . $I(0, $applicant->name) !!}</div>
        <div class="r" style="margin:0">{!! '<span class="l">Jenis Kelamin</span><span class="c">:</span>' . $I(0, $genderLabel) !!}</div>
        <div class="r" style="margin:0">{!! '<span class="l">Tempat / Tgl Lahir</span><span class="c">:</span>' . $I(0, $applicant->place_of_birth . ', ' . $fmtDate($applicant->date_of_birth)) !!}</div>
        <div class="r" style="margin:0"><span class="l">Tinggi badan</span><span class="c">:</span>{!! $I(40, $applicant->height) !!}&nbsp;cm<span style="width:20px" class="w"></span><span class="w">Berat Badan</span><span class="c">:</span>{!! $I(40, $applicant->weight) !!}&nbsp;kg</div>
        <div class="r" style="margin:0"><span class="l">Golongan Darah</span><span class="c">:</span><span>{!! $bloodHtml !!} <i class="sm"><b>(coret yang tidak perlu)</b></i></span></div>
    </div>
    <div style="width:108px;height:144px;border:1.5px solid #000;padding:3px;box-sizing:border-box;flex:none;display:flex;align-items:center;justify-content:center;background:#fff;overflow:hidden;margin-top:2px">
        @if ($applicant->photo_url)
            <img src="{{ asset('storage/' . $applicant->photo_url) }}" alt="Foto {{ $applicant->name }}" style="width:100%;height:100%;object-fit:cover;display:block;border:1px solid #222">
        @else
            <div style="width:100%;height:100%;border:1px dashed #777;display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:bold;color:#777;text-align:center;line-height:1.4">PAS FOTO<br>3 x 4</div>
        @endif
    </div>
</div>
{!! $R('Alamat sesuai KTP', $I(0, $applicant->address_ktp), 'margin-top:8px') !!}
<div class="r" style="margin-left:170px">{!! $I(0) !!}<span style="margin-left:6px">Kode Pos :</span>{!! $I(60, $applicant->postal_code_ktp ?? '') !!}</div>
{!! $R('Alamat Domisili', $I(0, $applicant->address_domisili), 'margin-top:5px') !!}
<div class="r" style="margin-left:170px">{!! $I(0) !!}<span style="margin-left:6px">Kode Pos :</span>{!! $I(60, $applicant->postal_code_domisili ?? '') !!}</div>
{!! $R('No. Handphone', $I(0, $applicant->phone_number)) !!}
{!! $R('Email', $I(0, $applicant->email)) !!}
{!! $R('Instagram', $I(163, $applicant->instagram) . '<span class="w" style="margin-left:8px;width:60px">LinkedIn :</span>' . $I(0, $applicant->linkedin)) !!}
{!! $R('Agama', $I(163, $applicant->religion)) !!}
<div class="r" style="height:19px"><span class="l">Status Perkawinan<sup>*)</sup></span><span class="c">:</span><label class="w" style="width:200px"><input type="checkbox" disabled @checked($marital === 'single')>single/bertunangan</label><label class="w" style="width:100px"><input type="checkbox" disabled @checked($marital === 'married')>menikah, sejak</label><span class="c">:</span>{!! $I(100, $marital === 'married' ? $maritalYear : '') !!}</div>
<div class="r" style="height:17px"><span class="l"></span><span class="c"></span><i class="sm w" style="width:200px;margin-left:3px"><sup>*)</sup> pilih (v) salah satu</i><label class="w" style="width:100px"><input type="checkbox" disabled @checked(in_array($marital, ['divorced', 'widowed']))>bercerai, sejak</label><span class="c">:</span>{!! $I(100, in_array($marital, ['divorced', 'widowed']) ? $maritalYear : '') !!}</div>
{!! $R('No. KTP', $I(192, $applicant->nik)) !!}
<div class="r" style="margin-top:8px"><b>Emergency Contacts</b></div>
{!! $R('Nama Lengkap', $I(306, $applicant->emergency_contact_name ?? '')) !!}{!! $R('Hubungan', $I(306, $applicant->emergency_contact_relationship ?? '')) !!}{!! $R('No. HP', $I(306, $applicant->emergency_contact_phone ?? '')) !!}
<div style="margin:10px 0 2px 6px"><b>B. 1. LINGKUNGAN KELUARGA INTI</b></div>
<table>{!! $famHead . $famRows($nuclear) !!}</table>
<div style="margin:10px 0 2px 6px"><b>2. LINGKUNGAN KELUARGA KANDUNG (Termasuk diri Anda)</b></div>
<table>{!! $famHead . $famRows($biological) !!}</table>
<div style="margin-left:12px;font-size:10.5px"><b><i>* Bagi anggota keluarga yang sudah meninggal, harap tetap dicantumkan pada kolom nama dan diberi tanda (+)</i></b></div>
</div>

<div class="pg"><div class="fn">No Form: HC-ODR.FRM.001.00</div><div class="lg"><img src="{{ asset('assets/images/header-sosro-rekso.png') }}" alt="Sinar Sosro Rekso"></div><div class="pn">2</div>
<div style="margin:0 0 3px 6px"><b>C. 1. RIWAYAT PENDIDIKAN FORMAL</b></div>
<table style="width:692px;margin-left:-18px"><tr><th style="width:10%">Jenjang<th style="width:32%">Nama Sekolah<th style="width:9%">Kota<th style="width:6%">Th.<br>Masuk<th style="width:6%">Th.<br>Lulus<th style="width:18%">Fakultas / Jurusan<th style="width:19%">Keterangan / IPK</tr>
@for ($i = 0; $i < 4; $i++)
@php $edu = $applicant->educations->get($i); @endphp
<tr>{!! $cell($edu?->degree_level) . $cell($edu?->institution_name) . $cell('') . $cell($edu?->entry_year) . $cell($edu?->graduation_year) . $cell($edu?->major) . $cell($edu?->gpa) !!}</tr>
@endfor
</table>
<div style="margin:14px 0 3px 6px"><b>2. RIWAYAT PENDIDIKAN INFORMAL (TRAINING / KURSUS)</b></div>
<table class="t2"><tr><th style="width:35%">Nama Lembaga<th style="width:50%">Jenis Training / Kursus<th style="width:15%">Tahun</tr>
@for ($i = 0; $i < 5; $i++)
@php $tr = $applicant->trainings->get($i); @endphp
<tr>{!! $cell($tr?->organizer) . $cell($tr?->training_name) . $cell($tr ? \Carbon\Carbon::parse($tr->finished)->format('Y') : '') !!}</tr>
@endfor
</table>
<div style="margin:16px 0 4px 6px"><b>D. RIWAYAT PEKERJAAN (Sebutkan 3 perusahaan terakhir)</b></div>
{!! $jobHtml(1) !!}<div style="height:10px"></div>{!! $jobHtml(2) !!}
</div>

<div class="pg"><div class="fn">No Form: HC-ODR.FRM.001.00</div><div class="lg"><img src="{{ asset('assets/images/header-sosro-rekso.png') }}" alt="Sinar Sosro Rekso"></div><div class="pn">3</div>
{!! $jobHtml(3) !!}
<div style="margin:14px 0 6px 6px"><b>Gambarkan Struktur Organisasi Perusahaan Anda (terakhir) dan posisi Anda di dalamnya !</b></div>
<textarea style="width:718px;margin-left:-18px;height:180px;border:1px solid #000;resize:none;display:block;padding:4px" readonly tabindex="-1"></textarea>
<div style="margin:14px 0 4px 6px">Pernahkah Anda melamar di Perusahaan / Group ini sebelumnya? Kapan? Untuk posisi jabatan apa?</div>
<div style="margin:0 0 0 38px;height:20px;display:flex;align-items:flex-end">{!! $I(0) !!}</div>
<div style="margin:0 0 0 38px;height:20px;display:flex;align-items:flex-end"><span class="w">Pernahkah Anda bekerja di Perusahaan / Group ini sebelumnya?&nbsp;</span>{!! $I(0, $hasWorkedSosro ? 'YA' : 'TIDAK') !!}</div>
{!! $jy(1) !!}{!! $jy(2) !!}
<div style="margin:14px 0 6px 6px">Buatlah urutan minat Anda dalam bekerja. (Nomor 1 – {{ $divisions->count() }})</div>
<table class="t2" style="width:610px;margin-left:19px"><tr><th style="width:35%">Jenis Pekerjaan<th style="width:11%">No. Urut<th style="width:41%">Jenis Pekerjaan<th style="width:13%">No. Urut</tr>{!! $interestRows !!}</table>
</div>

<div class="pg"><div class="fn">No Form: HC-ODR.FRM.001.00</div><div class="lg"><img src="{{ asset('assets/images/header-sosro-rekso.png') }}" alt="Sinar Sosro Rekso"></div><div class="pn">4</div>
<div style="margin:0 0 4px 6px"><b>E. LAIN-LAIN</b></div>
<div class="q">1. Berapa gaji yang Anda harapkan ?{!! $I(0, $expectation?->salary_expectation ? 'Rp ' . number_format($expectation->salary_expectation, 0, ',', '.') : '') !!}</div>
<div class="q">2. Fasilitas apa saja yang Anda harapkan ?{!! $I(0, $expectation?->facility_expectation) !!}</div>
<div class="q">3. Apakah Anda bersedia dinas keluar kota ?{!! $I(0, $expectation ? $yesNo($expectation->ready_to_travel) : '') !!}</div>
<div class="q">4. Apakah Anda bersedia untuk ditempatkan di luar kota ?{!! $I(0, $expectation ? $yesNo($expectation->ready_to_relocate) : '') !!}</div>
<div class="q">5. Darimana Anda mendapatkan informasi mengenai lowongan di perusahaan ini?{!! $I(0, $expectation?->job_source) !!}</div>
<div class="q" style="height:18px">6. Sebutkan nama kenalan / referensi Anda di perusahaan ini.</div>
<div class="q" style="margin-left:30px;height:19px">{!! $I(0, $expectation?->reference_by) !!}</div>
<div style="margin:24px 0 4px 6px"><b>F. INFO KESEHATAN</b></div>
<div class="q">1. Apakah Anda memiliki riwayat penyakit kronis ?{!! $I(0, $applicant->medical_history ?: 'TIDAK ADA') !!}</div>
<div class="q" style="margin-top:6px">2. Apakah Anda merokok ?{!! $I(150, $yesNo($applicant->is_smoker === 'y')) !!}</div>
<div class="q">3. Apakah Anda memiliki tato?{!! $I(0, $yesNo($applicant->has_tattoo === 'y')) !!}</div>
<p style="margin:32px 0 0;text-align:justify;font-weight:bold;line-height:1.45;font-size:12.5px">Dengan ini saya menyatakan bahwa semua data dan informasi yang saya kemukakan dan tuliskan selama proses rekrutmen berlangsung adalah benar adanya. Apabila di kemudian hari hal tersebut terbukti tidak benar, maka saya bersedia diberikan sanksi berupa pengakhiran hubungan kerja tanpa diberikan uang pesangon / uang pisah / kompensasi dalam bentuk apapun dari dan atas nama perusahaan.</p>
<p style="margin:14px 0 0;font-weight:bold">Demikian pernyataan ini saya buat dengan sebenar-benarnya dan dalam kondisi tanpa tekanan/paksaan.</p>
<div style="display:flex;justify-content:flex-end;margin-top:35px">
    <div style="width:240px">
        <div style="margin-top:85px;display:flex;align-items:flex-end;height:18px">
            <span class="w">(&nbsp;</span>
            <input type="text" class="f" style="text-align:center;font-weight:bold" value="{{ $u($applicant->name) }}" readonly tabindex="-1">
            <span class="w">&nbsp;)</span>
        </div>
    </div>
</div>
</div>
</body>
</html>
