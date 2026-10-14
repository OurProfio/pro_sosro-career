<?php

namespace App\Models\Hris;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThrmAppPersonalData extends Model
{
    use HasFactory;

    protected $table = 'thrm_app_personal_data';

    protected $primaryKey = 'APPLICANT_ID';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $guarded = [];
}
