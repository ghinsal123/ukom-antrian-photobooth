<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pengguna extends Authenticatable
{
    use Notifiable;

    protected $table = 'pengguna';

    // ✅ TAMBAHKAN 'email' di sini
    protected $fillable = [
        'nama_pengguna',
        'email',        // ← TAMBAHKAN INI
        'no_telp',
        'password',
        'role',     // admin / customer
        'foto',
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];
}