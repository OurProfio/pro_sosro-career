<?php

namespace Database\Factories;

use App\Models\Application;
use App\Models\UserConfirmation;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<UserConfirmation>
 */
class UserConfirmationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'application_id' => Application::factory(),
            'email' => fake()->safeEmail(),
            'token' => hash('sha256', Str::random(64)),
            'expires_at' => now()->addDays(7),
            'decision' => 'pending',
        ];
    }
}
