<?php

namespace Database\Seeders;

use App\Models\Applicant;
use Illuminate\Database\Seeder;

class ApplicantTrainingSeeder extends Seeder
{
    /**
     * Seed one training for every applicant without training data.
     */
    public function run(): void
    {
        $trainings = [
            ['Pelatihan Microsoft Excel Lanjutan', 'Kampus Digital'],
            ['Workshop Public Speaking', 'Himpunan Mahasiswa'],
            ['Sertifikasi K3 Dasar', 'Kemnaker RI'],
            ['Pelatihan Kepemimpinan', 'BEM Universitas'],
        ];

        Applicant::doesntHave('trainings')->get()->each(function (Applicant $applicant, int $index) use ($trainings) {
            [$name, $organizer] = $trainings[$index % count($trainings)];

            $applicant->trainings()->create([
                'training_name' => $name,
                'organizer' => $organizer,
                'finished' => now()->subMonths(6 + $index)->toDateString(),
            ]);
        });
    }
}
