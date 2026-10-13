<?php

namespace Database\Factories;

use App\Models\Applicant;
use App\Models\Application;
use App\Models\Job;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Application>
 */
class ApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'applicant_id' => Applicant::factory(),
            'job_id' => Job::factory(),
            'status' => 'pending',
        ];
    }
}
