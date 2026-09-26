<?php

namespace App\Http\Controllers;

use App\Models\ApplicantWorkExprience;
use App\Http\Requests\StoreApplicantWorkExprienceRequest;
use App\Http\Requests\UpdateApplicantWorkExprienceRequest;

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
        return view('auth.applicant.biodata.create.workExperience');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreApplicantWorkExprienceRequest $request)
    {
        if ($request->validated()) {
            foreach ($request->validated('experiences') as $exp) {
                ApplicantWorkExprience::create($exp + ['applicant_id' => auth()->user()->applicant->id]);
            }
        }

        return redirect()->route('biodata.index')->with('success', 'Pengalaman kerja berhasil disimpan.');
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
