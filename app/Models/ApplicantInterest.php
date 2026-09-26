<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['applicant_id', 'interests',])]
class ApplicantInterest extends Model
{
    /** @use HasFactory<\Database\Factories\ApplicantInterestFactory> */
    use HasFactory;

    protected $casts = [
        'interests' => 'array',
    ];
}
