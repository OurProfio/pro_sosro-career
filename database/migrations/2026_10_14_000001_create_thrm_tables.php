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
            $table->string('COUNTRY1', 50)->nullable();
            $table->string('CITY1', 100)->nullable();
            $table->string('ZIPCODE1', 20)->nullable();
            $table->text('ADDRESS2')->nullable();
            $table->string('STATE2', 100)->nullable();
            $table->string('COUNTRY2', 50)->nullable();
            $table->string('CITY2', 100)->nullable();
            $table->string('ZIPCODE2', 20)->nullable();
            $table->string('NRIC', 50)->nullable();
            $table->string('PHONE', 50)->nullable();
            $table->string('MOBILE_PHONE', 50)->nullable();
            $table->string('EMAIL', 100)->nullable();
            $table->text('INTEREST')->nullable();
            $table->text('SKILL')->nullable();
            $table->string('HEIGHT', 20)->nullable();
            $table->string('WEIGHT', 20)->nullable();
            $table->string('ID_CARD', 50)->nullable();
            $table->dateTime('ID_EXPIRY')->nullable();
            $table->string('ID_ISSUED', 50)->nullable();
            $table->text('IMAGE_FILE')->nullable();
            $table->text('MEDICAL_AWARE')->nullable();
            $table->text('REASON_HOSPITAL')->nullable();
            $table->string('TITLE', 50)->nullable();
            $table->string('FAX', 50)->nullable();
            $table->string('REQUEST_CODE', 50)->nullable();
            $table->text('PSYCOTEST')->nullable();
            $table->text('MEDICALTEST')->nullable();
            $table->string('NATIONALITY_ID', 20)->nullable();
            $table->string('APPSTEP_STATUS', 50)->nullable();
            $table->string('EXPECTED_POSITION', 100)->nullable();
            $table->integer('COMPANY_ID')->nullable();
            $table->text('OTHERS')->nullable();
            $table->string('SPECTACLED', 10)->nullable();
            $table->decimal('CURRENT_SALARY', 15, 2)->nullable();
            $table->text('TEST')->nullable();
            $table->string('NPWP', 50)->nullable();
            $table->text('EXPECTED_BENEFIT')->nullable();
            $table->dateTime('UPDATEDDATE')->nullable();
            $table->string('UPDATEDBY', 50)->nullable();
            $table->dateTime('CREATEDDATE')->nullable();
            $table->string('CREATEDBY', 50)->nullable();
            $table->string('BLOOD_TYPE', 10)->nullable();
            $table->string('DISABILITYCODE', 50)->nullable();
            $table->string('REFERRAL_EMPID', 50)->nullable();
            $table->string('REFERRAL_NAME', 100)->nullable();
            $table->string('REFERRAL_URGENCY', 50)->nullable();
            $table->string('EMP_ID', 50)->nullable();
            $table->string('STATUSAPP', 20)->nullable();
            $table->string('PHONE1', 50)->nullable();
            $table->string('PHONE2', 50)->nullable();
            $table->string('EMERGENCY_CONTACT_NAME', 100)->nullable();
            $table->string('EMERGENCY_CONTACT_RELATIONSHIP', 50)->nullable();
            $table->string('EMERGENCY_CONTACT_PHONE', 50)->nullable();
            $table->string('EMERGENCY_CONTACT_OTHER_PHONE', 50)->nullable();
            $table->text('EMERGENCY_CONTACT_ADDRESS')->nullable();
            $table->string('EMERGENCY_CONTACT_STATE', 100)->nullable();
            $table->string('EMERGENCY_CONTACT_COUNTRY', 50)->nullable();
            $table->string('EMERGENCY_CONTACT_CITY', 100)->nullable();
            $table->string('EMERGENCY_CONTACT_ZIPCODE', 20)->nullable();
            $table->string('EMERGENCY_CONTACT_RELATIONS2', 50)->nullable();
            $table->text('STRONG_POINT')->nullable();
            $table->text('WEAK_POINT')->nullable();
            $table->text('SPARE_TIME')->nullable();
            $table->text('REASON')->nullable();
            $table->dateTime('NRICDATE')->nullable();
            $table->string('IS_INTERNAL', 10)->nullable();
            $table->string('IS_ACTIVE', 10)->nullable();
            $table->string('IS_ONLINE', 10)->nullable();
            $table->text('WORKINTEREST')->nullable();
            $table->integer('MEDIUM_ID')->nullable();
            $table->dateTime('APPLIED_DATE')->nullable();
            $table->decimal('EXPECTED_SALARY', 15, 2)->nullable();
            $table->string('CURRENCY_ID', 10)->nullable();
            $table->integer('APPSTS')->nullable();
            $table->text('REMARK')->nullable();
            $table->string('PAYMENTTYPECODE', 50)->nullable();
            $table->string('APPLIED_POSITION', 50)->nullable();
            $table->string('APPLIED_GRADE', 20)->nullable();
            $table->string('OFFERED_SALARY', 50)->nullable();
            $table->string('DEALT_SALARY', 50)->nullable();
            $table->string('MEDIUM_CODE', 50)->nullable();
            $table->dateTime('OFFEREDSALARY_DATE')->nullable();
            $table->dateTime('DEALTSALARY_DATE')->nullable();
            $table->string('OFFEREDSALARY_REVIEWER', 50)->nullable();
            $table->string('DEALTSALARY_REVIEWER', 50)->nullable();
            $table->string('APPLIED_JOBTITLE', 100)->nullable();
            $table->string('EXPECTED_JOBTITLE', 100)->nullable();
            $table->string('EMPLOYMENT_STATUS', 50)->nullable();
            $table->string('OWN_HOUSE', 10)->nullable();
            $table->string('OWN_LAND', 10)->nullable();
            $table->string('OWN_CAR', 10)->nullable();
            $table->string('OWN_MOTORCYCLE', 10)->nullable();
            $table->string('USING_COMPANY_HOUSE', 10)->nullable();
            $table->string('USING_COMPANY_VEHICLE', 10)->nullable();
            $table->string('EMERG_CONTACT_NAME', 100)->nullable();
            $table->text('EMERG_CONTACT_ADDRESS')->nullable();
            $table->string('EMERG_CONTACT_PHONE', 50)->nullable();
            $table->string('EMERG_STATE', 50)->nullable();
            $table->string('EMERG_COUNTRY', 50)->nullable();
            $table->string('EMERG_CITY', 50)->nullable();
            $table->string('EMERG_ZIP_CODE', 20)->nullable();
            $table->integer('EMERG_RELATION_ID')->nullable();
            $table->string('DATA_BANK_ACTIVE', 10)->nullable();
            $table->dateTime('DATA_BANK_DATE')->nullable();
            $table->string('LAST_UPDATE_STATUS', 50)->nullable();
            $table->dateTime('EFECTIVE_DATE')->nullable();
            $table->string('LEVEL_APPLIED', 50)->nullable();
            $table->string('LEVEL_EXPECTED', 50)->nullable();
            $table->string('EMP_TYPE', 50)->nullable();
            $table->dateTime('PROB_DATE')->nullable();
            $table->string('LOCATION', 100)->nullable();
            $table->text('ADDRESS3')->nullable();
            $table->string('PHONE3', 50)->nullable();
            $table->string('STATE3', 50)->nullable();
            $table->string('COUNTRY3', 50)->nullable();
            $table->string('CITY3', 50)->nullable();
            $table->string('ZIPCODE3', 20)->nullable();
            $table->string('NICK_NAME', 50)->nullable();
            $table->dateTime('DATE_OF_MARRIED')->nullable();
            $table->string('PLACED_ANY', 10)->nullable();
            $table->string('OBEY_RULES', 10)->nullable();
            $table->string('EXPECTED_GRADE', 20)->nullable();
            $table->dateTime('END_CONTRACT_DATE')->nullable();
            $table->string('IS_CLOSED', 10)->nullable();
            $table->string('USER_INPUT', 50)->nullable();
            $table->string('FLAG', 10)->nullable();
            $table->string('VACANT', 10)->nullable();
            $table->dateTime('END_PROBATION')->nullable();
            $table->text('TUNJANGAN')->nullable();
            $table->string('FLAG_APPROVAL_LTR', 10)->nullable();
            $table->dateTime('HIRE_DATE')->nullable();
            $table->string('SALUTATION', 20)->nullable();
            $table->string('RACE_CODE', 20)->nullable();
            $table->string('DIALECT_CODE', 20)->nullable();
            $table->dateTime('DRIVINGDATE')->nullable();
            $table->text('RESIDENCE1')->nullable();
            $table->text('RESIDENCE2')->nullable();
            $table->text('RESIDENCE3')->nullable();
            $table->text('MAIL_ADDRESS')->nullable();
            $table->text('CV_DOCFILE')->nullable();
            $table->text('EXPECTED_FACILITIES')->nullable();
            $table->dateTime('AVAILABLE_DATE')->nullable();
            $table->string('REAPPLY', 10)->nullable();
            $table->dateTime('MARITAL_DATE')->nullable();
            $table->string('MARITAL_PLACE', 100)->nullable();
            $table->string('COMPLETETEST', 10)->nullable();
            $table->string('REPLACED_EMPID', 50)->nullable();
            $table->string('username', 50)->nullable();
            $table->string('Skill_Level', 50)->nullable();
            $table->text('CV_FILE')->nullable();
            $table->string('POH', 50)->nullable();
            $table->string('WORKLOCATION_CODE', 50)->nullable();
            $table->string('SSS_DEPENDENT', 50)->nullable();
            $table->string('HMO_DEPENDENT', 50)->nullable();
            $table->string('PHILHEALTH_DEPENDENT', 50)->nullable();
            $table->string('BIR_DEPENDENT', 50)->nullable();
            $table->string('BPJS', 50)->nullable();
            $table->string('Faskes', 100)->nullable();
            $table->string('BANK_CODE', 50)->nullable();
            $table->string('BANK_ACCOUNT', 50)->nullable();
            $table->string('ACCOUNT_NAME', 100)->nullable();
            $table->string('FAMILY_NAME', 100)->nullable();
            $table->string('CONFIRMBY', 50)->nullable();
            $table->dateTime('CONFIRMDATE')->nullable();
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

            $table->foreign('APPLICANT_ID')
                ->references('APPLICANT_ID')
                ->on('thrm_app_personal_data')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
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

            $table->foreign('APPLICANT_ID')
                ->references('APPLICANT_ID')
                ->on('thrm_app_personal_data')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
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

            $table->foreign('APPLICANT_ID')
                ->references('APPLICANT_ID')
                ->on('thrm_app_personal_data')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
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

            $table->foreign('APPLICANT_ID')
                ->references('APPLICANT_ID')
                ->on('thrm_app_personal_data')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
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
