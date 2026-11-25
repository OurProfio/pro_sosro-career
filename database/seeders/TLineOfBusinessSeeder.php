<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TLineOfBusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        $rows = [
            ['LOB_ID' => 1, 'LOB_NAME' => 'Forwarding & Warehousing'],
            ['LOB_ID' => 2, 'LOB_NAME' => 'Terminal & Agency'],
            ['LOB_ID' => 4, 'LOB_NAME' => 'Finance & Administration'],
            ['LOB_ID' => 7, 'LOB_NAME' => 'HRD'],
            ['LOB_ID' => 8, 'LOB_NAME' => 'Transportation'],
            ['LOB_ID' => 9, 'LOB_NAME' => 'Manufacturing'],
            ['LOB_ID' => 10, 'LOB_NAME' => 'Travel'],
            ['LOB_ID' => 11, 'LOB_NAME' => 'IT Consultant'],
            ['LOB_ID' => 13, 'LOB_NAME' => 'Music'],
            ['LOB_ID' => 14, 'LOB_NAME' => 'Pharmacy'],
            ['LOB_ID' => 15, 'LOB_NAME' => 'Telecomunication'],
            ['LOB_ID' => 16, 'LOB_NAME' => 'Mining'],
            ['LOB_ID' => 17, 'LOB_NAME' => 'Creative Agency'],
            ['LOB_ID' => 18, 'LOB_NAME' => 'Media Telecomunication'],
            ['LOB_ID' => 19, 'LOB_NAME' => 'Games Developer'],
            ['LOB_ID' => 20, 'LOB_NAME' => 'Branding Consultant'],
            ['LOB_ID' => 21, 'LOB_NAME' => 'Movie Developer'],
            ['LOB_ID' => 22, 'LOB_NAME' => 'Production House'],
            ['LOB_ID' => 23, 'LOB_NAME' => 'Digital and Offset Printing'],
            ['LOB_ID' => 24, 'LOB_NAME' => 'Business Development'],
            ['LOB_ID' => 25, 'LOB_NAME' => 'Sales'],
            ['LOB_ID' => 26, 'LOB_NAME' => 'Institution'],
            ['LOB_ID' => 27, 'LOB_NAME' => 'Retail'],
            ['LOB_ID' => 28, 'LOB_NAME' => 'FMCG'],
        ];

        $payload = array_map(
            fn (array $row): array => array_merge($row, [
                'created_at' => $now,
                'updated_at' => $now,
            ]),
            $rows
        );

        DB::table('t_line_of_business')->upsert(
            $payload,
            ['LOB_ID'],
            ['LOB_NAME', 'updated_at']
        );
    }
}
