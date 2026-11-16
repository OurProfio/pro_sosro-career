<?php

namespace App\Models;

use Database\Factories\JobFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable('office_id', 'admin_id', 'title', 'category', 'occupation', 'type', 'location', 'description', 'qualification', 'opening_date', 'closing_date', 'status')]
class Job extends Model
{
    /** @use HasFactory<JobFactory> */
    use HasFactory, SoftDeletes;

    public const CITIES = [
        'Bandar Lampung',
        'Batam',
        'Bekasi',
        'Belitung',
        'Bengkulu',
        'Binjai',
        'Bukit Tinggi',
        'Cakung',
        'Cikarang',
        'Daan Mogot',
        'Jakarta Barat',
        'Jakarta Pusat',
        'Jakarta Utara',
        'Jambi',
        'Kelapa Gading',
        'Kisaran',
        'Lahat',
        'Medan',
        'Padang',
        'Padang Sidempuan',
        'Palembang',
        'Pangkal Pinang',
        'Parung Panjang',
        'Pekanbaru',
        'Pluit',
        'Rantau Prapat',
        'Sawangan',
        'Tangerang',
        'Tanjung Mulia',
        'Tanjung Pinang',
    ];

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

    public function psikotesLinks(): HasMany
    {
        return $this->hasMany(PsikotesLink::class);
    }

    public function psikotesStage(): ?Stage
    {
        return Stage::where('type', $this->category)->where('name', 'psikotes')->first();
    }

    public function isManageableBy(?Admin $admin): bool
    {
        if ($admin?->role === 'superadmin') {
            return true;
        }

        return ! ($admin?->office_id && $this->office_id !== $admin->office_id);
    }
}
