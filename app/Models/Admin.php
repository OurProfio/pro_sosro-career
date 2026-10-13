<?php

namespace App\Models;

use Database\Factories\AdminFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// #[Fillable(['user_id', 'cabang_id', 'role'])]
#[Fillable(['user_id', 'office_id', 'name', 'role'])]
class Admin extends Model
{
    /** @use HasFactory<AdminFactory> */
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function jobs()
    {
        return $this->hasMany(Job::class, 'admin_id');
    }
}
