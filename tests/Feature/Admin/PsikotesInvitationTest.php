<?php

use App\Mail\psikotesMail;
use App\Models\Admin;
use App\Models\Application;
use App\Models\Job;
use App\Models\Office;
use App\Models\PsikotesLink;
use App\Models\Stage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

uses(RefreshDatabase::class);

beforeEach(function () {
    Mail::fake();

    $this->officeA = Office::factory()->create(['name' => 'Kantor Cabang A']);
    $this->officeB = Office::factory()->create(['name' => 'Kantor Cabang B']);

    $this->adminA = Admin::factory()->create(['role' => 'admin', 'office_id' => $this->officeA->id])->user;
    $this->adminB = Admin::factory()->create(['role' => 'admin', 'office_id' => $this->officeB->id])->user;

    $this->job = Job::factory()->create(['office_id' => $this->officeA->id, 'category' => 'magang']);

    $this->administration = Stage::factory()->create(['name' => 'administration', 'type' => 'magang', 'step' => 1]);
    $this->psikotes = Stage::factory()->create(['name' => 'psikotes', 'type' => 'magang', 'step' => 2]);
    $this->interview = Stage::factory()->create(['name' => 'interview 1', 'type' => 'magang', 'step' => 3]);

    $this->applications = Application::factory()->count(3)->create([
        'job_id' => $this->job->id,
        'stages_id' => $this->administration->id,
        'status' => 'progress',
    ]);

    $this->invite = function (array $ids, array $extra = []) {
        return $this->actingAs($this->adminA)
            ->post(route('job.psikotesInvitations.store', $this->job), ['application_ids' => $ids, ...$extra]);
    };
});

it('assigns a unique link to each invited applicant and queues their email', function () {
    PsikotesLink::factory()->count(5)->create(['job_id' => $this->job->id]);

    ($this->invite)($this->applications->pluck('id')->all(), [
        'psikotes_date' => '2026-11-20',
        'psikotes_time' => '08:00 - 17:00 WIB',
    ])->assertSessionHas('info', '3 pelamar diundang psikotes. Email undangan sedang dikirim.');

    $links = [];
    foreach ($this->applications as $application) {
        $application->refresh()->load('psikotesLink');

        expect($application->stages_id)->toBe($this->psikotes->id)
            ->and($application->status)->toBe('progress')
            ->and($application->psikotesLink)->not->toBeNull()
            ->and($application->psikotesLink->assigned_at)->not->toBeNull();

        $links[$application->id] = $application->psikotesLink->link;
    }

    expect(array_unique($links))->toHaveCount(3)
        ->and($this->job->psikotesLinks()->available()->count())->toBe(2);

    Mail::assertQueued(psikotesMail::class, 3);

    foreach ($this->applications as $application) {
        Mail::assertQueued(psikotesMail::class, fn (psikotesMail $mail) => $mail->hasTo($application->applicant->user->email)
            && $mail->link === $links[$application->id]
            && $mail->date === '2026-11-20'
            && $mail->time === '08:00 - 17:00 WIB');
    }
});

it('changes nothing when there are not enough links', function () {
    PsikotesLink::factory()->count(2)->create(['job_id' => $this->job->id]);

    ($this->invite)($this->applications->pluck('id')->all())
        ->assertSessionHasErrorsIn('psikotesInvite', ['application_ids' => 'Stok link psikotes tidak cukup: butuh 3, tersedia 2.']);

    expect(Application::where('stages_id', $this->administration->id)->count())->toBe(3)
        ->and($this->job->psikotesLinks()->available()->count())->toBe(2);
    Mail::assertNothingQueued();
});

it('rejects applications from another job', function () {
    PsikotesLink::factory()->count(3)->create(['job_id' => $this->job->id]);
    $other = Application::factory()->create(['stages_id' => $this->administration->id, 'status' => 'progress']);

    ($this->invite)([$other->id])->assertSessionHasErrorsIn('psikotesInvite', 'application_ids.0');

    expect($other->refresh()->stages_id)->toBe($this->administration->id)
        ->and($this->job->psikotesLinks()->available()->count())->toBe(3);
});

it('rejects applications with a final status', function () {
    PsikotesLink::factory()->count(3)->create(['job_id' => $this->job->id]);
    $rejected = $this->applications->first();
    $rejected->update(['status' => 'rejected']);

    ($this->invite)([$rejected->id])->assertSessionHasErrorsIn('psikotesInvite', 'application_ids.0');

    expect($rejected->refresh()->stages_id)->toBe($this->administration->id)
        ->and($rejected->status)->toBe('rejected')
        ->and($this->job->psikotesLinks()->available()->count())->toBe(3);
    Mail::assertNothingQueued();
});

it('rejects duplicate application ids', function () {
    PsikotesLink::factory()->count(3)->create(['job_id' => $this->job->id]);
    $id = $this->applications->first()->id;

    ($this->invite)([$id, $id])->assertSessionHasErrorsIn('psikotesInvite');

    expect($this->job->psikotesLinks()->available()->count())->toBe(3);
});

it('rejects applications already in or past the psikotes stage', function (string $stageProperty) {
    PsikotesLink::factory()->count(3)->create(['job_id' => $this->job->id]);
    $this->applications->first()->update(['stages_id' => $this->{$stageProperty}->id]);

    ($this->invite)($this->applications->pluck('id')->all())
        ->assertSessionHasErrorsIn('psikotesInvite', ['application_ids' => 'Beberapa pelamar sudah diundang psikotes atau sudah melewati tahap tersebut.']);

    expect($this->job->psikotesLinks()->available()->count())->toBe(3);
    Mail::assertNothingQueued();
})->with(['already in psikotes' => ['psikotes'], 'past psikotes' => ['interview']]);

it('rejects jobs without a psikotes stage', function () {
    $job = Job::factory()->create(['office_id' => $this->officeA->id, 'category' => 'internship']);
    PsikotesLink::factory()->create(['job_id' => $job->id]);
    $application = Application::factory()->create(['job_id' => $job->id, 'stages_id' => null, 'status' => 'pending']);

    $this->actingAs($this->adminA)
        ->post(route('job.psikotesInvitations.store', $job), ['application_ids' => [$application->id]])
        ->assertSessionHasErrorsIn('psikotesInvite', ['application_ids' => 'Lowongan ini tidak memiliki tahap psikotes.']);
});

it('forbids admins from another office', function () {
    $this->actingAs($this->adminB)
        ->post(route('job.psikotesInvitations.store', $this->job), ['application_ids' => $this->applications->pluck('id')->all()])
        ->assertForbidden();
});
