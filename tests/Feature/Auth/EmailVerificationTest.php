<?php

use App\Models\Admin;
use App\Models\Applicant;
use App\Models\Application;
use App\Models\Job;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;

uses(RefreshDatabase::class);

it('logs in the applicant, sends a verification email, and redirects to notice page after registration', function () {
    Notification::fake();

    $this->post(route('guest.register.post'), [
        'email' => 'kandidat@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ])->assertRedirect(route('verification.notice'))
        ->assertSessionHas('success', 'Pendaftaran berhasil. Silakan cek email Anda untuk verifikasi akun.');

    $user = User::where('email', 'kandidat@example.com')->firstOrFail();

    expect($user->hasVerifiedEmail())->toBeFalse();
    Notification::assertSentTo($user, VerifyEmail::class);
    expect(auth()->check())->toBeTrue();
    expect(auth()->id())->toBe($user->id);
});

it('allows a newly registered applicant to verify email and enter dashboard without visiting login', function () {
    Notification::fake();

    $this->post(route('guest.register.post'), [
        'email' => 'baru@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ])->assertRedirect(route('verification.notice'));

    $user = User::where('email', 'baru@example.com')->firstOrFail();

    $this->get(route('applicant.dashboard'))->assertRedirect(route('verification.notice'));

    $url = URL::temporarySignedRoute('verification.verify', now()->addMinutes(15), [
        'id' => $user->id,
        'hash' => sha1($user->email),
    ]);

    $this->get($url)->assertRedirect(route('applicant.dashboard'));

    expect($user->fresh()->hasVerifiedEmail())->toBeTrue();

    $this->get(route('applicant.dashboard'))->assertOk();
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

it('prevents unverified applicants from submitting an application', function () {
    $user = User::factory()->unverified()->create();
    Applicant::factory()->create(['user_id' => $user->id]);
    $job = Job::factory()->create([
        'status' => 'aktif',
        'closing_date' => now()->addDays(14)->toDateString(),
    ]);

    $this->actingAs($user)
        ->post(route('applications.store'), ['job_id' => $job->id])
        ->assertRedirect(route('verification.notice'));

    expect(Application::count())->toBe(0);
});

it('does not require email verification for admin routes', function () {
    $adminUser = User::factory()->admin()->unverified()->create();
    Admin::factory()->create(['user_id' => $adminUser->id]);

    $this->actingAs($adminUser)
        ->get(route('admin.dashboard'))
        ->assertOk();
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

    $this->actingAs($user)
        ->get($url)
        ->assertForbidden()
        ->assertViewIs('guest.verify-email-invalid')
        ->assertViewHas('isExpired', true)
        ->assertSee('Kedaluwarsa')
        ->assertSee('Kirim Ulang Link Verifikasi');

    expect($user->fresh()->hasVerifiedEmail())->toBeFalse();
});

it('renders invalid verification page when signature is tampered', function () {
    $user = User::factory()->unverified()->create();

    $url = URL::temporarySignedRoute('verification.verify', now()->addMinutes(15), [
        'id' => $user->id,
        'hash' => sha1($user->email),
    ]);

    $tamperedUrl = preg_replace('/signature=[^&]+/', 'signature=invalid', $url);

    $this->actingAs($user)
        ->get($tamperedUrl)
        ->assertForbidden()
        ->assertViewIs('guest.verify-email-invalid')
        ->assertViewHas('isExpired', false)
        ->assertSee('Tidak Valid');

    expect($user->fresh()->hasVerifiedEmail())->toBeFalse();
});

it('resends the verification email', function () {
    Notification::fake();
    $user = User::factory()->unverified()->create();

    $this->actingAs($user)->post(route('verification.send'))->assertRedirect(route('verification.notice'));

    Notification::assertSentTo($user, VerifyEmail::class);
});

it('verifies the email after a guest opens the link and logs in', function () {
    $user = User::factory()->unverified()->create();
    $url = URL::temporarySignedRoute('verification.verify', now()->addMinutes(15), [
        'id' => $user->id,
        'hash' => sha1($user->email),
    ]);

    $this->get($url)->assertRedirect(route('guest.login'));

    $this->post(route('guest.login.post'), [
        'email' => $user->email,
        'password' => 'password',
    ])->assertRedirect($url);

    $this->get($url)->assertRedirect(route('applicant.dashboard'));
    expect($user->fresh()->hasVerifiedEmail())->toBeTrue();
});

it('forbids verifying another users email', function () {
    $owner = User::factory()->unverified()->create();
    $intruder = User::factory()->unverified()->create();
    $url = URL::temporarySignedRoute('verification.verify', now()->addMinutes(15), [
        'id' => $owner->id,
        'hash' => sha1($owner->email),
    ]);

    $this->actingAs($intruder)->get($url)->assertForbidden();

    expect($owner->fresh()->hasVerifiedEmail())->toBeFalse();
});

it('sends verification email and redirects an unverified applicant to notice page after login', function () {
    Notification::fake();
    $user = User::factory()->unverified()->create([
        'password' => bcrypt('password123'),
    ]);

    $this->post(route('guest.login.post'), [
        'email' => $user->email,
        'password' => 'password123',
    ])->assertRedirect(route('verification.notice'));

    Notification::assertSentTo($user, VerifyEmail::class);
    expect(auth()->check())->toBeTrue();
});

it('does not send verification email and redirects to dashboard when verified applicant logs in', function () {
    Notification::fake();
    $user = User::factory()->create([
        'password' => bcrypt('password123'),
    ]);

    $this->post(route('guest.login.post'), [
        'email' => $user->email,
        'password' => 'password123',
    ])->assertRedirect(route('applicant.dashboard'));

    Notification::assertNothingSent();
    expect(auth()->check())->toBeTrue();
});
