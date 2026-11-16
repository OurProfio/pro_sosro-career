<?php

namespace Database\Factories;

use App\Models\ContactMessage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ContactMessage>
 */
class ContactMessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => null,
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'region' => fake()->randomElement([
                'Kantor Pusat (Head Office)',
                'KPW Jakarta Banten',
                'KPW Jawa Barat',
                'KPW Jawa Tengah',
                'KPW Jawa Timur',
            ]),
            'message' => fake()->paragraph(),
            'status' => 'unread',
            'ip_address' => fake()->ipv4(),
            'user_agent' => fake()->userAgent(),
            'admin_notes' => null,
            'resolved_at' => null,
        ];
    }

    public function read(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => 'read',
        ]);
    }

    public function resolved(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => 'resolved',
            'resolved_at' => now(),
            'admin_notes' => fake()->sentence(),
        ]);
    }
}
