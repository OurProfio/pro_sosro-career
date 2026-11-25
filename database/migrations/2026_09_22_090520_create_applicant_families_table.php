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
        Schema::create('applicant_families', function (Blueprint $table) {
            $table->id();
            $table->foreignId('applicant_id')->constrained('applicants')->cascadeOnDelete();
            $table->string('name');
            $table->string('place_of_birth');
            $table->date('date_of_birth');
            $table->string('education');
            $table->integer('edutype_id')->nullable();
            $table->string('phone_number');
            $table->string('work');
            $table->text('address')->nullable();
            $table->enum('relationship', ['father', 'mother', 'sibling', 'spouse', 'child', 'father_in_law', 'mother_in_law']);
            $table->integer('relationship_id')->nullable();
            $table->enum('gender', ['l', 'p'])->nullable();
            $table->enum('family_type', ['biological', 'nuclear']);
            $table->enum('status', ['alive', 'deceased', 'divorced'])->default('alive');
            $table->timestamps();

            $table->foreign('edutype_id')->references('EDUTYPE_ID')->on('thrm_education')->nullOnDelete();
            $table->foreign('relationship_id')->references('RELATIONSHIP_ID')->on('thrm_family_connection')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicant_families');
    }
};
