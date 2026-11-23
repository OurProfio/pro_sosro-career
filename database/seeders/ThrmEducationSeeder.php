<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ThrmEducationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan jenjang di bawah SMA/SMK (SD dan SMP) terhapus jika sebelumnya sudah pernah terisi.
        DB::table('thrm_education')
            ->whereIn('EDUTYPE_ID', [2, 3])
            ->orWhere('EDUTYPE_LEVEL', '<', 3)
            ->delete();

        $now = now();

        $defaults = [
            'EDUTYPE_NAME_EN' => null,
            'EDUTYPE_NAME_ID' => null,
            'EDUTYPE_NAME_CH' => null,
            'EDUTYPE_NAMETESTWORD' => null,
            'EDUTYPE_LEVEL' => null,
            'STATUS' => null,
            'EDUTYPE_NAME_DE' => null,
            'EDUTYPE_NAME_DWORD' => null,
            'EDUTYPE_NAME_EWORD' => null,
            'EDUTYPE_NAME_FWORD' => null,
            'EDUTYPE_NAME_GWORD' => null,
            'EDUTYPE_NAME_HWORD' => null,
            'EDUTYPE_NAME_SSWORD' => null,
            'EduType_Name_ThailandWord' => null,
            'EDUTYPE_NAME_TH' => null,
            'EDUTYPE_NAME_MY' => null,
            'EDUTYPE_NAME_VN' => null,
        ];

        $rows = [
            [
                'EDUTYPE_ID' => 4,
                'EDUTYPE_NAME_EN' => 'Senior High School',
                'EDUTYPE_NAME_ID' => 'SMA',
                'EDUTYPE_LEVEL' => 3,
                'STATUS' => 1,
                'EDUTYPE_NAME_TH' => 'Senior High School',
                'EDUTYPE_NAME_MY' => 'Senior High School',
                'EDUTYPE_NAME_VN' => 'Senior High School',
            ],
            [
                'EDUTYPE_ID' => 10,
                'EDUTYPE_NAME_EN' => 'vocational secondary schools',
                'EDUTYPE_NAME_ID' => 'STM',
                'EDUTYPE_LEVEL' => 3,
                'STATUS' => 1,
                'EDUTYPE_NAME_TH' => 'vocational secondary schools',
                'EDUTYPE_NAME_MY' => 'vocational secondary schools',
                'EDUTYPE_NAME_VN' => 'vocational secondary schools',
            ],
            [
                'EDUTYPE_ID' => 5,
                'EDUTYPE_NAME_EN' => 'Diploma',
                'EDUTYPE_NAME_ID' => 'Diploma',
                'EDUTYPE_LEVEL' => 5,
                'STATUS' => 1,
                'EDUTYPE_NAME_TH' => 'Diploma',
                'EDUTYPE_NAME_MY' => 'Diploma',
                'EDUTYPE_NAME_VN' => 'Diploma',
            ],
            [
                'EDUTYPE_ID' => 6,
                'EDUTYPE_NAME_EN' => 'Diploma Degre',
                'EDUTYPE_NAME_ID' => 'Diploma Degre',
                'EDUTYPE_LEVEL' => 6,
                'STATUS' => 1,
                'EDUTYPE_NAME_TH' => 'Diploma Degre',
                'EDUTYPE_NAME_MY' => 'Diploma Degre',
                'EDUTYPE_NAME_VN' => 'Diploma Degre',
            ],
            [
                'EDUTYPE_ID' => 7,
                'EDUTYPE_NAME_EN' => 'Bachelor Degree',
                'EDUTYPE_NAME_ID' => 'Sarjana',
                'EDUTYPE_LEVEL' => 7,
                'STATUS' => 1,
                'EDUTYPE_NAME_TH' => 'Bachelor Degree',
                'EDUTYPE_NAME_MY' => 'Bachelor Degree',
                'EDUTYPE_NAME_VN' => 'Bachelor Degree',
            ],
            [
                'EDUTYPE_ID' => 13,
                'EDUTYPE_NAME_EN' => 'College',
                'EDUTYPE_NAME_ID' => 'College',
                'EDUTYPE_LEVEL' => 7,
                'STATUS' => null,
                'EDUTYPE_NAME_TH' => 'College',
                'EDUTYPE_NAME_MY' => 'College',
                'EDUTYPE_NAME_VN' => 'College',
            ],
            [
                'EDUTYPE_ID' => 8,
                'EDUTYPE_NAME_EN' => 'Masters Degree',
                'EDUTYPE_NAME_ID' => 'Master/S2',
                'EDUTYPE_LEVEL' => 8,
                'STATUS' => 1,
                'EDUTYPE_NAME_TH' => 'Masters Degree',
                'EDUTYPE_NAME_MY' => 'Master/S2',
            ],
            [
                'EDUTYPE_ID' => 9,
                'EDUTYPE_NAME_EN' => 'Doctorate',
                'EDUTYPE_NAME_ID' => 'Doctor',
                'EDUTYPE_LEVEL' => 9,
                'STATUS' => 1,
                'EDUTYPE_NAME_TH' => 'Doctorate',
                'EDUTYPE_NAME_MY' => 'Doctor',
            ],
            [
                'EDUTYPE_ID' => 1,
                'EDUTYPE_NAME_EN' => 'Other',
                'EDUTYPE_NAME_ID' => 'Lain-lain',
                'EDUTYPE_LEVEL' => 10,
                'STATUS' => 1,
                'EDUTYPE_NAME_TH' => 'Other',
                'EDUTYPE_NAME_MY' => 'Other',
            ],
            [
                'EDUTYPE_ID' => 44,
                'EDUTYPE_NAME_EN' => 'Education',
                'EDUTYPE_NAME_ID' => 'Edukasi',
                'EDUTYPE_LEVEL' => 11,
                'STATUS' => null,
                'EDUTYPE_NAME_TH' => '??????????????',
                'EDUTYPE_NAME_MY' => 'Belajar',
            ],
        ];

        $payload = array_map(
            fn (array $row): array => array_merge($defaults, $row, [
                'created_at' => $now,
                'updated_at' => $now,
            ]),
            $rows
        );

        DB::table('thrm_education')->upsert(
            $payload,
            ['EDUTYPE_ID'],
            array_merge(array_keys($defaults), ['updated_at'])
        );
    }
}
