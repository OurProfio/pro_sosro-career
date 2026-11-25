<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class HrisMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            ThrmReligionSeeder::class,
            ThrmEducationSeeder::class,
            ThrmListFacultySeeder::class,
            ThrmListMajorSeeder::class,
            ThrmListSchoolSeeder::class,
            ThrmFamilyConnectionSeeder::class,
            TLineOfBusinessSeeder::class,
            ThrmPositionSeeder::class,
        ]);
    }

    /**
     * Read semicolon-delimited headerless CSV rows from database/seeders/data/.
     *
     * @return list<list<?string>>
     */
    public static function readRevisionCsv(string $filename): array
    {
        $filePath = database_path("seeders/data/{$filename}");

        if (! is_file($filePath)) {
            return [];
        }

        $handle = fopen($filePath, 'r');

        if ($handle === false) {
            return [];
        }

        $rows = [];
        $isFirstRow = true;

        try {
            while (($row = fgetcsv($handle, 0, ';', '"', '')) !== false) {
                if ($row === [null]) {
                    continue;
                }

                if ($isFirstRow && isset($row[0])) {
                    $row[0] = ltrim($row[0], "\xEF\xBB\xBF");
                    $isFirstRow = false;
                }

                $rows[] = array_map(static function (?string $cell): ?string {
                    $trimmed = trim((string) $cell);

                    if ($trimmed === '' || strcasecmp($trimmed, 'NULL') === 0) {
                        return null;
                    }

                    return $trimmed;
                }, $row);
            }
        } finally {
            fclose($handle);
        }

        return $rows;
    }
}
