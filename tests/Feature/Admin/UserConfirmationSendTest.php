<?php

use App\Mail\UserConfirmationMail;
use App\Models\Application;
use App\Models\Stage;
use App\Models\User;
use App\Models\UserConfirmation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

uses(RefreshDatabase::class);

beforeEach(function () {
    Mail::fake();

    $this->admin = User::factory()->admin()->create();
    $this->application = Application::factory()->create();
    $this->confirmationStage = Stage::factory()->create(['name' => 'konfirmasi user', 'step' => 4]);
});

it('requires the user email for the konfirmasi user stage', function () {
    $this->actingAs($this->admin)
        ->patch(route('application.updateStage', $this->application), ['stages_id' => $this->confirmationStage->id])
        ->assertSessionHasErrors('user_email');

    expect($this->application->fresh()->stages_id)->toBeNull();
    Mail::assertNothingSent();
});

it('creates a hashed-token confirmation and mails the user, not the applicant', function () {
    $this->actingAs($this->admin)
        ->patch(route('application.updateStage', $this->application), [
            'stages_id' => $this->confirmationStage->id,
            'user_email' => 'manager@sosro.test',
        ])
        ->assertSessionHasNoErrors()
        ->assertSessionHas('info', fn ($m) => str_contains($m, 'Email konfirmasi telah dikirim ke user.'));

    $confirmation = $this->application->fresh()->userConfirmation;
    expect($confirmation)->email->toBe('manager@sosro.test')->decision->toBe('pending')
        ->and($confirmation->expires_at->isSameDay(now()->addDays(7)))->toBeTrue();

    Mail::assertSent(UserConfirmationMail::class, function (UserConfirmationMail $mail) use ($confirmation) {
        $plainToken = Str::afterLast($mail->url, '/');

        return $mail->hasTo('manager@sosro.test')
            && ! $mail->hasTo($this->application->applicant->email)
            && $confirmation->token === hash('sha256', $plainToken)
            && $plainToken !== $confirmation->token;
    });
});

it('resets the decision and replaces the token when sent again', function () {
    UserConfirmation::factory()->for($this->application)->create([
        'email' => 'lama@sosro.test',
        'token' => hash('sha256', 'old-token'),
        'decision' => 'approved',
        'note' => 'ok',
        'decided_at' => now(),
    ]);

    $this->actingAs($this->admin)
        ->patch(route('application.updateStage', $this->application), [
            'stages_id' => $this->confirmationStage->id,
            'user_email' => 'baru@sosro.test',
        ])
        ->assertSessionHasNoErrors();

    expect(UserConfirmation::count())->toBe(1)
        ->and($this->application->fresh()->userConfirmation)
        ->email->toBe('baru@sosro.test')
        ->decision->toBe('pending')
        ->note->toBeNull()
        ->decided_at->toBeNull()
        ->and(UserConfirmation::findActiveByToken('old-token'))->toBeNull();
});

it('recognises the stage regardless of casing and spacing', function () {
    $stage = Stage::factory()->create(['name' => 'Konfirmasi User ', 'step' => 5]);

    $this->actingAs($this->admin)
        ->patch(route('application.updateStage', $this->application), ['stages_id' => $stage->id])
        ->assertSessionHasErrors('user_email');
});

it('ignores an empty user email field on other stages', function () {
    $stage = Stage::factory()->create(['name' => 'administration', 'step' => 1]);

    $this->actingAs($this->admin)
        ->patch(route('application.updateStage', $this->application), [
            'stages_id' => $stage->id,
            'user_email' => '',
        ])
        ->assertSessionHasNoErrors();

    Mail::assertNothingSent();
});

it('keeps the stage change when the user email fails to send', function () {
    Mail::shouldReceive('to')->andThrow(new Exception('smtp down'));

    $this->actingAs($this->admin)
        ->patch(route('application.updateStage', $this->application), [
            'stages_id' => $this->confirmationStage->id,
            'user_email' => 'manager@sosro.test',
        ])
        ->assertRedirect();

    expect($this->application->fresh())
        ->stages_id->toBe($this->confirmationStage->id)
        ->userConfirmation->not->toBeNull();
});

it('renders the user email with the candidate and the link', function () {
    $confirmation = UserConfirmation::factory()->create();
    $mail = new UserConfirmationMail($confirmation, 'https://karir.test/konfirmasi-user/abc');

    $mail->assertSeeInHtml($confirmation->application->applicant->name)
        ->assertSeeInHtml($confirmation->application->job->title)
        ->assertSeeInHtml('https://karir.test/konfirmasi-user/abc')
        ->assertSeeInHtml('7 hari');
});

it('still lets the admin accept an application the user rejected', function () {
    $this->application->update(['stages_id' => $this->confirmationStage->id, 'status' => 'progress']);
    UserConfirmation::factory()->for($this->application)->create(['decision' => 'rejected']);

    $this->actingAs($this->admin)
        ->patch(route('application.updateStatus', $this->application), [
            'status' => 'accepted',
            'start_date' => now()->addWeek()->toDateString(),
            'work_address' => 'KPW Jawa Barat',
        ])
        ->assertSessionHasNoErrors();

    expect($this->application->fresh()->status)->toBe('accepted');
});
