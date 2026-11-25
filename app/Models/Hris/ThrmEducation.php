<?php

namespace App\Models\Hris;

use Illuminate\Database\Eloquent\Model;

class ThrmEducation extends Model
{
    protected $table = 'thrm_education';

    protected $primaryKey = 'EDUTYPE_ID';

    public $incrementing = false;

    protected $keyType = 'int';

    protected $guarded = [];
}
