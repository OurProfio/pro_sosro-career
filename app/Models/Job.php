<?php

namespace App\Models;

use Database\Factories\JobFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable('office_id', 'admin_id', 'title', 'category', 'occupation', 'type', 'location', 'description', 'qualification', 'opening_date', 'closing_date', 'status')]
class Job extends Model
{
    /** @use HasFactory<JobFactory> */
    use HasFactory;

    public function office()
    {
        return $this->belongsTo(Office::class, 'office_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
