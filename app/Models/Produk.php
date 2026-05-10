<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produk extends Model
{
    use HasFactory;

    protected $table      = 'produk';
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

    protected $casts = [
        'harga'          => 'decimal:2',
        'harga_reseller' => 'decimal:2',
        'stok'           => 'integer',
    ];

    /* ------------------------------------------------------------------ */
    /*  Relasi                                                              */
    /* ------------------------------------------------------------------ */

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    /* ------------------------------------------------------------------ */
    /*  Accessor Helper                                                     */
    /* ------------------------------------------------------------------ */

    public function getHargaFormatAttribute(): string
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }

    public function getHargaResellerFormatAttribute(): string
    {
        return $this->harga_reseller
            ? 'Rp ' . number_format($this->harga_reseller, 0, ',', '.')
            : '—';
    }

    public function getGambarUrlAttribute(): string
    {
        return $this->gambar_produk
            ? asset('storage/' . $this->gambar_produk)
            : asset('images/placeholder-produk.png');
    }


    public function returs()
    {
        return $this->hasMany(Retur::class, 'id_produk', 'id_produk');
    }
    
    public function ratings()
    {
        return $this->hasMany(Rating::class, 'id_produk', 'id_produk');
    }
}