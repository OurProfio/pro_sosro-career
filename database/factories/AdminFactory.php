<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\Office;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Admin>
 */
class AdminFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'user_id' => User::factory()->admin(),
            'office_id' => Office::factory(),
            'role' => 'admin',
            'is_active' => true,
        ];
    }
}
