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
