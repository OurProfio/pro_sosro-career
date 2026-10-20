<?php

use App\Mail\DocumentCollectionMail;
use App\Mail\InterviewOnlineMail;
use App\Mail\PanelBodMail;
use App\Mail\psikotesMail;
use App\Mail\RejectedMail;
use App\Mail\StudyCaseMail;
use App\Mail\tesKepribadianMail;
use App\Mail\VerifyEmailMail;
use App\Models\Application;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

uses(RefreshDatabase::class);

beforeEach(function () {
    Mail::fake();
});

it('sends only the selected templates to the given test address', function () {
    Application::factory()->create();

    $this->actingAs(User::factory()->admin()->create())
        ->post(route('email.send'), [
            'email' => 'tester@example.com',
            'templates' => ['interview-online', 'tes-kepribadian'],
        ])
        ->assertRedirect()
        ->assertSessionHas('success');

    Mail::assertSent(InterviewOnlineMail::class, fn ($mail) => $mail->hasTo('tester@example.com'));
    Mail::assertSent(tesKepribadianMail::class, fn ($mail) => $mail->hasTo('tester@example.com'));
    Mail::assertNotSent(RejectedMail::class);
});

it('uses the manually entered data and falls back to defaults when blank', function () {
    Application::factory()->create();

    $this->actingAs(User::factory()->admin()->create())
        ->post(route('email.send'), [
            'email' => 'tester@example.com',
            'templates' => ['interview-online', 'psikotes'],
            'interview_link' => 'https://zoom.us/j/123',
            'interview_date' => '2027-01-15',
            'psikotes_code' => '',
        ])
        ->assertSessionHasNoErrors();

    Mail::assertSent(InterviewOnlineMail::class, fn ($mail) => $mail->link === 'https://zoom.us/j/123'
        && $mail->date === '2027-01-15'
        && $mail->time === '09:00');
    Mail::assertSent(psikotesMail::class, fn ($mail) => $mail->code === 'ABC123');
});

it('requires at least one valid template', function () {
    $this->actingAs(User::factory()->admin()->create())
        ->post(route('email.send'), ['email' => 'tester@example.com', 'templates' => ['bukan-template']])
        ->assertSessionHasErrors('templates.0');

    $this->actingAs(User::factory()->admin()->create())
        ->post(route('email.send'), ['email' => 'tester@example.com'])
        ->assertSessionHasErrors('templates');

    Mail::assertNothingSent();
});

it('rejects an invalid address', function () {
    $this->actingAs(User::factory()->admin()->create())
        ->post(route('email.send'), ['email' => 'bukan-email', 'templates' => ['rejected']])
        ->assertSessionHasErrors('email');

    Mail::assertNothingSent();
});

it('does not allow guests to send test emails', function () {
    $this->post(route('email.send'), ['email' => 'tester@example.com', 'templates' => ['rejected']])
        ->assertRedirect();

    Mail::assertNothingSent();
});

it('sends the study case, panel BOD and document collection templates', function () {
    Application::factory()->create();

    $this->actingAs(User::factory()->admin()->create())
        ->post(route('email.send'), [
            'email' => 'tester@example.com',
            'templates' => ['study-case', 'panel-bod', 'document-collection'],
            'study_case_topic' => 'Topik uji',
        ])
        ->assertSessionHasNoErrors();

    Mail::assertSent(StudyCaseMail::class, fn ($mail) => $mail->hasTo('tester@example.com') && $mail->topic === 'Topik uji');
    Mail::assertSent(PanelBodMail::class, fn ($mail) => $mail->time === '10:00');
    Mail::assertSent(DocumentCollectionMail::class);
});

it('sends the email verification template', function () {
    Application::factory()->create();

    $this->actingAs(User::factory()->admin()->create())
        ->post(route('email.send'), ['email' => 'tester@example.com', 'templates' => ['verify-email']])
        ->assertSessionHasNoErrors();

    Mail::assertSent(VerifyEmailMail::class, fn ($mail) => $mail->hasTo('tester@example.com')
        && str_contains($mail->url, 'email/verify/'));
});
