<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';
    protected $primaryKey = 'id_pembayaran';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_pesanan',
        'metode_pembayaran',
        'status_pembayaran',
        'tanggal_pembayaran',
        'bukti_pembayaran',
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan', 'id_pesanan');
    }
}