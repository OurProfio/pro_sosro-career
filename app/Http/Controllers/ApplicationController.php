<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApplicationRequest;
use App\Http\Requests\UpdateApplicationStageRequest;
use App\Http\Requests\UpdateApplicationStatusRequest;
use App\Mail\AcceptedHOMail;
use App\Mail\AcceptedKpwMail;
use App\Mail\InterviewOfflineMail;
use App\Mail\InterviewOnlineMail;
use App\Mail\RejectedMail;
use App\Models\Application;
use App\Models\Job;
use Illuminate\Http\RedirectResponse;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

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

        if ($job->closing_date && \Carbon\Carbon::parse($job->closing_date)->isPast() && !\Carbon\Carbon::parse($job->closing_date)->isToday()) {
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
    public function updateStage(UpdateApplicationStageRequest $request, Application $application): RedirectResponse
    {
        $stage = $request->selectedStage();

        $application->update([
            'stages_id' => $stage->id,
            'status' => 'progress',
        ]);

        $application->load('stage');

        $mailable = null;

        if ($stage->isInterview()) {
            $mailable = $request->interview_type === 'virtual'
                ? new InterviewOnlineMail($application, $request->interview_date, $request->interview_time, $request->interview_link)
                : new InterviewOfflineMail($application, $request->interview_date, $request->interview_time, $request->interview_address);
        }

        return $this->redirectAfterUpdate($application, $mailable, 'Stage lamaran berhasil diperbarui.');
    }

    /**
     * Accept or reject the application and notify the applicant.
     */
    public function updateStatus(UpdateApplicationStatusRequest $request, Application $application): RedirectResponse
    {
        $application->update(['status' => $request->status]);

        if ($request->status === 'rejected') {
            $mailable = new RejectedMail($application);
        } elseif ($application->job->office->type === 'HO') {
            $mailable = new AcceptedHOMail($application, $request->start_date, $request->work_address);
        } else {
            $mailable = new AcceptedKpwMail($application, $request->start_date, $request->work_address);
        }

        return $this->redirectAfterUpdate($application, $mailable, 'Status lamaran berhasil diperbarui.');
    }

    /**
     * Send the mailable (if any) to the applicant and redirect back with the result.
     */
    private function redirectAfterUpdate(Application $application, ?Mailable $mailable, string $message): RedirectResponse
    {
        if (! $mailable) {
            return redirect()->back()->with('info', $message);
        }

        try {
            Mail::to($application->applicant->email)->send($mailable);
        } catch (Throwable $exception) {
            Log::error('Gagal mengirim email lamaran.', ['application_id' => $application->id, 'error' => $exception->getMessage()]);

            return redirect()->back()->with('info', $message.' Namun email gagal dikirim ke applicant.');
        }

        return redirect()->back()->with('info', $message.' Email telah dikirim ke applicant.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Application $application)
    {
        //
    }
}
