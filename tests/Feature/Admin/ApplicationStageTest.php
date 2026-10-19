<?php

use App\Mail\AcceptedHOMail;
use App\Mail\AcceptedKpwMail;
use App\Mail\InterviewOfflineMail;
use App\Mail\InterviewOnlineMail;
use App\Mail\RejectedMail;
use App\Models\Applicant;
use App\Models\Application;
use App\Models\Job;
use App\Models\Office;
use App\Models\Stage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

uses(RefreshDatabase::class);

beforeEach(function () {
    Mail::fake();

    $this->admin = User::factory()->admin()->create();
    $this->application = Application::factory()->create();
    $this->administrationStage = Stage::factory()->create(['name' => 'administration', 'step' => 1]);
    $this->interviewStage = Stage::factory()->create(['name' => 'interview 1', 'step' => 2]);
});

it('moves the application to a stage without email', function () {
    $this->actingAs($this->admin)
        ->patch(route('application.updateStage', $this->application), [
            'stages_id' => $this->administrationStage->id,
        ])
        ->assertRedirect()
        ->assertSessionHasNoErrors();

    expect($this->application->fresh())
        ->stages_id->toBe($this->administrationStage->id)
        ->status->toBe('progress');

    Mail::assertNothingSent();
});

it('sends the online interview email', function () {
    $this->actingAs($this->admin)
        ->patch(route('application.updateStage', $this->application), [
            'stages_id' => $this->interviewStage->id,
            'interview_type' => 'virtual',
            'interview_date' => now()->addDay()->toDateString(),
            'interview_time' => '09:00',
            'interview_link' => 'https://meet.google.com/abc-defg-hij',
        ])
        ->assertSessionHasNoErrors();

    expect($this->application->fresh()->stages_id)->toBe($this->interviewStage->id);

    Mail::assertSent(InterviewOnlineMail::class, fn (InterviewOnlineMail $mail) => $mail->hasTo($this->application->applicant->email)
        && $mail->link === 'https://meet.google.com/abc-defg-hij');
});

it('sends the interview email for the second interview stage', function () {
    $secondInterviewStage = Stage::factory()->create(['name' => 'interview 2', 'step' => 3]);

    $this->actingAs($this->admin)
        ->patch(route('application.updateStage', $this->application), [
            'stages_id' => $secondInterviewStage->id,
            'interview_type' => 'virtual',
            'interview_date' => now()->addDay()->toDateString(),
            'interview_time' => '10:00',
            'interview_link' => 'https://meet.google.com/xyz',
        ])
        ->assertSessionHasNoErrors();

    expect($this->application->fresh()->stages_id)->toBe($secondInterviewStage->id);

    Mail::assertSent(InterviewOnlineMail::class, fn (InterviewOnlineMail $mail) => $mail->hasSubject('Undangan Interview 2 PT Sinar Sosro Gunung Slamat'));
});

it('sends the offline interview email', function () {
    $this->actingAs($this->admin)
        ->patch(route('application.updateStage', $this->application), [
            'stages_id' => $this->interviewStage->id,
            'interview_type' => 'offline',
            'interview_date' => now()->addDay()->toDateString(),
            'interview_time' => '13:30',
            'interview_address' => 'Graha Rekso Lt.8',
        ])
        ->assertSessionHasNoErrors();

    Mail::assertSent(InterviewOfflineMail::class, fn (InterviewOfflineMail $mail) => $mail->address === 'Graha Rekso Lt.8');
});

it('renders the interview email with the applicant data', function () {
    $mail = new InterviewOnlineMail($this->application, '2026-10-20', '09:00', 'https://meet.google.com/abc');

    $mail->assertSeeInHtml($this->application->applicant->name)
        ->assertSeeInHtml('09:00 WIB')
        ->assertSeeInHtml('https://meet.google.com/abc')
        ->assertDontSeeInHtml('[Nama Kandidat]');
});

it('requires schedule details for the interview stage', function () {
    $this->actingAs($this->admin)
        ->patch(route('application.updateStage', $this->application), [
            'stages_id' => $this->interviewStage->id,
            'interview_type' => 'virtual',
        ])
        ->assertSessionHasErrors(['interview_date', 'interview_time', 'interview_link']);

    expect($this->application->fresh()->stages_id)->toBeNull();
    Mail::assertNothingSent();
});

it('rejects a stage from another job category', function () {
    $otherStage = Stage::factory()->create(['name' => 'psikotes', 'type' => 'profesional', 'step' => 2]);

    $this->actingAs($this->admin)
        ->patch(route('application.updateStage', $this->application), [
            'stages_id' => $otherStage->id,
        ])
        ->assertSessionHasErrors('stages_id');
});

it('rejects the application and sends the rejection email', function () {
    $this->actingAs($this->admin)
        ->patch(route('application.updateStatus', $this->application), [
            'status' => 'rejected',
        ])
        ->assertSessionHasNoErrors();

    expect($this->application->fresh()->status)->toBe('rejected');
    Mail::assertSent(RejectedMail::class);
});

it('sends the head office acceptance email for HO jobs', function () {
    $job = Job::factory()->for(Office::factory()->headOffice())->create();
    $application = Application::factory()->for($job)->create();

    $this->actingAs($this->admin)
        ->patch(route('application.updateStatus', $application), [
            'status' => 'accepted',
            'start_date' => now()->addWeek()->toDateString(),
            'work_address' => 'Graha Rekso Lt.8',
        ])
        ->assertSessionHasNoErrors();

    expect($application->fresh()->status)->toBe('accepted');
    $this->assertDatabaseHas('thrm_app_personal_data', [
        'EMAIL' => $application->applicant->email,
        'STATUSAPP' => 'ACCEPTED',
    ]);
    $this->assertDatabaseHas('thrm_app_history', [
        'REQUEST_CODE' => (string) $job->id,
        'APPSTS' => 1,
    ]);
    Mail::assertSent(AcceptedHOMail::class);
    Mail::assertNotSent(AcceptedKpwMail::class);
});

it('sends the KPW acceptance email for KPW jobs', function () {
    $this->actingAs($this->admin)
        ->patch(route('application.updateStatus', $this->application), [
            'status' => 'accepted',
            'start_date' => now()->addWeek()->toDateString(),
            'work_address' => 'KPW Jawa Barat',
        ])
        ->assertSessionHasNoErrors();

    Mail::assertSent(AcceptedKpwMail::class);
    Mail::assertNotSent(AcceptedHOMail::class);
});

it('requires a start date and address when accepting', function () {
    $this->actingAs($this->admin)
        ->patch(route('application.updateStatus', $this->application), [
            'status' => 'accepted',
        ])
        ->assertSessionHasErrors(['start_date', 'work_address']);

    Mail::assertNothingSent();
});

it('redirects applicants to applicant dashboard when attempting to update applications', function () {
    $this->actingAs(User::factory()->create())
        ->patch(route('application.updateStatus', $this->application), [
            'status' => 'rejected',
        ])
        ->assertRedirect(route('applicant.dashboard'));

    expect($this->application->fresh()->status)->toBe('pending');
});

it('releases quota when an application is rejected so applicant can apply to another job', function () {
    $applicantUser = User::factory()->create();
    $applicant = Applicant::factory()->create(['user_id' => $applicantUser->id]);

    $jobs = Job::factory()->count(4)->create([
        'status' => 'aktif',
        'opening_date' => now()->subDay()->toDateString(),
        'closing_date' => now()->addMonth()->toDateString(),
    ]);

    // Create 3 active applications
    $app1 = Application::create(['applicant_id' => $applicant->id, 'job_id' => $jobs[0]->id, 'status' => 'pending']);
    $app2 = Application::create(['applicant_id' => $applicant->id, 'job_id' => $jobs[1]->id, 'status' => 'pending']);
    $app3 = Application::create(['applicant_id' => $applicant->id, 'job_id' => $jobs[2]->id, 'status' => 'pending']);

    // Attempting to apply to 4th job should fail due to quota
    $this->actingAs($applicantUser)
        ->post(route('applications.store'), ['job_id' => $jobs[3]->id])
        ->assertSessionHas('error', 'Anda sudah mencapai batas maksimal 3 lamaran aktif yang sedang berjalan.');

    // Admin rejects application 1
    $this->actingAs($this->admin)
        ->patch(route('application.updateStatus', $app1), [
            'status' => 'rejected',
        ])
        ->assertSessionHasNoErrors();

    expect($app1->fresh()->status)->toBe('rejected');
    expect(Application::where('applicant_id', $applicant->id)->count())->toBe(3); // Tetap tersimpan sebagai history

    // Applicant should now be able to apply to the 4th job
    $this->actingAs($applicantUser)
        ->post(route('applications.store'), ['job_id' => $jobs[3]->id])
        ->assertRedirect(route('applications.index'))
        ->assertSessionHas('success', 'Berhasil melamar pekerjaan.');

    // Total history is now 4, but only 3 are active
    expect(Application::where('applicant_id', $applicant->id)->count())->toBe(4);
    expect(Application::where('applicant_id', $applicant->id)->where('status', '!=', 'rejected')->count())->toBe(3);
});
