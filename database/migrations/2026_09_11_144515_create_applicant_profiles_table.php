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
        // Schema::create('applicant_profiles', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('applicant_id')->constrained('applicants')->cascadeOnDelete();
        //     $table->json('jenis_sim')->nullable();
        //     $table->string('instagram')->nullable();
        //     $table->string('linkedin')->nullable();
        //     $table->string('referensi_perusahaan')->nullable();
        //     $table->boolean('pernah_bekerja_internal')->default(false);
        //     $table->string('nama_perusahaan_lama')->nullable();
        //     $table->string('jabatan_terakhir')->nullable();
        //     $table->text('riwayat_penyakit')->nullable();
        //     $table->boolean('perokok')->default(false);
        //     $table->boolean('bertato')->default(false);
        //     $table->string('ekspektasi_gaji');
        //     $table->text('ekspektasi_fasilitas')->nullable();
        //     $table->boolean('bersedia_dinas_luar')->default(true);
        //     $table->boolean('bersedia_penempatan_luar')->default(true);

        //     $table->timestamps();
        // });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('applicant_profiles');
    }
};
