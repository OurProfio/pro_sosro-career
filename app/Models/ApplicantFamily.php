<?php

namespace App\Models;

use Database\Factories\ApplicantFamilyFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable('applicant_id', 'relationship', 'gender', 'name', 'date_of_birth', 'place_of_birth', 'education', 'phone_number', 'work', 'family_type', 'status')]
class ApplicantFamily extends Model
{
    /** @use HasFactory<ApplicantFamilyFactory> */
    use HasFactory;

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }
}
