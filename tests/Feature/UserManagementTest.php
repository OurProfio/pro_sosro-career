<?php

use App\Models\Admin;
use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;

uses(RefreshDatabase::class);

it('sends a verification email when a superadmin creates an applicant account', function () {
    Notification::fake();

    $superAdminUser = Admin::factory()->create(['role' => 'superadmin'])->user;

    $this->actingAs($superAdminUser)
        ->post(route('user.store'), [
            'email' => 'pelamar-baru@example.com',
            'password' => 'password123',
        ])
        ->assertRedirect(route('user.index'));

    $user = User::where('email', 'pelamar-baru@example.com')->firstOrFail();

    expect($user->role)->toBe('user')
        ->and($user->hasVerifiedEmail())->toBeFalse()
        ->and($user->is_active)->toBeTrue();
    Notification::assertSentTo($user, VerifyEmail::class);
});

it('deactivates an applicant account instead of deleting when destroyed', function () {
    $superAdminUser = Admin::factory()->create(['role' => 'superadmin'])->user;
    $user = User::factory()->create(['role' => 'user', 'is_active' => true]);

    $this->actingAs($superAdminUser)
        ->delete(route('user.destroy', $user))
        ->assertRedirect(route('user.index'))
        ->assertSessionHas('success');

    expect($user->fresh()->is_active)->toBeFalse();
    expect(User::where('id', $user->id)->exists())->toBeTrue();
});

it('toggles active status of a user via toggleStatus', function () {
    $superAdminUser = Admin::factory()->create(['role' => 'superadmin'])->user;
    $user = User::factory()->create(['role' => 'user', 'is_active' => true]);

    // Deactivate
    $this->actingAs($superAdminUser)
        ->patch(route('user.toggleStatus', $user))
        ->assertRedirect(route('user.index'))
        ->assertSessionHas('success');

    expect($user->fresh()->is_active)->toBeFalse();

    // Reactivate
    $this->actingAs($superAdminUser)
        ->patch(route('user.toggleStatus', $user))
        ->assertRedirect(route('user.index'))
        ->assertSessionHas('success');

    expect($user->fresh()->is_active)->toBeTrue();
});

it('prevents deactivated user from logging in', function () {
    $user = User::factory()->create([
        'email' => 'nonaktif@example.com',
        'password' => bcrypt('password123'),
        'role' => 'user',
        'is_active' => false,
    ]);

    $this->post(route('guest.login.post'), [
        'email' => 'nonaktif@example.com',
        'password' => 'password123',
    ])
        ->assertSessionHas('error', 'Akun Anda telah dinonaktifkan. Silakan hubungi pihak administrator.');

    $this->assertGuest();
});
