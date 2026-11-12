<?php

use App\Models\Admin;
use App\Models\Job;
use App\Models\Office;
use App\Models\PsikotesLink;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Writer\XLSX\Writer;

uses(RefreshDatabase::class);

const PSIKOTES_HEADER = ['No', 'Kode Aktivasi', 'Link Tes', 'Email', 'WhatsApp', 'Nama Peserta', 'Modul', 'Pembuat', 'Status Pengerjaan', 'Status Seleksi'];

/**
 * @param  array<int, array<int, mixed>>  $rows
 */
function psikotesXlsx(array $rows): UploadedFile
{
    $path = tempnam(sys_get_temp_dir(), 'psk').'.xlsx';

    $writer = new Writer;
    $writer->openToFile($path);
    foreach ($rows as $row) {
        $writer->addRow(Row::fromValues($row));
    }
    $writer->close();

    return new UploadedFile($path, 'KODE TES.xlsx', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', null, true);
}

beforeEach(function () {
    $this->officeA = Office::factory()->create(['name' => 'Kantor Cabang A']);
    $this->officeB = Office::factory()->create(['name' => 'Kantor Cabang B']);

    $this->adminA = Admin::factory()->create(['role' => 'admin', 'office_id' => $this->officeA->id])->user;
    $this->adminB = Admin::factory()->create(['role' => 'admin', 'office_id' => $this->officeB->id])->user;

    $this->job = Job::factory()->create(['office_id' => $this->officeA->id, 'category' => 'magang']);
});

it('imports links from the Link Tes column', function () {
    PsikotesLink::factory()->create(['link' => 'https://careeratsosro.com/?kode=EXIST00001']);

    $file = psikotesXlsx([
        PSIKOTES_HEADER,
        [1, 'A', 'https://careeratsosro.com/?kode=118067XQF0'],
        [2, 'B', 'https://careeratsosro.com/?kode=17SNSDEL8K'],
        [3, 'C', ''],
        [4, 'D', 'bukan-url'],
        [5, 'E', 'https://careeratsosro.com/?kode=EXIST00001'],
    ]);

    $this->actingAs($this->adminA)
        ->post(route('job.psikotesLinks.import', $this->job), ['file' => $file])
        ->assertRedirect()
        ->assertSessionHas('info', '2 link psikotes ditambahkan, 2 dilewati (duplikat/tidak valid).');

    expect($this->job->psikotesLinks()->pluck('link')->all())->toEqualCanonicalizing([
        'https://careeratsosro.com/?kode=118067XQF0',
        'https://careeratsosro.com/?kode=17SNSDEL8K',
    ]);
    expect($this->job->psikotesLinks()->whereNotNull('application_id')->count())->toBe(0);
});

it('matches the Link Tes header regardless of case and whitespace', function () {
    $file = psikotesXlsx([
        ['No', '  LINK TES '],
        [1, 'https://careeratsosro.com/?kode=CASE000001'],
    ]);

    $this->actingAs($this->adminA)
        ->post(route('job.psikotesLinks.import', $this->job), ['file' => $file])
        ->assertRedirect();

    expect($this->job->psikotesLinks()->count())->toBe(1);
});

it('skips every row when the same file is uploaded twice', function () {
    $rows = [
        PSIKOTES_HEADER,
        [1, 'A', 'https://careeratsosro.com/?kode=TWICE00001'],
        [2, 'B', 'https://careeratsosro.com/?kode=TWICE00002'],
    ];

    $this->actingAs($this->adminA)
        ->post(route('job.psikotesLinks.import', $this->job), ['file' => psikotesXlsx($rows)]);

    $this->actingAs($this->adminA)
        ->post(route('job.psikotesLinks.import', $this->job), ['file' => psikotesXlsx($rows)])
        ->assertSessionHas('info', '0 link psikotes ditambahkan, 2 dilewati (duplikat/tidak valid).');

    expect(PsikotesLink::count())->toBe(2);
});

it('rejects a file without the Link Tes column', function () {
    $file = psikotesXlsx([['No', 'Kode Aktivasi'], [1, 'A']]);

    $this->actingAs($this->adminA)
        ->post(route('job.psikotesLinks.import', $this->job), ['file' => $file])
        ->assertSessionHasErrorsIn('psikotesImport', ['file' => "Kolom 'Link Tes' tidak ditemukan di file."]);

    expect(PsikotesLink::count())->toBe(0);
});

it('rejects a non xlsx file', function () {
    $this->actingAs($this->adminA)
        ->post(route('job.psikotesLinks.import', $this->job), [
            'file' => UploadedFile::fake()->create('kode.csv', 10, 'text/csv'),
        ])
        ->assertSessionHasErrorsIn('psikotesImport', 'file');
});

it('forbids admins from another office', function () {
    $file = psikotesXlsx([PSIKOTES_HEADER]);

    $this->actingAs($this->adminB)
        ->post(route('job.psikotesLinks.import', $this->job), ['file' => $file])
        ->assertForbidden();
});
