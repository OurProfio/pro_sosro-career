<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ThrmPositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rows = HrisMasterSeeder::readRevisionCsv('THRMPOSITION.csv');

        if ($rows === []) {
            $this->command?->warn('CSV file is empty or missing: database/seeders/data/THRMPOSITION.csv');

            return;
        }

        $now = now();
        $payload = [];

        foreach ($rows as $row) {
            $positionId = $row[0] ?? null;

            if ($positionId === null || ! is_numeric($positionId)) {
                continue;
            }

            $payload[] = [
                'POSITION_ID' => (int) $positionId,
                'POSITION_NAME_EN' => $row[1] ?? null,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        foreach (array_chunk($payload, 500) as $chunk) {
            DB::table('thrm_position')->upsert(
                $chunk,
                ['POSITION_ID'],
                ['POSITION_NAME_EN', 'updated_at']
            );
        }
    }
}
