<?php

use App\Models\Admin;
use App\Models\Applicant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->adminProfile = Admin::factory()->create();
    $this->adminUser = $this->adminProfile->user;
    $this->applicantUser = User::factory()->create(['role' => 'user']);
    $this->applicant = Applicant::factory()->create(['user_id' => $this->applicantUser->id]);
});

it('allows admin to access admin routes', function () {
    $this->actingAs($this->adminUser)
        ->get(route('admin.dashboard'))
        ->assertOk();
});

it('redirects admin to admin dashboard when accessing applicant routes', function () {
    $this->actingAs($this->adminUser)
        ->get(route('applicant.dashboard'))
        ->assertRedirect(route('admin.dashboard'));
});

it('allows applicant to access applicant routes', function () {
    $this->actingAs($this->applicantUser)
        ->get(route('applicant.dashboard'))
        ->assertOk();
});

it('redirects applicant to applicant dashboard when accessing admin routes', function () {
    $this->actingAs($this->applicantUser)
        ->get(route('admin.dashboard'))
        ->assertRedirect(route('applicant.dashboard'));
});

it('redirects guest to login when accessing protected admin or applicant routes', function () {
    $this->get(route('admin.dashboard'))
        ->assertRedirect(route('admin.login'));

    $this->get(route('applicant.dashboard'))
        ->assertRedirect(route('guest.login'));
});

it('renders admin login page successfully without register button in navbar', function () {
    $this->get(route('admin.login'))
        ->assertOk()
        ->assertSee('Masuk sebagai')
        ->assertSee('Admin')
        ->assertDontSee('px-6 py-2 bg-white text-red-700 font-bold rounded-full');
});

it('allows admin to login via admin.login and rejects applicant', function () {
    $this->post(route('admin.login.post'), [
        'email' => $this->adminUser->email,
        'password' => 'password',
    ])->assertRedirect(route('admin.dashboard'));

    $this->assertAuthenticatedAs($this->adminUser);

    auth()->logout();

    $this->post(route('admin.login.post'), [
        'email' => $this->applicantUser->email,
        'password' => 'password',
    ])->assertSessionHas('error');

    $this->assertGuest();
});

it('allows applicant to login via guest.login and rejects admin', function () {
    $this->post(route('guest.login.post'), [
        'email' => $this->applicantUser->email,
        'password' => 'password',
    ])->assertRedirect(route('applicant.dashboard'));

    $this->assertAuthenticatedAs($this->applicantUser);

    auth()->logout();

    $this->post(route('guest.login.post'), [
        'email' => $this->adminUser->email,
        'password' => 'password',
    ])->assertSessionHas('error');

    $this->assertGuest();
});
