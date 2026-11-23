<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ThrmReligionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        $defaults = [
            'RELIGION_NAME_EN' => null,
            'RELIGION_NAME_ID' => null,
            'RELIGION_NAME_CH' => null,
            'RELIGION_NAME_DE' => null,
            'RELIGION_ENABLED' => null,
            'RELIGION_NAME_BWORD' => null,
            'RELIGION_NAME_CCWORD' => null,
            'RELIGION_NAME_DWORD' => null,
            'RELIGION_NAME_EWORD' => null,
            'RELIGION_NAME_FWORD' => null,
            'RELIGION_NAME_GWORD' => null,
            'RELIGION_NAME_HWORD' => null,
            'RELIGION_NAME_SSWORD' => null,
            'Religion_Name_ThailandWord' => null,
            'RELIGION_NAME_TH' => null,
            'RELIGION_NAME_MY' => null,
            'RELIGION_NAME_VN' => null,
        ];

        $rows = [
            [
                'RELIGION_ID' => 'Budhist',
                'RELIGION_NAME_EN' => 'Budhist',
                'RELIGION_NAME_ID' => 'Budha',
                'RELIGION_NAME_TH' => 'Budhist',
                'RELIGION_NAME_MY' => 'Budhist',
            ],
            [
                'RELIGION_ID' => 'Catholic',
                'RELIGION_NAME_EN' => 'Catholic',
                'RELIGION_NAME_ID' => 'Katolik',
                'RELIGION_NAME_TH' => 'Catholic',
                'RELIGION_NAME_MY' => 'Catholic',
            ],
            [
                'RELIGION_ID' => 'Christian',
                'RELIGION_NAME_EN' => 'Christian',
                'RELIGION_NAME_ID' => 'Kristen',
                'RELIGION_NAME_TH' => 'Christian',
                'RELIGION_NAME_MY' => 'Christian',
            ],
            [
                'RELIGION_ID' => 'Hindu',
                'RELIGION_NAME_EN' => 'Hindu',
                'RELIGION_NAME_ID' => 'Hindu',
                'RELIGION_NAME_TH' => 'Hindu',
                'RELIGION_NAME_MY' => 'Hindu',
            ],
            [
                'RELIGION_ID' => 'Islam',
                'RELIGION_NAME_EN' => 'Moslem',
                'RELIGION_NAME_ID' => 'Islam',
                'RELIGION_NAME_TH' => 'Moslem',
                'RELIGION_NAME_MY' => 'Moslem',
            ],
            [
                'RELIGION_ID' => 'KHC',
                'RELIGION_NAME_EN' => 'Kong Hu Cu',
                'RELIGION_NAME_ID' => 'Kong Hu Cu',
            ],
            [
                'RELIGION_ID' => 'Oth',
                'RELIGION_NAME_EN' => 'Other',
                'RELIGION_NAME_ID' => 'Lainnya',
                'RELIGION_NAME_CH' => 'Other',
                'RELIGION_NAME_DE' => 'Other',
                'RELIGION_NAME_TH' => 'Other',
                'RELIGION_NAME_MY' => 'Other',
                'RELIGION_NAME_VN' => 'Other',
            ],
        ];

        $payload = array_map(
            fn (array $row): array => array_merge($defaults, $row, [
                'created_at' => $now,
                'updated_at' => $now,
            ]),
            $rows
        );

        DB::table('treligion')->upsert(
            $payload,
            ['RELIGION_ID'],
            array_merge(array_keys($defaults), ['updated_at'])
        );
    }
}
