<?php

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;

uses(RefreshDatabase::class);

it('sends a verification email and shows the notice page after registration', function () {
    Notification::fake();

    $this->post(route('guest.register.post'), [
        'email' => 'kandidat@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ])->assertRedirect(route('verification.notice'));

    $user = User::where('email', 'kandidat@example.com')->firstOrFail();

    expect($user->hasVerifiedEmail())->toBeFalse();
    Notification::assertSentTo($user, VerifyEmail::class);
});

it('renders the verification email from the career template', function () {
    $user = User::factory()->unverified()->create();

    $html = (new VerifyEmail)->toMail($user)->render();

    expect($html)
        ->toContain('Verifikasi Email')
        ->toContain('Link ini berlaku selama 15 menit')
        ->toContain('HC – Recruitment');
});

it('blocks unverified applicants from applicant routes', function () {
    $user = User::factory()->unverified()->create();

    $this->actingAs($user)
        ->get(route('applicant.dashboard'))
        ->assertRedirect(route('verification.notice'));
});

it('verifies the email through the signed link', function () {
    Event::fake([Verified::class]);
    $user = User::factory()->unverified()->create();

    $url = URL::temporarySignedRoute('verification.verify', now()->addMinutes(15), [
        'id' => $user->id,
        'hash' => sha1($user->email),
    ]);

    $this->actingAs($user)->get($url)->assertRedirect(route('applicant.dashboard'));

    expect($user->fresh()->hasVerifiedEmail())->toBeTrue();
    Event::assertDispatched(Verified::class);
});

it('rejects an expired verification link', function () {
    $user = User::factory()->unverified()->create();

    $url = URL::temporarySignedRoute('verification.verify', now()->subMinute(), [
        'id' => $user->id,
        'hash' => sha1($user->email),
    ]);

    $this->actingAs($user)->get($url)->assertForbidden();
    expect($user->fresh()->hasVerifiedEmail())->toBeFalse();
});

it('resends the verification email', function () {
    Notification::fake();
    $user = User::factory()->unverified()->create();

    $this->actingAs($user)->post(route('verification.send'))->assertRedirect();

    Notification::assertSentTo($user, VerifyEmail::class);
});
