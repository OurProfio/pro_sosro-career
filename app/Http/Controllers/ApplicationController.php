<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApplicationRequest;
use App\Http\Requests\UpdateApplicationStageRequest;
use App\Http\Requests\UpdateApplicationStatusRequest;
use App\Mail\UserConfirmationMail;
use App\Models\Application;
use App\Models\Job;
use App\Services\ApplicationNotificationService;
use App\Services\HrisTransferService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

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
            return redirect()->route('biodata.create')->with('warning', 'Silakan lengkapi biodata Anda terlebih dahulu sebelum melamar pekerjaan.');
        }

        if (! auth()->user()->applicant->isProfileComplete()) {
            return redirect()->route('biodata.index')->with('warning', 'Silakan lengkapi seluruh tahapan biodata Anda terlebih dahulu sebelum melamar pekerjaan.');
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

        $existingApplication = Application::where('applicant_id', auth()->user()->applicant->id)
            ->where('job_id', $job->id)
            ->first();

        if ($existingApplication) {
            if ($existingApplication->status === 'rejected') {
                return redirect()->back()->with('error', 'Anda sebelumnya telah melamar posisi ini dan tidak terpilih.');
            }

            if ($existingApplication->status === 'cancelled') {
                return redirect()->back()->with('error', 'Anda sebelumnya telah membatalkan lamaran untuk posisi ini.');
            }

            return redirect()->back()->with('error', 'Anda sudah melamar posisi pekerjaan ini.');
        }

        $activeApplicationsCount = Application::where('applicant_id', auth()->user()->applicant->id)
            ->whereNotIn('status', ['rejected', 'cancelled'])
            ->count();

        if ($activeApplicationsCount >= 3) {
            return redirect()->back()->with('error', 'Anda sudah mencapai batas maksimal 3 lamaran aktif yang sedang berjalan.');
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
            ...$request->has('notes') ? ['notes' => $request->validated('notes')] : [],
        ]);

        $application->load(['stage', 'applicant', 'job.office']);

        $mailable = $notificationService->sendStageNotification($application, $request->validated());

        $message = "Stage lamaran berhasil diperbarui ke {$stage->name}.";
        if ($mailable instanceof UserConfirmationMail) {
            $message .= ' Email konfirmasi telah dikirim ke user.';
        } elseif ($mailable) {
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
        ApplicationNotificationService $notificationService,
        HrisTransferService $hrisTransferService
    ): RedirectResponse {
        $validatedData = $request->validated();
        $newStatus = $validatedData['status'] ?? $request->status;
        $mailable = null;

        DB::transaction(function () use ($application, $newStatus, $validatedData, $notificationService, $hrisTransferService, &$mailable) {
            if ($newStatus === 'accepted') {
                $hrisTransferService->transferAcceptedApplicant($application, $validatedData);
            }

            $application->update(['status' => $newStatus]);

            $application->load(['stage', 'applicant', 'job.office']);

            $mailable = $notificationService->sendStatusNotification($application, $validatedData);
        });

        $message = 'Status lamaran berhasil diperbarui.';
        if ($newStatus === 'accepted') {
            $message .= ' Data pelamar berhasil disinkronkan ke tabel HRIS.';
        }
        if ($mailable) {
            $message .= ' Email notifikasi telah dikirim ke applicant.';
        }

        return redirect()->back()->with('info', $message);
    }

    /**
     * Cancel an ongoing application by the applicant.
     */
    public function cancel(Application $application): RedirectResponse
    {
        $applicantId = auth()->user()->applicant?->id;

        if (! $applicantId || $application->applicant_id !== $applicantId) {
            abort(403, 'Akses tidak diizinkan.');
        }

        if ($application->status !== 'pending') {
            return redirect()->back()->with('error', 'Lamaran ini sudah tidak dapat dibatalkan.');
        }

        $application->update([
            'status' => 'cancelled',
            'notes' => trim(($application->notes ? $application->notes."\n" : '').'Dibatalkan oleh pelamar pada '.now()->format('d/m/Y H:i')),
        ]);

        return redirect()->back()->with('success', 'Lamaran pekerjaan berhasil dibatalkan.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Application $application)
    {
        //
    }
}
