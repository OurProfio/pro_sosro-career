<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(
    'applicant_id',
    'salary_expectation',
    'facility_expectation',
    'ready_to_relocate',
    'ready_to_travel',
    'reference_by',
)]
class ApplicantExpectation extends Model
{
    /** @use HasFactory<\Database\Factories\ApplicantExpectationFactory> */
    use HasFactory;
}
