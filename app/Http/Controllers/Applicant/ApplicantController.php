<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Http\Requests\Applicant\StoreApplicantRequest;
use App\Http\Requests\Applicant\UpdateApplicantRequest;
use App\Models\ApplicantExpectation;
use App\Models\ApplicantInterest;
use App\Models\ApplicantWorkExprience;
use App\Models\Division;
use Illuminate\Support\Facades\DB;

class ApplicantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user()->applicant) {
            return redirect()->route('biodata.create');
        }

        $applicant = Applicant::with([
            'workExperiences',
            'educations',
            'families',
            'trainings'
        ])->where('user_id', auth()->id())->firstOrFail();

        return view('auth.applicant.biodata.index', compact('applicant'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $divisions = Division::all();
        $applicant = auth()->user()->applicant ?? null;

        return view('auth.applicant.biodata.create.biodata', compact('divisions', 'applicant'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreApplicantRequest $request)
    {
        DB::transaction(function () use ($request) {
            $validated = $request->validated();
            $validated['user_id'] = auth()->user()->id;

            $applicant = Applicant::create($validated + [
                'photo_url' => $request->file('photo') ? $request->file('photo')->store('applicants', 'public') : null,
            ]);
            ApplicantInterest::updateOrCreate(
                ['applicant_id' => $applicant->id],
                ['interests' => $request->validated('division_preferences')],
            );
            ApplicantExpectation::create([
                'applicant_id' => $applicant->id,
                'salary_expectation' => $request['salary_expectation'],
                'facility_expectation' => $request['facility_expectation'] ?? null,
                'ready_to_relocate' => $request['ready_to_relocate'],
                'ready_to_travel' => $request['ready_to_travel'],
                'reference_by' => $request['reference_by'] ?? null,
            ]);
            if ($request->validated('has_worked_in_sosro')) {
                ApplicantWorkExprience::create([
                    'applicant_id' => $applicant->id,
                    'company_name' => $request['previous_sosro_company'],
                    'position' => $request['previous_sosro_position'],
                ]);
            }
        });

        return redirect()->route('biodata.family.create')->with('success', 'Berhasil menambahkan biodata pelamar.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Applicant $applicant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Applicant $applicant)
    {
        dd($applicant);
        $divisions = Division::all();

        return view('auth.applicant.biodata.edit', compact('applicant', 'divisions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateApplicantRequest $request, Applicant $applicant)
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
