<?php

namespace App\Models;

use Database\Factories\ApplicationFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable('applicant_id', 'status', 'job_id', 'stages_id', 'notes')]
class Application extends Model
{
    /** @use HasFactory<ApplicationFactory> */
    use HasFactory;

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function userConfirmation(): HasOne
    {
        return $this->hasOne(UserConfirmation::class);
    }

    public function stage()
    {
        return $this->belongsTo(Stage::class, 'stages_id');
    }

    public function psikotesLink(): HasOne
    {
        return $this->hasOne(PsikotesLink::class);
    }
}
