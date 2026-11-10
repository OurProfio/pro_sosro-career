<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Applicant\StoreApplicantRequest;
use App\Http\Requests\Applicant\UpdateApplicantRequest;
use App\Models\Applicant;
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
        $applicant = auth()->user()->applicant;

        if (! $applicant) {
            return redirect()->route('biodata.create');
        }

        if ($incompleteRoute = $applicant->incompleteStepRoute()) {
            return redirect($incompleteRoute);
        }

        $applicant->load([
            'workExperiences',
            'educations',
            'families',
            'trainings',
        ]);

        return view('auth.applicant.biodata.index', compact('applicant'));
    }

    /**
     * Tampilkan formulir biodata (HC-ODR.FRM.001.00) yang sudah terisi untuk dicetak.
     */
    public function print()
    {
        $applicant = auth()->user()->applicant;

        if (! $applicant) {
            return redirect()->route('biodata.create');
        }

        if ($incompleteRoute = $applicant->incompleteStepRoute()) {
            return redirect($incompleteRoute);
        }

        return view('auth.applicant.biodata.print', $applicant->biodataPrintData());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $divisions = Division::all();
        $religions = DB::table('treligion')->select('RELIGION_ID', 'RELIGION_NAME_ID', 'RELIGION_NAME_EN')->get();
        $applicant = auth()->user()->applicant ?? null;

        return view('auth.applicant.biodata.create.biodata', compact('divisions', 'religions', 'applicant'));
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

            if (! empty($validated['email']) && auth()->user()->email !== $validated['email']) {
                auth()->user()->update(['email' => $validated['email']]);
            }

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
                'job_source' => $request['job_source'],
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
        return redirect()->route('biodata.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Applicant $applicant)
    {
        $divisions = Division::all();
        $religions = DB::table('treligion')->select('RELIGION_ID', 'RELIGION_NAME_ID', 'RELIGION_NAME_EN')->get();

        return view('auth.applicant.biodata.edit', compact('applicant', 'divisions', 'religions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateApplicantRequest $request, Applicant $applicant)
    {
        DB::transaction(function () use ($request, $applicant) {
            $validated = $request->validated();

            if ($request->hasFile('photo')) {
                $validated['photo_url'] = $request->file('photo')->store('applicants', 'public');
            }

            $applicant->update($validated);

            if (! empty($validated['email']) && $applicant->user && $applicant->user->email !== $validated['email']) {
                $applicant->user->update(['email' => $validated['email']]);
            }

            if ($request->has('division_preferences')) {
                ApplicantInterest::updateOrCreate(
                    ['applicant_id' => $applicant->id],
                    ['interests' => $request->validated('division_preferences')]
                );
            }

            ApplicantExpectation::updateOrCreate(
                ['applicant_id' => $applicant->id],
                [
                    'salary_expectation' => $request->validated('salary_expectation'),
                    'facility_expectation' => $request->validated('facility_expectation'),
                    'ready_to_relocate' => $request->validated('ready_to_relocate'),
                    'ready_to_travel' => $request->validated('ready_to_travel'),
                    'job_source' => $request->validated('job_source'),
                    'reference_by' => $request->validated('reference_by'),
                ]
            );
        });

        $redirectStep = $request->input('redirect_step', 'family');
        $targetRoute = match ($redirectStep) {
            'education' => route('biodata.education.create'),
            'workExperience' => route('biodata.workExperience.create'),
            'index' => route('biodata.index'),
            default => route('biodata.family.create'),
        };

        return redirect($targetRoute)->with('success', 'Data personal berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Applicant $applicant)
    {
        //
    }
}
