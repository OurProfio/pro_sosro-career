<?php

namespace Database\Factories;

use App\Models\Applicant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Applicant>
 */
class ApplicantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'nik' => fake()->unique()->numerify('################'),
            'address_ktp' => fake()->address(),
            'address_domisili' => fake()->address(),
            'gender' => fake()->randomElement(['l', 'p']),
            'place_of_birth' => fake()->city(),
            'date_of_birth' => fake()->date(),
            'height' => fake()->numberBetween(150, 190),
            'weight' => fake()->numberBetween(45, 90),
            'phone_number' => fake()->numerify('08##########'),
            'religion' => 'Islam',
            'is_smoker' => 'n',
            'has_tattoo' => 'n',
            'marital_status' => 'single',
            'photo_url' => 'photos/default.jpg',
        ];
    }
}
