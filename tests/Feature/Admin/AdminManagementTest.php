<?php

use App\Models\Admin;
use App\Models\Office;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->office1 = Office::factory()->create(['name' => 'Kantor Pusat']);
    $this->office2 = Office::factory()->create(['name' => 'Kantor Cabang']);

    $this->superAdminProfile = Admin::factory()->create([
        'role' => 'superadmin',
        'office_id' => $this->office1->id,
    ]);
    $this->superAdminUser = $this->superAdminProfile->user;

    $this->targetAdminProfile = Admin::factory()->create([
        'name' => 'Admin Lama',
        'role' => 'admin',
        'office_id' => $this->office1->id,
    ]);
    $this->targetAdminUser = $this->targetAdminProfile->user;
});

it('allows superadmin to update admin data successfully', function () {
    $updatePayload = [
        'name' => 'Admin Baru Diperbarui',
        'email' => 'admin_baru@example.com',
        'office_id' => $this->office2->id,
        'role' => 'superadmin',
    ];

    $this->actingAs($this->superAdminUser)
        ->put(route('admin.update', $this->targetAdminProfile), $updatePayload)
        ->assertRedirect(route('admin.index'))
        ->assertSessionHas('success');

    $this->targetAdminProfile->refresh();
    $this->targetAdminUser->refresh();

    expect($this->targetAdminProfile->name)->toBe('Admin Baru Diperbarui')
        ->and($this->targetAdminProfile->role)->toBe('superadmin')
        ->and($this->targetAdminProfile->office_id)->toBe($this->office2->id)
        ->and($this->targetAdminUser->email)->toBe('admin_baru@example.com');
});

it('allows superadmin to update admin keeping the same email', function () {
    $updatePayload = [
        'name' => 'Admin Nama Baru',
        'email' => $this->targetAdminUser->email,
        'office_id' => $this->office1->id,
        'role' => 'admin',
    ];

    $this->actingAs($this->superAdminUser)
        ->put(route('admin.update', $this->targetAdminProfile), $updatePayload)
        ->assertRedirect(route('admin.index'))
        ->assertSessionHas('success');

    $this->targetAdminProfile->refresh();
    expect($this->targetAdminProfile->name)->toBe('Admin Nama Baru');
});

it('allows superadmin to update admin password if provided', function () {
    $updatePayload = [
        'name' => $this->targetAdminProfile->name,
        'email' => $this->targetAdminUser->email,
        'password' => 'newpassword123',
        'office_id' => $this->office1->id,
        'role' => 'admin',
    ];

    $this->actingAs($this->superAdminUser)
        ->put(route('admin.update', $this->targetAdminProfile), $updatePayload)
        ->assertRedirect(route('admin.index'))
        ->assertSessionHas('success');

    $this->targetAdminUser->refresh();
    expect(Hash::check('newpassword123', $this->targetAdminUser->password))->toBeTrue();
});

it('allows superadmin to create a new admin successfully', function () {
    $createPayload = [
        'name' => 'Admin Baru Dibuat',
        'email' => 'admin_fresh@example.com',
        'password' => 'secret1234',
        'office_id' => $this->office1->id,
        'role' => 'admin',
    ];

    $this->actingAs($this->superAdminUser)
        ->post(route('admin.store'), $createPayload)
        ->assertRedirect(route('admin.index'))
        ->assertSessionHas('success');

    $newAdmin = Admin::where('name', 'Admin Baru Dibuat')->first();
    expect($newAdmin)->not->toBeNull()
        ->and($newAdmin->user->email)->toBe('admin_fresh@example.com');
});

it('prevents regular admin from accessing admin update route', function () {
    $updatePayload = [
        'name' => 'Hacker Name',
        'email' => 'hacker@example.com',
        'office_id' => $this->office1->id,
        'role' => 'superadmin',
    ];

    $this->actingAs($this->targetAdminUser)
        ->put(route('admin.update', $this->targetAdminProfile), $updatePayload)
        ->assertForbidden();
});

it('deactivates an admin instead of deleting from the database', function () {
    $this->actingAs($this->superAdminUser)
        ->delete(route('admin.destroy', $this->targetAdminProfile))
        ->assertRedirect(route('admin.index'))
        ->assertSessionHas('success');

    $this->targetAdminProfile->refresh();

    expect($this->targetAdminProfile->is_active)->toBeFalse()
        ->and($this->targetAdminProfile->exists)->toBeTrue()
        ->and($this->targetAdminUser->fresh()->exists)->toBeTrue();
});

it('allows superadmin to toggle admin active status back and forth', function () {
    $this->actingAs($this->superAdminUser)
        ->patch(route('admin.toggleStatus', $this->targetAdminProfile))
        ->assertRedirect(route('admin.index'))
        ->assertSessionHas('success');

    expect($this->targetAdminProfile->fresh()->is_active)->toBeFalse();

    $this->actingAs($this->superAdminUser)
        ->patch(route('admin.toggleStatus', $this->targetAdminProfile))
        ->assertRedirect(route('admin.index'))
        ->assertSessionHas('success');

    expect($this->targetAdminProfile->fresh()->is_active)->toBeTrue();
});

it('prevents a deactivated admin from logging into the admin portal', function () {
    $this->targetAdminProfile->update(['is_active' => false]);

    $this->post(route('admin.login.post'), [
        'email' => $this->targetAdminUser->email,
        'password' => 'password',
    ])
        ->assertRedirect()
        ->assertSessionHas('error');

    $this->assertGuest();
});

it('prevents superadmin from deactivating their own account', function () {
    $this->actingAs($this->superAdminUser)
        ->delete(route('admin.destroy', $this->superAdminProfile))
        ->assertRedirect(route('admin.index'))
        ->assertSessionHas('error');

    expect($this->superAdminProfile->fresh()->is_active)->toBeTrue();
});

it('displays "Lihat Semua Pelamar" button on dashboard for superadmin and admin', function () {
    $this->actingAs($this->superAdminUser)
        ->get(route('admin.dashboard'))
        ->assertOk()
        ->assertSee('Lihat Semua Pelamar');

    $this->actingAs($this->targetAdminUser)
        ->get(route('admin.dashboard'))
        ->assertOk()
        ->assertSee('Lihat Semua Pelamar');
});
