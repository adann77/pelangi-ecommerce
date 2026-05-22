<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdukGambar extends Model
{
    protected $table = 'produk_gambar';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_produk',
        'path_gambar',
        'urutan',
    ];

    protected $appends = ['url'];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }

    public function getUrlAttribute()
    {
        if ($this->path_gambar) {
            return asset('storage/' . $this->path_gambar);
        }
        return null;
    }
}