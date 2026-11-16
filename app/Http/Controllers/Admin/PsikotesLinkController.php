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

        $outcome = DB::transaction(function () use ($job, $psikotesStage, $applicationIds, $needed): array {
            $applications = Application::whereIn('id', $applicationIds)
                ->where('job_id', $job->id)
                ->with(['stage', 'psikotesLink'])
                ->orderBy('id')
                ->lockForUpdate()
                ->get();

            $hasIneligible = $applications->count() !== $needed
                || $applications->contains(fn (Application $application): bool => ! $application->canBeInvitedToPsikotes($psikotesStage));

            if ($hasIneligible) {
                return ['error' => 'Beberapa pelamar sudah diundang psikotes atau sudah melewati tahap tersebut.'];
            }

            $links = $job->psikotesLinks()->available()->orderBy('id')->limit($needed)->lockForUpdate()->get();

            if ($links->count() < $needed) {
                return ['error' => "Stok link psikotes tidak cukup: butuh {$needed}, tersedia {$links->count()}."];
            }

            foreach ($applications->values() as $index => $application) {
                $links[$index]->update(['application_id' => $application->id, 'assigned_at' => now()]);
                $application->update(['stages_id' => $psikotesStage->id, 'status' => 'progress']);
            }

            return ['applications' => $applications];
        });

        if (isset($outcome['error'])) {
            return back()->withErrors(['application_ids' => $outcome['error']], 'psikotesInvite');
        }

        $invited = $outcome['applications'];

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
