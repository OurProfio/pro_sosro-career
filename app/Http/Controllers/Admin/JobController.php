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

        $admin = auth()->user()->admin;
        $isSuperAdmin = $admin?->role === 'superadmin';

        $jobsQuery = Job::with('office')->withCount('applications')->latest();

        if (! $isSuperAdmin) {
            $jobsQuery->where('office_id', $admin?->office_id);
        }

        $jobs = $jobsQuery->get();

        if ($isSuperAdmin) {
            $offices = Office::orderBy('name')->get();
            $assignableOffices = Office::whereHas('admin', fn ($q) => $q->where('is_active', true))
                ->orderBy('name')
                ->get();
        } else {
            $offices = Office::where('id', $admin?->office_id)->orderBy('name')->get();
            $assignableOffices = Office::where('id', $admin?->office_id)->get();
        }

        $divisions = Division::all();
        $cities = Job::CITIES;

        return view('auth.admin.job.index', compact('jobs', 'offices', 'assignableOffices', 'divisions', 'cities'));
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
        $admin = auth()->user()->admin;
        $status = $admin?->role === 'superadmin' ? 'aktif' : 'pending';

        $data = $request->validated();
        if ($admin && $admin->role !== 'superadmin' && $admin->office_id) {
            $data['office_id'] = $admin->office_id;
        }

        Job::create($data + [
            'admin_id' => $admin->id,
            'opening_date' => today(),
            'status' => $status,
        ]);

        $message = $status === 'aktif'
            ? 'Lowongan berhasil dibuat dan dipublikasikan.'
            : 'Lowongan berhasil dibuat dan berstatus ditunda (menunggu persetujuan Superadmin).';

        return redirect()->route('job.index')->with('success', $message);
    }

    /**
     * Display the specified resource.
     */
    public function show(Job $job)
    {
        $admin = auth()->user()->admin;
        $isSuperAdmin = $admin?->role === 'superadmin';

        if (! $isSuperAdmin && $admin?->office_id && $job->office_id !== $admin->office_id) {
            abort(403, 'Akses tidak diizinkan untuk kantor cabang lain.');
        }

        if ($job->status === 'aktif' && $job->closing_date && Carbon::parse($job->closing_date)->isPast() && ! Carbon::parse($job->closing_date)->isToday()) {
            $job->update(['status' => 'nonaktif']);
        }

        $job->load([
            'office',
            'admin.user',
            'applications.applicant.educations',
            'applications.applicant.workExperiences',
            'applications.stage',
            'applications.userConfirmation',
        ]);

        $stages = Stage::where('type', $job->category)
            ->orderBy('step')
            ->get();

        if ($isSuperAdmin) {
            $offices = Office::orderBy('name')->get();
            $assignableOffices = Office::whereHas('admin', fn ($q) => $q->where('is_active', true))
                ->orWhere('id', $job->office_id)
                ->orderBy('name')
                ->get();
        } else {
            $offices = Office::where('id', $admin?->office_id)->orderBy('name')->get();
            $assignableOffices = Office::where('id', $admin?->office_id)->get();
        }

        $divisions = Division::all();
        $cities = Job::CITIES;

        return view('auth.admin.job.show', compact('job', 'stages', 'offices', 'assignableOffices', 'divisions', 'cities'));
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
        $admin = auth()->user()->admin;
        $isSuperAdmin = $admin?->role === 'superadmin';

        if (! $isSuperAdmin && $admin?->office_id && $job->office_id !== $admin->office_id) {
            abort(403, 'Akses tidak diizinkan untuk kantor cabang lain.');
        }

        $data = $request->validated();

        if ($admin && ! $isSuperAdmin && $admin->office_id) {
            $data['office_id'] = $admin->office_id;
        }

        if (! isset($data['status'])) {
            $data['status'] = $job->status;
        }

        $job->update($data);

        return redirect()->route('job.show', $job)->with('success', 'Data lowongan berhasil diperbarui.');
    }

    /**
     * Approve the specified job (Superadmin only).
     */
    public function approve(Job $job)
    {
        if (auth()->user()->admin?->role !== 'superadmin') {
            abort(403, 'Hanya superadmin yang dapat menyetujui lowongan.');
        }

        $job->update([
            'status' => 'aktif',
            'opening_date' => today(),
        ]);

        return redirect()->back()->with('success', 'Lowongan "'.$job->title.'" berhasil disetujui dan sekarang aktif.');
    }

    /**
     * Close the specified job (cannot be deleted or reopened once closed).
     */
    public function destroy(Job $job)
    {
        $admin = auth()->user()->admin;
        $isSuperAdmin = $admin?->role === 'superadmin';

        if (! $isSuperAdmin && $admin?->office_id && $job->office_id !== $admin->office_id) {
            abort(403, 'Akses tidak diizinkan untuk kantor cabang lain.');
        }

        if (in_array($job->status, ['aktif', 'pending'])) {
            $job->update([
                'status' => 'nonaktif',
                'closing_date' => today(),
            ]);
        }

        return redirect()->back()->with('success', 'Lowongan berhasil ditutup secara permanen.');
    }
}
