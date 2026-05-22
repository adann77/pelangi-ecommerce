<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;

    protected $table = 'keranjang';
    protected $primaryKey = 'id_keranjang';

    public $timestamps = true;

    protected $fillable = [
        'id_user',
    ];

    /* ── Relasi ── */

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function details()
    {
        return $this->hasMany(KeranjangDetail::class, 'id_keranjang', 'id_keranjang');
    }

    /* ── Accessor ── */

    public function getTotalItemsAttribute(): int
    {
        return $this->details->sum('kuantitas');
    }

    public function getTotalHargaAttribute(): float
    {
        return $this->details->sum('subtotal');
    }
}