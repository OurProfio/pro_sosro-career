<?php

use App\Mail\ContactMessageReplyMail;
use App\Models\Admin;
use App\Models\Applicant;
use App\Models\ContactMessage;
use App\Models\Office;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

uses(RefreshDatabase::class);

it('renders the kontak page jumbotron, contact form with 15 regions, and 10 FAQ items', function () {
    $response = $this->get(route('guest.kontak'));

    $response->assertOk()
        ->assertSee('CARI TAHU LEBIH TENTANG KARIER SINAR SOSRO GUNUNG SLAMAT')
        ->assertSee('Kami siap membantu!')
        ->assertSee('Hubungi kami melalui form di bawah ini.')
        ->assertSee('KIRIM PESAN')
        ->assertSee('PERTANYAAN YANG SERING DIAJUKAN (FAQ)?')
        ->assertSee('Tahapan apa saja jika ingin melamar di PT Sinar Sosro Gunung Slamat?')
        ->assertSee('Tahapan umumnya: Pendaftaran Akun, Melengkapi Profil, Pemilihan Lowongan, Seleksi oleh HRD/User, hingga Penawaran Kerja.')
        ->assertSee('Apakah ada pungutan biaya dalam proses seleksi?')
        ->assertSee('Tidak. Seluruh proses rekrutmen PT Sinar Sosro Gunung Slamat bersifat GRATIS.')
        ->assertSee('const isTransparentNav = true', false)
        ->assertSee(route('guest.kontak.store'));

    foreach (ContactMessage::REGIONS as $region) {
        $response->assertSee($region);
    }
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

it('validates and stores contact messages into central triage for guests and authenticated users', function () {
    $this->post(route('guest.kontak.store'), [])
        ->assertSessionHasErrors(['name', 'email', 'region', 'message']);

    $this->post(route('guest.kontak.store'), [
        'name' => 'Budi Santoso',
        'email' => 'budi@example.com',
        'region' => 'Wilayah Tidak Valid',
        'message' => 'Test wilayah tidak valid.',
    ])->assertSessionHasErrors(['region']);

    $guestResponse = $this->from(route('guest.kontak'))
        ->post(route('guest.kontak.store'), [
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'region' => 'Jakarta & Banten',
            'message' => 'Mohon informasi terkait jadwal rekrutmen MT batch berikutnya.',
        ]);

    $guestResponse->assertRedirect(route('guest.kontak'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('contact_messages', [
        'user_id' => null,
        'assigned_office_id' => null,
        'name' => 'Budi Santoso',
        'email' => 'budi@example.com',
        'region' => 'Jakarta & Banten',
        'message' => 'Mohon informasi terkait jadwal rekrutmen MT batch berikutnya.',
        'status' => 'unread',
    ]);

    $user = User::factory()->create(['role' => 'user', 'is_active' => true]);

    $authResponse = $this->actingAs($user)
        ->from(route('guest.kontak'))
        ->post(route('guest.kontak.store'), [
            'name' => 'Dewi Lestari',
            'email' => $user->email,
            'region' => 'Jawa Barat',
            'message' => 'Laporan kendala saat mengunggah berkas lamaran.',
        ]);

    $authResponse->assertRedirect(route('guest.kontak'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('contact_messages', [
        'user_id' => $user->id,
        'assigned_office_id' => null,
        'name' => 'Dewi Lestari',
        'email' => $user->email,
        'region' => 'Jawa Barat',
        'status' => 'unread',
    ]);
});

it('allows superadmin to view, reply via email to resolve directly, and delete contact messages', function () {
    Mail::fake();

    $office = Office::factory()->create(['name' => 'KPW Jakarta Banten', 'type' => 'KPW']);
    $superAdminUser = Admin::factory()->create([
        'role' => 'superadmin',
        'office_id' => $office->id,
        'is_active' => true,
    ])->user;

    $message = ContactMessage::factory()->create([
        'name' => 'Andi Pratama',
        'email' => 'andi@example.com',
        'region' => 'KPW Jakarta Banten',
        'message' => 'Pertanyaan mengenai status seleksi administrasi.',
        'status' => 'unread',
    ]);

    $this->actingAs($superAdminUser)
        ->get(route('contact-message.index'))
        ->assertOk()
        ->assertSee('Pesan Masuk')
        ->assertSee('Andi Pratama')
        ->assertSee('andi@example.com')
        ->assertSee('KPW Jakarta Banten');

    $replyText = 'Sudah saya ubah password Anda menjadi 123678, coba login kembali.';

    $this->actingAs($superAdminUser)
        ->patch(route('contact-message.updateStatus', $message), [
            'assigned_office_id' => '',
            'reply_message' => $replyText,
        ])
        ->assertRedirect(route('contact-message.index'))
        ->assertSessionHas('success');

    Mail::assertSent(ContactMessageReplyMail::class, function (ContactMessageReplyMail $mail) use ($message, $replyText): bool {
        $rendered = $mail->render();

        return $mail->hasTo($message->email)
            && str_contains($rendered, $replyText)
            && str_contains($rendered, 'Best regards,')
            && str_contains($rendered, 'Human Capital Team')
            && str_contains($rendered, 'PT. Sinar Sosro Gunung Slamat');
    });

    $message->refresh();
    expect($message->status)->toBe('resolved')
        ->and($message->reply_message)->toBe($replyText)
        ->and($message->assigned_office_id)->toBeNull()
        ->and($message->resolved_at)->not->toBeNull();

    $this->actingAs($superAdminUser)
        ->delete(route('contact-message.destroy', $message))
        ->assertRedirect(route('contact-message.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseMissing('contact_messages', [
        'id' => $message->id,
    ]);
});
