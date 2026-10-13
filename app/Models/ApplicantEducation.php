<?php

namespace App\Models;

use Database\Factories\ApplicantEducationFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable('applicant_id', 'institution_name', 'degree_level', 'major', 'gpa', 'entry_year', 'graduation_year')]
class ApplicantEducation extends Model
{
    /** @use HasFactory<ApplicantEducationFactory> */
    use HasFactory;

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }
}
