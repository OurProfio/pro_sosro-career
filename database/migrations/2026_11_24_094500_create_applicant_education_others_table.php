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
        Schema::create('applicant_education_others', function (Blueprint $table) {
            $table->id();
            $table->foreignId('applicant_education_id')->constrained('applicant_education')->cascadeOnDelete();
            $table->foreignId('applicant_id')->constrained('applicants')->cascadeOnDelete();
            $table->string('category', 20)->index();
            $table->string('custom_name', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicant_education_others');
    }
};
