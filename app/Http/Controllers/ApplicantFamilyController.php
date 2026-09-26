<?php

namespace App\Http\Controllers;

use App\Models\ApplicantFamily;
use App\Http\Requests\StoreApplicantFamilyRequest;
use App\Http\Requests\UpdateApplicantFamilyRequest;

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
        return view('auth.applicant.biodata.create.family');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreApplicantFamilyRequest $request)
    {
        foreach ($request->validated('families') as $member => $data) {
            if ($member === 'children') {
                foreach ($data as $children) {
                    $children['applicant_id'] = auth()->user()->applicant->id;
                    ApplicantFamily::create($children);
                }
            } else if ($member === 'siblings') {
                foreach ($data as $sibling) {
                    $sibling['applicant_id'] = auth()->user()->applicant->id;
                    ApplicantFamily::create($sibling);
                }
            } else {
                $data['applicant_id'] = auth()->user()->applicant->id;
                ApplicantFamily::create($data);
            }
        }

        return redirect()->route('biodata.education.create')->with('success', 'Berhasil menambahkan data keluarga.');
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
