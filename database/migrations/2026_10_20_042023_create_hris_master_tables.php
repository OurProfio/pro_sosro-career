<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('treligion', function (Blueprint $table) {
            $table->string('RELIGION_ID', 50)->primary();
            $table->string('RELIGION_NAME_EN', 100)->nullable();
            $table->string('RELIGION_NAME_ID', 100)->nullable();
            $table->string('RELIGION_NAME_CH', 100)->nullable();
            $table->string('RELIGION_NAME_DE', 100)->nullable();
            $table->integer('RELIGION_ENABLED')->nullable();
            $table->string('RELIGION_NAME_BWORD', 100)->nullable();
            $table->string('RELIGION_NAME_CCWORD', 100)->nullable();
            $table->string('RELIGION_NAME_DWORD', 100)->nullable();
            $table->string('RELIGION_NAME_EWORD', 100)->nullable();
            $table->string('RELIGION_NAME_FWORD', 100)->nullable();
            $table->string('RELIGION_NAME_GWORD', 100)->nullable();
            $table->string('RELIGION_NAME_HWORD', 100)->nullable();
            $table->string('RELIGION_NAME_SSWORD', 100)->nullable();
            $table->string('Religion_Name_ThailandWord', 100)->nullable();
            $table->string('RELIGION_NAME_TH', 100)->nullable();
            $table->string('RELIGION_NAME_MY', 100)->nullable();
            $table->string('RELIGION_NAME_VN', 100)->nullable();
            $table->timestamps();
        });

        Schema::create('thrm_education', function (Blueprint $table) {
            $table->integer('EDUTYPE_ID')->primary();
            $table->string('EDUTYPE_NAME_EN', 150)->nullable();
            $table->string('EDUTYPE_NAME_ID', 150)->nullable();
            $table->string('EDUTYPE_NAME_CH', 100)->nullable();
            $table->string('EDUTYPE_NAMETESTWORD', 100)->nullable();
            $table->integer('EDUTYPE_LEVEL')->nullable();
            $table->integer('STATUS')->nullable();
            $table->string('EDUTYPE_NAME_DE', 100)->nullable();
            $table->string('EDUTYPE_NAME_DWORD', 100)->nullable();
            $table->string('EDUTYPE_NAME_EWORD', 100)->nullable();
            $table->string('EDUTYPE_NAME_FWORD', 100)->nullable();
            $table->string('EDUTYPE_NAME_GWORD', 100)->nullable();
            $table->string('EDUTYPE_NAME_HWORD', 100)->nullable();
            $table->string('EDUTYPE_NAME_SSWORD', 100)->nullable();
            $table->string('EduType_Name_ThailandWord', 100)->nullable();
            $table->string('EDUTYPE_NAME_TH', 100)->nullable();
            $table->string('EDUTYPE_NAME_MY', 100)->nullable();
            $table->string('EDUTYPE_NAME_VN', 100)->nullable();
            $table->timestamps();
        });

        Schema::create('thrm_list_major', function (Blueprint $table) {
            $table->id('id');
            $table->integer('MAJOR_ID')->nullable()->index();
            $table->string('MAJOR_CODE', 50)->nullable()->index();
            $table->string('MAJOR_NAME', 255)->nullable();
            $table->string('MAJOR_NAME_EN', 150)->nullable();
            $table->string('MAJOR_NAME_ID', 150)->nullable();
            $table->string('MAJOR_NAME_TH', 150)->nullable();
            $table->string('MAJOR_NAME_MY', 150)->nullable();
            $table->string('MAJOR_NAME_VN', 150)->nullable();
            $table->timestamps();
        });

        Schema::create('thrm_list_school', function (Blueprint $table) {
            $table->integer('EDU_ID')->primary();
            $table->string('EDU_CODE', 50)->nullable()->index();
            $table->string('EDU_NAME', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thrm_list_school');
        Schema::dropIfExists('thrm_list_major');
        Schema::dropIfExists('thrm_education');
        Schema::dropIfExists('treligion');
    }
};
