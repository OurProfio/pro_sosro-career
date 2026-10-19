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
        ->assertRedirect(route('guest.login'));

    $this->get(route('applicant.dashboard'))
        ->assertRedirect(route('guest.login'));
});
