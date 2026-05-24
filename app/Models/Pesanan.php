<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan';
    protected $primaryKey = 'id_pesanan';
    public $incrementing = true;
    protected $keyType = 'int';

    // protected $fillable = [
    //     'id_user',
    //     'total_harga',
    //     'status_pesanan',
    //     'tanggal_pesanan',
    // ];
    protected $fillable = [
        'id_user',
        'total_harga',
        'status_pesanan',
        'tanggal_pesanan',
        'alamat_pengiriman',
        'layanan_kurir',
        'kode_kurir',
        'ongkir',
        'nomor_resi',
    ];

    protected $casts = [
        'tanggal_pesanan' => 'datetime',
    ];

    // ========== RELATIONSHIPS ==========

    /**
     * Pesanan dimiliki oleh satu User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    /**
     * Pesanan punya banyak DetailPesanan
     */
    public function details()
    {
        return $this->hasMany(DetailPesanan::class, 'id_pesanan', 'id_pesanan');
    }

    /**
     * Pesanan punya satu Pembayaran
     */
    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'id_pesanan', 'id_pesanan');
    }

    /**
     * Pesanan punya satu Pengiriman
     */
    public function pengiriman()
    {
        return $this->hasOne(Pengiriman::class, 'pesanan_id', 'id_pesanan');
    }

    // ========== ACCESSOR ==========

    /**
     * Format total harga ke Rupiah
     */
    public function getTotalHargaFormatAttribute()
    {
        return 'Rp ' . number_format($this->total_harga, 0, ',', '.');
    }

    /**
     * Format Order ID
     */
    public function getOrderIdFormatAttribute()
    {
        return 'PLG-' . str_pad($this->id_pesanan, 4, '0', STR_PAD_LEFT);
    }

    // ========== SCOPES ==========

    public function scopeForPengiriman($query)
    {
        return $query->whereIn('status_pesanan', ['dibayar', 'diproses', 'dikirim', 'selesai']);
    }

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

    public function scopeFilterStatusPengiriman($query, $status)
    {
        if (!empty($status)) {
            return $query->where('status_pesanan', $status);
        }
        return $query;
    }

    public function scopePerluDikirim($query)
    {
        return $query->whereIn('status_pesanan', ['dibayar', 'diproses']);
    }

    public function scopeDalamPerjalanan($query)
    {
        return $query->where('status_pesanan', 'dikirim');
    }

    public function scopeSelesaiPengiriman($query)
    {
        return $query->where('status_pesanan', 'selesai');
    }
}