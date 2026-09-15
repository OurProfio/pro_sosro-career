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
        Schema::create('minat_pekerjaans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('applicant_profile_id')->constrained('applicant_profiles')->cascadeOnDelete();
            $table->foreignId('divisi_id')->constrained('divisis')->cascadeOnDelete();
            $table->integer('urutan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('minat_pekerjaans');
    }
};
