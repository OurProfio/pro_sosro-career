<?php

namespace App\Models\Hris;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThrmAppOrgAct extends Model
{
    use HasFactory;

    protected $table = 'thrm_app_org_act';

    protected $primaryKey = 'APPORGACT_ID';

    protected $guarded = [];
}
