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
            $table->string('phone_number');
            $table->string('work');
            $table->enum('relationship', ['father', 'mother', 'sibling', 'spouse', 'child']);
            $table->enum('gender', ['l', 'p'])->nullable();
            $table->enum('family_type', ['biological', 'nuclear']);
            $table->enum('status', ['alive', 'deceased', 'divorced'])->default('alive');
            $table->timestamps();
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
