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
        Schema::create('thrm_list_faculty', function (Blueprint $table) {
            $table->integer('FACULTY_ID')->primary();
            $table->string('FACULTY_CODE', 50)->nullable()->index();
            $table->string('FACULTY_NAME', 255)->nullable();
            $table->string('FACULTY_NAME_EN', 150)->nullable();
            $table->string('FACULTY_NAME_ID', 150)->nullable();
            $table->string('FACULTY_NAME_TH', 150)->nullable();
            $table->string('FACULTY_NAME_MY', 150)->nullable();
            $table->string('FACULTY_NAME_VN', 150)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thrm_list_faculty');
    }
};
