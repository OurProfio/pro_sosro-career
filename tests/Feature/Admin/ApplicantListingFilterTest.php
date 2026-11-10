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

    $this->jobA = Job::factory()->create([
        'office_id' => $this->officeA->id,
        'title' => 'Lowongan Kantor A',
        'status' => 'aktif',
    ]);

    $this->jobB = Job::factory()->create([
        'office_id' => $this->officeB->id,
        'title' => 'Lowongan Kantor B',
        'status' => 'aktif',
    ]);
});

it('does not display applicants with incomplete biodata or without job applications', function () {
    // 1. Pelamar dengan biodata belum lengkap & belum melamar
    $incompleteApplicant = Applicant::factory()->incomplete()->create([
        'name' => 'Kandidat Belum Lengkap',
    ]);

    // 2. Pelamar dengan biodata lengkap TAPI belum pernah melamar
    $completedNoAppApplicant = Applicant::factory()->create([
        'name' => 'Kandidat Lengkap Tanpa Lamaran',
        'is_completed' => true,
    ]);

    // 3. Pelamar dengan biodata lengkap DAN sudah pernah melamar
    $appliedApplicant = Applicant::factory()->create([
        'name' => 'Kandidat Sudah Melamar',
        'is_completed' => true,
    ]);
    Application::factory()->create([
        'applicant_id' => $appliedApplicant->id,
        'job_id' => $this->jobA->id,
    ]);

    $response = $this->actingAs($this->superAdminUser)
        ->get(route('applicant.index'));

    $response->assertOk();
    $response->assertSee('Kandidat Sudah Melamar');
    $response->assertDontSee('Kandidat Belum Lengkap');
    $response->assertDontSee('Kandidat Lengkap Tanpa Lamaran');
});

it('scopes applicants in applicant.index to the admin branch office', function () {
    $applicantA = Applicant::factory()->create([
        'name' => 'Kandidat Cabang A',
        'is_completed' => true,
    ]);
    Application::factory()->create([
        'applicant_id' => $applicantA->id,
        'job_id' => $this->jobA->id,
    ]);

    $applicantB = Applicant::factory()->create([
        'name' => 'Kandidat Cabang B',
        'is_completed' => true,
    ]);
    Application::factory()->create([
        'applicant_id' => $applicantB->id,
        'job_id' => $this->jobB->id,
    ]);

    // Admin Cabang A hanya melihat pelamar lowongan Cabang A
    $response = $this->actingAs($this->adminBranchAUser)
        ->get(route('applicant.index'));

    $response->assertOk();
    $response->assertSee('Kandidat Cabang A');
    $response->assertDontSee('Kandidat Cabang B');

    // Super Admin melihat semua pelamar yang sudah melamar
    $superResponse = $this->actingAs($this->superAdminUser)
        ->get(route('applicant.index'));

    $superResponse->assertOk();
    $superResponse->assertSee('Kandidat Cabang A');
    $superResponse->assertSee('Kandidat Cabang B');
});

it('returns 404 when viewing or printing applicant without applications', function () {
    $applicantWithoutApp = Applicant::factory()->create([
        'name' => 'Kandidat Nol Lamaran',
        'is_completed' => true,
    ]);

    $this->actingAs($this->superAdminUser)
        ->get(route('applicant.show', $applicantWithoutApp))
        ->assertNotFound();

    $this->actingAs($this->superAdminUser)
        ->get(route('applicant.print', $applicantWithoutApp))
        ->assertNotFound();
});
