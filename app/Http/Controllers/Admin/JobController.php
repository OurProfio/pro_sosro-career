<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreJobRequest;
use App\Http\Requests\Admin\UpdateJobRequest;
use App\Models\Division;
use App\Models\Job;
use App\Models\Office;
use App\Models\Stage;
use Carbon\Carbon;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Job::where('status', 'aktif')
            ->whereDate('closing_date', '<', today())
            ->update(['status' => 'nonaktif']);

        $jobs = Job::with('office')->withCount('applications')->latest()->get();

        if (auth()->user()->admin->role === 'superadmin') {
            $offices = Office::orderBy('name')->get();
        } else {
            $offices = Office::where('id', auth()->user()->admin->office_id)->orderBy('name')->get();
        }

        $divisions = Division::all();

        return view('auth.admin.job.index', compact('jobs', 'offices', 'divisions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('job.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJobRequest $request)
    {
        Job::create($request->validated() + [
            'admin_id' => auth()->user()->admin->id,
            'opening_date' => today(),
            'status' => 'aktif',
        ]);

        return redirect()->route('job.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Job $job)
    {
        if ($job->status === 'aktif' && $job->closing_date && Carbon::parse($job->closing_date)->isPast() && ! Carbon::parse($job->closing_date)->isToday()) {
            $job->update(['status' => 'nonaktif']);
        }

        $job->load([
            'office',
            'admin.user',
            'applications.applicant.educations',
            'applications.applicant.workExperiences',
            'applications.stage',
        ]);

        $stages = Stage::where('type', $job->category)
            ->orderBy('step')
            ->get();

        if (auth()->user()->admin->role === 'superadmin') {
            $offices = Office::orderBy('name')->get();
        } else {
            $offices = Office::where('id', auth()->user()->admin->office_id)->orderBy('name')->get();
        }

        $divisions = Division::all();

        return view('auth.admin.job.show', compact('job', 'stages', 'offices', 'divisions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Job $job)
    {
        return redirect()->route('job.show', $job->id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJobRequest $request, Job $job)
    {
        $data = $request->validated();

        if ($job->status !== 'aktif') {
            $data['status'] = 'nonaktif';
        }

        $job->update($data);

        return redirect()->route('job.show', $job)->with('success', 'Data lowongan berhasil diperbarui.');
    }

    /**
     * Close the specified job (cannot be deleted or reopened once closed).
     */
    public function destroy(Job $job)
    {
        if ($job->status === 'aktif') {
            $job->update([
                'status' => 'nonaktif',
                'closing_date' => today(),
            ]);
        }

        return redirect()->back()->with('success', 'Lowongan berhasil ditutup secara permanen.');
    }
}
