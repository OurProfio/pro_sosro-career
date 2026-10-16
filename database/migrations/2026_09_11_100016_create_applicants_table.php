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
        Schema::create('applicants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('nik')->unique();
            $table->text('address_ktp');
            $table->text('address_domisili');
            $table->enum('gender', ['l', 'p']);
            $table->string('place_of_birth');
            $table->date('date_of_birth');
            $table->unsignedSmallInteger('height');
            $table->unsignedSmallInteger('weight');
            $table->enum('blood_type', ['A', 'B', 'AB', 'O'])->nullable();
            $table->string('phone_number');
            $table->string('religion');
            $table->text('medical_history')->nullable();
            $table->enum('is_smoker', ['y', 'n']);
            $table->enum('has_tattoo', ['y', 'n']);
            $table->string('instagram')->nullable();
            $table->string('linkedin')->nullable();
            $table->json('driver_licenses')->nullable();
            $table->enum('marital_status', ['single', 'married', 'divorced', 'widowed']);
            $table->string('marital_date', 10)->nullable();
            $table->string('postal_code_ktp', 10)->nullable();
            $table->string('postal_code_domisili', 10)->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_relationship')->nullable();
            $table->string('emergency_contact_phone')->nullable();
            $table->string('photo_url');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicants');
    }
};
