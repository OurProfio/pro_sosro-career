<?php

namespace Database\Seeders;

use App\Models\Applicant;
use Illuminate\Database\Seeder;

class ApplicantFamilySeeder extends Seeder
{
    /**
     * Seed father, mother and one sibling for every applicant without family data.
     */
    public function run(): void
    {
        Applicant::doesntHave('families')->get()->each(function (Applicant $applicant, int $index) {
            $lastName = collect(explode(' ', $applicant->name))->last();
            $birthYear = (int) substr($applicant->date_of_birth, 0, 4);

            $applicant->families()->createMany([
                [
                    'relationship' => 'father',
                    'name' => 'Bambang '.$lastName,
                    'place_of_birth' => $applicant->place_of_birth,
                    'date_of_birth' => ($birthYear - 28).'-03-15',
                    'education' => 'SMA/SMK',
                    'phone_number' => '0811000'.str_pad((string) ($index + 1), 4, '0', STR_PAD_LEFT),
                    'work' => 'Wiraswasta',
                    'family_type' => 'biological',
                    'status' => 'alive',
                ],
                [
                    'relationship' => 'mother',
                    'name' => 'Sri '.$lastName,
                    'place_of_birth' => $applicant->place_of_birth,
                    'date_of_birth' => ($birthYear - 26).'-08-21',
                    'education' => 'SMA/SMK',
                    'phone_number' => '0812000'.str_pad((string) ($index + 1), 4, '0', STR_PAD_LEFT),
                    'work' => 'Ibu Rumah Tangga',
                    'family_type' => 'biological',
                    'status' => 'alive',
                ],
                [
                    'relationship' => 'sibling',
                    'name' => 'Adik '.$lastName,
                    'place_of_birth' => $applicant->place_of_birth,
                    'date_of_birth' => ($birthYear + 3).'-11-02',
                    'education' => 'D4/S1',
                    'phone_number' => '0813000'.str_pad((string) ($index + 1), 4, '0', STR_PAD_LEFT),
                    'work' => 'Mahasiswa',
                    'family_type' => 'biological',
                    'status' => 'alive',
                ],
            ]);
        });
    }
}
