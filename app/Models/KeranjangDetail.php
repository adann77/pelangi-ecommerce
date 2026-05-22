<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeranjangDetail extends Model
{
    protected $table = 'keranjang_detail';
    protected $primaryKey = 'id_keranjang_detail';

    public $timestamps = true;

    protected $fillable = [
        'id_keranjang',
        'id_produk',
        'id_varian',
        'kuantitas',
        'subtotal',
    ];

    /* ── Relasi ── */

    public function keranjang()
    {
        return $this->belongsTo(Keranjang::class, 'id_keranjang', 'id_keranjang');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }

    // public function varian()
    // {
    //     return $this->belongsTo(ProdukVarian::class, 'id_varian', 'id');
    // }
    public function varian()
{
    return $this->belongsTo(ProdukVarian::class, 'id_varian', 'id');
}

    /* ── Helper ── */

    /**
     * Hitung ulang subtotal berdasarkan harga aktif & kuantitas.
     * Dipanggil saat menampilkan keranjang agar harga selalu up-to-date.
     */
    public function hitungSubtotal(): void
    {
        $harga = $this->produk?->harga_aktif ?? $this->produk?->harga ?? 0;
        $this->subtotal = $harga * $this->kuantitas;
        $this->saveQuietly();          // save tanpa trigger events/timestamps update
    }
    
}