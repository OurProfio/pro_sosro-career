<?php

use App\Mail\ContactMessageReplyMail;
use App\Models\Admin;
use App\Models\ContactMessage;
use App\Models\Office;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->hoOffice = Office::factory()->create(['name' => 'Kantor Pusat', 'type' => 'HO']);
    $this->jakartaOffice = Office::factory()->create(['name' => 'KPW Jakarta Banten', 'type' => 'KPW']);
    $this->bandungOffice = Office::factory()->create(['name' => 'KPW Jawa Barat', 'type' => 'KPW']);
    $this->inactiveOffice = Office::factory()->create(['name' => 'Pabrik Tanpa Admin', 'type' => 'Pabrik']);

    $this->superAdminUser = Admin::factory()->create([
        'role' => 'superadmin',
        'office_id' => $this->hoOffice->id,
        'is_active' => true,
    ])->user;

    $this->jakartaAdminUser = Admin::factory()->create([
        'role' => 'admin',
        'office_id' => $this->jakartaOffice->id,
        'is_active' => true,
    ])->user;

    $this->bandungAdminUser = Admin::factory()->create([
        'role' => 'admin',
        'office_id' => $this->bandungOffice->id,
        'is_active' => true,
    ])->user;
});

it('keeps newly submitted messages in superadmin triage until dispatched to a branch admin', function () {
    Mail::fake();

    $message = ContactMessage::factory()->create([
        'name' => 'Rina Kartika',
        'region' => $this->jakartaOffice->name,
        'assigned_office_id' => null,
        'status' => 'unread',
    ]);

    $this->actingAs($this->superAdminUser)
        ->get(route('contact-message.index'))
        ->assertOk()
        ->assertSee('Rina Kartika')
        ->assertSee('Pusat (Superadmin)');

    $this->actingAs($this->jakartaAdminUser)
        ->get(route('contact-message.index'))
        ->assertOk()
        ->assertDontSee('Rina Kartika');

    $this->actingAs($this->jakartaAdminUser)
        ->patch(route('contact-message.updateStatus', $message), [
            'reply_message' => 'Tidak seharusnya bisa membalas.',
        ])
        ->assertForbidden();

    Mail::assertNothingSent();
});

it('requires a reply message when superadmin handles directly or when branch admin resolves', function () {
    Mail::fake();

    $message = ContactMessage::factory()->create([
        'assigned_office_id' => null,
        'status' => 'unread',
    ]);

    $this->actingAs($this->superAdminUser)
        ->from(route('contact-message.index'))
        ->patch(route('contact-message.updateStatus', $message), [
            'assigned_office_id' => '',
            'reply_message' => '',
        ])
        ->assertRedirect(route('contact-message.index'))
        ->assertSessionHasErrors(['reply_message']);

    $branchMessage = ContactMessage::factory()
        ->assignedTo($this->jakartaOffice)
        ->create(['status' => 'unread']);

    $this->actingAs($this->jakartaAdminUser)
        ->from(route('contact-message.index'))
        ->patch(route('contact-message.updateStatus', $branchMessage), [
            'reply_message' => '',
        ])
        ->assertRedirect(route('contact-message.index'))
        ->assertSessionHasErrors(['reply_message']);

    Mail::assertNothingSent();
});

it('allows superadmin to dispatch without emailing and lets the branch admin reply via email to resolve', function () {
    Mail::fake();

    $message = ContactMessage::factory()->create([
        'name' => 'Dodi Setiawan',
        'email' => 'dodi@example.com',
        'region' => $this->jakartaOffice->name,
        'assigned_office_id' => null,
        'status' => 'unread',
    ]);

    // Superadmin lempar ke admin cabang (tanpa kirim email ke pelapor)
    $this->actingAs($this->superAdminUser)
        ->patch(route('contact-message.updateStatus', $message), [
            'assigned_office_id' => $this->jakartaOffice->id,
        ])
        ->assertRedirect(route('contact-message.index'))
        ->assertSessionHas('success');

    Mail::assertNothingSent();

    $message->refresh();
    expect($message->assigned_office_id)->toBe($this->jakartaOffice->id)
        ->and($message->assigned_at)->not->toBeNull()
        ->and($message->status)->toBe('unread')
        ->and($message->resolved_at)->toBeNull();

    // Admin cabang tujuan melihat pesan
    $this->actingAs($this->jakartaAdminUser)
        ->get(route('contact-message.index'))
        ->assertOk()
        ->assertSee('Dodi Setiawan')
        ->assertSee('Kirim Balasan Email');

    // Admin cabang lain tidak melihat pesan dan dilarang membalas
    $this->actingAs($this->bandungAdminUser)
        ->get(route('contact-message.index'))
        ->assertOk()
        ->assertDontSee('Dodi Setiawan');

    $this->actingAs($this->bandungAdminUser)
        ->patch(route('contact-message.updateStatus', $message), [
            'reply_message' => 'Akses cabang lain.',
        ])
        ->assertForbidden();

    // Admin cabang tujuan mengirim balasan email solusi
    $branchReply = 'Jadwal psikotes Anda telah kami perbarui untuk hari Kamis pukul 09:00 WIB.';

    $this->actingAs($this->jakartaAdminUser)
        ->patch(route('contact-message.updateStatus', $message), [
            'reply_message' => $branchReply,
        ])
        ->assertRedirect(route('contact-message.index'))
        ->assertSessionHas('success');

    Mail::assertSent(ContactMessageReplyMail::class, function (ContactMessageReplyMail $mail) use ($message, $branchReply): bool {
        $rendered = $mail->render();

        return $mail->hasTo($message->email)
            && str_contains($rendered, $branchReply)
            && str_contains($rendered, 'Best regards,')
            && str_contains($rendered, 'Human Capital Team')
            && str_contains($rendered, 'PT. Sinar Sosro Gunung Slamat');
    });

    $message->refresh();
    expect($message->status)->toBe('resolved')
        ->and($message->reply_message)->toBe($branchReply)
        ->and($message->resolved_at)->not->toBeNull()
        ->and($message->assigned_office_id)->toBe($this->jakartaOffice->id);
});

it('shows only non-HO offices with registered active branch admins in superadmin dispatch options', function () {
    $response = $this->actingAs($this->superAdminUser)
        ->get(route('contact-message.index'));

    $response->assertOk();

    $groupedOffices = $response->viewData('groupedOffices');
    $officeIds = $groupedOffices->flatten(1)->pluck('id');

    expect($officeIds)->toContain($this->jakartaOffice->id, $this->bandungOffice->id)
        ->and($officeIds)->not->toContain($this->hoOffice->id)
        ->and($officeIds)->not->toContain($this->inactiveOffice->id);
});

it('rejects dispatching a message to an HO office or an office without an active branch admin', function () {
    Mail::fake();

    $message = ContactMessage::factory()->create([
        'assigned_office_id' => null,
        'status' => 'unread',
    ]);

    $this->actingAs($this->superAdminUser)
        ->from(route('contact-message.index'))
        ->patch(route('contact-message.updateStatus', $message), [
            'assigned_office_id' => $this->hoOffice->id,
        ])
        ->assertRedirect(route('contact-message.index'))
        ->assertSessionHasErrors(['assigned_office_id']);

    $this->actingAs($this->superAdminUser)
        ->from(route('contact-message.index'))
        ->patch(route('contact-message.updateStatus', $message), [
            'assigned_office_id' => $this->inactiveOffice->id,
        ])
        ->assertRedirect(route('contact-message.index'))
        ->assertSessionHasErrors(['assigned_office_id']);

    Mail::assertNothingSent();

    $message->refresh();
    expect($message->assigned_office_id)->toBeNull();
});

it('prevents branch admins from deleting contact messages', function () {
    $message = ContactMessage::factory()
        ->assignedTo($this->jakartaOffice)
        ->create();

    $this->actingAs($this->jakartaAdminUser)
        ->delete(route('contact-message.destroy', $message))
        ->assertForbidden();

    $this->assertDatabaseHas('contact_messages', [
        'id' => $message->id,
    ]);
});
