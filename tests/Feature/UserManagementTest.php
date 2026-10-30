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
        ->and($user->hasVerifiedEmail())->toBeFalse();
    Notification::assertSentTo($user, VerifyEmail::class);
});
