<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable('applicant_id', 'relationship', 'name', 'date_of_birth', 'place_of_birth', 'education', 'phone_number', 'work', 'family_type')]
class ApplicantFamily extends Model
{
    /** @use HasFactory<\Database\Factories\ApplicantFamilyFactory> */
    use HasFactory;

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }
}
