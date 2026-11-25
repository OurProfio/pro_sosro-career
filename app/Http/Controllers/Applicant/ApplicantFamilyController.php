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

        if (! $applicant) {
            return redirect()->route('biodata.create');
        }

        $families = $applicant->families ?? collect();
        $educations = DB::table('thrm_education')
            ->select('EDUTYPE_ID', 'EDUTYPE_NAME_ID', 'EDUTYPE_NAME_EN')
            ->orderBy('EDUTYPE_LEVEL')
            ->get();

        return view('auth.applicant.biodata.create.family', compact('applicant', 'families', 'educations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreApplicantFamilyRequest $request)
    {
        $applicant = auth()->user()->applicant;

        $educationMap = DB::table('thrm_education')
            ->get(['EDUTYPE_ID', 'EDUTYPE_NAME_ID', 'EDUTYPE_NAME_EN'])
            ->keyBy('EDUTYPE_ID');
        $validRelationshipIds = DB::table('thrm_family_connection')
            ->pluck('RELATIONSHIP_ID')
            ->all();

        $enrichFamilyData = static function (array $row) use ($educationMap, $validRelationshipIds): array {
            $eduInput = trim((string) ($row['education'] ?? ''));
            if ($eduInput !== '' && ctype_digit($eduInput) && $educationMap->has((int) $eduInput)) {
                $eduRecord = $educationMap->get((int) $eduInput);
                $row['edutype_id'] = (int) $eduInput;
                $row['education'] = $eduRecord->EDUTYPE_NAME_ID ?: ($eduRecord->EDUTYPE_NAME_EN ?: $eduInput);
            } else {
                $resolvedEduId = ApplicantFamily::resolveEdutypeId($eduInput);
                $row['edutype_id'] = ($resolvedEduId !== null && $educationMap->has($resolvedEduId))
                    ? $resolvedEduId
                    : null;
            }

            $resolvedRelId = ApplicantFamily::resolveRelationshipId($row['relationship'] ?? null, $row['gender'] ?? null);
            $row['relationship_id'] = ($resolvedRelId !== null && in_array($resolvedRelId, $validRelationshipIds, true))
                ? $resolvedRelId
                : null;

            return $row;
        };

        DB::transaction(function () use ($request, $applicant, $enrichFamilyData) {
            ApplicantFamily::where('applicant_id', $applicant->id)->delete();

            foreach ($request->validated('families') as $member => $data) {
                if ($member === 'children') {
                    foreach ($data as $children) {
                        $children['applicant_id'] = $applicant->id;
                        ApplicantFamily::create($enrichFamilyData($children));
                    }
                } elseif ($member === 'siblings') {
                    foreach ($data as $sibling) {
                        $sibling['applicant_id'] = $applicant->id;
                        ApplicantFamily::create($enrichFamilyData($sibling));
                    }
                } else {
                    if (empty($data['name'])) {
                        continue;
                    }
                    $data['applicant_id'] = $applicant->id;
                    if ($member === 'father' || $member === 'father_in_law') {
                        $data['gender'] = 'l';
                    } elseif ($member === 'mother' || $member === 'mother_in_law') {
                        $data['gender'] = 'p';
                    } elseif ($member === 'spouse' && empty($data['gender'])) {
                        $data['gender'] = $applicant->gender === 'l' ? 'p' : ($applicant->gender === 'p' ? 'l' : null);
                    }
                    ApplicantFamily::create($enrichFamilyData($data));
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
