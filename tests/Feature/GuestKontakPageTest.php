<?php

use Illuminate\Support\Facades\Storage;

it('renders the kontak page jumbotron, contact form, and 10 FAQ items', function () {
    $response = $this->get(route('guest.kontak'));

    $response->assertOk()
        ->assertSee('CARI TAHU LEBIH TENTANG KARIER SINAR SOSRO GUNUNG SLAMAT')
        ->assertSee('Kami siap membantu!')
        ->assertSee('Hubungi kami melalui form di bawah ini.')
        ->assertSee('KIRIM PESAN')
        ->assertSee('PERTANYAAN YANG SERING DIAJUKAN (FAQ)?')
        ->assertSee('Tahapan apa saja jika ingin melamar di PT Sinar Sosro Gunung Slamat?')
        ->assertSee('Tahapan umumnya: Pendaftaran Akun, Melengkapi Profil, Pemilihan Lowongan, Seleksi oleh HRD/User, hingga Offering.')
        ->assertSee('Apakah ada pungutan biaya dalam proses seleksi?')
        ->assertSee('Tidak. Seluruh proses rekrutmen PT Sinar Sosro Gunung Slamat bersifat GRATIS.')
        ->assertSee('const isTransparentNav = true', false)
        ->assertSee(route('guest.kontak.store'));
});

it('validates and stores contact messages submitted through the kontak form', function () {
    Storage::fake('local');

    $this->post(route('guest.kontak.store'), [])
        ->assertSessionHasErrors(['name', 'email', 'region', 'message']);

    $response = $this->from(route('guest.kontak'))
        ->post(route('guest.kontak.store'), [
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'region' => 'Kantor Pusat (Head Office)',
            'message' => 'Mohon informasi terkait jadwal rekrutmen MT batch berikutnya.',
        ]);

    $response->assertRedirect(route('guest.kontak'))
        ->assertSessionHas('success');

    Storage::disk('local')->assertExists('contact_messages.json');
    $saved = json_decode(Storage::disk('local')->get('contact_messages.json'), true);
    expect($saved)->toHaveCount(1)
        ->and($saved[0]['email'])->toBe('budi@example.com')
        ->and($saved[0]['region'])->toBe('Kantor Pusat (Head Office)');
});
