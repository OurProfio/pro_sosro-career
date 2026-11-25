<?php

use App\Models\Admin;
use App\Models\Applicant;
use App\Models\ApplicantEducation;
use App\Models\ApplicantFamily;
use App\Models\Application;
use App\Models\Job;
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

it('saves gender for siblings and children when saving family data', function () {
    $payload = [
        'families' => [
            'father' => [
                'name' => 'Budi Santoso',
                'status' => 'alive',
                'place_of_birth' => 'Jakarta',
                'date_of_birth' => '1960-01-01',
                'education' => 'SMA',
                'work' => 'Pensiunan',
                'phone_number' => '081234567890',
                'relationship' => 'father',
                'family_type' => 'biological',
            ],
            'mother' => [
                'name' => 'Siti Aminah',
                'status' => 'alive',
                'place_of_birth' => 'Bandung',
                'date_of_birth' => '1965-02-02',
                'education' => 'SMA',
                'work' => 'Ibu Rumah Tangga',
                'phone_number' => '081234567891',
                'relationship' => 'mother',
                'family_type' => 'biological',
            ],
            'siblings' => [
                [
                    'name' => 'Adik Laki',
                    'gender' => 'l',
                    'status' => 'alive',
                    'place_of_birth' => 'Jakarta',
                    'date_of_birth' => '2000-05-05',
                    'education' => 'S1',
                    'work' => 'Karyawan',
                    'phone_number' => '081234567892',
                    'relationship' => 'sibling',
                    'family_type' => 'biological',
                ],
                [
                    'name' => 'Adik Perempuan',
                    'gender' => 'p',
                    'status' => 'alive',
                    'place_of_birth' => 'Jakarta',
                    'date_of_birth' => '2003-08-08',
                    'education' => 'SMA',
                    'work' => 'Mahasiswi',
                    'phone_number' => '081234567893',
                    'relationship' => 'sibling',
                    'family_type' => 'biological',
                ],
            ],
        ],
    ];

    $this->actingAs($this->user)
        ->post(route('biodata.family.store'), $payload)
        ->assertRedirect(route('biodata.education.create'));

    $this->assertDatabaseHas('applicant_families', [
        'applicant_id' => $this->applicant->id,
        'relationship' => 'sibling',
        'name' => 'Adik Laki',
        'gender' => 'l',
    ]);

    $this->assertDatabaseHas('applicant_families', [
        'applicant_id' => $this->applicant->id,
        'relationship' => 'sibling',
        'name' => 'Adik Perempuan',
        'gender' => 'p',
    ]);
});

it('renders print view with gender and family correctly', function () {
    ApplicantFamily::create([
        'applicant_id' => $this->applicant->id,
        'relationship' => 'sibling',
        'family_type' => 'biological',
        'status' => 'alive',
        'name' => 'Kakak Perempuan',
        'gender' => 'p',
        'place_of_birth' => 'Jakarta',
        'date_of_birth' => '1995-01-01',
        'education' => 'S1',
        'phone_number' => '081234567894',
        'work' => 'Guru',
    ]);

    ApplicantEducation::create([
        'applicant_id' => $this->applicant->id,
        'institution_name' => 'Universitas Indonesia',
        'state' => 'Depok',
        'degree_level' => 'S1',
        'major' => 'Ilmu Komputer',
        'gpa' => 3.75,
        'entry_year' => 2018,
        'graduation_year' => 2022,
    ]);

    $admin = Admin::factory()->create(['role' => 'superadmin']);
    Application::factory()->create([
        'applicant_id' => $this->applicant->id,
        'job_id' => Job::factory()->create()->id,
    ]);

    $this->actingAs($admin->user)
        ->get(route('applicant.print', $this->applicant))
        ->assertOk()
        ->assertSee('FORMULIR BIODATA CALON KARYAWAN')
        ->assertSee('KAKAK PEREMPUAN')
        ->assertSee('UNIVERSITAS INDONESIA')
        ->assertSee('DEPOK');

    $this->actingAs($this->user)
        ->get('/biodata/cetak')
        ->assertNotFound();
});

it('links applicant dashboard help card to kontak and hides biodata print button', function () {
    ApplicantFamily::create([
        'applicant_id' => $this->applicant->id,
        'relationship' => 'father',
        'name' => 'Budi Santoso',
        'gender' => 'l',
        'place_of_birth' => 'Jakarta',
        'date_of_birth' => '1960-01-01',
        'education' => 'SMA',
        'phone_number' => '081234567890',
        'work' => 'Karyawan',
    ]);

    ApplicantEducation::create([
        'applicant_id' => $this->applicant->id,
        'institution_name' => 'Universitas Indonesia',
        'state' => 'Depok',
        'degree_level' => 'S1',
        'major' => 'Ilmu Komputer',
        'gpa' => 3.75,
        'entry_year' => 2018,
        'graduation_year' => 2022,
    ]);

    $this->actingAs($this->user)
        ->get(route('applicant.dashboard'))
        ->assertOk()
        ->assertSee('href="'.route('guest.kontak').'"', false);

    $this->actingAs($this->user)
        ->get(route('biodata.index'))
        ->assertOk()
        ->assertSee('Kembali ke Beranda')
        ->assertSee('href="'.route('applicant.dashboard').'"', false)
        ->assertDontSee('Cetak / Simpan PDF');
});

it('shows spouse section before biological parents for married applicants and links step 1 directly', function () {
    $this->applicant->update(['marital_status' => 'married']);

    $response = $this->actingAs($this->user)
        ->get(route('biodata.family.create'))
        ->assertOk();

    $html = $response->getContent();

    expect(strpos($html, 'Data Suami / Istri'))->not->toBeFalse()
        ->and(strpos($html, '1. Data Ayah Kandung'))->not->toBeFalse()
        ->and(strpos($html, 'Data Suami / Istri'))->toBeLessThan(strpos($html, '1. Data Ayah Kandung'))
        ->and($html)->toContain('href="'.route('biodata.edit', $this->applicant->id).'"')
        ->and($html)->not->toContain("goToStep('personal')")
        ->and($html)->not->toContain("goToStep('education')")
        ->and($html)->not->toContain("goToStep('workExperience')");
});

it('only allows navigating back to previous steps on the education stepper navbar', function () {
    ApplicantFamily::create([
        'applicant_id' => $this->applicant->id,
        'family_type' => 'biological',
        'relationship' => 'father',
        'name' => 'Budi Santoso',
        'gender' => 'l',
        'place_of_birth' => 'Jakarta',
        'date_of_birth' => '1960-01-01',
        'education' => 'SMA',
        'phone_number' => '081234567890',
        'work' => 'Karyawan',
    ]);

    $response = $this->actingAs($this->user)
        ->get(route('biodata.education.create'))
        ->assertOk();

    $html = $response->getContent();

    expect($html)->toContain('href="'.route('biodata.edit', $this->applicant->id).'"')
        ->and($html)->toContain('href="'.route('biodata.family.create').'"')
        ->and($html)->not->toContain("goToStep('workExperience')");
});

it('deletes marriage family records and marital date when changing marital status back to single', function () {
    $this->applicant->update([
        'marital_status' => 'married',
        'marital_date' => 2020,
    ]);

    DB::table('treligion')->insertOrIgnore([
        'RELIGION_ID' => '1',
        'RELIGION_NAME_ID' => 'Islam',
        'RELIGION_NAME_EN' => 'Islam',
    ]);

    DB::table('thrm_family_connection')->insertOrIgnore([
        'RELATIONSHIP_ID' => 1,
        'FAMILY_RELATIONSHIP_ID' => 'Ayah',
    ]);

    ApplicantFamily::create([
        'applicant_id' => $this->applicant->id,
        'family_type' => 'biological',
        'relationship' => 'father',
        'name' => 'Budi Santoso',
        'gender' => 'l',
        'place_of_birth' => 'Jakarta',
        'date_of_birth' => '1960-01-01',
        'education' => 'SMA',
        'phone_number' => '081234567890',
        'work' => 'Karyawan',
    ]);

    ApplicantFamily::create([
        'applicant_id' => $this->applicant->id,
        'family_type' => 'nuclear',
        'relationship' => 'spouse',
        'name' => 'Siti Rahma',
        'gender' => 'p',
        'place_of_birth' => 'Bandung',
        'date_of_birth' => '1996-05-10',
        'education' => 'S1',
        'phone_number' => '081234567891',
        'work' => 'Karyawan',
    ]);

    ApplicantFamily::create([
        'applicant_id' => $this->applicant->id,
        'family_type' => 'nuclear',
        'relationship' => 'child',
        'name' => 'Andi Pratama',
        'gender' => 'l',
        'place_of_birth' => 'Jakarta',
        'date_of_birth' => '2021-01-15',
        'education' => 'TK',
        'phone_number' => '0',
        'work' => 'Pelajar',
    ]);

    $this->actingAs($this->user)
        ->put(route('biodata.update', $this->applicant->id), [
            'name' => $this->applicant->name,
            'email' => $this->applicant->email,
            'nik' => $this->applicant->nik,
            'address_ktp' => $this->applicant->address_ktp,
            'address_domisili' => $this->applicant->address_domisili,
            'gender' => 'l',
            'place_of_birth' => $this->applicant->place_of_birth,
            'date_of_birth' => '1995-01-01',
            'height' => 170,
            'weight' => 65,
            'blood_type' => 'O',
            'phone_number' => '081234567899',
            'religion' => '1',
            'is_smoker' => 'n',
            'has_tattoo' => 'n',
            'marital_status' => 'single',
            'marital_date' => 2020,
            'emergency_contact_name' => 'Budi Santoso',
            'emergency_contact_relationship' => 1,
            'emergency_contact_phone' => '081234567890',
            'emergency_contact_address' => 'Jl. Merdeka No. 1',
            'emergency_contact_state' => 'DKI Jakarta',
            'emergency_contact_city' => 'Jakarta Selatan',
            'salary_expectation' => 5000000,
            'ready_to_relocate' => 1,
            'ready_to_travel' => 1,
            'job_source' => 'Career Page',
        ])
        ->assertRedirect(route('biodata.family.create'))
        ->assertSessionHasNoErrors();

    expect($this->applicant->fresh())
        ->marital_status->toBe('single')
        ->marital_date->toBeNull();

    expect($this->applicant->families()->pluck('relationship')->all())
        ->toBe(['father']);
});

it('displays dynamic marital year label for married and divorced statuses', function () {
    $this->applicant->update(['marital_status' => 'married']);

    $this->actingAs($this->user)
        ->get(route('biodata.edit', $this->applicant->id))
        ->assertOk()
        ->assertSee('Tahun Menikah')
        ->assertDontSee('Tahun Menikah / Bercerai');

    $this->applicant->update(['marital_status' => 'divorced']);

    $this->actingAs($this->user)
        ->get(route('biodata.edit', $this->applicant->id))
        ->assertOk()
        ->assertSee('Tahun Cerai');
});
