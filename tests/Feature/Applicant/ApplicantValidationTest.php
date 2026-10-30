<?php

use App\Models\Applicant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create(['role' => 'user']);
    $this->applicant = Applicant::factory()->create([
        'user_id' => $this->user->id,
        'gender' => 'l',
    ]);
});

it('returns correct Indonesian error message when father birth date is omitted in step 2', function () {
    $payload = [
        'families' => [
            'father' => [
                'name' => 'Budi Santoso',
                'status' => 'alive',
                'place_of_birth' => 'Jakarta',
                // 'date_of_birth' sengaja dikosongkan
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
        ],
    ];

    $response = $this->actingAs($this->user)
        ->from(route('biodata.family.create'))
        ->post(route('biodata.family.store'), $payload);

    $response->assertSessionHasErrors([
        'families.father.date_of_birth' => 'Tanggal lahir ayah kandung wajib diisi.',
    ]);
});

it('returns correct Indonesian error message when mother birth date is omitted in step 2', function () {
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
                // 'date_of_birth' sengaja dikosongkan
                'education' => 'SMA',
                'work' => 'Ibu Rumah Tangga',
                'phone_number' => '081234567891',
                'relationship' => 'mother',
                'family_type' => 'biological',
            ],
        ],
    ];

    $response = $this->actingAs($this->user)
        ->from(route('biodata.family.create'))
        ->post(route('biodata.family.store'), $payload);

    $response->assertSessionHasErrors([
        'families.mother.date_of_birth' => 'Tanggal lahir ibu kandung wajib diisi.',
    ]);
});

it('returns human-readable Indonesian error messages in step 1 personal data validation', function () {
    $userNew = User::factory()->create(['role' => 'user']);

    $response = $this->actingAs($userNew)
        ->from(route('biodata.create'))
        ->post(route('biodata.store'), [
            'name' => '',
            'height' => 80, // min 100
            'weight' => 20, // min 30
        ]);

    $response->assertSessionHasErrors([
        'name' => 'Nama lengkap wajib diisi.',
        'height' => 'Tinggi badan tidak logis (minimal 100 cm).',
        'weight' => 'Berat badan tidak logis (minimal 30 kg).',
        'photo' => 'Pas foto wajib diunggah.',
    ]);
});

it('returns human-readable Indonesian error messages in step 3 education validation', function () {
    $response = $this->actingAs($this->user)
        ->from(route('biodata.education.create'))
        ->post(route('biodata.education.store'), [
            'educations' => [
                [
                    'institution_name' => '',
                    'degree_level' => '',
                ],
            ],
        ]);

    $response->assertSessionHasErrors([
        'educations.0.degree_level' => 'Jenjang pendidikan wajib dipilih.',
        'educations.0.institution_name' => 'Nama sekolah / universitas wajib diisi.',
    ]);
});

it('returns human-readable Indonesian error messages in step 4 work experience validation', function () {
    $response = $this->actingAs($this->user)
        ->from(route('biodata.workExperience.create'))
        ->post(route('biodata.workExperience.store'), [
            'has_applied_sosro' => 'y',
            'previous_applied_position' => '',
            'previous_applied_year' => '',
            'experiences' => [
                [
                    'company_name' => 'PT Testing',
                    'start_date' => now()->addDays(5)->format('Y-m-d'), // invalid: in future
                ],
            ],
        ]);

    $response->assertSessionHasErrors([
        'previous_applied_position' => 'Jabatan posisi wajib diisi jika pernah melamar di Sinar Sosro / Group.',
        'previous_applied_year' => 'Tahun wajib diisi jika pernah melamar di Sinar Sosro / Group.',
        'experiences.0.start_date' => 'Tanggal mulai bekerja tidak boleh melebihi hari ini.',
    ]);
});
