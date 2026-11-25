<?php

use Database\Seeders\HrisMasterSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

uses(RefreshDatabase::class);

it('seeds HRIS master tables excluding SD and SMP and uses latest major and school CSVs', function () {
    // Sisipkan data lama (SD, SMP, dan sekolah lama) untuk memastikan dibersihkan oleh seeder.
    DB::table('thrm_education')->insert([
        ['EDUTYPE_ID' => 2, 'EDUTYPE_NAME_EN' => 'Elementary School', 'EDUTYPE_NAME_ID' => 'SD', 'EDUTYPE_LEVEL' => 1, 'STATUS' => 1],
        ['EDUTYPE_ID' => 3, 'EDUTYPE_NAME_EN' => 'Junior High School', 'EDUTYPE_NAME_ID' => 'SMP', 'EDUTYPE_LEVEL' => 2, 'STATUS' => 1],
    ]);

    DB::table('thrm_list_school')->insert([
        'EDU_ID' => 1,
        'EDU_CODE' => 'OLD',
        'EDU_NAME' => 'Sekolah Lama',
    ]);

    $this->seed(HrisMasterSeeder::class);

    expect(DB::table('treligion')->count())->toBe(7)
        ->and(DB::table('thrm_education')->count())->toBe(10)
        ->and(DB::table('thrm_education')->whereIn('EDUTYPE_ID', [2, 3])->count())->toBe(0)
        ->and(DB::table('thrm_education')->where('EDUTYPE_LEVEL', '<', 3)->count())->toBe(0)
        ->and(DB::table('thrm_education')->where('EDUTYPE_ID', 4)->value('EDUTYPE_NAME_ID'))->toBe('SMA')
        ->and(DB::table('thrm_list_faculty')->count())->toBe(151)
        ->and(DB::table('thrm_list_major')->count())->toBe(2200)
        ->and(DB::table('thrm_list_school')->count())->toBe(4303)
        ->and(DB::table('thrm_family_connection')->count())->toBe(21)
        ->and(DB::table('thrm_family_connection')->where('RELATIONSHIP_ID', 1)->value('FAMILY_RELATIONSHIP_ID'))->toBe('Ayah')
        ->and(DB::table('t_line_of_business')->count())->toBe(24)
        ->and(DB::table('t_line_of_business')->where('LOB_ID', 28)->value('LOB_NAME'))->toBe('FMCG')
        ->and(DB::table('thrm_position')->count())->toBe(1051)
        ->and(DB::table('thrm_position')->where('POSITION_ID', 42036)->value('POSITION_NAME_EN'))->toBe('RECRUITMENT STAFF')
        ->and(DB::table('thrm_list_school')->where('EDU_ID', 1)->exists())->toBeFalse();

    $firstFaculty = DB::table('thrm_list_faculty')->where('FACULTY_ID', 128)->first();
    $otherFaculty = DB::table('thrm_list_faculty')->where('FACULTY_ID', 278)->first();
    $firstMajor = DB::table('thrm_list_major')->where('MAJOR_ID', 2842)->first();
    $otherMajor = DB::table('thrm_list_major')->where('MAJOR_ID', 15)->first();
    $firstSchool = DB::table('thrm_list_school')->where('EDU_ID', 5053)->first();
    $otherSchool = DB::table('thrm_list_school')->where('EDU_ID', 44)->first();

    expect($firstFaculty)->not->toBeNull()
        ->and($firstFaculty->FACULTY_CODE)->toBe('702')
        ->and($firstFaculty->FACULTY_NAME)->toBe('Adab')
        ->and($firstFaculty->FACULTY_NAME_EN)->toBeNull()
        ->and($firstFaculty->FACULTY_NAME_ID)->toBeNull()
        ->and($firstFaculty->FACULTY_NAME_TH)->toBeNull()
        ->and($firstFaculty->FACULTY_NAME_MY)->toBeNull()
        ->and($firstFaculty->FACULTY_NAME_VN)->toBeNull();

    expect($otherFaculty)->not->toBeNull()
        ->and($otherFaculty->FACULTY_CODE)->toBe('OTHERS')
        ->and($otherFaculty->FACULTY_NAME)->toBe('Others');

    expect($firstMajor)->not->toBeNull()
        ->and($firstMajor->MAJOR_CODE)->toBe('418')
        ->and($firstMajor->MAJOR_NAME)->toBe('Elektronika Industri')
        ->and($firstMajor->MAJOR_NAME_EN)->toBeNull();

    expect($otherMajor)->not->toBeNull()
        ->and($otherMajor->MAJOR_CODE)->toBe('MJR2611100354')
        ->and($otherMajor->MAJOR_NAME)->toBe('Other');

    expect($firstSchool)->not->toBeNull()
        ->and($firstSchool->EDU_CODE)->toBe('024035')
        ->and($firstSchool->EDU_NAME)->toBe('Akademi Keuangan Dan Perbankan Mulia Darma Pratama');

    expect($otherSchool)->not->toBeNull()
        ->and($otherSchool->EDU_CODE)->toBe('I2611100354')
        ->and($otherSchool->EDU_NAME)->toBe('Other');
});

it('is idempotent when HrisMasterSeeder runs multiple times', function () {
    $this->seed(HrisMasterSeeder::class);
    $this->seed(HrisMasterSeeder::class);

    expect(DB::table('treligion')->count())->toBe(7)
        ->and(DB::table('thrm_education')->count())->toBe(10)
        ->and(DB::table('thrm_list_faculty')->count())->toBe(151)
        ->and(DB::table('thrm_list_major')->count())->toBe(2200)
        ->and(DB::table('thrm_list_school')->count())->toBe(4303)
        ->and(DB::table('thrm_family_connection')->count())->toBe(21)
        ->and(DB::table('t_line_of_business')->count())->toBe(24)
        ->and(DB::table('thrm_position')->count())->toBe(1051);
});
