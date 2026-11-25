<?php

use App\Models\Applicant;
use App\Models\ApplicantEducation;
use App\Models\ApplicantEducationOther;
use App\Models\ApplicantFamily;
use App\Models\Application;
use App\Models\Hris\ThrmAppEducation;
use App\Models\Job;
use App\Models\User;
use App\Services\HrisTransferService;
use Database\Seeders\HrisMasterSeeder;
use Database\Seeders\ThrmListFacultySeeder;
use Database\Seeders\ThrmListMajorSeeder;
use Database\Seeders\ThrmListSchoolSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('renders faculty select options from thrm_list_faculty on the education form', function () {
    $this->seed(ThrmListFacultySeeder::class);

    $user = User::factory()->create();
    $applicant = Applicant::factory()->create(['user_id' => $user->id]);
    ApplicantFamily::factory()->create(['applicant_id' => $applicant->id]);

    $this->actingAs($user)
        ->get(route('biodata.education.create'))
        ->assertOk()
        ->assertSee('name="educations[0][faculty]"', false)
        ->assertSee('Adab dan Humaniora')
        ->assertSee('Teknik');
});

it('saves faculty and pre-selects it when reopening the education form for editing', function () {
    $this->seed(ThrmListFacultySeeder::class);

    $user = User::factory()->create();
    $applicant = Applicant::factory()->create(['user_id' => $user->id]);
    ApplicantFamily::factory()->create(['applicant_id' => $applicant->id]);

    $this->actingAs($user)
        ->post(route('biodata.education.store'), [
            'educations' => [
                [
                    'degree_level' => 'Sarjana',
                    'institution_name' => 'Universitas Indonesia',
                    'faculty' => 'Teknik',
                    'state' => 'Depok',
                    'major' => 'Teknik Informatika',
                    'gpa' => '3.75',
                    'entry_year' => '2019',
                    'graduation_year' => '2023',
                ],
                [
                    'degree_level' => 'SMA',
                    'institution_name' => 'SMA Negeri 1 Jakarta',
                    'faculty' => '',
                    'state' => 'Jakarta',
                    'major' => 'IPA',
                    'gpa' => '90.00',
                    'entry_year' => '2016',
                    'graduation_year' => '2019',
                ],
            ],
        ])
        ->assertRedirect(route('biodata.workExperience.create'))
        ->assertSessionHasNoErrors();

    $educations = ApplicantEducation::where('applicant_id', $applicant->id)->get();

    expect($educations)->toHaveCount(2)
        ->and($educations[0]->faculty)->toBe('TEKNIK')
        ->and($educations[1]->faculty)->toBeNull();

    $this->actingAs($user)
        ->get(route('biodata.education.create'))
        ->assertOk()
        ->assertSee('value="TEKNIK"', false);
});

it('clears faculty and hides faculty field for SMA, SMK, and STM degree levels', function () {
    $this->seed(ThrmListFacultySeeder::class);

    $user = User::factory()->create();
    $applicant = Applicant::factory()->create(['user_id' => $user->id]);
    ApplicantFamily::factory()->create(['applicant_id' => $applicant->id]);

    $this->actingAs($user)
        ->post(route('biodata.education.store'), [
            'educations' => [
                [
                    'degree_level' => 'SMA',
                    'institution_name' => 'SMA Negeri 1 Jakarta',
                    'faculty' => 'Teknik',
                    'state' => 'Jakarta',
                    'major' => 'IPA',
                    'gpa' => '90.00',
                    'entry_year' => '2016',
                    'graduation_year' => '2019',
                ],
                [
                    'degree_level' => 'SMK',
                    'institution_name' => 'SMK Negeri 2 Jakarta',
                    'faculty' => 'Ekonomi',
                    'state' => 'Jakarta',
                    'major' => 'Akuntansi',
                    'gpa' => '88.00',
                    'entry_year' => '2016',
                    'graduation_year' => '2019',
                ],
            ],
        ])
        ->assertRedirect(route('biodata.workExperience.create'))
        ->assertSessionHasNoErrors();

    $educations = ApplicantEducation::where('applicant_id', $applicant->id)->get();

    expect($educations)->toHaveCount(2)
        ->and($educations[0]->faculty)->toBeNull()
        ->and($educations[1]->faculty)->toBeNull();

    $this->actingAs($user)
        ->get(route('biodata.education.create'))
        ->assertOk()
        ->assertSee('faculty-field-wrapper faculty-combobox-wrapper hidden', false);
});

it('requires faculty for non-high-school degree levels', function () {
    $user = User::factory()->create();
    $applicant = Applicant::factory()->create(['user_id' => $user->id]);
    ApplicantFamily::factory()->create(['applicant_id' => $applicant->id]);

    $this->actingAs($user)
        ->post(route('biodata.education.store'), [
            'educations' => [
                [
                    'degree_level' => 'Sarjana',
                    'institution_name' => 'Universitas Indonesia',
                    'faculty' => '',
                    'state' => 'Depok',
                    'major' => 'Teknik Informatika',
                    'gpa' => '3.75',
                    'entry_year' => '2019',
                    'graduation_year' => '2023',
                ],
            ],
        ])
        ->assertSessionHasErrors('educations.0.faculty');
});

it('saves THRM master IDs, logs manual Other entries into applicant_education_others, and transfers Other to HRIS', function () {
    $this->seed(HrisMasterSeeder::class);

    $user = User::factory()->create();
    $applicant = Applicant::factory()->create(['user_id' => $user->id]);
    ApplicantFamily::factory()->create(['applicant_id' => $applicant->id]);

    $this->actingAs($user)
        ->post(route('biodata.education.store'), [
            'educations' => [
                [
                    'degree_level' => 'Sarjana',
                    'institution_name' => 'Universitas Contoh Baru Tidak Terdaftar',
                    'faculty' => 'Fakultas Contoh Baru',
                    'state' => 'Bekasi',
                    'major' => 'Jurusan Contoh Baru',
                    'gpa' => '3.80',
                    'entry_year' => '2019',
                    'graduation_year' => '2023',
                ],
                [
                    'degree_level' => 'SMA',
                    'institution_name' => 'SMA Negeri 1 Contoh Baru',
                    'faculty' => 'Teknik',
                    'state' => 'Jakarta',
                    'major' => 'IPA',
                    'gpa' => '90.00',
                    'entry_year' => '2016',
                    'graduation_year' => '2019',
                ],
            ],
        ])
        ->assertRedirect(route('biodata.workExperience.create'))
        ->assertSessionHasNoErrors();

    $educations = ApplicantEducation::with(['educationType', 'school', 'facultyMaster', 'majorMaster', 'otherEntries'])
        ->where('applicant_id', $applicant->id)
        ->orderBy('id')
        ->get();

    expect($educations)->toHaveCount(2)
        ->and($educations[0]->edutype_id)->toBe(7)
        ->and($educations[0]->school_id)->toBe(ThrmListSchoolSeeder::OTHER_EDU_ID)
        ->and($educations[0]->faculty_id)->toBe(ThrmListFacultySeeder::OTHER_FACULTY_ID)
        ->and($educations[0]->major_id)->toBe(ThrmListMajorSeeder::OTHER_MAJOR_ID)
        ->and($educations[0]->educationType?->EDUTYPE_NAME_ID)->toBe('Sarjana')
        ->and($educations[0]->school?->EDU_NAME)->toBe('Other')
        ->and($educations[0]->facultyMaster?->FACULTY_NAME)->toBe('Others')
        ->and($educations[0]->majorMaster?->MAJOR_NAME)->toBe('Other')
        ->and($educations[1]->edutype_id)->toBe(4)
        ->and($educations[1]->faculty)->toBeNull()
        ->and($educations[1]->faculty_id)->toBeNull();

    $otherEntries = ApplicantEducationOther::where('applicant_education_id', $educations[0]->id)
        ->pluck('custom_name', 'category')
        ->all();

    expect($otherEntries)->toMatchArray([
        ApplicantEducationOther::CATEGORY_SCHOOL => 'UNIVERSITAS CONTOH BARU TIDAK TERDAFTAR',
        ApplicantEducationOther::CATEGORY_FACULTY => 'FAKULTAS CONTOH BARU',
        ApplicantEducationOther::CATEGORY_MAJOR => 'JURUSAN CONTOH BARU',
    ]);

    $job = Job::factory()->create();
    $application = Application::factory()->create([
        'applicant_id' => $applicant->id,
        'job_id' => $job->id,
    ]);

    $personalData = app(HrisTransferService::class)->transferAcceptedApplicant($application);

    $hrisEducations = ThrmAppEducation::where('APPLICANT_ID', $personalData->APPLICANT_ID)
        ->orderBy('APPEDUCATION_ID')
        ->get();

    expect($hrisEducations)->toHaveCount(2)
        ->and($hrisEducations[0]->EDUTYPE_ID)->toBe(7)
        ->and($hrisEducations[0]->EDU_NAME)->toBe('Other')
        ->and($hrisEducations[0]->FACULTY)->toBe('Others')
        ->and($hrisEducations[0]->MAJOR)->toBe('Other')
        ->and($hrisEducations[0]->GPASCALE)->toBe('4')
        ->and($hrisEducations[0]->IS_DEFAULT)->toBe(1)
        ->and($hrisEducations[0]->SPECIALIZATION)->toBeNull()
        ->and($hrisEducations[1]->EDUTYPE_ID)->toBe(4)
        ->and($hrisEducations[1]->FACULTY)->toBeNull()
        ->and($hrisEducations[1]->GPASCALE)->toBe('100')
        ->and($hrisEducations[1]->IS_DEFAULT)->toBe(0);
});
