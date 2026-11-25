<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ThrmListMajorSeeder extends Seeder
{
    public const OTHER_MAJOR_ID = 15;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rows = HrisMasterSeeder::readRevisionCsv('THRMLISTMAJOR.csv');

        if ($rows === []) {
            $this->command?->warn('CSV file is empty or missing: database/seeders/data/THRMLISTMAJOR.csv');

            return;
        }

        $now = now();
        $payload = [];
        $hasOther = false;

        foreach ($rows as $row) {
            $majorName = $row[1] ?? null;

            if ($majorName === null) {
                continue;
            }

            $majorId = isset($row[2]) && is_numeric($row[2]) ? (int) $row[2] : null;

            if ($majorId === self::OTHER_MAJOR_ID) {
                $hasOther = true;
            }

            $payload[] = [
                'MAJOR_CODE' => $row[0] ?? null,
                'MAJOR_NAME' => $majorName,
                'MAJOR_ID' => $majorId,
                'MAJOR_NAME_EN' => $row[3] ?? null,
                'MAJOR_NAME_ID' => $row[4] ?? null,
                'MAJOR_NAME_TH' => $row[5] ?? null,
                'MAJOR_NAME_MY' => $row[6] ?? null,
                'MAJOR_NAME_VN' => $row[7] ?? null,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        if (! $hasOther) {
            $payload[] = [
                'MAJOR_CODE' => 'MJR2611100354',
                'MAJOR_NAME' => 'Other',
                'MAJOR_ID' => self::OTHER_MAJOR_ID,
                'MAJOR_NAME_EN' => null,
                'MAJOR_NAME_ID' => null,
                'MAJOR_NAME_TH' => null,
                'MAJOR_NAME_MY' => null,
                'MAJOR_NAME_VN' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('thrm_list_major')->delete();

        foreach (array_chunk($payload, 500) as $chunk) {
            DB::table('thrm_list_major')->insert($chunk);
        }
    }
}
