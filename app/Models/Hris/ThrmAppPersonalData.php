<?php

namespace App\Models\Hris;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ThrmAppPersonalData extends Model
{
    use HasFactory;

    protected $table = 'thrm_app_personal_data';

    protected $primaryKey = 'APPLICANT_ID';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $guarded = [];

    /**
     * @return HasMany<ThrmAppFamily, $this>
     */
    public function families(): HasMany
    {
        return $this->hasMany(ThrmAppFamily::class, 'APPLICANT_ID', 'APPLICANT_ID');
    }

    /**
     * @return HasMany<ThrmAppEducation, $this>
     */
    public function educations(): HasMany
    {
        return $this->hasMany(ThrmAppEducation::class, 'APPLICANT_ID', 'APPLICANT_ID');
    }

    /**
     * @return HasMany<ThrmAppJobExp, $this>
     */
    public function jobExperiences(): HasMany
    {
        return $this->hasMany(ThrmAppJobExp::class, 'APPLICANT_ID', 'APPLICANT_ID');
    }

    /**
     * @return HasMany<ThrmAppHistory, $this>
     */
    public function histories(): HasMany
    {
        return $this->hasMany(ThrmAppHistory::class, 'APPLICANT_ID', 'APPLICANT_ID');
    }
}
