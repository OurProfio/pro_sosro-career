<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    'phone_number',
    'religion',
    'medical_history',
    'is_smoker',
    'has_tattoo',
    'instagram',
    'linkedin',
    'driver_licenses',
    'marital_status',
    'photo_url',
])]
class Applicant extends Model
{
    /** @use HasFactory<\Database\Factories\ApplicantFactory> */
    use HasFactory;

    protected $casts = [
        'driver_licenses' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
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
}
