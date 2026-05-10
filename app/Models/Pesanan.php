<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan';
    protected $primaryKey = 'id_pesanan';

    protected $fillable = [
        'id_user',
        'total_harga',
        'status_pesanan',
        'tanggal_pesanan',
        // ... kolom lainnya
    ];

    protected $casts = [
        'tanggal_pesanan' => 'datetime',
    ];

    // ========== RELATIONSHIPS ==========
    
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    // ... relasi lainnya ...

    // =========================================================
    // TAMBAHKAN SCOPE-SCOPE BERIKUT INI
    // =========================================================

    /**
     * Scope: Hanya pesanan yang relevan untuk halaman pengiriman
     * (sudah dibayar, diproses, dikirim, atau selesai)
     */
    public function scopeForPengiriman($query)
    {
        return $query->whereIn('status_pesanan', ['dibayar', 'diproses', 'dikirim', 'selesai']);
    }

    /**
     * Scope: Cari berdasarkan ID pesanan atau nama/email pelanggan
     */
    public function scopeSearchPengiriman($query, $search)
    {
        if (!empty($search)) {
            return $query->where(function ($q) use ($search) {
                $q->where('id_pesanan', 'LIKE', "%{$search}%")
                  ->orWhereHas('user', function ($q2) use ($search) {
                      $q2->where('nama', 'LIKE', "%{$search}%")
                         ->orWhere('email', 'LIKE', "%{$search}%");
                  });
            });
        }
        return $query;
    }

    /**
     * Scope: Filter berdasarkan status pengiriman
     */
    public function scopeFilterStatusPengiriman($query, $status)
    {
        if (!empty($status)) {
            return $query->where('status_pesanan', $status);
        }
        return $query;
    }

    /**
     * Scope: Pesanan yang perlu dikirim (sudah dibayar/diproses)
     */
    public function scopePerluDikirim($query)
    {
        return $query->whereIn('status_pesanan', ['dibayar', 'diproses']);
    }

    /**
     * Scope: Pesanan yang sedang dalam perjalanan
     */
    public function scopeDalamPerjalanan($query)
    {
        return $query->where('status_pesanan', 'dikirim');
    }

    /**
     * Scope: Pesanan yang sudah selesai dikirim
     */
    public function scopeSelesaiPengiriman($query)
    {
        return $query->where('status_pesanan', 'selesai');
    }
}