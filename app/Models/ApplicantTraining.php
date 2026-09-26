<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable('applicant_id', 'training_name', 'organizer', 'finished')]
class ApplicantTraining extends Model
{
    /** @use HasFactory<\Database\Factories\ApplicantTrainingFactory> */
    use HasFactory;

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }
}
