<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Applicant\StoreApplicantFamilyRequest;
use App\Http\Requests\Applicant\UpdateApplicantFamilyRequest;
use App\Models\ApplicantFamily;
use Illuminate\Support\Facades\DB;

class ApplicantFamilyController extends Controller
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
        $families = $applicant?->families ?? collect();

        return view('auth.applicant.biodata.create.family', compact('applicant', 'families'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreApplicantFamilyRequest $request)
    {
        $applicant = auth()->user()->applicant;

        DB::transaction(function () use ($request, $applicant) {
            ApplicantFamily::where('applicant_id', $applicant->id)->delete();

            foreach ($request->validated('families') as $member => $data) {
                if ($member === 'children') {
                    foreach ($data as $children) {
                        $children['applicant_id'] = $applicant->id;
                        ApplicantFamily::create($children);
                    }
                } elseif ($member === 'siblings') {
                    foreach ($data as $sibling) {
                        $sibling['applicant_id'] = $applicant->id;
                        ApplicantFamily::create($sibling);
                    }
                } else {
                    $data['applicant_id'] = $applicant->id;
                    if ($member === 'father') {
                        $data['gender'] = 'l';
                    } elseif ($member === 'mother') {
                        $data['gender'] = 'p';
                    } elseif ($member === 'spouse' && empty($data['gender'])) {
                        $data['gender'] = $applicant->gender === 'l' ? 'p' : ($applicant->gender === 'p' ? 'l' : null);
                    }
                    ApplicantFamily::create($data);
                }
            }
        });

        $redirectStep = $request->input('redirect_step', 'education');
        $targetRoute = match ($redirectStep) {
            'personal' => route('biodata.edit', $applicant->id),
            'family' => route('biodata.family.create'),
            'workExperience' => route('biodata.workExperience.create'),
            'index' => route('biodata.index'),
            default => route('biodata.education.create'),
        };

        return redirect($targetRoute)->with('success', 'Data keluarga berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ApplicantFamily $applicantFamily)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ApplicantFamily $applicantFamily)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateApplicantFamilyRequest $request, ApplicantFamily $applicantFamily)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ApplicantFamily $applicantFamily)
    {
        //
    }
}
