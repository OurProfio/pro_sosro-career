<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImportPsikotesLinksRequest;
use App\Models\Job;
use App\Services\PsikotesLinkImporter;
use Illuminate\Http\RedirectResponse;

class PsikotesLinkController extends Controller
{
    public function import(ImportPsikotesLinksRequest $request, Job $job, PsikotesLinkImporter $importer): RedirectResponse
    {
        $result = $importer->import($job, $request->file('file'));

        return back()->with('info', "{$result['added']} link psikotes ditambahkan, {$result['skipped']} dilewati (duplikat/tidak valid).");
    }
}
