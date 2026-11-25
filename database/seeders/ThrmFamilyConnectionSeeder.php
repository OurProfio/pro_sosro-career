<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ThrmFamilyConnectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        $defaults = [
            'RELATIONSHIP_CODE' => null,
            'FAMILY_RELATIONSHIP_EN' => null,
            'FAMILY_RELATIONSHIP_ID' => null,
            'FAMILY_RELATIONSHIP_CH' => null,
            'FAMILY_RELATIONSHIPTESTWORD' => null,
            'FAMILY_RELATIONSHIP_DE' => null,
            'ISREQUIRED' => null,
            'AGE' => null,
            'FAMILY_RELATIONSHIP_DWORD' => null,
            'FAMILY_RELATIONSHIP_EWORD' => null,
            'FAMILY_RELATIONSHIP_FWORD' => null,
            'FAMILY_RELATIONSHIP_GWORD' => null,
            'FAMILY_RELATIONSHIP_HWORD' => null,
            'FAMILY_RELATIONSHIP_SSWORD' => null,
            'FAMILY_RELATIONSHIP_TH' => null,
            'FAMILY_RELATIONSHIP_MY' => null,
            'FAMILY_RELATIONSHIP_VN' => null,
        ];

        $rows = [
            [
                'RELATIONSHIP_ID' => 1,
                'RELATIONSHIP_CODE' => 'FATHER',
                'FAMILY_RELATIONSHIP_EN' => 'Father',
                'FAMILY_RELATIONSHIP_ID' => 'Ayah',
                'ISREQUIRED' => 'Y',
                'FAMILY_RELATIONSHIP_TH' => 'Father',
                'FAMILY_RELATIONSHIP_MY' => 'Father',
            ],
            [
                'RELATIONSHIP_ID' => 2,
                'RELATIONSHIP_CODE' => 'MOTHER',
                'FAMILY_RELATIONSHIP_EN' => 'Mother',
                'FAMILY_RELATIONSHIP_ID' => 'Ibu',
                'ISREQUIRED' => 'Y',
                'FAMILY_RELATIONSHIP_TH' => 'Mother',
                'FAMILY_RELATIONSHIP_MY' => 'Mother',
            ],
            [
                'RELATIONSHIP_ID' => 3,
                'RELATIONSHIP_CODE' => 'CHILD',
                'FAMILY_RELATIONSHIP_EN' => 'Son',
                'FAMILY_RELATIONSHIP_ID' => 'Anak Laki-laki',
                'ISREQUIRED' => 'Y',
                'AGE' => 30,
                'FAMILY_RELATIONSHIP_TH' => 'Son',
                'FAMILY_RELATIONSHIP_MY' => 'Son',
            ],
            [
                'RELATIONSHIP_ID' => 4,
                'RELATIONSHIP_CODE' => 'CHILD',
                'FAMILY_RELATIONSHIP_EN' => 'Daughter',
                'FAMILY_RELATIONSHIP_ID' => 'Anak Perempuan',
                'ISREQUIRED' => 'Y',
                'AGE' => 30,
                'FAMILY_RELATIONSHIP_TH' => 'Daughter',
                'FAMILY_RELATIONSHIP_MY' => 'Daughter',
            ],
            [
                'RELATIONSHIP_ID' => 5,
                'RELATIONSHIP_CODE' => 'NONE',
                'FAMILY_RELATIONSHIP_EN' => 'Brother',
                'FAMILY_RELATIONSHIP_ID' => 'Kakak/Adik Laki-laki',
                'ISREQUIRED' => 'N',
                'AGE' => 12,
                'FAMILY_RELATIONSHIP_TH' => 'Brother',
                'FAMILY_RELATIONSHIP_MY' => 'Brother',
            ],
            [
                'RELATIONSHIP_ID' => 6,
                'RELATIONSHIP_CODE' => 'NONE',
                'FAMILY_RELATIONSHIP_EN' => 'Sister',
                'FAMILY_RELATIONSHIP_ID' => 'Kakak/Adik Perempuan',
                'ISREQUIRED' => 'N',
                'FAMILY_RELATIONSHIP_TH' => 'Sister',
                'FAMILY_RELATIONSHIP_MY' => 'Sister',
            ],
            [
                'RELATIONSHIP_ID' => 7,
                'RELATIONSHIP_CODE' => 'NONE',
                'FAMILY_RELATIONSHIP_EN' => 'Grand Mother',
                'FAMILY_RELATIONSHIP_ID' => 'Nenek',
                'ISREQUIRED' => 'N',
                'FAMILY_RELATIONSHIP_TH' => 'Grand Mother',
                'FAMILY_RELATIONSHIP_MY' => 'Grand Mother',
            ],
            [
                'RELATIONSHIP_ID' => 8,
                'RELATIONSHIP_CODE' => 'SPOUSE',
                'FAMILY_RELATIONSHIP_EN' => 'Spouse',
                'FAMILY_RELATIONSHIP_ID' => 'Suami/Istri',
                'ISREQUIRED' => 'Y',
                'FAMILY_RELATIONSHIP_TH' => 'Spouse',
                'FAMILY_RELATIONSHIP_MY' => 'Spouse',
            ],
            [
                'RELATIONSHIP_ID' => 9,
                'RELATIONSHIP_CODE' => 'NONE',
                'FAMILY_RELATIONSHIP_EN' => 'Grand Father',
                'FAMILY_RELATIONSHIP_ID' => 'Grand Father',
                'ISREQUIRED' => 'N',
                'FAMILY_RELATIONSHIP_TH' => 'Grand Father',
                'FAMILY_RELATIONSHIP_MY' => 'Grand Father',
                'FAMILY_RELATIONSHIP_VN' => 'Grand Father',
            ],
            [
                'RELATIONSHIP_ID' => 10,
                'RELATIONSHIP_CODE' => 'NONE',
                'FAMILY_RELATIONSHIP_EN' => 'Great Grand Parent',
                'FAMILY_RELATIONSHIP_ID' => 'Buyut',
                'ISREQUIRED' => 'N',
                'FAMILY_RELATIONSHIP_TH' => 'Great Grand Parent',
                'FAMILY_RELATIONSHIP_MY' => 'Great Grand Parent',
            ],
            [
                'RELATIONSHIP_ID' => 11,
                'RELATIONSHIP_CODE' => 'NONE',
                'FAMILY_RELATIONSHIP_EN' => 'Father in Law',
                'FAMILY_RELATIONSHIP_ID' => 'Mertua Laki-laki',
                'ISREQUIRED' => 'N',
                'FAMILY_RELATIONSHIP_TH' => 'Father in Law',
                'FAMILY_RELATIONSHIP_MY' => 'Father in Law',
            ],
            [
                'RELATIONSHIP_ID' => 12,
                'RELATIONSHIP_CODE' => 'NONE',
                'FAMILY_RELATIONSHIP_EN' => 'Mother in Law',
                'FAMILY_RELATIONSHIP_ID' => 'Mertua Perempuan',
                'ISREQUIRED' => 'N',
                'FAMILY_RELATIONSHIP_TH' => 'Mother in Law',
                'FAMILY_RELATIONSHIP_MY' => 'Mother in Law',
            ],
            [
                'RELATIONSHIP_ID' => 13,
                'RELATIONSHIP_CODE' => 'NONE',
                'FAMILY_RELATIONSHIP_EN' => 'Uncle',
                'FAMILY_RELATIONSHIP_ID' => 'Paman',
                'ISREQUIRED' => 'N',
                'FAMILY_RELATIONSHIP_TH' => 'Uncle',
                'FAMILY_RELATIONSHIP_MY' => 'Uncle',
            ],
            [
                'RELATIONSHIP_ID' => 14,
                'RELATIONSHIP_CODE' => 'NONE',
                'FAMILY_RELATIONSHIP_EN' => 'Brother in Law',
                'FAMILY_RELATIONSHIP_ID' => 'Saudara Ipar',
                'ISREQUIRED' => 'N',
                'FAMILY_RELATIONSHIP_TH' => 'Brother in Law',
                'FAMILY_RELATIONSHIP_MY' => 'Brother in Law',
                'FAMILY_RELATIONSHIP_VN' => 'Brother in Law',
            ],
            [
                'RELATIONSHIP_ID' => 15,
                'RELATIONSHIP_CODE' => 'NONE',
                'FAMILY_RELATIONSHIP_EN' => 'Other',
                'FAMILY_RELATIONSHIP_ID' => 'Lainnya',
                'ISREQUIRED' => 'N',
                'FAMILY_RELATIONSHIP_TH' => 'Other',
                'FAMILY_RELATIONSHIP_MY' => 'Other',
                'FAMILY_RELATIONSHIP_VN' => 'Other',
            ],
            [
                'RELATIONSHIP_ID' => 16,
                'RELATIONSHIP_CODE' => 'NONE',
                'FAMILY_RELATIONSHIP_EN' => 'Aunt',
                'FAMILY_RELATIONSHIP_ID' => 'Bibi',
                'ISREQUIRED' => 'N',
                'FAMILY_RELATIONSHIP_TH' => 'Aunt',
                'FAMILY_RELATIONSHIP_MY' => 'Aunt',
            ],
            [
                'RELATIONSHIP_ID' => 18,
                'RELATIONSHIP_CODE' => 'NONE',
                'FAMILY_RELATIONSHIP_EN' => 'Sister in law',
                'FAMILY_RELATIONSHIP_ID' => 'Saudara ipar',
                'ISREQUIRED' => 'N',
                'FAMILY_RELATIONSHIP_TH' => 'Sister in law',
                'FAMILY_RELATIONSHIP_MY' => 'Sister in law',
            ],
            [
                'RELATIONSHIP_ID' => 39,
                'RELATIONSHIP_CODE' => 'SPOUSE',
                'FAMILY_RELATIONSHIP_EN' => 'Wife',
                'FAMILY_RELATIONSHIP_ID' => 'Wife',
                'ISREQUIRED' => 'Y',
                'AGE' => 0,
                'FAMILY_RELATIONSHIP_TH' => 'Wife',
                'FAMILY_RELATIONSHIP_MY' => 'Wife',
                'FAMILY_RELATIONSHIP_VN' => 'Wife',
            ],
            [
                'RELATIONSHIP_ID' => 40,
                'RELATIONSHIP_CODE' => 'NONE',
                'FAMILY_RELATIONSHIP_EN' => 'Sister in Law',
                'FAMILY_RELATIONSHIP_ID' => 'Sister in Law',
                'ISREQUIRED' => 'N',
                'AGE' => 0,
                'FAMILY_RELATIONSHIP_TH' => 'Sister in Law',
                'FAMILY_RELATIONSHIP_MY' => 'Sister in Law',
                'FAMILY_RELATIONSHIP_VN' => 'Sister in Law',
            ],
            [
                'RELATIONSHIP_ID' => 41,
                'RELATIONSHIP_CODE' => 'SPOUSE',
                'FAMILY_RELATIONSHIP_EN' => 'Husband',
                'FAMILY_RELATIONSHIP_ID' => 'Suami',
                'ISREQUIRED' => 'Y',
                'AGE' => 0,
            ],
            [
                'RELATIONSHIP_ID' => 42,
                'RELATIONSHIP_CODE' => 'NONE',
                'FAMILY_RELATIONSHIP_EN' => 'SIBLING',
                'FAMILY_RELATIONSHIP_ID' => 'SIBLING',
                'ISREQUIRED' => 'N',
                'AGE' => 0,
            ],
        ];

        $payload = array_map(
            fn (array $row): array => array_merge($defaults, $row, [
                'created_at' => $now,
                'updated_at' => $now,
            ]),
            $rows
        );

        DB::table('thrm_family_connection')->upsert(
            $payload,
            ['RELATIONSHIP_ID'],
            array_merge(array_keys($defaults), ['updated_at'])
        );
    }
}
