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

        $acceptedApplicationsCount = (clone $applicationsQuery())
            ->where('status', 'accepted')
            ->count();

        $totalApplicationsCount = (clone $applicationsQuery())
            ->count();

        $activeJobsCount = (clone $jobsQuery())
            ->where('status', 'aktif')
            ->whereDate('opening_date', '<=', $today)
            ->whereDate('closing_date', '>=', $today)
            ->count();

        $applicantsCount = Applicant::query()
            ->where(function (Builder $query): void {
                $query->where('is_completed', true)
                    ->orWhere(function (Builder $subQuery): void {
                        $subQuery->has('families')
                            ->has('educations')
                            ->has('workExperiences');
                    });
            })
            ->whereHas('applications', function (Builder $appQuery) use ($isSuperAdmin, $officeId): void {
                $appQuery->when(! $isSuperAdmin && $officeId, function (Builder $query) use ($officeId): void {
                    $query->whereHas('job', fn (Builder $jobQuery): Builder => $jobQuery->where('office_id', $officeId));
                });
            })
            ->count();

        $recentApplications = $applicationsQuery()
            ->with([
                'applicant:id,name,email',
                'applicant.educations:id,applicant_id,degree_level,major,graduation_year',
                'job:id,title,category,office_id',
                'stage:id,name',
            ])
            ->latest()
            ->limit(5)
            ->get();

        $closingSoonJobs = $jobsQuery()
            ->with('office:id,name')
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
            'acceptedApplicationsCount' => $acceptedApplicationsCount,
            'totalApplicationsCount' => $totalApplicationsCount,
            'activeJobsCount' => $activeJobsCount,
            'applicantsCount' => $applicantsCount,
            'recentApplications' => $recentApplications,
            'closingSoonJobs' => $closingSoonJobs,
        ]);
    }
}
