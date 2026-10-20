<h1>Template Email</h1>

<p>Email dikirim otomatis saat admin memperbarui stage atau status lamaran di halaman detail lowongan.</p>

@if (session('success'))
    <p style="color: green">{{ session('success') }}</p>
@endif
@if (session('error'))
    <p style="color: red">{{ session('error') }}</p>
@endif

<form method="POST" action="{{ route('email.send') }}">
    @csrf
    <label for="email">Alamat tujuan tes</label>
    <input type="email" id="email" name="email" value="{{ old('email') }}" required>
    @error('email')
        <small style="color: red">{{ $message }}</small>
    @enderror

    <fieldset>
        <legend>Pilih email yang dikirim</legend>
        @foreach ($templates as $key => $label)
            <div>
                <input type="checkbox" id="template-{{ $key }}" name="templates[]" value="{{ $key }}"
                    @checked(in_array($key, old('templates', []), true))>
                <label for="template-{{ $key }}">{{ $label }}</label>
            </div>
        @endforeach
        @error('templates')
            <small style="color: red">{{ $message }}</small>
        @enderror
    </fieldset>

    @php
        $groups = [
            'Interview' => [
                'interview_date' => ['Tanggal', 'date'],
                'interview_time' => ['Jam', 'time'],
                'interview_link' => ['Link (online)', 'text'],
                'interview_address' => ['Alamat (offline)', 'text'],
            ],
            'Psikotes' => [
                'psikotes_date' => ['Tanggal', 'date'],
                'psikotes_time' => ['Jam', 'time'],
                'psikotes_link' => ['Link', 'text'],
                'psikotes_code' => ['Kode', 'text'],
            ],
            'Medical Check Up' => [
                'mcu_date' => ['Tanggal', 'date'],
                'mcu_time' => ['Jam', 'time'],
                'mcu_location' => ['Lokasi', 'text'],
                'mcu_address' => ['Alamat', 'text'],
            ],
            'Diterima (HO / KPW)' => [
                'start_date' => ['Tanggal mulai kerja', 'date'],
                'work_address' => ['Alamat kerja', 'text'],
            ],
            'Studi Kasus (MT)' => [
                'study_case_topic' => ['Topik', 'text'],
                'study_case_deadline' => ['Batas pengumpulan', 'text'],
                'study_case_link' => ['Link pengumpulan', 'text'],
            ],
            'Panel BOD (MT)' => [
                'panel_bod_date' => ['Tanggal', 'date'],
                'panel_bod_time' => ['Jam', 'time'],
            ],
            'Pengumpulan Berkas' => [
                'document_deadline' => ['Batas pengumpulan', 'text'],
            ],
        ];
    @endphp

    @foreach ($groups as $groupLabel => $fields)
        <fieldset>
            <legend>Data {{ $groupLabel }}</legend>
            @foreach ($fields as $name => [$label, $type])
                <div>
                    <label for="{{ $name }}">{{ $label }}</label>
                    <input type="{{ $type }}" id="{{ $name }}" name="{{ $name }}" value="{{ old($name, $defaults[$name]) }}">
                    @error($name)
                        <small style="color: red">{{ $message }}</small>
                    @enderror
                </div>
            @endforeach
        </fieldset>
    @endforeach

    <button type="button" onclick="document.querySelectorAll('input[name=&quot;templates[]&quot;]').forEach(c => c.checked = true)">Pilih semua</button>
    <button type="submit" class="btn btn-primary">Kirim Email Tes</button>
</form>
