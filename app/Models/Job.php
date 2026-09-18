<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable('office_id', 'admin_id', 'title', 'category', 'occupation', 'type', 'location', 'description', 'qualification', 'opening_date', 'closing_date', 'status')]
class Job extends Model
{
    /** @use HasFactory<\Database\Factories\JobFactory> */
    use HasFactory;
}
