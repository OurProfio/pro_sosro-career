<?php

use App\Models\Applicant;
use App\Models\ApplicantEducation;
use App\Models\ApplicantFamily;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create(['role' => 'user', 'email_verified_at' => now()]);
});

it('redirects to personal data create when applicant record does not exist', function () {
    $this->actingAs($this->user)
        ->get(route('biodata.index'))
        ->assertRedirect(route('biodata.create'));

    $this->actingAs($this->user)
        ->get(route('biodata.family.create'))
        ->assertRedirect(route('biodata.create'));

    $this->actingAs($this->user)
        ->get(route('biodata.education.create'))
        ->assertRedirect(route('biodata.create'));

    $this->actingAs($this->user)
        ->get(route('biodata.workExperience.create'))
        ->assertRedirect(route('biodata.create'));
});

it('redirects to family create when personal data is filled but family step is incomplete', function () {
    Applicant::factory()->incomplete()->create([
        'user_id' => $this->user->id,
    ]);

    $this->actingAs($this->user)
        ->get(route('biodata.index'))
        ->assertRedirect(route('biodata.family.create'));

    $this->actingAs($this->user)
        ->get(route('biodata.education.create'))
        ->assertRedirect(route('biodata.family.create'));

    $this->actingAs($this->user)
        ->get(route('biodata.workExperience.create'))
        ->assertRedirect(route('biodata.family.create'));
});

it('redirects to education create when personal data and family are filled but education step is incomplete', function () {
    $applicant = Applicant::factory()->incomplete()->create([
        'user_id' => $this->user->id,
    ]);

    ApplicantFamily::create([
        'applicant_id' => $applicant->id,
        'name' => 'Budi',
        'status' => 'alive',
        'place_of_birth' => 'Jakarta',
        'date_of_birth' => '1965-01-01',
        'education' => 'SMA',
        'relationship' => 'father',
        'family_type' => 'biological',
        'gender' => 'l',
    ]);

    $this->actingAs($this->user)
        ->get(route('biodata.index'))
        ->assertRedirect(route('biodata.education.create'));

    $this->actingAs($this->user)
        ->get(route('biodata.workExperience.create'))
        ->assertRedirect(route('biodata.education.create'));
});

it('redirects to work experience create when education is filled but step 4 is not completed', function () {
    $applicant = Applicant::factory()->incomplete()->create([
        'user_id' => $this->user->id,
    ]);

    ApplicantFamily::create([
        'applicant_id' => $applicant->id,
        'name' => 'Budi',
        'status' => 'alive',
        'place_of_birth' => 'Jakarta',
        'date_of_birth' => '1965-01-01',
        'education' => 'SMA',
        'relationship' => 'father',
        'family_type' => 'biological',
        'gender' => 'l',
    ]);

    ApplicantEducation::create([
        'applicant_id' => $applicant->id,
        'institution_name' => 'Universitas Indonesia',
        'city' => 'Depok',
        'degree_level' => 'S1',
        'major' => 'Teknik Informatika',
        'gpa' => 3.75,
        'entry_year' => 2018,
        'graduation_year' => 2022,
    ]);

    $this->actingAs($this->user)
        ->get(route('biodata.index'))
        ->assertRedirect(route('biodata.workExperience.create'));
});

it('allows access to biodata index when all steps are completed', function () {
    $applicant = Applicant::factory()->create([
        'user_id' => $this->user->id,
        'is_completed' => true,
    ]);

    ApplicantFamily::create([
        'applicant_id' => $applicant->id,
        'name' => 'Budi',
        'status' => 'alive',
        'place_of_birth' => 'Jakarta',
        'date_of_birth' => '1965-01-01',
        'education' => 'SMA',
        'relationship' => 'father',
        'family_type' => 'biological',
        'gender' => 'l',
    ]);

    ApplicantEducation::create([
        'applicant_id' => $applicant->id,
        'institution_name' => 'Universitas Indonesia',
        'city' => 'Depok',
        'degree_level' => 'S1',
        'major' => 'Teknik Informatika',
        'gpa' => 3.75,
        'entry_year' => 2018,
        'graduation_year' => 2022,
    ]);

    $this->actingAs($this->user)
        ->get(route('biodata.index'))
        ->assertOk();
});

