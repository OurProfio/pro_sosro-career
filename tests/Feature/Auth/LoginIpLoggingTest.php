<?php

use App\Models\LoginLog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('records last login ip, timestamp, and login log history when applicant logs in', function () {
    $user = User::factory()->create([
        'role' => 'user',
        'is_active' => true,
        'password' => 'password123',
        'email_verified_at' => now(),
    ]);

    $response = $this->withServerVariables(['REMOTE_ADDR' => '203.0.113.10'])
        ->withHeader('User-Agent', 'SosroTestBrowser/1.0')
        ->post(route('guest.login.post'), [
            'email' => $user->email,
            'password' => 'password123',
        ]);

    $response->assertRedirect(route('applicant.dashboard'));

    $user->refresh();
    expect($user->last_login_ip)->toBe('203.0.113.10')
        ->and($user->last_login_at)->not->toBeNull();

    expect(LoginLog::where('user_id', $user->id)->count())->toBe(1);
    $log = LoginLog::where('user_id', $user->id)->first();
    expect($log->ip_address)->toBe('203.0.113.10')
        ->and($log->user_agent)->toBe('SosroTestBrowser/1.0')
        ->and($log->logged_in_at)->not->toBeNull();
});

it('records last login ip and login log history when admin logs in', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
        'is_active' => true,
        'password' => 'adminpass123',
    ]);

    $response = $this->withServerVariables(['REMOTE_ADDR' => '198.51.100.25'])
        ->withHeader('User-Agent', 'AdminAgent/2.0')
        ->post(route('admin.login.post'), [
            'email' => $admin->email,
            'password' => 'adminpass123',
        ]);

    $response->assertRedirect(route('admin.dashboard'));

    $admin->refresh();
    expect($admin->last_login_ip)->toBe('198.51.100.25')
        ->and($admin->last_login_at)->not->toBeNull();

    $log = $admin->loginLogs()->first();
    expect($log)->not->toBeNull()
        ->and($log->ip_address)->toBe('198.51.100.25')
        ->and($log->user_agent)->toBe('AdminAgent/2.0');
});

it('updates last login ip on subsequent logins while keeping full history in login_logs', function () {
    $user = User::factory()->create([
        'role' => 'user',
        'is_active' => true,
        'password' => 'password123',
        'email_verified_at' => now(),
    ]);

    $this->withServerVariables(['REMOTE_ADDR' => '203.0.113.1'])
        ->post(route('guest.login.post'), ['email' => $user->email, 'password' => 'password123']);

    $this->post(route('auth.logout'));

    $this->withServerVariables(['REMOTE_ADDR' => '203.0.113.2'])
        ->post(route('guest.login.post'), ['email' => $user->email, 'password' => 'password123']);

    $user->refresh();
    expect($user->last_login_ip)->toBe('203.0.113.2')
        ->and($user->loginLogs()->count())->toBe(2)
        ->and($user->loginLogs()->pluck('ip_address')->all())->toBe(['203.0.113.1', '203.0.113.2']);
});

it('does not record login ip when login fails or user is inactive or wrong role', function () {
    $inactiveUser = User::factory()->create([
        'role' => 'user',
        'is_active' => false,
        'password' => 'password123',
    ]);

    $adminUser = User::factory()->create([
        'role' => 'admin',
        'is_active' => true,
        'password' => 'password123',
    ]);

    $this->withServerVariables(['REMOTE_ADDR' => '203.0.113.50'])
        ->post(route('guest.login.post'), ['email' => $inactiveUser->email, 'password' => 'wrong']);

    $this->withServerVariables(['REMOTE_ADDR' => '203.0.113.51'])
        ->post(route('guest.login.post'), ['email' => $inactiveUser->email, 'password' => 'password123']);

    $this->withServerVariables(['REMOTE_ADDR' => '203.0.113.52'])
        ->post(route('guest.login.post'), ['email' => $adminUser->email, 'password' => 'password123']);

    expect(LoginLog::count())->toBe(0)
        ->and($inactiveUser->fresh()->last_login_ip)->toBeNull()
        ->and($adminUser->fresh()->last_login_ip)->toBeNull();
});
