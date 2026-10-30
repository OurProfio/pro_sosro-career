<?php

use App\Models\Admin;
use App\Models\Job;
use App\Models\Office;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->officeA = Office::factory()->create(['name' => 'Kantor Cabang A']);
    $this->officeB = Office::factory()->create(['name' => 'Kantor Cabang B']);

    $this->superAdminProfile = Admin::factory()->create([
        'role' => 'superadmin',
        'office_id' => $this->officeA->id,
    ]);
    $this->superAdminUser = $this->superAdminProfile->user;

    $this->adminBranchAProfile = Admin::factory()->create([
        'role' => 'admin',
        'office_id' => $this->officeA->id,
    ]);
    $this->adminBranchAUser = $this->adminBranchAProfile->user;

    $this->adminBranchBProfile = Admin::factory()->create([
        'role' => 'admin',
        'office_id' => $this->officeB->id,
    ]);
    $this->adminBranchBUser = $this->adminBranchBProfile->user;

    $this->jobOfficeA = Job::factory()->create([
        'office_id' => $this->officeA->id,
        'title' => 'Lowongan Cabang A',
        'status' => 'aktif',
    ]);

    $this->jobOfficeB = Job::factory()->create([
        'office_id' => $this->officeB->id,
        'title' => 'Lowongan Cabang B',
        'status' => 'aktif',
    ]);
});

it('allows superadmin to see vacancies from all offices', function () {
    $response = $this->actingAs($this->superAdminUser)
        ->get(route('job.index'));

    $response->assertOk();
    $response->assertSee('Lowongan Cabang A');
    $response->assertSee('Lowongan Cabang B');
    $response->assertSee('Semua Wilayah');
});

it('scopes vacancies to the admin own office only', function () {
    $response = $this->actingAs($this->adminBranchAUser)
        ->get(route('job.index'));

    $response->assertOk();
    $response->assertSee('Lowongan Cabang A');
    $response->assertDontSee('Lowongan Cabang B');
    $response->assertDontSee('Semua Wilayah');
    $response->assertSee('Kantor Cabang A');
});

it('prevents regular admin from accessing jobs of another office', function () {
    $this->actingAs($this->adminBranchAUser)
        ->get(route('job.show', $this->jobOfficeB))
        ->assertForbidden();

    $this->actingAs($this->adminBranchAUser)
        ->delete(route('job.destroy', $this->jobOfficeB))
        ->assertForbidden();
});
