<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable('nama', 'tipe')]
class Cabang extends Model
{
    /** @use HasFactory<\Database\Factories\CabangFactory> */
    use HasFactory;

    public function admin()
    {
        return $this->hasMany(Admin::class);
    }
}
