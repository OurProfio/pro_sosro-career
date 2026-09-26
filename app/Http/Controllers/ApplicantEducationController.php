<?php

namespace App\Http\Controllers;

use App\Models\ApplicantEducation;
use App\Http\Requests\StoreApplicantEducationRequest;
use App\Http\Requests\UpdateApplicantEducationRequest;
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
        return view('auth.applicant.biodata.create.education');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreApplicantEducationRequest $request)
    {
        DB::transaction(function () use ($request) {
            foreach ($request->validated('educations') as $education) {
                ApplicantEducation::create($education + ['applicant_id' => auth()->user()->applicant->id]);
            }

            if ($request->has('trainings')) {
                foreach ($request->validated('trainings') as $training) {
                    ApplicantTraining::create($training + ['applicant_id' => auth()->user()->applicant->id]);
                }
            }
        });

        return redirect()->route('biodata.workExperience.create', auth()->user()->applicant->id)->with('success', 'Education data saved successfully.');
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
