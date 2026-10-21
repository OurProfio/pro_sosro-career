<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Applicant\StoreApplicantWorkExprienceRequest;
use App\Http\Requests\Applicant\UpdateApplicantWorkExprienceRequest;
use App\Models\ApplicantWorkExprience;
use Illuminate\Support\Facades\DB;

class ApplicantWorkExprienceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $applicant = auth()->user()->applicant;
        $workExperiences = $applicant?->workExperiences ?? collect();

        return view('auth.applicant.biodata.create.workExperience', compact('applicant', 'workExperiences'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreApplicantWorkExprienceRequest $request)
    {
        $applicant = auth()->user()->applicant;

        DB::transaction(function () use ($request, $applicant) {
            $applicant->update([
                'has_applied_sosro' => $request->input('has_applied_sosro', 'n'),
                'previous_applied_position' => $request->input('has_applied_sosro') === 'y' ? $request->input('previous_applied_position') : null,
                'previous_applied_year' => $request->input('has_applied_sosro') === 'y' ? $request->input('previous_applied_year') : null,
            ]);

            ApplicantWorkExprience::where('applicant_id', $applicant->id)->delete();

            if ($request->has('experiences')) {
                foreach ($request->validated('experiences') as $exp) {
                    if (! empty($exp['company_name']) || ! empty($exp['position'])) {
                        ApplicantWorkExprience::create($exp + ['applicant_id' => $applicant->id]);
                    }
                }
            }
        });

        $redirectStep = $request->input('redirect_step', 'index');
        $targetRoute = match ($redirectStep) {
            'personal' => route('biodata.edit', $applicant->id),
            'family' => route('biodata.family.create'),
            'education' => route('biodata.education.create'),
            'workExperience' => route('biodata.workExperience.create'),
            default => route('biodata.index'),
        };

        return redirect($targetRoute)->with('success', 'Data pengalaman kerja berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ApplicantWorkExprience $applicantWorkExprience)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ApplicantWorkExprience $applicantWorkExprience)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateApplicantWorkExprienceRequest $request, ApplicantWorkExprience $applicantWorkExprience)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ApplicantWorkExprience $applicantWorkExprience)
    {
        //
    }
}
