<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement('SET SESSION innodb_strict_mode = 0');
        }

        if (Schema::hasTable('applicants') && ! Schema::hasColumn('applicants', 'postal_code_ktp')) {
            Schema::table('applicants', function (Blueprint $table) {
                $table->string('postal_code_ktp', 10)->nullable()->after('address_ktp');
                $table->string('postal_code_domisili', 10)->nullable()->after('address_domisili');
                $table->string('emergency_contact_name')->nullable()->after('postal_code_domisili');
                $table->string('emergency_contact_relationship')->nullable()->after('emergency_contact_name');
                $table->string('emergency_contact_phone')->nullable()->after('emergency_contact_relationship');
                $table->date('marital_date')->nullable()->after('marital_status');
            });
        }

        if (Schema::hasTable('applicant_work_expriences') && ! Schema::hasColumn('applicant_work_expriences', 'company_phone')) {
            Schema::table('applicant_work_expriences', function (Blueprint $table) {
                $table->string('company_phone')->nullable()->after('company_name');
                $table->string('reference_position')->nullable()->after('reference_name');
                $table->string('reference_phone')->nullable()->after('reference_position');
            });
        }

        Schema::create('thrm_app_personal_data', function (Blueprint $table) {
            $table->engine = 'InnoDB ROW_FORMAT=DYNAMIC';

            $table->string('APPLICANT_ID', 50)->primary();
            $table->string('FIRST_NAME', 100)->nullable();
            $table->string('MIDDLE_NAME', 100)->nullable();
            $table->string('LAST_NAME', 100)->nullable();
            $table->integer('GENDER')->nullable();
            $table->string('RELIGION_ID', 50)->nullable();
            $table->string('BIRTH_PLACE', 100)->nullable();
            $table->dateTime('DATE_OF_BIRTH')->nullable();
            $table->integer('MARITAL_STATUS')->nullable();
            $table->text('ADDRESS1')->nullable();
            $table->string('STATE1', 100)->nullable();
            $table->string('COUNTRY1', 100)->nullable();
            $table->string('CITY1', 100)->nullable();
            $table->string('ZIPCODE1', 20)->nullable();
            $table->text('ADDRESS2')->nullable();
            $table->string('STATE2', 100)->nullable();
            $table->string('COUNTRY2', 100)->nullable();
            $table->string('CITY2', 100)->nullable();
            $table->string('ZIPCODE2', 20)->nullable();
            $table->string('NRIC', 50)->nullable();
            $table->string('PHONE', 50)->nullable();
            $table->string('MOBILE_PHONE', 50)->nullable();
            $table->string('EMAIL', 100)->nullable();
            $table->string('HEIGHT', 20)->nullable();
            $table->string('WEIGHT', 20)->nullable();
            $table->string('BLOOD_TYPE', 10)->nullable();
            $table->string('ID_CARD', 100)->nullable();
            $table->dateTime('ID_EXPIRY')->nullable();
            $table->string('ID_ISSUED', 100)->nullable();
            $table->string('IMAGE_FILE', 255)->nullable();
            $table->text('MEDICAL_AWARE')->nullable();
            $table->string('NATIONALITY_ID', 50)->nullable();
            $table->string('NPWP', 50)->nullable();
            $table->string('BPJS', 100)->nullable();
            $table->string('FASKES', 100)->nullable();
            $table->string('STATUSAPP', 50)->nullable();
            $table->string('IS_ACTIVE', 20)->nullable();
            $table->string('EXPECTED_POSITION', 100)->nullable();
            $table->decimal('EXPECTED_SALARY', 15, 2)->nullable();
            $table->string('OFFERED_SALARY', 100)->nullable();
            $table->string('DEALT_SALARY', 100)->nullable();
            $table->dateTime('HIRE_DATE')->nullable();
            $table->string('WORKLOCATION_CODE', 50)->nullable();
            $table->string('BANK_CODE', 50)->nullable();
            $table->string('BANK_ACCOUNT', 50)->nullable();
            $table->string('ACCOUNT_NAME', 150)->nullable();
            $table->string('EMERGENCY_CONTACT_NAME', 150)->nullable();
            $table->string('EMERGENCY_CONTACT_RELATIONSHIP', 100)->nullable();
            $table->string('EMERGENCY_CONTACT_PHONE', 50)->nullable();
            $table->text('EMERGENCY_CONTACT_ADDRESS')->nullable();
            $table->string('REFERRAL_EMPID', 50)->nullable();
            $table->string('REFERRAL_NAME', 150)->nullable();
            $table->string('CV_FILE', 255)->nullable();
            $table->string('CV_DOCFILE', 255)->nullable();
            $table->string('USER_INPUT', 100)->nullable();
            $table->string('CREATEDBY', 100)->nullable();
            $table->string('UPDATEDBY', 100)->nullable();
            $table->text('EXTRA_DATA')->nullable();
            $table->timestamps();
        });

        Schema::create('thrm_app_job_exp', function (Blueprint $table) {
            $table->engine = 'InnoDB ROW_FORMAT=DYNAMIC';

            $table->id('APPJOBEXP_ID');
            $table->string('JOB_POSITION', 255)->nullable();
            $table->string('COMPANY_NAME', 255)->nullable();
            $table->string('COMPANY_ADDR', 255)->nullable();
            $table->double('LAST_SALARY')->nullable();
            $table->string('CURRENCY_ID', 50)->nullable();
            $table->integer('START_MONTH')->nullable();
            $table->integer('END_MONTH')->nullable();
            $table->integer('START_YEAR')->nullable();
            $table->integer('END_YEAR')->nullable();
            $table->string('FACILITIES', 50)->nullable();
            $table->string('TERMINATION_REASON', 100)->nullable();
            $table->text('JOB_DESC')->nullable();
            $table->string('SUPERIOR_NAME', 50)->nullable();
            $table->string('SUPERIOR_POSITION', 255)->nullable();
            $table->string('APPLICANT_ID', 50)->nullable();
            $table->string('TYPE_SALARY', 50)->nullable();
            $table->string('BENEFIT', 255)->nullable();
            $table->string('GROSS_NETTO', 100)->nullable();
            $table->string('MASAKERJA', 100)->nullable();
            $table->string('START_CURRENCY_ID', 10)->nullable();
            $table->double('START_SALARY')->nullable();
            $table->string('START_TYPE_SALARY', 10)->nullable();
            $table->integer('LOB_ID')->nullable();
            $table->string('PHONE', 50)->nullable();
            $table->string('ACHIEVEMENT', 100)->nullable();
            $table->string('OTHER_TR', 255)->nullable();
            $table->string('COMPANY_PHONE', 50)->nullable();
            $table->integer('RESIGNCAUSE_ID')->nullable();
            $table->string('OTHER_TR_EN', 50)->nullable();
            $table->string('OTHER_TR_ID', 50)->nullable();
            $table->string('OTHER_TR_DE', 50)->nullable();
            $table->string('OTHER_TR_CH', 50)->nullable();
            $table->string('LOB', 50)->nullable();
            $table->string('OTHER_TR_TH', 50)->nullable();
            $table->string('OTHER_TR_MY', 50)->nullable();
            $table->string('OTHER_TR_VN', 100)->nullable();
            $table->timestamps();
        });

        Schema::create('thrm_app_org_act', function (Blueprint $table) {
            $table->id('APPORGACT_ID');
            $table->string('APPLICANT_ID', 50)->nullable();
            $table->string('ORG_NAME', 255)->nullable();
            $table->string('ORG_TYPE', 50)->nullable();
            $table->integer('YEAR')->nullable();
            $table->string('POSITION', 255)->nullable();
            $table->integer('START_YEAR')->nullable();
            $table->integer('END_YEAR')->nullable();
            $table->string('COUNTRY_NAME', 50)->nullable();
            $table->string('STATE_NAME', 50)->nullable();
            $table->string('CITY_NAME', 50)->nullable();
            $table->string('POSITION_DESC', 255)->nullable();
            $table->timestamps();
        });

        Schema::create('thrm_app_language', function (Blueprint $table) {
            $table->id('APPLANGUAGE_ID');
            $table->integer('SPEAKING')->nullable();
            $table->integer('WRITING')->nullable();
            $table->integer('READING')->nullable();
            $table->text('REMARK')->nullable();
            $table->integer('LANGUAGE_ID')->nullable();
            $table->string('APPLICANT_ID', 50)->nullable();
            $table->integer('LISTEN')->nullable();
            $table->string('LANGUAGE_DESC', 255)->nullable();
            $table->tinyInteger('LISTENING')->nullable();
            $table->timestamps();
        });

        Schema::create('thrm_app_family', function (Blueprint $table) {
            $table->id('APPFAMILY_ID');
            $table->text('APPFAMILY_NAME')->nullable();
            $table->integer('APPFAMILY_RELATIONSHIP_ID')->nullable();
            $table->text('APPFAMILY_BIRTHPLACE')->nullable();
            $table->dateTime('APPFAMILY_DOB')->nullable();
            $table->integer('APPFAMILY_DEPENDENTSTS')->nullable();
            $table->text('APPFAMILY_OCCUPATION')->nullable();
            $table->string('APPLICANT_ID', 50)->nullable();
            $table->string('APPFAMILY_GENDER', 50)->nullable();
            $table->string('APPFAMILY_PHONE', 100)->nullable();
            $table->string('APPFAMILY_LASTEDUCATION', 50)->nullable();
            $table->integer('ALIVE_STATUS')->nullable();
            $table->text('APPFAMILY_ADDRESS')->nullable();
            $table->string('APPFAMILY_RELATIONSHIP2', 255)->nullable();
            $table->string('APPFAMILY_MARITAL_STATUS', 255)->nullable();
            $table->integer('CHILD_ORDER')->nullable();
            $table->string('APPSCHOOL_NAME', 100)->nullable();
            $table->integer('ASTRAEMP')->nullable();
            $table->string('COMPNAME', 255)->nullable();
            $table->timestamps();
        });

        Schema::create('thrm_app_skill', function (Blueprint $table) {
            $table->string('APPLICANT_ID', 20)->nullable();
            $table->string('SKILL_CODE', 10)->nullable();
            $table->string('RATING_CODE', 20)->nullable();
            $table->id();
            $table->timestamps();
        });

        Schema::create('thrm_app_education', function (Blueprint $table) {
            $table->id('APPEDUCATION_ID');
            $table->integer('EDUTYPE_ID')->nullable();
            $table->string('EDU_NAME', 255)->nullable();
            $table->string('MAJOR', 255)->nullable();
            $table->integer('START_YEAR')->nullable();
            $table->integer('END_YEAR')->nullable();
            $table->string('COUNTRY', 255)->nullable();
            $table->double('GPA')->nullable();
            $table->string('SPECIALIZATION', 255)->nullable();
            $table->string('SKILL_ABILITY', 255)->nullable();
            $table->string('INTEREST_SUBJECT', 255)->nullable();
            $table->string('DESERTATION_TITLE', 255)->nullable();
            $table->string('APPLICANT_ID', 50)->nullable();
            $table->integer('IS_DEFAULT')->nullable();
            $table->string('CERTIFICATE_NO', 255)->nullable();
            $table->dateTime('CERTIFICATE_DATE')->nullable();
            $table->string('FACULTY', 255)->nullable();
            $table->string('STATE', 225)->nullable();
            $table->string('CITY', 225)->nullable();
            $table->string('GPASCALE', 10)->nullable();
            $table->string('DOCPATH', 100)->nullable();
            $table->string('FILEPATH', 100)->nullable();
            $table->timestamps();
        });

        Schema::create('thrm_app_course', function (Blueprint $table) {
            $table->id('APPCOURSE_ID');
            $table->string('COURSE_NAME', 255)->nullable();
            $table->string('COURSE_INSTITUTION', 255)->nullable();
            $table->integer('PERIOD_FR')->nullable();
            $table->integer('PERIOD_TO')->nullable();
            $table->string('APPLICANT_ID', 50)->nullable();
            $table->string('CITY', 255)->nullable();
            $table->string('CERTIFICATE', 1)->nullable();
            $table->integer('MONTHPERIOD_FR')->nullable();
            $table->integer('MONTHPERIOD_TO')->nullable();
            $table->timestamps();
        });

        Schema::create('thrm_app_history', function (Blueprint $table) {
            $table->engine = 'InnoDB ROW_FORMAT=DYNAMIC';

            $table->id('APPHISTORY_ID');
            $table->string('APPLICANT_ID', 50)->nullable();
            $table->integer('MEDIUM_ID')->nullable();
            $table->dateTime('APPLIED_DATE')->nullable();
            $table->decimal('EXPECTED_SALARY', 15, 2)->nullable();
            $table->string('CURRENCY_ID', 10)->nullable();
            $table->string('PAYMENTTYPECODE', 50)->nullable();
            $table->integer('APPSTS')->nullable();
            $table->text('REMARK')->nullable();
            $table->string('REQUEST_CODE', 50)->nullable();
            $table->integer('APPLIED_POSITION')->nullable();
            $table->string('APPLIED_GRADE', 10)->nullable();
            $table->string('EMP_ID', 20)->nullable();
            $table->decimal('OFFERED_SALARY', 15, 2)->nullable();
            $table->decimal('DEALT_SALARY', 15, 2)->nullable();
            $table->decimal('EXPECTED_POSITION', 15, 2)->nullable();
            $table->string('MEDIUM_CODE', 20)->nullable();
            $table->dateTime('OFFEREDSALARY_DATE')->nullable();
            $table->dateTime('DEALTSALARY_DATE')->nullable();
            $table->string('OFFEREDSALARY_REVIEWER', 50)->nullable();
            $table->string('DEALTSALARY_REVIEWER', 50)->nullable();
            $table->string('APPLIED_JOBTITLE', 255)->nullable();
            $table->string('EXPECTED_JOBTITLE', 255)->nullable();
            $table->integer('COMPANY_ID')->nullable();
            $table->decimal('CURRENT_SALARY', 15, 2)->nullable();
            $table->dateTime('HIRE_DATE')->nullable();
            $table->string('EXPECTED_BENEFIT', 255)->nullable();
            $table->integer('COMPLETETEST')->nullable();
            $table->string('REPLACED_EMPID', 20)->nullable();
            $table->string('CV_DOCFILE', 255)->nullable();
            $table->string('CREATEDBY', 255)->nullable();
            $table->dateTime('CREATEDDATE')->nullable();
            $table->string('UPDATEDBY', 255)->nullable();
            $table->dateTime('UPDATEDDATE')->nullable();
            $table->string('APPLICANT_FLAG', 50)->nullable();
            $table->string('LETTER_NO', 255)->nullable();
            $table->string('REFERRAL_EMPID', 50)->nullable();
            $table->string('REFERRAL_NAME', 150)->nullable();
            $table->integer('REFERRAL_URGENCY')->nullable();
            $table->string('APP_READY', 200)->nullable();
            $table->string('SENDTOCLIENT', 1)->nullable();
            $table->string('Confirm_Status', 5)->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thrm_app_history');
        Schema::dropIfExists('thrm_app_course');
        Schema::dropIfExists('thrm_app_education');
        Schema::dropIfExists('thrm_app_skill');
        Schema::dropIfExists('thrm_app_family');
        Schema::dropIfExists('thrm_app_language');
        Schema::dropIfExists('thrm_app_org_act');
        Schema::dropIfExists('thrm_app_job_exp');
        Schema::dropIfExists('thrm_app_personal_data');
    }
};
