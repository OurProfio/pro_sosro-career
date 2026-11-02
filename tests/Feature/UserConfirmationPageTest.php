<?php

use App\Models\Application;
use App\Models\Stage;
use App\Models\UserConfirmation;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

const LOCK_MESSAGE = 'Proses seleksi kandidat ini sudah dilanjutkan oleh tim rekrutmen.';

beforeEach(function () {
    $this->stage = Stage::factory()->create(['name' => 'konfirmasi user', 'step' => 4]);
    $this->application = Application::factory()->create([
        'stages_id' => $this->stage->id,
        'status' => 'progress',
    ]);
    $this->applicant = $this->application->applicant;
    $this->confirmation = UserConfirmation::factory()->for($this->application)->create([
        'token' => hash('sha256', 'valid-token'),
    ]);
});

it('shows the candidate summary without sensitive data', function () {
    $this->get(route('user-confirmation.show', 'valid-token'))
        ->assertOk()
        ->assertSee($this->applicant->name)
        ->assertSee($this->application->job->title)
        ->assertDontSee($this->applicant->nik)
        ->assertDontSee($this->applicant->phone_number);
});

it('returns 404 for an unknown token', function () {
    $this->get(route('user-confirmation.show', 'nope'))->assertNotFound();
});

it('returns 404 for an expired link even after a decision', function () {
    $this->confirmation->update([
        'expires_at' => now()->subMinute(),
        'decision' => 'approved',
        'decided_at' => now()->subDay(),
    ]);

    $this->get(route('user-confirmation.show', 'valid-token'))->assertNotFound();
    $this->put(route('user-confirmation.update', 'valid-token'), ['decision' => 'rejected'])->assertNotFound();
});

it('renders when the applicant has no education or work experience', function () {
    expect($this->applicant->educations)->toBeEmpty()
        ->and($this->applicant->workExperiences)->toBeEmpty();

    $this->get(route('user-confirmation.show', 'valid-token'))->assertOk();
});

it('stores the decision and lets the user change it', function () {
    $this->put(route('user-confirmation.update', 'valid-token'), ['decision' => 'rejected', 'note' => 'Kurang pengalaman'])
        ->assertRedirect(route('user-confirmation.show', 'valid-token'))
        ->assertSessionHas('success', 'Keputusan Anda telah disimpan.');

    expect($this->confirmation->fresh())
        ->decision->toBe('rejected')
        ->note->toBe('Kurang pengalaman')
        ->decided_at->not->toBeNull();

    $this->put(route('user-confirmation.update', 'valid-token'), ['decision' => 'approved']);

    expect($this->confirmation->fresh())->decision->toBe('approved')->note->toBeNull();

    $this->get(route('user-confirmation.show', 'valid-token'))
        ->assertOk()
        ->assertSee('Keputusan Anda saat ini');
});

it('validates the decision and note', function () {
    $this->put(route('user-confirmation.update', 'valid-token'), ['decision' => 'maybe'])
        ->assertSessionHasErrors('decision');

    $this->put(route('user-confirmation.update', 'valid-token'), ['decision' => 'approved', 'note' => str_repeat('a', 1001)])
        ->assertSessionHasErrors('note');

    expect($this->confirmation->fresh()->decision)->toBe('pending');
});

it('locks the form once the application moved on', function (string $change) {
    match ($change) {
        'stage' => $this->application->update([
            'stages_id' => Stage::factory()->create(['name' => 'offering', 'step' => 5])->id,
        ]),
        default => $this->application->update(['status' => $change]),
    };

    $this->put(route('user-confirmation.update', 'valid-token'), ['decision' => 'approved'])
        ->assertSessionHas('error', LOCK_MESSAGE);

    expect($this->confirmation->fresh()->decision)->toBe('pending');

    $this->get(route('user-confirmation.show', 'valid-token'))
        ->assertOk()
        ->assertSee(LOCK_MESSAGE)
        ->assertDontSee('name="decision"', false);
})->with(['stage' => 'stage', 'accepted' => 'accepted', 'rejected' => 'rejected']);
