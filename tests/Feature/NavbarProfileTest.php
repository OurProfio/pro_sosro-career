<?php

use App\Models\Admin;
use App\Models\Applicant;
use App\Models\Office;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('renders Dashboard Admin link in navbar when logged in as admin', function () {
    $office = Office::factory()->create();
    $adminUser = User::factory()->create([
        'role' => 'admin',
        'email_verified_at' => now(),
    ]);

    Admin::factory()->create([
        'user_id' => $adminUser->id,
        'office_id' => $office->id,
        'name' => 'Budi Administrator',
        'role' => 'admin',
        'is_active' => true,
    ]);

    $this->actingAs($adminUser)
        ->get(route('guest.index'))
        ->assertOk()
        ->assertSee('Dashboard Admin')
        ->assertSee(route('admin.dashboard'))
        ->assertDontSee('Dashboard Pelamar');
});

it('renders Dashboard Pelamar link in navbar when logged in as applicant', function () {
    $applicantUser = User::factory()->create([
        'role' => 'user',
        'email_verified_at' => now(),
    ]);

    Applicant::factory()->create([
        'user_id' => $applicantUser->id,
        'name' => 'Siti Pelamar',
        'gender' => 'p',
    ]);

    $this->actingAs($applicantUser)
        ->get(route('guest.index'))
        ->assertOk()
        ->assertSee('Dashboard Pelamar')
        ->assertSee(route('applicant.dashboard'))
        ->assertDontSee('Dashboard Admin');
});
