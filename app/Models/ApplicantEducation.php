<?php

namespace App\Models;

use App\Models\Hris\ThrmEducation;
use App\Models\Hris\ThrmListFaculty;
use App\Models\Hris\ThrmListMajor;
use App\Models\Hris\ThrmListSchool;
use Database\Factories\ApplicantEducationFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable('applicant_id', 'edutype_id', 'school_id', 'faculty_id', 'major_id', 'institution_name', 'faculty', 'state', 'degree_level', 'major', 'gpa', 'entry_year', 'graduation_year')]
class ApplicantEducation extends Model
{
    /** @use HasFactory<ApplicantEducationFactory> */
    use HasFactory;

    public function applicant(): BelongsTo
    {
        return $this->belongsTo(Applicant::class);
    }

    public function educationType(): BelongsTo
    {
        return $this->belongsTo(ThrmEducation::class, 'edutype_id', 'EDUTYPE_ID');
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(ThrmListSchool::class, 'school_id', 'EDU_ID');
    }

    public function facultyMaster(): BelongsTo
    {
        return $this->belongsTo(ThrmListFaculty::class, 'faculty_id', 'FACULTY_ID');
    }

    public function majorMaster(): BelongsTo
    {
        return $this->belongsTo(ThrmListMajor::class, 'major_id', 'MAJOR_ID');
    }

    public function otherEntries(): HasMany
    {
        return $this->hasMany(ApplicantEducationOther::class, 'applicant_education_id');
    }
}
