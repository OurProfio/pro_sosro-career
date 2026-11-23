<?php

namespace App\Models;

use Database\Factories\ContactMessageFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'user_id',
    'assigned_office_id',
    'name',
    'email',
    'region',
    'message',
    'status',
    'ip_address',
    'user_agent',
    'reply_message',
    'assigned_at',
    'resolved_at',
])]
class ContactMessage extends Model
{
    /** @use HasFactory<ContactMessageFactory> */
    use HasFactory;

    /**
     * Daftar wilayah tujuan pada formulir halaman Kontak.
     *
     * @var list<string>
     */
    public const REGIONS = [
        'Sumatera Utara',
        'Nangroe Aceh Darusalam',
        'Sumatera Barat',
        'Kepulauan Riau',
        'Sumatera Selatan',
        'Bangka Belitung',
        'Jakarta & Banten',
        'Jawa Barat',
        'Jawa Tengah',
        'Jawa Timur',
        'Bali & Nusra',
        'Kalimantan',
        'Sulawesi',
        'Maluku',
        'Papua',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'assigned_at' => 'datetime',
            'resolved_at' => 'datetime',
        ];
    }

    /**
     * Pengirim pesan apabila berada dalam keadaan login.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Kantor cabang yang ditugaskan menangani pesan ini.
     */
    public function assignedOffice(): BelongsTo
    {
        return $this->belongsTo(Office::class, 'assigned_office_id');
    }
}
