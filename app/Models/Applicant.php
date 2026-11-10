<?php

namespace App\Models;

use Database\Factories\ApplicantFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
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
    'is_completed',
])]
class Applicant extends Model
{
    /** @use HasFactory<ApplicantFactory> */
    use HasFactory;

    protected $casts = [
        'driver_licenses' => 'array',
        'is_completed' => 'boolean',
    ];

    /**
     * Menentukan route langkah create pertama yang belum dipenuhi.
     */
    public function incompleteStepRoute(): ?string
    {
        if ($this->families()->doesntExist()) {
            return route('biodata.family.create');
        }

        if ($this->educations()->doesntExist()) {
            return route('biodata.education.create');
        }

        if (! $this->is_completed) {
            if ($this->workExperiences()->exists()) {
                $this->updateQuietly(['is_completed' => true]);

                return null;
            }

            return route('biodata.workExperience.create');
        }

        return null;
    }

    /**
     * Memeriksa apakah seluruh tahapan biodata telah lengkap.
     */
    public function isProfileComplete(): bool
    {
        return $this->incompleteStepRoute() === null;
    }

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
     * Data untuk partial detail profil kandidat (admin dan halaman detail konfirmasi user).
     *
     * Tanpa $application, lamaran yang ditampilkan adalah lamaran terbaru pelamar.
     *
     * @return array{applicant: self, interestNames: Collection<int, string>, latestApplication: ?Application, stages: Collection<int, Stage>}
     */
    public function profileViewData(?Application $application = null): array
    {
        $this->load([
            'workExperiences',
            'educations',
            'families',
            'trainings',
            'expectation',
            'interest',
            'applications.job.office',
            'applications.stage',
        ]);

        $interestIds = collect($this->interest?->interests ?? [])
            ->filter(fn ($interest) => is_scalar($interest) && is_numeric($interest))
            ->map(fn ($interest) => (int) $interest)
            ->values();

        $latestApplication = $application?->loadMissing(['job.office', 'stage'])
            ?? $this->applications->sortByDesc('created_at')->first();

        return [
            'applicant' => $this,
            'interestNames' => Division::query()->whereIn('id', $interestIds)->pluck('name', 'id'),
            'latestApplication' => $latestApplication,
            'stages' => $latestApplication?->job?->category
                ? Stage::where('type', $latestApplication->job->category)->orderBy('step')->get()
                : collect(),
        ];
    }

    /**
     * Data untuk formulir biodata (HC-ODR.FRM.001.00) yang dicetak.
     *
     * Dengan $job, posisi yang dicetak diambil dari lowongan tersebut.
     *
     * @return array<string, mixed>
     */
    public function biodataPrintData(?Job $job = null): array
    {
        $jobTitle = $job?->title;
        if (! $jobTitle && request()->filled('job_id')) {
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
