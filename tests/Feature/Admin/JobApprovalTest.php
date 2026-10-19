<?php

use App\Models\Admin;
use App\Models\Applicant;
use App\Models\Job;
use App\Models\Office;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function jobPayload(Office $office, array $overrides = []): array
{
    return $overrides + [
        'office_id' => $office->id,
        'title' => 'Staff Produksi',
        'category' => 'profesional',
        'occupation' => 'Produksi',
        'type' => 'Full-Time',
        'location' => 'Bekasi',
        'description' => 'Deskripsi',
        'qualification' => 'Kualifikasi',
        'opening_date' => today()->toDateString(),
        'closing_date' => today()->addMonth()->toDateString(),
    ];
}

beforeEach(function () {
    $this->office = Office::factory()->create();
    $this->kpw = Admin::factory()->for($this->office)->create(['role' => 'admin']);
    $this->ho = Admin::factory()->create(['role' => 'superadmin']);
});

it('creates a pending job when a regular admin posts it', function () {
    $this->actingAs($this->kpw->user)
        ->post(route('job.store'), jobPayload($this->office))
        ->assertRedirect(route('job.index'));

    expect(Job::firstOrFail())
        ->approval_status->toBe('pending')
        ->approved_by->toBeNull();
});

it('forces a regular admin to post to their own office', function () {
    $otherOffice = Office::factory()->create();

    $this->actingAs($this->kpw->user)
        ->post(route('job.store'), jobPayload($otherOffice));

    expect(Job::firstOrFail()->office_id)->toBe($this->office->id);
});

it('auto-approves a job posted by a superadmin', function () {
    $this->actingAs($this->ho->user)
        ->post(route('job.store'), jobPayload($this->office));

    expect(Job::firstOrFail())
        ->approval_status->toBe('approved')
        ->approved_by->toBe($this->ho->id);
});

it('lets a superadmin approve a pending job', function () {
    $job = Job::factory()->pending()->create();

    $this->actingAs($this->ho->user)
        ->patch(route('job.approve', $job))
        ->assertRedirect();

    expect($job->fresh())
        ->approval_status->toBe('approved')
        ->approved_by->toBe($this->ho->id);
});

it('lets a superadmin reject a job with a reason', function () {
    $job = Job::factory()->pending()->create();

    $this->actingAs($this->ho->user)
        ->patch(route('job.reject', $job), ['rejection_reason' => 'Kuota tidak sesuai'])
        ->assertRedirect();

    expect($job->fresh())
        ->approval_status->toBe('rejected')
        ->rejection_reason->toBe('Kuota tidak sesuai');
});

it('requires a reason to reject a job', function () {
    $job = Job::factory()->pending()->create();

    $this->actingAs($this->ho->user)
        ->patch(route('job.reject', $job), [])
        ->assertSessionHasErrors('rejection_reason');

    expect($job->fresh()->approval_status)->toBe('pending');
});

it('forbids a regular admin from approving or rejecting', function () {
    $job = Job::factory()->pending()->create();

    $this->actingAs($this->kpw->user)->patch(route('job.approve', $job))->assertForbidden();
    $this->actingAs($this->kpw->user)
        ->patch(route('job.reject', $job), ['rejection_reason' => 'x'])
        ->assertForbidden();

    expect($job->fresh()->approval_status)->toBe('pending');
});

it('sends an edited job back to pending when a regular admin updates it', function () {
    $job = Job::factory()->for($this->office)->create();

    $this->actingAs($this->kpw->user)
        ->put(route('job.update', $job), jobPayload($this->office, [
            'status' => 'aktif',
            'opening_date' => today()->subDay()->toDateString(),
        ]))
        ->assertRedirect(route('job.index'));

    expect($job->fresh())
        ->approval_status->toBe('pending')
        ->approved_by->toBeNull();
});

it('only shows approved jobs on the public page', function () {
    Job::factory()->create(['title' => 'Lowongan Disetujui']);
    Job::factory()->pending()->create(['title' => 'Lowongan Pending']);
    Job::factory()->rejected()->create(['title' => 'Lowongan Ditolak']);

    $this->get(route('guest.index'))
        ->assertSee('Lowongan Disetujui')
        ->assertDontSee('Lowongan Pending')
        ->assertDontSee('Lowongan Ditolak');
});

it('rejects applications to jobs that are not approved', function () {
    $job = Job::factory()->pending()->create();
    $applicant = Applicant::factory()->create();

    $this->actingAs($applicant->user)
        ->post(route('applications.store'), ['job_id' => $job->id])
        ->assertSessionHas('error');

    expect($job->applications()->count())->toBe(0);
});
