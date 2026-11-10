<?php

use App\Models\Application;
use App\Models\Stage;
use App\Models\UserConfirmation;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->lockMessage = 'Proses seleksi kandidat ini sudah dilanjutkan oleh tim rekrutmen.';
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

it('links the confirmation page to the candidate detail page', function () {
    $this->get(route('user-confirmation.show', 'valid-token'))
        ->assertOk()
        ->assertSee('Lihat Detail Pelamar')
        ->assertSee(route('user-confirmation.detail', 'valid-token'));
});

it('shows the full candidate detail with the HR notes and the resume link', function () {
    $this->application->update(['notes' => 'Lulus interview, komunikasi baik']);

    $this->get(route('user-confirmation.detail', 'valid-token'))
        ->assertOk()
        ->assertSee($this->applicant->name)
        ->assertSee($this->applicant->nik)
        ->assertSee($this->application->job->office->name)
        ->assertSee('Lulus interview, komunikasi baik')
        ->assertSee(route('user-confirmation.print', 'valid-token'))
        ->assertSee(route('user-confirmation.show', 'valid-token'));
});

it('hides the admin-only links on the candidate detail page', function () {
    $this->get(route('user-confirmation.detail', 'valid-token'))
        ->assertOk()
        ->assertDontSee(route('job.show', $this->application->job))
        ->assertDontSee(route('applicant.index'))
        ->assertDontSee(route('applicant.print', $this->applicant));
});

it('shows the printable resume with the confirmed position', function () {
    $this->get(route('user-confirmation.print', 'valid-token'))
        ->assertOk()
        ->assertSee('FORMULIR BIODATA CALON KARYAWAN')
        ->assertSee('Jabatan yang dilamar')
        ->assertSee(mb_strtoupper($this->application->job->title));
});

it('returns 404 for the detail and resume of an unknown or expired token', function () {
    $this->get(route('user-confirmation.detail', 'nope'))->assertNotFound();
    $this->get(route('user-confirmation.print', 'nope'))->assertNotFound();

    $this->confirmation->update(['expires_at' => now()->subMinute()]);

    $this->get(route('user-confirmation.detail', 'valid-token'))->assertNotFound();
    $this->get(route('user-confirmation.print', 'valid-token'))->assertNotFound();
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
        ->assertSessionHas('error', $this->lockMessage);

    expect($this->confirmation->fresh()->decision)->toBe('pending');

    $this->get(route('user-confirmation.show', 'valid-token'))
        ->assertOk()
        ->assertSee($this->lockMessage)
        ->assertDontSee('name="decision"', false);
})->with(['stage' => 'stage', 'accepted' => 'accepted', 'rejected' => 'rejected']);
