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
            $table->enum('jenis_kelamin', ['l', 'p']);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->unsignedSmallInteger('tinggi_badan');
            $table->unsignedSmallInteger('berat_badan');
            $table->string('no_telepon');
            $table->string('agama');
            $table->enum('status_pernikahan', ['belum_menikah', 'sudah_menikah', 'cerai_hidup', 'cerai_mati']);
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
