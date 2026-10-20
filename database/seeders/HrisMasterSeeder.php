<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use ZipArchive;

class HrisMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = public_path('assets/revisi/Table Database Website Recruitment.xlsx');

        if (! file_exists($filePath)) {
            $this->command?->warn("File not found: {$filePath}");

            return;
        }

        $zip = new ZipArchive;
        if ($zip->open($filePath) !== true) {
            $this->command?->error("Failed to open excel zip archive: {$filePath}");

            return;
        }

        $sharedStrings = $this->loadSharedStrings($zip);

        $this->seedReligion($zip, $sharedStrings);
        $this->seedEducation($zip, $sharedStrings);
        $this->seedMajor($zip, $sharedStrings);
        $this->seedSchool($zip, $sharedStrings);

        $zip->close();
    }

    /**
     * @return array<int, string>
     */
    private function loadSharedStrings(ZipArchive $zip): array
    {
        $sharedStrings = [];
        $xmlContent = $zip->getFromName('xl/sharedStrings.xml');

        if (! $xmlContent) {
            return $sharedStrings;
        }

        $xml = simplexml_load_string($xmlContent);
        if (! $xml) {
            return $sharedStrings;
        }

        foreach ($xml->si as $si) {
            if (isset($si->t)) {
                $sharedStrings[] = (string) $si->t;
            } elseif (isset($si->r)) {
                $text = '';
                foreach ($si->r as $r) {
                    $text .= (string) $r->t;
                }
                $sharedStrings[] = $text;
            } else {
                $sharedStrings[] = '';
            }
        }

        return $sharedStrings;
    }

    /**
     * @param  array<int, string>  $sharedStrings
     * @return array<int, array<string, mixed>>
     */
    private function parseSheetRows(ZipArchive $zip, string $path, array $sharedStrings): array
    {
        $xmlContent = $zip->getFromName($path);
        if (! $xmlContent) {
            return [];
        }

        $xml = simplexml_load_string($xmlContent);
        if (! $xml || ! isset($xml->sheetData->row)) {
            return [];
        }

        $headers = [];
        $data = [];
        $rowIdx = 0;

        foreach ($xml->sheetData->row as $r) {
            $rowArr = [];
            foreach ($r->c as $c) {
                $colRef = preg_replace('/[0-9]/', '', (string) $c['r']);
                $type = (string) $c['t'];
                $val = (string) $c->v;

                if ($type === 's' && isset($sharedStrings[(int) $val])) {
                    $val = $sharedStrings[(int) $val];
                }

                $rowArr[$colRef] = $val;
            }

            if ($rowIdx === 0) {
                $headers = $rowArr;
            } else {
                $row = [];
                foreach ($headers as $col => $name) {
                    $val = $rowArr[$col] ?? null;
                    if ($val === '(null)' || $val === '') {
                        $val = null;
                    }
                    $row[$name] = $val;
                }
                $data[] = $row;
            }
            $rowIdx++;
        }

        return $data;
    }

    /**
     * @param  array<int, string>  $sharedStrings
     */
    private function seedReligion(ZipArchive $zip, array $sharedStrings): void
    {
        $rows = $this->parseSheetRows($zip, 'xl/worksheets/sheet1.xml', $sharedStrings);
        $now = now();
        $payload = [];

        foreach ($rows as $row) {
            if (empty($row['RELIGION_ID'])) {
                continue;
            }

            $payload[] = [
                'RELIGION_ID' => $row['RELIGION_ID'],
                'RELIGION_NAME_EN' => $row['RELIGION_NAME_EN'] ?? null,
                'RELIGION_NAME_ID' => $row['RELIGION_NAME_ID'] ?? null,
                'RELIGION_NAME_CH' => $row['RELIGION_NAME_CH'] ?? null,
                'RELIGION_NAME_DE' => $row['RELIGION_NAME_DE'] ?? null,
                'RELIGION_ENABLED' => isset($row['RELIGION_ENABLED']) && is_numeric($row['RELIGION_ENABLED']) ? (int) $row['RELIGION_ENABLED'] : null,
                'RELIGION_NAME_BWORD' => $row['RELIGION_NAME_BWORD'] ?? null,
                'RELIGION_NAME_CCWORD' => $row['RELIGION_NAME_CCWORD'] ?? null,
                'RELIGION_NAME_DWORD' => $row['RELIGION_NAME_DWORD'] ?? null,
                'RELIGION_NAME_EWORD' => $row['RELIGION_NAME_EWORD'] ?? null,
                'RELIGION_NAME_FWORD' => $row['RELIGION_NAME_FWORD'] ?? null,
                'RELIGION_NAME_GWORD' => $row['RELIGION_NAME_GWORD'] ?? null,
                'RELIGION_NAME_HWORD' => $row['RELIGION_NAME_HWORD'] ?? null,
                'RELIGION_NAME_SSWORD' => $row['RELIGION_NAME_SSWORD'] ?? null,
                'Religion_Name_ThailandWord' => $row['Religion_Name_ThailandWord'] ?? null,
                'RELIGION_NAME_TH' => $row['RELIGION_NAME_TH'] ?? null,
                'RELIGION_NAME_MY' => $row['RELIGION_NAME_MY'] ?? null,
                'RELIGION_NAME_VN' => $row['RELIGION_NAME_VN'] ?? null,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        if (! empty($payload)) {
            DB::table('treligion')->upsert(
                $payload,
                ['RELIGION_ID'],
                [
                    'RELIGION_NAME_EN', 'RELIGION_NAME_ID', 'RELIGION_NAME_CH', 'RELIGION_NAME_DE',
                    'RELIGION_ENABLED', 'RELIGION_NAME_BWORD', 'RELIGION_NAME_CCWORD', 'RELIGION_NAME_DWORD',
                    'RELIGION_NAME_EWORD', 'RELIGION_NAME_FWORD', 'RELIGION_NAME_GWORD', 'RELIGION_NAME_HWORD',
                    'RELIGION_NAME_SSWORD', 'Religion_Name_ThailandWord', 'RELIGION_NAME_TH', 'RELIGION_NAME_MY',
                    'RELIGION_NAME_VN', 'updated_at',
                ]
            );
        }
    }

    /**
     * @param  array<int, string>  $sharedStrings
     */
    private function seedEducation(ZipArchive $zip, array $sharedStrings): void
    {
        $rows = $this->parseSheetRows($zip, 'xl/worksheets/sheet4.xml', $sharedStrings);
        $now = now();
        $payload = [];

        foreach ($rows as $row) {
            if (! isset($row['EDUTYPE_ID']) || $row['EDUTYPE_ID'] === '') {
                continue;
            }

            $payload[] = [
                'EDUTYPE_ID' => (int) $row['EDUTYPE_ID'],
                'EDUTYPE_NAME_EN' => $row['EDUTYPE_NAME_EN'] ?? null,
                'EDUTYPE_NAME_ID' => $row['EDUTYPE_NAME_ID'] ?? null,
                'EDUTYPE_NAME_CH' => $row['EDUTYPE_NAME_CH'] ?? null,
                'EDUTYPE_NAMETESTWORD' => $row['EDUTYPE_NAMETESTWORD'] ?? null,
                'EDUTYPE_LEVEL' => isset($row['EDUTYPE_LEVEL']) && is_numeric($row['EDUTYPE_LEVEL']) ? (int) $row['EDUTYPE_LEVEL'] : null,
                'STATUS' => isset($row['STATUS']) && is_numeric($row['STATUS']) ? (int) $row['STATUS'] : null,
                'EDUTYPE_NAME_DE' => $row['EDUTYPE_NAME_DE'] ?? null,
                'EDUTYPE_NAME_DWORD' => $row['EDUTYPE_NAME_DWORD'] ?? null,
                'EDUTYPE_NAME_EWORD' => $row['EDUTYPE_NAME_EWORD'] ?? null,
                'EDUTYPE_NAME_FWORD' => $row['EDUTYPE_NAME_FWORD'] ?? null,
                'EDUTYPE_NAME_GWORD' => $row['EDUTYPE_NAME_GWORD'] ?? null,
                'EDUTYPE_NAME_HWORD' => $row['EDUTYPE_NAME_HWORD'] ?? null,
                'EDUTYPE_NAME_SSWORD' => $row['EDUTYPE_NAME_SSWORD'] ?? null,
                'EduType_Name_ThailandWord' => $row['EduType_Name_ThailandWord'] ?? null,
                'EDUTYPE_NAME_TH' => $row['EDUTYPE_NAME_TH'] ?? null,
                'EDUTYPE_NAME_MY' => $row['EDUTYPE_NAME_MY'] ?? null,
                'EDUTYPE_NAME_VN' => $row['EDUTYPE_NAME_VN'] ?? null,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        if (! empty($payload)) {
            DB::table('thrm_education')->upsert(
                $payload,
                ['EDUTYPE_ID'],
                [
                    'EDUTYPE_NAME_EN', 'EDUTYPE_NAME_ID', 'EDUTYPE_NAME_CH', 'EDUTYPE_NAMETESTWORD',
                    'EDUTYPE_LEVEL', 'STATUS', 'EDUTYPE_NAME_DE', 'EDUTYPE_NAME_DWORD', 'EDUTYPE_NAME_EWORD',
                    'EDUTYPE_NAME_FWORD', 'EDUTYPE_NAME_GWORD', 'EDUTYPE_NAME_HWORD', 'EDUTYPE_NAME_SSWORD',
                    'EduType_Name_ThailandWord', 'EDUTYPE_NAME_TH', 'EDUTYPE_NAME_MY', 'EDUTYPE_NAME_VN',
                    'updated_at',
                ]
            );
        }
    }

    /**
     * @param  array<int, string>  $sharedStrings
     */
    private function seedMajor(ZipArchive $zip, array $sharedStrings): void
    {
        $rows = $this->parseSheetRows($zip, 'xl/worksheets/sheet3.xml', $sharedStrings);
        $now = now();
        $payload = [];

        foreach ($rows as $row) {
            $payload[] = [
                'MAJOR_ID' => isset($row['MAJOR_ID']) && is_numeric($row['MAJOR_ID']) ? (int) $row['MAJOR_ID'] : null,
                'MAJOR_CODE' => $row['MAJOR_CODE'] ?? null,
                'MAJOR_NAME' => $row['MAJOR_NAME'] ?? null,
                'MAJOR_NAME_EN' => $row['MAJOR_NAME_EN'] ?? null,
                'MAJOR_NAME_ID' => $row['MAJOR_NAME_ID'] ?? null,
                'MAJOR_NAME_TH' => $row['MAJOR_NAME_TH'] ?? null,
                'MAJOR_NAME_MY' => $row['MAJOR_NAME_MY'] ?? null,
                'MAJOR_NAME_VN' => $row['MAJOR_NAME_VN'] ?? null,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('thrm_list_major')->truncate();
        foreach (array_chunk($payload, 100) as $chunk) {
            DB::table('thrm_list_major')->insert($chunk);
        }
    }

    /**
     * @param  array<int, string>  $sharedStrings
     */
    private function seedSchool(ZipArchive $zip, array $sharedStrings): void
    {
        $rows = $this->parseSheetRows($zip, 'xl/worksheets/sheet2.xml', $sharedStrings);
        $now = now();
        $payload = [];

        foreach ($rows as $row) {
            if (! isset($row['EDU_ID']) || $row['EDU_ID'] === '') {
                continue;
            }

            $payload[] = [
                'EDU_ID' => (int) $row['EDU_ID'],
                'EDU_CODE' => $row['EDU_CODE'] ?? null,
                'EDU_NAME' => $row['EDU_NAME'] ?? null,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        foreach (array_chunk($payload, 500) as $chunk) {
            DB::table('thrm_list_school')->upsert(
                $chunk,
                ['EDU_ID'],
                ['EDU_CODE', 'EDU_NAME', 'updated_at']
            );
        }
    }
}
