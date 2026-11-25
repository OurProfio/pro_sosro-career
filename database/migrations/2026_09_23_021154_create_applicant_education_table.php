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
        Schema::create('applicant_education', function (Blueprint $table) {
            $table->id();
            $table->foreignId('applicant_id')->constrained('applicants')->cascadeOnDelete();
            $table->integer('edutype_id')->nullable();
            $table->integer('school_id')->nullable();
            $table->integer('faculty_id')->nullable();
            $table->integer('major_id')->nullable();
            $table->string('institution_name');
            $table->string('faculty', 255)->nullable();
            $table->string('state');
            $table->string('degree_level');
            $table->string('major');
            $table->decimal('gpa', 4, 2);
            $table->year('entry_year');
            $table->year('graduation_year');
            $table->timestamps();

            $table->foreign('edutype_id')->references('EDUTYPE_ID')->on('thrm_education')->nullOnDelete();
            $table->foreign('school_id')->references('EDU_ID')->on('thrm_list_school')->nullOnDelete();
            $table->foreign('faculty_id')->references('FACULTY_ID')->on('thrm_list_faculty')->nullOnDelete();
            $table->foreign('major_id')->references('MAJOR_ID')->on('thrm_list_major')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicant_education');
    }
};
