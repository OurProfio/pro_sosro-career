<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\Division;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ApplicantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $applicants = Applicant::all();

        return view('auth.admin.applicant.index', compact('applicants'));
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
        $applicant = $applicant->load([
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

        return view('auth.admin.applicant.show', compact('applicant', 'interestNames'));
    }

    public function pdf(Applicant $applicant)
    {
        $applicant->load([
            'workExperiences',
            'educations',
            'families',
            'trainings',
            'expectation',
            'interest',
            'applications.job',
        ]);

        return Pdf::loadView('auth.admin.applicant.pdf', compact('applicant'))
            ->setPaper('a4')
            ->stream('form-biodata-'.str()->slug($applicant->name).'.pdf');
    }

    /**
     * Tampilkan formulir biodata (HC-ODR.FRM.001.00) pelamar untuk dicetak.
     */
    public function print(Applicant $applicant)
    {
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
