<?php

namespace App\Models\Hris;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThrmAppSkill extends Model
{
    use HasFactory;

    protected $table = 'thrm_app_skill';

    protected $primaryKey = 'id';

    protected $guarded = [];
}
