<?php

namespace App\Models\Hris;

use Illuminate\Database\Eloquent\Model;

class ThrmListFaculty extends Model
{
    protected $table = 'thrm_list_faculty';

    protected $primaryKey = 'FACULTY_ID';

    public $incrementing = false;

    protected $keyType = 'int';

    protected $guarded = [];
}
