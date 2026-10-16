<?php

namespace App\Models;

use Database\Factories\ApplicantWorkExprienceFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(
    'applicant_id',
    'company_name',
    'position',
    'division',
    'salary',
    'start_date',
    'end_date',
    'facility',
    'reason_for_leaving',
    'reference_name',
    'company_phone',
    'reference_position',
    'reference_phone',
)]
class ApplicantWorkExprience extends Model
{
    /** @use HasFactory<ApplicantWorkExprienceFactory> */
    use HasFactory;

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }
}
