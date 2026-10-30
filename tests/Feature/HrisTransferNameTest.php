<?php

use App\Models\Applicant;
use App\Models\Application;
use App\Models\Hris\ThrmAppPersonalData;
use App\Services\HrisTransferService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('splits names into first, middle, and last according to standard conventions', function () {
    $service = new HrisTransferService;

    // 1 word
    expect($service->splitName('Suharto'))->toBe([
        'first' => 'Suharto',
        'middle' => null,
        'last' => null,
    ]);

    // 2 words
    expect($service->splitName('Budi Santoso'))->toBe([
        'first' => 'Budi',
        'middle' => null,
        'last' => 'Santoso',
    ]);

    // 3 words
    expect($service->splitName('Budi Eko Santoso'))->toBe([
        'first' => 'Budi',
        'middle' => 'Eko',
        'last' => 'Santoso',
    ]);

    // 4 words
    expect($service->splitName('Muhammad Rizky Pratama Putra'))->toBe([
        'first' => 'Muhammad',
        'middle' => 'Rizky Pratama',
        'last' => 'Putra',
    ]);

    // 5 words
    expect($service->splitName('Raden Mas Arya Sena Kusuma'))->toBe([
        'first' => 'Raden',
        'middle' => 'Mas Arya Sena',
        'last' => 'Kusuma',
    ]);

    // Multiple spaces
    expect($service->splitName('   Raden    Mas   Arya   Sena   Kusuma   '))->toBe([
        'first' => 'Raden',
        'middle' => 'Mas Arya Sena',
        'last' => 'Kusuma',
    ]);
});

it('stores first, middle, and last name in thrm_app_personal_data when applicant is transferred', function () {
    $applicant = Applicant::factory()->create([
        'name' => 'Raden Mas Arya Sena Kusuma',
        'gender' => 'L',
    ]);

    $application = Application::factory()->create([
        'applicant_id' => $applicant->id,
        'status' => 'accepted',
    ]);

    $service = new HrisTransferService;
    $personalData = $service->transferAcceptedApplicant($application);

    expect($personalData)->toBeInstanceOf(ThrmAppPersonalData::class)
        ->and($personalData->FIRST_NAME)->toBe('Raden')
        ->and($personalData->MIDDLE_NAME)->toBe('Mas Arya Sena')
        ->and($personalData->LAST_NAME)->toBe('Kusuma');

    $this->assertDatabaseHas('thrm_app_personal_data', [
        'FIRST_NAME' => 'Raden',
        'MIDDLE_NAME' => 'Mas Arya Sena',
        'LAST_NAME' => 'Kusuma',
    ]);
});
