<?php

namespace App\Models\Hris;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThrmAppCourse extends Model
{
    use HasFactory;

    protected $table = 'thrm_app_course';

    protected $primaryKey = 'APPCOURSE_ID';

    protected $guarded = [];
}
