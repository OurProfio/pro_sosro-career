<?php

namespace Database\Factories;

use App\Models\Application;
use App\Models\Job;
use App\Models\PsikotesLink;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<PsikotesLink>
 */
class PsikotesLinkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'job_id' => Job::factory(),
            'link' => 'https://careeratsosro.com/?kode='.Str::upper(Str::random(10)),
            'application_id' => null,
        ];
    }

    public function assigned(?Application $application = null): static
    {
        return $this->state(fn (): array => [
            'application_id' => $application?->id ?? Application::factory(),
            'assigned_at' => now(),
        ]);
    }
}
