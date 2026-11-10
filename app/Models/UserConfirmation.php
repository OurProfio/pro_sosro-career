<?php

namespace App\Models;

use Database\Factories\UserConfirmationFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable('application_id', 'email', 'token', 'expires_at', 'decision', 'note', 'decided_at')]
class UserConfirmation extends Model
{
    /** @use HasFactory<UserConfirmationFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
            'decided_at' => 'datetime',
        ];
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    /**
     * Find a non-expired confirmation by its plain (unhashed) token.
     */
    public static function findActiveByToken(string $token): ?self
    {
        return static::where('token', hash('sha256', $token))
            ->where('expires_at', '>', now())
            ->first();
    }

    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    /**
     * Determine whether the application has moved on so the decision can no longer change.
     */
    public function isLocked(): bool
    {
        return $this->application->status !== 'progress'
            || ! $this->application->stage?->isUserConfirmation();
    }
}
