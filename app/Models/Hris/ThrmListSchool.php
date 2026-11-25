<?php

namespace App\Models\Hris;

use Illuminate\Database\Eloquent\Model;

class ThrmListSchool extends Model
{
    protected $table = 'thrm_list_school';

    protected $primaryKey = 'EDU_ID';

    public $incrementing = false;

    protected $keyType = 'int';

    protected $guarded = [];
}
