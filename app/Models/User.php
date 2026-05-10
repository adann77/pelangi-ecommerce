<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $primaryKey = 'id_user';

    protected $fillable = [
        'nama',
        'email',
        'password',
        'no_hp',
        'alamat',
        'role',
        'status',
        'status_reseller',
        'bukti_pembayaran',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
        
    }

     public function returs()
    {
     return $this->hasMany(Retur::class, 'id_user', 'id_user');
    }
    public function ratings()
    {
        return $this->hasMany(Rating::class, 'id_user', 'id_user');
    }

    
}