<?php

use App\Models\Applicant;
use App\Models\Application;
use App\Models\Job;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create(['role' => 'user']);
    $this->applicant = Applicant::factory()->create(['user_id' => $this->user->id]);
    $this->job = Job::factory()->create();
});

it('allows an applicant to cancel their own pending application', function () {
    $application = Application::factory()->create([
        'applicant_id' => $this->applicant->id,
        'job_id' => $this->job->id,
        'status' => 'pending',
    ]);

    $this->actingAs($this->user)
        ->from(route('applications.index'))
        ->patch(route('applications.cancel', $application))
        ->assertRedirect(route('applications.index'))
        ->assertSessionHas('success', 'Lamaran pekerjaan berhasil dibatalkan.');

    expect($application->fresh())
        ->status->toBe('cancelled')
        ->notes->toContain('Dibatalkan oleh pelamar');
});

it('prevents an applicant from cancelling an in-progress application', function () {
    $application = Application::factory()->create([
        'applicant_id' => $this->applicant->id,
        'job_id' => $this->job->id,
        'status' => 'progress',
    ]);

    $this->actingAs($this->user)
        ->from(route('applications.index'))
        ->patch(route('applications.cancel', $application))
        ->assertRedirect(route('applications.index'))
        ->assertSessionHas('error', 'Lamaran ini sudah tidak dapat dibatalkan.');

    expect($application->fresh()->status)->toBe('progress');
});

it('prevents an applicant from cancelling someone elses application', function () {
    $otherUser = User::factory()->create(['role' => 'user']);
    $otherApplicant = Applicant::factory()->create(['user_id' => $otherUser->id]);

    $otherApplication = Application::factory()->create([
        'applicant_id' => $otherApplicant->id,
        'job_id' => $this->job->id,
        'status' => 'pending',
    ]);

    $this->actingAs($this->user)
        ->patch(route('applications.cancel', $otherApplication))
        ->assertForbidden();

    expect($otherApplication->fresh()->status)->toBe('pending');
});

it('prevents cancelling an already accepted or rejected or cancelled application', function () {
    $acceptedApp = Application::factory()->create([
        'applicant_id' => $this->applicant->id,
        'job_id' => $this->job->id,
        'status' => 'accepted',
    ]);

    $this->actingAs($this->user)
        ->from(route('applications.index'))
        ->patch(route('applications.cancel', $acceptedApp))
        ->assertRedirect(route('applications.index'))
        ->assertSessionHas('error', 'Lamaran ini sudah tidak dapat dibatalkan.');

    expect($acceptedApp->fresh()->status)->toBe('accepted');
});

it('does not count cancelled or rejected applications in the active quota', function () {
    foreach (['cancelled', 'rejected', 'progress'] as $status) {
        Application::factory()->create([
            'applicant_id' => $this->applicant->id,
            'job_id' => Job::factory()->create()->id,
            'status' => $status,
        ]);
    }

    $this->actingAs($this->user)
        ->get(route('applications.index'))
        ->assertOk()
        ->assertSeeText('1 / 3 Posisi');
});
