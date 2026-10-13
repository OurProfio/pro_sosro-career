<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable('applicant_id','status', 'job_id', 'stages_id', 'notes')]
class Application extends Model
{
    /** @use HasFactory<\Database\Factories\ApplicationFactory> */
    use HasFactory;

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function stage()
    {
        return $this->belongsTo(Stage::class, 'stages_id');
    }
}
