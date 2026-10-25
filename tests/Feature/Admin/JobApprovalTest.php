<?php

use App\Models\Admin;
use App\Models\Job;
use App\Models\Office;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->office = Office::factory()->create();

    $this->superAdminProfile = Admin::factory()->create([
        'role' => 'superadmin',
        'office_id' => $this->office->id,
    ]);
    $this->superAdminUser = $this->superAdminProfile->user;

    $this->adminProfile = Admin::factory()->create([
        'role' => 'admin',
        'office_id' => $this->office->id,
    ]);
    $this->adminUser = $this->adminProfile->user;
});

it('creates an active job directly when created by superadmin', function () {
    $jobPayload = [
        'office_id' => $this->office->id,
        'title' => 'Lowongan Superadmin',
        'category' => 'profesional',
        'occupation' => 'Teknologi Informasi',
        'type' => 'Full-Time',
        'location' => 'Jakarta Barat',
        'description' => 'Deskripsi pekerjaan lowongan superadmin.',
        'qualification' => 'Kualifikasi pekerjaan lowongan superadmin.',
        'closing_date' => now()->addDays(14)->toDateString(),
    ];

    $this->actingAs($this->superAdminUser)
        ->post(route('job.store'), $jobPayload)
        ->assertRedirect(route('job.index'))
        ->assertSessionHas('success');

    $job = Job::where('title', 'Lowongan Superadmin')->first();
    expect($job)->not->toBeNull()
        ->and($job->status)->toBe('aktif');
});

it('creates a pending job when created by regular admin', function () {
    $jobPayload = [
        'office_id' => $this->office->id,
        'title' => 'Lowongan Admin Cabang',
        'category' => 'profesional',
        'occupation' => 'Operasional',
        'type' => 'Kontrak',
        'location' => 'Bandung',
        'description' => 'Deskripsi pekerjaan lowongan cabang.',
        'qualification' => 'Kualifikasi pekerjaan lowongan cabang.',
        'closing_date' => now()->addDays(10)->toDateString(),
    ];

    $this->actingAs($this->adminUser)
        ->post(route('job.store'), $jobPayload)
        ->assertRedirect(route('job.index'))
        ->assertSessionHas('success');

    $job = Job::where('title', 'Lowongan Admin Cabang')->first();
    expect($job)->not->toBeNull()
        ->and($job->status)->toBe('pending')
        ->and($job->office_id)->toBe($this->office->id);
});

it('automatically sets branch admin office_id even if branch admin sends a different or empty office_id', function () {
    $otherOffice = Office::factory()->create();

    $jobPayload = [
        'office_id' => $otherOffice->id,
        'title' => 'Lowongan Cabang Auto Office',
        'category' => 'profesional',
        'occupation' => 'Logistik',
        'type' => 'Full-Time',
        'location' => 'Semarang',
        'description' => 'Deskripsi pekerjaan lowongan auto office.',
        'qualification' => 'Kualifikasi pekerjaan lowongan auto office.',
        'closing_date' => now()->addDays(7)->toDateString(),
    ];

    $this->actingAs($this->adminUser)
        ->post(route('job.store'), $jobPayload)
        ->assertRedirect(route('job.index'))
        ->assertSessionHas('success');

    $job = Job::where('title', 'Lowongan Cabang Auto Office')->first();
    expect($job)->not->toBeNull()
        ->and($job->office_id)->toBe($this->office->id);
});

it('does not display pending jobs on the applicant / guest vacancy page', function () {
    $pendingJob = Job::factory()->create([
        'title' => 'Lowongan Rahasia Pending',
        'status' => 'pending',
        'closing_date' => now()->addDays(10)->toDateString(),
    ]);

    $activeJob = Job::factory()->create([
        'title' => 'Lowongan Publik Aktif',
        'status' => 'aktif',
        'closing_date' => now()->addDays(10)->toDateString(),
    ]);

    $this->get(route('guest.index'))
        ->assertOk()
        ->assertSee('Lowongan Publik Aktif')
        ->assertDontSee('Lowongan Rahasia Pending');
});

it('allows superadmin to approve a pending job and then it appears to applicants', function () {
    $pendingJob = Job::factory()->create([
        'title' => 'Lowongan Menunggu Persetujuan',
        'status' => 'pending',
        'closing_date' => now()->addDays(10)->toDateString(),
    ]);

    $this->actingAs($this->superAdminUser)
        ->patch(route('job.approve', $pendingJob))
        ->assertRedirect()
        ->assertSessionHas('success');

    expect($pendingJob->fresh()->status)->toBe('aktif');

    $this->get(route('guest.index'))
        ->assertOk()
        ->assertSee('Lowongan Menunggu Persetujuan');
});

it('prevents regular admin from approving jobs', function () {
    $pendingJob = Job::factory()->create([
        'title' => 'Lowongan Cabang',
        'status' => 'pending',
        'closing_date' => now()->addDays(10)->toDateString(),
    ]);

    $this->actingAs($this->adminUser)
        ->patch(route('job.approve', $pendingJob))
        ->assertForbidden();

    expect($pendingJob->fresh()->status)->toBe('pending');
});

it('displays the pending tab and pending vacancies in admin job index', function () {
    $pendingJob = Job::factory()->create([
        'title' => 'Lowongan Status Pending',
        'status' => 'pending',
        'closing_date' => now()->addDays(10)->toDateString(),
    ]);

    $this->actingAs($this->superAdminUser)
        ->get(route('job.index'))
        ->assertOk()
        ->assertSee('Lowongan Ditunda')
        ->assertSee('Lowongan Status Pending')
        ->assertSee('Ditunda (Pending)');
});
