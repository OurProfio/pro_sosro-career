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

it('returns Indonesian error message when marital year is not an integer', function (string $routeMethod, string $routeName) {
    $userNew = User::factory()->create(['role' => 'user']);
    $route = $routeName === 'biodata.update'
        ? route($routeName, Applicant::factory()->create(['user_id' => $userNew->id]))
        : route($routeName);

    $response = $this->actingAs($userNew)->{$routeMethod}($route, ['marital_date' => '19.5']);

    $response->assertSessionHasErrors([
        'marital_date' => 'Tahun pernikahan harus berupa tahun yang valid (contoh: 2020).',
    ]);
})->with([
    'create' => ['post', 'biodata.store'],
    'edit' => ['put', 'biodata.update'],
]);

it('requires marital year when marital status is married, divorced, or widowed', function (string $routeMethod, string $routeName, string $maritalStatus) {
    $userNew = User::factory()->create(['role' => 'user']);
    $route = $routeName === 'biodata.update'
        ? route($routeName, Applicant::factory()->create(['user_id' => $userNew->id]))
        : route($routeName);

    $response = $this->actingAs($userNew)->{$routeMethod}($route, [
        'marital_status' => $maritalStatus,
        'marital_date' => '',
    ]);

    $response->assertSessionHasErrors([
        'marital_date' => 'Tahun pernikahan/perceraian wajib diisi.',
    ]);
})->with([
    'create married' => ['post', 'biodata.store', 'married'],
    'create divorced' => ['post', 'biodata.store', 'divorced'],
    'create widowed' => ['post', 'biodata.store', 'widowed'],
    'edit married' => ['put', 'biodata.update', 'married'],
    'edit divorced' => ['put', 'biodata.update', 'divorced'],
    'edit widowed' => ['put', 'biodata.update', 'widowed'],
]);

it('does not require marital year when marital status is single', function (string $routeMethod, string $routeName) {
    $userNew = User::factory()->create(['role' => 'user']);
    $route = $routeName === 'biodata.update'
        ? route($routeName, Applicant::factory()->create(['user_id' => $userNew->id]))
        : route($routeName);

    $response = $this->actingAs($userNew)->{$routeMethod}($route, [
        'marital_status' => 'single',
        'marital_date' => '',
    ]);

    $response->assertSessionDoesntHaveErrors(['marital_date']);
})->with([
    'create' => ['post', 'biodata.store'],
    'edit' => ['put', 'biodata.update'],
]);

it('rejects applicant date of birth that is today, in the future, or younger than 17 years', function (string $routeMethod, string $routeName, string $invalidDob) {
    $userNew = User::factory()->create(['role' => 'user']);
    $route = $routeName === 'biodata.update'
        ? route($routeName, Applicant::factory()->create(['user_id' => $userNew->id]))
        : route($routeName);

    $response = $this->actingAs($userNew)->{$routeMethod}($route, [
        'date_of_birth' => $invalidDob,
    ]);

    $response->assertSessionHasErrors([
        'date_of_birth' => 'Usia pelamar minimal harus 17 tahun.',
    ]);
})->with([
    'create today' => ['post', 'biodata.store', now()->format('Y-m-d')],
    'create future' => ['post', 'biodata.store', now()->addDay()->format('Y-m-d')],
    'create 16 years ago' => ['post', 'biodata.store', now()->subYears(16)->format('Y-m-d')],
    'edit today' => ['put', 'biodata.update', now()->format('Y-m-d')],
    'edit future' => ['put', 'biodata.update', now()->addDay()->format('Y-m-d')],
    'edit 16 years ago' => ['put', 'biodata.update', now()->subYears(16)->format('Y-m-d')],
]);

it('accepts applicant date of birth that is exactly 17 years ago', function (string $routeMethod, string $routeName) {
    $userNew = User::factory()->create(['role' => 'user']);
    $route = $routeName === 'biodata.update'
        ? route($routeName, Applicant::factory()->create(['user_id' => $userNew->id]))
        : route($routeName);

    $response = $this->actingAs($userNew)->{$routeMethod}($route, [
        'date_of_birth' => now()->subYears(17)->format('Y-m-d'),
    ]);

    $response->assertSessionDoesntHaveErrors(['date_of_birth']);
})->with([
    'create' => ['post', 'biodata.store'],
    'edit' => ['put', 'biodata.update'],
]);

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
