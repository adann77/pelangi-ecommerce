<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';
    protected $primaryKey = 'id_produk';

    protected $fillable = [
        'id_kategori',
        'nama_produk',
        'deskripsi',
        'harga',
        'harga_reseller',
        'stok',
        'gambar_produk',
    ];

    // ✅ Tambahkan harga_aktif dan harga_regular_format ke appends
    protected $appends = ['gambar_url', 'harga_aktif', 'harga_format', 'harga_regular_format'];

    // ── Relasi ──

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    public function varians()
    {
        return $this->hasMany(ProdukVarian::class, 'id_produk', 'id_produk');
    }

    public function gambars()
    {
        return $this->hasMany(ProdukGambar::class, 'id_produk', 'id_produk');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'id_produk', 'id_produk');
    }

    // ── Accessor ──

    public function getGambarUrlAttribute()
    {
        if ($this->gambar_produk) {
            return asset('storage/' . $this->gambar_produk);
        }

        try {
            $firstVarian = $this->varians()
                ->whereNotNull('gambar_varian')
                ->where('gambar_varian', '!=', '')
                ->first();

            if ($firstVarian) {
                return asset('storage/' . $firstVarian->gambar_varian);
            }
        } catch (\Throwable $e) {}

        try {
            $firstGambar = $this->gambars()
                ->whereNotNull('path_gambar')
                ->where('path_gambar', '!=', '')
                ->orderBy('urutan')
                ->first();

            if ($firstGambar) {
                return asset('storage/' . $firstGambar->path_gambar);
            }
        } catch (\Throwable $e) {}

        return 'data:image/svg+xml,' . urlencode('<svg xmlns="http://www.w3.org/2000/svg" width="400" height="400" viewBox="0 0 400 400"><rect fill="#f3f4f6" width="400" height="400"/><text fill="#9ca3af" font-family="sans-serif" font-size="16" text-anchor="middle" x="200" y="195">Tidak Ada</text><text fill="#9ca3af" font-family="sans-serif" font-size="16" text-anchor="middle" x="200" y="220">Gambar</text></svg>');
    }

    /**
     * ✅ BARU: Harga aktif berdasarkan role user yang login.
     * Jika reseller & ada harga_reseller (> 0), pakai harga_reseller.
     * Selain itu, pakai harga biasa.
     */
    public function getHargaAktifAttribute()
    {
        if (auth()->check() && auth()->user()->role === 'reseller' && $this->harga_reseller && $this->harga_reseller > 0) {
            return $this->harga_reseller;
        }

        return $this->harga;
    }

    /**
     * ✅ FIX: Format harga sekarang menggunakan harga_aktif (bukan harga biasa)
     */
    public function getHargaFormatAttribute()
    {
        return 'Rp ' . number_format($this->harga_aktif, 0, ',', '.');
    }

    /**
     * ✅ BARU: Format harga regular (untuk coret di tampilan reseller)
     */
    public function getHargaRegularFormatAttribute()
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }
}