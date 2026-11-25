<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Applicant\StoreApplicantEducationRequest;
use App\Http\Requests\Applicant\UpdateApplicantEducationRequest;
use App\Models\ApplicantEducation;
use App\Models\ApplicantEducationOther;
use App\Models\ApplicantTraining;
use Database\Seeders\ThrmListFacultySeeder;
use Database\Seeders\ThrmListMajorSeeder;
use Database\Seeders\ThrmListSchoolSeeder;
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

        if (! $applicant) {
            return redirect()->route('biodata.create');
        }

        if ($applicant->families()->doesntExist()) {
            return redirect()->route('biodata.family.create');
        }

        $educations = $applicant->educations ?? collect();
        $trainings = $applicant->trainings ?? collect();

        $educationTypes = DB::table('thrm_education')
            ->select('EDUTYPE_ID', 'EDUTYPE_NAME_ID', 'EDUTYPE_NAME_EN', 'EDUTYPE_LEVEL')
            ->orderByRaw('COALESCE(EDUTYPE_LEVEL, 99) ASC')
            ->get();

        $faculties = DB::table('thrm_list_faculty')
            ->select('FACULTY_ID', 'FACULTY_CODE', 'FACULTY_NAME')
            ->where('FACULTY_ID', '!=', ThrmListFacultySeeder::OTHER_FACULTY_ID)
            ->whereNotNull('FACULTY_NAME')
            ->where('FACULTY_NAME', '!=', '')
            ->orderBy('FACULTY_NAME', 'ASC')
            ->get();

        $majors = DB::table('thrm_list_major')
            ->select('MAJOR_ID', 'MAJOR_CODE', 'MAJOR_NAME')
            ->where('MAJOR_ID', '!=', ThrmListMajorSeeder::OTHER_MAJOR_ID)
            ->whereNotNull('MAJOR_NAME')
            ->where('MAJOR_NAME', '!=', '')
            ->orderBy('MAJOR_NAME', 'ASC')
            ->get();

        $schools = DB::table('thrm_list_school')
            ->select('EDU_ID', 'EDU_CODE', 'EDU_NAME')
            ->where('EDU_ID', '!=', ThrmListSchoolSeeder::OTHER_EDU_ID)
            ->whereNotNull('EDU_NAME')
            ->where('EDU_NAME', '!=', '')
            ->orderBy('EDU_NAME', 'ASC')
            ->get();

        return view('auth.applicant.biodata.create.education', compact(
            'applicant',
            'educations',
            'trainings',
            'educationTypes',
            'faculties',
            'majors',
            'schools'
        ));
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
                $createdEducation = ApplicantEducation::create($education + ['applicant_id' => $applicant->id]);

                if ((int) $createdEducation->school_id === ThrmListSchoolSeeder::OTHER_EDU_ID && filled($createdEducation->institution_name)) {
                    ApplicantEducationOther::create([
                        'applicant_education_id' => $createdEducation->id,
                        'applicant_id' => $applicant->id,
                        'category' => ApplicantEducationOther::CATEGORY_SCHOOL,
                        'custom_name' => $createdEducation->institution_name,
                    ]);
                }

                if ((int) $createdEducation->faculty_id === ThrmListFacultySeeder::OTHER_FACULTY_ID && filled($createdEducation->faculty)) {
                    ApplicantEducationOther::create([
                        'applicant_education_id' => $createdEducation->id,
                        'applicant_id' => $applicant->id,
                        'category' => ApplicantEducationOther::CATEGORY_FACULTY,
                        'custom_name' => $createdEducation->faculty,
                    ]);
                }

                if ((int) $createdEducation->major_id === ThrmListMajorSeeder::OTHER_MAJOR_ID && filled($createdEducation->major)) {
                    ApplicantEducationOther::create([
                        'applicant_education_id' => $createdEducation->id,
                        'applicant_id' => $applicant->id,
                        'category' => ApplicantEducationOther::CATEGORY_MAJOR,
                        'custom_name' => $createdEducation->major,
                    ]);
                }
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
