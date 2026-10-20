<?php

namespace Database\Seeders;

use App\Models\Applicant;
use Illuminate\Database\Seeder;

class ApplicantWorkExprienceSeeder extends Seeder
{
    /**
     * Seed one past job for applicants without work experience (every third applicant stays a fresh graduate).
     */
    public function run(): void
    {
        $companies = ['PT Maju Bersama', 'PT Nusantara Jaya', 'CV Karya Mandiri', 'PT Sinar Abadi'];

        Applicant::doesntHave('workExperiences')->get()->each(function (Applicant $applicant, int $index) use ($companies) {
            if ($index % 3 === 2) {
                return;
            }

            $applicant->workExperiences()->create([
                'company_name' => $companies[$index % count($companies)],
                'company_address' => 'Jl. Industri Raya No. '.($index + 1).', Jakarta',
                'company_phone' => '021555'.str_pad((string) ($index + 1), 4, '0', STR_PAD_LEFT),
                'position' => 'Staff',
                'division' => 'Operasional',
                'salary' => 5000000 + $index * 250000,
                'start_date' => now()->subYears(2)->startOfMonth()->toDateString(),
                'end_date' => now()->subMonths(3)->startOfMonth()->toDateString(),
                'facility' => 'BPJS, Tunjangan Makan',
                'reason_for_leaving' => 'Mencari tantangan baru',
                'reference_name' => 'Hendra Kusuma',
                'reference_position' => 'Manager',
                'reference_phone' => '0815000'.str_pad((string) ($index + 1), 4, '0', STR_PAD_LEFT),
            ]);
        });
    }
}
