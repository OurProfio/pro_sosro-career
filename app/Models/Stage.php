<?php

namespace App\Models;

use Database\Factories\StageFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable('name', 'type', 'step')]
class Stage extends Model
{
    /** @use HasFactory<StageFactory> */
    use HasFactory;

    /**
     * Determine whether the stage is an interview stage (e.g. "interview", "interview 1").
     */
    public function isInterview(): bool
    {
        return str_starts_with($this->name, 'interview');
    }

    /**
     * Determine whether the stage is the "konfirmasi user" stage.
     */
    public function isUserConfirmation(): bool
    {
        return strtolower(trim($this->name)) === 'konfirmasi user';
    }

    public function applications()
    {
        return $this->hasMany(Application::class, 'stages_id');
    }
}
