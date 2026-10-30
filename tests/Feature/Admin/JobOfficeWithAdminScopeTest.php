<?php

use App\Models\Admin;
use App\Models\Job;
use App\Models\Office;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->officeWithAdmin = Office::factory()->create(['name' => 'Kantor Cabang Medan']);
    $this->officeWithoutAdmin = Office::factory()->create(['name' => 'Kantor Cabang Tanpa Admin']);

    $this->superAdminProfile = Admin::factory()->create([
        'role' => 'superadmin',
        'office_id' => $this->officeWithAdmin->id,
        'is_active' => true,
    ]);
    $this->superAdminUser = $this->superAdminProfile->user;

    $this->branchAdminProfile = Admin::factory()->create([
        'role' => 'admin',
        'office_id' => $this->officeWithAdmin->id,
        'is_active' => true,
    ]);
    $this->branchAdminUser = $this->branchAdminProfile->user;
});

it('only includes offices with active admins in assignable offices for superadmin', function () {
    $response = $this->actingAs($this->superAdminUser)
        ->get(route('job.index'));

    $response->assertOk();
    $assignableOffices = $response->viewData('assignableOffices');

    expect($assignableOffices->pluck('id'))->toContain($this->officeWithAdmin->id)
        ->and($assignableOffices->pluck('id'))->not->toContain($this->officeWithoutAdmin->id);

    $cities = $response->viewData('cities');
    expect($cities)->toBe(Job::CITIES)
        ->and($cities)->toContain('Medan', 'Jakarta Utara', 'Binjai');
});

it('allows creating a job with valid office having an admin and a valid city', function () {
    $payload = [
        'office_id' => $this->officeWithAdmin->id,
        'title' => 'Staff Operasional Medan',
        'category' => 'profesional',
        'occupation' => 'Operasional',
        'type' => 'Full-Time',
        'location' => 'Medan',
        'description' => 'Deskripsi pekerjaan lengkap.',
        'qualification' => 'Kualifikasi pekerjaan lengkap.',
        'closing_date' => now()->addDays(14)->toDateString(),
    ];

    $this->actingAs($this->superAdminUser)
        ->post(route('job.store'), $payload)
        ->assertRedirect(route('job.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('jobs', [
        'title' => 'Staff Operasional Medan',
        'office_id' => $this->officeWithAdmin->id,
        'location' => 'Medan',
    ]);
});

it('fails validation when creating a job for an office without an active admin', function () {
    $payload = [
        'office_id' => $this->officeWithoutAdmin->id,
        'title' => 'Staff Cabang Tanpa Admin',
        'category' => 'profesional',
        'occupation' => 'Operasional',
        'type' => 'Full-Time',
        'location' => 'Jakarta Utara',
        'description' => 'Deskripsi pekerjaan lengkap.',
        'qualification' => 'Kualifikasi pekerjaan lengkap.',
        'closing_date' => now()->addDays(14)->toDateString(),
    ];

    $this->actingAs($this->superAdminUser)
        ->post(route('job.store'), $payload)
        ->assertSessionHasErrors(['office_id']);
});

it('fails validation when location is not in the predefined city list', function () {
    $payload = [
        'office_id' => $this->officeWithAdmin->id,
        'title' => 'Staff Kota Antah Berantah',
        'category' => 'profesional',
        'occupation' => 'Operasional',
        'type' => 'Full-Time',
        'location' => 'Kota Tidak Dikenal 123',
        'description' => 'Deskripsi pekerjaan lengkap.',
        'qualification' => 'Kualifikasi pekerjaan lengkap.',
        'closing_date' => now()->addDays(14)->toDateString(),
    ];

    $this->actingAs($this->superAdminUser)
        ->post(route('job.store'), $payload)
        ->assertSessionHasErrors(['location']);
});
