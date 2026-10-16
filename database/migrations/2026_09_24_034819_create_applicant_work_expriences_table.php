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
        Schema::create('applicant_work_expriences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('applicant_id')->constrained()->onDelete('cascade');
            $table->string('company_name')->nullable();
            $table->string('company_phone')->nullable();
            $table->string('position')->nullable();
            $table->string('division')->nullable();
            $table->unsignedBigInteger('salary')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('facility')->nullable();
            $table->string('reason_for_leaving')->nullable();
            $table->string('reference_name')->nullable();
            $table->string('reference_position')->nullable();
            $table->string('reference_phone')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicant_work_expriences');
    }
};
