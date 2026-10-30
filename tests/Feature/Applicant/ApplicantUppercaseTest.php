<?php

use App\Models\Applicant;
use App\Models\Division;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create(['role' => 'user']);
    $this->applicant = Applicant::factory()->create([
        'user_id' => $this->user->id,
        'gender' => 'l',
    ]);
});

it('transforms personal data string inputs to uppercase on update', function () {
    DB::table('treligion')->insertOrIgnore([
        'RELIGION_ID' => 'ISLAM',
        'RELIGION_NAME_ID' => 'Islam',
        'RELIGION_NAME_EN' => 'Islam',
    ]);

    $division = Division::firstOrCreate(['name' => 'Information Technology']);

    $payload = [
        'nik' => '3171012345670001',
        'name' => 'budi santoso pratama',
        'place_of_birth' => 'jakarta timur',
        'address_ktp' => 'jl. raya bogor km 28',
        'address_domisili' => 'jl. mangga besar no 10',
        'emergency_contact_name' => 'siti aminah',
        'emergency_contact_relationship' => 'Orang Tua',
        'emergency_contact_phone' => '081234567890',
        'gender' => 'l',
        'date_of_birth' => '1998-05-10',
        'height' => 172,
        'weight' => 65,
        'blood_type' => 'O',
        'phone_number' => '081234567891',
        'religion' => 'ISLAM',
        'is_smoker' => 'n',
        'has_tattoo' => 'n',
        'marital_status' => 'single',
        'salary_expectation' => '8000000',
        'ready_to_relocate' => 1,
        'ready_to_travel' => 1,
        'job_source' => 'LinkedIn',
        'division_preferences' => [$division->id],
    ];

    $response = $this->actingAs($this->user)
        ->put(route('biodata.update', $this->applicant), $payload);

    $response->assertSessionHasNoErrors();

    $this->assertDatabaseHas('applicants', [
        'id' => $this->applicant->id,
        'name' => 'BUDI SANTOSO PRATAMA',
        'place_of_birth' => 'JAKARTA TIMUR',
        'address_ktp' => 'JL. RAYA BOGOR KM 28',
        'address_domisili' => 'JL. MANGGA BESAR NO 10',
        'emergency_contact_name' => 'SITI AMINAH',
    ]);
});

it('transforms family data inputs to uppercase on store', function () {
    $payload = [
        'families' => [
            'father' => [
                'name' => 'budi santoso',
                'status' => 'alive',
                'place_of_birth' => 'jakarta',
                'date_of_birth' => '1960-01-01',
                'education' => 'SMA',
                'work' => 'pensiunan pns',
                'phone_number' => '081234567890',
                'relationship' => 'father',
                'family_type' => 'biological',
            ],
            'mother' => [
                'name' => 'siti aminah',
                'status' => 'alive',
                'place_of_birth' => 'bandung',
                'date_of_birth' => '1965-02-02',
                'education' => 'SMA',
                'work' => 'ibu rumah tangga',
                'phone_number' => '081234567891',
                'relationship' => 'mother',
                'family_type' => 'biological',
            ],
        ],
    ];

    $response = $this->actingAs($this->user)
        ->post(route('biodata.family.store'), $payload);

    $response->assertSessionHasNoErrors();

    $this->assertDatabaseHas('applicant_families', [
        'applicant_id' => $this->applicant->id,
        'relationship' => 'father',
        'name' => 'BUDI SANTOSO',
        'place_of_birth' => 'JAKARTA',
        'work' => 'PENSIUNAN PNS',
    ]);

    $this->assertDatabaseHas('applicant_families', [
        'applicant_id' => $this->applicant->id,
        'relationship' => 'mother',
        'name' => 'SITI AMINAH',
        'place_of_birth' => 'BANDUNG',
        'work' => 'IBU RUMAH TANGGA',
    ]);
});

it('transforms education data inputs to uppercase on store', function () {
    $payload = [
        'educations' => [
            [
                'institution_name' => 'universitas indonesia',
                'city' => 'depok',
                'degree_level' => 'S1',
                'major' => 'ilmu komputer',
                'gpa' => 3.75,
                'entry_year' => 2018,
                'graduation_year' => 2022,
            ],
        ],
    ];

    $response = $this->actingAs($this->user)
        ->post(route('biodata.education.store'), $payload);

    $response->assertSessionHasNoErrors();

    $this->assertDatabaseHas('applicant_education', [
        'applicant_id' => $this->applicant->id,
        'institution_name' => 'UNIVERSITAS INDONESIA',
        'city' => 'DEPOK',
        'major' => 'ILMU KOMPUTER',
    ]);
});

it('transforms work experience data inputs to uppercase on store', function () {
    $payload = [
        'has_applied_sosro' => 'n',
        'experiences' => [
            [
                'company_name' => 'pt sinar sejahtera perkasa',
                'company_address' => 'jl. jendral sudirman kav 1',
                'position' => 'senior web developer',
                'division' => 'technology',
                'salary' => '10000000',
                'start_date' => '2022-01-01',
                'end_date' => '2024-01-01',
                'facility' => 'laptop dan asuransi kesehatan',
                'reason_for_leaving' => 'mencari peluang karir baru',
                'reference_name' => 'bambang pamungkas',
                'reference_position' => 'engineering manager',
                'reference_phone' => '081234567899',
            ],
        ],
    ];

    $response = $this->actingAs($this->user)
        ->post(route('biodata.workExperience.store'), $payload);

    $response->assertSessionHasNoErrors();

    $this->assertDatabaseHas('applicant_work_expriences', [
        'applicant_id' => $this->applicant->id,
        'company_name' => 'PT SINAR SEJAHTERA PERKASA',
        'position' => 'SENIOR WEB DEVELOPER',
        'division' => 'TECHNOLOGY',
        'reference_name' => 'BAMBANG PAMUNGKAS',
    ]);
});
