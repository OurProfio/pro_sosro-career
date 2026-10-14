<?php

namespace App\Models\Hris;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThrmAppEducation extends Model
{
    use HasFactory;

    protected $table = 'thrm_app_education';

    protected $primaryKey = 'APPEDUCATION_ID';

    protected $guarded = [];
}
