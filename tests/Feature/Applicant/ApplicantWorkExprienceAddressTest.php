<?php

use App\Models\Applicant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create(['role' => 'user']);
    $this->applicant = Applicant::factory()->create(['user_id' => $this->user->id]);
});

it('stores the company address in uppercase', function () {
    $this->actingAs($this->user)
        ->post(route('biodata.workExperience.store'), [
            'experiences' => [[
                'company_name' => 'pt maju',
                'company_address' => 'jl. merdeka no. 1, jakarta',
            ]],
        ])
        ->assertSessionHasNoErrors();

    expect($this->applicant->workExperiences()->first()->company_address)
        ->toBe('JL. MERDEKA NO. 1, JAKARTA');
});

it('rejects a company address longer than 255 characters', function () {
    $this->actingAs($this->user)
        ->post(route('biodata.workExperience.store'), [
            'experiences' => [[
                'company_name' => 'PT MAJU',
                'company_address' => str_repeat('A', 256),
            ]],
        ])
        ->assertSessionHasErrors('experiences.0.company_address');

    expect($this->applicant->workExperiences()->count())->toBe(0);
});
