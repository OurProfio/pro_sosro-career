<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApplicationRequest;
use App\Http\Requests\UpdateApplicationStageRequest;
use App\Http\Requests\UpdateApplicationStatusRequest;
use App\Models\Application;
use App\Models\Job;
use App\Services\ApplicationNotificationService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $applications = Application::with(['job.office'])
            ->where('applicant_id', auth()->user()->applicant->id ?? null)
            ->latest()
            ->get();

        return view('auth.applicant.applications', compact('applications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreApplicationRequest $request)
    {
        if (! auth()->user()->applicant) {
            return redirect()->route('biodata.index')->with('error', 'Anda harus melengkapi profil terlebih dahulu sebelum melamar pekerjaan.');
        }

        $job = Job::findOrFail($request->job_id);

        if ($job->closing_date && Carbon::parse($job->closing_date)->isPast() && ! Carbon::parse($job->closing_date)->isToday()) {
            if ($job->status === 'aktif') {
                $job->update(['status' => 'nonaktif']);
            }

            return redirect()->back()->with('error', 'Lowongan pekerjaan ini sudah ditutup (melewati batas tanggal).');
        }

        if ($job->status !== 'aktif') {
            return redirect()->back()->with('error', 'Lowongan pekerjaan ini sudah tidak aktif.');
        }

        if (Application::where('applicant_id', auth()->user()->applicant->id)->count() === 3) {
            return redirect()->back()->with('error', 'Anda sudah mencapai batas maksimal melamar pekerjaan (3 kali).');
        }

        Application::create([
            'applicant_id' => auth()->user()->applicant->id,
            'job_id' => $job->id,
        ]);

        return redirect()->route('applications.index')->with('success', 'Berhasil melamar pekerjaan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Application $application)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Application $application)
    {
        //
    }

    /**
     * Move the application to another stage and notify the applicant when the stage has an email.
     */
    public function updateStage(
        UpdateApplicationStageRequest $request,
        Application $application,
        ApplicationNotificationService $notificationService
    ): RedirectResponse {
        $stage = $request->selectedStage();

        $application->update([
            'stages_id' => $stage->id,
            'status' => 'progress',
        ]);

        $application->load(['stage', 'applicant', 'job.office']);

        $mailable = $notificationService->sendStageNotification($application, $request->validated());

        $message = "Stage lamaran berhasil diperbarui ke {$stage->name}.";
        if ($mailable) {
            $message .= ' Email notifikasi telah dikirim ke applicant.';
        }

        return redirect()->back()->with('info', $message);
    }

    /**
     * Accept or reject the application and notify the applicant.
     */
    public function updateStatus(
        UpdateApplicationStatusRequest $request,
        Application $application,
        ApplicationNotificationService $notificationService
    ): RedirectResponse {
        $application->update(['status' => $request->status]);

        $application->load(['stage', 'applicant', 'job.office']);

        $mailable = $notificationService->sendStatusNotification($application, $request->validated());

        $message = 'Status lamaran berhasil diperbarui.';
        if ($mailable) {
            $message .= ' Email notifikasi telah dikirim ke applicant.';
        }

        return redirect()->back()->with('info', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Application $application)
    {
        //
    }
}
