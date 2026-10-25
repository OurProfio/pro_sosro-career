<?php

use App\Models\Applicant;
use App\Models\Application;
use App\Models\Job;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->job = Job::factory()->create([
        'status' => 'aktif',
        'closing_date' => now()->addDays(14)->toDateString(),
        'title' => 'Software Engineer Backend',
    ]);
});

it('displays unauthenticated apply handler on vacancy when guest is not logged in', function () {
    $this->get(route('guest.index'))
        ->assertOk()
        ->assertSee('handleBelumLogin')
        ->assertSee('Software Engineer Backend');

    // Mengunjungi login dengan parameter required menampilkan notifikasi login
    $this->get(route('guest.login', ['required' => 1]))
        ->assertOk()
        ->assertSee('Silakan masuk (login) terlebih dahulu');
});

it('prompts user to complete biodata when logged in but biodata is not filled yet', function () {
    $userWithoutApplicant = User::factory()->create([
        'role' => 'user',
        'email_verified_at' => now(),
    ]);

    $this->actingAs($userWithoutApplicant)
        ->get(route('guest.index'))
        ->assertOk()
        ->assertSee('handleBelumBiodata')
        ->assertDontSee('konfirmasiLamar(this)');

    // Mengunjungi biodata.create dengan required menampilkan notifikasi lengkapi biodata
    $this->actingAs($userWithoutApplicant)
        ->get(route('biodata.create', ['required' => 1]))
        ->assertOk()
        ->assertSee('Silakan lengkapi formulir biodata Anda terlebih dahulu');

    // Jika mencoba submit form lamaran secara langsung, diarahkan ke biodata.create dengan notifikasi warning
    $this->actingAs($userWithoutApplicant)
        ->post(route('applications.store'), ['job_id' => $this->job->id])
        ->assertRedirect(route('biodata.create'))
        ->assertSessionHas('warning', 'Silakan lengkapi biodata Anda terlebih dahulu sebelum melamar pekerjaan.');
});

it('prompts confirmation modal and allows application when user is logged in with complete biodata', function () {
    $userWithApplicant = User::factory()->create([
        'role' => 'user',
        'email_verified_at' => now(),
    ]);

    $applicant = Applicant::factory()->create([
        'user_id' => $userWithApplicant->id,
    ]);

    $this->actingAs($userWithApplicant)
        ->get(route('guest.index'))
        ->assertOk()
        ->assertSee('konfirmasiLamar(this)')
        ->assertDontSee('onclick="handleBelumLogin')
        ->assertDontSee('onclick="handleBelumBiodata');

    $this->actingAs($userWithApplicant)
        ->post(route('applications.store'), ['job_id' => $this->job->id])
        ->assertRedirect(route('applications.index'))
        ->assertSessionHas('success', 'Berhasil melamar pekerjaan.');

    expect(Application::where('applicant_id', $applicant->id)->where('job_id', $this->job->id)->exists())->toBeTrue();
});
