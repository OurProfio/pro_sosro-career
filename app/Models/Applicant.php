<?php

namespace App\Models;

use Database\Factories\ApplicantFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

#[Fillable([
    'user_id',
    'name',
    'email',
    'nik',
    'address_ktp',
    'address_domisili',
    'gender',
    'place_of_birth',
    'date_of_birth',
    'height',
    'weight',
    'blood_type',
    'phone_number',
    'religion',
    'medical_history',
    'is_smoker',
    'has_tattoo',
    'instagram',
    'linkedin',
    'driver_licenses',
    'marital_status',
    'marital_date',
    'postal_code_ktp',
    'postal_code_domisili',
    'emergency_contact_name',
    'emergency_contact_relationship',
    'emergency_contact_phone',
    'has_applied_sosro',
    'previous_applied_position',
    'previous_applied_year',
    'photo_url',
])]
class Applicant extends Model
{
    /** @use HasFactory<ApplicantFactory> */
    use HasFactory;

    protected $casts = [
        'driver_licenses' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getReligionNameAttribute(): ?string
    {
        if (empty($this->religion)) {
            return null;
        }

        $row = DB::table('treligion')
            ->where('RELIGION_ID', $this->religion)
            ->first();

        return $row ? ($row->RELIGION_NAME_ID ?? $row->RELIGION_NAME_EN) : $this->religion;
    }

    public function workExperiences()
    {
        return $this->hasMany(ApplicantWorkExprience::class);
    }

    public function educations()
    {
        return $this->hasMany(ApplicantEducation::class);
    }

    public function families()
    {
        return $this->hasMany(ApplicantFamily::class);
    }

    public function trainings()
    {
        return $this->hasMany(ApplicantTraining::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function interest()
    {
        return $this->hasOne(ApplicantInterest::class);
    }

    public function expectation()
    {
        return $this->hasOne(ApplicantExpectation::class);
    }

    /**
     * Data untuk formulir biodata (HC-ODR.FRM.001.00) yang dicetak.
     *
     * @return array<string, mixed>
     */
    public function biodataPrintData(): array
    {
        $jobTitle = null;
        if (request()->filled('job_id')) {
            $jobTitle = Job::find(request('job_id'))?->title;
        }
        if (! $jobTitle) {
            $jobTitle = Application::with('job')->where('applicant_id', $this->id)->latest()->first()?->job?->title;
        }

        return [
            'applicant' => $this->load(['workExperiences', 'educations', 'families', 'trainings']),
            'expectation' => ApplicantExpectation::where('applicant_id', $this->id)->first(),
            'expectationInterests' => ApplicantInterest::where('applicant_id', $this->id)->value('interests'),
            'jobTitle' => $jobTitle,
            'divisions' => Division::all(),
        ];
    }
}
