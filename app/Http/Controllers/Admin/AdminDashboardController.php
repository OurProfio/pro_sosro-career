<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\Application;
use App\Models\Job;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $admin = auth()->user()->admin;
        abort_if($admin === null, 403);

        $isSuperAdmin = $admin->role === 'superadmin';
        $officeId = $admin->office_id;

        $jobsQuery = static fn (): Builder => Job::query()
            ->when(! $isSuperAdmin, fn (Builder $query): Builder => $query->where('office_id', $officeId));

        $applicationsQuery = static fn (): Builder => Application::query()
            ->when(! $isSuperAdmin, function (Builder $query) use ($officeId): void {
                $query->whereHas('job', fn (Builder $jobQuery): Builder => $jobQuery->where('office_id', $officeId));
            });

        $today = today();

        $pendingApplicationsCount = (clone $applicationsQuery())
            ->where('status', 'pending')
            ->count();

        $inProgressApplicationsCount = (clone $applicationsQuery())
            ->where('status', 'progress')
            ->count();

        $activeJobsCount = (clone $jobsQuery())
            ->where('status', 'aktif')
            ->whereDate('opening_date', '<=', $today)
            ->whereDate('closing_date', '>=', $today)
            ->count();

        $applicantsCount = Applicant::query()
            ->when(! $isSuperAdmin, function (Builder $query) use ($officeId): void {
                $query->whereHas('applications.job', fn (Builder $jobQuery): Builder => $jobQuery->where('office_id', $officeId));
            })
            ->count();

        $recentApplications = $applicationsQuery()
            ->with([
                'applicant:id,name,email',
                'job:id,title,office_id',
                'stage:id,name',
            ])
            ->latest()
            ->limit(6)
            ->get();

        $closingSoonJobs = $jobsQuery()
            ->withCount('applications')
            ->where('status', 'aktif')
            ->whereDate('opening_date', '<=', $today)
            ->whereDate('closing_date', '>=', $today)
            ->whereDate('closing_date', '<=', $today->copy()->addDays(7))
            ->orderBy('closing_date')
            ->limit(5)
            ->get();

        return view('auth.admin.index', [
            'adminName' => $admin->name,
            'officeName' => $admin->office?->name,
            'isSuperAdmin' => $isSuperAdmin,
            'pendingApplicationsCount' => $pendingApplicationsCount,
            'inProgressApplicationsCount' => $inProgressApplicationsCount,
            'activeJobsCount' => $activeJobsCount,
            'applicantsCount' => $applicantsCount,
            'recentApplications' => $recentApplications,
            'closingSoonJobs' => $closingSoonJobs,
        ]);
    }
}
