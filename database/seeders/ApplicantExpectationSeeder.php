<?php

namespace Database\Seeders;

use App\Models\Applicant;
use Illuminate\Database\Seeder;

class ApplicantExpectationSeeder extends Seeder
{
    /**
     * Seed salary and placement expectations for every applicant without them.
     */
    public function run(): void
    {
        $sources = ['Career Page', 'Jobstreet', 'LinkedIn', 'Instagram Career', 'Referral'];

        Applicant::doesntHave('expectation')->get()->each(function (Applicant $applicant, int $index) use ($sources) {
            $jobSource = $sources[$index % count($sources)];

            $applicant->expectation()->create([
                'salary_expectation' => 5500000 + $index * 300000,
                'facility_expectation' => 'BPJS Kesehatan dan Ketenagakerjaan, tunjangan transportasi',
                'ready_to_relocate' => $index % 2 === 0,
                'ready_to_travel' => true,
                'job_source' => $jobSource,
                'reference_by' => $jobSource === 'Referral' ? 'Rina Marlina' : null,
            ]);
        });
    }
}
