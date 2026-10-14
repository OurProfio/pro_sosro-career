<?php

namespace App\Services;

use App\Models\Applicant;
use App\Models\Application;
use App\Models\Hris\ThrmAppCourse;
use App\Models\Hris\ThrmAppEducation;
use App\Models\Hris\ThrmAppFamily;
use App\Models\Hris\ThrmAppHistory;
use App\Models\Hris\ThrmAppJobExp;
use App\Models\Hris\ThrmAppPersonalData;
use Illuminate\Support\Facades\Log;

class HrisTransferService
{
    /**
     * Transfer accepted applicant and application data to HRIS (THRM) staging tables.
     */
    public function transferAcceptedApplicant(Application $application, array $extraData = []): ThrmAppPersonalData
    {
        $applicant = $application->applicant ?? Applicant::findOrFail($application->applicant_id);

        $applicant->loadMissing([
            'user',
            'families',
            'educations',
            'workExperiences',
            'trainings',
        ]);

        $applicantId = $this->generateApplicantId($applicant);

        // 1. Personal Data (THRMAPPPERSONALDATA)
        $personalData = $this->syncPersonalData($applicant, $applicantId, $extraData);

        // 2. Family Data (THRMAppFamily)
        $this->syncFamilyData($applicant, $applicantId);

        // 3. Education Data (THRMAppEducation)
        $this->syncEducationData($applicant, $applicantId);

        // 4. Job Experience Data (THRMAppJobExp)
        $this->syncJobExpData($applicant, $applicantId);

        // 5. Training / Course Data (THRMAPPCOURSE)
        $this->syncCourseData($applicant, $applicantId);

        // 6. Application History / FPTK (THRMAPPHISTORY)
        $this->syncApplicationHistory($application, $applicantId, $extraData);

        Log::info("Applicant ID {$applicant->id} successfully transferred to HRIS tables with APPLICANT_ID: {$applicantId}");

        return $personalData;
    }

    /**
     * Generate a unique and formatted APPLICANT_ID for HRIS.
     */
    protected function generateApplicantId(Applicant $applicant): string
    {
        $year = date('Y');
        $id = str_pad((string) $applicant->id, 5, '0', STR_PAD_LEFT);

        return "APP-{$year}-{$id}";
    }

    /**
     * Sync THRMAPPPERSONALDATA.
     */
    protected function syncPersonalData(Applicant $applicant, string $applicantId, array $extraData): ThrmAppPersonalData
    {
        $nameParts = explode(' ', trim($applicant->name ?? ''), 2);
        $firstName = $nameParts[0] ?? '';
        $lastName = $nameParts[1] ?? '';

        $genderVal = match (strtolower((string) $applicant->gender)) {
            'l' => 1,
            'p' => 2,
            default => null,
        };

        return ThrmAppPersonalData::updateOrCreate(
            ['APPLICANT_ID' => $applicantId],
            [
                'FIRST_NAME' => $firstName,
                'LAST_NAME' => $lastName,
                'GENDER' => $genderVal,
                'RELIGION_ID' => $applicant->religion,
                'BIRTH_PLACE' => $applicant->place_of_birth,
                'DATE_OF_BIRTH' => $applicant->date_of_birth ? date('Y-m-d H:i:s', strtotime($applicant->date_of_birth)) : null,
                'MARITAL_STATUS' => $this->mapMaritalStatus($applicant->marital_status),
                'ADDRESS1' => $applicant->address_ktp,
                'ADDRESS2' => $applicant->address_domisili,
                'NRIC' => $applicant->nik,
                'PHONE' => $applicant->phone_number,
                'MOBILE_PHONE' => $applicant->phone_number,
                'EMAIL' => $applicant->email ?? $applicant->user?->email,
                'HEIGHT' => (string) ($applicant->height ?? ''),
                'WEIGHT' => (string) ($applicant->weight ?? ''),
                'MEDICAL_AWARE' => $applicant->medical_history,
                'STATUSAPP' => 'ACCEPTED',
                'IS_ACTIVE' => '1',
                'CREATEDBY' => auth()->user()?->email ?? 'SYSTEM',
                'USER_INPUT' => auth()->user()?->name ?? 'Admin',
            ]
        );
    }

    /**
     * Sync THRMAppFamily.
     */
    protected function syncFamilyData(Applicant $applicant, string $applicantId): void
    {
        ThrmAppFamily::where('APPLICANT_ID', $applicantId)->delete();

        foreach ($applicant->families as $family) {
            ThrmAppFamily::create([
                'APPLICANT_ID' => $applicantId,
                'APPFAMILY_NAME' => $family->name,
                'APPFAMILY_BIRTHPLACE' => $family->place_of_birth,
                'APPFAMILY_DOB' => $family->date_of_birth ? date('Y-m-d H:i:s', strtotime($family->date_of_birth)) : null,
                'APPFAMILY_LASTEDUCATION' => $family->education,
                'APPFAMILY_PHONE' => $family->phone_number,
                'APPFAMILY_OCCUPATION' => $family->work,
                'APPFAMILY_RELATIONSHIP2' => $family->relationship,
                'ALIVE_STATUS' => 1,
            ]);
        }
    }

    /**
     * Sync THRMAppEducation.
     */
    protected function syncEducationData(Applicant $applicant, string $applicantId): void
    {
        ThrmAppEducation::where('APPLICANT_ID', $applicantId)->delete();

        foreach ($applicant->educations as $education) {
            ThrmAppEducation::create([
                'APPLICANT_ID' => $applicantId,
                'EDU_NAME' => $education->institution_name,
                'MAJOR' => $education->major,
                'GPA' => $education->gpa ? (float) $education->gpa : null,
                'START_YEAR' => $education->entry_year ? (int) $education->entry_year : null,
                'END_YEAR' => $education->graduation_year ? (int) $education->graduation_year : null,
                'SPECIALIZATION' => $education->degree_level,
                'IS_DEFAULT' => 1,
            ]);
        }
    }

    /**
     * Sync THRMAppJobExp.
     */
    protected function syncJobExpData(Applicant $applicant, string $applicantId): void
    {
        ThrmAppJobExp::where('APPLICANT_ID', $applicantId)->delete();

        foreach ($applicant->workExperiences as $work) {
            $startYear = $work->start_date ? (int) date('Y', strtotime($work->start_date)) : null;
            $startMonth = $work->start_date ? (int) date('n', strtotime($work->start_date)) : null;
            $endYear = $work->end_date ? (int) date('Y', strtotime($work->end_date)) : null;
            $endMonth = $work->end_date ? (int) date('n', strtotime($work->end_date)) : null;

            ThrmAppJobExp::create([
                'APPLICANT_ID' => $applicantId,
                'COMPANY_NAME' => $work->company_name,
                'JOB_POSITION' => $work->position,
                'LAST_SALARY' => $work->salary ? (float) $work->salary : null,
                'START_YEAR' => $startYear,
                'START_MONTH' => $startMonth,
                'END_YEAR' => $endYear,
                'END_MONTH' => $endMonth,
                'FACILITIES' => $work->facility,
                'TERMINATION_REASON' => $work->reason_for_leaving,
                'SUPERIOR_NAME' => $work->reference_name,
            ]);
        }
    }

    /**
     * Sync THRMAPPCOURSE.
     */
    protected function syncCourseData(Applicant $applicant, string $applicantId): void
    {
        ThrmAppCourse::where('APPLICANT_ID', $applicantId)->delete();

        foreach ($applicant->trainings as $training) {
            $year = $training->finished ? (int) date('Y', strtotime($training->finished)) : null;

            ThrmAppCourse::create([
                'APPLICANT_ID' => $applicantId,
                'COURSE_NAME' => $training->training_name,
                'COURSE_INSTITUTION' => $training->organizer,
                'PERIOD_TO' => $year,
            ]);
        }
    }

    /**
     * Sync THRMAPPHISTORY.
     */
    protected function syncApplicationHistory(Application $application, string $applicantId, array $extraData): void
    {
        $application->loadMissing('job');

        ThrmAppHistory::create([
            'APPLICANT_ID' => $applicantId,
            'REQUEST_CODE' => (string) ($application->job?->id ?? ''),
            'APPLIED_JOBTITLE' => (string) ($application->job?->title ?? ''),
            'APPLIED_DATE' => $application->created_at ?? now(),
            'APPSTS' => 1, // 1: Accepted
            'REMARK' => 'Accepted on '.now()->toDateTimeString().' - Address: '.($extraData['work_address'] ?? '-'),
        ]);
    }

    /**
     * Map marital status to integer code.
     */
    protected function mapMaritalStatus(?string $status): ?int
    {
        return match (strtolower((string) $status)) {
            'single' => 1,
            'married' => 2,
            'divorced' => 3,
            'widowed' => 4,
            default => null,
        };
    }
}
