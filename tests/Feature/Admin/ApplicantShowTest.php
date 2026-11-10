<?php

use App\Models\Application;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows the office name and HR notes of the latest application', function () {
    $application = Application::factory()->create(['notes' => 'Lulus interview, komunikasi baik']);

    $this->actingAs(User::factory()->admin()->create())
        ->get(route('applicant.show', $application->applicant))
        ->assertOk()
        ->assertSee($application->job->office->name)
        ->assertDontSee('"created_at":')
        ->assertSee('Lulus interview, komunikasi baik')
        ->assertSee(route('applicant.print', $application->applicant));
});
