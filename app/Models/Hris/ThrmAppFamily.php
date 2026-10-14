<?php

namespace App\Models\Hris;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThrmAppFamily extends Model
{
    use HasFactory;

    protected $table = 'thrm_app_family';

    protected $primaryKey = 'APPFAMILY_ID';

    protected $guarded = [];
}
