<?php

use App\Models\Applicant;
use App\Models\ApplicantFamily;
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

    $this->actingAs($this->user)
        ->get(route('biodata.print'))
        ->assertOk()
        ->assertSee('FORMULIR BIODATA CALON KARYAWAN')
        ->assertSee('KAKAK PEREMPUAN');
});
