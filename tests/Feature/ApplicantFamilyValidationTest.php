<?php

use App\Models\Applicant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create(['role' => 'user']);
    Applicant::factory()->create(['user_id' => $this->user->id, 'marital_status' => 'single']);
});

it('shows readable indonesian messages for missing parent fields', function () {
    $payload = [
        'families' => [
            'father' => ['relationship' => 'father', 'family_type' => 'biological'],
            'mother' => ['relationship' => 'mother', 'family_type' => 'biological'],
        ],
    ];

    $response = $this->actingAs($this->user)
        ->from(route('biodata.family.create'))
        ->post(route('biodata.family.store'), $payload);

    $response->assertRedirect(route('biodata.family.create'));
    $response->assertSessionHasErrors([
        'families.father.education' => 'pendidikan terakhir ayah wajib diisi.',
        'families.mother.name' => 'nama lengkap ibu wajib diisi.',
    ]);
});

it('labels sibling errors with their position and uses character limit wording', function () {
    $payload = [
        'families' => [
            'father' => [
                'name' => 'Budi', 'status' => 'alive', 'place_of_birth' => 'Jakarta', 'date_of_birth' => '1960-01-01',
                'education' => 'SMA/SMK', 'relationship' => 'father', 'family_type' => 'biological',
            ],
            'mother' => [
                'name' => 'Siti', 'status' => 'alive', 'place_of_birth' => 'Bandung', 'date_of_birth' => '1965-01-01',
                'education' => 'SMA/SMK', 'relationship' => 'mother', 'family_type' => 'biological',
            ],
            'siblings' => [
                ['name' => str_repeat('a', 300), 'relationship' => 'sibling', 'family_type' => 'biological'],
            ],
        ],
    ];

    $this->actingAs($this->user)
        ->from(route('biodata.family.create'))
        ->post(route('biodata.family.store'), $payload)
        ->assertSessionHasErrors([
            'families.siblings.0.name' => 'nama lengkap saudara kandung ke-1 tidak boleh lebih dari 255 karakter.',
            'families.siblings.0.education' => 'pendidikan terakhir saudara kandung ke-1 wajib diisi.',
        ]);
});

it('rejects adult family members younger than 17 years old', function () {
    $this->user->applicant->update(['marital_status' => 'married']);
    $tooYoung = now()->subYears(16)->format('Y-m-d');

    $payload = [
        'families' => [
            'father' => [
                'name' => 'Budi', 'status' => 'alive', 'place_of_birth' => 'Jakarta', 'date_of_birth' => $tooYoung,
                'education' => 'SMA/SMK', 'relationship' => 'father', 'family_type' => 'biological',
            ],
            'mother' => [
                'name' => 'Siti', 'status' => 'alive', 'place_of_birth' => 'Bandung', 'date_of_birth' => now()->format('Y-m-d'),
                'education' => 'SMA/SMK', 'relationship' => 'mother', 'family_type' => 'biological',
            ],
            'spouse' => [
                'name' => 'Ani', 'place_of_birth' => 'Surabaya', 'date_of_birth' => now()->addDay()->format('Y-m-d'),
                'education' => 'S1', 'work' => 'Karyawan', 'phone_number' => '081234567890',
                'relationship' => 'spouse', 'family_type' => 'nuclear',
            ],
            'father_in_law' => [
                'date_of_birth' => $tooYoung,
            ],
            'mother_in_law' => [
                'date_of_birth' => now()->format('Y-m-d'),
            ],
        ],
    ];

    $this->actingAs($this->user)
        ->from(route('biodata.family.create'))
        ->post(route('biodata.family.store'), $payload)
        ->assertSessionHasErrors([
            'families.father.date_of_birth' => 'tanggal lahir ayah minimal harus 17 tahun sebelum hari ini.',
            'families.mother.date_of_birth' => 'tanggal lahir ibu minimal harus 17 tahun sebelum hari ini.',
            'families.spouse.date_of_birth' => 'tanggal lahir pasangan minimal harus 17 tahun sebelum hari ini.',
            'families.father_in_law.date_of_birth' => 'tanggal lahir ayah mertua minimal harus 17 tahun sebelum hari ini.',
            'families.mother_in_law.date_of_birth' => 'tanggal lahir ibu mertua minimal harus 17 tahun sebelum hari ini.',
        ]);
});

it('rejects today or future birth dates for siblings and children while allowing minors', function () {
    $this->user->applicant->update(['marital_status' => 'married']);

    $payload = [
        'families' => [
            'father' => [
                'name' => 'Budi', 'status' => 'alive', 'place_of_birth' => 'Jakarta', 'date_of_birth' => now()->subYears(50)->format('Y-m-d'),
                'education' => 'SMA/SMK', 'relationship' => 'father', 'family_type' => 'biological',
            ],
            'mother' => [
                'name' => 'Siti', 'status' => 'alive', 'place_of_birth' => 'Bandung', 'date_of_birth' => now()->subYears(48)->format('Y-m-d'),
                'education' => 'SMA/SMK', 'relationship' => 'mother', 'family_type' => 'biological',
            ],
            'spouse' => [
                'name' => 'Ani', 'place_of_birth' => 'Surabaya', 'date_of_birth' => now()->subYears(25)->format('Y-m-d'),
                'education' => 'S1', 'work' => 'Karyawan', 'phone_number' => '081234567890',
                'relationship' => 'spouse', 'family_type' => 'nuclear',
            ],
            'siblings' => [
                [
                    'name' => 'Adik', 'place_of_birth' => 'Jakarta', 'date_of_birth' => now()->format('Y-m-d'),
                    'education' => 'SD', 'work' => 'Pelajar', 'phone_number' => '0',
                    'relationship' => 'sibling', 'family_type' => 'biological',
                ],
                [
                    'name' => 'Adik Kecil', 'place_of_birth' => 'Jakarta', 'date_of_birth' => now()->subYears(10)->format('Y-m-d'),
                    'education' => 'SD', 'work' => 'Pelajar', 'phone_number' => '0',
                    'relationship' => 'sibling', 'family_type' => 'biological',
                ],
            ],
            'children' => [
                [
                    'name' => 'Anak Masa Depan', 'place_of_birth' => 'Jakarta', 'date_of_birth' => now()->addDay()->format('Y-m-d'),
                    'education' => 'Belum Sekolah', 'work' => 'Belum Bekerja', 'phone_number' => '0',
                    'relationship' => 'child', 'family_type' => 'nuclear',
                ],
                [
                    'name' => 'Anak Balita', 'place_of_birth' => 'Jakarta', 'date_of_birth' => now()->subYears(3)->format('Y-m-d'),
                    'education' => 'Belum Sekolah', 'work' => 'Belum Bekerja', 'phone_number' => '0',
                    'relationship' => 'child', 'family_type' => 'nuclear',
                ],
            ],
        ],
    ];

    $this->actingAs($this->user)
        ->from(route('biodata.family.create'))
        ->post(route('biodata.family.store'), $payload)
        ->assertSessionHasErrors([
            'families.siblings.0.date_of_birth' => 'tanggal lahir saudara kandung ke-1 harus sebelum hari ini.',
            'families.children.0.date_of_birth' => 'tanggal lahir anak ke-1 harus sebelum hari ini.',
        ])
        ->assertSessionDoesntHaveErrors([
            'families.siblings.1.date_of_birth',
            'families.children.1.date_of_birth',
        ]);
});
