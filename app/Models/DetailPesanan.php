<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    protected $table = 'detail_pesanan';
    protected $primaryKey = 'id_detail_pesanan';
    public $incrementing = true;
    protected $keyType = 'int';

    // protected $fillable = [
    //     'id_pesanan',
    //     'id_produk',
    //     'id_varian',
    //     'kuantitas',
    //     'harga',
    // ];
    protected $fillable = [
        'id_pesanan',
        'id_produk',
        'id_varian',      // ← tambah
        'harga_satuan',   // ← nama kolom yang benar di migrasi
        'kuantitas',
        'subtotal',       // ← tambah
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }

    public function varian()
    {
        return $this->belongsTo(Varian::class, 'id_varian', 'id_varian');
    }
}