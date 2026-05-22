<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdukVarian extends Model
{
    protected $table = 'produk_varian';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_produk',
        'nama_varian',
        'stok_varian',
        'gambar_varian',
    ];

    protected $appends = ['gambar_varian_url'];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }

    public function getGambarVarianUrlAttribute()
    {
        if ($this->gambar_varian) {
            return asset('storage/' . $this->gambar_varian);
        }
        return null;
    }
}