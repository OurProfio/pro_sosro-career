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
        Schema::create('thrm_family_connection', function (Blueprint $table) {
            $table->integer('RELATIONSHIP_ID')->primary();
            $table->string('RELATIONSHIP_CODE', 50)->nullable()->index();
            $table->string('FAMILY_RELATIONSHIP_EN', 100)->nullable();
            $table->string('FAMILY_RELATIONSHIP_ID', 100)->nullable();
            $table->string('FAMILY_RELATIONSHIP_CH', 100)->nullable();
            $table->string('FAMILY_RELATIONSHIPTESTWORD', 100)->nullable();
            $table->string('FAMILY_RELATIONSHIP_DE', 100)->nullable();
            $table->string('ISREQUIRED', 10)->nullable();
            $table->integer('AGE')->nullable();
            $table->string('FAMILY_RELATIONSHIP_DWORD', 100)->nullable();
            $table->string('FAMILY_RELATIONSHIP_EWORD', 100)->nullable();
            $table->string('FAMILY_RELATIONSHIP_FWORD', 100)->nullable();
            $table->string('FAMILY_RELATIONSHIP_GWORD', 100)->nullable();
            $table->string('FAMILY_RELATIONSHIP_HWORD', 100)->nullable();
            $table->string('FAMILY_RELATIONSHIP_SSWORD', 100)->nullable();
            $table->string('FAMILY_RELATIONSHIP_TH', 100)->nullable();
            $table->string('FAMILY_RELATIONSHIP_MY', 100)->nullable();
            $table->string('FAMILY_RELATIONSHIP_VN', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thrm_family_connection');
    }
};
