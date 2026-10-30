<?php

use App\Models\Admin;
use App\Models\Applicant;
use App\Models\Application;
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

    // Jobs
    $this->jobA = Job::factory()->create([
        'office_id' => $this->officeA->id,
        'title' => 'Software Engineer Cabang A',
        'status' => 'aktif',
        'opening_date' => today()->subDays(2),
        'closing_date' => today()->addDays(10),
    ]);

    $this->jobB = Job::factory()->create([
        'office_id' => $this->officeB->id,
        'title' => 'Accountant Cabang B',
        'status' => 'aktif',
        'opening_date' => today()->subDays(2),
        'closing_date' => today()->addDays(10),
    ]);

    // Applicants & Applications
    $this->applicantA = Applicant::factory()->create(['name' => 'Kandidat Cabang A']);
    $this->applicationA = Application::factory()->create([
        'applicant_id' => $this->applicantA->id,
        'job_id' => $this->jobA->id,
        'status' => 'pending',
    ]);

    $this->applicantB = Applicant::factory()->create(['name' => 'Kandidat Cabang B']);
    $this->applicationB = Application::factory()->create([
        'applicant_id' => $this->applicantB->id,
        'job_id' => $this->jobB->id,
        'status' => 'pending',
    ]);
});

it('shows all applications and jobs across branches on superadmin dashboard', function () {
    $response = $this->actingAs($this->superAdminUser)
        ->get(route('admin.dashboard'));

    $response->assertOk();
    $response->assertViewHas('pendingApplicationsCount', 2);
    $response->assertViewHas('activeJobsCount', 2);
    $response->assertSee('Kandidat Cabang A');
    $response->assertSee('Kandidat Cabang B');
    $response->assertSee('Software Engineer Cabang A');
    $response->assertSee('Accountant Cabang B');
});

it('scopes dashboard cards and recent applications to the admin own office only', function () {
    $response = $this->actingAs($this->adminBranchAUser)
        ->get(route('admin.dashboard'));

    $response->assertOk();
    $response->assertViewHas('pendingApplicationsCount', 1);
    $response->assertViewHas('activeJobsCount', 1);
    $response->assertSee('Kandidat Cabang A');
    $response->assertDontSee('Kandidat Cabang B');
    $response->assertSee('Software Engineer Cabang A');
    $response->assertDontSee('Accountant Cabang B');
});
