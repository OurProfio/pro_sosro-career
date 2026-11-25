<?php

namespace Database\Seeders;

use App\Models\Hris\ThrmAppEducation;
use App\Models\Hris\ThrmAppFamily;
use App\Models\Hris\ThrmAppHistory;
use App\Models\Hris\ThrmAppJobExp;
use App\Models\Hris\ThrmAppPersonalData;
use Illuminate\Database\Seeder;

class ThrmAyleenSeeder extends Seeder
{
    public const APPLICANT_ID = 'APL20261112526';

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ThrmAppPersonalData::updateOrCreate(
            ['APPLICANT_ID' => self::APPLICANT_ID],
            [
                'FIRST_NAME' => 'AYLEEN',
                'MIDDLE_NAME' => 'GEMILA',
                'LAST_NAME' => 'APRILIA',
                'GENDER' => 0,
                'RELIGION_ID' => 'Islam',
                'BIRTH_PLACE' => 'JAKARTA',
                'DATE_OF_BIRTH' => '2005-04-21 00:00:00',
                'MARITAL_STATUS' => 0,
                'ADDRESS1' => 'BUKIT JATIWARINGIN INDAH RESIDENCE KAV. 51 C',
                'NRIC' => '317025310990002',
                'PHONE' => '087860001374',
                'EMAIL' => 'ayleengemila@gmail.com',
                'NATIONALITY_ID' => 'ID',
                'COMPANY_ID' => 73,
                'UPDATEDDATE' => '2026-11-23 14:02:46',
                'UPDATEDBY' => 'DO231294',
                'CREATEDDATE' => '2026-11-23 14:02:46',
                'CREATEDBY' => 'DO231294',
                'STATUSAPP' => 'A',
                'EMERGENCY_CONTACT_NAME' => 'JASMINE OCTAVIA',
                'EMERGENCY_CONTACT_RELATIONSHIP' => '2',
                'EMERGENCY_CONTACT_PHONE' => '087860001374',
                'EMERGENCY_CONTACT_ADDRESS' => 'BUKIT JATIWARINGIN INDAH RESIDENCE KAV. 51 C',
                'EMERGENCY_CONTACT_STATE' => 'DKI Jakarta',
                'EMERGENCY_CONTACT_COUNTRY' => 'ID',
                'EMERGENCY_CONTACT_CITY' => 'Jakarta Utara',
                'IS_INTERNAL' => 'N',
                'APPLIED_DATE' => '2026-11-23 00:00:00',
            ]
        );

        ThrmAppFamily::updateOrCreate(
            ['APPFAMILY_ID' => 2641],
            [
                'APPLICANT_ID' => self::APPLICANT_ID,
                'APPFAMILY_NAME' => 'JASMINE OCTAVIA',
                'APPFAMILY_RELATIONSHIP_ID' => 2,
                'APPFAMILY_BIRTHPLACE' => 'Bandung',
                'APPFAMILY_DOB' => '1999-10-13 00:00:00',
                'APPFAMILY_DEPENDENTSTS' => 0,
                'APPFAMILY_OCCUPATION' => 'Emp',
                'APPFAMILY_GENDER' => '0',
                'APPFAMILY_PHONE' => '087860001374',
                'APPFAMILY_LASTEDUCATION' => '7',
                'ALIVE_STATUS' => 1,
                'APPFAMILY_ADDRESS' => 'BUKIT JATIWARINGIN INDAH RESIDENCE KAV. 51C',
                'APPFAMILY_RELATIONSHIP2' => '',
                'APPFAMILY_MARITAL_STATUS' => '1',
            ]
        );

        ThrmAppFamily::updateOrCreate(
            ['APPFAMILY_ID' => 2642],
            [
                'APPLICANT_ID' => self::APPLICANT_ID,
                'APPFAMILY_NAME' => 'FARIS APRILIO',
                'APPFAMILY_RELATIONSHIP_ID' => 1,
                'APPFAMILY_BIRTHPLACE' => 'Bandung',
                'APPFAMILY_DOB' => '1999-04-07 00:00:00',
                'APPFAMILY_DEPENDENTSTS' => 0,
                'APPFAMILY_OCCUPATION' => 'Emp',
                'APPFAMILY_GENDER' => '1',
                'APPFAMILY_PHONE' => '081290745897',
                'APPFAMILY_LASTEDUCATION' => '7',
                'ALIVE_STATUS' => 1,
                'APPFAMILY_ADDRESS' => 'BUKIT JATIWARINGIN INDAH RESIDENCE KAV. 51 C',
                'APPFAMILY_RELATIONSHIP2' => '',
                'APPFAMILY_MARITAL_STATUS' => '1',
            ]
        );

        ThrmAppEducation::updateOrCreate(
            ['APPEDUCATION_ID' => 1526],
            [
                'APPLICANT_ID' => self::APPLICANT_ID,
                'EDUTYPE_ID' => 7,
                'EDU_NAME' => 'Universitas Indonesia',
                'MAJOR' => 'Psikologi',
                'START_YEAR' => 2018,
                'END_YEAR' => 2022,
                'COUNTRY' => 'ID',
                'IS_DEFAULT' => 0,
                'FACULTY' => 'Psikologi',
                'STATE' => 'Depok',
                'CITY' => 'Other',
            ]
        );

        ThrmAppJobExp::updateOrCreate(
            ['APPJOBEXP_ID' => 1314],
            [
                'APPLICANT_ID' => self::APPLICANT_ID,
                'JOB_POSITION' => 'RECRUITMENT STAFF',
                'COMPANY_NAME' => 'GODREJ CONSUMER PRODUCTS INDONESIA',
                'COMPANY_ADDR' => 'KELAPA GADING',
                'LAST_SALARY' => 0,
                'CURRENCY_ID' => 'IDR',
                'START_MONTH' => 5,
                'END_MONTH' => 10,
                'START_YEAR' => 2026,
                'END_YEAR' => 2026,
                'TERMINATION_REASON' => '999',
                'JOB_DESC' => 'REKRUT',
                'SUPERIOR_NAME' => 'Sinar Sosro Gunung Slamat',
                'SUPERIOR_POSITION' => 'SHANNE',
                'TYPE_SALARY' => '1',
                'GROSS_NETTO' => 'Netto',
                'START_CURRENCY_ID' => 'IDR',
                'START_SALARY' => 0,
                'START_TYPE_SALARY' => '1',
                'LOB_ID' => 7,
                'PHONE' => '081241002778',
            ]
        );

        ThrmAppHistory::updateOrCreate(
            ['APPHISTORY_ID' => 33555],
            [
                'APPLICANT_ID' => self::APPLICANT_ID,
                'APPLIED_DATE' => '2026-11-23 00:00:00',
                'EXPECTED_SALARY' => 0,
                'CURRENCY_ID' => 'IDR',
                'PAYMENTTYPECODE' => 'MONTHLY',
                'APPSTS' => 3,
                'REQUEST_CODE' => 'RCR20261117235',
                'APPLIED_POSITION' => 42036,
                'EXPECTED_POSITION' => 42036,
                'MEDIUM_CODE' => '0',
                'APPLIED_JOBTITLE' => 'STF',
                'EXPECTED_JOBTITLE' => 'STF',
                'COMPANY_ID' => 73,
                'CURRENT_SALARY' => 0,
                'COMPLETETEST' => 1,
                'CREATEDBY' => 'DO231294',
                'CREATEDDATE' => '2026-11-23 14:02:46',
                'UPDATEDBY' => 'DO231294',
                'UPDATEDDATE' => '2026-11-23 14:02:46',
                'APPLICANT_FLAG' => null,
                'Confirm_Status' => null,
            ]
        );
    }
}
