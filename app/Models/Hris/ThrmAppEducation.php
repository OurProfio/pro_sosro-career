<?php

namespace App\Models\Hris;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ThrmAppEducation extends Model
{
    use HasFactory;

    protected $table = 'thrm_app_education';

    protected $primaryKey = 'APPEDUCATION_ID';

    protected $guarded = [];

    /**
     * @return BelongsTo<ThrmAppPersonalData, $this>
     */
    public function personalData(): BelongsTo
    {
        return $this->belongsTo(ThrmAppPersonalData::class, 'APPLICANT_ID', 'APPLICANT_ID');
    }
}
