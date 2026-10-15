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
        $openingDate = Carbon::parse($request->opening_date)->startOfDay();
        $status = $openingDate->isToday() ? 'aktif' : 'nonaktif';

        Job::create($request->validated() + [
            'admin_id' => auth()->user()->admin->id,
            'status' => $status,
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
            'applications.applicant',
            'applications.stage',
        ]);

        $stages = Stage::where('type', $job->category)
            ->orderBy('step')
            ->get();

        return view('auth.admin.job.show', compact('job', 'stages'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Job $job)
    {
        if (auth()->user()->admin->role === 'superadmin') {
            $offices = Office::all();
        } else {
            $offices = Office::where('id', auth()->user()->admin->office_id)->get();
        }

        $divisions = Division::all();

        return view('auth.admin.job.edit', compact('job', 'offices', 'divisions'));
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
        $job->update(['status' => 'dihapus']);
        $job->delete();

        return redirect()->route('job.index')->with('success', 'Berhasil menghapus data lowongan.');
    }
}
