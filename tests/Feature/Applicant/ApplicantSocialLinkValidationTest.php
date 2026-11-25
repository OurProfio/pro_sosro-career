<?php

use App\Models\Applicant;
use App\Models\Division;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

uses(RefreshDatabase::class);

it('returns Indonesian error message when instagram username is too long', function () {
    $user = User::factory()->create(['role' => 'user']);

    $response = $this->actingAs($user)
        ->from(route('biodata.create'))
        ->post(route('biodata.store'), [
            'instagram' => 'https://www.instagram.com/'.str_repeat('a', 120).'?igsh=MWQ1ZGUxMzBkMmZhYzImdGk%3D',
        ]);

    $response->assertSessionHasErrors([
        'instagram' => 'Akun Instagram maksimal 100 karakter (cukup tulis username tanpa link).',
    ]);
});

it('returns Indonesian error message when linkedin name is too long', function () {
    $user = User::factory()->create(['role' => 'user']);

    $response = $this->actingAs($user)
        ->from(route('biodata.create'))
        ->post(route('biodata.store'), [
            'linkedin' => str_repeat('a', 120),
        ]);

    $response->assertSessionHasErrors([
        'linkedin' => 'Akun LinkedIn maksimal 100 karakter (cukup tulis nama akun tanpa link).',
    ]);
});

it('returns Indonesian error message when emergency contact name is too long', function () {
    $user = User::factory()->create(['role' => 'user']);

    $response = $this->actingAs($user)
        ->from(route('biodata.create'))
        ->post(route('biodata.store'), [
            'emergency_contact_name' => str_repeat('A', 300),
        ]);

    $response->assertSessionHasErrors([
        'emergency_contact_name' => 'Nama kontak darurat maksimal 255 karakter.',
    ]);
});

it('strips a pasted instagram link down to the username', function () {
    DB::table('treligion')->insertOrIgnore([
        'RELIGION_ID' => 'ISLAM',
        'RELIGION_NAME_ID' => 'Islam',
        'RELIGION_NAME_EN' => 'Islam',
    ]);

    $division = Division::firstOrCreate(['name' => 'Information Technology']);
    $user = User::factory()->create(['role' => 'user']);
    $applicant = Applicant::factory()->create(['user_id' => $user->id]);

    $response = $this->actingAs($user)
        ->put(route('biodata.update', $applicant), [
            'nik' => '3171012345670001',
            'name' => 'Budi Santoso',
            'place_of_birth' => 'Jakarta',
            'address_ktp' => 'Jl. Raya Bogor Km 28',
            'address_domisili' => 'Jl. Mangga Besar No 10',
            'emergency_contact_name' => 'Siti Aminah',
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
            'instagram' => 'https://www.instagram.com/budi.santoso/?igsh=MWQ1ZGUxMzBkMmZhYzImdGk%3D',
            'linkedin' => 'https://www.linkedin.com/in/budi-santoso-12345/?utm_source=share',
        ]);

    $response->assertSessionHasNoErrors();

    expect($applicant->refresh())
        ->instagram->toBe('budi.santoso')
        ->linkedin->toBe('budi-santoso-12345');
});
