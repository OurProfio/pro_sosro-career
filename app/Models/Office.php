<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable('name', 'type')]
class Office extends Model
{
    /** @use HasFactory<\Database\Factories\OfficeFactory> */
    use HasFactory;

    public function admin()
    {
        return $this->hasMany(Admin::class);
    }

    public function jobs()
    {
        return $this->hasMany(Job::class, 'office_id');
    }
}
