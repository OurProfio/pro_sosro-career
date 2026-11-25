<?php

namespace App\Models\Hris;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ThrmAppJobExp extends Model
{
    use HasFactory;

    protected $table = 'thrm_app_job_exp';

    protected $primaryKey = 'APPJOBEXP_ID';

    protected $guarded = [];

    /**
     * @return BelongsTo<ThrmAppPersonalData, $this>
     */
    public function personalData(): BelongsTo
    {
        return $this->belongsTo(ThrmAppPersonalData::class, 'APPLICANT_ID', 'APPLICANT_ID');
    }
}
