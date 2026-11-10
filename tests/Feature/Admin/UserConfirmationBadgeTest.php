<?php

use App\Http\Controllers\Mail\MailController;
use App\Mail\UserConfirmationMail;
use App\Models\Application;
use App\Models\Stage;
use App\Models\User;
use App\Models\UserConfirmation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

uses(RefreshDatabase::class);

it('shows the user decision badge on the job page', function (array $state, string $label, ?string $extra) {
    $application = Application::factory()->create();
    UserConfirmation::factory()->for($application)->create(['email' => 'manager@sosro.test', ...$state]);

    $response = $this->actingAs(User::factory()->admin()->create())
        ->get(route('job.show', $application->job))
        ->assertOk()
        ->assertSee($label)
        ->assertSee('manager@sosro.test');

    if ($extra) {
        $response->assertSee($extra);
    }
})->with([
    'pending' => [['decision' => 'pending'], 'Menunggu user', null],
    'expired' => [['decision' => 'pending', 'expires_at' => now()->subDay()], 'Link kedaluwarsa', null],
    'approved' => [['decision' => 'approved', 'decided_at' => now()], 'Disetujui user', null],
    'rejected' => [['decision' => 'rejected', 'note' => 'Kurang pengalaman', 'decided_at' => now()], 'Ditolak user', 'Kurang pengalaman'],
]);

it('shows no badge when there is no confirmation', function () {
    $application = Application::factory()->create();

    $this->actingAs(User::factory()->admin()->create())
        ->get(route('job.show', $application->job))
        ->assertOk()
        ->assertDontSee('Menunggu user')
        ->assertDontSee('Disetujui user');
});

it('offers the user confirmation email as a test template', function () {
    Mail::fake();
    Application::factory()->create();
    Route::post('/_test/email', [MailController::class, 'sendEmail'])->middleware('web');

    $this->actingAs(User::factory()->admin()->create())
        ->post('/_test/email', ['email' => 'tester@example.com', 'templates' => ['user-confirmation']])
        ->assertSessionHasNoErrors();

    Mail::assertSent(UserConfirmationMail::class, fn ($mail) => $mail->hasTo('tester@example.com'));
    expect(UserConfirmation::count())->toBe(0);
});

it('shows the resend button only while at the user confirmation stage in progress', function (string $stageName, string $status, bool $visible) {
    $stage = Stage::factory()->create(['name' => $stageName, 'step' => 4]);
    $application = Application::factory()->create(['stages_id' => $stage->id, 'status' => $status]);
    UserConfirmation::factory()->for($application)->create();

    $response = $this->actingAs(User::factory()->admin()->create())
        ->get(route('job.show', $application->job))
        ->assertOk();

    $visible ? $response->assertSee('Kirim ulang') : $response->assertDontSee('Kirim ulang');
})->with([
    'at stage and progress' => ['konfirmasi user', 'progress', true],
    'other stage' => ['offering', 'progress', false],
    'accepted' => ['konfirmasi user', 'accepted', false],
    'rejected' => ['konfirmasi user', 'rejected', false],
]);
