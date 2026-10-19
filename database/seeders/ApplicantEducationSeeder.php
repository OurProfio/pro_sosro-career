<?php

namespace Database\Seeders;

use App\Models\Applicant;
use Illuminate\Database\Seeder;

class ApplicantEducationSeeder extends Seeder
{
    /**
     * Seed SMA/SMK and university education for every applicant without education data.
     */
    public function run(): void
    {
        $majors = ['Teknik Informatika', 'Manajemen', 'Akuntansi', 'Teknik Industri', 'Psikologi'];
        $universities = ['Universitas Indonesia', 'Institut Teknologi Bandung', 'Universitas Gadjah Mada', 'Universitas Diponegoro', 'Universitas Airlangga'];

        Applicant::doesntHave('educations')->get()->each(function (Applicant $applicant, int $index) use ($majors, $universities) {
            $graduationYear = (int) now()->subYears(1 + $index % 3)->format('Y');

            $applicant->educations()->createMany([
                [
                    'institution_name' => 'SMA Negeri '.(1 + $index).' '.$applicant->place_of_birth,
                    'degree_level' => 'SMA/SMK',
                    'major' => 'IPA',
                    'gpa' => 85.5 + $index % 10 / 10,
                    'entry_year' => $graduationYear - 7,
                    'graduation_year' => $graduationYear - 4,
                ],
                [
                    'institution_name' => $universities[$index % count($universities)],
                    'degree_level' => 'D4/S1',
                    'major' => $majors[$index % count($majors)],
                    'gpa' => 3.2 + $index % 8 / 10,
                    'entry_year' => $graduationYear - 4,
                    'graduation_year' => $graduationYear,
                ],
            ]);
        });
    }
}
