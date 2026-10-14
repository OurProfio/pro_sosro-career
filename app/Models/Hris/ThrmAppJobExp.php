<?php

namespace App\Models\Hris;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThrmAppJobExp extends Model
{
    use HasFactory;

    protected $table = 'thrm_app_job_exp';

    protected $primaryKey = 'APPJOBEXP_ID';

    protected $guarded = [];
}
