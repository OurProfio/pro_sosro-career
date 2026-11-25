<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ThrmListFacultySeeder extends Seeder
{
    public const OTHER_FACULTY_ID = 278;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rows = HrisMasterSeeder::readRevisionCsv('THRMLISTFACULTY.csv');

        if ($rows === []) {
            $this->command?->warn('CSV file is empty or missing: database/seeders/data/THRMLISTFACULTY.csv');

            return;
        }

        $now = now();
        $payload = [];
        $hasOther = false;

        foreach ($rows as $row) {
            $facultyId = $row[2] ?? null;

            if ($facultyId === null || ! is_numeric($facultyId)) {
                continue;
            }

            $facultyIdInt = (int) $facultyId;

            if ($facultyIdInt === self::OTHER_FACULTY_ID) {
                $hasOther = true;
            }

            $payload[] = [
                'FACULTY_ID' => $facultyIdInt,
                'FACULTY_CODE' => $row[0] ?? null,
                'FACULTY_NAME' => $row[1] ?? null,
                'FACULTY_NAME_EN' => $row[3] ?? null,
                'FACULTY_NAME_ID' => $row[4] ?? null,
                'FACULTY_NAME_TH' => $row[5] ?? null,
                'FACULTY_NAME_MY' => $row[6] ?? null,
                'FACULTY_NAME_VN' => $row[7] ?? null,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        if (! $hasOther) {
            $payload[] = [
                'FACULTY_ID' => self::OTHER_FACULTY_ID,
                'FACULTY_CODE' => 'OTHERS',
                'FACULTY_NAME' => 'Others',
                'FACULTY_NAME_EN' => null,
                'FACULTY_NAME_ID' => null,
                'FACULTY_NAME_TH' => null,
                'FACULTY_NAME_MY' => null,
                'FACULTY_NAME_VN' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('thrm_list_faculty')->delete();

        foreach (array_chunk($payload, 500) as $chunk) {
            DB::table('thrm_list_faculty')->insert($chunk);
        }
    }
}
