<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\Division;
use App\Models\Stage;
use Illuminate\Http\Request;

class ApplicantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admin = auth()->user()->admin;
        $isSuperAdmin = $admin?->role === 'superadmin';
        $officeId = $admin?->office_id;

        $applicants = Applicant::query()
            // Hanya pelamar yang biodatanya sudah lengkap terisi
            ->where(function ($query) {
                $query->where('is_completed', true)
                    ->orWhere(function ($subQuery) {
                        $subQuery->has('families')
                            ->has('educations')
                            ->has('workExperiences');
                    });
            })
            // Hanya pelamar yang sudah pernah melamar minimal 1 lowongan
            ->whereHas('applications', function ($appQuery) use ($isSuperAdmin, $officeId) {
                $appQuery->when(! $isSuperAdmin && $officeId, function ($query) use ($officeId) {
                    $query->whereHas('job', fn ($jobQuery) => $jobQuery->where('office_id', $officeId));
                });
            })
            ->with([
                'educations',
                'workExperiences',
                'applications.stage',
                'applications.job',
                'interest',
            ])
            ->latest()
            ->get();

        $divisions = Division::all();

        return view('auth.admin.applicant.index', compact('applicants', 'divisions'));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Applicant $applicant)
    {
        $admin = auth()->user()->admin;
        $isSuperAdmin = $admin?->role === 'superadmin';
        $officeId = $admin?->office_id;

        // Hanya pelamar yang sudah pernah melamar lowongan
        abort_if($applicant->applications()->doesntExist(), 404);

        if (! $isSuperAdmin && $officeId) {
            $hasBranchApplication = $applicant->applications()
                ->whereHas('job', fn ($q) => $q->where('office_id', $officeId))
                ->exists();
            abort_unless($hasBranchApplication, 403);
        }

        $applicant = $applicant->load([
            'user',
            'workExperiences',
            'educations',
            'families',
            'trainings',
            'expectation',
            'interest',
            'applications.job',
            'applications.stage',
        ]);

        $interestIds = collect($applicant->interest?->interests ?? [])
            ->filter(fn ($interest) => is_scalar($interest) && is_numeric($interest))
            ->map(fn ($interest) => (int) $interest)
            ->values();
        $interestNames = Division::query()
            ->whereIn('id', $interestIds)
            ->pluck('name', 'id');

        $latestApplication = $applicant->applications->sortByDesc('created_at')->first();
        $stages = $latestApplication?->job?->category
            ? Stage::where('type', $latestApplication->job->category)->orderBy('step')->get()
            : collect();

        return view('auth.admin.applicant.show', compact('applicant', 'interestNames', 'latestApplication', 'stages'));
    }

    /**
     * Tampilkan formulir biodata (HC-ODR.FRM.001.00) pelamar untuk dicetak.
     */
    public function print(Applicant $applicant)
    {
        $admin = auth()->user()->admin;
        $isSuperAdmin = $admin?->role === 'superadmin';
        $officeId = $admin?->office_id;

        abort_if($applicant->applications()->doesntExist(), 404);

        if (! $isSuperAdmin && $officeId) {
            $hasBranchApplication = $applicant->applications()
                ->whereHas('job', fn ($q) => $q->where('office_id', $officeId))
                ->exists();
            abort_unless($hasBranchApplication, 403);
        }

        return view('auth.applicant.biodata.print', $applicant->biodataPrintData());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Applicant $applicant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Applicant $applicant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Applicant $applicant)
    {
        //
    }
}
