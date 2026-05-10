<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengiriman extends Model
{
    protected $table = 'pengiriman';

    protected $fillable = [
        'pesanan_id',
        'kurir',
        'layanan',
        'ongkir',
        'no_resi',
        'status',
    ];

    protected $casts = [
        'ongkir' => 'decimal:2',
    ];

    /* ───── Constants ───── */
    public const STATUS_PERLU_DIKIRIM    = 'perlu_dikirim';
    public const STATUS_DALAM_PERJALANAN = 'dalam_perjalanan';
    public const STATUS_SELESAI          = 'selesai';

    public static function statusList(): array
    {
        return [
            self::STATUS_PERLU_DIKIRIM    => 'Perlu Dikirim',
            self::STATUS_DALAM_PERJALANAN => 'Dalam Perjalanan',
            self::STATUS_SELESAI          => 'Selesai',
        ];
    }

    /* ───── Relasi ───── */
    public function pesanan(): BelongsTo
    {
        // FIX: specify foreign key & owner key karena Pesanan pakai id_pesanan
        return $this->belongsTo(Pesanan::class, 'pesanan_id', 'id_pesanan');
    }

    /* ───── Scopes ───── */
    public function scopePerluDikirim($query)
    {
        return $query->where('status', self::STATUS_PERLU_DIKIRIM);
    }

    public function scopeDalamPerjalanan($query)
    {
        return $query->where('status', self::STATUS_DALAM_PERJALANAN);
    }

    public function scopeSelesai($query)
    {
        return $query->where('status', self::STATUS_SELESAI);
    }

    public function scopeFilterStatus($query, ?string $status)
    {
        if ($status && in_array($status, array_keys(self::statusList()))) {
            $query->where('status', $status);
        }

        return $query;
    }

    public function scopeSearch($query, ?string $keyword)
    {
        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('no_resi', 'like', "%{$keyword}%")
                  ->orWhere('kurir', 'like', "%{$keyword}%")
                  ->orWhereHas('pesanan', function ($q2) use ($keyword) {
                      $q2->where('id_pesanan', 'like', "%{$keyword}%")
                         ->orWhereHas('user', function ($q3) use ($keyword) {
                             $q3->where('name', 'like', "%{$keyword}%");
                         });
                  });
            });
        }

        return $query;
    }

    /* ───── Accessor ───── */

    public function getStatusLabelAttribute(): string
    {
        return self::statusList()[$this->status] ?? $this->status;
    }

    public function getOngkirRupiahAttribute(): string
    {
        return 'Rp ' . number_format($this->ongkir, 0, ',', '.');
    }

    /**
     * Warna Tailwind berdasarkan nama kurir
     */
    public function getKurirColorAttribute(): string
    {
        return match ($this->kurir) {
            'JNE'      => 'red',
            'J&T'      => 'orange',
            'SiCepat'  => 'purple',
            'AnterAja'  => 'green',
            'Tiki'     => 'blue',
            default    => 'gray',
        };
    }

    /**
     * Badge CSS class berdasarkan status pengiriman
     */
    public function getPengirimanStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PERLU_DIKIRIM    => 'bg-amber-50 text-amber-700 border-amber-200',
            self::STATUS_DALAM_PERJALANAN => 'bg-blue-50 text-blue-700 border-blue-200',
            self::STATUS_SELESAI          => 'bg-emerald-50 text-emerald-700 border-emerald-200',
            default                       => 'bg-gray-50 text-gray-700 border-gray-200',
        };
    }

    /**
     * Dot CSS class berdasarkan status pengiriman
     */
    public function getPengirimanStatusDotAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PERLU_DIKIRIM    => 'bg-amber-500',
            self::STATUS_DALAM_PERJALANAN => 'bg-blue-500',
            self::STATUS_SELESAI          => 'bg-emerald-500',
            default                       => 'bg-gray-500',
        };
    }

    /**
     * Label status pengiriman
     */
    public function getPengirimanStatusLabelAttribute(): string
    {
        return self::statusList()[$this->status] ?? $this->status;
    }

    /**
     * Inisial nama untuk avatar (Budi Santoso → BS)
     */
    public function getInisialPelangganAttribute(): string
    {
        $name = $this->pesanan?->user?->name ?? '';
        $parts = explode(' ', trim($name));

        $initials = '';
        foreach ($parts as $i => $part) {
            if ($i >= 2) break;
            $initials .= strtoupper(substr($part, 0, 1));
        }

        return $initials ?: '?';
    }
}