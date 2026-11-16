<?php

use App\Models\Admin;
use App\Models\Application;
use App\Models\Job;
use App\Models\PsikotesLink;
use App\Models\Stage;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->superAdmin = Admin::factory()->create(['role' => 'superadmin'])->user;

    $this->job = Job::factory()->create(['category' => 'magang', 'status' => 'aktif']);

    $this->administration = Stage::factory()->create(['name' => 'administration', 'type' => 'magang', 'step' => 1]);
    $this->psikotes = Stage::factory()->create(['name' => 'psikotes', 'type' => 'magang', 'step' => 2]);

    $this->eligible = Application::factory()->create([
        'job_id' => $this->job->id,
        'stages_id' => $this->administration->id,
        'status' => 'pending',
    ]);
    $this->rejected = Application::factory()->create([
        'job_id' => $this->job->id,
        'stages_id' => $this->administration->id,
        'status' => 'rejected',
    ]);
    $this->invited = Application::factory()->create([
        'job_id' => $this->job->id,
        'stages_id' => $this->psikotes->id,
        'status' => 'progress',
    ]);

    PsikotesLink::factory()->count(2)->create(['job_id' => $this->job->id]);
    PsikotesLink::factory()->assigned($this->invited)->create(['job_id' => $this->job->id]);
});

it('shows the psikotes link stock and upload button', function () {
    $this->actingAs($this->superAdmin)
        ->get(route('job.show', $this->job))
        ->assertOk()
        ->assertSee('Upload Link Psikotes')
        ->assertSeeInOrder(['Link psikotes:', '2', 'tersedia', '1', 'terpakai']);
});

it('renders a bulk checkbox only for invitable applications', function () {
    $this->actingAs($this->superAdmin)
        ->get(route('job.show', $this->job))
        ->assertOk()
        ->assertSee('class="psikotes-checkbox" value="'.$this->eligible->id.'"', false)
        ->assertDontSee('class="psikotes-checkbox" value="'.$this->rejected->id.'"', false)
        ->assertDontSee('class="psikotes-checkbox" value="'.$this->invited->id.'"', false);
});

it('hides the psikotes bulk tools for jobs without a psikotes stage', function () {
    $internship = Job::factory()->create(['category' => 'internship', 'status' => 'aktif']);
    Application::factory()->create(['job_id' => $internship->id, 'status' => 'pending']);

    $this->actingAs($this->superAdmin)
        ->get(route('job.show', $internship))
        ->assertOk()
        ->assertDontSee('Upload Link Psikotes')
        ->assertDontSee('class="psikotes-checkbox"', false);
});

it('keeps the previously selected applicants after an invite error', function () {
    $this->actingAs($this->superAdmin)
        ->withSession(['_old_input' => ['application_ids' => [$this->eligible->id]]])
        ->get(route('job.show', $this->job))
        ->assertOk()
        ->assertSee("selectedApplicationIds: JSON.parse('[{$this->eligible->id}]')", false);
});
