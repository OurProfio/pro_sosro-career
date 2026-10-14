<?php

namespace App\Models\Hris;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThrmAppHistory extends Model
{
    use HasFactory;

    protected $table = 'thrm_app_history';

    protected $primaryKey = 'APPHISTORY_ID';

    protected $guarded = [];
}
