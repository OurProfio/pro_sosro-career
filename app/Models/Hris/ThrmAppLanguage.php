<?php

namespace App\Models\Hris;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThrmAppLanguage extends Model
{
    use HasFactory;

    protected $table = 'thrm_app_language';

    protected $primaryKey = 'APPLANGUAGE_ID';

    protected $guarded = [];
}
