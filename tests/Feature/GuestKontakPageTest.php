<?php

use App\Models\Admin;
use App\Models\Applicant;
use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

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

it('prefills contact form name and email for authenticated users', function () {
    $applicant = Applicant::factory()->create([
        'name' => 'Siti Rahmawati',
    ]);

    $this->actingAs($applicant->user)
        ->get(route('guest.kontak'))
        ->assertOk()
        ->assertSee('value="Siti Rahmawati"', false)
        ->assertSee('value="'.$applicant->user->email.'"', false);
});

it('validates and stores contact messages in database for guests and authenticated users', function () {
    $this->post(route('guest.kontak.store'), [])
        ->assertSessionHasErrors(['name', 'email', 'region', 'message']);

    $guestResponse = $this->from(route('guest.kontak'))
        ->post(route('guest.kontak.store'), [
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'region' => 'Kantor Pusat (Head Office)',
            'message' => 'Mohon informasi terkait jadwal rekrutmen MT batch berikutnya.',
        ]);

    $guestResponse->assertRedirect(route('guest.kontak'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('contact_messages', [
        'user_id' => null,
        'name' => 'Budi Santoso',
        'email' => 'budi@example.com',
        'region' => 'Kantor Pusat (Head Office)',
        'message' => 'Mohon informasi terkait jadwal rekrutmen MT batch berikutnya.',
        'status' => 'unread',
    ]);

    $user = User::factory()->create(['role' => 'user', 'is_active' => true]);

    $authResponse = $this->actingAs($user)
        ->from(route('guest.kontak'))
        ->post(route('guest.kontak.store'), [
            'name' => 'Dewi Lestari',
            'email' => $user->email,
            'region' => 'KPW Jawa Barat',
            'message' => 'Laporan kendala saat mengunggah berkas lamaran.',
        ]);

    $authResponse->assertRedirect(route('guest.kontak'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('contact_messages', [
        'user_id' => $user->id,
        'name' => 'Dewi Lestari',
        'email' => $user->email,
        'region' => 'KPW Jawa Barat',
        'status' => 'unread',
    ]);
});

it('allows only superadmin to view, update status, and delete contact messages', function () {
    $message = ContactMessage::factory()->create([
        'name' => 'Andi Pratama',
        'email' => 'andi@example.com',
        'region' => 'KPW Jakarta Banten',
        'message' => 'Pertanyaan mengenai status seleksi administrasi.',
        'status' => 'unread',
    ]);

    $regularAdminUser = Admin::factory()->create(['role' => 'admin'])->user;

    $this->actingAs($regularAdminUser)
        ->get(route('contact-message.index'))
        ->assertForbidden();

    $superAdminUser = Admin::factory()->create(['role' => 'superadmin'])->user;

    $this->actingAs($superAdminUser)
        ->get(route('contact-message.index'))
        ->assertOk()
        ->assertSee('Pesan Masuk')
        ->assertSee('Andi Pratama')
        ->assertSee('andi@example.com')
        ->assertSee('KPW Jakarta Banten');

    $this->actingAs($superAdminUser)
        ->patch(route('contact-message.updateStatus', $message), [
            'status' => 'resolved',
            'admin_notes' => 'Sudah dihubungi kembali melalui email resmi HR.',
        ])
        ->assertRedirect(route('contact-message.index'))
        ->assertSessionHas('success');

    $message->refresh();
    expect($message->status)->toBe('resolved')
        ->and($message->admin_notes)->toBe('Sudah dihubungi kembali melalui email resmi HR.')
        ->and($message->resolved_at)->not->toBeNull();

    $this->actingAs($superAdminUser)
        ->delete(route('contact-message.destroy', $message))
        ->assertRedirect(route('contact-message.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseMissing('contact_messages', [
        'id' => $message->id,
    ]);
});
