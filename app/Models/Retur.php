<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Retur extends Model
{
    use HasFactory;

    protected $table = 'retur';
    protected $primaryKey = 'id_return';

    protected $fillable = [
        'id_pesanan',
        'id_produk',
        'id_user',
        'alasan_return',
        'bukti_return',
        'status_return',
        'catatan_admin',
        'tanggal_pengajuan',
    ];

    protected $casts = [
        'tanggal_pengajuan' => 'datetime',
    ];

    // ========== RELATIONSHIPS ==========

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan', 'id_pesanan');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }

    // ========== ACCESSORS ==========

    public function getKodeReturnAttribute()
    {
        return '#RT-' . str_pad($this->id_return, 3, '0', STR_PAD_LEFT);
    }

    public function getStatusLabelAttribute()
    {
        return match ($this->status_return) {
            'pending'  => 'Menunggu',
            'diproses' => 'Diproses',
            'selesai'  => 'Selesai',
            'ditolak'  => 'Ditolak',
            default    => 'Unknown',
        };
    }

    public function getStatusColorAttribute()
    {
        return match ($this->status_return) {
            'pending'  => 'amber',
            'diproses' => 'blue',
            'selesai'  => 'emerald',
            'ditolak'  => 'rose',
            default    => 'gray',
        };
    }

    public function getBuktiReturnUrlAttribute()
    {
        return $this->bukti_return ? asset('storage/' . $this->bukti_return) : null;
    }

    public function getInitialsAttribute()
    {
        $name = $this->user->nama ?? 'U';
        $parts = explode(' ', $name);
        $initials = strtoupper(substr($parts[0], 0, 1));
        if (count($parts) > 1) {
            $initials .= strtoupper(substr($parts[1], 0, 1));
        }
        return $initials;
    }

    public function getAvatarColorAttribute()
    {
        $palettes = ['blue', 'purple', 'emerald', 'amber', 'rose'];
        $index = ord(strtoupper($this->initials[0] ?? 'A')) % 5;
        return $palettes[$index];
    }
}