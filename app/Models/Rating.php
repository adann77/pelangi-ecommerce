<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $table = 'rating';
    protected $primaryKey = 'id_rating';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'id_user',
        'id_produk',
        'rating',
        'komentar',
        'status',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    // Relasi ke Produk
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }
}