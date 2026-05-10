<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kategori extends Model
{
    use HasFactory;

    protected $table      = 'kategori';
    protected $primaryKey = 'id_kategori';

    protected $fillable = [
        'nama_kategori',
        'gambar_kategori',
    ];

    /* ------------------------------------------------------------------ */
    /*  Relasi                                                              */
    /* ------------------------------------------------------------------ */

    public function produks()
    {
        return $this->hasMany(Produk::class, 'id_kategori', 'id_kategori');
    }

    /* ------------------------------------------------------------------ */
    /*  Accessor Helper                                                     */
    /* ------------------------------------------------------------------ */

    public function getGambarUrlAttribute(): string
    {
        return $this->gambar_kategori
            ? asset('storage/' . $this->gambar_kategori)
            : asset('images/placeholder-kategori.png');
    }
}