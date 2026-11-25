<?php

use App\Models\Applicant;
use App\Models\ApplicantFamily;
use App\Models\ApplicantWorkExprience;
use App\Models\Application;
use App\Models\Hris\ThrmAppPersonalData;
use App\Services\HrisTransferService;
use Database\Seeders\ThrmAyleenSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

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

it('maps gender, alive status, work experience gross/netto, start salary, and request code to hris tables', function () {
    $applicant = Applicant::factory()->create([
        'name' => 'Siti Aminah',
        'gender' => 'P',
        'marital_status' => 'single',
    ]);

    ApplicantFamily::create([
        'applicant_id' => $applicant->id,
        'relationship' => 'father',
        'family_type' => 'biological',
        'name' => 'Ahmad',
        'place_of_birth' => 'Jakarta',
        'date_of_birth' => '1965-05-10',
        'education' => 'S1',
        'phone_number' => '081234567890',
        'work' => 'Wiraswasta',
        'gender' => 'l',
        'status' => 'deceased',
        'address' => 'Jl. Merdeka No. 1',
    ]);

    ApplicantFamily::create([
        'applicant_id' => $applicant->id,
        'relationship' => 'mother',
        'family_type' => 'biological',
        'name' => 'Rahmawati',
        'place_of_birth' => 'Bandung',
        'date_of_birth' => '1968-08-20',
        'education' => 'SMA',
        'phone_number' => '081234567891',
        'work' => 'Ibu Rumah Tangga',
        'gender' => 'p',
        'status' => 'alive',
        'address' => 'Jl. Merdeka No. 1',
    ]);

    DB::table('t_line_of_business')->insert([
        'LOB_ID' => 28,
        'LOB_NAME' => 'FMCG',
    ]);

    ApplicantWorkExprience::create([
        'applicant_id' => $applicant->id,
        'company_name' => 'PT Contoh Jaya',
        'position' => 'Staff Finance',
        'lob_id' => 28,
        'job_desc' => 'Mengelola laporan keuangan dan rekonsiliasi bulanan',
        'salary' => 7500000,
        'gross_netto' => 'Netto',
        'start_date' => '2022-01-01',
        'end_date' => '2024-01-01',
    ]);

    $application = Application::factory()->create([
        'applicant_id' => $applicant->id,
        'status' => 'accepted',
    ]);

    DB::table('thrm_position')->insert([
        'POSITION_ID' => 42036,
        'POSITION_NAME_EN' => 'RECRUITMENT STAFF',
    ]);

    $personalData = (new HrisTransferService)->transferAcceptedApplicant($application, [
        'request_code' => 'RCR20261117235',
        'position_id' => 42036,
    ]);

    expect($personalData->APPLICANT_ID)->toBe('APL'.date('Ym').str_pad((string) $applicant->id, 5, '0', STR_PAD_LEFT))
        ->and($personalData->GENDER)->toBe(0)
        ->and($personalData->MARITAL_STATUS)->toBe(0)
        ->and($personalData->STATUSAPP)->toBe('A')
        ->and($personalData->COUNTRY1)->toBe('ID')
        ->and($personalData->COUNTRY2)->toBe('ID')
        ->and($personalData->NATIONALITY_ID)->toBe('ID')
        ->and($personalData->COMPANY_ID)->toBe(73)
        ->and($personalData->IS_INTERNAL)->toBe('N')
        ->and($personalData->CURRENCY_ID)->toBe('IDR')
        ->and($personalData->CREATEDBY)->toBe('SYSTEM')
        ->and($personalData->UPDATEDBY)->toBe('SYSTEM')
        ->and($personalData->CREATEDDATE)->not->toBeNull()
        ->and($personalData->UPDATEDDATE)->not->toBeNull()
        ->and($personalData->APPLIED_DATE)->not->toBeNull()
        ->and($personalData->MEDIUM_ID)->toBe(63)
        ->and($personalData->MEDIUM_CODE)->toBe('IWT')
        ->and($personalData->REQUEST_CODE)->toBe('RCR20261117235');

    $this->assertDatabaseHas('thrm_app_history', [
        'APPLICANT_ID' => $personalData->APPLICANT_ID,
        'REQUEST_CODE' => 'RCR20261117235',
        'MEDIUM_ID' => 63,
        'MEDIUM_CODE' => 'IWT',
        'APPLIED_POSITION' => 42036,
        'EXPECTED_POSITION' => 42036,
        'APPLIED_JOBTITLE' => 'RECRUITMENT STAFF',
        'EXPECTED_JOBTITLE' => 'RECRUITMENT STAFF',
        'CURRENT_SALARY' => 7500000,
        'CURRENCY_ID' => 'IDR',
        'PAYMENTTYPECODE' => 'MONTHLY',
        'COMPANY_ID' => 73,
        'CREATEDBY' => 'SYSTEM',
        'UPDATEDBY' => 'SYSTEM',
        'APPSTS' => 3,
        'COMPLETETEST' => 1,
        'APPLICANT_FLAG' => null,
    ]);

    $this->assertDatabaseHas('thrm_app_family', [
        'APPLICANT_ID' => $personalData->APPLICANT_ID,
        'APPFAMILY_NAME' => 'Ahmad',
        'APPFAMILY_RELATIONSHIP_ID' => 1,
        'APPFAMILY_RELATIONSHIP2' => '',
        'APPFAMILY_LASTEDUCATION' => '7',
        'APPFAMILY_DEPENDENTSTS' => 0,
        'APPFAMILY_MARITAL_STATUS' => '1',
        'APPFAMILY_GENDER' => '1',
        'ALIVE_STATUS' => 0,
    ]);

    $this->assertDatabaseHas('thrm_app_family', [
        'APPLICANT_ID' => $personalData->APPLICANT_ID,
        'APPFAMILY_NAME' => 'Rahmawati',
        'APPFAMILY_RELATIONSHIP_ID' => 2,
        'APPFAMILY_RELATIONSHIP2' => '',
        'APPFAMILY_LASTEDUCATION' => '4',
        'APPFAMILY_DEPENDENTSTS' => 0,
        'APPFAMILY_MARITAL_STATUS' => '1',
        'APPFAMILY_GENDER' => '0',
        'ALIVE_STATUS' => 1,
    ]);

    $this->assertDatabaseHas('thrm_app_job_exp', [
        'APPLICANT_ID' => $personalData->APPLICANT_ID,
        'COMPANY_NAME' => 'PT Contoh Jaya',
        'JOB_DESC' => 'Mengelola laporan keuangan dan rekonsiliasi bulanan',
        'START_SALARY' => 7500000,
        'LAST_SALARY' => 7500000,
        'TYPE_SALARY' => '6',
        'START_TYPE_SALARY' => '6',
        'GROSS_NETTO' => 'Netto',
        'LOB_ID' => 28,
        'LOB' => 'FMCG',
        'CURRENCY_ID' => 'IDR',
        'START_CURRENCY_ID' => 'IDR',
    ]);
});

it('seeds Ayleen sample data across all 5 related thrm_app tables idempotently', function () {
    $this->seed(ThrmAyleenSeeder::class);
    $this->seed(ThrmAyleenSeeder::class);

    $ayleen = ThrmAppPersonalData::with(['families', 'educations', 'jobExperiences', 'histories'])
        ->find(ThrmAyleenSeeder::APPLICANT_ID);

    expect($ayleen)->not->toBeNull()
        ->and($ayleen->FIRST_NAME)->toBe('AYLEEN')
        ->and($ayleen->families)->toHaveCount(2)
        ->and($ayleen->educations)->toHaveCount(1)
        ->and($ayleen->jobExperiences)->toHaveCount(1)
        ->and($ayleen->histories)->toHaveCount(1)
        ->and($ayleen->histories->first()->personalData->APPLICANT_ID)->toBe('APL20261112526');
});
