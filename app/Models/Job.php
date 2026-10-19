<?php

namespace App\Models;

use Database\Factories\JobFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable('office_id', 'admin_id', 'title', 'category', 'occupation', 'type', 'location', 'description', 'qualification', 'opening_date', 'closing_date', 'status', 'approval_status', 'approved_by', 'approved_at', 'rejection_reason')]
class Job extends Model
{
    /** @use HasFactory<JobFactory> */
    use HasFactory, SoftDeletes;

    protected function casts(): array
    {
        return ['approved_at' => 'datetime'];
    }

    public function office()
    {
        return $this->belongsTo(Office::class, 'office_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function approver()
    {
        return $this->belongsTo(Admin::class, 'approved_by');
    }

    /**
     * @param  Builder<Job>  $query
     * @return Builder<Job>
     */
    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('approval_status', 'approved');
    }

    public function isApproved(): bool
    {
        return $this->approval_status === 'approved';
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
