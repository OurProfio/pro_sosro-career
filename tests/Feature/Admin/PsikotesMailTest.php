<?php

use App\Mail\psikotesMail;
use App\Models\Application;
use App\Models\Stage;
use App\Services\ApplicationNotificationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

uses(RefreshDatabase::class);

beforeEach(function () {
    Mail::fake();

    $stage = Stage::factory()->create(['name' => 'psikotes', 'type' => 'magang', 'step' => 2]);
    $this->application = Application::factory()->create(['stages_id' => $stage->id])
        ->load('stage', 'applicant.user', 'job.office');
});

it('queues the psikotes email when queue is requested', function () {
    app(ApplicationNotificationService::class)->sendStageNotification(
        $this->application,
        ['psikotes_link' => 'https://careeratsosro.com/?kode=118067XQF0'],
        queue: true,
    );

    Mail::assertQueued(psikotesMail::class, fn ($mail) => $mail->hasTo($this->application->applicant->user->email)
        && $mail->link === 'https://careeratsosro.com/?kode=118067XQF0');
    Mail::assertNotSent(psikotesMail::class);
});

it('sends the psikotes email immediately by default', function () {
    app(ApplicationNotificationService::class)->sendStageNotification(
        $this->application,
        ['psikotes_link' => 'https://careeratsosro.com/?kode=118067XQF0'],
    );

    Mail::assertSent(psikotesMail::class, fn ($mail) => $mail->hasTo($this->application->applicant->user->email));
    Mail::assertNotQueued(psikotesMail::class);
});

it('hides the code line when no code is given', function () {
    $mail = new psikotesMail($this->application, link: 'https://careeratsosro.com/?kode=X');

    $mail->assertDontSeeInHtml('Kode Tes');
    $mail->assertSeeInHtml('https://careeratsosro.com/?kode=X');
});

it('shows the code line when a code is given', function () {
    (new psikotesMail($this->application, code: 'ABC123'))->assertSeeInHtml('<strong>Kode Tes:</strong> ABC123', false);
});
