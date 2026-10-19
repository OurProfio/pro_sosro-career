<?php

namespace Database\Seeders;

use App\Models\Applicant;
use App\Models\Division;
use Illuminate\Database\Seeder;

class ApplicantInterestSeeder extends Seeder
{
    /**
     * Seed three prioritised division IDs for every applicant without interests.
     */
    public function run(): void
    {
        $divisionIds = Division::orderBy('id')->pluck('id');

        if ($divisionIds->count() < 3) {
            return;
        }

        Applicant::doesntHave('interest')->get()->each(function (Applicant $applicant, int $index) use ($divisionIds) {
            $applicant->interest()->create([
                'interests' => $divisionIds->shuffle()->take(3)->values()->all(),
            ]);
        });
    }
}
