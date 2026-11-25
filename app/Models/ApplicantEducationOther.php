<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable('applicant_education_id', 'applicant_id', 'category', 'custom_name')]
class ApplicantEducationOther extends Model
{
    public const CATEGORY_SCHOOL = 'school';

    public const CATEGORY_FACULTY = 'faculty';

    public const CATEGORY_MAJOR = 'major';

    public function education(): BelongsTo
    {
        return $this->belongsTo(ApplicantEducation::class, 'applicant_education_id');
    }

    public function applicant(): BelongsTo
    {
        return $this->belongsTo(Applicant::class);
    }
}
