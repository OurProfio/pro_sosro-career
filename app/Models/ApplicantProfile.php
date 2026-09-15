<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable('applicant_id','nik', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'tinggi_badan', 'berat_badan', 'alamat_ktp', 'alamat_domisili', 'no_telepon', 'agama', 'status_pernikahan', 'jenis_sim', 'instagram', 'linkedin', 'referensi_perusahaan', 'pernah_bekerja_internal', 'nama_perusahaan_lama', 'jabatan_terakhir', 'riwayat_penyakit', 'perokok', 'bertato', 'ekspektasi_gaji', 'ekspektasi_fasilitas', 'bersedia_dinas_luar', 'bersedia_penempatan_luar')]
class ApplicantProfile extends Model
{
    /** @use HasFactory<\Database\Factories\ApplicantProfileFactory> */
    use HasFactory;

    protected $primaryKey = 'id';

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }

    public function minatPekerjaan()
    {
        return $this->hasMany(MinatPekerjaan::class);
    }
}
