<?php

namespace App\Models;

use Database\Factories\PsikotesLinkFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable('job_id', 'link', 'application_id', 'assigned_at')]
class PsikotesLink extends Model
{
    /** @use HasFactory<PsikotesLinkFactory> */
    use HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'assigned_at' => 'datetime',
        ];
    }

    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class);
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    /**
     * @param  Builder<PsikotesLink>  $query
     */
    public function scopeAvailable(Builder $query): void
    {
        $query->whereNull('application_id');
    }
}
