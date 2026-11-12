<?php

namespace App\Services;

use App\Models\Job;
use App\Models\PsikotesLink;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\ValidationException;
use OpenSpout\Common\Exception\OpenSpoutException;
use OpenSpout\Reader\XLSX\Reader;

class PsikotesLinkImporter
{
    private const ERROR_BAG = 'psikotesImport';

    /**
     * Read the "Link Tes" column of the first sheet and store the new links as stock for the job.
     *
     * @return array{added: int, skipped: int}
     *
     * @throws ValidationException
     */
    public function import(Job $job, UploadedFile $file): array
    {
        $reader = new Reader;
        $skipped = 0;
        $validLinks = [];

        try {
            $reader->open($file->getRealPath());

            foreach ($reader->getSheetIterator() as $sheet) {
                $linkColumn = null;

                foreach ($sheet->getRowIterator() as $rowNumber => $row) {
                    $cells = $row->toArray();

                    if ($rowNumber === 1) {
                        $linkColumn = $this->findLinkColumn($cells);

                        if ($linkColumn === null) {
                            throw ValidationException::withMessages([
                                'file' => "Kolom 'Link Tes' tidak ditemukan di file.",
                            ])->errorBag(self::ERROR_BAG);
                        }

                        continue;
                    }

                    $value = trim((string) ($cells[$linkColumn] ?? ''));

                    if ($value === '') {
                        continue;
                    }

                    if (filter_var($value, FILTER_VALIDATE_URL) === false) {
                        $skipped++;

                        continue;
                    }

                    $validLinks[] = $value;
                }

                break;
            }
        } catch (OpenSpoutException) {
            throw ValidationException::withMessages([
                'file' => 'File tidak dapat dibaca.',
            ])->errorBag(self::ERROR_BAG);
        } finally {
            $reader->close();
        }

        $validLinks = array_values(array_unique($validLinks));
        $added = 0;
        $now = now();

        foreach (array_chunk($validLinks, 500) as $chunk) {
            $added += PsikotesLink::insertOrIgnore(array_map(fn (string $link): array => [
                'job_id' => $job->id,
                'link' => $link,
                'created_at' => $now,
                'updated_at' => $now,
            ], $chunk));
        }

        return ['added' => $added, 'skipped' => $skipped + count($validLinks) - $added];
    }

    /**
     * @param  array<int, mixed>  $headerCells
     */
    private function findLinkColumn(array $headerCells): ?int
    {
        foreach ($headerCells as $index => $header) {
            if (strtolower(trim((string) $header)) === 'link tes') {
                return $index;
            }
        }

        return null;
    }
}
