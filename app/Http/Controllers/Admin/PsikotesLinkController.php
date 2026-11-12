<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImportPsikotesLinksRequest;
use App\Http\Requests\InvitePsikotesRequest;
use App\Models\Application;
use App\Models\Job;
use App\Services\ApplicationNotificationService;
use App\Services\PsikotesLinkImporter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class PsikotesLinkController extends Controller
{
    public function import(ImportPsikotesLinksRequest $request, Job $job, PsikotesLinkImporter $importer): RedirectResponse
    {
        $result = $importer->import($job, $request->file('file'));

        return back()->with('info', "{$result['added']} link psikotes ditambahkan, {$result['skipped']} dilewati (duplikat/tidak valid).");
    }

    public function invite(InvitePsikotesRequest $request, Job $job, ApplicationNotificationService $notificationService): RedirectResponse
    {
        $psikotesStage = $job->psikotesStage();
        $applicationIds = $request->validated('application_ids');
        $needed = count($applicationIds);

        $invited = DB::transaction(function () use ($job, $psikotesStage, $applicationIds, $needed) {
            $links = $job->psikotesLinks()->available()->orderBy('id')->limit($needed)->lockForUpdate()->get();

            if ($links->count() < $needed) {
                return $links->count();
            }

            $applications = Application::whereIn('id', $applicationIds)->orderBy('id')->get();

            foreach ($applications as $index => $application) {
                $links[$index]->update(['application_id' => $application->id, 'assigned_at' => now()]);
                $application->update(['stages_id' => $psikotesStage->id, 'status' => 'progress']);
            }

            return $applications;
        });

        if (is_int($invited)) {
            return back()->with('error', "Stok link psikotes tidak cukup: butuh {$needed}, tersedia {$invited}.");
        }

        $invited->load(['stage', 'psikotesLink', 'applicant.user', 'job.office']);

        foreach ($invited as $application) {
            $notificationService->sendStageNotification($application, [
                'psikotes_link' => $application->psikotesLink->link,
                'psikotes_date' => $request->validated('psikotes_date'),
                'psikotes_time' => $request->validated('psikotes_time'),
            ], queue: true);
        }

        return back()->with('info', "{$needed} pelamar diundang psikotes. Email undangan sedang dikirim.");
    }
}
