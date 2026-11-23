<?php

namespace Database\Factories;

use App\Models\ContactMessage;
use App\Models\Office;
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
            'assigned_office_id' => null,
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'region' => fake()->randomElement(ContactMessage::REGIONS),
            'message' => fake()->paragraph(),
            'status' => 'unread',
            'ip_address' => fake()->ipv4(),
            'user_agent' => fake()->userAgent(),
            'reply_message' => null,
            'assigned_at' => null,
            'resolved_at' => null,
        ];
    }

    public function assignedTo(Office $office): static
    {
        return $this->state(fn (array $attributes): array => [
            'assigned_office_id' => $office->id,
            'assigned_at' => now(),
        ]);
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
            'reply_message' => fake()->sentence(),
            'resolved_at' => now(),
        ]);
    }
}
