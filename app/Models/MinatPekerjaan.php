<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable('applicant_profile_id', 'divisi_id', 'urutan')]
class MinatPekerjaan extends Model
{
    /** @use HasFactory<\Database\Factories\MinatPekerjaanFactory> */
    use HasFactory;

    public function applicantProfile()
    {
        return $this->belongsTo(ApplicantProfile::class);
    }
}
