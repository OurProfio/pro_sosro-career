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
        Schema::create('applicant_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('applicant_id')->constrained('applicants')->cascadeOnDelete();
            $table->string('nik')->unique();
            $table->enum('jenis_kelamin', ['l', 'p']);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('tinggi_badan');
            $table->string('berat_badan');
            $table->text('alamat_ktp');
            $table->text('alamat_domisili');
            $table->string('no_telepon');
            $table->string('agama');
            $table->enum('status_pernikahan', ['belum_menikah', 'sudah_menikah', 'cerai_hidup', 'cerai_mati']);
            $table->json('jenis_sim')->nullable();
            $table->string('instagram')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('referensi_perusahaan')->nullable();
            $table->boolean('pernah_bekerja_internal')->default(false);
            $table->string('nama_perusahaan_lama')->nullable();
            $table->string('jabatan_terakhir')->nullable();
            $table->text('riwayat_penyakit')->nullable();
            $table->boolean('perokok')->default(false);
            $table->boolean('bertato')->default(false);
            $table->string('ekspektasi_gaji');
            $table->text('ekspektasi_fasilitas')->nullable();
            $table->boolean('bersedia_dinas_luar')->default(true);
            $table->boolean('bersedia_penempatan_luar')->default(true);

            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicant_profiles');
    }
};
