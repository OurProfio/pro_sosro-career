<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ThrmListSchoolSeeder extends Seeder
{
    public const OTHER_EDU_ID = 44;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rows = HrisMasterSeeder::readRevisionCsv('THRMLISTSCHOOL.csv');

        if ($rows === []) {
            $this->command?->warn('CSV file is empty or missing: public/revisi/THRMLISTSCHOOL.csv');

            return;
        }

        $now = now();
        $payload = [];
        $hasOther = false;

        foreach ($rows as $row) {
            $eduId = $row[2] ?? null;

            if ($eduId === null || ! is_numeric($eduId)) {
                continue;
            }

            $eduIdInt = (int) $eduId;

            if ($eduIdInt === self::OTHER_EDU_ID) {
                $hasOther = true;
            }

            $payload[] = [
                'EDU_ID' => $eduIdInt,
                'EDU_CODE' => $row[0] ?? null,
                'EDU_NAME' => $row[1] ?? null,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        if (! $hasOther) {
            $payload[] = [
                'EDU_ID' => self::OTHER_EDU_ID,
                'EDU_CODE' => 'I2611100354',
                'EDU_NAME' => 'Other',
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('thrm_list_school')->delete();

        foreach (array_chunk($payload, 500) as $chunk) {
            DB::table('thrm_list_school')->insert($chunk);
        }
    }
}
