<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\Job;
use App\Models\Office;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Job>
 */
class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'admin_id' => Admin::factory(),
            'office_id' => Office::factory(),
            'title' => fake()->jobTitle(),
            'category' => 'magang',
            'occupation' => fake()->word(),
            'type' => 'magang',
            'location' => fake()->randomElement(Job::CITIES),
            'opening_date' => now()->subDay()->toDateString(),
            'closing_date' => now()->addMonth()->toDateString(),
            'description' => fake()->sentence(),
            'qualification' => fake()->sentence(),
            'status' => 'aktif',
        ];
    }
}
