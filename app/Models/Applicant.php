<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['user_id', 'is_profile_complete'])]
class Applicant extends Model
{
    /** @use HasFactory<\Database\Factories\ApplicantFactory> */
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function applicantProfile()
    {
        return $this->hasOne(ApplicantProfile::class);
    }
}
