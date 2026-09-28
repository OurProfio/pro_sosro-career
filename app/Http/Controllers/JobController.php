<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Http\Requests\StoreJobRequest;
use App\Http\Requests\UpdateJobRequest;
use App\Models\Division;
use App\Models\Office;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobs = Job::all();

        return view('auth.admin.job.index', compact('jobs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->admin->role === 'superadmin') {
            $offices = Office::all();
        } else {
            $offices = Office::where('id', auth()->user()->admin->office_id)->get();
        }

        $divisions = Division::all();

        return view('auth.admin.job.create', compact('offices', 'divisions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJobRequest $request)
    {
        Job::create($request->validated() + [
            "admin_id" => auth()->user()->admin->id,
        ]);

        return redirect()->route('job.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Job $job)
    {
        $job->load(['office', 'admin.user']);

        return view('auth.admin.job.show', compact('job'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Job $job)
    {
        $offices = Office::all();

        return view('auth.admin.job.edit', compact('job', 'offices'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJobRequest $request, Job $job)
    {
        $job->update($request->validated());

        return redirect()->route('job.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Job $job)
    {
        $job->delete();

        return redirect()->route('job.index')->with('success', 'Berhasil menghapus data lowongan.');
    }
}
