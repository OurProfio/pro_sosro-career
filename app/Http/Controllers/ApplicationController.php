<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Http\Requests\StoreApplicationRequest;
use App\Http\Requests\UpdateApplicationRequest;
use App\Models\Job;

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
        if (!auth()->user()->applicant) {
            return redirect()->route('biodata.index')->with('error', 'Anda harus melengkapi profil terlebih dahulu sebelum melamar pekerjaan.');
        }

        $job = Job::findOrFail($request->job_id);
        
        if (Application::where('applicant_id', auth()->user()->applicant->id)->count() === 3) {
            return redirect()->back()->with('error', 'Anda sudah mencapai batas maksimal melamar pekerjaan (3 kali).');
        };

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
     * Update the specified resource in storage.
     */
    public function update(UpdateApplicationRequest $request, Application $application)
    {
        $application->update([
            'status' => $request->status,
            'stages_id' => $request->stages_id,
            'notes' => $request->notes,
        ]);

        return redirect()->back()->with('success', 'Status lamaran berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Application $application)
    {
        //
    }
}
