<?php

use App\Models\Applicant;
use App\Models\Application;
use App\Models\Job;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('seeds jobs and applicants with complete biodata', function () {
    $this->seed(DatabaseSeeder::class);

    expect(Job::count())->toBe(3)
        ->and(Applicant::count())->toBe(3)
        ->and(Application::count())->toBe(3);

    Applicant::with(['user', 'educations', 'families', 'trainings', 'interest', 'expectation'])->get()
        ->each(function (Applicant $applicant) {
            expect($applicant->user->role)->toBe('user')
                ->and($applicant->educations)->toHaveCount(2)
                ->and($applicant->families)->toHaveCount(3)
                ->and($applicant->trainings)->toHaveCount(1)
                ->and($applicant->interest->interests)->toHaveCount(3)
                ->and($applicant->expectation)->not->toBeNull();
        });
});

it('can be run twice without duplicating data', function () {
    $this->seed(DatabaseSeeder::class);
    $this->seed(DatabaseSeeder::class);

    expect(Job::count())->toBe(3)
        ->and(Applicant::count())->toBe(3)
        ->and(Applicant::first()->educations)->toHaveCount(2);
});
