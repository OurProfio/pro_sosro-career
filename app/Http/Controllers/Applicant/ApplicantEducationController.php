<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Applicant\StoreApplicantEducationRequest;
use App\Http\Requests\Applicant\UpdateApplicantEducationRequest;
use App\Models\ApplicantEducation;
use App\Models\ApplicantTraining;
use Illuminate\Support\Facades\DB;

class ApplicantEducationController extends Controller
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
        $educations = $applicant?->educations ?? collect();
        $trainings = $applicant?->trainings ?? collect();

        return view('auth.applicant.biodata.create.education', compact('applicant', 'educations', 'trainings'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreApplicantEducationRequest $request)
    {
        $applicant = auth()->user()->applicant;

        DB::transaction(function () use ($request, $applicant) {
            ApplicantEducation::where('applicant_id', $applicant->id)->delete();
            ApplicantTraining::where('applicant_id', $applicant->id)->delete();

            foreach ($request->validated('educations') as $education) {
                ApplicantEducation::create($education + ['applicant_id' => $applicant->id]);
            }

            if ($request->has('trainings')) {
                foreach ($request->validated('trainings') as $training) {
                    ApplicantTraining::create($training + ['applicant_id' => $applicant->id]);
                }
            }
        });

        $redirectStep = $request->input('redirect_step', 'workExperience');
        $targetRoute = match ($redirectStep) {
            'personal' => route('biodata.edit', $applicant->id),
            'family' => route('biodata.family.create'),
            'education' => route('biodata.education.create'),
            'index' => route('biodata.index'),
            default => route('biodata.workExperience.create'),
        };

        return redirect($targetRoute)->with('success', 'Data pendidikan & pelatihan berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ApplicantEducation $applicantEducation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ApplicantEducation $applicantEducation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateApplicantEducationRequest $request, ApplicantEducation $applicantEducation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ApplicantEducation $applicantEducation)
    {
        //
    }
}
