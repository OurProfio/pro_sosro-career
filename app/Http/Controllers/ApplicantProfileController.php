<?php

namespace App\Http\Controllers;

use App\Models\ApplicantProfile;
use App\Http\Requests\StoreApplicantProfileRequest;
use App\Http\Requests\UpdateApplicantProfileRequest;
use App\Models\Divisi;
use App\Models\MinatPekerjaan;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ApplicantProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->applicant->is_profile_complete === 1) {
            return view('auth.applicant.biodata.index');
        } else {
            return redirect()->route('biodata.create')->with('warning', 'Silahkan lengkapi data profil anda terlebih dahulu.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $divisis = Divisi::all();

        return view('auth.applicant.biodata.create', compact('divisis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreApplicantProfileRequest $request)
    {
        DB::transaction(function () use ($request) {
            auth()->user()->applicant->update(['is_profile_complete' => true]);

            ApplicantProfile::updateOrCreate(
                ['applicant_id' => auth()->user()->applicant->id],
                $request->validated()
            );

            foreach ($request->minat_ids as $index => $divisiId) {
                MinatPekerjaan::updateOrCreate(
                    ['applicant_profile_id' => auth()->user()->applicant->applicantProfile->id, 'divisi_id' => $divisiId],
                    ['urutan' => $index + 1]
                );
            }
        });

        return redirect()->route('applicant.index')->with('success', 'Berhasil menambahkan biodata pelamar.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ApplicantProfile $applicantProfile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ApplicantProfile $applicantProfile)
    {
        $minatPekerjaanIds = $applicantProfile->minatPekerjaan->sortBy('urutan')->pluck('divisi_id')->toArray();
        $divisis = Divisi::all();

        if (!empty($minatPekerjaanIds)) {
            $divisis = $divisis->sortBy(function ($divisi) use ($minatPekerjaanIds) {
                $index = array_search($divisi->id, $minatPekerjaanIds);
                return $index !== false ? $index : 999;
            });
        }

        return view('auth.applicant.biodata.edit', compact('applicantProfile', 'divisis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateApplicantProfileRequest $request, ApplicantProfile $applicantProfile)
    {
        DB::transaction(function () use ($request, $applicantProfile) {
            $applicant = auth()->user()->applicant;
            $applicant->update(['is_profile_complete' => true]);
            
            $validated = $request->validated();
            $minatIds = Arr::pull($validated, 'minat_ids');
            
            $applicantProfile->update($request->validated());
            $applicantProfile->minatPekerjaan()->delete();

            $minatData = collect($minatIds)->map(function ($divisiId, $index) {
                return [
                    'divisi_id' => $divisiId,
                    'urutan' => $index + 1,
                ];
            })->toArray();

            $applicantProfile->minatPekerjaan()->createMany($minatData);
        });

        return redirect()->route('applicant.index')->with('success', 'Berhasil mengedit biodata pelamar.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ApplicantProfile $applicantProfile)
    {
        //
    }
}
