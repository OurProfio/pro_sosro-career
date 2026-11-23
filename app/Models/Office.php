<?php

namespace App\Models;

use Database\Factories\OfficeFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

#[Fillable('name', 'type')]
class Office extends Model
{
    /** @use HasFactory<OfficeFactory> */
    use HasFactory;

    /**
     * Label tampilan berdasarkan tipe kantor dengan urutan prioritas.
     *
     * @var array<string, string>
     */
    public const TYPE_LABELS = [
        'HO' => 'Kantor Pusat (HO)',
        'KPW' => 'Kantor Perwakilan Wilayah (KPW)',
        'KP' => 'Kantor Penjualan (KP)',
        'KPP' => 'Kantor Penjualan Pembantu (KPP)',
        'Pabrik' => 'Pabrik / Unit Produksi',
        'Lainnya' => 'Lainnya',
    ];

    public function admin(): HasMany
    {
        return $this->hasMany(Admin::class);
    }

    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class, 'office_id');
    }

    public function assignedContactMessages(): HasMany
    {
        return $this->hasMany(ContactMessage::class, 'assigned_office_id');
    }

    /**
     * Filter kantor yang memiliki minimal satu admin aktif.
     */
    public function scopeWithActiveAdmins(Builder $query): Builder
    {
        return $query->whereHas('admin', fn (Builder $adminQuery): Builder => $adminQuery->where('is_active', true));
    }

    /**
     * Filter kantor cabang (non-HO) yang memiliki minimal satu admin cabang aktif terdaftar.
     */
    public function scopeWithActiveBranchAdmins(Builder $query): Builder
    {
        return $query
            ->where('type', '!=', 'HO')
            ->whereHas('admin', fn (Builder $adminQuery): Builder => $adminQuery
                ->where('role', 'admin')
                ->where('is_active', true));
    }

    /**
     * Mengelompokkan kantor cabang (non-HO) beradmin aktif berdasarkan tipe kantor.
     *
     * @return Collection<string, Collection<int, Office>>
     */
    public static function groupedWithActiveBranchAdmins(): Collection
    {
        $offices = static::query()
            ->withActiveBranchAdmins()
            ->with(['admin' => fn ($query) => $query
                ->where('role', 'admin')
                ->where('is_active', true)
                ->orderBy('name')])
            ->orderBy('name')
            ->get();

        $typePriority = array_flip(array_keys(self::TYPE_LABELS));

        return $offices
            ->groupBy('type')
            ->sortBy(fn (Collection $items, string $type): int => $typePriority[$type] ?? 999)
            ->mapWithKeys(fn (Collection $items, string $type): array => [
                self::TYPE_LABELS[$type] ?? $type => $items->values(),
            ]);
    }
}
