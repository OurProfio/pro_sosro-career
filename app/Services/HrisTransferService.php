<?php

namespace App\Services;

use App\Models\Applicant;
use App\Models\ApplicantFamily;
use App\Models\Application;
use App\Models\Hris\ThrmAppCourse;
use App\Models\Hris\ThrmAppEducation;
use App\Models\Hris\ThrmAppFamily;
use App\Models\Hris\ThrmAppHistory;
use App\Models\Hris\ThrmAppJobExp;
use App\Models\Hris\ThrmAppPersonalData;
use Database\Seeders\ThrmListFacultySeeder;
use Database\Seeders\ThrmListMajorSeeder;
use Database\Seeders\ThrmListSchoolSeeder;
use Illuminate\Support\Facades\DB;
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
            'expectation',
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
        $this->syncApplicationHistory($application, $applicant, $applicantId, $extraData);

        Log::info("Applicant ID {$applicant->id} successfully transferred to HRIS tables with APPLICANT_ID: {$applicantId}");

        return $personalData;
    }

    /**
     * Generate a unique and formatted APPLICANT_ID for HRIS.
     */
    protected function generateApplicantId(Applicant $applicant): string
    {
        $yearMonth = date('Ym');
        $id = str_pad((string) $applicant->id, 5, '0', STR_PAD_LEFT);

        return "APL{$yearMonth}{$id}";
    }

    /**
     * Sync THRMAPPPERSONALDATA.
     */
    protected function syncPersonalData(Applicant $applicant, string $applicantId, array $extraData): ThrmAppPersonalData
    {
        $name = $this->splitName($applicant->name ?? '');

        $genderVal = match (strtolower((string) $applicant->gender)) {
            'l' => 1,
            'p' => 0,
            default => null,
        };

        $requestCode = ! empty($extraData['request_code'])
            ? strtoupper(trim((string) $extraData['request_code']))
            : null;

        $biodataCompletedAt = $applicant->updated_at ?? $applicant->created_at ?? now();

        return ThrmAppPersonalData::updateOrCreate(
            ['APPLICANT_ID' => $applicantId],
            [
                'FIRST_NAME' => $name['first'],
                'MIDDLE_NAME' => $name['middle'],
                'LAST_NAME' => $name['last'],
                'GENDER' => $genderVal,
                'REQUEST_CODE' => $requestCode,
                'RELIGION_ID' => $applicant->religion,
                'BIRTH_PLACE' => $applicant->place_of_birth,
                'DATE_OF_BIRTH' => $applicant->date_of_birth ? date('Y-m-d H:i:s', strtotime($applicant->date_of_birth)) : null,
                'MARITAL_STATUS' => $this->mapMaritalStatus($applicant->marital_status),
                'ADDRESS1' => $applicant->address_ktp,
                'ZIPCODE1' => $applicant->postal_code_ktp,
                'COUNTRY1' => 'ID',
                'ADDRESS2' => $applicant->address_domisili,
                'ZIPCODE2' => $applicant->postal_code_domisili,
                'COUNTRY2' => 'ID',
                'NATIONALITY_ID' => 'ID',
                'COMPANY_ID' => 73,
                'NRIC' => $applicant->nik,
                'PHONE' => $applicant->phone_number,
                'MOBILE_PHONE' => $applicant->phone_number,
                'EMAIL' => $applicant->user?->email ?? $applicant->email,
                'HEIGHT' => (string) ($applicant->height ?? ''),
                'WEIGHT' => (string) ($applicant->weight ?? ''),
                'BLOOD_TYPE' => $applicant->blood_type,
                'MEDICAL_AWARE' => $applicant->medical_history,
                'EMERGENCY_CONTACT_NAME' => $applicant->emergency_contact_name,
                'EMERGENCY_CONTACT_RELATIONSHIP' => $applicant->emergency_contact_relationship,
                'EMERGENCY_CONTACT_PHONE' => $applicant->emergency_contact_phone,
                'EMERGENCY_CONTACT_ADDRESS' => $applicant->emergency_contact_address,
                'EMERGENCY_CONTACT_STATE' => $applicant->emergency_contact_state,
                'EMERGENCY_CONTACT_CITY' => $applicant->emergency_contact_city,
                'EMERGENCY_CONTACT_COUNTRY' => filled($applicant->emergency_contact_address) ? 'ID' : null,
                'EXPECTED_SALARY' => $applicant->expectation?->salary_expectation,
                'CURRENCY_ID' => 'IDR',
                'REFERRAL_NAME' => $applicant->expectation?->reference_by,
                'STATUSAPP' => 'A',
                'MEDIUM_ID' => 63,
                'MEDIUM_CODE' => 'IWT',
                'APPLIED_DATE' => now(),
                'IS_INTERNAL' => 'N',
                'IS_ACTIVE' => '1',
                'CREATEDDATE' => $biodataCompletedAt,
                'UPDATEDDATE' => $biodataCompletedAt,
                'CREATEDBY' => 'SYSTEM',
                'UPDATEDBY' => 'SYSTEM',
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
            $familyGender = match (strtolower((string) $family->gender)) {
                'l' => '1',
                'p' => '0',
                default => null,
            };

            $relationshipId = $family->relationship_id
                ?? ApplicantFamily::resolveRelationshipId($family->relationship, $family->gender);

            $edutypeId = $family->edutype_id
                ?? ApplicantFamily::resolveEdutypeId($family->education);

            $familyMaritalStatus = in_array(
                strtolower((string) $family->relationship),
                ['father', 'mother', 'spouse', 'father_in_law', 'mother_in_law'],
                true
            ) ? '1' : null;

            ThrmAppFamily::create([
                'APPLICANT_ID' => $applicantId,
                'APPFAMILY_NAME' => $family->name,
                'APPFAMILY_RELATIONSHIP_ID' => $relationshipId,
                'APPFAMILY_GENDER' => $familyGender,
                'APPFAMILY_BIRTHPLACE' => $family->place_of_birth,
                'APPFAMILY_DOB' => $family->date_of_birth ? date('Y-m-d H:i:s', strtotime($family->date_of_birth)) : null,
                'APPFAMILY_DEPENDENTSTS' => 0,
                'APPFAMILY_LASTEDUCATION' => $edutypeId !== null ? (string) $edutypeId : $family->education,
                'APPFAMILY_PHONE' => $family->phone_number,
                'APPFAMILY_OCCUPATION' => $family->work,
                'APPFAMILY_ADDRESS' => $family->address,
                'APPFAMILY_RELATIONSHIP2' => '',
                'APPFAMILY_MARITAL_STATUS' => $familyMaritalStatus,
                'ALIVE_STATUS' => $family->status === 'deceased' ? 0 : 1,
            ]);
        }
    }

    /**
     * Sync THRMAppEducation.
     */
    protected function syncEducationData(Applicant $applicant, string $applicantId): void
    {
        ThrmAppEducation::where('APPLICANT_ID', $applicantId)->delete();

        foreach ($applicant->educations->values() as $index => $education) {
            $isHighSchool = (bool) preg_match('/\b(SMA|SMK|STM)\b/i', (string) ($education->degree_level ?? ''));
            $gpaValue = $education->gpa !== null ? (float) $education->gpa : null;
            $gpaScale = $gpaValue !== null
                ? ($isHighSchool || $gpaValue > 4.0 ? '100' : '4')
                : null;

            $eduName = (int) $education->school_id === ThrmListSchoolSeeder::OTHER_EDU_ID
                ? 'Other'
                : $education->institution_name;

            $facultyName = $isHighSchool
                ? null
                : ((int) $education->faculty_id === ThrmListFacultySeeder::OTHER_FACULTY_ID
                    ? 'Others'
                    : $education->faculty);

            $majorName = (int) $education->major_id === ThrmListMajorSeeder::OTHER_MAJOR_ID
                ? 'Other'
                : $education->major;

            ThrmAppEducation::create([
                'APPLICANT_ID' => $applicantId,
                'EDUTYPE_ID' => $education->edutype_id,
                'EDU_NAME' => $eduName,
                'FACULTY' => $facultyName,
                'STATE' => $education->state,
                'COUNTRY' => 'ID',
                'MAJOR' => $majorName,
                'GPA' => $gpaValue,
                'GPASCALE' => $gpaScale,
                'START_YEAR' => $education->entry_year ? (int) $education->entry_year : null,
                'END_YEAR' => $education->graduation_year ? (int) $education->graduation_year : null,
                'SPECIALIZATION' => null,
                'IS_DEFAULT' => $index === 0 ? 1 : 0,
            ]);
        }
    }

    /**
     * Sync THRMAppJobExp.
     */
    protected function syncJobExpData(Applicant $applicant, string $applicantId): void
    {
        ThrmAppJobExp::where('APPLICANT_ID', $applicantId)->delete();

        $lobNames = DB::table('t_line_of_business')->pluck('LOB_NAME', 'LOB_ID');

        foreach ($applicant->workExperiences as $work) {
            $startYear = $work->start_date ? (int) date('Y', strtotime($work->start_date)) : null;
            $startMonth = $work->start_date ? (int) date('n', strtotime($work->start_date)) : null;
            $endYear = $work->end_date ? (int) date('Y', strtotime($work->end_date)) : null;
            $endMonth = $work->end_date ? (int) date('n', strtotime($work->end_date)) : null;

            $salaryValue = $work->salary ? (float) $work->salary : null;
            $typeSalary = ($salaryValue !== null && $salaryValue > 0) ? '6' : '0';
            $lobId = $work->lob_id ? (int) $work->lob_id : null;
            $lobName = $lobId !== null ? ($lobNames[$lobId] ?? null) : null;

            ThrmAppJobExp::create([
                'APPLICANT_ID' => $applicantId,
                'COMPANY_NAME' => $work->company_name,
                'COMPANY_ADDR' => $work->company_address,
                'COMPANY_PHONE' => $work->company_phone,
                'JOB_POSITION' => $work->position,
                'JOB_DESC' => $work->job_desc,
                'START_SALARY' => $salaryValue ?? 0,
                'LAST_SALARY' => $salaryValue ?? 0,
                'TYPE_SALARY' => $typeSalary,
                'START_TYPE_SALARY' => $typeSalary,
                'CURRENCY_ID' => 'IDR',
                'START_CURRENCY_ID' => 'IDR',
                'GROSS_NETTO' => $work->gross_netto,
                'LOB_ID' => $lobId,
                'LOB' => $lobName,
                'START_YEAR' => $startYear,
                'START_MONTH' => $startMonth,
                'END_YEAR' => $endYear,
                'END_MONTH' => $endMonth,
                'FACILITIES' => $work->facility,
                'TERMINATION_REASON' => $work->reason_for_leaving,
                'SUPERIOR_NAME' => $work->reference_name,
                'SUPERIOR_POSITION' => $work->reference_position,
                'PHONE' => $work->reference_phone,
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
            $month = $training->finished ? (int) date('n', strtotime($training->finished)) : null;

            ThrmAppCourse::create([
                'APPLICANT_ID' => $applicantId,
                'COURSE_NAME' => $training->training_name,
                'COURSE_INSTITUTION' => $training->organizer,
                'PERIOD_TO' => $year,
                'MONTHPERIOD_TO' => $month,
            ]);
        }
    }

    /**
     * Sync THRMAPPHISTORY.
     */
    protected function syncApplicationHistory(Application $application, Applicant $applicant, string $applicantId, array $extraData): void
    {
        $application->loadMissing('job');

        $now = now();

        $requestCode = ! empty($extraData['request_code'])
            ? strtoupper(trim((string) $extraData['request_code']))
            : (string) ($application->job?->id ?? '');

        $positionId = isset($extraData['position_id']) && $extraData['position_id'] !== ''
            ? (int) $extraData['position_id']
            : null;
        $positionName = $positionId !== null
            ? DB::table('thrm_position')->where('POSITION_ID', $positionId)->value('POSITION_NAME_EN')
            : null;
        $jobTitle = $positionName ?: (string) ($application->job?->title ?? '');

        $currentSalary = $applicant->workExperiences->first()?->salary ?? 0;

        ThrmAppHistory::create([
            'APPLICANT_ID' => $applicantId,
            'REQUEST_CODE' => $requestCode,
            'MEDIUM_ID' => 63,
            'MEDIUM_CODE' => 'IWT',
            'APPLIED_POSITION' => $positionId,
            'EXPECTED_POSITION' => $positionId,
            'APPLIED_JOBTITLE' => $jobTitle,
            'EXPECTED_JOBTITLE' => $jobTitle,
            'APPLIED_DATE' => $application->created_at ?? $now,
            'EXPECTED_SALARY' => $applicant->expectation?->salary_expectation ?? 0,
            'CURRENT_SALARY' => $currentSalary,
            'CURRENCY_ID' => 'IDR',
            'PAYMENTTYPECODE' => 'MONTHLY',
            'COMPANY_ID' => 73,
            'APPSTS' => 3,
            'COMPLETETEST' => 1,
            'APPLICANT_FLAG' => null,
            'CREATEDBY' => 'SYSTEM',
            'CREATEDDATE' => $now,
            'UPDATEDBY' => 'SYSTEM',
            'UPDATEDDATE' => $now,
            'REMARK' => 'Accepted on '.$now->toDateTimeString().' - Address: '.($extraData['work_address'] ?? '-'),
        ]);
    }

    /**
     * Map marital status to integer code.
     */
    protected function mapMaritalStatus(?string $status): ?int
    {
        return match (strtolower((string) $status)) {
            'single' => 0,
            'married' => 1,
            'divorced' => 2,
            'widowed' => 3,
            default => null,
        };
    }

    /**
     * Split full name into FIRST_NAME, MIDDLE_NAME, and LAST_NAME according to standard conventions.
     *
     * @return array{first: string, middle: ?string, last: ?string}
     */
    public function splitName(string $fullName): array
    {
        $parts = preg_split('/\s+/', trim($fullName), -1, PREG_SPLIT_NO_EMPTY) ?: [];
        $count = count($parts);

        if ($count === 0) {
            return [
                'first' => '',
                'middle' => null,
                'last' => null,
            ];
        }

        if ($count === 1) {
            return [
                'first' => $parts[0],
                'middle' => null,
                'last' => null,
            ];
        }

        if ($count === 2) {
            return [
                'first' => $parts[0],
                'middle' => null,
                'last' => $parts[1],
            ];
        }

        $first = array_shift($parts);
        $last = array_pop($parts);
        $middle = implode(' ', $parts);

        return [
            'first' => $first,
            'middle' => $middle ?: null,
            'last' => $last,
        ];
    }
}
